<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class EmployeesLogController extends Controller
{
    public function index(): View
    {
        return view('pages/employees-log', [
            'layout' => 'top-menu',
        ]);
    }

    public function details(Request $request): View
    {
        // Format Date
        list($startDateStr, $endDateStr) = explode(' - ', $request->daterange);
        $dateFrom = Carbon::createFromFormat('d M, Y', trim($startDateStr));
        $dateTo = Carbon::createFromFormat('d M, Y', trim($endDateStr));
        $dateFromFormatted = $dateFrom->format('Y-m-d');
        $dateToFormatted = $dateTo->format('Y-m-d');

        $result = DB::table('attendancelog')
            ->select('attendancelog.lrnno', 'attendancelog.logdate', 'attendancelog.logtime', 'attendancelog.logtype',
                DB::raw('CONCAT(teacher.lastname, " ", teacher.firstname, " ", teacher.middlename) AS fullname'))
            ->join('teacher', 'attendancelog.lrnno', '=', 'teacher.idno')
            ->where('attendancelog.logdate', '>=', $dateFromFormatted)
            ->where('attendancelog.logdate', '<=', $dateToFormatted)
            ->where('teacher.isdelete', '=', 0)
            ->where('attendancelog.entrytype', '=', 'EMPLOYEE')
            ->orderBy('attendancelog.logdate', 'asc')
            ->orderBy('attendancelog.logtime', 'asc')
            ->paginate(200);

        $entranceData = [];
        $exitData = [];

        // Iterate through the items and categorize by LOGTYPE
        foreach ($result as $item) {
            // Convert LOGDATE to the desired format
            $item->logdate = date('F j, Y', strtotime($item->logdate));

            if ($item->logtype === 'ENTRANCE') {
                $entranceData[] = $item;
            } elseif ($item->logtype === 'EXIT') {
                $exitData[] = $item;
            }
        }

        usort($entranceData, function ($a, $b) {
            return strcmp($a->{'fullname'}, $b->{'fullname'});
        });

        usort($exitData, function ($a, $b) {
            return strcmp($a->{'fullname'}, $b->{'fullname'});
        });

        return view('pages/employees-log', [
            'layout' => 'top-menu',
            'entranceData' => $entranceData,
            'exitData' => $exitData,
        ]);
    }
}
