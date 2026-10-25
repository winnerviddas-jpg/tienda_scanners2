@extends('layouts.app')

@section('contenido')
<div class="container" style="margin-top: 80px;">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow-lg border-primary">
                <div class="card-header bg-primary text-white text-center">
                    <h5 class="mb-0">ACCESO A CATÁLOGO DE SCANNERS</h5>
                </div>
                <div class="card-body p-4">
                    <p class="text-center text-muted small">Ingresa las credenciales técnicas para ver los equipos.</p>
                    
                    @if(session('error'))
                        <div class="alert alert-danger py-2 text-center">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('validar.equipos') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">Usuario Técnico</label>
                            <input type="text" name="usuario" class="form-control" placeholder="" required value="{{ old('usuario') }}">
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold">Contraseña</label>
                            <input type="password" name="password" class="form-control" placeholder="*****" required>
                        </div>
                        <button type="submit" class="btn btn-secondary w-100 fw-bold">
                            VER PRODUCTOS
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection