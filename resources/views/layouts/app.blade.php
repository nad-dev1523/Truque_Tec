<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Asesorías</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f7fb;
        }

        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: -250px;
            background: linear-gradient(180deg, #0d6efd, #084298);
            transition: 0.3s;
            padding-top: 60px;
        }

        .sidebar a {
            padding: 15px;
            text-decoration: none;
            font-size: 16px;
            color: white;
            display: block;
        }

        .sidebar a:hover {
            background-color: rgba(255,255,255,0.2);
        }

        .sidebar.active {
            left: 0;
        }

        .content {
            transition: margin-left 0.3s;
            padding: 25px;
        }

        .content.shift {
            margin-left: 250px;
        }

        .navbar-custom {
            background: linear-gradient(90deg, #0d6efd, #0a58ca);
        }

        .card-custom {
            border-radius: 20px;
        }

        .btn-rounded {
            border-radius: 50px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-dark navbar-custom px-3">
    <button id="menuBtn" class="btn btn-light btn-sm" onclick="toggleSidebar()">☰</button>
    <span class="navbar-brand ms-3">Sistema de Asesorías</span>

    <div class="ms-auto text-white">
        {{ Auth::user()->name }}
        <a href="/logout" class="btn btn-sm btn-light ms-3 btn-rounded">Salir</a>
    </div>
</nav>

<div id="sidebar" class="sidebar">

    {{-- ADMIN --}}
    @if(Auth::user()->id_rol == 1)
        <a href="{{ route('asesorias.index') }}">Todas las Asesorías</a>
        <a href="admin">Inicio</a>
    @endif

    {{-- EXPERTO --}}
    @if(Auth::user()->id_rol == 2)
        <a href="{{ route('asesorias.index') }}">Mis Asesorías</a>
    @endif

    {{-- ALUMNO --}}
    @if(Auth::user()->id_rol == 3)
        <a href="{{ route('asesorias.index') }}">Ver Asesorías</a>
        <a href="#">Expertos</a>
    @endif

</div>

<div id="content" class="content">
    @yield('content')
</div>

<script>
    function toggleSidebar() {
        document.getElementById("sidebar").classList.toggle("active");
        document.getElementById("content").classList.toggle("shift");
}
</script>

</body>
</html>