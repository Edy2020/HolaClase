<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    protected $fillable = [
        'rut',
        'nombre',
        'apellido',
        'genero',
        'nacionalidad',
        'fecha_nacimiento',
        'email',
        'telefono',
        'direccion',
        'ciudad',
        'region',
        'estado',
        'foto_perfil',
        'apoderado_id',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];

    /**
     * Get the apoderado (guardian) for this student.
     */
    public function apoderado()
    {
        return $this->belongsTo(Apoderado::class);
    }

    /**
     * Get the documentos for this student.
     */
    public function documentos()
    {
        return $this->hasMany(EstudianteDocumento::class);
    }

    /**
     * Get the notas for this student.
     */
    public function notas()
    {
        return $this->hasMany(Nota::class);
    }

    /**
     * Get the cursos that the student is enrolled in.
     */
    public function cursos()
    {
        return $this->belongsToMany(Curso::class, 'curso_estudiante')
            ->withTimestamps()
            ->withPivot('fecha_inscripcion')
            ->withCasts(['fecha_inscripcion' => 'date']);
    }

    /**
     * Get the student's full name.
     */
    public function getNombreCompletoAttribute()
    {
        return "{$this->nombre} {$this->apellido}";
    }

    /**
     * Get the student's age.
     */
    public function getEdadAttribute()
    {
        if (!$this->fecha_nacimiento) {
            return null;
        }
        return $this->fecha_nacimiento->age;
    }

    /**
     * Get the student's current main course.
     */
    public function getCursoActualAttribute()
    {
        return $this->cursos()->latest('curso_estudiante.created_at')->first();
    }

    /**
     * Calculate the student's general average.
     */
    public function getPromedioGeneralAttribute()
    {
        $notas = $this->notas;

        if ($notas->isEmpty()) {
            return null;
        }

        $totalPonderado = $notas->sum(function ($nota) {
            return $nota->nota * $nota->ponderacion;
        });

        $totalPonderacion = $notas->sum('ponderacion');

        return $totalPonderacion > 0 ? round($totalPonderado / $totalPonderacion, 1) : null;
    }

    /**
     * Get average by subject.
     */
    public function getPromedioAsignatura($asignaturaId)
    {
        $notas = $this->notas()->where('asignatura_id', $asignaturaId)->get();

        if ($notas->isEmpty()) {
            return null;
        }

        $totalPonderado = $notas->sum(function ($nota) {
            return $nota->nota * $nota->ponderacion;
        });

        $totalPonderacion = $notas->sum('ponderacion');

        return $totalPonderacion > 0 ? round($totalPonderado / $totalPonderacion, 1) : null;
    }
}
