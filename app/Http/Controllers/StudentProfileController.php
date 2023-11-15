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
        $students = DB::select('CALL spProfileOnline()');

        return response()->json($students);
    }
}
