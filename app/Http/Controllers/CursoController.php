<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Profesor;
use App\Models\Estudiante;
use App\Models\Asignatura;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    public function index()
    {
        $cursos = Curso::withCount('estudiantes')
            ->with('profesor')
            ->orderBy('nivel')
            ->orderBy('grado')
            ->orderBy('letra')
            ->paginate(12);
        return view('cursos.index', compact('cursos'));
    }

    public function create()
    {
        return view('cursos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nivel' => 'required|string',
            'grado' => 'nullable|string',
            'letra' => 'required|string|max:5',
        ]);

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

        if ($nivel === 'Pre-Kinder' || $nivel === 'Kinder') {
            $nombre = "{$nivel} {$letra}";
            $grado = null; 
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

    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('csv_file');
        
        if (($handle = fopen($file->path(), 'r')) !== false) {
            $count = 0;
            $rowNumber = 0;

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

            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                $rowNumber++;
                
                if ($rowNumber === 1 && (stripos($data[0], 'nivel') !== false)) {
                    continue;
                }

                if (count($data) < 3) continue;

                $nivelRaw = trim($data[0]);
                $gradoRaw = trim($data[1]);
                $letraRaw = trim($data[2]);

                if (empty($nivelRaw) || empty($letraRaw)) continue;

                $grado = $gradoRaw === '' ? null : $gradoRaw;
                $nivelLower = strtolower($nivelRaw);
                if (in_array($nivelLower, ['pre-kinder', 'prekinder', 'pre kinder'])) {
                    $nivel = 'Pre-Kinder';
                } elseif ($nivelLower === 'kinder') {
                    $nivel = 'Kinder';
                } elseif (in_array($nivelLower, ['basica', 'básica', 'basico', 'básico'])) {
                    $nivel = 'Basica';
                } elseif (in_array($nivelLower, ['media', 'medio'])) {
                    $nivel = 'Media';
                } else {
                    $nivel = ucfirst($nivelLower);
                }

                $letra = strtoupper($letraRaw);
                $nombre = '';

                if ($nivel === 'Pre-Kinder' || $nivel === 'Kinder') {
                    $nombre = "{$nivel} {$letra}";
                    $grado = null; 
                } elseif ($nivel === 'Basica') {
                    $nombreGrado = $nombresGrados[$grado] ?? $grado;
                    $nombre = "{$grado}{$nombreGrado} Básico {$letra}";
                } elseif ($nivel === 'Media') {
                    $nombreGrado = $nombresGrados[$grado] ?? $grado;
                    $nombre = "{$grado}{$nombreGrado} Medio {$letra}";
                }

                if (empty($nombre)) continue;

                $exists = Curso::where('nivel', $nivel)
                    ->where('grado', $grado)
                    ->where('letra', $letra)
                    ->exists();

                if (!$exists) {
                    Curso::create([
                        'nivel' => $nivel,
                        'grado' => $grado,
                        'letra' => $letra,
                        'nombre' => $nombre,
                    ]);
                    $count++;
                }
            }
            fclose($handle);

            return redirect()->route('courses.index')->with('success', "Se han importado $count cursos exitosamente.");
        }

        return back()->withErrors(['csv_file' => 'Error al leer el archivo CSV.']);
    }

    public function show(Curso $curso)
    {
        $curso->load([
            'profesor',
            'estudiantes',
            'asignaturas',
            'notas',
            'eventos' => function ($query) {
                $query->orderBy('fecha_inicio', 'asc');
            },
            'pruebas' => function ($query) {
                $query->with('asignatura')->orderBy('fecha', 'asc');
            }
        ]);

        $profesores = Profesor::orderBy('nombre')->get();

        $estudiantesDisponibles = Estudiante::whereDoesntHave('cursos', function ($query) use ($curso) {
            $query->where('curso_id', $curso->id);
        })->orderBy('nombre')->get();

        $asignaturasDisponibles = Asignatura::whereDoesntHave('cursos', function ($query) use ($curso) {
            $query->where('curso_id', $curso->id);
        })->orderBy('nombre')->get();

        return view('cursos.show', compact('curso', 'profesores', 'estudiantesDisponibles', 'asignaturasDisponibles'));
    }

    public function edit(Curso $curso)
    {
        return view('cursos.edit', compact('curso'));
    }

    public function update(Request $request, Curso $curso)
    {
        $validated = $request->validate([
            'nivel' => 'required|string',
            'grado' => 'nullable|string',
            'letra' => 'required|string|max:5',
        ]);

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

        if ($nivel === 'Pre-Kinder' || $nivel === 'Kinder') {
            $nombre = "{$nivel} {$letra}";
            $grado = null; 
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

    public function destroy(Curso $curso)
    {
        $curso->delete();
        return redirect()->route('courses.index')->with('success', 'Curso eliminado correctamente.');
    }

    public function assignTeacher(Request $request, Curso $curso)
    {
        $request->validate([
            'profesor_id' => 'nullable|exists:profesores,id',
        ]);

        $curso->update(['profesor_id' => $request->profesor_id]);

        return redirect()->route('courses.show', $curso)->with('success', 'Profesor asignado correctamente.');
    }

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

    public function removeStudent(Curso $curso, $estudianteId)
    {
        $curso->estudiantes()->detach($estudianteId);

        return redirect()->route('courses.show', $curso)->with('success', 'Estudiante removido correctamente.');
    }

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

    public function removeSubject(Curso $curso, $asignaturaId)
    {
        $curso->asignaturas()->detach($asignaturaId);

        return redirect()->route('courses.show', $curso)->with('success', 'Asignatura removida correctamente.');
    }

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

    public function destroyEvent(Curso $curso, $eventoId)
    {
        $evento = $curso->eventos()->findOrFail($eventoId);
        $evento->delete();

        return redirect()->route('courses.show', $curso)->with('success', 'Evento eliminado correctamente.');
    }

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

    public function destroyTest(Curso $curso, $pruebaId)
    {
        $prueba = $curso->pruebas()->findOrFail($pruebaId);
        $prueba->delete();

        return redirect()->route('courses.show', $curso)->with('success', 'Prueba eliminada correctamente.');
    }
}
