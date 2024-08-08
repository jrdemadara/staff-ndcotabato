<?php

namespace App\Http\Controllers;

use App\Models\Sections;
use App\Models\Teachers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function index(): View
    {
        $sections = Sections::select('secserial', 'secname')->get();

        return view('register.main', [
            'layout' => 'base',
            'sections' => $sections,
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'id_number' => 'required|string|unique:users,id_number',
            'password' => 'required|string|min:8|confirmed',
            'user_type' => 'required|string',
            'section' => 'required|string',
        ]);

        //Check if id number valid
        if ($this->checkIdNumber($request->input('id_number'))) {
            return response()->json([
                'status' => 'failed',
                'message' => 'id number is invalid.',
                'data' => null,
            ], 400);
        }

        //Check if id number is already registered
        if ($this->isIdRegistered($request->input('id_number'))) {
            return response()->json([
                'status' => 'failed',
                'message' => 'id number is already registered.',
                'data' => null,
            ], 400);
        }

        //Check the user type
        if ($request->input('user_type') === 'teacher') {
            if ($this->isSectionRegistered($request->input('section'))) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Section is already belong to teacher.',
                    'data' => null,
                ], 400);
            }
        }

        $user = new User();
        $user->id_number = $request->input('id_number');
        $user->password = Hash::make($request->input('password'));
        $user->user_type = $request->input('user_type');
        $user->section_id = $request->input('section');
        $user->is_active = true;
        $user->profile_id = $this->getTeacherSerial($request->id_number);

        if ($user->save()) {
            return response()->json([
                'status' => 'success',
                'message' => 'User registered successfully!',
                'data' => $user,
            ], 201); // 201 Created
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'User registration failed.',
                'data' => null,
            ], 500); // 500 Internal Server Error
        }
    }

    private function checkIdNumber($id_number): bool
    {
        $isExist = Teachers::where('id_no', $id_number)->first();
        return $isExist;
    }

    private function isIdRegistered($id_number): bool
    {
        return User::where('id_number', $id_number)->exists();
    }

    private function isSectionRegistered($section): bool
    {
        return User::where('section_id', $section)->exists();
    }

    private function getTeacherSerial($id_number): ?string
    {
        return Teachers::where('id_no', $id_number)->value('teaserial');
    }

}
