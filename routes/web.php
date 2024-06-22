<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postLogin'])->name('postLogin');


Route::get("confirm-login", [AuthController::class, 'confirmLogin'])->name('confirm-login');
Route::post('confirm-login', [AuthController::class, 'postConfirmLogin'])->name('postConfirmLogin');

Route::get('forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');
Route::post('forgot-password', [AuthController::class, 'postForgotPassword'])->name('postForgotPassword');

Route::get('update-forgot-password/{token}', [AuthController::class, 'updateForgotPassword'])->name('updateForgotPassword');
Route::post('update-forgot-password/{token}', [AuthController::class, 'postUpdateForgotPassword']);
