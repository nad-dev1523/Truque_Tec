<?php

use App\Http\Controllers\Admin\AsesoriaAdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AsesoriaController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ExpertController;
// PASO 1: Importar el controlador de análisis
use App\Http\Controllers\AnalysisController;

/*
|--------------------------------------------------------------------------
| Rutas Públicas
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

// Rutas de Autenticación
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/registro', [AuthController::class, 'showRegister'])->name('register');
Route::post('/registro', [AuthController::class, 'register'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Rutas Protegidas (Solo Alumnos y Expertos UTVT)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Ruta para ver el directorio de expertos
    Route::get('/expertos', [ExpertController::class, 'index'])->name('expertos.index');
    
    // MONITOR DE ASESORÍAS (ADMIN)
    Route::get('/admin/monitor', [AsesoriaAdminController::class, 'index'])->name('admin.asesorias.monitor');
    Route::delete('/admin/monitor/{asesoria}', [AsesoriaAdminController::class, 'destroy'])->name('admin.asesorias.destroy');

    // PANEL DE ADMINISTRACIÓN Y ANÁLISIS
    Route::get('/admin/usuarios', [UserController::class, 'index'])->name('admin.users.index');
    Route::delete('/admin/usuarios/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    Route::put('/admin/usuarios/{user}', [UserController::class, 'update'])->name('admin.users.update');

    // PASO 1: Nueva ruta para el Análisis de Laplace
    Route::get('/admin/analisis-crecimiento', [AnalysisController::class, 'index'])->name('admin.analisis');

    // Monitor de Asesorías
    Route::get('/admin/monitor-lista', [App\Http\Controllers\Admin\AsesoriaController::class, 'index'])->name('admin.asesorias.index');
    
    // Perfil
    Route::get('/perfil', [PerfilController::class, 'index'])->name('perfil.index');
    
    // Banco de Tiempo
    Route::get('/asesorias', [AsesoriaController::class, 'index'])->name('asesorias.index');
    Route::get('/asesorias/crear', [AsesoriaController::class, 'create'])->name('asesorias.create');
    Route::post('/asesorias', [AsesoriaController::class, 'store'])->name('asesorias.store');
    
    // Acciones del Trueque
    Route::post('/asesorias/unirse/{id}', [AsesoriaController::class, 'unirse'])->name('asesorias.unirse');
    Route::post('/asesorias/finalizar/{id}', [AsesoriaController::class, 'finalizarAsesoria'])->name('asesorias.finalizar');
    
    // CRUD
    Route::get('/asesorias/{asesoria}/editar', [AsesoriaController::class, 'edit'])->name('asesorias.edit');
    Route::put('/asesorias/{asesoria}', [AsesoriaController::class, 'update'])->name('asesorias.update');
    Route::delete('/asesorias/{asesoria}', [AsesoriaController::class, 'destroy'])->name('asesorias.destroy');

});