@extends('layouts.app')

@section('content')

<h2 class="mb-4">Panel de Administrador</h2>

<div class="row">
    @foreach($users as $user)
    @if($user->id_rol == 3)
    <a href="/hacer-experto/{{ $user->id }}" 
       class="btn btn-sm btn-success btn-rounded mt-2">
        Hacer Experto
    </a>
@endif
        <div class="col-md-4 mb-4">
            <div class="card card-custom shadow-sm">
                <div class="card-body">
                    <h5>{{ $user->name }}</h5>
                    <p>{{ $user->email }}</p>
                    <span class="badge bg-primary">
                        Rol: {{ $user->id_rol }}
                    </span>
                </div>
            </div>
        </div>
    @endforeach
</div>

@endsection