<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
