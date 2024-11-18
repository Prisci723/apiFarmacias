<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FarmaciaProducto extends Model
{
    protected $table='farmacia_productos';
    public $timestamps = false;

    protected $fillable=[
        'id_farmacia',
        'id_producto',
        'id_sucursal',
        'precio',
        'disponibilidad',
    ];
}
