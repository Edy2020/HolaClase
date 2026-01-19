<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use App\Models\Curso;
use App\Models\Asignatura;
use App\Models\Estudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotaController extends Controller
{
    /**
     * Display a listing of grades.
     */
    public function index(Request $request)
    {
        $query = Nota::with(['curso', 'asignatura', 'estudiante']);

        // Apply filters
        if ($request->filled('curso_id')) {
            $query->forCurso($request->curso_id);
        }

        if ($request->filled('asignatura_id')) {
            $query->forAsignatura($request->asignatura_id);
        }

        if ($request->filled('estudiante_id')) {
            $query->forEstudiante($request->estudiante_id);
        }

        if ($request->filled('periodo')) {
            $query->forPeriodo($request->periodo);
        }

        if ($request->filled('tipo_evaluacion')) {
            $query->forTipoEvaluacion($request->tipo_evaluacion);
        }

        $notas = $query->orderBy('fecha', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Get filter options
        $cursos = Curso::orderBy('nombre')->get();
        $asignaturas = Asignatura::orderBy('nombre')->get();
        $estudiantes = Estudiante::orderBy('nombre')->get();

        // Calculate statistics
        $stats = [
            'total' => Nota::count(),
            'promedio' => round(Nota::avg('nota'), 1) ?? 0,
            'aprobados' => Nota::where('nota', '>=', 4.0)->count(),
            'reprobados' => Nota::where('nota', '<', 4.0)->count(),
            'nota_maxima' => Nota::max('nota') ?? 0,
            'nota_minima' => Nota::min('nota') ?? 0,
        ];

        return view('notas.index', compact('notas', 'cursos', 'asignaturas', 'estudiantes', 'stats'));
    }

    /**
     * Show the form for creating new grades.
     */
    public function create(Request $request)
    {
        $cursos = Curso::with('asignaturas')->orderBy('nombre')->get();

        $selectedCurso = null;
        $selectedAsignatura = null;
        $estudiantes = collect();

        if ($request->filled('curso_id')) {
            $selectedCurso = Curso::with(['estudiantes', 'asignaturas'])->findOrFail($request->curso_id);
            $estudiantes = $selectedCurso->estudiantes()->orderBy('nombre')->get();

            if ($request->filled('asignatura_id')) {
                $selectedAsignatura = Asignatura::findOrFail($request->asignatura_id);
            }
        }

        $tiposEvaluacion = ['Prueba', 'Trabajo', 'Examen', 'Taller', 'Proyecto', 'Participación', 'Control'];
        $periodos = ['Semestre 1', 'Semestre 2', 'Anual'];

        return view('notas.create', compact(
            'cursos',
            'selectedCurso',
            'selectedAsignatura',
            'estudiantes',
            'tiposEvaluacion',
            'periodos'
        ));
    }

    /**
     * Store newly created grades in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'curso_id' => 'required|exists:cursos,id',
            'asignatura_id' => 'required|exists:asignaturas,id',
            'tipo_evaluacion' => 'required|string|max:255',
            'periodo' => 'required|string|max:255',
            'fecha' => 'required|date|before_or_equal:today',
            'ponderacion' => 'required|numeric|min:0.01|max:1',
            'notas' => 'required|array',
            'notas.*.estudiante_id' => 'required|exists:estudiantes,id',
            'notas.*.nota' => 'required|numeric|min:1.0|max:7.0',
            'notas.*.observaciones' => 'nullable|string|max:500',
        ]);

        DB::beginTransaction();
        try {
            foreach ($validated['notas'] as $notaData) {
                if (isset($notaData['nota']) && $notaData['nota'] !== '') {
                    Nota::create([
                        'curso_id' => $validated['curso_id'],
                        'asignatura_id' => $validated['asignatura_id'],
                        'estudiante_id' => $notaData['estudiante_id'],
                        'nota' => $notaData['nota'],
                        'tipo_evaluacion' => $validated['tipo_evaluacion'],
                        'periodo' => $validated['periodo'],
                        'fecha' => $validated['fecha'],
                        'ponderacion' => $validated['ponderacion'],
                        'observaciones' => $notaData['observaciones'] ?? null,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('grades.index')
                ->with('success', 'Notas registradas exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al guardar las notas: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Display the specified grade.
     */
    public function show(Nota $nota)
    {
        $nota->load(['curso', 'asignatura', 'estudiante']);
        return view('notas.show', compact('nota'));
    }

    /**
     * Show the form for editing the specified grade.
     */
    public function edit(Nota $nota)
    {
        $nota->load(['curso', 'asignatura', 'estudiante']);
        $tiposEvaluacion = ['Prueba', 'Trabajo', 'Examen', 'Taller', 'Proyecto', 'Participación', 'Control'];
        $periodos = ['Semestre 1', 'Semestre 2', 'Anual'];

        return view('notas.edit', compact('nota', 'tiposEvaluacion', 'periodos'));
    }

    /**
     * Update the specified grade in storage.
     */
    public function update(Request $request, Nota $nota)
    {
        $validated = $request->validate([
            'nota' => 'required|numeric|min:1.0|max:7.0',
            'tipo_evaluacion' => 'required|string|max:255',
            'periodo' => 'required|string|max:255',
            'fecha' => 'required|date|before_or_equal:today',
            'ponderacion' => 'required|numeric|min:0.01|max:1',
            'observaciones' => 'nullable|string|max:500',
        ]);

        $nota->update($validated);

        return redirect()->route('grades.index')
            ->with('success', 'Nota actualizada exitosamente.');
    }

    /**
     * Remove the specified grade from storage.
     */
    public function destroy(Nota $nota)
    {
        $nota->delete();

        return redirect()->route('grades.index')
            ->with('success', 'Nota eliminada exitosamente.');
    }

    /**
     * Generate grade report for a course.
     */
    public function reportePorCurso(Request $request, Curso $curso)
    {
        $periodo = $request->get('periodo');
        $asignaturaId = $request->get('asignatura_id');

        $query = Nota::where('curso_id', $curso->id);

        if ($periodo) {
            $query->where('periodo', $periodo);
        }

        if ($asignaturaId) {
            $query->where('asignatura_id', $asignaturaId);
        }

        $notas = $query->with(['estudiante', 'asignatura'])->get();

        // Group by student and subject
        $reporteEstudiantes = $curso->estudiantes->map(function ($estudiante) use ($notas) {
            $estudianteNotas = $notas->where('estudiante_id', $estudiante->id);

            // Group by subject
            $notasPorAsignatura = $estudianteNotas->groupBy('asignatura_id')->map(function ($group) {
                $totalPonderacion = $group->sum('ponderacion');
                $notaPonderada = $group->sum(function ($nota) {
                    return $nota->nota * $nota->ponderacion;
                });

                return $totalPonderacion > 0 ? round($notaPonderada / $totalPonderacion, 1) : 0;
            });

            // Calculate overall average
            $promedio = $notasPorAsignatura->count() > 0 ? round($notasPorAsignatura->avg(), 1) : 0;

            return [
                'estudiante' => $estudiante,
                'notas_por_asignatura' => $notasPorAsignatura,
                'promedio' => $promedio,
                'estado' => $promedio >= 4.0 ? 'Aprobado' : 'Reprobado',
            ];
        });

        $asignaturas = $curso->asignaturas;
        $periodos = ['Semestre 1', 'Semestre 2', 'Anual'];

        return view('notas.reporte_curso', compact('curso', 'reporteEstudiantes', 'asignaturas', 'periodo', 'asignaturaId', 'periodos'));
    }

    /**
     * Generate grade report for a student.
     */
    public function reportePorEstudiante(Request $request, Estudiante $estudiante)
    {
        $periodo = $request->get('periodo');

        $query = Nota::where('estudiante_id', $estudiante->id);

        if ($periodo) {
            $query->where('periodo', $periodo);
        }

        $notas = $query->with(['curso', 'asignatura'])
            ->orderBy('fecha', 'desc')
            ->get();

        // Group by subject
        $reporteAsignaturas = $notas->groupBy('asignatura_id')->map(function ($group) {
            $asignatura = $group->first()->asignatura;
            $totalPonderacion = $group->sum('ponderacion');
            $notaPonderada = $group->sum(function ($nota) {
                return $nota->nota * $nota->ponderacion;
            });

            $promedio = $totalPonderacion > 0 ? round($notaPonderada / $totalPonderacion, 1) : 0;

            return [
                'asignatura' => $asignatura,
                'notas' => $group,
                'promedio' => $promedio,
                'estado' => $promedio >= 4.0 ? 'Aprobado' : 'Reprobado',
            ];
        });

        // Calculate overall average
        $promedioGeneral = $reporteAsignaturas->count() > 0
            ? round($reporteAsignaturas->pluck('promedio')->avg(), 1)
            : 0;

        $periodos = ['Semestre 1', 'Semestre 2', 'Anual'];

        return view('notas.reporte_estudiante', compact('estudiante', 'reporteAsignaturas', 'promedioGeneral', 'periodo', 'periodos'));
    }

    /**
     * Generate report card (libreta) for a student.
     */
    public function libreta(Estudiante $estudiante)
    {
        $notas = Nota::where('estudiante_id', $estudiante->id)
            ->with(['curso', 'asignatura'])
            ->orderBy('periodo')
            ->orderBy('asignatura_id')
            ->get();

        // Group by period and subject
        $libreta = $notas->groupBy('periodo')->map(function ($periodoNotas, $periodo) {
            return $periodoNotas->groupBy('asignatura_id')->map(function ($group) {
                $asignatura = $group->first()->asignatura;
                $totalPonderacion = $group->sum('ponderacion');
                $notaPonderada = $group->sum(function ($nota) {
                    return $nota->nota * $nota->ponderacion;
                });

                $promedio = $totalPonderacion > 0 ? round($notaPonderada / $totalPonderacion, 1) : 0;

                return [
                    'asignatura' => $asignatura,
                    'notas' => $group,
                    'promedio' => $promedio,
                ];
            });
        });

        // Calculate final average
        $promedioFinal = 0;
        $totalAsignaturas = 0;

        foreach ($libreta as $periodo => $asignaturas) {
            foreach ($asignaturas as $asignaturaData) {
                $promedioFinal += $asignaturaData['promedio'];
                $totalAsignaturas++;
            }
        }

        $promedioFinal = $totalAsignaturas > 0 ? round($promedioFinal / $totalAsignaturas, 1) : 0;

        return view('notas.libreta', compact('estudiante', 'libreta', 'promedioFinal'));
    }
}
