<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class EmployeeLogController extends Controller
{
    public function index(): View
    {
        $employees = DB::table('teacher')
            ->select('teaserial', DB::raw('CONCAT(lastname, " ", firstname, " ", middlename) AS fullname'))
            ->where('isdelete', '=', 0)
            ->orderBy('lastname', 'asc')
            ->get();

        return view('pages/employee-log', [
            'layout' => 'top-menu',
            'employees' => $employees,
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

        $employee = $request->employee;

        $employees = DB::table('teacher')
            ->select('teaserial', DB::raw('CONCAT(lastname, " ", firstname, " ", middlename) AS fullname'))
            ->where('isdelete', '=', 0)
            ->orderBy('lastname', 'asc')
            ->get();

        if ($employee == null) {
            return view('pages/employee-log', [
                'layout' => 'top-menu',
                'employees' => $employees,
            ]);
        }

        $result = DB::select('CALL spRptTeacherLog(?,?,?)', [$employee, $dateFromFormatted, $dateToFormatted]);
        $selectedEmployee = DB::table('teacher')
            ->select('teaserial', DB::raw('CONCAT(lastname, " ", firstname, " ", middlename) AS fullname'))
            ->where('teaserial', '=', $employee)
            ->get();

        // Initialize arrays to store categorized data
        $entranceData = [];
        $exitData = [];

        // Iterate through the items and categorize by LOGTYPE
        foreach ($result as $item) {
            // Convert LOGDATE to the desired format
            $item->LOGDATE = date('F j, Y', strtotime($item->LOGDATE));

            if ($item->LOGTYPE === 'ENTRANCE') {
                $entranceData[] = $item;
            } elseif ($item->LOGTYPE === 'EXIT') {
                $exitData[] = $item;
            }
        }

        usort($entranceData, function ($a, $b) {
            return strtotime($a->LOGDATE) - strtotime($b->LOGDATE);
        });

        usort($exitData, function ($a, $b) {
            return strtotime($a->LOGDATE) - strtotime($b->LOGDATE);
        });

        return view('pages/employee-log', [
            'layout' => 'top-menu',
            'entranceData' => $entranceData,
            'exitData' => $exitData,
            'selectedEmployee' => $selectedEmployee,
            'employees' => $employees,
        ]);
    }
}
