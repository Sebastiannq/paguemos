<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prenda extends Model
{
    protected $table = 'prenda';
    protected $primaryKey = 'id_prenda';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'nombre_prend',
        'descripcion_prend',
        'precio',
        'estado',
        'fecha_registro',
        'stock',
        'min_stock',
        'max_stock',
        'imagen_prend',
        'fk_id_genero',
        'fk_idt_prendas',
        'fk_id_color'
    ];
}