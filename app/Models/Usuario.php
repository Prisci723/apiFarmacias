<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/Farmacia.php

class Usuario extends Model
{
    protected $fillable = [
        'nombre',
        'email',
        'password',
        'rol',
        'id_ubicacion'
    ];
}