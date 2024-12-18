<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CategoriaController extends Controller
{
    //Listar todas las categorías  (GET / categorias)
    public function index()
    {
        // Obtener todas las categorias
        $categorias = Categoria::all();
        return response()->json($categorias, 200);
    }


    //Mostrar una categoria especifica (GET / categorias / {id})
    public function show($id)
    {
        //Buscar la categoria por ID
        $categoria = Categoria::find($id);
        //Verificar si la categoria existe
        if (!$categoria) {
            return response()->json(['error' => 'Categoria no encontrada'], 400);
        }
        //Devolver la categoria encontrada
        return response()->json([$categoria, 200]);
    }

    //Crear una nueva categoria (POST / Categorias)
    public function store(Request $request)
    {
        //Validación de los datos
        try {
            $validateData = $request->validate([
                'nombre' => 'required|string|max:20',
                // 'descripcion' => 'nullable|string'
            ]);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        //Crear una nueva categoria
        $categoria = Categoria::create($validateData);
        $categoria->save();

        //Responder con la categoria creada
        return response()->json($categoria, 201);
    }



    //Actualizar una categoria existente (PUT / categorias / {id})
    public function update(Request $request, $id)
    {
        //Buscar la categoria por id
        $categoria = Categoria::find($id);

        //Verificar si la categoria existe
        if ($categoria == null) {
            return response()->json(['error' => 'Categoria no encontrada'], 404);
        }


        try {
            //Validación de los datos
            $validatedData = $request->validate([
                'nombre' => 'required|string|max:20',
                // 'descripcion' => 'nullable|string'
            ]);
        } catch (ValidationException $e) {
            //Devolver
            return response()->json(['error' => $e->getMessage()], 200);
        }

        //Actualizar los campos de la categoria
        $categoria->update($validatedData);

        //Devolver
        return response()->json($categoria, 200);
    }

    public function destroy($id)
    {
        //Buscar la categoria por id
        $categoria = Categoria::find($id);
        //Verificar si la categoria existe
        if (!$categoria) {
            return response()->json(['error' => 'Categoria no encontrada'], 404);
        }

        //Eliminar la categoira
        $categoria->delete();
        return response()->json(['message' => 'Categoría eliminada con éxito'], 200);
    }
}
