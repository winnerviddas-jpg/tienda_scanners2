@extends('layouts.app')

@section('contenido')
<div class="container" style="margin-top: 50px; margin-bottom: 50px;">
    <div class="d-flex justify-content-between align-items-center mb-5 border-bottom pb-3">
        <div>
            <h1 class="fw-bold text-dark mb-0">PANEL DE CONTROL: ADMINISTRADOR</h1>
            <p class="text-muted">Supervisión general del sistema y generación de reportes totales</p>
        </div>
        <a href="{{ route('logout') }}" class="btn btn-danger fw-bold shadow-sm">
            <i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success text-center fw-bold shadow-sm mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="row mb-5">
        <div class="col-md-3 mb-4">
            <div class="card bg-primary text-white h-100 shadow border-0" style="border-radius: 12px;">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-uppercase fw-bold opacity-75">Usuarios</h6>
                        <h2 class="fw-bold mb-0">12</h2>
                    </div>
                    <i class="fas fa-users fa-3x opacity-50"></i>
                </div>
            </div>
        </div>

        <!-- Tarjeta de Clientes convertida en botón -->
        <a href="{{ route('admin.clients.index') }}" class="col-md-3 mb-4 text-decoration-none">
            <div class="card bg-success text-white h-100 shadow border-0" style="border-radius: 12px; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.02)';" onmouseout="this.style.transform='scale(1)';">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-uppercase fw-bold opacity-75 text-white">Clientes</h6>
                        <h2 class="fw-bold mb-0 text-white">45</h2>
                    </div>
                    <i class="fas fa-user-tie fa-3x opacity-50"></i>
                </div>
            </div>
        </a>

        <div class="col-md-3 mb-4">
            <div class="card bg-warning text-dark h-100 shadow border-0" style="border-radius: 12px;">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-uppercase fw-bold opacity-75">Equipos en Venta</h6>
                        <h2 class="fw-bold mb-0">28</h2>
                    </div>
                    <i class="fas fa-wrench fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card bg-info text-white h-100 shadow border-0" style="border-radius: 12px;">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-uppercase fw-bold opacity-75">Ventas Registradas</h6>
                        <h2 class="fw-bold mb-0">89</h2>
                    </div>
                    <i class="fas fa-shopping-basket fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 p-5 bg-light text-center" style="border-radius: 15px;">
        <h4 class="fw-bold text-secondary mb-3"><i class="fas fa-file-invoice me-2"></i>EXPORTACIÓN DE REPORTES ADMINISTRATIVOS</h4>
        <p class="text-muted mb-4">Genera y descarga el estado consolidado de la base de datos en los formatos requeridos para auditoría.</p>
        
        <div class="d-flex justify-content-center gap-4">
            <a href="{{ route('admin.export.pdf') }}" class="btn btn-danger btn-lg px-4 fw-bold shadow">
                <i class="fas fa-file-pdf me-2"></i> Exportar Reporte a PDF
            </a>
            <a href="{{ route('admin.export.excel') }}" class="btn btn-success btn-lg px-4 fw-bold shadow">
                <i class="fas fa-file-excel me-2"></i> Exportar Reporte a Excel
            </a>
        </div>
    </div>
</div>
@endsection