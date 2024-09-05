<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//register
Route::get('/register/{code}', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register/{code}', [AuthController::class, 'register'])->name('register');

//reset
Route::get('/forget-password', [AuthController::class, 'forgetForm'])->name('password.forget');
Route::post('/forget-password', [AuthController::class, 'forgetAction'])->name('password.forget');

Route::post('/reset-password', [AuthController::class, 'resetPasswordForm'])->name('password.reset');
Route::post('/reset-password-update', [AuthController::class, 'resetPassword'])->name('password.update');

Route::get('/verify-phone', [AuthController::class, 'verifyPhoneForm'])->name('phone.verify.form');
Route::post('/verify-phone', [AuthController::class, 'verifyPhone'])->name('phone.verify');

Route::get('/resend-otp', [AuthController::class, 'resendOtp'])->name('otp.resend');
