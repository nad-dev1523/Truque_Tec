<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin() { 
        return view('auth.login'); 
    }

    public function showRegister() { 
        return view('auth.register'); 
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'El correo es obligatorio.',
            'email.email' => 'Ingresa un correo válido.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('asesorias.index');
        }

        return back()->withErrors(['email' => 'Las credenciales no coinciden con nuestros registros.']);
    }

    public function register(Request $request) {
        // 1. Validamos los datos con mensajes en español
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Ingresa un formato de correo válido.',
            'email.unique' => 'Este correo ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
        ]);

        try {
            // 2. Intentamos crear el usuario
            $user = User::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => Hash::make($data['password']),
                'id_rol'   => 3,  // Alumno UTVT
                'puntos'   => 10, // Saldo inicial
            ]);

            // 3. Logueo y redirección
            Auth::login($user);
            return redirect()->route('asesorias.index');

        } catch (\Exception $e) {
            // Si sale error aquí, revisa que id_rol y puntos existan en tu tabla de MySQL
            return back()->withInput()->withErrors(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
        }
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}