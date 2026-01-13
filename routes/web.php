<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\ProfesorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Module Routes - Spanish
    // Route::get('/cursos', function () {
    //     return view('cursos.index');
    // })->name('courses.index');

    Route::resource('cursos', App\Http\Controllers\CursoController::class)->names([
        'index' => 'courses.index',
        'create' => 'courses.create',
        'store' => 'courses.store',
        'show' => 'courses.show',
        'edit' => 'courses.edit',
        'update' => 'courses.update',
        'destroy' => 'courses.destroy',
    ]);

    // Additional course management routes
    Route::post('/cursos/{curso}/assign-teacher', [App\Http\Controllers\CursoController::class, 'assignTeacher'])->name('courses.assign-teacher');
    Route::post('/cursos/{curso}/students', [App\Http\Controllers\CursoController::class, 'addStudent'])->name('courses.add-student');
    Route::delete('/cursos/{curso}/students/{estudiante}', [App\Http\Controllers\CursoController::class, 'removeStudent'])->name('courses.remove-student');
    Route::post('/cursos/{curso}/subjects', [App\Http\Controllers\CursoController::class, 'addSubject'])->name('courses.add-subject');
    Route::delete('/cursos/{curso}/subjects/{asignatura}', [App\Http\Controllers\CursoController::class, 'removeSubject'])->name('courses.remove-subject');
    Route::post('/cursos/{curso}/events', [App\Http\Controllers\CursoController::class, 'storeEvent'])->name('courses.store-event');
    Route::delete('/cursos/{curso}/events/{evento}', [App\Http\Controllers\CursoController::class, 'destroyEvent'])->name('courses.destroy-event');
    Route::post('/cursos/{curso}/tests', [App\Http\Controllers\CursoController::class, 'storeTest'])->name('courses.store-test');
    Route::delete('/cursos/{curso}/tests/{prueba}', [App\Http\Controllers\CursoController::class, 'destroyTest'])->name('courses.destroy-test');

    Route::resource('estudiantes', App\Http\Controllers\EstudianteController::class)->names([
        'index' => 'students.index',
        'create' => 'students.create',
        'store' => 'students.store',
        'show' => 'students.show',
        'edit' => 'students.edit',
        'update' => 'students.update',
        'destroy' => 'students.destroy',
    ]);


    Route::resource('asignaturas', App\Http\Controllers\AsignaturaController::class)->names([
        'index' => 'subjects.index',
        'create' => 'subjects.create',
        'store' => 'subjects.store',
        'show' => 'subjects.show',
        'edit' => 'subjects.edit',
        'update' => 'subjects.update',
        'destroy' => 'subjects.destroy',
    ]);

    // Route::get('/profesores', function () {
    //    return view('profesores.index');
    // })->name('teachers.index');

    Route::resource('profesores', ProfesorController::class)->names([
        'index' => 'teachers.index',
        'create' => 'teachers.create',
        'store' => 'teachers.store',
        'show' => 'teachers.show',
        'edit' => 'teachers.edit',
        'update' => 'teachers.update',
        'destroy' => 'teachers.destroy',
    ]);

    Route::get('/asistencia', function () {
        return view('asistencia.index');
    })->name('attendance.index');

    Route::get('/notas', function () {
        return view('notas.index');
    })->name('grades.index');

    // Settings Routes
    Route::get('/configuracion', [ConfiguracionController::class, 'index'])->name('settings.index');
    Route::post('/configuracion/tema', [ConfiguracionController::class, 'updateTheme'])->name('settings.theme');
});

require __DIR__ . '/auth.php';
