<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Scopes\ProfesorScope;
use Illuminate\Database\Eloquent\Builder;

class Nota extends Model
{
    protected $fillable = [
        'estudiante_id',
        'asignatura_id',
        'curso_id',
        'nota',
        'tipo_evaluacion',
        'periodo',
        'fecha',
        'observaciones',
        'ponderacion',
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new ProfesorScope);
    }

    /**
     * Custom scope application for ProfesorScope.
     */
    public function applyProfesorScope(Builder $builder, $profesorId)
    {
        $builder->whereHas('curso', function ($query) use ($profesorId) {
            $query->where('profesor_id', $profesorId);
        });
    }

    protected $casts = [
        'fecha' => 'date',
        'nota' => 'decimal:1',
        'ponderacion' => 'decimal:2',
    ];

    /**
     * Get the estudiante that owns the nota.
     */
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    /**
     * Get the asignatura for this nota.
     */
    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class);
    }

    /**
     * Get the curso for this nota.
     */
    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    /**
     * Calculate weighted grade.
     */
    public function getNotaPonderadaAttribute()
    {
        return $this->nota * $this->ponderacion;
    }

    /**
     * Get formatted grade display.
     */
    public function getNotaFormattedAttribute()
    {
        return number_format($this->nota, 1);
    }

    /**
     * Get pass/fail status based on Chilean system (>= 4.0).
     */
    public function getEstadoAttribute()
    {
        return $this->nota >= 4.0 ? 'Aprobado' : 'Reprobado';
    }

    /**
     * Get grade color for UI.
     */
    public function getNotaColorAttribute()
    {
        if ($this->nota >= 6.0)
            return 'success';
        if ($this->nota >= 5.0)
            return 'info';
        if ($this->nota >= 4.0)
            return 'warning';
        return 'danger';
    }

    /**
     * Scope a query to only include grades for a specific course.
     */
    public function scopeForCurso($query, $cursoId)
    {
        return $query->where('curso_id', $cursoId);
    }

    /**
     * Scope a query to only include grades for a specific subject.
     */
    public function scopeForAsignatura($query, $asignaturaId)
    {
        return $query->where('asignatura_id', $asignaturaId);
    }

    /**
     * Scope a query to only include grades for a specific student.
     */
    public function scopeForEstudiante($query, $estudianteId)
    {
        return $query->where('estudiante_id', $estudianteId);
    }

    /**
     * Scope a query to only include grades for a specific period.
     */
    public function scopeForPeriodo($query, $periodo)
    {
        return $query->where('periodo', $periodo);
    }

    /**
     * Scope a query to only include grades for a specific evaluation type.
     */
    public function scopeForTipoEvaluacion($query, $tipo)
    {
        return $query->where('tipo_evaluacion', $tipo);
    }

    /**
     * Scope a query to only include passing grades.
     */
    public function scopeAprobado($query)
    {
        return $query->where('nota', '>=', 4.0);
    }

    /**
     * Scope a query to only include failing grades.
     */
    public function scopeReprobado($query)
    {
        return $query->where('nota', '<', 4.0);
    }
}
