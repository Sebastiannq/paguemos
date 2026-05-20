<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prenda extends Model
{
    use HasFactory;

    // 1. Definir el nombre real de la tabla en tu base de datos
    protected $table = 'prenda';

    // 2. CAMBIO CLAVE: Definir tu nueva Llave Primaria
    protected $primaryKey = 'codigo_barras';

    // 3. CAMBIO CLAVE: Indicar que la PK no es un entero autoincrementable
    public $incrementing = false;

    // 4. CAMBIO CLAVE: Indicar que el tipo de la PK es un string
    protected $keyType = 'string';

    // Desactivar timestamps si tu tabla no tiene 'created_at' y 'updated_at'
    public $timestamps = false; 

    protected $fillable = [
        'codigo_barras', // Ahora debe ser llenable al crear
        'nombre_prend',
        'descripcion_prend',
        'precio',
        'stock',
        'min_stock',
        'max_stock',
        'fk_id_genero',
        'fk_idt_prendas',
        'fk_id_color',
        'estado',
        'fecha_registro',
        'imagen_prend'
    ];
}