<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apoderado extends Model
{
    protected $fillable = [
        'rut',
        'nombre',
        'apellido',
        'relacion',
        'telefono',
        'email',
        'direccion',
        'telefono_emergencia',
        'ocupacion',
        'lugar_trabajo',
    ];

    /**
     * Get the estudiantes that belong to this apoderado.
     */
    public function estudiantes()
    {
        return $this->hasMany(Estudiante::class);
    }

    /**
     * Get the apoderado's full name.
     */
    public function getNombreCompletoAttribute()
    {
        return "{$this->nombre} {$this->apellido}";
    }
}
