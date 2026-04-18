<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Scopes\ProfesorScope;

class Curso extends Model
{
    protected $fillable = [
        'nivel',
        'grado',
        'letra',
        'nombre',
        'profesor_id',
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new ProfesorScope);
    }

    /**
     * Get the profesor assigned to this curso.
     */
    public function profesor()
    {
        return $this->belongsTo(Profesor::class, 'profesor_id');
    }

    /**
     * Get the estudiantes enrolled in this curso.
     */
    public function estudiantes()
    {
        return $this->belongsToMany(Estudiante::class, 'curso_estudiante')
            ->withTimestamps()
            ->withPivot('fecha_inscripcion')
            ->withCasts(['fecha_inscripcion' => 'date']);
    }

    /**
     * Get the asignaturas for this curso.
     */
    public function asignaturas()
    {
        return $this->belongsToMany(Asignatura::class, 'curso_asignatura')
            ->withTimestamps()
            ->withPivot('profesor_id');
    }

    /**
     * Get the eventos academicos for this curso.
     */
    public function eventos()
    {
        return $this->hasMany(EventoAcademico::class);
    }

    /**
     * Get the pruebas for this curso.
     */
    public function pruebas()
    {
        return $this->hasMany(Prueba::class);
    }

    /**
     * Get the notas for this curso.
     */
    public function notas()
    {
        return $this->hasMany(Nota::class);
    }
}
