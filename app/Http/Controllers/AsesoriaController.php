<?php

namespace App\Http\Controllers;

use App\Models\Asesoria;
use App\Models\User;
use App\Models\Lugar; 
use App\Models\DetalleAsistencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash; // <-- IMPORTANTE: Faltaba esta para el registro

class AsesoriaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $query = Asesoria::with(['experto', 'alumno', 'lugar']);

        if ($user->id_rol == 1) {
            $asesorias = $query->latest()->get();
        } elseif ($user->id_rol == 2) {
            // El experto ve las que él imparte
            $asesorias = $query->where('id_experto', $user->id)->latest()->get();
        } else {
            // El alumno ve las disponibles (para unirse) o las que ya reservó
            $asesorias = $query->where('estado', 'Disponible')
                               ->orWhere('id_alumno', $user->id)
                               ->latest()
                               ->get();
        }

        return view('asesorias.index', compact('asesorias'));
    }

    public function create()
    {
        // PASO 2: Cargamos los lugares de la base de datos para el select
        $lugares = Lugar::all();
        
        // El experto no necesita elegir alumno al crear, la deja 'Disponible'
        // Pero cargamos la lista por si el Admin quiere asignar a alguien directamente
        $alumnos = User::where('id_rol', 3)->get();

        return view('asesorias.create', compact('alumnos', 'lugares'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_lugar' => 'required|exists:lugares,id_lugar',
            'materia' => 'required|string|max:255',
            'fecha' => 'required|date|after_or_equal:today', // Validación extra de seguridad
            'hora_ini' => 'required',
            'hora_fin' => 'required',
            'descripcion' => 'required|string'
        ]);

        // El experto es quien está logueado
        $data['id_experto'] = Auth::id();
        $data['estado'] = 'Disponible'; 
        
        Asesoria::create($data);

        return redirect()->route('asesorias.index')
                         ->with('success', 'Asesoría publicada con éxito en el Banco de Tiempo.');
    }

    public function edit(Asesoria $asesoria)
    {
        $alumnos = User::where('id_rol', 3)->get();
        $lugares = Lugar::all();

        return view('asesorias.edit', compact('asesoria', 'alumnos', 'lugares'));
    }

    public function update(Request $request, Asesoria $asesoria)
    {
        $data = $request->validate([
            'id_lugar' => 'required|exists:lugares,id_lugar',
            'materia' => 'required|string',
            'fecha' => 'required|date',
            'estado' => 'required|string',
            'hora_ini' => 'required',
            'hora_fin' => 'required',
            'descripcion' => 'required'
        ]);

        $asesoria->update($data);

        return redirect()->route('asesorias.index')->with('success', 'Asesoría actualizada correctamente.');
    }

    public function destroy(Asesoria $asesoria)
    {
        $asesoria->delete();
        return redirect()->route('asesorias.index')->with('success', 'Asesoría eliminada del sistema.');
    }

    public function unirse($id)
    {
        $asesoria = Asesoria::findOrFail($id);
        $alumno = Auth::user();
        $experto = User::find($asesoria->id_experto);

        // Lógica de protección del Trueque
        if ($alumno->puntos < 1) {
            return redirect()->back()->with('error', 'Necesitas al menos 1 punto para solicitar este trueque.');
        }

        if ($asesoria->estado !== 'Disponible') {
            return redirect()->back()->with('error', 'Esta asesoría ya ha sido tomada.');
        }

        // Transacción para asegurar que no se pierdan puntos si algo falla
        DB::transaction(function () use ($alumno, $experto, $asesoria) {
            $alumno->decrement('puntos', 1);
            $experto->increment('puntos', 1);

            $asesoria->update([
                'id_alumno' => $alumno->id,
                'estado' => 'Ocupada'
            ]);
        });

        return redirect()->route('asesorias.index')->with('success', '¡Excelente! Te has unido a la asesoría.');
    }

    public function finalizarAsesoria($id)
    {
        $asesoria = Asesoria::findOrFail($id);

        if (Auth::id() !== $asesoria->id_experto) {
            return redirect()->back()->with('error', 'Solo el tutor puede finalizar esta sesión.');
        }

        DB::transaction(function () use ($asesoria) {
            // Creamos el registro en la tabla que acabamos de corregir
            DetalleAsistencia::create([
                'id_as' => $asesoria->id_asesoria, // Coincide con tu PK id_asesoria
                'id_usuario' => $asesoria->id_alumno,
                'asistio' => true
            ]);

            $asesoria->update(['estado' => 'Finalizada']);
        });

        return redirect()->route('asesorias.index')->with('success', 'Asistencia registrada. ¡Gracias por compartir tu conocimiento!');
    }

    public function perfil()
    {
        $user = Auth::user();
        $asesorias_tomadas = Asesoria::where('id_alumno', $user->id)->with('experto')->get();
        $asesorias_dadas = Asesoria::where('id_experto', $user->id)->with('alumno')->get();

        return view('perfil.index', compact('user', 'asesorias_tomadas', 'asesorias_dadas'));
    }
}