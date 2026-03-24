<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asesoria;
use Illuminate\Http\Request;

class AsesoriaController extends Controller
{
    public function index()
    {
        // Traemos las asesorías con sus relaciones (usuario y lugar)
        $asesorias = Asesoria::with(['user', 'lugar'])->get();
        return view('admin.asesorias.index', compact('asesorias'));
    }

    public function destroy(Asesoria $asesoria)
    {
        $asesoria->delete();
        return back()->with('success', 'Asesoría cancelada por el administrador.');
    }
}