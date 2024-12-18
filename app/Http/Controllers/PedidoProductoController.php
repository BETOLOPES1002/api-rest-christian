<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Producto;
use Illuminate\Http\Request;

class PedidoProductoController extends Controller
{
    // Listar todos los productos dentro de un pedido
    public function index(Pedido $pedido)
    {
        return response()->json($pedido->productos, 200);
    }

    // Agregar un producto a un pedido
    public function store(Request $request, Pedido $pedido)
    {
        $producto = new Producto($request->all());
        $producto->save();

        // Asociar el producto recién creado al pedido
        $pedido->productos()->attach($producto->id);

        return response()->json($producto, 201);
    }

    // Eliminar un producto de un pedido
    public function destroy(Pedido $pedido, Producto $producto)
    {
        // Verificar que el producto esté asociado al pedido
        if (!$pedido->productos()->where('id', $producto->id)->exists()) {
            return response()->json(['error' => 'El producto no pertenece a este pedido'], 400);
        }

        // Desasociar el producto del pedido sin eliminarlo de la base de datos
        $pedido->productos()->detach($producto->id);

        return response()->json(['message' => 'Producto eliminado del pedido'], 204);
    }
}

