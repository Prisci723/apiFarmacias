<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/Farmacia.php

class Ubicaciones extends Model
{
    protected $fillable = [
        'direccion',
        'latitud',
        'longitud'
    ];
}