<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('notas', function (Blueprint $table) {
            // Índice compuesto para la fase de filtrado (WHERE)
            $table->index(['curso_id', 'periodo'], 'idx_notas_curso_periodo');
            
            // Índice compuesto para optimizar las agrupaciones (GROUP BY)
            $table->index(['estudiante_id', 'asignatura_id'], 'idx_notas_estudiante_asignatura');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('notas', function (Blueprint $table) {
            // Revertir los índices explícitamente por su nombre
            $table->dropIndex('idx_notas_curso_periodo');
            $table->dropIndex('idx_notas_estudiante_asignatura');
        });
    }
};
