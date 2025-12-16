<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ConfiguracionController;
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
    Route::get('/cursos', function () {
        return view('cursos.index');
    })->name('courses.index');
    
    Route::get('/estudiantes', function () {
        return view('estudiantes.index');
    })->name('students.index');
    
    Route::get('/asignaturas', function () {
        return view('asignaturas.index');
    })->name('subjects.index');
    
    Route::get('/profesores', function () {
        return view('profesores.index');
    })->name('teachers.index');
    
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

require __DIR__.'/auth.php';
