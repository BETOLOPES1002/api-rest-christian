<?php
namespace App\Http\Controllers;
use App\Models\Usuario;
use App\Models\Pedido;
use App\Models\User;
use Illuminate\Http\Request;

class UsuarioPedidoController extends Controller
{
    // Listar todos los pedidos de un usuario
    public function index(User $user)
    {
        return response()->json($user->pedidos, 200);
    }

    // Crear un pedido para un usuario
    public function store(Request $request, User $user)
    {
        $pedido = new Pedido($request->all());
        $pedido->user_id = $user->id;
        $pedido->save();

        return response()->json($pedido, 201);
    }
    // Eliminar un pedido de un usuario
public function destroy(User $user, Pedido $pedido)
{
    if ($pedido->user_id != $user->id) {
        return response()->json(['error' => 'El pedido no pertenece a este usuario'], 400);
    }

    $pedido->delete();
    return response()->json(null, 204);
}

public function show(User $user, Pedido $pedido)
    {
        if ($pedido->user_id != $user->id) {
            return response()->json(['error' => 'El pedido no pertenece a este usuario'], 404);
        }

        return response()->json($pedido, 200);
    }
    public function update(User $user, Request $request, Pedido $pedido)
    {
        if ($pedido->user_id != $user->id) {
            return response()->json(['error' => 'El pedido no pertenece a este usuario'], 404);
        }

        $pedido->update($request->all());
        return response()->json($pedido, 200);
    }



}

