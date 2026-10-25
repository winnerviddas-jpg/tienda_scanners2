@extends('layouts.app')

@section('contenido')
<div class="container mt-5">
    <div class="text-center mb-4">
        <h2 class="fw-bold text-primary">CATÁLOGO TÉCNICO DE EQUIPOS</h2>
        <p class="badge bg-info text-dark">Acceso Técnico: David</p>
    </div>

    {{-- Alertas del Sistema para Confirmar Acciones --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show text-center fw-bold shadow-sm mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex justify-content-center gap-3 mb-5">
        <a href="{{ route('formulario.equipo') }}" class="btn btn-dark shadow-sm">
            <i class="fas fa-plus-circle me-1"></i> Nuevo Equipo
        </a>
        <a href="{{ route('formulario.venta') }}" class="btn btn-dark shadow-sm">
            <i class="fas fa-file-invoice-dollar me-1"></i> Registrar Venta
        </a>
    </div>

    <div class="row">
        @foreach($products as $product)
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="text-center p-3">
                    <img src="{{ asset($product->imagen) }}" class="card-img-top" style="height: 200px; object-fit: contain;">
                </div>
                <div class="card-body text-center">
                    <h5 class="card-title fw-bold">{{ $product->nombre }}</h5>
                    <p class="text-muted small text-truncate">{{ $product->descripcion }}</p>
                    <h3 class="text-primary fw-bold mb-2">{{ number_format($product->precio, 2) }} Bs.</h3>
                    <span class="badge bg-secondary">Stock: {{ $product->stock }} u.</span>
                </div>
                <div class="card-footer bg-white border-top-0 pb-4">
                    {{-- Formulario de Carrito (Se mantiene intacto) --}}
                    <form action="{{ route('cart.store') }}" method="POST" class="mb-3">
                        @csrf
                        <input type="hidden" value="{{ $product->id }}" name="id">
                        <button type="submit" class="btn btn-success w-100 fw-bold">
                            <i class="fas fa-shopping-cart"></i> Agregar al Carrito
                        </button>
                    </form>

                    {{-- CONTROLADORES DEL CRUD: EDITAR Y ELIMINAR --}}
                    <div class="row g-2">
                        {{-- Botón de Redirección al Formulario de Edición --}}
                        <div class="col-6">
                            <a href="{{ route('producto.edit', $product->id) }}" class="btn btn-warning text-dark fw-bold w-100">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                        </div>

                        {{-- Formulario de Eliminación Segura --}}
                        <div class="col-6">
                            <form action="{{ route('producto.destroy', $product->id) }}" method="POST" onsubmit="return confirm('¿Está completamente seguro de eliminar este producto de la base de datos?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger fw-bold w-100">
                                    <i class="fas fa-trash-alt"></i> Borrar
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection