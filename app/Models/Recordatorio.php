<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recordatorio extends Model
{
    protected $table = 'recordatorios';

    protected $fillable = [
        'user_id',
        'titulo',
        'descripcion',
        'fecha',
        'hora',
        'importancia',
        'completado',
    ];

    protected $casts = [
        'fecha' => 'date',
        'completado' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
