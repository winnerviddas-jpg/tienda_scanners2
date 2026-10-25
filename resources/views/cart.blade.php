@extends('layouts.app')

@section('contenido')
<div class="container" style="margin-top: 50px; margin-bottom: 50px;">
    <div class="row">
        <div class="col-12">
            <h2 class="fw-bold text-primary mb-4"><i class="fas fa-shopping-cart me-2"></i>CARRITO DE COMPRAS</h2>
            
            @if(session('success'))
                <div class="alert alert-success text-center fw-bold shadow-sm mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(count($cartItems) > 0)
                <div class="card shadow-sm border-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col" class="ps-4">Equipo</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col" class="text-center">Precio</th>
                                    <th scope="col" class="text-center">Cantidad</th>
                                    <th scope="col" class="text-center">Subtotal</th>
                                    <th scope="col" class="text-end pe-4">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cartItems as $id => $item)
                                    <tr>
                                        <td class="ps-4">
                                            <img src="{{ asset($item['imagen']) }}" alt="{{ $item['nombre'] }}" style="width: 60px; height: 60px; object-fit: contain;">
                                        </td>
                                        <td>
                                            <span class="fw-bold">{{ $item['nombre'] }}</span>
                                        </td>
                                        <td class="text-center">{{ number_format($item['precio'], 2) }} Bs.</td>
                                        <td class="text-center">
                                            <span class="badge bg-secondary p-2">{{ $item['cantidad'] }}</span>
                                        </td>
                                        <td class="text-center fw-bold text-primary">
                                            {{ number_format($item['precio'] * $item['cantidad'], 2) }} Bs.
                                        </td>
                                        <td class="text-end pe-4">
                                            <form action="{{ route('cart.remove') }}" method="POST">
                                                @csrf
                                                <input type="hidden" value="{{ $id }}" name="id">
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash-alt"></i> Quitar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('welcome') }}" class="btn btn-outline-dark fw-bold">
                        <i class="fas fa-arrow-left me-2"></i>Seguir Comprando
                    </a>
                    <div class="text-end">
                        <h4 class="fw-bold">Total a Pagar: 
                            {{ number_format(array_sum(array_map(function($item) { return $item['precio'] * $item['cantidad']; }, $cartItems)), 2) }} Bs.
                        </h4>
                        <button class="btn btn-success btn-lg px-5 fw-bold shadow">PROCESAR PEDIDO</button>
                    </div>
                </div>
            @else
                <div class="alert alert-light text-center border p-5 shadow-sm" style="border-radius: 15px;">
                    <i class="fas fa-shopping-cart fa-4x text-muted mb-3"></i>
                    <h4 class="fw-bold">Tu carrito está vacío</h4>
                    <p class="text-muted">Aún no has agregado ningún scanner o cable de diagnóstico al carrito.</p>
                    
                    <a href="{{ route('welcome') }}" class="btn btn-primary btn-lg mt-2 fw-bold shadow-sm">
                        Ir al Catálogo de Equipos
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection