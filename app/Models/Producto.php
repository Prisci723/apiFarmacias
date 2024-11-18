<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table='productos';
    public $timestamps = false;

    protected $fillable=[
        'nombre',
        'descripcion',
        'imagen_url',
        'id_categoria'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }
    
    public function farmacias()
    {
        return $this->belongsToMany(Farmacia::class, 'farmacia_productos', 'id_producto', 'id_farmacia');
    }
}
