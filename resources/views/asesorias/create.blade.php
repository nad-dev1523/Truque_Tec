@extends('layouts.app')

@section('content')
<div class="container py-4" style="max-width: 600px;">
    <div class="card border-0 shadow-sm rounded-4 p-4">
        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('asesorias.index') }}" class="btn btn-light rounded-circle me-3 shadow-sm">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h2 class="fw-bold text-primary mb-0">Programar Asesoría</h2>
        </div>

        <form action="{{ route('asesorias.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label class="form-label fw-bold">Materia</label>
                <input type="text" name="materia" class="form-control rounded-pill px-3 @error('materia') is-invalid @enderror" 
                       placeholder="Ej. Estructura de Datos" value="{{ old('materia') }}" required>
                @error('materia')
                    <div class="invalid-feedback ms-3">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-6 mb-3">
                    <label class="form-label fw-bold">Fecha</label>
                    <input type="date" name="fecha" class="form-control rounded-pill px-3 @error('fecha') is-invalid @enderror" 
                           min="{{ date('Y-m-d') }}" value="{{ old('fecha') }}" required>
                    @error('fecha')
                        <div class="invalid-feedback ms-3">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label fw-bold">Lugar (UTVT)</label>
                    <select name="id_lugar" class="form-select rounded-pill px-3 @error('id_lugar') is-invalid @enderror" required>
                        <option value="" disabled {{ old('id_lugar') ? '' : 'selected' }}>Seleccionar...</option>
                        @foreach($lugares as $lugar)
                            <option value="{{ $lugar->id_lugar }}" {{ old('id_lugar') == $lugar->id_lugar ? 'selected' : '' }}>
                                {{ $lugar->nombre_lugar }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_lugar')
                        <div class="invalid-feedback ms-3">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-6 mb-3">
                    <label class="form-label fw-bold">Hora Inicio</label>
                    <input type="time" name="hora_ini" class="form-control rounded-pill px-3 @error('hora_ini') is-invalid @enderror" 
                           value="{{ old('hora_ini') }}" required>
                    @error('hora_ini')
                        <div class="invalid-feedback ms-3">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label fw-bold">Hora Fin</label>
                    <input type="time" name="hora_fin" class="form-control rounded-pill px-3 @error('hora_fin') is-invalid @enderror" 
                           value="{{ old('hora_fin') }}" required>
                    @error('hora_fin')
                        <div class="invalid-feedback ms-3">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Descripción / Temas</label>
                <textarea name="descripcion" class="form-control rounded-4 px-3 @error('descripcion') is-invalid @enderror" rows="3" 
                          placeholder="¿Qué temas se revisarán en la sesión?" required>{{ old('descripcion') }}</textarea>
                @error('descripcion')
                    <div class="invalid-feedback ms-3">{{ $message }}</div>
                @enderror
            </div>
            
            <button type="submit" class="btn btn-primary w-100 rounded-pill py-3 fw-bold shadow">
                <i class="fas fa-paper-plane me-2"></i> Publicar Asesoría
            </button>
        </form>
    </div>
</div>
@endsection