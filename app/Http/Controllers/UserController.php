<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function users(){
        $users = user::all(); // Obtiene todos los usuarios
        return view('admin.user.listUser', compact('users'));
    }
}
