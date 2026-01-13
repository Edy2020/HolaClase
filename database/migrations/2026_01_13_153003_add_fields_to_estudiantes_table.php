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
        Schema::table('estudiantes', function (Blueprint $table) {
            $table->foreignId('apoderado_id')->nullable()->after('direccion')->constrained('apoderados')->nullOnDelete();
            $table->string('genero')->nullable()->after('apellido');
            $table->string('nacionalidad')->default('Chilena')->after('genero');
            $table->string('ciudad')->nullable()->after('direccion');
            $table->string('region')->nullable()->after('ciudad');
            $table->enum('estado', ['activo', 'inactivo', 'retirado'])->default('activo')->after('region');
            $table->string('foto_perfil')->nullable()->after('estado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('estudiantes', function (Blueprint $table) {
            $table->dropForeign(['apoderado_id']);
            $table->dropColumn([
                'apoderado_id',
                'genero',
                'nacionalidad',
                'ciudad',
                'region',
                'estado',
                'foto_perfil'
            ]);
        });
    }
};
