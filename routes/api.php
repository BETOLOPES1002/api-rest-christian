<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CategoriaProductoController;
use App\Http\Controllers\PedidoProductoController;
use App\Http\Controllers\UsuarioPedidoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('categorias/{categoria}/productos', [CategoriaProductoController::class, 'index']);
Route::post('categorias/{categoria}/productos', [CategoriaProductoController::class, 'store']);
Route::get('categorias/{categoria}/productos/{producto}', [CategoriaProductoController::class, 'show']);
Route::put('categorias/{categoria}/productos/{producto}', [CategoriaProductoController::class, 'update']);
Route::delete('categorias/{categoria}/productos/{producto}', [CategoriaProductoController::class, 'destroy']);


//Rutas: Usuarios y pedidos
Route::get('users/{user}/pedidos', [UsuarioPedidoController::class, 'index']);
Route::post('users/{user}/pedidos', [UsuarioPedidoController::class, 'store']);
Route::delete('users/{user}/pedidos/{pedido}', [UsuarioPedidoController::class, 'destroy']);
Route::put('users/{user}/pedidos/{pedido}', [UsuarioPedidoController::class, 'update']);
Route::get('users/{user}/pedidos/{pedido}', [UsuarioPedidoController::class, 'show']);

//Rutas: Pedidos y productos
Route::get('pedidos/{pedido}/productos', [PedidoProductoController::class, 'index']);
Route::post('pedidos/{pedido}/productos', [PedidoProductoController::class, 'store']);
Route::delete('pedidos/{pedido}/productos/{producto}', [PedidoProductoController::class, 'destroy']);


//Rutas: Categorias
Route::get('categorias', [CategoriaController::class, 'index']);
Route::post('categorias', [CategoriaController::class, 'store']);
Route::get('categorias/{categoria}', [CategoriaController::class, 'show']);
Route::put('categorias/{categoria}', [CategoriaController::class, 'update']);
Route::delete('categorias/{categoria}', [CategoriaController::class, 'destroy']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);


Route::get('productos', [ProductoController::class, 'index']);
Route::post('productos', [ProductoController::class, 'store']);
Route::get('productos/{producto}', [ProductoController::class, 'show']);
Route::put('productos/{producto}', [ProductoController::class, 'update']);
Route::delete('productos/{producto}', [ProductoController::class, 'destroy']);