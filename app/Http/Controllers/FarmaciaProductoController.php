<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class FarmaciaProductoController extends Controller
{
    function obtenerProductosFarmaciaCategoria($id_farmacia, $id_categoria){
        $productos = Producto::join('farmacia_productos', 'productos.id', '=', 'farmacia_productos.id_producto')
        ->where('farmacia_productos.id_farmacia', $id_farmacia)
        ->where('productos.id_categoria', $id_categoria)
        ->select('productos.*')
        ->get();
        return response()->json($productos, 200);
    }
    function obtenerProductosFarmacia($id_farmacia){
        $productos = Producto::join('farmacia_productos', 'productos.id', '=', 'farmacia_productos.id_producto')
        ->where('farmacia_productos.id_farmacia', $id_farmacia)
        ->select('productos.*')
        ->get();
        return response()->json($productos, 200);
    }
    function obtenerProductoPalabraClave($id_farmacia, $palabra){
        $productos = Producto::join('farmacia_productos', 'productos.id', '=', 'farmacia_productos.id_producto')
            ->where('farmacia_productos.id_farmacia', $id_farmacia)
            ->where('productos.nombre', 'like', '%'.$palabra.'%')
            ->select('productos.id',
                    'productos.nombre',
                    'productos.descripcion',
                    'productos.imagen_url',
                    'productos.id_categoria',
                    'farmacia_productos.precio',
                    'farmacia_productos.disponibilidad')
            ->get();
        
        return response()->json($productos, 200);
    }
}
