<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Asesoría</title>
</head>
<body>

    <h1>Editar Asesoría</h1>

    {{-- Mostrar errores --}}
    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('asesorias.update', $asesoria->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Materia:</label><br>
        <input type="text" name="materia" value="{{ $asesoria->materia }}"><br><br>

        <label>Experto:</label><br>
        <select name="experto_id">
            @foreach($expertos as $experto)
                <option value="{{ $experto->id }}"
                    {{ $asesoria->experto_id == $experto->id ? 'selected' : '' }}>
                    {{ $experto->name }}
                </option>
            @endforeach
        </select><br><br>

        <label>Alumno:</label><br>
        <select name="alumno_id">
            @foreach($alumnos as $alumno)
                <option value="{{ $alumno->id }}"
                    {{ $asesoria->alumno_id == $alumno->id ? 'selected' : '' }}>
                    {{ $alumno->name }}
                </option>
            @endforeach
        </select><br><br>

        <label>Fecha:</label><br>
        <input type="date" name="fecha" value="{{ $asesoria->fecha }}"><br><br>

        <label>Descripción:</label><br>
        <textarea name="descripcion">{{ $asesoria->descripcion }}</textarea><br><br>

        <label>Estado:</label><br>
        <select name="estado">
            <option value="Pendiente" {{ $asesoria->estado == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
            <option value="Aprobada" {{ $asesoria->estado == 'Aprobada' ? 'selected' : '' }}>Aprobada</option>
            <option value="Cancelada" {{ $asesoria->estado == 'Cancelada' ? 'selected' : '' }}>Cancelada</option>
        </select><br><br>

        <button type="submit">Actualizar</button>
    </form>

    <br>
    <a href="{{ route('asesorias.index') }}">Volver al listado</a>

</body>
</html>