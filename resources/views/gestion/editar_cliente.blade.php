@extends('layouts.app')

@section('contenido')
<div class="container mt-5" style="max-width: 600px; margin-bottom: 50px;">
    <div class="card shadow border-0" style="border-radius: 12px;">
        <div class="card-header bg-warning text-dark text-center fw-bold py-3" style="border-top-left-radius: 12px; border-top-right-radius: 12px;">
            <h4 class="mb-0 fw-bold"><i class="fas fa-edit me-2"></i>EDITAR REGISTRO AUXILIAR</h4>
        </div>
        <div class="card-body p-4">

            <form action="{{ route('cliente.update', $cliente->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nombre" class="form-label fw-bold text-secondary">Nombre / Detalle</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $cliente->nombre }}" required>
                </div>

                <div class="mb-3">
                    <label for="marca" class="form-label fw-bold text-secondary">Marca</label>
                    <input type="text" class="form-control" id="marca" name="marca" value="{{ $cliente->marca }}" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="precio" class="form-label fw-bold text-secondary">Precio (Bs.)</label>
                        <input type="number" step="0.01" class="form-control" id="precio" name="precio" value="{{ $cliente->precio }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="stock" class="form-label fw-bold text-secondary">Stock</label>
                        <input type="number" class="form-control" id="stock" name="stock" value="{{ $cliente->stock }}" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="descripcion" class="form-label fw-bold text-secondary">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required>{{ $cliente->descripcion }}</textarea>
                </div>

                <div class="d-flex gap-3 pt-2">
                    <a href="{{ route('gestion.clientes') }}" class="btn btn-secondary w-50 fw-bold">
                        <i class="fas fa-arrow-left me-1"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-warning text-dark w-50 fw-bold">
                        <i class="fas fa-save me-1"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection