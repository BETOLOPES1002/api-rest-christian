<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CategoriaProductoController extends Controller
{
    //Listar todos los productos de una categoria con soporte para respuestas parciales y filtros
    public function index(Request $request, $categoria_Id)
    {
        //Verificar si la categoria exite
        $categoria = Categoria::find($categoria_Id);
        if (!$categoria) {
            return response()->json(['error' => 'Categoria no encontrada'], 404);
        }

        //Aplicar filtros
        $query = $categoria->productos();

        if ($request->has('precio_min')) {
            $query->where('precio', '>=', $request->input('precio_min'));
        }

        if ($request->has('precio_max')) {
            $query->where('precio', '<=', $request->input('precio_max'));
        }

        // Implementar ordenamiento
        if ($request->has('sort')) {
            $sortFields = explode(',', $request->input('sort'));
            foreach ($sortFields as $fields) {
                if (str_ends_with($fields, '_desc')) {
                    $query->orderBy(str_replace('_desc', '', $fields), 'desc');
                } else {
                    $query->orderBy(str_replace('_asc', '', $fields), 'asc');
                }
            }
        }

        // Implementar paginación
        $perPage = $request->input('per_page',10);
        //Obtener los productos
        $productos = $query->paginate($perPage);

        //Respuestas parciales
        if ($request->has("fields")) {
            $fields = explode(",", $request->input('fields'));
            $productos = $productos->map(function ($producto) use ($fields) {
                return $producto->only($fields);
            });

        }

        return response()->json($productos, 200);
    }


    //Crear un producto dentro de una categoria
    public function store(Request $request, $categoria)
    {
        $categoria = Categoria::find($categoria);
        if ($categoria == null) {
            return response()->json(['error' => 'Categoría no encontrada'], 404);
        }

        try {
            $validateDate = $request->validate([
                'nombre' => 'required|string|max:20',
                'precio' => 'required|numeric|min:0',
                'descripcion' => 'required|string|max:255',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        $producto = new Producto($validateDate);
        $producto->categoria_id = $categoria->id;
        $producto->save();

        return response()->json($producto, 201);
    }



    //Mostrar un producto especifico de una categoria con soporte para respuestas parciales
    public function show(Request $request, $categoriaId, $productoId)
    {

        //Verificar si la categoria exite
        $categoria = Categoria::find($categoriaId);
        if (!$categoria) {
            return response()->json(['error' => 'Categoria no encontrada'], 404);
        }

        //Verificar si la categoria exite
        $producto = Producto::find($productoId);
        if (!$producto || $producto->categoria_id != $categoria->id) {
            return response()->json(['error' => 'El producto no pertenece a esta categoría o no existe'], 404);
        }

        //Respuesta parcial (Campos especificos)
        if ($request->has('fields')) {
            $fields = explode(',', $request->input('fields'));
            $producto = $producto->only($fields);
        }
        return response()->json($producto, 200);
    }


    //Update the specified resource in storage
    public function update($categoria, $producto, Request $request)
    {

        //Verificar si la categoria exite
        $categoria = Categoria::find($categoria);
        if ($categoria == null) {
            return response()->json(['error' => 'Categoria no encontrada'], 404);
        }

        //Verificar si la categoria exite
        $producto = Producto::find($producto);
        if (!$producto || $producto->categoria_id != $categoria->id) {
            return response()->json(['error' => 'El producto no pertenece a esta categoría o no existe'], 404);
        }

        try {
            $validateDate = $request->validate([
                'nombre' => 'required|string|max:20',
                'precio' => 'required|numeric|min:0',
                'descripcion' => 'required|string|max:255',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        $producto->update($validateDate);
        return response()->json($producto, 200);

    }



    //Elimanar un producto de una categoria
    public function destroy($categoriaId, $productoId)
    {
        //Verificar si la categoria exite
        $categoria = Categoria::find($categoriaId);
        if ($categoria == null) {
            return response()->json(['error' => 'Categoria no encontrada'], 404);
        }

        //Verificar si la categoria exite
        $producto = Producto::find($productoId);
        if (!$producto || $producto->categoria_id != $categoria->id) {
            return response()->json(['error' => 'El producto no pertenece a esta categoría o no existe'], 404);
        }

        $producto->delete();
        return response()->json(['message' => 'Producto eliminado'], 204);
    }
}
