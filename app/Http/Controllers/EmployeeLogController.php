<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class EmployeeLogController extends Controller
{
    public function index(): View
    {
        return view('pages/employee-log', [
            'layout' => 'top-menu',
        ]);
    }

    public function populate(Request $request)
    {
        $results = DB::table('attendancelog as t1')
            ->join('teacher as t2', 't1.lrnno', '=', 't2.idno')
            ->join('department as t3', 't2.deptserial', '=', 't3.deptserial')
            ->where('t1.logdate', '>=', DB::raw("STR_TO_DATE('$request->startDate', '%Y-%m-%d')"))
            ->where('t1.logdate', '<=', DB::raw("STR_TO_DATE('$request->endDate', '%Y-%m-%d')"))
            ->where('t2.isdelete', '=', 0)
            ->where('t1.entrytype', '=', 'EMPLOYEE')
            ->orderBy('t2.lastname', 'asc')
            ->orderBy('t1.logdate', 'asc')
            ->select(
                DB::raw("CONCAT(t2.lastname, ', ', t2.firstname, ' ', t2.middlename, ' ', t2.extension) as fullname"),
                't1.lrnno as lrn',
                't3.deptname as department',
                't1.logdate',
                't1.logtime',
                't1.logtype'
            )
            ->get();

        return response()->json($results);
    }
}
