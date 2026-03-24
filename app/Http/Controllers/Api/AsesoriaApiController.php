<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Asesoria;
use App\Models\User;
use App\Models\DetalleAsistencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AsesoriaApiController extends Controller
{
    public function index()
    {
        // Traemos las asesorías disponibles con sus relaciones
        $asesorias = Asesoria::with(['experto', 'lugar'])
            ->where('estado', 'Disponible')
            ->latest()
            ->get();

        // En lugar de una vista, devolvemos un JSON que el móvil entenderá
        return response()->json([
            'status' => 'success',
            'message' => 'Asesorías recuperadas correctamente',
            'data' => $asesorias
        ], 200);
    }

    public function unirse(Request $request, $id)
    {
        // 1. Buscamos la asesoría por el ID que mandó el móvil
        $asesoria = Asesoria::find($id);
        
        if (!$asesoria) {
            return response()->json(['status' => 'error', 'message' => 'Asesoría no encontrada.'], 404);
        }

        // 2. Obtenemos al usuario autenticado mediante el Token
        $alumno = Auth::user();

        // 3. Validaciones de seguridad
        if ($alumno->id_rol != 3) {
            return response()->json(['status' => 'error', 'message' => 'Solo los alumnos pueden solicitar trueques.'], 403);
        }

        if ($asesoria->estado !== 'Disponible') {
            return response()->json(['status' => 'error', 'message' => 'Esta asesoría ya no está disponible.'], 400);
        }

        if ($alumno->puntos < 1) {
            return response()->json(['status' => 'error', 'message' => 'No tienes puntos suficientes.'], 400);
        }

        // 4. Ejecutamos la transacción (Igual que en la web)
        try {
            DB::transaction(function () use ($alumno, $asesoria) {
                $alumno->decrement('puntos', 1);
                $asesoria->update([
                    'id_alumno' => $alumno->id,
                    'estado' => 'Ocupada'
                ]);
            });

            return response()->json([
                'status' => 'success',
                'message' => '¡Te has unido con éxito!',
                'puntos_restantes' => $alumno->fresh()->puntos // Enviamos el saldo actualizado
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Error al procesar el trueque.'], 500);
        }
    }

    public function finalizarAsesoria($id)
    {
        // 1. Buscamos la asesoría (id_asesoria)
        $asesoria = Asesoria::find($id);
        
        if (!$asesoria) {
            return response()->json(['status' => 'error', 'message' => 'Asesoría no encontrada.'], 404);
        }

        $experto = Auth::user();

        // 2. Verificación: ¿Es este usuario el experto de esta asesoría?
        if ($experto->id !== $asesoria->id_experto) {
            return response()->json(['status' => 'error', 'message' => 'No tienes permiso para finalizar esta sesión.'], 403);
        }

        // 3. Verificación: ¿Tiene un alumno asignado?
        if (!$asesoria->id_alumno) {
            return response()->json(['status' => 'error', 'message' => 'No se puede finalizar una asesoría sin alumno.'], 400);
        }

        $alumno = User::find($asesoria->id_alumno);

        try {
            DB::transaction(function () use ($asesoria, $experto, $alumno) {
                // El experto gana 1 punto
                $experto->increment('puntos', 1);

                // El alumno gana 2 puntos (bonificación UTVT)
                if ($alumno) {
                    $alumno->increment('puntos', 2);
                }

                // Registro de asistencia
                DetalleAsistencia::create([
                    'id_as' => $asesoria->id_asesoria,
                    'id_usuario' => $asesoria->id_alumno,
                    'asistio' => true
                ]);

                // Actualizar estado
                $asesoria->update(['estado' => 'Finalizada']);
            });

            return response()->json([
                'status' => 'success',
                'message' => 'Asesoría finalizada exitosamente. Puntos repartidos.',
                'mis_puntos' => $experto->fresh()->puntos
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Error al procesar la finalización.'], 500);
        }
    }

    public function historial()
    {
    $user = Auth::user();

    // Obtenemos las asesorías donde participó el alumno logueado
    $historial = Asesoria::where('id_alumno', $user->id)
        ->with(['experto', 'lugar'])
        ->latest()
        ->get();

    return response()->json([
        'status' => 'success',
        'usuario' => $user->name,
        'puntos_actuales' => $user->puntos,
        'data' => $historial
    ], 200);
    }
}