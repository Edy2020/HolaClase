<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prueba extends Model
{
    protected $fillable = [
        'curso_id',
        'asignatura_id',
        'titulo',
        'descripcion',
        'fecha',
        'hora',
        'ponderacion',
    ];

    protected $casts = [
        'fecha' => 'date',
    ];

    /**
     * Get the curso that owns the prueba.
     */
    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    /**
     * Get the asignatura that owns the prueba.
     */
    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class);
    }
}
