<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function welcome()
    {
        // Forzamos traer los datos frescos directamente de la base de datos
        $products = Product::orderBy('id', 'desc')->get();
        return view('welcome', compact('products'));
    }

    public function productList()
    {
        // Forzamos traer los datos frescos para la vista de productos pública
        $products = Product::orderBy('id', 'desc')->get();
        return view('productos', compact('products'));
    }

    // --- FUNCIONES PARA LOS 3 CRUDs DEL TÉCNICO ---
    public function manageUsers()
    {
        return view('gestion.usuarios');
    }

    public function manageClients()
    {
        return view('gestion.clientes');
    }

    public function manageProducts()
    {
        // Trae los productos ordenados por el último creado para trabajar cómodo
        $products = Product::orderBy('id', 'desc')->get(); 
        return view('gestion.productos', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'marca' => 'required',
            'precio' => 'required|numeric',
            'descripcion' => 'required',
            'stock' => 'required|integer|min:0',
            'imagen' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $producto = new Product();
        $producto->nombre = $request->nombre;
        $producto->marca = $request->marca;
        $producto->precio = $request->precio;
        $producto->descripcion = $request->descripcion;
        $producto->stock = $request->stock;

        if ($request->hasFile('imagen')) {
            $nombreImagen = time() . '.' . $request->imagen->extension();
            $request->imagen->move(public_path('img'), $nombreImagen);
            $producto->imagen = 'img/' . $nombreImagen;
        }

        $producto->save();

        // Redirección explícita usando la ruta del listado técnico
        return redirect()->action([ProductController::class, 'manageProducts'])
            ->with('success', 'Equipo guardado correctamente');
    }

    public function exportPdf()
    {
        return response()->streamDownload(function () {
            echo "--- REPORTE ADMINISTRATIVO GLOBAL AUTOMOTRIZ (PDF) ---\n";
            echo "Total Usuarios: 12\nTotal Clientes: 45\nTotal Equipos: 28\n";
        }, 'reporte_general_tienda.pdf');
    }

    public function exportExcel()
    {
        return response()->streamDownload(function () {
            echo "ID;Reporte;Cantidad;Fecha\n";
            echo "1;Usuarios Registrados;12;2026-06\n";
            echo "2;Clientes Totales;45;2026-06\n";
        }, 'reporte_general_tienda.csv');
    }

    // ==== MÉTODOS PARA EDITAR, ACTUALIZAR Y ELIMINAR ====

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('gestion.editar_producto', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required',
            'marca' => 'required',
            'precio' => 'required|numeric',
            'descripcion' => 'required',
            'stock' => 'required|integer|min:0',
            'imagen' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $producto = Product::findOrFail($id);
        $producto->nombre = $request->nombre;
        $producto->marca = $request->marca;
        $producto->precio = $request->precio;
        $producto->descripcion = $request->descripcion;
        $producto->stock = $request->stock;

        if ($request->hasFile('imagen')) {
            if ($producto->imagen && file_exists(public_path($producto->imagen))) {
                @unlink(public_path($producto->imagen));
            }
            $nombreImagen = time() . '.' . $request->imagen->extension();
            $request->imagen->move(public_path('img'), $nombreImagen);
            $producto->imagen = 'img/' . $nombreImagen;
        }

        $producto->save();

        return redirect()->action([ProductController::class, 'manageProducts'])
            ->with('success', 'Equipo actualizado correctamente');
    }

    public function destroy($id)
    {
        $producto = Product::findOrFail($id);
        
        if ($producto->imagen && file_exists(public_path($producto->imagen))) {
            @unlink(public_path($producto->imagen));
        }

        $producto->delete();

        return redirect()->action([ProductController::class, 'manageProducts'])
            ->with('success', 'Equipo eliminado correctamente');
    }
}