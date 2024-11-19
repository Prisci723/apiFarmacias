<?php
namespace App\Http\Controllers;

use App\Models\Farmacia;
use App\Models\Ubicaciones;
use DB;
use Illuminate\Http\Request;

class UbicacionController extends Controller
{
    public function obtenerUbicacionMasCercana($latitud, $longitud)
{
    // Redondeamos las coordenadas de entrada a 4 decimales
    $latitud = round($latitud, 4);
    $longitud = round($longitud, 4);
    
    // Obtenemos la hora actual
    $horaActual = now()->format('H:i');
    
    // Buscamos la farmacia más cercana
    $farmacia = DB::table('farmacias')
        ->join('ubicaciones', 'farmacias.id_ubicacion', '=', 'ubicaciones.id')
        ->select(
            'farmacias.id',
            'farmacias.nombre',
            'farmacias.telefono',
            'farmacias.email',
            'farmacias.horario',
            'farmacias.servicios',
            'farmacias.turno',
            'farmacias.id_ubicacion',
            'ubicaciones.id as ubicacion_id',
            'ubicaciones.direccion',
            DB::raw('ROUND(ubicaciones.latitud, 4) as latitud'),
            DB::raw('ROUND(ubicaciones.longitud, 4) as longitud')
        )
        ->selectRaw(
            'ROUND(
                (6371 * acos(
                    cos(radians(?)) * cos(radians(ubicaciones.latitud)) * 
                    cos(radians(ubicaciones.longitud) - radians(?)) + 
                    sin(radians(?)) * sin(radians(ubicaciones.latitud))
                )
            ), 4) AS distancia',
            [$latitud, $longitud, $latitud]
        )
        ->where('farmacias.turno', 1)
        ->orWhereRaw(
            '? BETWEEN SUBSTRING_INDEX(farmacias.horario, " - ", 1) 
            AND SUBSTRING_INDEX(farmacias.horario, " - ", -1)',
            [$horaActual]
        )
        ->orderBy('distancia')
        ->first();

    if (!$farmacia) {
        return response()->json([
            'mensaje' => 'No se encontraron farmacias abiertas cercanas'
        ], 404);
    }

    // Preparamos la respuesta con la estructura deseada
    $respuesta = [
        'ubicacion' => [
            'id' => $farmacia->ubicacion_id,
            'direccion' => $farmacia->direccion,
            'latitud' => $farmacia->latitud,
            'longitud' => $farmacia->longitud,
            'distancia' => $farmacia->distancia // distancia en kilómetros
        ]
    ];
    
    return response()->json($respuesta, 200);
}
    // public function obtenerUbicacionMasCercana($latitud, $longitud)
    // {
    //     // Redondeamos las coordenadas de entrada a 4 decimales
    //     $latitud = round($latitud, 4);
    //     $longitud = round($longitud, 4);
        
    //     // Obtenemos la hora actual
    //     $horaActual = now()->format('H:i');
        
    //     // Unimos las tablas farmacias y ubicaciones
    //     $farmacia = Farmacia::join('ubicaciones', 'farmacias.id_ubicacion', '=', 'ubicaciones.id')
    //         ->select(
    //             'farmacias.*',
    //             DB::raw('ROUND(ubicaciones.latitud, 4) as latitud'),
    //             DB::raw('ROUND(ubicaciones.longitud, 4) as longitud'),
    //             'ubicaciones.direccion',
    //             DB::raw("ROUND(
    //                 (6371 * acos(
    //                     cos(radians($latitud)) * cos(radians(ubicaciones.latitud)) * 
    //                     cos(radians(ubicaciones.longitud) - radians($longitud)) + 
    //                     sin(radians($latitud)) * sin(radians(ubicaciones.latitud))
    //                 )
    //             ), 4) AS distancia")
    //         )
    //         ->where(function($query) use ($horaActual) {
    //             $query->where('farmacias.turno', 1)
    //                   ->orWhere(function($q) use ($horaActual) {
    //                       $q->whereRaw('? BETWEEN SUBSTRING_INDEX(farmacias.horario, " - ", 1) 
    //                                   AND SUBSTRING_INDEX(farmacias.horario, " - ", -1)', [$horaActual]);
    //                   });
    //         })
    //         ->orderBy('distancia')
    //         ->first();
    
    //     if (!$farmacia) {
    //         return response()->json([
    //             'mensaje' => 'No se encontraron farmacias abiertas cercanas'
    //         ], 404);
    //     }
    
    //     // Agregamos la distancia al objeto farmacia
    //     $farmacia->distancia = $farmacia->distancia;
        
    //     return response()->json($farmacia, 200);
    // }
    public function show($id){
        $ubicacion = Ubicaciones::find($id);
        if (!$ubicacion) {
            return response()->json(['message' => 'ubicacion no encontrada'], 404);
        }
        return response()->json($ubicacion, 200);
    }
}
