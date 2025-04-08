<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('home');
});

Route::get('/biografia', function () {
    return view('biografia');
});


Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/auth', [LoginController::class, 'auth'])->name('auth');


//Rutas que se requieren ser Logueadas para verlas

Route::prefix('admin')->middleware(['auth'])->group(function () {
    //Dashboard
    Route::get('/dashboard', function () { return view('admin.dashboard'); })->name('dashboard');

    //Usuarios
    
    Route::get('/users', [UserController::class, 'users'])->name('users');
    Route::post('/addUser', [UserController::class, 'store'])->name('addUser');
    Route::put('/updateUser/{id}', [UserController::class, 'update'])->name('updateUser');
    Route::delete('/deleteUser/{id}', [UserController::class, 'destroy'])->name('deleteUser');

});