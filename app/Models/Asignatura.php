<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asignatura extends Model
{
    protected $fillable = [
        'nombre',
        'codigo',
        'descripcion',
    ];

    /**
     * Get the cursos that have this asignatura.
     */
    public function cursos()
    {
        return $this->belongsToMany(Curso::class, 'curso_asignatura')
            ->withTimestamps()
            ->withPivot('profesor_id');
    }

    /**
     * Get the pruebas for this asignatura.
     */
    public function pruebas()
    {
        return $this->hasMany(Prueba::class);
    }
}
