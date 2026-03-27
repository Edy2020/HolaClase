<x-app-layout>
    <x-slot name="header">
        Reporte del Estudiante
    </x-slot>

    <!-- Header -->
    <div style="background: var(--theme-dark); color: white; padding: var(--spacing-2xl); border-radius: var(--radius-xl); margin-bottom: var(--spacing-2xl); box-shadow: var(--shadow-lg);">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div style="display: flex; align-items: center; gap: var(--spacing-lg);">
                <div style="width: 60px; height: 60px; border-radius: 50%; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.5rem;">
                    {{ strtoupper(substr($estudiante->nombre, 0, 1) . substr($estudiante->apellido, 0, 1)) }}
                </div>
                <div>
                    <h2 style="color: white; font-size: 1.75rem; font-weight: 700; margin-bottom: 4px;">
                        {{ $estudiante->nombre }} {{ $estudiante->apellido }}
                    </h2>
                    <p style="opacity: 0.85; margin: 0; font-size: 0.875rem;">
                        RUT: {{ $estudiante->rut }}
                        @if($periodo) • Período: {{ $periodo }} @endif
                    </p>
                </div>
            </div>
            <div style="display: flex; gap: var(--spacing-md); align-items: center;">
                @php
                    $promColor = $promedioGeneral >= 6 ? '#4ade80' : ($promedioGeneral >= 5 ? '#38bdf8' : ($promedioGeneral >= 4 ? '#fbbf24' : '#f87171'));
                @endphp
                <div style="text-align: center; background: rgba(255,255,255,0.1); padding: var(--spacing-md) var(--spacing-xl); border-radius: var(--radius-lg);">
                    <div style="font-size: 2.5rem; font-weight: 900; color: {{ $promColor }};">{{ $promedioGeneral ?: '–' }}</div>
                    <div style="font-size: 0.75rem; opacity: 0.8; margin-top: 2px;">Promedio General</div>
                </div>
                <a href="{{ route('grades.index') }}" class="btn btn-outline" style="color: white; border-color: rgba(255,255,255,0.4);">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
    </div>

    <!-- Period Filter -->
    <div class="card mb-xl">
        <div class="card-body">
            <form method="GET" action="{{ route('grades.reporte.estudiante', $estudiante->id) }}">
                <div style="display: flex; gap: var(--spacing-md); align-items: end;">
                    <div style="flex: 0 0 250px;">
                        <label class="form-label">Período</label>
                        <select name="periodo" class="form-select" onchange="this.form.submit()">
                            <option value="">Todos los períodos</option>
                            @foreach($periodos as $p)
                                <option value="{{ $p }}" {{ $periodo == $p ? 'selected' : '' }}>{{ $p }}</option>
                            @endforeach
                        </select>
                    </div>
                    <a href="{{ route('grades.libreta', $estudiante->id) }}" class="btn btn-outline">
                        <i class="fas fa-book"></i> Ver Libreta Completa
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Grades by Subject -->
    @if($reporteAsignaturas->count() > 0)
        @foreach($reporteAsignaturas as $reporte)
            @php
                $prom = $reporte['promedio'];
                $promColor = $prom >= 6.0 ? 'var(--success)' : ($prom >= 5.0 ? '#0ea5e9' : ($prom >= 4.0 ? 'var(--warning)' : 'var(--error)'));
                $barWidth = min(100, ($prom / 7) * 100);
            @endphp
            <div class="card mb-xl">
                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <h3 class="card-title">
                        <i class="fas fa-book"></i> {{ $reporte['asignatura']->nombre ?? 'Asignatura' }}
                    </h3>
                    <div style="display: flex; align-items: center; gap: var(--spacing-md);">
                        <span style="font-size: 1.5rem; font-weight: 800; color: {{ $promColor }};">
                            {{ $prom }}
                        </span>
                        @if($prom >= 4.0)
                            <span class="badge badge-success">Aprobado</span>
                        @else
                            <span class="badge badge-danger">Reprobado</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <!-- Progress Bar -->
                    <div style="height: 8px; background: var(--gray-100); border-radius: 9999px; margin-bottom: var(--spacing-lg); overflow: hidden;">
                        <div style="width: {{ $barWidth }}%; height: 100%; background: {{ $promColor }}; border-radius: 9999px; transition: width 0.6s ease;"></div>
                    </div>

                    <!-- Notas Table -->
                    <div style="overflow-x: auto;">
                        <table class="table" style="font-size: 0.875rem;">
                            <thead>
                                <tr>
                                    <th>Tipo Evaluación</th>
                                    <th>Período</th>
                                    <th>Fecha</th>
                                    <th style="text-align: center;">Ponderación</th>
                                    <th style="text-align: center;">Nota</th>
                                    <th>Observaciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reporte['notas'] as $nota)
                                    @php
                                        $nc = (float)$nota->nota;
                                        $nColor = $nc >= 6.0 ? 'var(--success)' : ($nc >= 5.0 ? '#0ea5e9' : ($nc >= 4.0 ? 'var(--warning)' : 'var(--error)'));
                                    @endphp
                                    <tr>
                                        <td>{{ $nota->tipo_evaluacion }}</td>
                                        <td>{{ $nota->periodo }}</td>
                                        <td>{{ $nota->fecha ? $nota->fecha->format('d/m/Y') : '–' }}</td>
                                        <td style="text-align: center;">{{ round($nota->ponderacion * 100) }}%</td>
                                        <td style="text-align: center;">
                                            <span style="font-weight: 700; color: {{ $nColor }};">{{ number_format($nota->nota, 1) }}</span>
                                        </td>
                                        <td style="color: var(--gray-500); font-size: 0.8rem;">{{ $nota->observaciones ?? '–' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="card">
            <div style="text-align: center; padding: var(--spacing-3xl);">
                <i class="fas fa-clipboard-list" style="font-size: 3rem; color: var(--gray-200); margin-bottom: var(--spacing-md);"></i>
                <p style="color: var(--gray-500);">No hay notas registradas para este estudiante.</p>
                <a href="{{ route('grades.create') }}" class="btn btn-primary" style="margin-top: var(--spacing-md); color: white;">
                    <i class="fas fa-plus"></i> Registrar Notas
                </a>
            </div>
        </div>
    @endif
</x-app-layout>
