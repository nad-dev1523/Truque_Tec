@extends('layouts.app')

@section('content')

<h2 class="mb-4">Crear Asesoría</h2>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card card-custom shadow-sm p-4">

<form action="{{ route('asesorias.store') }}" method="POST">
@csrf

<div class="mb-3">
    <label>Materia</label>
    <input type="text" name="materia" class="form-control">
</div>

<div class="mb-3">
    <label>Experto</label>
    <select name="experto_id" class="form-control">
        @foreach($expertos as $experto)
            <option value="{{ $experto->id }}">{{ $experto->name }}</option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label>Alumno</label>
    <select name="alumno_id" class="form-control">
        @foreach($alumnos as $alumno)
            <option value="{{ $alumno->id }}">{{ $alumno->name }}</option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label>Fecha</label>
    <input type="date" name="fecha" class="form-control">
</div>

<div class="mb-3">
    <label>Descripción</label>
    <textarea name="descripcion" class="form-control"></textarea>
</div>

<button class="btn btn-primary btn-rounded">Guardar</button>

</form>
</div>

@endsection