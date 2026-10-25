@extends('layouts.app')

@section('contenido')
<div class="container" style="margin-top: 80px; margin-bottom: 50px;">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-lg border-0" style="border-radius: 15px;">
                
                <div class="card-header bg-dark p-0" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                    <ul class="nav nav-tabs nav-justified border-bottom-0" id="loginTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active text-white fw-bold py-3 bg-dark border-0" id="login-tab" data-bs-toggle="tab" data-bs-target="#login-panel" type="button" role="tab" aria-controls="login-panel" aria-selected="true">
                                <i class="fas fa-lock me-2"></i>ACCESO PRIVADO
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link text-white fw-bold py-3 bg-secondary border-0" id="register-tab" data-bs-toggle="tab" data-bs-target="#register-panel" type="button" role="tab" aria-controls="register-panel" aria-selected="false">
                                <i class="fas fa-user-plus me-2"></i>REGISTRO CLIENTE
                            </button>
                        </li>
                    </ul>
                </div>

                <div class="card-body p-5 tab-content" id="loginTabsContent">
                    
                    @if(session('error'))
                        <div class="alert alert-danger small text-center shadow-sm">{{ session('error') }}</div>
                    @endif
                    @if(session('info'))
                        <div class="alert alert-warning small text-center shadow-sm fw-bold">{{ session('info') }}</div>
                    @endif

                    <div class="tab-pane fade show active" id="login-panel" role="tabpanel" aria-labelledby="login-tab">
                        <form action="{{ route('login.post') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-bold">Usuario</label>
                                <input type="text" name="usuario" class="form-control" placeholder="" required value="{{ old('usuario') }}">
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-bold">Contraseña</label>
                                <input type="password" name="password" class="form-control" placeholder="" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 fw-bold py-2">
                                ENTRAR A LA TIENDA
                            </button>
                        </form>
                    </div>

                    <div class="tab-pane fade" id="register-panel" role="tabpanel" aria-labelledby="register-tab">
                        <form action="{{ route('registro.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nombre Completo</label>
                                <input type="text" name="nombre_cliente" class="form-control" placeholder="Ej. Juan Pérez" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Correo Electrónico</label>
                                <input type="email" name="correo_cliente" class="form-control" placeholder="juan@correo.com" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-bold">Crear Contraseña</label>
                                <input type="password" name="password_cliente" class="form-control" placeholder="Mínimo 5 caracteres" required>
                            </div>
                            <button type="submit" class="btn btn-success w-100 fw-bold py-2">
                                COMPLETAR REGISTRO Y COMPRAR
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var triggerTabList = [].slice.call(document.querySelectorAll('#loginTabs button'))
        triggerTabList.forEach(function (triggerEl) {
            triggerEl.addEventListener('click', function (event) {
                triggerTabList.forEach(tab => {
                    tab.classList.add('bg-secondary');
                    tab.classList.remove('bg-dark');
                });
                this.classList.remove('bg-secondary');
                this.classList.add('bg-dark');
            });
        });
    });
</script>
@endsection