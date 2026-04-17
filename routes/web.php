<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\ProfesorController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Module Routes - Spanish
    // Route::get('/cursos', function () {
    //     return view('cursos.index');
    // })->name('courses.index');

    Route::get('/cursos', [App\Http\Controllers\CursoController::class, 'index'])->name('courses.index');

    Route::middleware('admin')->group(function () {
        Route::post('/cursos/import', [App\Http\Controllers\CursoController::class, 'import'])->name('courses.import');
        Route::get('/cursos/create', [App\Http\Controllers\CursoController::class, 'create'])->name('courses.create');
        Route::post('/cursos', [App\Http\Controllers\CursoController::class, 'store'])->name('courses.store');
        Route::get('/cursos/{curso}/edit', [App\Http\Controllers\CursoController::class, 'edit'])->name('courses.edit');
        Route::put('/cursos/{curso}', [App\Http\Controllers\CursoController::class, 'update'])->name('courses.update');
        Route::patch('/cursos/{curso}', [App\Http\Controllers\CursoController::class, 'update']);
        Route::delete('/cursos/{curso}', [App\Http\Controllers\CursoController::class, 'destroy'])->name('courses.destroy');

        Route::post('/cursos/{curso}/assign-teacher', [App\Http\Controllers\CursoController::class, 'assignTeacher'])->name('courses.assign-teacher');
        Route::post('/cursos/{curso}/students', [App\Http\Controllers\CursoController::class, 'addStudent'])->name('courses.add-student');
        Route::delete('/cursos/{curso}/students/{estudiante}', [App\Http\Controllers\CursoController::class, 'removeStudent'])->name('courses.remove-student');
        Route::post('/cursos/{curso}/subjects', [App\Http\Controllers\CursoController::class, 'addSubject'])->name('courses.add-subject');
        Route::delete('/cursos/{curso}/subjects/{asignatura}', [App\Http\Controllers\CursoController::class, 'removeSubject'])->name('courses.remove-subject');
        Route::post('/cursos/{curso}/events', [App\Http\Controllers\CursoController::class, 'storeEvent'])->name('courses.store-event');
        Route::delete('/cursos/{curso}/events/{evento}', [App\Http\Controllers\CursoController::class, 'destroyEvent'])->name('courses.destroy-event');
        Route::post('/cursos/{curso}/tests', [App\Http\Controllers\CursoController::class, 'storeTest'])->name('courses.store-test');
        Route::delete('/cursos/{curso}/tests/{prueba}', [App\Http\Controllers\CursoController::class, 'destroyTest'])->name('courses.destroy-test');

        Route::post('/estudiantes/import', [App\Http\Controllers\EstudianteController::class, 'import'])->name('students.import');
        Route::resource('estudiantes', App\Http\Controllers\EstudianteController::class)->names([
            'index' => 'students.index',
            'create' => 'students.create',
            'store' => 'students.store',
            'show' => 'students.show',
            'edit' => 'students.edit',
            'update' => 'students.update',
            'destroy' => 'students.destroy',
        ]);
        Route::patch('/estudiantes/{estudiante}/status', [App\Http\Controllers\EstudianteController::class, 'updateStatus'])->name('students.update-status');

        Route::post('/asignaturas/import', [App\Http\Controllers\AsignaturaController::class, 'import'])->name('subjects.import');
        Route::resource('asignaturas', App\Http\Controllers\AsignaturaController::class)->names([
            'index' => 'subjects.index',
            'create' => 'subjects.create',
            'store' => 'subjects.store',
            'show' => 'subjects.show',
            'edit' => 'subjects.edit',
            'update' => 'subjects.update',
            'destroy' => 'subjects.destroy',
        ]);

        Route::post('/profesores/import', [ProfesorController::class, 'import'])->name('teachers.import');
        Route::resource('profesores', ProfesorController::class)->names([
            'index' => 'teachers.index',
            'create' => 'teachers.create',
            'store' => 'teachers.store',
            'show' => 'teachers.show',
            'edit' => 'teachers.edit',
            'update' => 'teachers.update',
            'destroy' => 'teachers.destroy',
        ]);
    });

    Route::get('/cursos/{curso}', [App\Http\Controllers\CursoController::class, 'show'])->name('courses.show');

    Route::get('asistencia/dashboard', [App\Http\Controllers\AsistenciaController::class, 'dashboard'])->name('attendance.dashboard');
    Route::get('asistencia/reporte/curso/{curso}', [App\Http\Controllers\AsistenciaController::class, 'reportePorCurso'])->name('attendance.reporte.curso');
    Route::get('asistencia/reporte/estudiante/{estudiante}', [App\Http\Controllers\AsistenciaController::class, 'reportePorEstudiante'])->name('attendance.reporte.estudiante');

    Route::resource('asistencia', App\Http\Controllers\AsistenciaController::class)->names([
        'index' => 'attendance.index',
        'create' => 'attendance.create',
        'store' => 'attendance.store',
        'show' => 'attendance.show',
        'edit' => 'attendance.edit',
        'update' => 'attendance.update',
        'destroy' => 'attendance.destroy',
    ])->parameters(['asistencia' => 'asistencia']);

    Route::get('notas/dashboard', [App\Http\Controllers\NotaController::class, 'dashboard'])->name('grades.dashboard');
    Route::get('notas/estadisticas', [App\Http\Controllers\NotaController::class, 'estadisticas'])->name('grades.estadisticas');
    Route::get('notas/export/pdf', [App\Http\Controllers\NotaController::class, 'exportPDF'])->name('grades.export.pdf');
    Route::get('notas/export/excel', [App\Http\Controllers\NotaController::class, 'exportExcel'])->name('grades.export.excel');

    Route::resource('notas', App\Http\Controllers\NotaController::class)->names([
        'index' => 'grades.index',
        'create' => 'grades.create',
        'store' => 'grades.store',
        'show' => 'grades.show',
        'edit' => 'grades.edit',
        'update' => 'grades.update',
        'destroy' => 'grades.destroy',
    ]);

    Route::get('notas/reporte/curso/{curso}', [App\Http\Controllers\NotaController::class, 'reportePorCurso'])->name('grades.reporte.curso');
    Route::get('notas/reporte/estudiante/{estudiante}', [App\Http\Controllers\NotaController::class, 'reportePorEstudiante'])->name('grades.reporte.estudiante');
    Route::get('notas/libreta/{estudiante}', [App\Http\Controllers\NotaController::class, 'libreta'])->name('grades.libreta');

    Route::middleware('admin')->prefix('usuarios')->group(function () {
        Route::get('/', [App\Http\Controllers\UsuarioController::class, 'index'])->name('users.index');
        Route::get('/crear', [App\Http\Controllers\UsuarioController::class, 'crear'])->name('users.crear');
        Route::get('/gestionar', [App\Http\Controllers\UsuarioController::class, 'gestionar'])->name('users.gestionar');
        Route::get('/roles', [App\Http\Controllers\UsuarioController::class, 'roles'])->name('users.roles');
        Route::post('/', [App\Http\Controllers\UsuarioController::class, 'storeUser'])->name('users.store');
        Route::post('/grant-access', [App\Http\Controllers\UsuarioController::class, 'grantAccess'])->name('users.grant-access');
        Route::post('/roles', [App\Http\Controllers\UsuarioController::class, 'storeRole'])->name('users.roles.store');
        Route::patch('/roles/{role}', [App\Http\Controllers\UsuarioController::class, 'updateRole'])->name('users.roles.update');
        Route::delete('/roles/{role}', [App\Http\Controllers\UsuarioController::class, 'destroyRole'])->name('users.roles.destroy');
        Route::get('/{user}', [App\Http\Controllers\UsuarioController::class, 'showUser'])->name('users.show');
        Route::patch('/{user}/password', [App\Http\Controllers\UsuarioController::class, 'updatePassword'])->name('users.update-password');
        Route::post('/{user}/notify', [App\Http\Controllers\UsuarioController::class, 'notifyUser'])->name('users.notify');
        Route::delete('/{user}', [App\Http\Controllers\UsuarioController::class, 'revokeAccess'])->name('users.revoke-access');
    });
});

require __DIR__ . '/auth.php';
