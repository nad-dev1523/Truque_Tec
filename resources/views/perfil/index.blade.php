@extends('layouts.app')

@section('content')
<div class="container py-4" style="max-width: 600px; padding-bottom: 80px;">
    
    {{-- Cabecera de Perfil --}}
    <div class="text-center mb-4">
        <div class="position-relative d-inline-block">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0D6EFD&color=fff&size=128" 
                 class="rounded-circle shadow-sm border border-4 border-white" alt="Perfil">
            <span class="position-absolute bottom-0 end-0 bg-success border border-2 border-white rounded-circle p-2"></span>
        </div>
        <h3 class="fw-bold mt-3 mb-0">{{ $user->name }}</h3>
        <p class="text-muted small">
            @if($user->id_rol == 1) Administrador @elseif($user->id_rol == 2) Experto @else Alumno @endif UTVT 
            • Matrícula: {{ $user->id }}
        </p>
    </div>

    {{-- Card de Saldo (Solo visible para Alumnos y Expertos) --}}
    @if($user->id_rol != 1)
    <div class="card border-0 bg-primary text-white rounded-4 shadow-lg mb-4">
        <div class="card-body p-4 d-flex justify-content-between align-items-center">
            <div>
                <p class="mb-0 opacity-75 small uppercase fw-bold">Saldo de Trueque</p>
                <h1 class="display-5 fw-bold mb-0">{{ $user->puntos }} <small class="fs-4">pts</small></h1>
            </div>
            <div class="bg-white bg-opacity-25 rounded-circle p-3">
                <i class="fas fa-wallet fa-2x"></i>
            </div>
        </div>
    </div>
    @endif

    {{-- Actividad Reciente --}}
    <h5 class="fw-bold mb-3 px-2">
        @if($user->id_rol == 1) Resumen del Sistema @else Actividad Reciente @endif
    </h5>

    <div class="list-group list-group-flush shadow-sm rounded-4 overflow-hidden bg-white">
        
        {{-- Listado para Alumnos: Asesorías Tomadas --}}
        @if($user->id_rol == 3 || $user->id_rol == 1)
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
                @if($user->id_rol == 3)
                <div class="list-group-item text-center py-4 text-muted border-0">
                    No has tomado asesorías aún.
                </div>
                @endif
            @endforelse
        @endif

        {{-- Listado para Expertos: Asesorías Dadas --}}
        @if($user->id_rol == 2 || $user->id_rol == 1)
            @foreach($asesorias_dadas as $item)
                <div class="list-group-item list-group-item-action border-0 py-3">
                    <div class="d-flex w-100 justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="bg-success bg-opacity-10 text-success rounded-3 p-2 me-3">
                                <i class="fas fa-arrow-up small"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold">{{ $item->materia }}</h6>
                                <small class="text-muted">A: {{ $item->alumno->name ?? 'Disponible' }}</small>
                            </div>
                        </div>
                        <span class="text-success fw-bold">+1 pt</span>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    {{-- Botón de Salida --}}
    <div class="mt-4 px-2">
        <a href="{{ route('logout') }}" class="btn btn-outline-danger w-100 rounded-pill fw-bold py-2 shadow-sm"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt me-2"></i> Cerrar Sesión
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
</div>

<style>
    .uppercase { text-transform: uppercase; letter-spacing: 1px; }
    .list-group-item { border-bottom: 1px solid #f8f9fa !important; }
    .list-group-item:last-child { border-bottom: 0 !important; }
</style>
@endsection