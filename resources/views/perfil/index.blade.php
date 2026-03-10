@extends('layouts.app')

@section('content')
<div class="container py-4" style="max-width: 600px; padding-bottom: 80px;">
    
    <div class="text-center mb-4">
        <div class="position-relative d-inline-block">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0D6EFD&color=fff&size=128" 
                 class="rounded-circle shadow-sm border border-4 border-white" alt="Perfil">
            <span class="position-absolute bottom-0 end-0 bg-success border border-2 border-white rounded-circle p-2"></span>
        </div>
        <h3 class="fw-bold mt-3 mb-0">{{ $user->name }}</h3>
        <p class="text-muted small">Estudiante UTVT • Matrícula: {{ $user->id }}</p>
    </div>

    <div class="card border-0 bg-primary text-white rounded-4 shadow-lg mb-4">
        <div class="card-body p-4 d-flex justify-content-between align-items-center">
            <div>
                <p class="mb-0 opacity-75 small uppercase fw-bold">Saldo Disponible</p>
                <h1 class="display-5 fw-bold mb-0">{{ $user->puntos }} <small class="fs-4">pts</small></h1>
            </div>
            <div class="bg-white bg-opacity-25 rounded-circle p-3">
                <i class="fas fa-wallet fa-2x"></i>
            </div>
        </div>
    </div>

    <h5 class="fw-bold mb-3 px-2">Actividad Reciente</h5>

    <div class="list-group list-group-flush shadow-sm rounded-4 overflow-hidden">
        @forelse($asesorias_tomadas as $item)
            <div class="list-group-item list-group-item-action border-0 py-3">
                <div class="d-flex w-100 justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="bg-danger bg-opacity-10 text-danger rounded-3 p-2 me-3">
                            <i class="fas fa-arrow-down small"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold">{{ $item->materia }}</h6>
                            <small class="text-muted">Con: {{ $item->experto->name }}</small>
                        </div>
                    </div>
                    <span class="text-danger fw-bold">-1 pt</span>
                </div>
            </div>
        @empty
            <div class="list-group-item text-center py-4 text-muted">
                No has tomado asesorías aún.
            </div>
        @endforelse

        @foreach($asesorias_dadas as $item)
            <div class="list-group-item list-group-item-action border-0 py-3">
                <div class="d-flex w-100 justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 text-success rounded-3 p-2 me-3">
                            <i class="fas fa-arrow-up small"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold">{{ $item->materia }}</h6>
                            <small class="text-muted">A: {{ $item->alumno->name ?? 'Pendiente' }}</small>
                        </div>
                    </div>
                    <span class="text-success fw-bold">+1 pt</span>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4 px-2">
        <a href="{{ route('logout') }}" class="btn btn-outline-danger w-100 rounded-pill fw-bold py-2"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Cerrar Sesión
        </a>
    </div>
</div>

<style>
    .uppercase { text-transform: uppercase; letter-spacing: 1px; }
    .list-group-item:last-child { border-bottom: 0; }
</style>
@endsection