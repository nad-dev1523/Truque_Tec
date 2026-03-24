<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Monitor de Asesorías - Trueque-Tec</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <a href="/" class="btn btn-outline-light btn-sm me-2 shadow-sm">
                        <i class="fas fa-home"></i>
                    </a>
                    <i class="fas fa-chalkboard-teacher me-2"></i> Monitor de Trueques
                </h4>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-light btn-sm">Volver a Usuarios</a>
            </div>
            
            <div class="card-body">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tema / Materia</th>
                            <th>Experto (Creador)</th>
                            <th>Lugar</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($asesorias as $asesoria)
                        <tr>
                            <td>{{ $asesoria->id }}</td>
                            <td><strong>{{ $asesoria->titulo }}</strong></td>
                            <td>
                                <i class="fas fa-user-grad me-1 text-secondary"></i> {{ $asesoria->user->name }}
                            </td>
                            <td>{{ $asesoria->lugar->nombre ?? 'No asignado' }}</td>
                            <td>
                                @if($asesoria->estado == 'disponible')
                                    <span class="badge bg-success">Disponible</span>
                                @elseif($asesoria->estado == 'proceso')
                                    <span class="badge bg-warning text-dark">En Proceso</span>
                                @else
                                    <span class="badge bg-secondary">Finalizada</span>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($asesoria->fecha)->format('d/m/Y') }}</td>
                            <td>
                                <form action="{{ route('admin.asesorias.destroy', $asesoria->id) }}" method="POST" onsubmit="return confirm('¿Eliminar esta asesoría permanentemente?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-outline-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                @if($asesorias->isEmpty())
                    <div class="text-center p-4">
                        <h5 class="text-muted">No hay asesorías activas en Trueque-Tec</h5>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>