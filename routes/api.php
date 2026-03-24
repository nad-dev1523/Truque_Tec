<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AsesoriaApiController;
use App\Http\Controllers\Api\AuthController;

// Al acceder a http://tu-dominio/api/asesorias-disponibles desde el móvil, obtendrá el JSON
Route::get('/asesorias-disponibles', [AsesoriaApiController::class, 'index']);

// Rutas PÚBLICAS (Cualquier celular puede verlas sin tener token)
Route::post('/login', [AuthController::class, 'login']);
Route::get('/asesorias-disponibles', [AsesoriaApiController::class, 'index']);

// Rutas PROTEGIDAS (Solo celulares con un Token válido pueden entrar)
Route::middleware('auth:sanctum')->group(function () {
    
Route::middleware('auth:sanctum')->group(function () {
    
    // Ruta para que el alumno solicite la asesoría desde el móvil
    Route::post('/asesorias/{id}/unirse', [AsesoriaApiController::class, 'unirse']);
    
    // Opcional: Ruta para ver el perfil del alumno logueado
    Route::get('/user-profile', function (Request $request) {
        return $request->user();
    });

    Route::middleware('auth:sanctum')->group(function () {
    
    // Ruta para que el alumno se una
    Route::post('/asesorias/{id}/unirse', [AsesoriaApiController::class, 'unirse']);
    
    // NUEVA: Ruta para que el experto finalice
    Route::post('/asesorias/{id}/finalizar', [AsesoriaApiController::class, 'finalizarAsesoria']);
    
});

Route::middleware('auth:sanctum')->group(function () {
    // ... tus otras rutas ...
    Route::get('/historial', [AsesoriaApiController::class, 'historial']);
});

});
    
});


