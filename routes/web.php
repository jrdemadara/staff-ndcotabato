<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ColorSchemeController;
use App\Http\Controllers\DarkModeController;
use App\Http\Controllers\EmployeeLogController;
use App\Http\Controllers\EmployeesLogController;
use App\Http\Controllers\SectionLogController;
use App\Http\Controllers\SMSLogController;
use App\Http\Controllers\StudentLogController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

Route::get('dark-mode-switcher', [DarkModeController::class, 'switch'])->name('dark-mode-switcher');
Route::get('color-scheme-switcher/{color_scheme}', [ColorSchemeController::class, 'switch'])->name('color-scheme-switcher');

Route::controller(AuthController::class)->middleware('loggedin')->group(function () {
    Route::get('login', 'loginView')->name('login.index');
    Route::post('login', 'login')->name('login.check');
});

Route::middleware('auth')->group(function () {
    Route::get('/', [AuthController::class, 'logout'])->name('logout');

    Route::get('student-log', [StudentLogController::class, 'index'])->name('student-log');
    Route::post('student-log', [StudentLogController::class, 'details'])->name('student-log');

    Route::get('section-log', [SectionLogController::class, 'index'])->name('section-log');
    Route::post('section-log', [SectionLogController::class, 'details'])->name('section-log');

    Route::get('employee-log', [EmployeeLogController::class, 'index'])->name('employee-log');
    Route::post('employee-log', [EmployeeLogController::class, 'details'])->name('employee-log');

    Route::get('employees-log', [EmployeesLogController::class, 'index'])->name('employees-log');
    Route::post('employees-log', [EmployeesLogController::class, 'details'])->name('employees-log');

    Route::get('sms-log', [SMSLogController::class, 'index'])->name('sms-log');
    Route::post('sms-log', [SMSLogController::class, 'details'])->name('sms-log');
});
