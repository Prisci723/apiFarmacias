<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/Farmacia.php

class Farmacia extends Model
{
    protected $table = 'farmacias';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'telefono',
        'email',
        'horario',
        'servicios',
        'turno',
        'id_ubicacion'
    ];

    public function productos()
    {
        
        return $this->belongsToMany(Producto::class, 'farmacia_productos', 'id_farmacia', 'id_producto')
                    ->withPivot('id_sucursal', 'precio', 'disponibilidad');
    }
}

