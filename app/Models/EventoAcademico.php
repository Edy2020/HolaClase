<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventoAcademico extends Model
{
    protected $table = 'eventos_academicos';

    protected $fillable = [
        'curso_id',
        'titulo',
        'descripcion',
        'fecha_inicio',
        'fecha_fin',
        'tipo',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
    ];

    /**
     * Get the curso that owns the evento.
     */
    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }
}
