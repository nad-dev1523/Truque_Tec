<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // 1. Validamos que nos envíen correo y contraseña
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // 2. Intentamos iniciar sesión con esos datos
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tus credenciales son incorrectas.'
            ], 401);
        }

        // 3. Si todo está bien, buscamos al usuario en la base de datos
        $user = User::where('email', $request->email)->firstOrFail();

        // 4. Generamos el Token de acceso usando Laravel Sanctum
        $token = $user->createToken('auth_token')->plainTextToken;

        // 5. Devolvemos la respuesta en formato JSON para el móvil
        return response()->json([
            'status' => 'success',
            'message' => '¡Hola de nuevo, ' . $user->name . '!',
            'data' => [
                'usuario' => [
                    'id' => $user->id,
                    'nombre' => $user->name,
                    'rol' => $user->id_rol,
                    'puntos' => $user->puntos
                ],
                'access_token' => $token,
                'token_type' => 'Bearer'
            ]
        ], 200);
    }
}