<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\HomeController;


Route::get('/', [HomeController::class, 'home']);
Route::get('/biografia', [HomeController::class, 'biografia'])->name('biografia');


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

    //eventos
    Route::get('/eventos/index', [EventoController::class, 'index'])->name('eventos.index');
    Route::get('/eventos', [EventoController::class, 'allEventos'])->name('eventos.all');
    Route::post('/eventos', [EventoController::class, 'store'])->name('eventos.store');
    Route::get('/eventos/{id}', [EventoController::class, 'show'])->name('eventos.show');
    Route::put('/eventos/{id}', [EventoController::class, 'update'])->name('eventos.update');
    Route::delete('/eventos/{id}', [EventoController::class, 'destroy'])->name('eventos.destroy');

});