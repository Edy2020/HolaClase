<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('profesores', function (Blueprint $table) {
            $table->string('nivel_ensenanza')->nullable()->after('rut');
        });

        // Migrate existing documents
        $profesores = DB::table('profesores')->whereNotNull('documento_identidad')->get();
        foreach ($profesores as $prof) {
            if (!empty($prof->documento_identidad)) {
                DB::table('profesor_documentos')->insert([
                    'profesor_id' => $prof->id,
                    'tipo' => 'Carnet', // Default assumption for existing files
                    'ruta_archivo' => $prof->documento_identidad,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        Schema::table('profesores', function (Blueprint $table) {
            $table->dropColumn(['especialidad', 'documento_identidad']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profesores', function (Blueprint $table) {
            $table->string('especialidad')->nullable();
            $table->string('documento_identidad')->nullable();
            $table->dropColumn('nivel_ensenanza');
        });
    }
};
