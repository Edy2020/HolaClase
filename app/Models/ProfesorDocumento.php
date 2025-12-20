<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfesorDocumento extends Model
{
    use HasFactory;

    protected $fillable = [
        'profesor_id',
        'tipo',
        'ruta_archivo',
    ];

    public function profesor()
    {
        return $this->belongsTo(Profesor::class);
    }
}
