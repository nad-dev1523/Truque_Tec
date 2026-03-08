<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\AsesoriaController;

/*
|--------------------------------------------------------------------------
| LOGIN
|--------------------------------------------------------------------------
*/

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', function (Request $request) {

    if (Auth::attempt([
        'email' => $request->email,
        'password' => $request->password
    ])) {

        $user = Auth::user();

        if ($user->id_rol == 1) {
            return redirect('/admin');
        } elseif ($user->id_rol == 2) {
            return redirect('/experto');
        } else {
            return redirect('/alumno');
        }
    }

    return back()->with('error', 'Credenciales incorrectas');
});

/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login');
});

/*
|--------------------------------------------------------------------------
| VISTAS POR ROL
|--------------------------------------------------------------------------
*/

Route::get('/admin', function () {

    if (!Auth::check() || Auth::user()->id_rol != 1) {
        return redirect('/login');
    }

    $users = \App\Models\User::all();

    return view('admin', compact('users'));
});

Route::get('/experto', function () {

    if (!Auth::check() || Auth::user()->id_rol != 2) {
        return redirect('/login');
    }

    return view('experto');
});

Route::get('/alumno', function () {

    if (!Auth::check() || Auth::user()->id_rol != 3) {
        return redirect('/login');
    }

    return view('alumno');
});

Route::get('/hacer-experto/{id}', function ($id) {

    if (!Auth::check() || Auth::user()->id_rol != 1) {
        return redirect('/login');
    }

    $user = \App\Models\User::find($id);
    $user->id_rol = 2;
    $user->save();

    return redirect('/admin');
});

/*
|--------------------------------------------------------------------------
| SISTEMA DE ASESORÍAS (CRUD FORMAL)
|--------------------------------------------------------------------------
*/

Route::resource('asesorias', AsesoriaController::class)->middleware('auth');