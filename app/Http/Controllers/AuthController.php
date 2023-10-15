<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Show specified view.
     */
    public function loginView(): View
    {
        return view('login.main', [
            'layout' => 'base',
        ]);
    }

    /**
     * Authenticate login user.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function login(LoginRequest $request): void
    {
        if (!Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])) {
            throw new \Exception('Wrong email or password.');
        }
    }

    /**
     * Logout user.
     */
    public function logout(): RedirectResponse
    {
        Auth::logout();
        return redirect('login');
    }
}
