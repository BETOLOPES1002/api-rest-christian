<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::all();
        return response()->json($productos, 200);
    }
    public function store(Request $request)
    {
        $producto = new Producto($request->all());
        $producto->save();
        return response()->json($producto, 201);
    }
    public function show($id)
    {
        $producto = Producto::find($id);
        if ($producto == null) {
            return response()->json(['error' => 'Producto NO encontrado'], 404);
        }
        return response()->json($producto, 200);
    }
    public function update(Request $request, $id)
    {
        $producto = Producto::find($id);
        if ($producto == null) {
            return response()->json(['error' => 'Producto NO encontrado'], 404);
        }
        $producto->update($request->all());
        return response()->json($producto, 200);
    }
    public function destroy($id)
    {
        $producto = Producto::find($id);
        if ($producto == null) {
            return response()->json(['error' => 'Producto NO encontrado'], 404);
        }
        $producto->delete();
        return response()->json(null, 204);
    }
}
