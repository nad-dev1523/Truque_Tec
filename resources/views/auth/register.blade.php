@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card border-0 shadow-sm rounded-4 p-4" style="width: 100%; max-width: 450px;">
        <div class="text-center mb-4">
            <h2 class="fw-bold text-primary">Únete a la Comunidad</h2>
            <p class="text-muted">Intercambia conocimientos en la UTVT</p>
        </div>

            @if ($errors->any())
        <div class="alert alert-danger shadow-sm rounded-4">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

        <form action="{{ route('register.post') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-bold">Nombre Completo</label>
                <input type="text" name="name" class="form-control rounded-pill px-3" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Correo Electrónico</label>
                <input type="email" name="email" class="form-control rounded-pill px-3" required>
            </div>

            <div class="row mb-4">
                <div class="col-6">
                    <label class="form-label fw-bold">Contraseña</label>
                    <input type="password" name="password" class="form-control rounded-pill px-3" required>
                </div>
                <div class="col-6">
                    <label class="form-label fw-bold">Confirmar</label>
                    <input type="password" name="password_confirmation" class="form-control rounded-pill px-3" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-bold shadow-sm">
                Crear Cuenta
            </button>
        </form>
    </div>
</div>
@endsection