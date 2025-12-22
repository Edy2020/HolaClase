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
        'nivel_ensenanza', // Renamed from especialidad
        'titulo',
        // 'documento_identidad' removed, now in related table
    ];

    public function documentos()
    {
        return $this->hasMany(ProfesorDocumento::class);
    }

    /**
     * Get the cursos where this profesor is assigned as the main teacher.
     */
    public function cursos()
    {
        return $this->hasMany(Curso::class, 'profesor_id');
    }

    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];
}
