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
        Schema::create('notas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estudiante_id')->constrained('estudiantes')->cascadeOnDelete();
            $table->foreignId('asignatura_id')->constrained('asignaturas')->cascadeOnDelete();
            $table->foreignId('curso_id')->constrained('cursos')->cascadeOnDelete();
            $table->decimal('nota', 3, 1); // e.g., 7.0, 6.5
            $table->string('tipo_evaluacion')->nullable(); // Prueba, Trabajo, Examen, etc.
            $table->string('periodo')->nullable(); // Semestre 1, Semestre 2, etc.
            $table->date('fecha')->default(now());
            $table->text('observaciones')->nullable();
            $table->decimal('ponderacion', 3, 2)->default(1.00); // Peso de la nota (0.00 - 1.00)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notas');
    }
};
