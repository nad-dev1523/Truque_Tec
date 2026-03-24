@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 px-2">
        <div>
            <h2 class="fw-bold text-dark mb-0">Banco de Tiempo</h2>
            <p class="text-muted">Explora y únete a las asesorías disponibles</p>
        </div>
        @if(Auth::user()->id_rol == 2)
            <a href="{{ route('asesorias.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                <i class="fas fa-plus me-2"></i> Crear Nueva
            </a>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm border-0 mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm border-0 mb-4" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        @forelse($asesorias as $asesoria)
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 transition-hover">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <span class="badge rounded-pill {{ $asesoria->estado == 'Disponible' ? 'bg-success-subtle text-success' : ($asesoria->estado == 'Ocupada' ? 'bg-primary-subtle text-primary' : 'bg-warning-subtle text-warning') }} px-3 py-2">
                                <i class="fas {{ $asesoria->estado == 'Disponible' ? 'fa-check-circle' : ($asesoria->estado == 'Ocupada' ? 'fa-users' : 'fa-clock') }} me-1"></i>
                                {{ $asesoria->estado }}
                            </span>
                            <div class="text-primary fw-bold">
                                <i class="fas fa-coins me-1 text-warning"></i> 1 pt
                            </div>
                        </div>

                        <h4 class="fw-bold mb-2 text-dark">{{ $asesoria->materia }}</h4>
                        <p class="text-muted small mb-3 text-truncate-2">{{ $asesoria->descripcion }}</p>

                        <div class="bg-light rounded-3 p-3 mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-user-tie text-primary me-3" style="width: 15px;"></i>
                                <span class="small"><strong>Experto:</strong> {{ $asesoria->experto->name ?? 'Por asignar' }}</span>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-calendar-alt text-primary me-3" style="width: 15px;"></i>
                                <span class="small">{{ \Carbon\Carbon::parse($asesoria->fecha)->format('d M, Y') }}</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-map-marker-alt text-primary me-3" style="width: 15px;"></i>
                                <span class="small">{{ $asesoria->lugar->nombre_lugar ?? 'Por definir' }}</span>
                            </div>
                        </div>

                        {{-- SECCIÓN DE BOTONES ACTUALIZADA --}}
                        @if($asesoria->estado == 'Disponible' && Auth::user()->id_rol == 3)
                            {{-- Botón para que el Alumno solicite el trueque --}}
                            <form action="{{ route('asesorias.unirse', $asesoria->id_asesoria) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-primary w-100 rounded-pill fw-bold py-2 shadow-sm"
                                        onclick="return confirm('¿Seguro que quieres usar 1 punto para esta asesoría?')">
                                    <i class="fas fa-handshake me-2"></i> Solicitar Trueque
                                </button>
                            </form>
                            
                        @elseif($asesoria->estado == 'Ocupada' && Auth::user()->id_rol == 2 && $asesoria->id_experto == Auth::id())
                            {{-- NUEVO: Botón para que el Experto finalice la sesión y se repartan los puntos --}}
                            <form action="{{ route('asesorias.finalizar', $asesoria->id_asesoria) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success w-100 rounded-pill fw-bold py-2 shadow-sm"
                                        onclick="return confirm('¿Confirmas que la asesoría terminó? Se enviarán los 2 puntos al alumno y 1 punto a ti.')">
                                    <i class="fas fa-check-circle me-2"></i> Asesoría Terminada
                                </button>
                            </form>

                        @elseif($asesoria->id_alumno == Auth::id())
                            {{-- Botón deshabilitado si el alumno ya se unió --}}
                            <button class="btn btn-secondary w-100 rounded-pill fw-bold py-2 disabled shadow-sm">
                                <i class="fas fa-user-check me-2"></i> Ya eres parte
                            </button>
                        @else
                            {{-- Botón por defecto si está ocupada por otra persona o finalizada --}}
                           <button class="btn btn-light w-100 rounded-pill fw-bold py-2 disabled border">
                                <i class="fas fa-lock me-2"></i> No disponible
                            </button>
                        @endif

                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="mb-3">
                    <i class="fas fa-search fa-4x text-light"></i>
                </div>
                <h5 class="text-muted">No hay asesorías disponibles por ahora.</h5>
                <p class="text-muted small">Vuelve más tarde para ver nuevas publicaciones.</p>
            </div>
        @endforelse
    </div>
</div>

<style>
    .transition-hover {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }
    .transition-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,.1) !important;
    }
    .text-truncate-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;  
        overflow: hidden;
    }
    .bg-success-subtle { background-color: #d1e7dd; }
    .bg-warning-subtle { background-color: #fff3cd; }
    .bg-primary-subtle { background-color: #cfe2ff; }
</style>
@endsection