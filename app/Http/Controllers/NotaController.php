<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use App\Models\Curso;
use App\Models\Asignatura;
use App\Models\Estudiante;
use App\Actions\ExportarNotasCsvAction;
use App\Actions\ExportarNotasPdfAction;
use App\Http\Requests\StoreNotaRequest;
use App\Http\Requests\UpdateNotaRequest;
use App\Services\ReporteAcademicoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotaController extends Controller
{
    protected ReporteAcademicoService $reporteService;

    public function __construct(ReporteAcademicoService $reporteService)
    {
        $this->reporteService = $reporteService;
    }

    public function index(Request $request)
    {
        $query = Nota::with(['curso', 'asignatura', 'estudiante']);

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

        $cursos = Curso::orderBy('nombre')->get();
        $asignaturas = Asignatura::orderBy('nombre')->get();
        $estudiantes = Estudiante::orderBy('nombre')->get();

        $statsQuery = Nota::query();

        $stats = [
            'total' => (clone $statsQuery)->count(),
            'promedio' => round((clone $statsQuery)->avg('nota'), 1) ?? 0,
            'aprobados' => (clone $statsQuery)->where('nota', '>=', 4.0)->count(),
            'reprobados' => (clone $statsQuery)->where('nota', '<', 4.0)->count(),
            'nota_maxima' => (clone $statsQuery)->max('nota') ?? 0,
            'nota_minima' => (clone $statsQuery)->min('nota') ?? 0,
        ];

        return view('notas.index', compact('notas', 'cursos', 'asignaturas', 'estudiantes', 'stats'));
    }

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

    public function store(StoreNotaRequest $request)
    {
        $validated = $request->validated();

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

    public function show(Nota $nota)
    {
        $nota->load(['curso', 'asignatura', 'estudiante']);
        return view('notas.show', compact('nota'));
    }

    public function edit(Nota $nota)
    {
        $nota->load(['curso', 'asignatura', 'estudiante']);
        $tiposEvaluacion = ['Prueba', 'Trabajo', 'Examen', 'Taller', 'Proyecto', 'Participación', 'Control'];
        $periodos = ['Semestre 1', 'Semestre 2', 'Anual'];

        return view('notas.edit', compact('nota', 'tiposEvaluacion', 'periodos'));
    }

    public function update(UpdateNotaRequest $request, Nota $nota)
    {
        $validated = $request->validated();

        $nota->update($validated);

        return redirect()->route('grades.index')
            ->with('success', 'Nota actualizada exitosamente.');
    }

    public function destroy(Nota $nota)
    {
        $nota->delete();

        return redirect()->route('grades.index')
            ->with('success', 'Nota eliminada exitosamente.');
    }

    public function reportePorCurso(Request $request, Curso $curso)
    {
        $periodo = $request->get('periodo');
        $asignaturaId = $request->get('asignatura_id');

        $reporteEstudiantes = $this->reporteService->generarReportePorCurso($curso, $periodo, $asignaturaId);

        $asignaturas = $curso->asignaturas;
        $periodos = ['Semestre 1', 'Semestre 2', 'Anual'];

        return view('notas.reporte_curso', compact('curso', 'reporteEstudiantes', 'asignaturas', 'periodo', 'asignaturaId', 'periodos'));
    }

    public function reportePorEstudiante(Request $request, Estudiante $estudiante)
    {
        $periodo = $request->get('periodo');

        $reporteData = $this->reporteService->generarReportePorEstudiante($estudiante, $periodo);
        $reporteAsignaturas = $reporteData['reporteAsignaturas'];
        $promedioGeneral = $reporteData['promedioGeneral'];

        $periodos = ['Semestre 1', 'Semestre 2', 'Anual'];

        return view('notas.reporte_estudiante', compact('estudiante', 'reporteAsignaturas', 'promedioGeneral', 'periodo', 'periodos'));
    }

    public function libreta(Estudiante $estudiante)
    {
        $libretaData = $this->reporteService->generarLibretaEstudiante($estudiante);
        $libreta = $libretaData['libreta'];
        $promedioFinal = $libretaData['promedioFinal'];

        return view('notas.libreta', compact('estudiante', 'libreta', 'promedioFinal'));
    }

    public function dashboard(Request $request)
    {
        $filtroPeriodo = $request->get('periodo', '');
        $filtroNivel = $request->get('nivel', '');

        $stats = $this->reporteService->generarEstadisticasDashboard($filtroPeriodo, $filtroNivel);

        $totalEstudiantes = $stats['totalEstudiantes'];
        $totalNotas = $stats['totalNotas'];
        $promedioGeneral = $stats['promedioGeneral'];
        $aprobados = $stats['aprobados'];
        $reprobados = $stats['reprobados'];
        $porcentajeAprobacion = $stats['porcentajeAprobacion'];
        $estadisticasBasica = $stats['estadisticasBasica'];
        $estadisticasMedia = $stats['estadisticasMedia'];
        $cursos = $stats['cursos'];
        $chartCursos = $stats['chartCursos'];
        $chartPromedios = $stats['chartPromedios'];

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

    public function escala()
    {
        return view('notas.escala');
    }

    public function estadisticas(Request $request)
    {
        $nivel = $request->get('nivel');
        $query = Nota::query();

        $cursosQuery = Curso::query();

        if ($nivel) {
            $cursosQuery->where('nivel', $nivel);
        }

        $cursosIds = $cursosQuery->pluck('id');
        $query->whereIn('curso_id', $cursosIds);

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

    public function exportPDF(Request $request, ExportarNotasPdfAction $action)
    {
        return $action->execute($request->only(['curso_id', 'periodo', 'estudiante_id']));
    }

    public function exportExcel(Request $request, ExportarNotasCsvAction $action)
    {
        return $action->execute($request->only(['curso_id', 'periodo', 'estudiante_id']));
    }
}

