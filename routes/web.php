<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ClientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| RUTAS DE AUTENTICACIÓN ESTRICTA
|--------------------------------------------------------------------------
*/

// --- INGRESO EXCLUSIVO DEL TÉCNICO (CON VINCULACIÓN DE IP) ---
Route::post('/validar-equipos', function (Request $request) {
    
    $usr = $request->input('usuario');
    $pass = $request->input('password');
    
    $keyIntentos = 'intentos_tecnico_ip_' . $request->ip();
    $keyBloqueo = 'bloqueo_tecnico_ip_' . $request->ip();

    if (Session::has($keyBloqueo)) {
        $tiempoBloqueo = Session::get($keyBloqueo);
        if (now()->lt($tiempoBloqueo)) {
            return back()->with('error', "Acceso de técnico bloqueado por seguridad durante 5 horas.");
        } else {
            Session::forget($keyBloqueo);
            Session::forget($keyIntentos);
            Session::save();
        }
    }

    if ($usr === 'tecnico_david' && $pass === '12345') {
        Session::forget($keyIntentos);
        Session::forget($keyBloqueo);
        Session::flush();

        Session::put('permiso_especial', true);
        Session::put('tecnico_ip', $request->ip());
        Session::save();
        
        return redirect()->route('tecnico.dashboard');
    }
    
    $intentosActuales = Session::get($keyIntentos, 0) + 1;
    Session::put($keyIntentos, $intentosActuales);
    Session::save();
    
    $intentosRestantes = max(0, 5 - $intentosActuales);

    if ($intentosActuales >= 5) {
        Session::put($keyBloqueo, now()->addHours(5));
        Session::forget($keyIntentos);
        Session::save();

        $ipAtacante = $request->ip();
        try {
            Mail::raw("Alerta: Bloqueo de técnico 'tecnico_david' por 5 horas. IP: {$ipAtacante}.", function ($message) {
                $message->to('winnerviddas@gmail.com')
                         ->subject('¡ALERTA! Intento bloqueado (Técnico)');
            });
        } catch (\Exception $e) {}

        return back()->with('error', "Demasiados intentos. El acceso ha sido bloqueado por 5 horas.");
    }

    return back()->withInput($request->only('usuario'))->with('error', "Credenciales de técnico incorrectas. Te quedan {$intentosRestantes} intentos.");
})->name('validar.equipos');


// --- INGRESO GENERAL ADMINISTRADOR (CON VINCULACIÓN DE IP) ---
Route::post('/login-validar', function (Request $request) {

    $cuenta = $request->input('usuario');
    $clave = $request->input('password');

    $keyIntentos = 'intentos_admin_ip_' . $request->ip();
    $keyBloqueo = 'bloqueo_admin_ip_' . $request->ip();

    if (Session::has($keyBloqueo)) {
        $tiempoBloqueo = Session::get($keyBloqueo);
        if (now()->lt($tiempoBloqueo)) {
            return back()->with('error', "Acceso bloqueado por seguridad durante 5 horas.");
        } else {
            Session::forget($keyBloqueo);
            Session::forget($keyIntentos);
            Session::save();
        }
    }

    // CASO A: Admin Global
    if ($cuenta === "viddas" && $clave === "12345") {
        Session::forget($keyIntentos);
        Session::forget($keyBloqueo);
        Session::flush();

        Session::put('acceso_permitido', true);
        Session::put('admin_ip', $request->ip());
        Session::save();
        return redirect()->route('admin');
    }

    // CASO B: Usuario Cliente en BD
    $usuarioBD = DB::table('users')->where('email', $cuenta)->first();
    if ($usuarioBD && Hash::check($clave, $usuarioBD->password)) {
        Session::forget($keyIntentos);
        Session::forget($keyBloqueo);
        Session::flush();
        Session::put('cliente_logueado', true);
        Session::save();
        return redirect()->route('welcome')->with('success', '¡Bienvenido!');
    }

    // CASO C: Fallo
    $intentosActuales = Session::get($keyIntentos, 0) + 1;
    Session::put($keyIntentos, $intentosActuales);
    Session::save();

    $intentosRestantes = max(0, 5 - $intentosActuales);

    if ($intentosActuales >= 5) {
        Session::put($keyBloqueo, now()->addHours(5));
        Session::forget($keyIntentos);
        Session::save();

        $ipAtacante = $request->ip();
        try {
            Mail::raw("Alerta: Usuario bloqueado por 5 horas. IP: {$ipAtacante}.", function ($message) {
                $message->to('winnerviddas@gmail.com')
                         ->subject('¡ALERTA! Acceso bloqueado');
            });
        } catch (\Exception $e) {}

        return back()->with('error', "Demasiados intentos. Cuenta bloqueada por 5 horas.");
    }

    return back()->withInput($request->only('usuario'))->with('error', "Credenciales incorrectas. Te quedan {$intentosRestantes} intentos.");
})->name('login.post');


/*
|--------------------------------------------------------------------------
| ACCIÓN DE REGISTRO DINÁMICO (BLINDADO CONTRA XSS)
|--------------------------------------------------------------------------
*/
Route::post('/registro-guardar', function (Request $request) {
    
    // ✅ VALIDACIÓN COMPLETA CON PROTECCIÓN XSS
    $request->validate([
        'nombre_cliente' => [
            'required',
            'string',
            'max:100',
            'regex:/^[\pL\s\-\.\']+$/u', // solo letras, espacios, puntos, guiones, apóstrofes
        ],
        'correo_cliente' => [
            'required',
            'email',
            'max:150',
            'unique:users,email',
        ],
        'password_cliente' => [
            'required',
            'string',
            'min:5',
            'max:255',
        ],
    ], [
        'nombre_cliente.required' => 'El nombre es obligatorio.',
        'nombre_cliente.regex'    => 'El nombre solo puede contener letras, espacios, puntos y guiones. No se permiten símbolos como < > { } ( ).',
        'nombre_cliente.max'      => 'El nombre es demasiado largo.',
        'correo_cliente.required' => 'El correo es obligatorio.',
        'correo_cliente.email'    => 'Ingrese un correo válido.',
        'correo_cliente.unique'   => 'Este correo ya está registrado.',
        'password_cliente.min'    => 'La contraseña debe tener al menos 5 caracteres.',
    ]);

    // Limpieza extra con strip_tags (doble capa de seguridad)
    $nombreCliente = strip_tags(trim($request->input('nombre_cliente')));
    $nuevoUsuario  = trim($request->input('correo_cliente'));
    $nuevaClave    = $request->input('password_cliente');

    DB::table('users')->insert([
        'name'       => $nombreCliente,
        'email'      => $nuevoUsuario,
        'password'   => Hash::make($nuevaClave),
        'created_at' => now(),
        'updated_at' => now()
    ]);

    return redirect()->route('login')->with('info', '¡Registro exitoso! Inicie sesión.');
})->name('registro.store');


/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS Y CIERRE DE SESIÓN TOTAL
|--------------------------------------------------------------------------
*/
Route::get('/', [ProductController::class, 'welcome'])->name('welcome');
Route::get('/productos', [ProductController::class, 'productList'])->name('productos.index');
Route::get('/login', function () { return view('login'); })->name('login');
Route::get('/login-equipos', function () { return view('login_equipos'); })->name('login.equipos');
Route::get('/registro', function () { return view('login'); })->name('registro');

// Destrucción total de sesión e IPs vinculadas
Route::get('/logout', function (Request $request) {
    Session::flush();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login')->with('success', 'Sesión cerrada correctamente.');
})->name('logout');


