<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Trueque-Tec | Sistema de Asesorías</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="apple-touch-icon" href="/logo-trueque.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        body { background-color: #f4f7fb; }
        .sidebar {
            height: 100vh; width: 250px; position: fixed;
            top: 0; left: -250px;
            background: linear-gradient(180deg, #0d6efd, #084298);
            transition: 0.3s; padding-top: 60px; z-index: 1000;
        }
        .sidebar a {
            padding: 15px; text-decoration: none;
            font-size: 16px; color: white; display: block;
        }
        .sidebar a:hover, .sidebar a.active { background-color: rgba(255,255,255,0.2); } /* Mejora visual */
        .sidebar.active { left: 0; }
        .content { transition: margin-left 0.3s; padding: 25px; }
        .content.shift { margin-left: 250px; }
        .navbar-custom { background: linear-gradient(90deg, #0d6efd, #0a58ca); }
        .btn-rounded { border-radius: 50px; }

        @media (max-width: 768px) {
            .content { padding: 15px; }
            .btn { padding: 10px; } 
            .navbar-brand { font-size: 1.2rem; }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-dark navbar-custom px-3 shadow-sm">
    @auth
        <button id="menuBtn" class="btn btn-light btn-sm" onclick="toggleSidebar()">☰</button>
    @endauth
    <span class="navbar-brand ms-3 fw-bold">Trueque-Tec</span>

    <div class="ms-auto text-white d-flex align-items-center">
        @auth
            <span class="me-2 d-none d-sm-inline"><i class="fas fa-user-circle"></i> {{ Auth::user()->name }}</span>
            
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm btn-light btn-rounded fw-bold shadow-sm">
                    <i class="fas fa-sign-out-alt"></i> Salir
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" class="btn btn-sm btn-light btn-rounded px-3">Entrar</a>
        @endauth
    </div>
</nav>

<div id="sidebar" class="sidebar shadow">
    @auth
        <a href="{{ route('perfil.index') }}" class="{{ request()->routeIs('perfil.index') ? 'active' : '' }}">
            <i class="fas fa-id-card me-2"></i> Mi Perfil
        </a>
        <hr class="text-white-50 mx-3">

        @if(Auth::user()->id_rol == 1)
            <a href="{{ route('asesorias.index') }}"><i class="fas fa-list me-2"></i> Todas las Asesorías</a>
            <a href="{{ route('admin.users.index') }}"><i class="fas fa-user-shield me-2"></i> Panel Admin</a>
        @endif

        @if(Auth::user()->id_rol == 2)
            <a href="{{ route('asesorias.index') }}"><i class="fas fa-chalkboard-teacher me-2"></i> Mis Asesorías</a>
            <a href="{{ route('asesorias.create') }}"><i class="fas fa-plus-circle me-2"></i> Crear Asesoría</a>
        @endif

        @if(Auth::user()->id_rol == 3)
            <a href="{{ route('asesorias.index') }}" class="{{ request()->routeIs('asesorias.index') ? 'active' : '' }}">
                <i class="fas fa-book me-2"></i> Ver Asesorías
            </a>
            
            <a href="{{ route('expertos.index') }}" class="{{ request()->routeIs('expertos.index') ? 'active' : '' }}">
                <i class="fas fa-graduation-cap me-2"></i> Expertos
            </a>

            <div class="p-3 mt-auto text-white-50 border-top">
                <small><i class="fas fa-coins text-warning"></i> Saldo: {{ Auth::user()->puntos }} pts</small>
            </div>
        @endif
    @endauth
</div>

<div id="content" class="content">
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function toggleSidebar() {
        document.getElementById("sidebar").classList.toggle("active");
        document.getElementById("content").classList.toggle("shift");
    }

    document.addEventListener('click', function(event) {
        var sidebar = document.getElementById('sidebar');
        var menuBtn = document.getElementById('menuBtn');
        if (window.innerWidth < 768 && 
            sidebar.classList.contains('active') && 
            !sidebar.contains(event.target) && 
            event.target !== menuBtn) {
            toggleSidebar();
        }
    });
</script>

</body>
</html>