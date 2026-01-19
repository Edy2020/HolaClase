<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Curso;
use App\Models\Asignatura;
use App\Models\Estudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AsistenciaController extends Controller
{
    /**
     * Display a listing of attendance records.
     */
    public function index(Request $request)
    {
        $query = Asistencia::with(['curso', 'asignatura', 'estudiante']);

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

        if ($request->filled('fecha')) {
            $query->forFecha($request->fecha);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $asistencias = $query->orderBy('fecha', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Get filter options
        $cursos = Curso::orderBy('nombre')->get();
        $asignaturas = Asignatura::orderBy('nombre')->get();
        $estudiantes = Estudiante::orderBy('nombre')->get();

        // Calculate statistics
        $stats = [
            'total' => Asistencia::count(),
            'presente' => Asistencia::where('estado', 'presente')->count(),
            'ausente' => Asistencia::where('estado', 'ausente')->count(),
            'tarde' => Asistencia::where('estado', 'tarde')->count(),
            'justificado' => Asistencia::where('estado', 'justificado')->count(),
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
        $cursos = Curso::with('asignaturas')->orderBy('nombre')->get();

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
