<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    protected $fillable = [
        'curso_id',
        'asignatura_id',
        'estudiante_id',
        'fecha',
        'estado',
        'notas',
    ];

    protected $casts = [
        'fecha' => 'date',
    ];

    /**
     * Get the curso that owns the asistencia.
     */
    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    /**
     * Get the asignatura that owns the asistencia.
     */
    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class);
    }

    /**
     * Get the estudiante that owns the asistencia.
     */
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    /**
     * Scope a query to only include attendance for a specific course.
     */
    public function scopeForCurso($query, $cursoId)
    {
        return $query->where('curso_id', $cursoId);
    }

    /**
     * Scope a query to only include attendance for a specific subject.
     */
    public function scopeForAsignatura($query, $asignaturaId)
    {
        return $query->where('asignatura_id', $asignaturaId);
    }

    /**
     * Scope a query to only include attendance for a specific student.
     */
    public function scopeForEstudiante($query, $estudianteId)
    {
        return $query->where('estudiante_id', $estudianteId);
    }

    /**
     * Scope a query to only include attendance for a specific date.
     */
    public function scopeForFecha($query, $fecha)
    {
        return $query->whereDate('fecha', $fecha);
    }

    /**
     * Scope a query to only include attendance within a date range.
     */
    public function scopeForDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('fecha', [$startDate, $endDate]);
    }

    /**
     * Scope a query to only include present students.
     */
    public function scopePresente($query)
    {
        return $query->where('estado', 'presente');
    }

    /**
     * Scope a query to only include absent students.
     */
    public function scopeAusente($query)
    {
        return $query->where('estado', 'ausente');
    }

    /**
     * Get the estado label in Spanish.
     */
    public function getEstadoLabelAttribute()
    {
        $labels = [
            'presente' => 'Presente',
            'ausente' => 'Ausente',
            'tarde' => 'Tarde',
            'justificado' => 'Justificado',
        ];

        return $labels[$this->estado] ?? $this->estado;
    }

    /**
     * Get the estado color for UI.
     */
    public function getEstadoColorAttribute()
    {
        $colors = [
            'presente' => 'success',
            'ausente' => 'danger',
            'tarde' => 'warning',
            'justificado' => 'info',
        ];

        return $colors[$this->estado] ?? 'secondary';
    }
}
