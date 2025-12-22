<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    protected $fillable = [
        'rut',
        'nombre',
        'apellido',
        'fecha_nacimiento',
        'email',
        'telefono',
        'direccion',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];

    /**
     * Get the cursos that the student is enrolled in.
     */
    public function cursos()
    {
        return $this->belongsToMany(Curso::class, 'curso_estudiante')
            ->withTimestamps()
            ->withPivot('fecha_inscripcion');
    }

    /**
     * Get the student's full name.
     */
    public function getNombreCompletoAttribute()
    {
        return "{$this->nombre} {$this->apellido}";
    }
}
