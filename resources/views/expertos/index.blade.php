@extends('layouts.app') @section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4 fw-bold">Directorio de Expertos</h2>
            <p class="text-muted">Encuentra al compañero ideal para realizar un trueque de conocimientos.</p>
            
            <div class="row">
                @forelse($expertos as $experto)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm border-0" style="border-radius: 15px;">
                            <div class="card-body text-center">
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-3" 
                                     style="width: 80px; height: 80px; font-size: 1.5rem; font-weight: bold;">
                                    {{ substr($experto->name, 0, 1) }}{{ substr(strrchr($experto->name, " "), 1, 1) }}
                                </div>
                                
                                <h5 class="card-title fw-bold">{{ $experto->name }}</h5>
                                <p class="text-primary mb-1">Experto UTVT</p>
                                <p class="small text-muted">Matrícula: {{ $experto->id }}</p>
                                
                                <hr>
                                
                                <div class="d-grid">
                                    <a href="#" class="btn btn-primary btn-sm" style="border-radius: 10px;">
                                        <i class="fas fa-calendar-alt me-2"></i> Solicitar Asesoría
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center mt-5">
                        <i class="fas fa-user-slash fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Aún no hay expertos registrados en la plataforma.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection