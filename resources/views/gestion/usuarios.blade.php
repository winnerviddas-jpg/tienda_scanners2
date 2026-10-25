@extends('layouts.app')

@section('contenido')
<div class="container" style="margin-top: 50px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary"><i class="fas fa-users-cog me-2"></i>CRUD 1: GESTIÓN DE USUARIOS</h2>
        <a href="{{ route('tecnico.dashboard') }}" class="btn btn-outline-dark fw-bold"><i class="fas fa-arrow-left me-2"></i>Volver al Panel</a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <span class="fw-bold mb-0">Lista de Personal con Acceso al Sistema</span>
            <button class="btn btn-light btn-sm fw-bold"><i class="fas fa-plus me-1"></i>Nuevo Usuario</button>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Rol Asignado</th>
                        <th>Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td><strong>David Quispe</strong></td>
                        <td><span class="badge bg-info text-dark">Técnico Principal</span></td>
                        <td><span class="badge bg-success">Activo</span></td>
                        <td class="text-end">
                            <button class="btn btn-warning btn-sm me-1"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td><strong>Laura Condori</strong></td>
                        <td><span class="badge bg-secondary">Operador</span></td>
                        <td><span class="badge bg-success">Activo</span></td>
                        <td class="text-end">
                            <button class="btn btn-warning btn-sm me-1"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection