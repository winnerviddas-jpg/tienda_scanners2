<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function cartList()
    {
        $cartItems = Session::get('cart', []);
        return view('cart', compact('cartItems'));
    }

    public function addToCart(Request $request)
    {
        // SEGURIDAD REFORZADA: Si NO ha iniciado sesión, va directo a la pantalla de Login
        if (!Session::has('cliente_logueado')) {
            return redirect()->route('login')
                ->with('info', 'Para añadir equipos al carrito, primero debes Iniciar Sesión. Si eres nuevo, puedes usar la pestaña de Registro.');
        }

        $product = Product::find($request->id);

        if (!$product) {
            return back()->with('error', 'Producto no encontrado');
        }

        $cart = Session::get('cart', []);

        $cart[$product->id] = [
            "nombre" => $product->nombre,
            "precio" => $product->precio,
            "imagen" => $product->imagen,
            "cantidad" => 1
        ];

        Session::put('cart', $cart);

        return redirect()->route('cart.list');
    }

    public function remove(Request $request)
    {
        if($request->id) {
            $cart = Session::get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                Session::put('cart', $cart);
            }
            return redirect()->route('cart.list');
        }
    }
}