<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('curso_id')->constrained('cursos')->cascadeOnDelete();
            $table->foreignId('asignatura_id')->constrained('asignaturas')->cascadeOnDelete();
            $table->foreignId('estudiante_id')->constrained('estudiantes')->cascadeOnDelete();
            $table->date('fecha');
            $table->enum('estado', ['presente', 'ausente', 'tarde', 'justificado'])->default('presente');
            $table->text('notas')->nullable();
            $table->timestamps();

            // Ensure one attendance record per student per subject per day
            $table->unique(['curso_id', 'asignatura_id', 'estudiante_id', 'fecha'], 'asistencia_unique');

            // Index for faster queries
            $table->index(['curso_id', 'fecha']);
            $table->index(['estudiante_id', 'fecha']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};
