<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoScanner Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    @yield('estilos_especificos')
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-success shadow">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ url('/') }}">
                <i class="fas fa-car-diagnostic text-danger"></i> 
                <span class="text-danger">AutoScanner Shop</span>
            </a>
            <div class="ms-auto">
                <a href="{{ url('/login') }}" class="btn btn-outline-light btn-sm rounded-pill me-2">
                    <i class="fas fa-user"></i> Contacto
                </a>
                <a href="#" class="btn btn-primary btn-sm rounded-pill">
                    <i class="fas fa-shopping-cart"></i> Carrito
                </a>
            </div>
        </div>
    </nav>

    <main>
        @yield('contenido')
    </main>

    <footer class="bg-primary text-white text-center py-3 mt-5">
        <p class="mb-0">&copy; 2026 - Mi Tienda de Scanners</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>