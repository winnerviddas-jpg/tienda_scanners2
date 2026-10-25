@extends('layouts.app')

@section('contenido')
<div class="container mt-5">
    <div class="text-center mb-4">
        <h2 class="fw-bold text-success">PANEL DE CONTROL DE REGISTROS SECUNDARIOS</h2>
        <p class="badge bg-info text-dark">Acceso Técnico: David</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show text-center fw-bold shadow-sm mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex justify-content-center mb-4">
        <a href="{{ route('cliente.create') }}" class="btn btn-dark shadow-sm">
            <i class="fas fa-plus-circle me-1"></i> Agregar Nuevo Registro
        </a>
    </div>

    <div class="card shadow border-0" style="border-radius: 12px;">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="ps-4">ID</th>
                        <th>Nombre / Detalle</th>
                        <th>Marca</th>
                        <th>Precio (Bs.)</th>
                        <th>Descripción</th>
                        <th>Stock</th>
                        <th class="text-center pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clientes as $cliente)
                    <tr>
                        <td class="ps-4 fw-bold">{{ $cliente->id }}</td>
                        <td>{{ $cliente->nombre }}</td>
                        <td>{{ $cliente->marca }}</td>
                        <td>{{ number_format($cliente->precio, 2) }} Bs.</td>
                        <td>{{ $cliente->descripcion }}</td>
                        <td>{{ $cliente->stock }} u.</td>
                        <td class="text-center pe-4">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('cliente.edit', $cliente->id) }}" class="btn btn-sm btn-warning text-dark fw-bold">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <form action="{{ route('cliente.destroy', $cliente->id) }}" method="POST" onsubmit="return confirm('¿Eliminar este registro definitivamente?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger fw-bold">
                                        <i class="fas fa-trash-alt"></i> Borrar
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted fw-bold">No hay registros disponibles en este momento.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection