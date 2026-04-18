<?php

namespace App\Services;

use App\Models\Nota;
use App\Models\Curso;
use App\Models\Estudiante;

class ReporteAcademicoService
{
    /**
     * Genera el reporte de estudiantes para un curso específico.
     */
    public function generarReportePorCurso(Curso $curso, ?string $periodo = null, ?int $asignaturaId = null)
    {
        $query = Nota::where('curso_id', $curso->id);

        if ($periodo) {
            $query->where('periodo', $periodo);
        }

        if ($asignaturaId) {
            $query->where('asignatura_id', $asignaturaId);
        }

        $notasAgrupadas = (clone $query)
            ->selectRaw('
                estudiante_id,
                asignatura_id,
                ROUND(SUM(nota * ponderacion) / NULLIF(SUM(ponderacion), 0), 1) as promedio_asignatura
            ')
            ->groupBy('estudiante_id', 'asignatura_id')
            ->get()
            ->groupBy('estudiante_id');

        return $curso->estudiantes->map(function ($estudiante) use ($notasAgrupadas) {
            if ($notasAgrupadas->has($estudiante->id)) {
                $notasPorAsignatura = $notasAgrupadas->get($estudiante->id)
                    ->keyBy('asignatura_id')
                    ->map(function ($record) {
                        return (float) ($record->promedio_asignatura ?? 0);
                    });

                $promedio = $notasPorAsignatura->count() > 0 ? round($notasPorAsignatura->avg(), 1) : 0;
            } else {
                $notasPorAsignatura = collect();
                $promedio = 0;
            }

            return [
                'estudiante' => $estudiante,
                'notas_por_asignatura' => $notasPorAsignatura,
                'promedio' => $promedio,
                'estado' => $promedio >= 4.0 ? 'Aprobado' : 'Reprobado',
            ];
        });
    }

    /**
     * Genera el reporte de notas para un estudiante.
     */
    public function generarReportePorEstudiante(Estudiante $estudiante, ?string $periodo = null)
    {
        $query = Nota::where('estudiante_id', $estudiante->id);

        if ($periodo) {
            $query->where('periodo', $periodo);
        }

        $promediosDb = (clone $query)
            ->selectRaw('
                asignatura_id,
                ROUND(SUM(nota * ponderacion) / NULLIF(SUM(ponderacion), 0), 1) as promedio_asignatura
            ')
            ->groupBy('asignatura_id')
            ->get()
            ->keyBy('asignatura_id');

        $notas = $query->with(['curso', 'asignatura'])
            ->orderBy('fecha', 'desc')
            ->get();

        $reporteAsignaturas = $notas->groupBy('asignatura_id')->map(function ($group) use ($promediosDb) {
            $asignatura = $group->first()->asignatura;
            
            $promedio = (float) ($promediosDb->get($asignatura->id)->promedio_asignatura ?? 0);

            return [
                'asignatura' => $asignatura,
                'notas' => $group,
                'promedio' => $promedio,
                'estado' => $promedio >= 4.0 ? 'Aprobado' : 'Reprobado',
            ];
        });

        $promedioGeneral = $reporteAsignaturas->count() > 0
            ? round($reporteAsignaturas->pluck('promedio')->avg(), 1)
            : 0;

        return [
            'reporteAsignaturas' => $reporteAsignaturas,
            'promedioGeneral' => $promedioGeneral,
        ];
    }

    /**
     * Genera la libreta de calificaciones completa para un estudiante.
     */
    public function generarLibretaEstudiante(Estudiante $estudiante)
    {
        $query = Nota::where('estudiante_id', $estudiante->id);

        $promediosDb = (clone $query)
            ->selectRaw('
                periodo,
                asignatura_id,
                ROUND(SUM(nota * ponderacion) / NULLIF(SUM(ponderacion), 0), 1) as promedio_asignatura
            ')
            ->groupBy('periodo', 'asignatura_id')
            ->get();

        $notas = $query->with(['curso', 'asignatura'])
            ->orderBy('periodo')
            ->orderBy('asignatura_id')
            ->get();

        $libreta = $notas->groupBy('periodo')->map(function ($periodoNotas, $periodo) use ($promediosDb) {
            return $periodoNotas->groupBy('asignatura_id')->map(function ($group) use ($periodo, $promediosDb) {
                $asignatura = $group->first()->asignatura;
                
                $record = $promediosDb->where('periodo', $periodo)->where('asignatura_id', $asignatura->id)->first();
                $promedio = (float) ($record->promedio_asignatura ?? 0);

                return [
                    'asignatura' => $asignatura,
                    'notas' => $group,
                    'promedio' => $promedio,
                ];
            });
        });

        $promedioFinal = 0;
        $totalAsignaturas = 0;

        foreach ($libreta as $periodo => $asignaturas) {
            foreach ($asignaturas as $asignaturaData) {
                $promedioFinal += $asignaturaData['promedio'];
                $totalAsignaturas++;
            }
        }

        $promedioFinal = $totalAsignaturas > 0 ? round($promedioFinal / $totalAsignaturas, 1) : 0;

        return [
            'libreta' => $libreta,
            'promedioFinal' => $promedioFinal,
        ];
    }

    /**
     * Genera las estadísticas globales para el dashboard de notas.
     */
    public function generarEstadisticasDashboard(?string $filtroPeriodo = null, ?string $filtroNivel = null)
    {
        $notasQuery = Nota::query();
        if ($filtroPeriodo) {
            $notasQuery->where('periodo', $filtroPeriodo);
        }

        $totalEstudiantesQuery = Estudiante::query();
        $user = auth()->user();
        if ($user && !$user->isAdmin() && $user->profesor_id) {
            $totalEstudiantesQuery->whereHas('cursos');
        }
        $totalEstudiantes = $totalEstudiantesQuery->count();

        $totalNotas = (clone $notasQuery)->count();
        $promedioRow = (clone $notasQuery)
            ->selectRaw('ROUND(SUM(nota * ponderacion) / NULLIF(SUM(ponderacion), 0), 1) as promedio')
            ->first();
        $promedioGeneral = $promedioRow->promedio ?? 0;
        
        $aprobados = (clone $notasQuery)->where('nota', '>=', 4.0)->count();
        $reprobados = (clone $notasQuery)->where('nota', '<', 4.0)->count();
        $porcentajeAprobacion = $totalNotas > 0 ? round(($aprobados / $totalNotas) * 100, 1) : 0;

        $cursosBasica = Curso::where('nivel', 'basica')->pluck('id');
        $cursosMedia = Curso::where('nivel', 'media')->pluck('id');

        $notasBasicaQuery = (clone $notasQuery)->whereIn('curso_id', $cursosBasica);
        $notasMediaQuery = (clone $notasQuery)->whereIn('curso_id', $cursosMedia);

        $statsBasica = $notasBasicaQuery->selectRaw('
            COUNT(*) as total,
            SUM(CASE WHEN nota >= 4.0 THEN 1 ELSE 0 END) as aprobados,
            SUM(CASE WHEN nota < 4.0 THEN 1 ELSE 0 END) as reprobados,
            ROUND(SUM(nota * ponderacion) / NULLIF(SUM(ponderacion), 0), 1) as promedio
        ')->first();

        $statsMedia = $notasMediaQuery->selectRaw('
            COUNT(*) as total,
            SUM(CASE WHEN nota >= 4.0 THEN 1 ELSE 0 END) as aprobados,
            SUM(CASE WHEN nota < 4.0 THEN 1 ELSE 0 END) as reprobados,
            ROUND(SUM(nota * ponderacion) / NULLIF(SUM(ponderacion), 0), 1) as promedio
        ')->first();

        $estadisticasBasica = [
            'total' => $statsBasica->total ?? 0,
            'aprobados' => $statsBasica->aprobados ?? 0,
            'reprobados' => $statsBasica->reprobados ?? 0,
            'promedio' => $statsBasica->promedio ?? 0,
            'porcentaje_aprobacion' => ($statsBasica->total > 0) ? round(($statsBasica->aprobados / $statsBasica->total) * 100, 1) : 0,
        ];

        $estadisticasMedia = [
            'total' => $statsMedia->total ?? 0,
            'aprobados' => $statsMedia->aprobados ?? 0,
            'reprobados' => $statsMedia->reprobados ?? 0,
            'promedio' => $statsMedia->promedio ?? 0,
            'porcentaje_aprobacion' => ($statsMedia->total > 0) ? round(($statsMedia->aprobados / $statsMedia->total) * 100, 1) : 0,
        ];

        $cursosQuery = Curso::withCount('estudiantes');
        if ($filtroNivel) {
            $cursosQuery->where('nivel', $filtroNivel);
        }

        $cursosDb = $cursosQuery->get();
        $cursoIds = $cursosDb->pluck('id');

        $notasStatsPorCurso = Nota::whereIn('curso_id', $cursoIds)
            ->when($filtroPeriodo, fn($q) => $q->where('periodo', $filtroPeriodo))
            ->selectRaw('
                curso_id,
                COUNT(*) as total_notas,
                SUM(CASE WHEN nota >= 4.0 THEN 1 ELSE 0 END) as aprobados,
                SUM(CASE WHEN nota < 4.0 THEN 1 ELSE 0 END) as reprobados,
                ROUND(SUM(nota * ponderacion) / NULLIF(SUM(ponderacion), 0), 1) as promedio
            ')
            ->groupBy('curso_id')
            ->get()
            ->keyBy('curso_id');

        $cursosMap = $cursosDb->map(function ($curso) use ($notasStatsPorCurso) {
            $stats = $notasStatsPorCurso->get($curso->id);
            $aprobados = $stats->aprobados ?? 0;
            $totalNotas = $stats->total_notas ?? 0;

            return [
                'id' => $curso->id,
                'nombre' => $curso->nombre,
                'nivel' => $curso->nivel,
                'total_estudiantes' => $curso->estudiantes_count,
                'total_notas' => $totalNotas,
                'promedio' => $stats->promedio ?? 0,
                'aprobados' => $aprobados,
                'reprobados' => $stats->reprobados ?? 0,
                'porcentaje_aprobacion' => $totalNotas > 0 ? round(($aprobados / $totalNotas) * 100, 1) : 0,
            ];
        });

        $chartCursos = $cursosMap->take(10)->pluck('nombre')->toArray();
        $chartPromedios = $cursosMap->take(10)->pluck('promedio')->toArray();

        return [
            'totalEstudiantes' => $totalEstudiantes,
            'totalNotas' => $totalNotas,
            'promedioGeneral' => $promedioGeneral,
            'aprobados' => $aprobados,
            'reprobados' => $reprobados,
            'porcentajeAprobacion' => $porcentajeAprobacion,
            'estadisticasBasica' => $estadisticasBasica,
            'estadisticasMedia' => $estadisticasMedia,
            'cursos' => $cursosMap,
            'chartCursos' => $chartCursos,
            'chartPromedios' => $chartPromedios,
        ];
    }
}
