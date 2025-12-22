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
        Schema::table('cursos', function (Blueprint $table) {
            // Add unique constraint for the combination of nivel, grado, and letra
            $table->unique(['nivel', 'grado', 'letra'], 'cursos_nivel_grado_letra_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cursos', function (Blueprint $table) {
            // Drop the unique constraint
            $table->dropUnique('cursos_nivel_grado_letra_unique');
        });
    }
};
