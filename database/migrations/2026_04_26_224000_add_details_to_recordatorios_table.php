<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('recordatorios', function (Blueprint $table) {
            $table->text('descripcion')->nullable()->after('titulo');
            $table->string('importancia', 20)->default('normal')->after('hora');
        });
    }

    public function down(): void
    {
        Schema::table('recordatorios', function (Blueprint $table) {
            $table->dropColumn(['descripcion', 'importancia']);
        });
    }
};
