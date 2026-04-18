<?php

namespace App\Actions;

use App\Models\Nota;

class ExportarNotasPdfAction
{
    /**
     * Ejecuta la generación de vista PDF para notas.
     *
     * @param array $filtros
     * @return \Illuminate\View\View
     */
    public function execute(array $filtros)
    {
        $query = Nota::with(['estudiante', 'curso', 'asignatura']);

        if (!empty($filtros['curso_id'])) {
            $query->where('curso_id', $filtros['curso_id']);
        }

        if (!empty($filtros['periodo'])) {
            $query->where('periodo', $filtros['periodo']);
        }

        if (!empty($filtros['estudiante_id'])) {
            $query->where('estudiante_id', $filtros['estudiante_id']);
        }

        $notas = $query->orderBy('curso_id')
            ->orderBy('estudiante_id')
            ->orderBy('asignatura_id')
            ->get();

        $stats = [
            'total'      => $notas->count(),
            'promedio'   => round($notas->avg('nota'), 1) ?? 0,
            'aprobados'  => $notas->where('nota', '>=', 4.0)->count(),
            'reprobados' => $notas->where('nota', '<', 4.0)->count(),
        ];

        return view('notas.pdf', compact('notas', 'stats'));
    }
}
