<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AsesoriaController;

/*
|--------------------------------------------------------------------------
| Rutas Públicas
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

// Rutas de Autenticación (Hechas a medida para Trueque-Tec)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/registro', [AuthController::class, 'showRegister'])->name('register');
Route::post('/registro', [AuthController::class, 'register'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Rutas Protegidas (Solo para usuarios logueados de la UTVT)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    
    // Panel Principal de Asesorías (Banco de Tiempo)
    Route::get('/asesorias', [AsesoriaController::class, 'index'])->name('asesorias.index');
    Route::get('/asesorias/crear', [AsesoriaController::class, 'create'])->name('asesorias.create');
    Route::post('/asesorias', [AsesoriaController::class, 'store'])->name('asesorias.store');
    
    // Acciones del Trueque
    Route::post('/asesorias/unirse/{id}', [AsesoriaController::class, 'unirse'])->name('asesorias.unirse');
    Route::post('/asesorias/finalizar/{id}', [AsesoriaController::class, 'finalizarAsesoria'])->name('asesorias.finalizar');
    
    // Perfil del Usuario (Donde verá sus puntos y asesorías)
    Route::get('/perfil', [AsesoriaController::class, 'perfil'])->name('perfil.index');
    
    // Rutas de edición y borrado (CRUD)
    Route::get('/asesorias/{asesoria}/editar', [AsesoriaController::class, 'edit'])->name('asesorias.edit');
    Route::put('/asesorias/{asesoria}', [AsesoriaController::class, 'update'])->name('asesorias.update');
    Route::delete('/asesorias/{asesoria}', [AsesoriaController::class, 'destroy'])->name('asesorias.destroy');

});

Route::get('/', function () {
    return redirect()->route('login');
});