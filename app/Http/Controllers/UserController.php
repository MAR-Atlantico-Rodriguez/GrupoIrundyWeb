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

    public function store(Request $request)
    {
        // Validar los datos
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        // Crear el usuario
        $user = User::create([
            'name' => $validated['nombre'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']), // ¡Nunca guardes passwords en texto plano!
        ]);

        // Podés devolver una respuesta en JSON
        return response()->json('Usuario agregado correctamente');
    }

    public function destroy($id){
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }
        $user->delete();
        return response()->json(['message' => 'Usuario eliminado correctamente']);
    }

    public function update(Request $request, $id)
{
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        // Validación
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6',
        ]);

        // Actualización
        $user->name = $validated['nombre'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = bcrypt($validated['password']);
        }

        $user->save();

        return response()->json(['message' => 'Usuario actualizado correctamente']);
    }
}
