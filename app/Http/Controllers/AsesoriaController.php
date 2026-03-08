<?php

namespace App\Http\Controllers;

use App\Models\Asesoria;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AsesoriaController extends Controller
{
    /**
     * Mostrar listado de asesorías
     */
    public function index()
{
    if (auth()->user()->id_rol == 1) {
        // Admin ve todas
        $asesorias = Asesoria::with('experto','alumno')->get();
    }

    elseif (auth()->user()->id_rol == 2) {
        // Experto ve solo las suyas
        $asesorias = Asesoria::with('experto','alumno')
            ->where('experto_id', auth()->id())
            ->get();
    }

    else {
        // Alumno ve solo donde está inscrito
        $asesorias = Asesoria::with('experto','alumno')
            ->where('alumno_id', auth()->id())
            ->get();
    }

    return view('asesorias.index', compact('asesorias'));
}

    /**
     * Mostrar formulario para crear
     */
    public function create()
    {
        $expertos = User::where('id_rol', 2)->get();
        $alumnos = User::where('id_rol', 3)->get();

        return view('asesorias.create', compact('expertos', 'alumnos'));
    }

    /**
     * Guardar nueva asesoría
     */
    public function store(Request $request)
    {
        $request->validate([
            'experto_id' => 'required',
            'alumno_id' => 'required',
            'materia' => 'required|string|max:255',
            'fecha' => 'required|date',
            'descripcion' => 'required'
        ]);

        Asesoria::create([
            'experto_id' => $request->experto_id,
            'alumno_id' => $request->alumno_id,
            'materia' => $request->materia,
            'fecha' => $request->fecha,
            'descripcion' => $request->descripcion,
            'estado' => 'Pendiente'
        ]);

        return redirect()->route('asesorias.index')
            ->with('success', 'Asesoría creada correctamente');
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(Asesoria $asesoria)
    {
        $expertos = User::where('id_rol', 2)->get();
        $alumnos = User::where('id_rol', 3)->get();

        return view('asesorias.edit', compact('asesoria', 'expertos', 'alumnos'));
    }

    /**
     * Actualizar asesoría
     */
    public function update(Request $request, Asesoria $asesoria)
    {
        $request->validate([
            'experto_id' => 'required',
            'alumno_id' => 'required',
            'materia' => 'required|string|max:255',
            'fecha' => 'required|date',
            'descripcion' => 'required',
            'estado' => 'required'
        ]);

        $asesoria->update($request->all());

        return redirect()->route('asesorias.index')
            ->with('success', 'Asesoría actualizada correctamente');
    }

    /**
     * Eliminar asesoría
     */
    public function destroy(Asesoria $asesoria)
    {
        $asesoria->delete();

        return redirect()->route('asesorias.index')
            ->with('success', 'Asesoría eliminada correctamente');
    }
}