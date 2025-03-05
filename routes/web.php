<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});


Route::get('/login', [LoginController::class, 'login']);

Route::post('/login', [LoginController::class, 'auth'])->name('login');


Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware('auth')->name('dashboard');