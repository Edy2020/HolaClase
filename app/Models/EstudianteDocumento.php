<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstudianteDocumento extends Model
{
    protected $fillable = [
        'estudiante_id',
        'tipo',
        'ruta_archivo',
        'nombre_original',
        'fecha_subida',
        'observaciones',
    ];

    protected $casts = [
        'fecha_subida' => 'date',
    ];

    /**
     * Get the estudiante that owns the documento.
     */
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    /**
     * Get the full URL for the document.
     */
    public function getUrlAttribute()
    {
        return asset('storage/' . $this->ruta_archivo);
    }
}
