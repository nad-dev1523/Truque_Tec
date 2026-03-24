<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Muestra la lista de todos los usuarios (Alumnos, Expertos, Admins)
     */
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Paso 1: Función para actualizar datos del usuario (Nombre, Rol y Puntos)
     * Esto permite al Admin gestionar el "Banco de Tiempo" de Trueque-Tec.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'id_rol' => 'required|integer',
            'puntos' => 'required|integer|min:0',
        ]);

        $user->update([
            'name' => $request->name,
            'id_rol' => $request->id_rol,
            'puntos' => $request->puntos,
        ]);

        return back()->with('success', 'Usuario actualizado con éxito.');
    }

    /**
     * Función para eliminar usuario
     * Incluye seguridad para no eliminar la cuenta activa del Admin.
     */
    public function destroy(User $user)
    {
        // Evitar que el admin se borre a sí mismo
        if (auth()->id() == $user->id) {
            return back()->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        $user->delete();
        return back()->with('success', 'Usuario eliminado correctamente.');
    }
}