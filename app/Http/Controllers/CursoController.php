<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Profesor;
use App\Models\Estudiante;
use App\Models\Asignatura;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cursos = Curso::orderBy('nivel')->orderBy('grado')->orderBy('letra')->paginate(12);
        return view('cursos.index', compact('cursos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cursos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nivel' => 'required|string',
            'grado' => 'nullable|string',
            'letra' => 'required|string|max:5',
        ]);

        // Check for duplicate curso
        $exists = Curso::where('nivel', $request->nivel)
            ->where('grado', $request->grado)
            ->where('letra', $request->letra)
            ->exists();

        if ($exists) {
            return back()->withErrors([
                'letra' => 'Ya existe un curso con esta combinación de nivel, grado y letra.'
            ])->withInput();
        }

        $nivel = $request->nivel;
        $grado = $request->grado;
        $letra = $request->letra;

        // Nombres completos de grados
        $nombresGrados = [
            '1°' => 'Primero',
            '2°' => 'Segundo',
            '3°' => 'Tercero',
            '4°' => 'Cuarto',
            '5°' => 'Quinto',
            '6°' => 'Sexto',
            '7°' => 'Séptimo',
            '8°' => 'Octavo',
        ];

        $nombre = '';

        // Generate Name Logic
        if ($nivel === 'Pre-Kinder' || $nivel === 'Kinder') {
            $nombre = "{$nivel} {$letra}";
            $grado = null; // Ensure grade is null for these levels
        } elseif ($nivel === 'Basica') {
            $nombreGrado = $nombresGrados[$grado] ?? $grado;
            $nombre = "{$grado}{$nombreGrado} Básico {$letra}";
        } elseif ($nivel === 'Media') {
            $nombreGrado = $nombresGrados[$grado] ?? $grado;
            $nombre = "{$grado}{$nombreGrado} Medio {$letra}";
        }

        Curso::create([
            'nivel' => $nivel,
            'grado' => $grado,
            'letra' => $letra,
            'nombre' => $nombre,
        ]);

        return redirect()->route('courses.index')->with('success', 'Curso creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Curso $curso)
    {
        // Load all relationships
        $curso->load([
            'profesor',
            'estudiantes',
            'asignaturas',
            'eventos' => function ($query) {
                $query->orderBy('fecha_inicio', 'asc');
            },
            'pruebas' => function ($query) {
                $query->with('asignatura')->orderBy('fecha', 'asc');
            }
        ]);

        // Get all profesores for the dropdown
        $profesores = Profesor::orderBy('nombre')->get();

        // Get all estudiantes not enrolled in this course
        $estudiantesDisponibles = Estudiante::whereDoesntHave('cursos', function ($query) use ($curso) {
            $query->where('curso_id', $curso->id);
        })->orderBy('nombre')->get();

        // Get all asignaturas not assigned to this course
        $asignaturasDisponibles = Asignatura::whereDoesntHave('cursos', function ($query) use ($curso) {
            $query->where('curso_id', $curso->id);
        })->orderBy('nombre')->get();

        return view('cursos.show', compact('curso', 'profesores', 'estudiantesDisponibles', 'asignaturasDisponibles'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Curso $curso)
    {
        return view('cursos.edit', compact('curso'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Curso $curso)
    {
        $validated = $request->validate([
            'nivel' => 'required|string',
            'grado' => 'nullable|string',
            'letra' => 'required|string|max:5',
        ]);

        // Check for duplicate curso (excluding current record)
        $exists = Curso::where('nivel', $request->nivel)
            ->where('grado', $request->grado)
            ->where('letra', $request->letra)
            ->where('id', '!=', $curso->id)
            ->exists();

        if ($exists) {
            return back()->withErrors([
                'letra' => 'Ya existe un curso con esta combinación de nivel, grado y letra.'
            ])->withInput();
        }

        $nivel = $request->nivel;
        $grado = $request->grado;
        $letra = $request->letra;

        // Nombres completos de grados
        $nombresGrados = [
            '1°' => 'Primero',
            '2°' => 'Segundo',
            '3°' => 'Tercero',
            '4°' => 'Cuarto',
            '5°' => 'Quinto',
            '6°' => 'Sexto',
            '7°' => 'Séptimo',
            '8°' => 'Octavo',
        ];

        $nombre = '';

        // Generate Name Logic
        if ($nivel === 'Pre-Kinder' || $nivel === 'Kinder') {
            $nombre = "{$nivel} {$letra}";
            $grado = null; // Ensure grade is null for these levels
        } elseif ($nivel === 'Basica') {
            $nombreGrado = $nombresGrados[$grado] ?? $grado;
            $nombre = "{$grado}{$nombreGrado} Básico {$letra}";
        } elseif ($nivel === 'Media') {
            $nombreGrado = $nombresGrados[$grado] ?? $grado;
            $nombre = "{$grado}{$nombreGrado} Medio {$letra}";
        }

        $curso->update([
            'nivel' => $nivel,
            'grado' => $grado,
            'letra' => $letra,
            'nombre' => $nombre,
        ]);

        return redirect()->route('courses.index')->with('success', 'Curso actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Curso $curso)
    {
        $curso->delete();
        return redirect()->route('courses.index')->with('success', 'Curso eliminado correctamente.');
    }

    /**
     * Assign a teacher to the course.
     */
    public function assignTeacher(Request $request, Curso $curso)
    {
        $request->validate([
            'profesor_id' => 'nullable|exists:profesores,id',
        ]);

        $curso->update(['profesor_id' => $request->profesor_id]);

        return redirect()->route('courses.show', $curso)->with('success', 'Profesor asignado correctamente.');
    }

    /**
     * Add a student to the course.
     */
    public function addStudent(Request $request, Curso $curso)
    {
        $request->validate([
            'estudiante_id' => 'required|exists:estudiantes,id',
            'fecha_inscripcion' => 'nullable|date',
        ]);

        $curso->estudiantes()->attach($request->estudiante_id, [
            'fecha_inscripcion' => $request->fecha_inscripcion ?? now(),
        ]);

        return redirect()->route('courses.show', $curso)->with('success', 'Estudiante agregado correctamente.');
    }

    /**
     * Remove a student from the course.
     */
    public function removeStudent(Curso $curso, $estudianteId)
    {
        $curso->estudiantes()->detach($estudianteId);

        return redirect()->route('courses.show', $curso)->with('success', 'Estudiante removido correctamente.');
    }

    /**
     * Add a subject to the course.
     */
    public function addSubject(Request $request, Curso $curso)
    {
        $request->validate([
            'asignatura_id' => 'required|exists:asignaturas,id',
            'profesor_id' => 'nullable|exists:profesores,id',
        ]);

        $curso->asignaturas()->attach($request->asignatura_id, [
            'profesor_id' => $request->profesor_id,
        ]);

        return redirect()->route('courses.show', $curso)->with('success', 'Asignatura agregada correctamente.');
    }

    /**
     * Remove a subject from the course.
     */
    public function removeSubject(Curso $curso, $asignaturaId)
    {
        $curso->asignaturas()->detach($asignaturaId);

        return redirect()->route('courses.show', $curso)->with('success', 'Asignatura removida correctamente.');
    }

    /**
     * Store a new academic event.
     */
    public function storeEvent(Request $request, Curso $curso)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'tipo' => 'required|in:vacaciones,reunion,actividad,examen,otro',
        ]);

        $curso->eventos()->create($request->all());

        return redirect()->route('courses.show', $curso)->with('success', 'Evento creado correctamente.');
    }

    /**
     * Delete an academic event.
     */
    public function destroyEvent(Curso $curso, $eventoId)
    {
        $evento = $curso->eventos()->findOrFail($eventoId);
        $evento->delete();

        return redirect()->route('courses.show', $curso)->with('success', 'Evento eliminado correctamente.');
    }

    /**
     * Store a new test.
     */
    public function storeTest(Request $request, Curso $curso)
    {
        $request->validate([
            'asignatura_id' => 'required|exists:asignaturas,id',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha' => 'required|date',
            'hora' => 'nullable|date_format:H:i',
            'ponderacion' => 'nullable|integer|min:0|max:100',
        ]);

        $curso->pruebas()->create($request->all());

        return redirect()->route('courses.show', $curso)->with('success', 'Prueba creada correctamente.');
    }

    /**
     * Delete a test.
     */
    public function destroyTest(Curso $curso, $pruebaId)
    {
        $prueba = $curso->pruebas()->findOrFail($pruebaId);
        $prueba->delete();

        return redirect()->route('courses.show', $curso)->with('success', 'Prueba eliminada correctamente.');
    }
}
