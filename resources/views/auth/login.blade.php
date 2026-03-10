@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card border-0 shadow-sm rounded-4 p-4" style="width: 100%; max-width: 400px;">
        <div class="text-center mb-4">
            <h2 class="fw-bold text-primary">Trueque-Tec</h2>
            <p class="text-muted">Inicia sesión para continuar</p>
        </div>

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-bold">Correo Institucional</label>
                <input type="email" name="email" class="form-control rounded-pill px-3" placeholder="usuario@utvt.edu.mx" required>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Contraseña</label>
                <input type="password" name="password" class="form-control rounded-pill px-3" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-bold shadow-sm">
                Entrar
            </button>
        </form>

        <div class="text-center mt-4">
            <p class="small">¿No tienes cuenta? <a href="{{ route('register') }}" class="text-primary fw-bold text-decoration-none">Regístrate aquí</a></p>
        </div>
    </div>
</div>
@endsection