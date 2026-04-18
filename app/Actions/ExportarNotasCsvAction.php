<?php

namespace App\Actions;

use App\Models\Nota;

class ExportarNotasCsvAction
{
    /**
     * Ejecuta la exportación de notas a CSV.
     *
     * @param array $filtros
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
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

        $filename = 'notas_' . date('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        // Añadir BOM (Byte Order Mark) para que Excel detecte UTF-8
        $callback = function () use ($notas) {
            $file = fopen('php://output', 'w');
            fputs($file, "\xEF\xBB\xBF");
            
            fputcsv($file, ['ID', 'Estudiante', 'RUT', 'Curso', 'Asignatura', 'Nota', 'Tipo Evaluación', 'Período', 'Fecha', 'Estado']);

            foreach ($notas as $nota) {
                fputcsv($file, [
                    $nota->id,
                    $nota->estudiante ? $nota->estudiante->nombre . ' ' . $nota->estudiante->apellido : 'N/A',
                    $nota->estudiante ? $nota->estudiante->rut : 'N/A',
                    $nota->curso ? $nota->curso->nombre : 'N/A',
                    $nota->asignatura ? $nota->asignatura->nombre : 'N/A',
                    $nota->nota,
                    $nota->tipo_evaluacion,
                    $nota->periodo,
                    $nota->fecha ? $nota->fecha->format('Y-m-d') : 'N/A',
                    $nota->nota >= 4.0 ? 'Aprobado' : 'Reprobado',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
