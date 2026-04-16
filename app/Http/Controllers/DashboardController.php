<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Estudiante;
use App\Models\Profesor;
use App\Models\Prueba;
use App\Models\Asistencia;
use App\Models\EventoAcademico;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if (!$user->isAdmin() && $user->profesor_id) {
            return $this->profesorDashboard($user);
        }

        return $this->adminDashboard();
    }

    private function adminDashboard()
    {
        $totalCursos = Curso::count();
        $totalEstudiantes = Estudiante::count();

        $recentCursos = Curso::with('profesor')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        $recentEstudiantes = Estudiante::orderBy('created_at', 'desc')
            ->take(2)
            ->get();

        $recentActivities = collect();

        foreach ($recentCursos as $curso) {
            $recentActivities->push([
                'type' => 'curso',
                'icon' => 'fa-book',
                'title' => 'Nuevo curso creado',
                'description' => $curso->nombre,
                'created_at' => $curso->created_at,
            ]);
        }

        foreach ($recentEstudiantes as $estudiante) {
            $recentActivities->push([
                'type' => 'estudiante',
                'icon' => 'fa-users',
                'title' => 'Nuevo estudiante registrado',
                'description' => $estudiante->nombre_completo,
                'created_at' => $estudiante->created_at,
            ]);
        }

        $recentActivities = $recentActivities->sortByDesc('created_at')->take(5)->values();

        $upcomingPruebas = Prueba::with(['curso', 'asignatura'])
            ->where('fecha', '>=', Carbon::today())
            ->orderBy('fecha', 'asc')
            ->orderBy('hora', 'asc')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalCursos',
            'totalEstudiantes',
            'recentActivities',
            'upcomingPruebas'
        ));
    }

    private function profesorDashboard($user)
    {
        $profesor = Profesor::find($user->profesor_id);

        $cursos = Curso::where('profesor_id', $user->profesor_id)
            ->withCount('estudiantes')
            ->with(['asignaturas', 'estudiantes'])
            ->orderBy('nombre')
            ->get();

        $cursoIds = $cursos->pluck('id');

        $totalEstudiantes = $cursos->sum('estudiantes_count');

        $totalAsignaturas = 0;
        foreach ($cursos as $curso) {
            $totalAsignaturas += $curso->asignaturas->count();
        }

        $upcomingPruebas = Prueba::with(['curso', 'asignatura'])
            ->whereIn('curso_id', $cursoIds)
            ->where('fecha', '>=', Carbon::today())
            ->orderBy('fecha', 'asc')
            ->orderBy('hora', 'asc')
            ->take(5)
            ->get();

        $startDate = Carbon::today()->startOfMonth();
        $endDate = Carbon::today();

        $attendanceStats = [];
        foreach ($cursos as $curso) {
            $stats = Asistencia::selectRaw(
                'COUNT(*) as total, SUM(CASE WHEN estado IN ("presente","tarde") THEN 1 ELSE 0 END) as asistio'
            )
            ->where('curso_id', $curso->id)
            ->whereBetween('fecha', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->first();

            $pct = ($stats->total ?? 0) > 0 ? round($stats->asistio / $stats->total * 100, 1) : null;
            $attendanceStats[] = [
                'curso' => $curso->nombre,
                'curso_id' => $curso->id,
                'total' => $stats->total ?? 0,
                'porcentaje' => $pct,
            ];
        }

        $totalAttendanceQuery = Asistencia::whereIn('curso_id', $cursoIds)
            ->whereBetween('fecha', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')]);
        $totalRecords = (clone $totalAttendanceQuery)->count();
        $totalPresent = (clone $totalAttendanceQuery)->whereIn('estado', ['presente', 'tarde'])->count();
        $globalAttendance = $totalRecords > 0 ? round($totalPresent / $totalRecords * 100, 1) : 0;

        $upcomingEvents = EventoAcademico::whereIn('curso_id', $cursoIds)
            ->where('fecha_inicio', '>=', Carbon::today())
            ->with('curso')
            ->orderBy('fecha_inicio', 'asc')
            ->take(5)
            ->get();

        return view('dashboard-profesor', compact(
            'profesor',
            'cursos',
            'totalEstudiantes',
            'totalAsignaturas',
            'upcomingPruebas',
            'attendanceStats',
            'globalAttendance',
            'upcomingEvents'
        ));
    }
}
