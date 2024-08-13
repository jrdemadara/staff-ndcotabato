<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ColorSchemeController;
use App\Http\Controllers\DarkModeController;
use App\Http\Controllers\EmployeeLogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SectionLogController;
use App\Http\Controllers\SMSLogController;
use App\Http\Controllers\StudentLogController;
use App\Http\Controllers\StudentProfileController;
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

Route::controller(RegisterController::class)->group(function () {
    Route::get('register', 'index')->name('register.index');
    Route::post('register', 'register')->name('register.register');
});

Route::controller(AuthController::class)->middleware('loggedin')->group(function () {
    Route::get('login', 'loginView')->name('login.index');
    Route::post('login', 'login')->name('login.check');
});

Route::middleware('auth')->group(function () {
    Route::get('/', [AuthController::class, 'logout'])->name('logout');

    Route::get('home', [HomeController::class, 'index'])->name('home.index');

    Route::get('student-profile', [StudentProfileController::class, 'index'])->name('student-profile.index');
    Route::get('student-profile-tabulator', [StudentProfileController::class, 'populate'])->name('student-profile.populate');

    Route::get('student-log', [StudentLogController::class, 'index'])->name('student-log.index');
    Route::get('student-log-tabulator', [StudentLogController::class, 'populate'])->name('student-log.populate');

    Route::get('employee-log', [EmployeeLogController::class, 'index'])->name('employee-log.index');
    Route::get('employee-log-tabulator', [EmployeeLogController::class, 'populate'])->name('employee-log.populate');

    Route::get('sms-log', [SMSLogController::class, 'index'])->name('sms-log.index');
    Route::get('sms-log-tabulator', [SMSLogController::class, 'populate'])->name('sms-log.populate');

    Route::get('section-log', [SectionLogController::class, 'index'])->name('section-log.index');
    Route::get('section-log-tabulator', [SectionLogController::class, 'populate'])->name('section-log.populate');
    Route::get('section-date-log-tabulator', [SectionLogController::class, 'populateBySelectedDate'])->name('section-date-log.populate');

});
