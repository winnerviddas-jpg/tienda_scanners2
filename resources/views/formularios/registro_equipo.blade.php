@extends('layouts.app')

@section('contenido')
<div class="container mt-5" style="max-width: 600px; margin-bottom: 50px;">
    <div class="card shadow border-0" style="border-radius: 12px;">
        <div class="card-header bg-dark text-white text-center fw-bold py-3" style="border-top-left-radius: 12px; border-top-right-radius: 12px;">
            <h4 class="mb-0 fw-bold"><i class="fas fa-plus-circle me-2"></i>REGISTRAR NUEVO EQUIPO</h4>
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

            <form action="{{ route('producto.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="nombre" class="form-label fw-bold text-secondary">Nombre del Equipo / Producto</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ej. Scanner Automotriz" required>
                </div>

                <div class="mb-3">
                    <label for="marca" class="form-label fw-bold text-secondary">Marca</label>
                    <input type="text" class="form-control" id="marca" name="marca" placeholder="Ej. Launch / Autel" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="precio" class="form-label fw-bold text-secondary">Precio (en Bs.)</label>
                        <div class="input-group">
                            <input type="number" step="0.01" class="form-control" id="precio" name="precio" placeholder="0.00" required>
                            <span class="input-group-text fw-bold">Bs.</span>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="stock" class="form-label fw-bold text-secondary">Stock / Cantidad</label>
                        <input type="number" class="form-control" id="stock" name="stock" placeholder="Ej. 10" min="0" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label fw-bold text-secondary">Descripción / Especificaciones</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3" placeholder="Ej. Soporta protocolo OBD2 y lectura de códigos de falla..." required></textarea>
                </div>

                <div class="mb-4">
                    <label for="imagen" class="form-label fw-bold text-secondary">Imagen del Producto</label>
                    <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*" required>
                    <div class="form-text text-muted">Formatos permitidos: jpeg, png, jpg. Máx: 2MB.</div>
                </div>

                <div class="d-flex gap-3 pt-2">
                    <a href="{{ route('gestion.productos') }}" class="btn btn-secondary w-50 fw-bold">
                        <i class="fas fa-arrow-left me-1"></i> Volver
                    </a>
                    <button type="submit" class="btn btn-primary w-50 fw-bold">
                        <i class="fas fa-save me-1"></i> Guardar Equipo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection