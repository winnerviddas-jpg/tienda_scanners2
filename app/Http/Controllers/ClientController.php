<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ClientController extends Controller
{
    // Listar Clientes (Distingue entre la vista de técnico y la de administrador)
    public function index(Request $request)
    {
        // Si viene desde el panel de administrador, mostramos los usuarios registrados en la tabla 'users'
        if ($request->routeIs('admin.clients.index')) {
            $clientes = DB::table('users')->get();
            return view('admin.clients.index', compact('clientes'));
        }

        // Comportamiento para el técnico (gestión de equipos/productos)
        $clientes = DB::table('products')->get();
        return view('gestion.clientes', compact('clientes'));
    }

    // Formulario de creación
    public function create()
    {
        return view('formularios.registro_cliente');
    }

    // Guardar nuevo (Create)
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'marca' => 'required',
            'precio' => 'required|numeric',
            'descripcion' => 'required',
            'stock' => 'required|integer'
        ]);

        DB::table('products')->insert([
            'nombre' => $request->nombre,
            'marca' => $request->marca,
            'precio' => $request->precio,
            'descripcion' => $request->descripcion,
            'stock' => $request->stock,
            'imagen' => 'img/default.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('gestion.clientes')
            ->with('success', 'Registro completado correctamente en el sistema');
    }

    // Formulario de edición
    public function edit($id)
    {
        $cliente = DB::table('products')->where('id', $id)->first();
        return view('gestion.editar_cliente', compact('cliente'));
    }

    // Actualizar (Update)
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required',
            'marca' => 'required',
            'precio' => 'required|numeric',
            'descripcion' => 'required',
            'stock' => 'required|integer'
        ]);

        DB::table('products')->where('id', $id)->update([
            'nombre' => $request->nombre,
            'marca' => $request->marca,
            'precio' => $request->precio,
            'descripcion' => $request->descripcion,
            'stock' => $request->stock,
            'updated_at' => now()
        ]);

        return redirect()->route('gestion.clientes')
            ->with('success', 'Registro actualizado correctamente');
    }

    // Eliminar (Delete)
    public function destroy($id)
    {
        DB::table('products')->where('id', $id)->delete();
        return redirect()->route('gestion.clientes')
            ->with('success', 'Registro eliminado correctamente');
    }

    // Restablecer contraseña del cliente desde el panel de administración
    public function resetPassword($id)
    {
        $cliente = DB::table('users')->where('id', $id)->first();

        if (!$cliente) {
            return redirect()->back()->with('error', 'Cliente no encontrado.');
        }

        // Generamos una contraseña temporal automática de 8 caracteres
        $nuevaPasswordTemp = Str::random(8);

        // Actualizamos en la base de datos de forma encriptada
        DB::table('users')->where('id', $id)->update([
            'password' => Hash::make($nuevaPasswordTemp),
            'updated_at' => now()
        ]);

        return redirect()->back()->with('success', "Contraseña restablecida para <strong>{$cliente->name}</strong>. Nueva contraseña temporal: <code>{$nuevaPasswordTemp}</code>");
    }
}