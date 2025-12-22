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
        // SQLite doesn't support modifying columns, so we need to recreate the table
        Schema::dropIfExists('cursos');

        Schema::create('cursos', function (Blueprint $table) {
            $table->id();
            $table->string('nivel'); // pre kinder, kinder, basica, media
            $table->string('grado')->nullable(); // 1°, 2°, etc (nullable for pre-kinder and kinder)
            $table->string('letra'); // A, B, C
            $table->string('nombre'); // Generated full name
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cursos');

        Schema::create('cursos', function (Blueprint $table) {
            $table->id();
            $table->string('nivel');
            $table->string('grado'); // NOT NULL
            $table->string('letra');
            $table->string('nombre');
            $table->timestamps();
        });
    }
};
