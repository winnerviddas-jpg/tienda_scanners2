@extends('layouts.app')
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@section('contenido')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow border-0">
                <div class="card-header bg-success text-white text-center">
                    <h4 class="mb-0">Registrar Venta</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('venta.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nombre del Cliente</label>
                            <input type="text" name="cliente" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">C.I. / NIT</label>
                            <input type="text" name="documento" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Producto Vendido</label>
                            <input type="text" name="producto" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Monto Total (Bs.)</label>
                            <input type="number" name="monto" class="form-control" step="0.01" required>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success">Registrar Venta</button>
                            <a href="{{ route('mostrar.productos') }}" class="btn btn-secondary">Volver</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection