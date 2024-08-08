<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SMSLogController extends Controller
{
    public function index(): View
    {
        $name = DB::select('CALL spSearchSE()');

        usort($name, function ($a, $b) {
            return strcmp($a->FULLNAME, $b->FULLNAME);
        });

        return view('pages/sms-log', [
            'layout' => 'top-menu',
            'names' => $name,
        ]);

    }

    public function populate(Request $request)
    {

        $results = DB::table('smsnotification')
            ->select('*', DB::raw("
            CASE
                WHEN message LIKE '%ENTERED%' THEN 'ENTRANCE'
                WHEN message LIKE '%LEFT%' THEN 'EXIT'
                ELSE 'UNKNOWN'
            END as logtype
        "))
            ->whereRaw("DATE_FORMAT(datecreated, '%Y-%m-%d') >= ?", [$request->startDate])
            ->whereRaw("DATE_FORMAT(datecreated, '%Y-%m-%d') <= ?", [$request->endDate])
            ->orderBy('datecreated', 'asc')
            ->get();

        return response()->json($results);
    }
}
