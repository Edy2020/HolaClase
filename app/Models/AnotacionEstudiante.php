<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnotacionEstudiante extends Model
{
    protected $table = 'anotaciones_estudiante';

    protected $fillable = [
        'estudiante_id',
        'user_id',
        'tipo',
        'titulo',
        'descripcion',
        'fecha',
    ];

    protected $casts = [
        'fecha' => 'date',
    ];

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
