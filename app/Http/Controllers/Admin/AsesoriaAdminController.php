<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asesoria;
use Illuminate\Http\Request;

class AsesoriaAdminController extends Controller
{
    /**
     * Muestra la lista de todas las asesorías para el Administrador
     */
    public function index()
    {
        // Traemos las asesorías cargando las relaciones de 'user' (el experto) 
        // y 'lugar' para evitar errores de carga.
        $asesorias = Asesoria::with(['user', 'lugar'])->orderBy('fecha', 'desc')->get();
        
        return view('admin.asesorias.index', compact('asesorias'));
    }

    /**
     * Permite al admin cancelar/eliminar una asesoría si hay algún problema
     */
    public function destroy(Asesoria $asesoria)
    {
        $asesoria->delete();
        return back()->with('success', 'La asesoría ha sido eliminada por el administrador.');
    }
}