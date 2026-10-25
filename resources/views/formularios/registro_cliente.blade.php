@extends('layouts.app')

@section('contenido')
<div class="container mt-5" style="max-width: 600px; margin-bottom: 50px;">
    <div class="card shadow border-0" style="border-radius: 12px;">
        <div class="card-header bg-success text-white text-center fw-bold py-3" style="border-top-left-radius: 12px; border-top-right-radius: 12px;">
            <h4 class="mb-0 fw-bold"><i class="fas fa-plus-circle me-2"></i>NUEVO REGISTRO AUXILIAR</h4>
        </div>
        <div class="card-body p-4">

            <form action="{{ route('cliente.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="nombre" class="form-label fw-bold text-secondary">Nombre / Detalle</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>

                <div class="mb-3">
                    <label for="marca" class="form-label fw-bold text-secondary">Marca</label>
                    <input type="text" class="form-control" id="marca" name="marca" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="precio" class="form-label fw-bold text-secondary">Precio (Bs.)</label>
                        <input type="number" step="0.01" class="form-control" id="precio" name="precio" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="stock" class="form-label fw-bold text-secondary">Stock Inicial</label>
                        <input type="number" class="form-control" id="stock" name="stock" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="descripcion" class="form-label fw-bold text-secondary">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
                </div>

                <div class="d-flex gap-3 pt-2">
                    <a href="{{ route('gestion.clientes') }}" class="btn btn-secondary w-50 fw-bold">
                        <i class="fas fa-arrow-left me-1"></i> Volver
                    </a>
                    <button type="submit" class="btn btn-success w-50 fw-bold">
                        <i class="fas fa-save me-1"></i> Guardar Registro
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection