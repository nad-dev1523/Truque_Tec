@extends('layouts.app')

@section('content')

<h2 class="mb-4">Listado de Asesorías</h2>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(Auth::user()->id_rol != 3)
    <a href="{{ route('asesorias.create') }}" class="btn btn-primary btn-rounded mb-4">
        + Crear Asesoría
    </a>
@endif

<div class="row">
@forelse($asesorias as $asesoria)

    <div class="col-md-4 mb-4">
        <div class="card card-custom shadow-sm">
            <div class="card-body">
                <h5>{{ $asesoria->materia }}</h5>
                <p><strong>Experto:</strong> {{ $asesoria->experto->name }}</p>
                <p><strong>Alumno:</strong> {{ $asesoria->alumno->name }}</p>
                <p><strong>Fecha:</strong> {{ $asesoria->fecha }}</p>
                <span class="badge bg-info text-dark">
                    {{ $asesoria->estado }}
                </span>

                <div class="mt-3">
                    @if(Auth::user()->id_rol == 1 || 
                       (Auth::user()->id_rol == 2 && Auth::id() == $asesoria->experto_id))
                        <a href="{{ route('asesorias.edit', $asesoria->id) }}" 
                           class="btn btn-sm btn-warning btn-rounded">
                            Editar
                        </a>
                    @endif

                    @if(Auth::user()->id_rol == 1)
                        <form action="{{ route('asesorias.destroy', $asesoria->id) }}" 
                              method="POST" 
                              style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger btn-rounded"
                                    onclick="return confirm('¿Eliminar asesoría?')">
                                Eliminar
                            </button>
                        </form>
                    @endif
                    @if(Auth::user()->id_rol == 3)
                        <button class="btn btn-sm btn-success btn-rounded">
                            Unirse
                        </button>
                    @endif

                </div>
            </div>
        </div>
    </div>

@empty
    <p>No hay asesorías registradas.</p>
@endforelse
</div>

@endsection