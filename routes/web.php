<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('home');
});


Route::get('/login', [LoginController::class, 'login']);

Route::post('/auth', [LoginController::class, 'auth'])->name('auth');


//Rutas que se requieren ser Logueadas para verlas

Route::prefix('admin')->middleware(['auth'])->name('admin')->group(function () {
    //Dashboard
    Route::get('/dashboard', function () { return view('admin.dashboard'); })->name('dashboard');

    //Usuarios
    
    Route::get('/users', [UserController::class, 'users'])->name('users');
    Route::post('/users', function () { return 'Usuarios';    })->name('addUser');

});