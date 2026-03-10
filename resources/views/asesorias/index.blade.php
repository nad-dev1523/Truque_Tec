@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">Banco de Tiempo <span class="text-primary">UTVT</span></h2>
        @if(Auth::user()->id_rol == 2)
            <a href="{{ route('asesorias.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                <i class="fas fa-plus me-2"></i> Publicar Asesoría
            </a>
        @endif
    </div>

    <div class="row">
        @foreach($asesorias as $asesoria)
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <span class="badge {{ $asesoria->estado == 'Disponible' ? 'bg-success' : 'bg-secondary' }} rounded-pill px-3">
                            {{ $asesoria->estado }}
                        </span>
                        <h5 class="text-primary fw-bold mb-0">1 Punto</h5>
                    </div>
                    
                    <h4 class="fw-bold mb-2">{{ $asesoria->materia }}</h4>
                    <p class="text-muted small mb-3">
                        <i class="fas fa-user-tie me-2"></i> Experto: {{ $asesoria->experto->name }}
                    </p>
                    
                    <hr class="text-light">
                    
                    <div class="d-flex flex-column gap-2 mb-4">
                        <div class="small text-dark">
                            <i class="far fa-calendar-alt me-2 text-primary"></i> {{ \Carbon\Carbon::parse($asesoria->fecha)->format('d/m/Y') }}
                        </div>
                        <div class="small text-dark">
                            <i class="far fa-clock me-2 text-primary"></i> {{ $asesoria->hora_ini }} - {{ $asesoria->hora_fin }}
                        </div>
                        <div class="small text-dark">
                            <i class="fas fa-map-marker-alt me-2 text-primary"></i> {{ $asesoria->lugar->nombre_lugar ?? 'Por definir' }}
                        </div>
                    </div>

                    @if($asesoria->estado == 'Disponible' && Auth::user()->id_rol == 3)
                        <form action="{{ route('asesorias.unirse', $asesoria->id_asesoria) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-primary w-100 rounded-pill fw-bold">
                                Tomar Asesoría
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection