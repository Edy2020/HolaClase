<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('display_name');
            $table->string('description')->nullable();
            $table->string('group');
            $table->timestamps();
        });

        $now = now();
        $permissions = [
            ['name' => 'cursos.ver', 'display_name' => 'Ver Cursos', 'group' => 'Cursos', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'cursos.crear', 'display_name' => 'Crear Cursos', 'group' => 'Cursos', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'cursos.editar', 'display_name' => 'Editar Cursos', 'group' => 'Cursos', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'cursos.eliminar', 'display_name' => 'Eliminar Cursos', 'group' => 'Cursos', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'estudiantes.ver', 'display_name' => 'Ver Estudiantes', 'group' => 'Estudiantes', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'estudiantes.crear', 'display_name' => 'Crear Estudiantes', 'group' => 'Estudiantes', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'estudiantes.editar', 'display_name' => 'Editar Estudiantes', 'group' => 'Estudiantes', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'estudiantes.eliminar', 'display_name' => 'Eliminar Estudiantes', 'group' => 'Estudiantes', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'profesores.ver', 'display_name' => 'Ver Profesores', 'group' => 'Profesores', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'profesores.crear', 'display_name' => 'Crear Profesores', 'group' => 'Profesores', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'profesores.editar', 'display_name' => 'Editar Profesores', 'group' => 'Profesores', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'profesores.eliminar', 'display_name' => 'Eliminar Profesores', 'group' => 'Profesores', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'asignaturas.ver', 'display_name' => 'Ver Asignaturas', 'group' => 'Asignaturas', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'asignaturas.crear', 'display_name' => 'Crear Asignaturas', 'group' => 'Asignaturas', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'asignaturas.editar', 'display_name' => 'Editar Asignaturas', 'group' => 'Asignaturas', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'asignaturas.eliminar', 'display_name' => 'Eliminar Asignaturas', 'group' => 'Asignaturas', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'asistencia.ver', 'display_name' => 'Ver Asistencia', 'group' => 'Asistencia', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'asistencia.crear', 'display_name' => 'Registrar Asistencia', 'group' => 'Asistencia', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'asistencia.editar', 'display_name' => 'Editar Asistencia', 'group' => 'Asistencia', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'asistencia.eliminar', 'display_name' => 'Eliminar Asistencia', 'group' => 'Asistencia', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'notas.ver', 'display_name' => 'Ver Notas', 'group' => 'Notas', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'notas.crear', 'display_name' => 'Crear Notas', 'group' => 'Notas', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'notas.editar', 'display_name' => 'Editar Notas', 'group' => 'Notas', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'notas.eliminar', 'display_name' => 'Eliminar Notas', 'group' => 'Notas', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'usuarios.ver', 'display_name' => 'Ver Usuarios', 'group' => 'Usuarios', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'usuarios.crear', 'display_name' => 'Crear Usuarios', 'group' => 'Usuarios', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'usuarios.editar', 'display_name' => 'Editar Usuarios', 'group' => 'Usuarios', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'usuarios.eliminar', 'display_name' => 'Eliminar Usuarios', 'group' => 'Usuarios', 'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('permissions')->insert($permissions);
    }

    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
