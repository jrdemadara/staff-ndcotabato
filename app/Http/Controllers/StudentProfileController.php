<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $students = DB::select('CALL spProfileOnline()');

        return response()->json($students);
    }

    public function details(Request $request): View
    {

        $search = $request->search;
        $results = DB::table('profiles as t1')
            ->select([
                't1.lrnno as lrn',
                DB::raw("CONCAT(t1.lastname, ', ', t1.firstname, ' ', t1.middlename, ' ', t1.extension) as fullname"),
                't1.birthdate as birthdate',
                DB::raw("DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(t1.birthdate, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(t1.birthdate, '00-%m-%d')) as age"),
                't1.gender as gender',
                't3.graname as grade',
                't4.secname as section',
                't1.guardiansname as parent',
                't1.gcontact as contact',
                't1.gaddress as address',
            ])
            ->join('enrollment as t2', 't1.studserial', '=', 't2.studserial')
            ->join('gradelevel as t3', 't2.gradeserial', '=', 't3.graserial')
            ->join('section as t4', 't2.secserial', '=', 't4.secserial')
            ->where(function ($query) use ($search) {
                if (!empty($search)) {
                    $query->orWhereRaw("LOWER(CONCAT(t1.lastname, ', ', t1.firstname, ' ', t1.middlename, ' ', t1.extension)) LIKE ?", ["%" . strtolower($search) . "%"]);
                    $query->orWhereRaw("LOWER(CONCAT(t4.secname)) LIKE ?", ["%" . strtolower($search) . "%"]);
                    $query->orWhereRaw("LOWER(CONCAT(t3.graname)) LIKE ?", ["%" . strtolower($search) . "%"]);
                }
            })
            ->orderByRaw("CONCAT(t1.lastname, ', ', t1.firstname, ' ', t1.middlename, ' ', t1.extension) ASC")
            ->get();

        return view('pages/student-profile', [
            'layout' => 'top-menu',
            'students' => $results,
            'search' => $search,
        ]);
    }
}
