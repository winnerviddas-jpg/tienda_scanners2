@extends('layouts.app')

@section('estilos_especificos')
<style>
    .hero-section {
        background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), 
                    url("{{ asset('img/portada.jpg') }}"); /* Mantiene la imagen de tu camión */
        background-size: cover;
        background-position: center;
        height: 700px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-align: center;
    }
    html {
        scroll-behavior: smooth;
    }
</style>
@endsection

@section('contenido')

<header class="hero-section">
    <div class="container">
        <h1 class="display-3 fw-bold">Expertos en Diagnóstico</h1>
        <p class="lead">Equipos profesionales para el mantenimiento automotriz.</p>
        
        <a href="#seccion-productos" class="btn btn-primary btn-lg shadow me-2">
            Explorar Equipos
        </a>

        <form action="{{ route('login.equipos') }}" method="GET" style="display: inline-block;">
            <button type="submit" class="btn btn-warning btn-lg shadow fw-bold">
                <i class="fas fa-tools me-1"></i> Técnico
            </button>
        </form>
    </div>
</header>

<div class="container mt-5" id="seccion-productos">
    <div class="text-center mb-4">
        <h2 class="fw-bold text-primary">CATÁLOGO DE EQUIPOS DISPONIBLES</h2>
        <p class="text-muted">Visualiza nuestros productos de diagnóstico automotriz de manera libre</p>
    </div>

    @if(session('info'))
        <div class="alert alert-warning text-center fw-bold shadow-sm mb-4">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('info') }}
        </div>
    @endif

    <div class="row">
        @foreach($products as $product)
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="text-center p-3">
                    <img src="{{ asset($product->imagen) }}" class="card-img-top" style="height: 200px; object-fit: contain;">
                </div>
                <div class="card-body text-center">
                    <h5 class="card-title fw-bold">{{ $product->nombre }}</h5>
                    <h3 class="text-primary fw-bold">{{ number_format($product->precio, 2) }} Bs.</h3>
                </div>
                <div class="card-footer bg-white border-top-0 pb-4">
                    <form action="{{ route('cart.store') }}" method="POST">
                        @csrf
                        <input type="hidden" value="{{ $product->id }}" name="id">
                        <button type="submit" class="btn btn-success w-100 fw-bold">
                            <i class="fas fa-shopping-cart"></i> Agregar al Carrito
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection