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
        Schema::create('profesor_documentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profesor_id')->constrained('profesores')->onDelete('cascade');
            $table->string('tipo'); // 'Carnet', 'Certificado de Nacimiento', 'Certificado de Titulo', 'Certificado de Habilitacion'
            $table->string('ruta_archivo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profesor_documentos');
    }
};
