@extends('layouts.app')

@section('content')
<div class="container py-4" style="max-width: 600px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center">
            <a href="{{ route('asesorias.index') }}" class="btn btn-light rounded-circle shadow-sm me-3 text-primary">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h2 class="fw-bold mb-0 text-dark">Editar Asesoría</h2>
        </div>
        <div class="bg-primary text-white px-3 py-2 rounded-pill shadow-sm">
            <i class="fas fa-coins me-1"></i> 
            <span class="fw-bold">{{ Auth::user()->puntos }} pts</span>
        </div>
    </div>

    <div class="alert alert-info border-0 shadow-sm rounded-4 mb-4 small">
        <i class="fas fa-info-circle me-2"></i>
        Recuerda que al marcar una asesoría como <strong>Finalizada</strong>, el sistema confirmará el intercambio de tiempo en el <strong>TimeBankService</strong>.
    </div>

    <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
        <div class="card-body p-4">
            <form action="{{ route('asesorias.update', $asesoria->id_asesoria) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-bold text-muted small uppercase">Materia</label>
                    <input type="text" name="materia" class="form-control form-control-lg rounded-3 bg-light border-0" 
                           value="{{ old('materia', $asesoria->materia) }}" placeholder="Nombre de la materia" required>
                </div>

                <div class="row">
                    <div class="col-6 mb-3">
                        <label class="form-label fw-bold text-muted small uppercase">Fecha</label>
                        <input type="date" name="fecha" class="form-control rounded-3 bg-light border-0" 
                               value="{{ old('fecha', $asesoria->fecha) }}" required>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label fw-bold text-muted small uppercase">Lugar</label>
                        <select name="id_lugar" class="form-select rounded-3 bg-light border-0" required>
                            @foreach($lugares as $lugar)
                                <option value="{{ $lugar->id_lugar }}" {{ $asesoria->id_lugar == $lugar->id_lugar ? 'selected' : '' }}>
                                    {{ $lugar->nombre_lugar }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6 mb-3">
                        <label class="form-label fw-bold text-muted small uppercase">Hora Inicio</label>
                        <input type="time" name="hora_ini" class="form-control rounded-3 bg-light border-0" 
                               value="{{ old('hora_ini', $asesoria->hora_ini) }}" required>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label fw-bold text-muted small uppercase">Hora Fin</label>
                        <input type="time" name="hora_fin" class="form-control rounded-3 bg-light border-0" 
                               value="{{ old('hora_fin', $asesoria->hora_fin) }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold text-muted small uppercase">Estado de la Asesoría</label>
                    <select name="estado" class="form-select rounded-3 bg-light border-0 fw-bold">
                        <option value="Pendiente" {{ $asesoria->estado == 'Pendiente' ? 'selected' : '' }}>🟡 Pendiente</option>
                        <option value="Disponible" {{ $asesoria->estado == 'Disponible' ? 'selected' : '' }}>🟢 Disponible</option>
                        <option value="Ocupada" {{ $asesoria->estado == 'Ocupada' ? 'selected' : '' }}>🔴 Ocupada</option>
                        <option value="Finalizada" {{ $asesoria->estado == 'Finalizada' ? 'selected' : '' }}>✔️ Finalizada</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold text-muted small uppercase">Descripción / Detalles</label>
                    <textarea name="descripcion" class="form-control rounded-3 bg-light border-0" rows="3">{{ old('descripcion', $asesoria->descripcion) }}</textarea>
                </div>

                <input type="hidden" name="id_experto" value="{{ $asesoria->id_experto }}">
                <input type="hidden" name="id_alumno" value="{{ $asesoria->id_alumno }}">

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold shadow">
                        Actualizar Cambios
                    </button>
                    <a href="{{ route('asesorias.index') }}" class="btn btn-link text-muted text-decoration-none small text-center">
                        Cancelar y volver
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    body { background-color: #f4f7f6; }
    .form-control:focus, .form-select:focus {
        background-color: #fff !important;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
        border: 1px solid #0d6efd !important;
    }
    .uppercase { text-transform: uppercase; letter-spacing: 1px; font-size: 0.7rem; }
    .rounded-4 { border-radius: 1.2rem !important; }
</style>
@endsection