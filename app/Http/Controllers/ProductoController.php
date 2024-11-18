<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index(){
        $productos=Producto::all();
        return response()->json($productos,200);
    }

    public function show($id){
        $producto = Producto::find($id);
        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrada'], 404);
        }
        return response()->json($producto, 200);
    }

    
    
    public function store(Request $request){
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
            'imagen_url' => 'nullable|string|max:255',
            'id_categoria' => 'required|integer',
        ]);
    
        $producto = Producto::create($validatedData);
    
        return response()->json($producto, 201); 
    }
    

    
    public function update(Request $request, $id){
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
            'imagen_url' => 'nullable|string|max:255',
            'id_categoria' => 'required|integer',
        ]);
    
        $producto = Producto::find($id);
        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrada'], 404);
        }
    
        $producto->update($validatedData);
    
        return response()->json($producto, 200);
    }
    

    
    public function destroy($id){
        $producto = Producto::find($id);
        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrada'], 404);
        }

        $producto->delete();
        return response()->json(['message' => 'Producto eliminada correctamente'], 200);
    }
}
