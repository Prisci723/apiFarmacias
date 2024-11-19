<?php

namespace App\Http\Controllers;

use App\Models\FarmaciaProducto;
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
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_farmacia' => 'required|integer|exists:farmacias,id',
            'id_producto' => 'required|integer|exists:productos,id',
            'id_sucursal' => 'required|integer|exists:sucursales,id',
            'precio' => 'required|numeric|min:0',
            'disponibilidad' => 'required|boolean',
        ]);
    
        $farmaciaProducto = FarmaciaProducto::create($validatedData);
        return response()->json($farmaciaProducto, 201);
    }
    
}