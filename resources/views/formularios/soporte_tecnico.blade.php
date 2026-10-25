@extends('layouts.app')

@section('contenido')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow border-0">
                <div class="card-header bg-dark text-white text-center">
                    <h4 class="mb-0">Soporte Técnico</h4>
                </div>
                <div class="card-body p-4">
                    <form action="#" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nombre del Técnico / Cliente</label>
                            <input type="text" name="nombre" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Correo de Contacto</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Modelo de Camión / Motor</label>
                            <input type="text" name="modelo" class="form-control" placeholder="Ej: Volvo FH12 / Motor D13" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Descripción del Problema</label>
                            <textarea name="problema" class="form-control" rows="4" required></textarea>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-dark">Enviar Consulta</button>
                            <a href="{{ route('mostrar.productos') }}" class="btn btn-secondary">Volver</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection