<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class StudentProfileController extends Controller
{
    public function index(): View
    {
        return view('pages/student-profile', [
            'layout' => 'top-menu',
        ]);
    }

    public function populate()
    {
        $results = DB::table('profiles as t1')
            ->join('enrollment as t2', 't1.studserial', '=', 't2.studserial')
            ->join('gradelevel as t3', 't2.gradeserial', '=', 't3.graserial')
            ->join('section as t4', 't2.secserial', '=', 't4.secserial')
            ->select(
                't1.lrnno as lrn',
                DB::raw("CONCAT(t1.lastname, ', ', t1.firstname, ' ', t1.middlename, ' ', t1.extension) as fullname"),
                't1.birthdate',
                DB::raw("YEAR(NOW()) - YEAR(t1.birthdate) - (DATE_FORMAT(NOW(), '%m-%d') < DATE_FORMAT(t1.birthdate, '%m-%d')) AS age"),
                't1.gender',
                't3.graname as grade',
                't4.secname as section',
                't1.guardiansname as parent',
                't1.gcontact as contact',
                't1.gaddress as address'
            )
            ->orderBy(DB::raw("CONCAT(t1.lastname, ', ', t1.firstname, ' ', t1.middlename, ' ', t1.extension)"), 'asc')
            ->get();

        return response()->json($results);
    }
}
