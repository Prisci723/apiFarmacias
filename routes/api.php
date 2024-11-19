<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\farmaciaController;
use App\Http\Controllers\FarmaciaProductoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UbicacionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Farmacia
Route::get('/farmacia',[farmaciaController::class,'index'] );
Route::get('/farmacia/{id}', [farmaciaController::class, 'show']);  
Route::get('/farmacia/{id}/productos', [farmaciaController::class, 'farmaciaProductos']);     
Route::get('/farmacia/{id}/productos/categoria/{idc}', [farmaciaController::class, 'productosPorCategoria']);
Route::post('/farmacia', [farmaciaController::class, 'store']);          
Route::put('/farmacia/{id}', [farmaciaController::class, 'update']);     
Route::delete('/farmacia/{id}', [farmaciaController::class, 'destroy']);
 

//Categoria
Route::get('/categoria',[CategoriaController::class,'index'] );
Route::get('/categoria/{id}', [CategoriaController::class, 'show']);       
Route::post('/categoria', [CategoriaController::class, 'store']);          
Route::put('/categoria/{id}', [CategoriaController::class, 'update']);     
Route::delete('/categoria/{id}', [CategoriaController::class, 'destroy']);


//Producto
Route::get('/producto',[ProductoController::class,'index'] );
Route::get('/producto/{id}', [ProductoController::class, 'show']);       
Route::post('/producto', [ProductoController::class, 'store']);          
Route::put('/producto/{id}', [ProductoController::class, 'update']);     
Route::delete('/producto/{id}', [ProductoController::class, 'destroy']);

//FarmaciaProducto
//obtener productos de una farmacia
Route::get('/farmacia/{id_farmacia}/productos', [FarmaciaProductoController::class, 'obtenerProductosFarmacia']);
//obtener productos de una farmacia por categoria
Route::get('/farmacia/{id_farmacia}/productos/categoria/{id_categoria}', [FarmaciaProductoController::class, 'obtenerProductosFarmaciaCategoria']);
//obtener productos de una farmacia con una palabra clave en el nombre del producto
Route::get('/farmacia/{id_farmacia}/productos/palabra/{palabra}', [FarmaciaProductoController::class, 'obtenerProductoPalabraClave']);

//Categoria
Route::get('/categoria/{id_farmacia}/farmacia',[CategoriaController::class,'obtenerCategoriasFarmacia'] );

//Obtener farmacia dada la ubicacion 
Route::get('/ubicacion/{id_ubicacion}/farmacia', [farmaciaController::class, 'obtenerFarmaciaUbicacion']);

//obtener farmacia mas cercana segun el horario o el turno
Route::get('/ubicacion/{latitud}/{longitud}',[UbicacionController::class,'obtenerUbicacionMasCercana'] );
//Obtener ubicacion dado el id de la ubicacion 
Route::get('/ubicacion/{id_ubicacion}', [UbicacionController::class, 'show']);