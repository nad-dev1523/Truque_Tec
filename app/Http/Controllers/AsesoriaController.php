<?php

namespace App\Http\Controllers;

use App\Models\Asesoria;
use App\Models\User;
use App\Models\Lugar; 
use App\Models\DetalleAsistencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AsesoriaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $query = Asesoria::with(['experto', 'alumno', 'lugar']);

        if ($user->id_rol == 1) {
            $asesorias = $query->latest()->get();
        } elseif ($user->id_rol == 2) {
            $asesorias = $query->where('id_experto', $user->id)->latest()->get();
        } else {
            $asesorias = $query->where('estado', 'Disponible')
                               ->orWhere('id_alumno', $user->id)
                               ->latest()
                               ->get();
        }

        return view('asesorias.index', compact('asesorias'));
    }

    public function create()
    {
        $lugares = Lugar::all();
        $alumnos = User::where('id_rol', 3)->get();
        return view('asesorias.create', compact('alumnos', 'lugares'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_lugar' => 'required|exists:lugares,id_lugar',
            'materia' => 'required|string|max:255',
            'fecha' => 'required|date|after_or_equal:today',
            'hora_ini' => 'required',
            'hora_fin' => 'required',
            'descripcion' => 'required|string'
        ]);

        $data['id_experto'] = Auth::id();
        $data['estado'] = 'Disponible'; 
        
        Asesoria::create($data);

        return redirect()->route('asesorias.index')->with('success', 'Asesoría publicada con éxito.');
    }

    // Métodos edit, update y destroy se mantienen...

    public function unirse($id)
    {
        $asesoria = Asesoria::findOrFail($id);
        $alumno = Auth::user();
        
        // Validación: Puntos suficientes
        if ($alumno->puntos < 1) {
            return redirect()->back()->with('error', 'Necesitas al menos 1 punto para solicitar este trueque.');
        }

        // Validación: Disponibilidad
        if ($asesoria->estado !== 'Disponible') {
            return redirect()->back()->with('error', 'Esta asesoría ya ha sido tomada.');
        }

        // El punto se descuenta al alumno al unirse, pero el experto lo cobra al finalizar
        DB::transaction(function () use ($alumno, $asesoria) {
            $alumno->decrement('puntos', 1);

            $asesoria->update([
                'id_alumno' => $alumno->id,
                'estado' => 'Ocupada'
            ]);
        });

        return redirect()->route('asesorias.index')->with('success', '¡Excelente! Te has unido a la asesoría. Tu punto ha sido reservado.');
    }

    public function finalizarAsesoria($id)
    {
        $asesoria = Asesoria::findOrFail($id);
        $experto = Auth::user();

        if ($experto->id !== $asesoria->id_experto) {
            return redirect()->back()->with('error', 'Solo el tutor puede finalizar esta sesión.');
        }

        // Buscamos al alumno para darle su bonificación
        $alumno = User::find($asesoria->id_alumno);

        // Al finalizar: el experto cobra 1, el alumno gana 2 y se registra la asistencia
        DB::transaction(function () use ($asesoria, $experto, $alumno) {
            $experto->increment('puntos', 1);

            if ($alumno) {
                $alumno->increment('puntos', 2);
            }

            DetalleAsistencia::create([
                'id_as' => $asesoria->id_asesoria,
                'id_usuario' => $asesoria->id_alumno,
                'asistio' => true
            ]);

            $asesoria->update(['estado' => 'Finalizada']);
        });

        return redirect()->route('perfil.index')->with('success', 'Asesoría finalizada. Has ganado 1 punto y el alumno ha recibido 2 puntos de bonificación.');
    }

    public function perfil()
    {
        $user = Auth::user();
        $data = [];

        if ($user->id_rol == 1) { // Admin
            $data['total_usuarios'] = User::count();
            $data['total_asesorias'] = Asesoria::count();
            $data['historial'] = Asesoria::with(['experto', 'alumno'])->latest()->take(10)->get();
        } 
        elseif ($user->id_rol == 2) { // Experto
            $data['asesorias_dadas'] = Asesoria::where('id_experto', $user->id)->where('estado', 'Finalizada')->count();
            $data['proximas'] = Asesoria::where('id_experto', $user->id)
                                        ->whereIn('estado', ['Disponible', 'Ocupada'])
                                        ->get();
        } 
        else { // Alumno
            $data['puntos'] = $user->puntos;
            $data['historial'] = Asesoria::where('id_alumno', $user->id)
                                         ->with('experto')
                                         ->latest()
                                         ->get();
        }

        return view('perfil.index', compact('user', 'data'));
    }
}