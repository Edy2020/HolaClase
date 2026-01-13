<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Estudiante;
use App\Models\Prueba;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Get statistics
        $totalCursos = Curso::count();
        $totalEstudiantes = Estudiante::count();

        // Get recent activities (last 5 courses and students)
        $recentCursos = Curso::with('profesor')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        $recentEstudiantes = Estudiante::orderBy('created_at', 'desc')
            ->take(2)
            ->get();

        // Merge and sort activities by creation date
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

        // Sort by created_at descending and take 5
        $recentActivities = $recentActivities->sortByDesc('created_at')->take(5)->values();

        // Get upcoming pruebas (tests)
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
}
