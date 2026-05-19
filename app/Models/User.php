<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Conexión con tu tabla personalizada en MySQL
    protected $table = 'usuario'; 
    protected $primaryKey = 'id_usuario';

    // Ahora es TRUE porque la base de datos real tiene AUTO_INCREMENT
    public $incrementing = true; 
    protected $keyType = 'int';

    // Campos permitidos para asignación masiva
    protected $fillable = [
        'primer_nom',
        'segund_nom',
        'primer_apelli',
        'segund_apelli',
        'correo',
        'contrasena',
        'estado',
        'fecha_ingreso'
    ];

    // Ocultar la clave en consultas JSON por seguridad
    protected $hidden = [
        'contrasena',
        'remember_token',
    ];

    /**
     * Le dice explícitamente a Laravel que tu columna de password se llama 'contrasena'
     */
    public function getAuthPassword()
    {
        return $this->contrasena;
    }

    // Desactivamos los timestamps automáticos (created_at / updated_at)
    // ya que controlas la fecha manualmente con 'fecha_ingreso'
    public $timestamps = false;
}