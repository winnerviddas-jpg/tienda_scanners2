@extends('layouts.app')

@section('contenido')
<div class="container" style="margin-top: 50px; margin-bottom: 50px;">
    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
        <div>
            <h1 class="fw-bold text-dark mb-0">GESTIÓN DE CLIENTES REGISTRADOS</h1>
            <p class="text-muted">Lista de clientes obtenidos desde la base de datos</p>
        </div>
        <a href="{{ route('logout') }}" class="btn btn-danger fw-bold shadow-sm">
            <i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success text-center fw-bold shadow-sm mb-4">
            {!! session('success') !!}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger text-center fw-bold shadow-sm mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="card shadow-sm border-0" style="border-radius: 15px;">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Correo Electrónico</th>
                            <th>Fecha de Registro</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($clientes as $cliente)
                        <tr>
                            <td>{{ $cliente->id }}</td>
                            <td class="fw-bold">{{ $cliente->name }}</td>
                            <td>{{ $cliente->email }}</td>
                            <td>{{ $cliente->created_at ?? 'No registrada' }}</td>
                            <td class="text-center">
                                <form action="{{ route('admin.clients.reset-password', $cliente->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de generar una nueva contraseña temporal para {{ $cliente->name }}?');">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-warning btn-sm fw-bold shadow-sm">
                                        <i class="fas fa-key me-1"></i> Resetear Contraseña
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">No hay clientes registrados en la base de datos.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection