<x-app-layout>
    <x-slot name="header">
        Reporte por Curso
    </x-slot>

    <!-- Header -->
    <div style="background: var(--theme-dark); color: white; padding: var(--spacing-2xl); border-radius: var(--radius-xl); margin-bottom: var(--spacing-2xl); box-shadow: var(--shadow-lg);">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <h2 style="color: white; font-size: 1.75rem; font-weight: 700; margin-bottom: var(--spacing-sm);">
                    <i class="fas fa-chalkboard-teacher"></i> Reporte: {{ $curso->nombre }}
                </h2>
                <p style="opacity: 0.85; margin: 0;">
                    {{ $reporteEstudiantes->count() }} estudiantes
                    @if($periodo) • Período: {{ $periodo }} @endif
                    @if($asignaturaId && $asignaturas->find($asignaturaId)) • {{ $asignaturas->find($asignaturaId)->nombre }} @endif
                </p>
            </div>
            <a href="{{ route('grades.index') }}" class="btn btn-outline" style="color: white; border-color: rgba(255,255,255,0.4);">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-xl">
        <div class="card-body">
            <form method="GET" action="{{ route('grades.reporte.curso', $curso->id) }}">
                <div class="grid grid-cols-3" style="gap: var(--spacing-md); align-items: end;">
                    <div>
                        <label class="form-label">Período</label>
                        <select name="periodo" class="form-select" onchange="this.form.submit()">
                            <option value="">Todos los períodos</option>
                            @foreach($periodos as $p)
                                <option value="{{ $p }}" {{ $periodo == $p ? 'selected' : '' }}>{{ $p }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Asignatura</label>
                        <select name="asignatura_id" class="form-select" onchange="this.form.submit()">
                            <option value="">Todas las asignaturas</option>
                            @foreach($asignaturas as $asignatura)
                                <option value="{{ $asignatura->id }}" {{ $asignaturaId == $asignatura->id ? 'selected' : '' }}>
                                    {{ $asignatura->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <a href="{{ route('grades.export-pdf', ['curso_id' => $curso->id, 'periodo' => $periodo]) }}"
                           class="btn btn-outline" target="_blank" style="width: 100%; text-align: center;">
                            <i class="fas fa-file-pdf"></i> Exportar PDF
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Reporte Table -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Resultados por Estudiante</h3>
        </div>
        <div class="card-body" style="padding: 0; overflow-x: auto;">
            @if($reporteEstudiantes->count() > 0)
                <table class="table" style="margin: 0;">
                    <thead>
                        <tr>
                            <th>Estudiante</th>
                            @foreach($asignaturas as $asignatura)
                                @if(!$asignaturaId || $asignaturaId == $asignatura->id)
                                    <th style="text-align: center;">{{ $asignatura->nombre }}</th>
                                @endif
                            @endforeach
                            <th style="text-align: center;">Promedio</th>
                            <th style="text-align: center;">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reporteEstudiantes as $reporte)
                            <tr>
                                <td>
                                    <div style="font-weight: 600; color: var(--gray-900);">
                                        {{ $reporte['estudiante']->nombre }} {{ $reporte['estudiante']->apellido }}
                                    </div>
                                    <div style="font-size: 0.75rem; color: var(--gray-500);">{{ $reporte['estudiante']->rut }}</div>
                                </td>
                                @foreach($asignaturas as $asignatura)
                                    @if(!$asignaturaId || $asignaturaId == $asignatura->id)
                                        @php
                                            $prom = $reporte['notas_por_asignatura'][$asignatura->id] ?? null;
                                            $color = is_null($prom) ? 'var(--gray-400)' : ($prom >= 6.0 ? 'var(--success)' : ($prom >= 5.0 ? '#0ea5e9' : ($prom >= 4.0 ? 'var(--warning)' : 'var(--error)')));
                                        @endphp
                                        <td style="text-align: center;">
                                            @if(!is_null($prom))
                                                <span style="font-weight: 700; color: {{ $color }};">{{ $prom }}</span>
                                            @else
                                                <span style="color: var(--gray-300);">–</span>
                                            @endif
                                        </td>
                                    @endif
                                @endforeach
                                @php
                                    $promColor = $reporte['promedio'] >= 6.0 ? 'var(--success)' : ($reporte['promedio'] >= 5.0 ? '#0ea5e9' : ($reporte['promedio'] >= 4.0 ? 'var(--warning)' : 'var(--error)'));
                                @endphp
                                <td style="text-align: center;">
                                    <span style="font-size: 1.125rem; font-weight: 800; color: {{ $promColor }};">
                                        {{ $reporte['promedio'] ?: '–' }}
                                    </span>
                                </td>
                                <td style="text-align: center;">
                                    @if($reporte['promedio'] >= 4.0)
                                        <span class="badge badge-success">{{ $reporte['estado'] }}</span>
                                    @elseif($reporte['promedio'] > 0)
                                        <span class="badge badge-danger">{{ $reporte['estado'] }}</span>
                                    @else
                                        <span class="badge">Sin notas</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div style="text-align: center; padding: var(--spacing-3xl);">
                    <i class="fas fa-clipboard-list" style="font-size: 3rem; color: var(--gray-200); margin-bottom: var(--spacing-md);"></i>
                    <p style="color: var(--gray-500);">No hay datos para mostrar con los filtros seleccionados.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