/*
|--------------------------------------------------------------------------
| ÁREAS PROTEGIDAS (TÉCNICO) CON VALIDACIÓN DE IP
|--------------------------------------------------------------------------
*/
Route::prefix('gestion')->group(function () {
    Route::get('/dashboard', function (Request $request) {
        if (!Session::has('permiso_especial') || Session::get('tecnico_ip') !== $request->ip()) {
            Session::flush();
            return redirect()->route('login.equipos')->with('error', 'Acceso no autorizado o IP no coincidente.');
        }
        return view('tecnico_dashboard');
    })->name('tecnico.dashboard');

    Route::get('/usuarios', function (Request $request) {
        if (!Session::has('permiso_especial') || Session::get('tecnico_ip') !== $request->ip()) {
            Session::flush();
            return redirect()->route('login.equipos');
        }
        return app(ProductController::class)->manageUsers();
    })->name('gestion.usuarios');

    Route::get('/productos', function (Request $request) {
        if (!Session::has('permiso_especial') || Session::get('tecnico_ip') !== $request->ip()) {
            Session::flush();
            return redirect()->route('login.equipos');
        }
        return app(ProductController::class)->manageProducts();
    })->name('gestion.productos');

    Route::get('/productos/{id}/editar', function (Request $request, $id) {
        if (!Session::has('permiso_especial') || Session::get('tecnico_ip') !== $request->ip()) {
            Session::flush();
            return redirect()->route('login.equipos');
        }
        return app(ProductController::class)->edit($id);
    })->name('producto.edit');

    Route::put('/productos/{id}/actualizar', function (Request $request, $id) {
        if (!Session::has('permiso_especial') || Session::get('tecnico_ip') !== $request->ip()) {
            Session::flush();
            return redirect()->route('login.equipos');
        }
        return app(ProductController::class)->update($request, $id);
    })->name('producto.update');

    Route::delete('/productos/{id}/eliminar', function (Request $request, $id) {
        if (!Session::has('permiso_especial') || Session::get('tecnico_ip') !== $request->ip()) {
            Session::flush();
            return redirect()->route('login.equipos');
        }
        return app(ProductController::class)->destroy($id);
    })->name('producto.destroy');

    Route::get('/registrar-equipo', function (Request $request) {
        if (!Session::has('permiso_especial') || Session::get('tecnico_ip') !== $request->ip()) {
            Session::flush();
            return redirect()->route('login.equipos');
        }
        return view('formularios.registro_equipo');
    })->name('formulario.equipo');

    Route::post('/registrar-equipo/store', function (Request $request) {
        if (!Session::has('permiso_especial') || Session::get('tecnico_ip') !== $request->ip()) {
            Session::flush();
            return redirect()->route('login.equipos');
        }
        return app(ProductController::class)->store($request);
    })->name('producto.store');

    Route::get('/clientes', function (Request $request) {
        if (!Session::has('permiso_especial') || Session::get('tecnico_ip') !== $request->ip()) {
            Session::flush();
            return redirect()->route('login.equipos');
        }
        return app(ClientController::class)->index($request);
    })->name('gestion.clientes');

    Route::get('/clientes/crear', function (Request $request) {
        if (!Session::has('permiso_especial') || Session::get('tecnico_ip') !== $request->ip()) {
            Session::flush();
            return redirect()->route('login.equipos');
        }
        return app(ClientController::class)->create();
    })->name('cliente.create');

    Route::post('/clientes/store', function (Request $request) {
        if (!Session::has('permiso_especial') || Session::get('tecnico_ip') !== $request->ip()) {
            Session::flush();
            return redirect()->route('login.equipos');
        }
        return app(ClientController::class)->store($request);
    })->name('cliente.store');

    Route::get('/clientes/{id}/editar', function (Request $request, $id) {
        if (!Session::has('permiso_especial') || Session::get('tecnico_ip') !== $request->ip()) {
            Session::flush();
            return redirect()->route('login.equipos');
        }
        return app(ClientController::class)->edit($id);
    })->name('cliente.edit');

    Route::put('/clientes/{id}/actualizar', function (Request $request, $id) {
        if (!Session::has('permiso_especial') || Session::get('tecnico_ip') !== $request->ip()) {
            Session::flush();
            return redirect()->route('login.equipos');
        }
        return app(ClientController::class)->update($request, $id);
    })->name('cliente.update');

    Route::delete('/clientes/{id}/eliminar', function (Request $request, $id) {
        if (!Session::has('permiso_especial') || Session::get('tecnico_ip') !== $request->ip()) {
            Session::flush();
            return redirect()->route('login.equipos');
        }
        return app(ClientController::class)->destroy($id);
    })->name('cliente.destroy');
});


/*
|--------------------------------------------------------------------------
| ÁREAS PROTEGIDAS (ADMINISTRADOR) CON VALIDACIÓN DE IP
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {
    Route::get('/', function (Request $request) {
        if (!Session::has('acceso_permitido') || Session::get('admin_ip') !== $request->ip()) {
            Session::flush();
            return redirect()->route('login')->with('error', 'Sesión cerrada o IP no autorizada.');
        }
        return view('admin');
    })->name('admin');

    Route::get('/clientes', function (Request $request) {
        if (!Session::has('acceso_permitido') || Session::get('admin_ip') !== $request->ip()) {
            Session::flush();
            return redirect()->route('login');
        }
        return app(ClientController::class)->index($request);
    })->name('admin.clients.index');

    Route::put('/clientes/{id}/reset-password', function (Request $request, $id) {
        if (!Session::has('acceso_permitido') || Session::get('admin_ip') !== $request->ip()) {
            Session::flush();
            return redirect()->route('login');
        }
        return app(ClientController::class)->resetPassword($id);
    })->name('admin.clients.reset-password');

    Route::get('/exportar/pdf', function (Request $request) {
        if (!Session::has('acceso_permitido') || Session::get('admin_ip') !== $request->ip()) {
            Session::flush();
            return redirect()->route('login');
        }
        return app(ProductController::class)->exportPdf();
    })->name('admin.export.pdf');

    Route::get('/exportar/excel', function (Request $request) {
        if (!Session::has('acceso_permitido') || Session::get('admin_ip') !== $request->ip()) {
            Session::flush();
            return redirect()->route('login');
        }
        return app(ProductController::class)->exportExcel();
    })->name('admin.export.excel');
});

Route::get('/cart', [CartController::class, 'cartList'])->name('cart.list');
Route::post('/cart', [CartController::class, 'addToCart'])->name('cart.store');
Route::post('/cart-remove', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/registrar-venta', function () { return view('formularios.registro_venta'); })->name('formulario.venta');