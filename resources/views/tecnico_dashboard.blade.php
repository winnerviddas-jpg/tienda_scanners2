@extends('layouts.app')

@section('contenido')
<div class="container" style="margin-top: 50px; margin-bottom: 50px;">
    <div class="d-flex justify-content-between align-items-center mb-5 border-bottom pb-3">
        <div>
            <h2 class="fw-bold text-dark mb-0">PANEL OPERATIVO: ÁREA TÉCNICA</h2>
            <p class="badge bg-info text-dark fs-6 mt-2">Acceso Técnico: david</p>
        </div>
        <a href="{{ route('logout') }}" class="btn btn-danger fw-bold shadow-sm">
            <i class="fas fa-sign-out-alt me-2"></i>Cerrar Panel
        </a>
    </div>

    <div class="text-center mb-5">
        <h4 class="text-secondary fw-bold">SELECCIONE EL MÓDULO DE TRABAJO (CRUD)</h4>
        <p class="text-muted">Según el diagrama, usted tiene permisos de lectura, inserción, actualización y eliminación de registros.</p>
    </div>

    <div class="row justify-content-center gap-4">
        <div class="col-md-3">
            <div class="card h-100 shadow-sm border-0 text-center p-4" style="border-radius: 12px;">
                <div class="card-body">
                    <i class="fas fa-users-cog fa-4x text-primary mb-3"></i>
                    <h5 class="fw-bold">CRUD 1</h5>
                    <p class="text-muted small">Gestión Completa de Usuarios Internos</p>
                    <a href="{{ route('gestion.usuarios') }}" class="btn btn-primary w-100 fw-bold">Administrar Usuarios</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card h-100 shadow-sm border-0 text-center p-4" style="border-radius: 12px;">
                <div class="card-body">
                    <i class="fas fa-user-check fa-4x text-success mb-3"></i>
                    <h5 class="fw-bold">CRUD 2</h5>
                    <p class="text-muted small">Gestión Completa de Clientes del Taller</p>
                    <a href="{{ route('gestion.clientes') }}" class="btn btn-success w-100 fw-bold">Administrar Clientes</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card h-100 shadow-sm border-0 text-center p-4" style="border-radius: 12px;">
                <div class="card-body">
                    <i class="fas fa-boxes fa-4x text-warning mb-3"></i>
                    <h5 class="fw-bold">CRUD 3</h5>
                    <p class="text-muted small">Gestión Completa de Productos (Equipos)</p>
                    <a href="{{ route('gestion.productos') }}" class="btn btn-warning w-100 text-dark fw-bold">Administrar Productos</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection