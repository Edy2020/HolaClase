<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profesor extends Model
{
    use HasFactory;

    protected $table = 'profesores';

    protected $fillable = [
        'rut',
        'nombre',
        'apellido',
        'fecha_nacimiento',
        'email',
        'telefono',
        'especialidad',
        'titulo',
        'documento_identidad',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];
}
