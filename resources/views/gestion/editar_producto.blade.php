@extends('layouts.app')

@section('contenido')
<div class="container mt-5" style="max-width: 600px; margin-bottom: 50px;">
    <div class="card shadow border-0" style="border-radius: 12px;">
        <div class="card-header bg-warning text-dark text-center fw-bold py-3" style="border-top-left-radius: 12px; border-top-right-radius: 12px;">
            <h4 class="mb-0 fw-bold"><i class="fas fa-edit me-2"></i>EDITAR REGISTRO DE EQUIPO</h4>
        </div>
        <div class="card-body p-4">
            
            @if ($errors->any())
                <div class="alert alert-danger shadow-sm">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li class="fw-bold">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('producto.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nombre" class="form-label fw-bold text-secondary">Nombre del Equipo / Producto</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', $product->nombre) }}" required>
                </div>

                <div class="mb-3">
                    <label for="marca" class="form-label fw-bold text-secondary">Marca</label>
                    <input type="text" class="form-control" id="marca" name="marca" value="{{ old('marca', $product->marca) }}" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="precio" class="form-label fw-bold text-secondary">Precio (en Bs.)</label>
                        <div class="input-group">
                            <input type="number" step="0.01" class="form-control" id="precio" name="precio" value="{{ old('precio', $product->precio) }}" required>
                            <span class="input-group-text fw-bold">Bs.</span>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="stock" class="form-label fw-bold text-secondary">Stock / Cantidad</label>
                        <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" min="0" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label fw-bold text-secondary">Descripción / Especificaciones</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required>{{ old('descripcion', $product->descripcion) }}</textarea>
                </div>

                <div class="mb-3 text-center">
                    <label class="form-label d-block fw-bold text-secondary mb-2">Imagen Actual</label>
                    <img src="{{ asset($product->imagen) }}" class="img-thumbnail" style="max-height: 150px; object-fit: contain;">
                </div>

                <div class="mb-4">
                    <label for="imagen" class="form-label fw-bold text-secondary">Cambiar Imagen (Opcional)</label>
                    <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
                    <div class="form-text text-muted">Formatos permitidos: jpeg, png, jpg. Máx: 2MB.</div>
                </div>

                <div class="d-flex gap-3 pt-2">
                    <a href="{{ route('gestion.productos') }}" class="btn btn-secondary w-50 fw-bold">
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