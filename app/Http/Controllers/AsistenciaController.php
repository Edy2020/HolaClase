<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Curso;
use App\Models\Asignatura;
use App\Models\Estudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AsistenciaController extends Controller
{
    /**
     * Display a listing of attendance records.
     */
    public function index(Request $request)
    {
        $query = Asistencia::with(['curso', 'asignatura', 'estudiante']);

        $user = auth()->user();
        $profesorCursoIds = null;
        if (!$user->isAdmin() && $user->profesor_id) {
            $profesorCursoIds = Curso::where('profesor_id', $user->profesor_id)->pluck('id');
            $query->whereIn('curso_id', $profesorCursoIds);
        }

        if ($request->filled('curso_id')) {
            $query->forCurso($request->curso_id);
        }

        if ($request->filled('asignatura_id')) {
            $query->forAsignatura($request->asignatura_id);
        }

        if ($request->filled('estudiante_id')) {
            $query->forEstudiante($request->estudiante_id);
        }

        if ($request->filled('fecha')) {
            $query->forFecha($request->fecha);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $asistencias = $query->orderBy('fecha', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $cursosQuery = Curso::orderBy('nombre');
        if ($profesorCursoIds !== null) {
            $cursosQuery->whereIn('id', $profesorCursoIds);
        }
        $cursos = $cursosQuery->get();
        $asignaturas = Asignatura::orderBy('nombre')->get();
        $estudiantes = Estudiante::orderBy('nombre')->get();

        $statsQuery = Asistencia::query();
        if ($profesorCursoIds !== null) {
            $statsQuery->whereIn('curso_id', $profesorCursoIds);
        }
        $stats = [
            'total' => (clone $statsQuery)->count(),
            'presente' => (clone $statsQuery)->where('estado', 'presente')->count(),
            'ausente' => (clone $statsQuery)->where('estado', 'ausente')->count(),
            'tarde' => (clone $statsQuery)->where('estado', 'tarde')->count(),
            'justificado' => (clone $statsQuery)->where('estado', 'justificado')->count(),
        ];

        if ($stats['total'] > 0) {
            $stats['porcentaje_asistencia'] = round(($stats['presente'] + $stats['tarde']) / $stats['total'] * 100, 1);
        } else {
            $stats['porcentaje_asistencia'] = 0;
        }

        return view('asistencia.index', compact('asistencias', 'cursos', 'asignaturas', 'estudiantes', 'stats'));
    }

    /**
     * Show the form for creating new attendance records.
     */
    public function create(Request $request)
    {
        $user = auth()->user();
        $cursosQuery = Curso::with('asignaturas')->orderBy('nombre');
        if (!$user->isAdmin() && $user->profesor_id) {
            $cursosQuery->where('profesor_id', $user->profesor_id);
        }
        $cursos = $cursosQuery->get();

        $selectedCurso = null;
        $selectedAsignatura = null;
        $estudiantes = collect();
        $fecha = $request->get('fecha', now()->format('Y-m-d'));
        $existingAttendance = collect();

        if ($request->filled('curso_id')) {
            $selectedCurso = Curso::with(['estudiantes', 'asignaturas'])->findOrFail($request->curso_id);
            $estudiantes = $selectedCurso->estudiantes()->orderBy('nombre')->get();

            if ($request->filled('asignatura_id')) {
                $selectedAsignatura = Asignatura::findOrFail($request->asignatura_id);

                // Check if attendance already exists for this date
                $existingAttendance = Asistencia::where('curso_id', $selectedCurso->id)
                    ->where('asignatura_id', $selectedAsignatura->id)
                    ->whereDate('fecha', $fecha)
                    ->with('estudiante')
                    ->get()
                    ->keyBy('estudiante_id');
            }
        }

        return view('asistencia.create', compact(
            'cursos',
            'selectedCurso',
            'selectedAsignatura',
            'estudiantes',
            'fecha',
            'existingAttendance'
        ));
    }

    /**
     * Store newly created attendance records in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'curso_id' => 'required|exists:cursos,id',
            'asignatura_id' => 'required|exists:asignaturas,id',
            'fecha' => 'required|date|before_or_equal:today',
            'asistencias' => 'required|array',
            'asistencias.*.estudiante_id' => 'required|exists:estudiantes,id',
            'asistencias.*.estado' => 'required|in:presente,ausente,tarde,justificado',
            'asistencias.*.notas' => 'nullable|string|max:500',
        ]);

        DB::beginTransaction();
        try {
            foreach ($validated['asistencias'] as $asistenciaData) {
                Asistencia::updateOrCreate(
                    [
                        'curso_id' => $validated['curso_id'],
                        'asignatura_id' => $validated['asignatura_id'],
                        'estudiante_id' => $asistenciaData['estudiante_id'],
                        'fecha' => $validated['fecha'],
                    ],
                    [
                        'estado' => $asistenciaData['estado'],
                        'notas' => $asistenciaData['notas'] ?? null,
                    ]
                );
            }

            DB::commit();
            return redirect()->route('attendance.index')
                ->with('success', 'Asistencia registrada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al guardar la asistencia: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Display the specified attendance record.
     */
    public function show(Asistencia $asistencia)
    {
        $asistencia->load(['curso', 'asignatura', 'estudiante']);
        return view('asistencia.show', compact('asistencia'));
    }

    /**
     * Show the form for editing attendance records.
     */
    public function edit(Request $request)
    {
        $curso = Curso::findOrFail($request->curso_id);
        $asignatura = Asignatura::findOrFail($request->asignatura_id);
        $fecha = $request->fecha;

        $asistencias = Asistencia::where('curso_id', $curso->id)
            ->where('asignatura_id', $asignatura->id)
            ->whereDate('fecha', $fecha)
            ->with('estudiante')
            ->get()
            ->keyBy('estudiante_id');

        $estudiantes = $curso->estudiantes()->orderBy('nombre')->get();

        return view('asistencia.edit', compact('curso', 'asignatura', 'fecha', 'asistencias', 'estudiantes'));
    }

    /**
     * Update the specified attendance records in storage.
     */
    public function update(Request $request, Asistencia $asistencia)
    {
        $validated = $request->validate([
            'estado' => 'required|in:presente,ausente,tarde,justificado',
            'notas' => 'nullable|string|max:500',
        ]);

        $asistencia->update($validated);

        return redirect()->route('attendance.index')
            ->with('success', 'Asistencia actualizada exitosamente.');
    }

    /**
     * Remove the specified attendance record from storage.
     */
    public function destroy(Asistencia $asistencia)
    {
        $asistencia->delete();

        return redirect()->route('attendance.index')
            ->with('success', 'Registro de asistencia eliminado exitosamente.');
    }

    /**
     * Display the attendance dashboard with statistics.
     */
    public function dashboard(Request $request)
    {
        $filtroCurso = $request->get('curso_id', '');
        $filtroPeriodo = $request->get('periodo', 'mes'); // mes, trimestre, anio

        // Date range based on filter
        $endDate = Carbon::today();
        $startDate = match($filtroPeriodo) {
            'trimestre' => Carbon::today()->subDays(90),
            'anio'      => Carbon::today()->startOfYear(),
            default     => Carbon::today()->startOfMonth(),
        };

        $user = auth()->user();
        $profesorCursoIds = null;
        if (!$user->isAdmin() && $user->profesor_id) {
            $profesorCursoIds = Curso::where('profesor_id', $user->profesor_id)->pluck('id');
        }

        $baseQuery = Asistencia::whereBetween('fecha', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')]);
        if ($profesorCursoIds !== null) {
            $baseQuery->whereIn('curso_id', $profesorCursoIds);
        }
        if ($filtroCurso) {
            $baseQuery->where('curso_id', $filtroCurso);
        }

        $totalRegistros  = (clone $baseQuery)->count();
        $totalPresente   = (clone $baseQuery)->where('estado', 'presente')->count();
        $totalAusente    = (clone $baseQuery)->where('estado', 'ausente')->count();
        $totalTarde      = (clone $baseQuery)->where('estado', 'tarde')->count();
        $totalJustificado = (clone $baseQuery)->where('estado', 'justificado')->count();
        $porcentajeAsistencia = $totalRegistros > 0
            ? round(($totalPresente + $totalTarde) / $totalRegistros * 100, 1)
            : 0;

        $tendenciaDias = Asistencia::selectRaw(
            "DATE(fecha) as dia,
             COUNT(*) as total,
             SUM(CASE WHEN estado IN ('presente','tarde') THEN 1 ELSE 0 END) as asistio"
        )
        ->whereBetween('fecha', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
        ->when($profesorCursoIds !== null, fn($q) => $q->whereIn('curso_id', $profesorCursoIds))
        ->when($filtroCurso, fn($q) => $q->where('curso_id', $filtroCurso))
        ->groupBy(DB::raw('DATE(fecha)'))
        ->orderBy(DB::raw('DATE(fecha)'))
        ->get();

        $chartDias      = $tendenciaDias->pluck('dia')->map(fn($d) => Carbon::parse($d)->format('d/m'))->toArray();
        $chartPorcentajes = $tendenciaDias->map(
            fn($r) => $r->total > 0 ? round($r->asistio / $r->total * 100, 1) : 0
        )->toArray();

        $estudiantesCriticos = Asistencia::selectRaw(
            "estudiante_id,
             COUNT(*) as total,
             SUM(CASE WHEN estado IN ('presente','tarde') THEN 1 ELSE 0 END) as asistio"
        )
        ->whereBetween('fecha', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
        ->when($profesorCursoIds !== null, fn($q) => $q->whereIn('curso_id', $profesorCursoIds))
        ->when($filtroCurso, fn($q) => $q->where('curso_id', $filtroCurso))
        ->groupBy('estudiante_id')
        ->with('estudiante')
        ->get()
        ->filter(fn($r) => $r->total > 0 && ($r->asistio / $r->total * 100) < 75)
        ->map(fn($r) => [
            'estudiante' => $r->estudiante,
            'total'      => (int) $r->total,
            'asistio'    => (int) $r->asistio,
            'porcentaje' => round($r->asistio / $r->total * 100, 1),
        ])
        ->sortBy('porcentaje')
        ->take(10);

        $resumenCursosQuery = Curso::with('estudiantes');
        if ($profesorCursoIds !== null) {
            $resumenCursosQuery->whereIn('id', $profesorCursoIds);
        }
        $resumenCursos = $resumenCursosQuery->get()->map(function ($curso) use ($startDate, $endDate) {
            $stats = Asistencia::selectRaw(
                "COUNT(*) as total, SUM(CASE WHEN estado IN ('presente','tarde') THEN 1 ELSE 0 END) as asistio"
            )
            ->where('curso_id', $curso->id)
            ->whereBetween('fecha', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->first();

            $pct = ($stats->total ?? 0) > 0 ? round($stats->asistio / $stats->total * 100, 1) : null;
            return [
                'id'         => $curso->id,
                'nombre'     => $curso->nombre,
                'nivel'      => $curso->nivel,
                'estudiantes'=> $curso->estudiantes->count(),
                'total'      => $stats->total ?? 0,
                'porcentaje' => $pct,
                'semaforo'   => is_null($pct) ? 'gray' : ($pct >= 85 ? 'green' : ($pct >= 75 ? 'yellow' : 'red')),
            ];
        })->sortByDesc('total');

        $cursosQuery = Curso::orderBy('nombre');
        if ($profesorCursoIds !== null) {
            $cursosQuery->whereIn('id', $profesorCursoIds);
        }
        $cursos = $cursosQuery->get();
        $periodos = ['mes' => 'Este Mes', 'trimestre' => 'Últimos 90 días', 'anio' => 'Este Año'];

        return view('asistencia.dashboard', compact(
            'totalRegistros', 'totalPresente', 'totalAusente', 'totalTarde',
            'totalJustificado', 'porcentajeAsistencia',
            'chartDias', 'chartPorcentajes',
            'estudiantesCriticos', 'resumenCursos',
            'cursos', 'periodos', 'filtroCurso', 'filtroPeriodo',
            'startDate', 'endDate'
        ));
    }

    /**
     * Generate attendance report for a course.
     */
    public function reportePorCurso(Request $request, Curso $curso)
    {
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));
        $asignaturaId = $request->get('asignatura_id');

        $query = Asistencia::where('curso_id', $curso->id)
            ->forDateRange($startDate, $endDate);

        if ($asignaturaId) {
            $query->where('asignatura_id', $asignaturaId);
        }

        $asistencias = $query->with(['estudiante', 'asignatura'])->get();

        // Group by student
        $reporteEstudiantes = $curso->estudiantes->map(function ($estudiante) use ($asistencias) {
            $estudianteAsistencias = $asistencias->where('estudiante_id', $estudiante->id);

            return [
                'estudiante' => $estudiante,
                'total' => $estudianteAsistencias->count(),
                'presente' => $estudianteAsistencias->where('estado', 'presente')->count(),
                'ausente' => $estudianteAsistencias->where('estado', 'ausente')->count(),
                'tarde' => $estudianteAsistencias->where('estado', 'tarde')->count(),
                'justificado' => $estudianteAsistencias->where('estado', 'justificado')->count(),
                'porcentaje' => $estudianteAsistencias->count() > 0
                    ? round(($estudianteAsistencias->whereIn('estado', ['presente', 'tarde'])->count() / $estudianteAsistencias->count()) * 100, 1)
                    : 0,
            ];
        });

        $asignaturas = $curso->asignaturas;

        return view('asistencia.reporte_curso', compact('curso', 'reporteEstudiantes', 'startDate', 'endDate', 'asignaturas', 'asignaturaId'));
    }

    /**
     * Generate attendance report for a student.
     */
    public function reportePorEstudiante(Request $request, Estudiante $estudiante)
    {
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));

        $asistencias = Asistencia::where('estudiante_id', $estudiante->id)
            ->forDateRange($startDate, $endDate)
            ->with(['curso', 'asignatura'])
            ->orderBy('fecha', 'desc')
            ->get();

        // Group by subject
        $reporteAsignaturas = $asistencias->groupBy('asignatura_id')->map(function ($group) {
            $asignatura = $group->first()->asignatura;
            return [
                'asignatura' => $asignatura,
                'total' => $group->count(),
                'presente' => $group->where('estado', 'presente')->count(),
                'ausente' => $group->where('estado', 'ausente')->count(),
                'tarde' => $group->where('estado', 'tarde')->count(),
                'justificado' => $group->where('estado', 'justificado')->count(),
                'porcentaje' => round(($group->whereIn('estado', ['presente', 'tarde'])->count() / $group->count()) * 100, 1),
            ];
        });

        $stats = [
            'total' => $asistencias->count(),
            'presente' => $asistencias->where('estado', 'presente')->count(),
            'ausente' => $asistencias->where('estado', 'ausente')->count(),
            'tarde' => $asistencias->where('estado', 'tarde')->count(),
            'justificado' => $asistencias->where('estado', 'justificado')->count(),
        ];

        if ($stats['total'] > 0) {
            $stats['porcentaje'] = round(($stats['presente'] + $stats['tarde']) / $stats['total'] * 100, 1);
        } else {
            $stats['porcentaje'] = 0;
        }

        return view('asistencia.reporte_estudiante', compact('estudiante', 'asistencias', 'reporteAsignaturas', 'stats', 'startDate', 'endDate'));
    }
}
