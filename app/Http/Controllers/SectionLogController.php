<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SectionLogController extends Controller
{
    public function index(): View
    {
        return view('pages/section-log', [
            'layout' => 'top-menu',
        ]);
    }

    public function populate()
    {
        $section = Auth::user()->section_id;

        $results = DB::table('enrollment as t1')
            ->join('profiles as t2', 't1.studserial', '=', 't2.studserial')
            ->join('attendancelog as t3', 't2.lrnno', '=', 't3.lrnno')
            ->join('gradelevel as t4', 't1.gradeserial', '=', 't4.graserial')
            ->join('section as t5', 't1.secserial', '=', 't5.secserial')
            ->join('department as t6', 't1.deptserial', '=', 't6.deptserial')
            ->join('semester as t7', 't1.semserial', '=', 't7.semserial')
            ->join('track as t8', 't1.traserial', '=', 't8.traserial')
            ->join('strand as t9', 't1.strserial', '=', 't9.strserial')
            ->select(
                DB::raw("CONCAT(t2.lastname, ', ', t2.firstname, ' ', t2.middlename, ' ', t2.extension) as fullname"),
                't3.lrnno as lrn',
                't4.graname as grade',
                't5.secname as section',
                't3.logdate',
                't3.logtime',
                't3.logtype'
            )
            ->whereDate('t3.logdate', '=', now()->format('YYYY-MM-DD')) // Filter by the current date
            ->where('t5.secserial', '=', $section)
            ->where('t1.isdelete', '=', 0)
            ->where('t3.entrytype', '=', 'STUDENT')
            ->orderBy('t2.lastname', 'asc')
            ->orderBy('t3.logdate', 'asc')
            ->get();

        return response()->json($results);
    }

    public function populateBySelectedDate(Request $request)
    {
        $section = Auth::user()->section_id;

        $results = DB::table('enrollment as t1')
            ->join('profiles as t2', 't1.studserial', '=', 't2.studserial')
            ->join('attendancelog as t3', 't2.lrnno', '=', 't3.lrnno')
            ->join('gradelevel as t4', 't1.gradeserial', '=', 't4.graserial')
            ->join('section as t5', 't1.secserial', '=', 't5.secserial')
            ->join('department as t6', 't1.deptserial', '=', 't6.deptserial')
            ->join('semester as t7', 't1.semserial', '=', 't7.semserial')
            ->join('track as t8', 't1.traserial', '=', 't8.traserial')
            ->join('strand as t9', 't1.strserial', '=', 't9.strserial')
            ->select(
                DB::raw("CONCAT(t2.lastname, ', ', t2.firstname, ' ', t2.middlename, ' ', t2.extension) as fullname"),
                't3.lrnno as lrn',
                't4.graname as grade',
                't5.secname as section',
                't3.logdate',
                't3.logtime',
                't3.logtype'
            )
            ->whereBetween('t3.logdate', [$request->startDate, $request->endDate])
            ->where('t5.secserial', '=', $section)
            ->where('t1.isdelete', '=', 0)
            ->where('t3.entrytype', '=', 'STUDENT')
            ->orderBy('t2.lastname', 'asc')
            ->orderBy('t3.logdate', 'asc')
            ->get();

        return response()->json($results);
    }
}
