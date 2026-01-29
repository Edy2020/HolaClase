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
            'ponderacion' => 'required|numeric|min:1|max:100',
            'notas' => 'required|array',
            'notas.*.estudiante_id' => 'required|exists:estudiantes,id',
            'notas.*.nota' => 'required|numeric|min:1.0|max:7.0',
            'notas.*.observaciones' => 'nullable|string|max:500',
        ]);

        // Convert percentage to decimal (30% -> 0.3)
        $ponderacionDecimal = $validated['ponderacion'] / 100;

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
                        'ponderacion' => $ponderacionDecimal,
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

    /**
     * Display the grades dashboard with statistics.
     */
    public function dashboard(Request $request)
    {
        // Get filter parameters
        $filtroPeriodo = $request->get('periodo', '');
        $filtroNivel = $request->get('nivel', '');

        // Build base query for notas with filters
        $notasQuery = Nota::query();
        if ($filtroPeriodo) {
            $notasQuery->where('periodo', $filtroPeriodo);
        }

        // General statistics
        $totalEstudiantes = Estudiante::count();
        $totalNotas = (clone $notasQuery)->count();
        $promedioGeneral = round((clone $notasQuery)->avg('nota'), 1) ?? 0;
        $aprobados = (clone $notasQuery)->where('nota', '>=', 4.0)->count();
        $reprobados = (clone $notasQuery)->where('nota', '<', 4.0)->count();
        $porcentajeAprobacion = $totalNotas > 0 ? round(($aprobados / $totalNotas) * 100, 1) : 0;

        // Statistics by education level
        $cursosBasica = Curso::where('nivel', 'basica')->pluck('id');
        $cursosMedia = Curso::where('nivel', 'media')->pluck('id');

        $notasBasicaQuery = (clone $notasQuery)->whereIn('curso_id', $cursosBasica);
        $notasMediaQuery = (clone $notasQuery)->whereIn('curso_id', $cursosMedia);

        $notasBasica = $notasBasicaQuery->get();
        $notasMedia = $notasMediaQuery->get();

        $estadisticasBasica = [
            'total' => $notasBasica->count(),
            'aprobados' => $notasBasica->where('nota', '>=', 4.0)->count(),
            'reprobados' => $notasBasica->where('nota', '<', 4.0)->count(),
            'promedio' => round($notasBasica->avg('nota'), 1) ?? 0,
            'porcentaje_aprobacion' => $notasBasica->count() > 0
                ? round(($notasBasica->where('nota', '>=', 4.0)->count() / $notasBasica->count()) * 100, 1)
                : 0,
        ];

        $estadisticasMedia = [
            'total' => $notasMedia->count(),
            'aprobados' => $notasMedia->where('nota', '>=', 4.0)->count(),
            'reprobados' => $notasMedia->where('nota', '<', 4.0)->count(),
            'promedio' => round($notasMedia->avg('nota'), 1) ?? 0,
            'porcentaje_aprobacion' => $notasMedia->count() > 0
                ? round(($notasMedia->where('nota', '>=', 4.0)->count() / $notasMedia->count()) * 100, 1)
                : 0,
        ];

        // Course summary with statistics (apply nivel filter)
        $cursosQuery = Curso::with(['estudiantes', 'asignaturas']);
        if ($filtroNivel) {
            $cursosQuery->where('nivel', $filtroNivel);
        }

        $cursos = $cursosQuery->get()->map(function ($curso) use ($filtroPeriodo) {
            $notasQuery = Nota::where('curso_id', $curso->id);
            if ($filtroPeriodo) {
                $notasQuery->where('periodo', $filtroPeriodo);
            }
            $notas = $notasQuery->get();
            $aprobados = $notas->where('nota', '>=', 4.0)->count();

            return [
                'id' => $curso->id,
                'nombre' => $curso->nombre,
                'nivel' => $curso->nivel,
                'total_estudiantes' => $curso->estudiantes->count(),
                'total_notas' => $notas->count(),
                'promedio' => round($notas->avg('nota'), 1) ?? 0,
                'aprobados' => $aprobados,
                'reprobados' => $notas->count() - $aprobados,
                'porcentaje_aprobacion' => $notas->count() > 0
                    ? round(($aprobados / $notas->count()) * 100, 1)
                    : 0,
            ];
        });

        // Data for charts
        $chartCursos = $cursos->take(10)->pluck('nombre')->toArray();
        $chartPromedios = $cursos->take(10)->pluck('promedio')->toArray();

        // Data for filters and exports
        $cursosSelect = Curso::orderBy('nombre')->get();
        $periodos = ['Semestre 1', 'Semestre 2', 'Anual'];
        $niveles = ['basica' => 'Básica', 'media' => 'Media'];

        return view('notas.dashboard', compact(
            'totalEstudiantes',
            'totalNotas',
            'promedioGeneral',
            'aprobados',
            'reprobados',
            'porcentajeAprobacion',
            'estadisticasBasica',
            'estadisticasMedia',
            'cursos',
            'cursosSelect',
            'periodos',
            'niveles',
            'filtroPeriodo',
            'filtroNivel',
            'chartCursos',
            'chartPromedios'
        ));
    }

    /**
     * Get statistics for AJAX requests.
     */
    public function estadisticas(Request $request)
    {
        $nivel = $request->get('nivel');

        $query = Nota::query();

        if ($nivel) {
            $cursos = Curso::where('nivel', $nivel)->pluck('id');
            $query->whereIn('curso_id', $cursos);
        }

        $notas = $query->get();

        return response()->json([
            'total' => $notas->count(),
            'aprobados' => $notas->where('nota', '>=', 4.0)->count(),
            'reprobados' => $notas->where('nota', '<', 4.0)->count(),
            'promedio' => round($notas->avg('nota'), 1) ?? 0,
            'porcentaje_aprobacion' => $notas->count() > 0
                ? round(($notas->where('nota', '>=', 4.0)->count() / $notas->count()) * 100, 1)
                : 0,
        ]);
    }

    /**
     * Export grades to PDF.
     */
    public function exportPDF(Request $request)
    {
        $cursoId = $request->get('curso_id');
        $periodo = $request->get('periodo');

        $query = Nota::with(['estudiante', 'curso', 'asignatura']);

        if ($cursoId) {
            $query->where('curso_id', $cursoId);
        }

        if ($periodo) {
            $query->where('periodo', $periodo);
        }

        $notas = $query->orderBy('curso_id')
            ->orderBy('estudiante_id')
            ->orderBy('asignatura_id')
            ->get();

        $stats = [
            'total' => $notas->count(),
            'promedio' => round($notas->avg('nota'), 1) ?? 0,
            'aprobados' => $notas->where('nota', '>=', 4.0)->count(),
            'reprobados' => $notas->where('nota', '<', 4.0)->count(),
        ];

        // For now, return a simple view that can be converted to PDF
        // Once dompdf is installed, we'll use: $pdf = PDF::loadView('notas.pdf', compact('notas', 'stats'));
        return view('notas.pdf', compact('notas', 'stats'));
    }

    /**
     * Export grades to Excel.
     */
    public function exportExcel(Request $request)
    {
        $cursoId = $request->get('curso_id');
        $periodo = $request->get('periodo');

        $query = Nota::with(['estudiante', 'curso', 'asignatura']);

        if ($cursoId) {
            $query->where('curso_id', $cursoId);
        }

        if ($periodo) {
            $query->where('periodo', $periodo);
        }

        $notas = $query->orderBy('curso_id')
            ->orderBy('estudiante_id')
            ->orderBy('asignatura_id')
            ->get();

        // For now, return CSV format
        // Once maatwebsite/excel is installed, we'll use proper Excel export
        $filename = 'notas_' . date('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($notas) {
            $file = fopen('php://output', 'w');

            // Header row
            fputcsv($file, ['ID', 'Estudiante', 'RUT', 'Curso', 'Asignatura', 'Nota', 'Tipo Evaluación', 'Período', 'Fecha', 'Estado']);

            // Data rows
            foreach ($notas as $nota) {
                fputcsv($file, [
                    $nota->id,
                    $nota->estudiante->nombre . ' ' . $nota->estudiante->apellido,
                    $nota->estudiante->rut,
                    $nota->curso->nombre,
                    $nota->asignatura->nombre,
                    $nota->nota,
                    $nota->tipo_evaluacion,
                    $nota->periodo,
                    $nota->fecha->format('Y-m-d'),
                    $nota->nota >= 4.0 ? 'Aprobado' : 'Reprobado',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

