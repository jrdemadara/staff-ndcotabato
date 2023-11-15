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
        $data = DB::select('CALL spSMSLog(?,?)', [$request->key1, $request->key2]);
        return response()->json($data);
    }
}
