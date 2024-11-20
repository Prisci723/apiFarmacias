<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class LoginController extends Controller
{   
    public function login(Request $request)
    {
        // Validamos que recibamos el email y password
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
    
        // Buscamos el usuario por email
        $usuario = Usuario::where('email', $request->email)->first();
    
        // Verificamos si existe el usuario y si la contraseña coincide
        if (!$usuario || $request->password !== $usuario->password) {
            return response()->json([
                'message' => 'Credenciales incorrectas'
            ], 401);
        }
    
        // Si las credenciales son correctas, devolvemos los datos del usuario
        return response()->json([
            'id' => $usuario->id,
            'nombre' => $usuario->nombre,
            'email' => $usuario->email,
            'password' => $usuario->password,
            'rol' => $usuario->rol,
            'id_ubicacion' => $usuario->id_ubicacion
        ], 200);
    }
}
