<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Farmacia;



class farmaciaController extends Controller
{
    public function index()
    {
        $farmacias = Farmacia::all();
        return response()->json($farmacias, 200);
    }

    public function show($id)
    {
        $farmacia = Farmacia::find($id);
        if (!$farmacia) {
            return response()->json(['message' => 'Farmacia no encontrada'], 404);
        }
        return response()->json($farmacia, 200);
    }



    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string|max:50',
            'email' => 'required|email|max:255',
            'horario' => 'required|string|max:100',
            'servicios' => 'nullable|string|max:255',
            'turno' => 'nullable|string|max:50',
            'id_ubicacion' => 'required|integer',
        ]);

        $farmacia = Farmacia::create($validatedData);

        return response()->json($farmacia, 201);
    }



    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nombre' => 'sometimes|required|string|max:255',
            'telefono' => 'sometimes|required|string|max:50',
            'email' => 'sometimes|required|email|max:255',
            'horario' => 'sometimes|required|string|max:100',
            'servicios' => 'sometimes|nullable|string|max:255',
            'turno' => 'sometimes|nullable|string|max:50',
            'id_ubicacion' => 'sometimes|required|integer',
        ]);

        $farmacia = Farmacia::find($id);
        if (!$farmacia) {
            return response()->json(['message' => 'Farmacia no encontrada'], 404);
        }

        $farmacia->update($validatedData);

        return response()->json($farmacia, 200);
    }



    public function destroy($id)
    {
        $farmacia = Farmacia::find($id);
        if (!$farmacia) {
            return response()->json(['message' => 'Farmacia no encontrada'], 404);
        }

        $farmacia->delete();
        return response()->json(['message' => 'Farmacia eliminada correctamente'], 200);
    }

    public function farmaciaProductos($idFarmacia)
    {
        // Busca la farmacia por su ID e incluye los productos con la información de la tabla pivote
        $farmacia = Farmacia::with(['productos' => function ($query) {
            $query->select('productos.*', 'farmacia_productos.precio', 'farmacia_productos.disponibilidad');
        }])->find($idFarmacia);

        if (!$farmacia) {
            return response()->json(['error' => 'Farmacia no encontrada'], 404);
        }

        $productos = $farmacia->productos->map(function ($producto) {
            return [
                'id' => $producto->id,
                'nombre' => $producto->nombre,
                'descripcion' => $producto->descripcion,
                'imagen_url' => $producto->imagen_url,
                'id_categoria' => $producto->id_categoria,
                'precio' => $producto->pivot->precio,
                'disponibilidad' => $producto->pivot->disponibilidad
            ];
        });

        return response()->json($productos, 200);
    }

    public function productosPorCategoria($idFarmacia, $idCategoria)
    {
        // Busca la farmacia por su ID y filtra los productos por la categoría
        $farmacia = Farmacia::with(['productos' => function ($query) use ($idCategoria) {
            $query->where('id_categoria', $idCategoria)
                ->select('productos.*', 'farmacia_productos.precio', 'farmacia_productos.disponibilidad');
        }])->find($idFarmacia);

        if (!$farmacia) {
            return response()->json(['error' => 'Farmacia no encontrada'], 404);
        }

        $productos = $farmacia->productos->map(function ($producto) {
            return [
                'id' => $producto->id,
                'nombre' => $producto->nombre,
                'descripcion' => $producto->descripcion,
                'imagen_url' => $producto->imagen_url,
                'id_categoria' => $producto->id_categoria,
                'precio' => $producto->pivot->precio,
                'disponibilidad' => $producto->pivot->disponibilidad
            ];
        });

        return response()->json($productos, 200);
    }
    public function obtenerFarmaciaUbicacion($id_ubicacion)
    {
        $farmacias = Farmacia::where('id_ubicacion', $id_ubicacion)->get();
        return response()->json($farmacias, 200);
    }
}
