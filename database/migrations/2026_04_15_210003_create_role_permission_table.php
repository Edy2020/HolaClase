<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('role_permission', function (Blueprint $table) {
            $table->foreignId('role_id')->constrained()->cascadeOnDelete();
            $table->foreignId('permission_id')->constrained()->cascadeOnDelete();
            $table->primary(['role_id', 'permission_id']);
        });

        $adminRole = DB::table('roles')->where('name', 'admin')->first();
        $allPermissions = DB::table('permissions')->pluck('id');

        $pivotData = $allPermissions->map(fn($permId) => [
            'role_id' => $adminRole->id,
            'permission_id' => $permId,
        ])->toArray();

        DB::table('role_permission')->insert($pivotData);

        $profesorRole = DB::table('roles')->where('name', 'profesor')->first();
        $profesorPermissions = DB::table('permissions')
            ->whereIn('name', ['cursos.ver', 'asignaturas.ver', 'estudiantes.ver', 'asistencia.ver', 'asistencia.crear', 'notas.ver', 'notas.crear'])
            ->pluck('id');

        $profesorPivot = $profesorPermissions->map(fn($permId) => [
            'role_id' => $profesorRole->id,
            'permission_id' => $permId,
        ])->toArray();

        DB::table('role_permission')->insert($profesorPivot);
    }

    public function down(): void
    {
        Schema::dropIfExists('role_permission');
    }
};
