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
        Schema::table('profesores', function (Blueprint $table) {
            $table->string('rut')->nullable()->unique()->after('id');
            $table->date('fecha_nacimiento')->nullable()->after('apellido');
            $table->string('titulo')->nullable()->after('especialidad');
            $table->string('documento_identidad')->nullable()->after('titulo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profesores', function (Blueprint $table) {
            $table->dropColumn(['rut', 'fecha_nacimiento', 'titulo', 'documento_identidad']);
        });
    }
};
