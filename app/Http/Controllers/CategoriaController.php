<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index(){
        $categorias=Categoria::all();
        return response()->json($categorias,200);
    }

    public function show($id){
        $categoria = Categoria::find($id);
        if (!$categoria) {
            return response()->json(['message' => 'Categoria no encontrada'], 404);
        }
        return response()->json($categoria, 200);
    }

    
    
    public function store(Request $request){
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:50',
        ]);
    
        $categoria = Categoria::create($validatedData);
    
        return response()->json($categoria, 201); 
    }
    

    
    public function update(Request $request, $id){
        $validatedData = $request->validate([
            'nombre' => 'sometimes|required|string|max:255',
            'descripcion' => 'required|string|max:50',
        ]);
    
        $categoria = Categoria::find($id);
        if (!$categoria) {
            return response()->json(['message' => 'Categoria no encontrada'], 404);
        }
    
        $categoria->update($validatedData);
    
        return response()->json($categoria, 200);
    }
    

    
    public function destroy($id){
        $categoria = Categoria::find($id);
        if (!$categoria) {
            return response()->json(['message' => 'Categoria no encontrada'], 404);
        }

        $categoria->delete();
        return response()->json(['message' => 'Categoria eliminada correctamente'], 200);
    }

    public function obtenerCategoriasFarmacia($id_farmacia){
        $categorias = Categoria::join('productos', 'categorias.id', '=', 'productos.id_categoria')
        ->join('farmacia_productos', 'productos.id', '=', 'farmacia_productos.id_producto')
        ->where('farmacia_productos.id_farmacia', $id_farmacia)
        ->select('categorias.*')
        ->distinct()
        ->get();
        return response()->json($categorias, 200);
    }
}
