<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Asesoria; // Asegúrate de importar el modelo

class PerfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Buscamos las asesorías donde el usuario es el alumno
        $asesorias_tomadas = Asesoria::where('id_alumno', $user->id)
            ->with('experto') // Cargamos la relación del experto para mostrar su nombre
            ->latest()
            ->get();

        // Buscamos las asesorías donde el usuario es el experto
        $asesorias_dadas = Asesoria::where('id_experto', $user->id)
            ->with('alumno') // Cargamos la relación del alumno
            ->latest()
            ->get();

        return view('perfil.index', compact('user', 'asesorias_tomadas', 'asesorias_dadas'));
    }
}