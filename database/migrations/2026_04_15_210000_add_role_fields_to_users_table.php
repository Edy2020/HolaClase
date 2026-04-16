<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('admin')->after('password');
            $table->string('plain_password')->nullable()->after('role');
            $table->foreignId('profesor_id')->nullable()->constrained('profesores')->nullOnDelete()->after('plain_password');
            $table->foreignId('estudiante_id')->nullable()->constrained('estudiantes')->nullOnDelete()->after('profesor_id');
        });

        DB::table('users')->whereNull('role')->orWhere('role', '')->update(['role' => 'admin']);
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['profesor_id']);
            $table->dropForeign(['estudiante_id']);
            $table->dropColumn(['role', 'plain_password', 'profesor_id', 'estudiante_id']);
        });
    }
};
