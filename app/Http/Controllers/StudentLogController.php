<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class StudentLogController extends Controller
{
    public function index(): View
    {
        return view('pages/student-log', [
            'layout' => 'top-menu',
        ]);
    }

    public function populate(Request $request)
    {
        $data = DB::select('CALL spStudentLog(?,?)', [$request->key1, $request->key2]);

        return response()->json($data);
    }

    public function details(Request $request): View
    {
        // Format Date
        list($startDateStr, $endDateStr) = explode(' - ', $request->daterange);
        $dateFrom = Carbon::createFromFormat('d M, Y', trim($startDateStr));
        $dateTo = Carbon::createFromFormat('d M, Y', trim($endDateStr));
        $dateFromFormatted = $dateFrom->format('Y-m-d');
        $dateToFormatted = $dateTo->format('Y-m-d');

        $student = $request->student;

        $students = DB::table('profiles')
            ->select('lrnno', DB::raw('CONCAT(lastname, " ", firstname, " ", middlename) AS fullname'))
            ->where('isdelete', '=', 0)
            ->orderBy('lastname', 'asc')
            ->get();

        if ($student == null) {
            return view('pages/student-log', [
                'layout' => 'top-menu',
                'students' => $students,
            ]);
        }

        $result = DB::select('CALL spStudentLog(?,?)', [$dateFromFormatted, $dateToFormatted]);
        $selectedStudent = DB::table('profiles')
            ->select('lrnno', DB::raw('CONCAT(lastname, " ", firstname, " ", middlename) AS fullname'))
            ->where('lrnno', '=', $student)
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

        return view('pages/student-log', [
            'layout' => 'top-menu',
            'entranceData' => $entranceData,
            'exitData' => $exitData,
            'selectedStudent' => $selectedStudent,
            'students' => $students,
        ]);
    }
}
