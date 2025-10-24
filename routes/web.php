<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect('/users'));
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/email-test', [UserController::class, 'emailTestForm'])->name('email.test.form');
Route::post('/email-test', [UserController::class, 'sendTestEmail'])->name('email.test.send');
Route::post('/language/switch', [UserController::class, 'switchLanguage'])->name('language.switch');
