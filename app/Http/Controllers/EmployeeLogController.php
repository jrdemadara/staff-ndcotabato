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
        $data = DB::select('CALL spEmployeeLog(?,?)', [$request->key1, $request->key2]);
        return response()->json($data);
    }
}
