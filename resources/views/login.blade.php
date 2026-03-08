<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistema de Asesorías</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #0d6efd;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-card {
            border-radius: 30px;
            padding: 40px;
        }

        .btn-rounded {
            border-radius: 50px;
        }

        .login-image {
            width: 130px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="card login-card shadow">
                <div class="card-body text-center">
                    <img src="{{ asset('imagenes/portada.png') }}" class="login-image" alt="Logo">

                    <h4 class="mb-4">Bienvenido al Sistema</h4>

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="/login">
                        @csrf

                        <div class="mb-3 text-start">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="mb-3 text-start">
                            <label>Contraseña</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 btn-rounded">
                            Iniciar Sesión
                        </button>
                    </form>

                    <hr>

                    <button class="btn btn-outline-primary w-100 btn-rounded">
                        Registrarse
                    </button>

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>