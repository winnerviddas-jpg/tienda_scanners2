<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;

class VentaController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'cliente' => 'required',
            'documento' => 'required',
            'producto' => 'required',
            'monto' => 'required|numeric'
        ]);

        Venta::create([
            'cliente' => $request->cliente,
            'documento' => $request->documento,
            'producto' => $request->producto,
            'monto' => $request->monto
        ]);

        return redirect()->route('formulario.venta')
            ->with('success', 'Venta registrada correctamente');
    }
}