<x-app-layout>
    <x-slot name="header">
        Reporte de Asistencia - {{ $estudiante->nombre }} {{ $estudiante->apellido }}
    </x-slot>

    <div class="card mb-xl">
        <div class="card-body">
            <div style="display: flex; align-items: center; gap: var(--spacing-lg);">
                <div
                    style="width: 80px; height: 80px; border-radius: var(--radius-full); background: var(--theme-color); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 2rem;">
                    {{ substr($estudiante->nombre, 0, 1) }}{{ substr($estudiante->apellido, 0, 1) }}
                </div>
                <div style="flex: 1;">
                    <h2
                        style="font-size: 1.5rem; font-weight: 700; color: var(--gray-900); margin-bottom: var(--spacing-xs);">
                        {{ $estudiante->nombre }} {{ $estudiante->apellido }}
                    </h2>
                    <div style="color: var(--gray-600);">
                        <span><i class="fas fa-id-card"></i> {{ $estudiante->rut }}</span>
                        @if($estudiante->email)
                            <span style="margin-left: var(--spacing-md);"><i class="fas fa-envelope"></i>
                                {{ $estudiante->email }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-xl">
        <div class="card-header">
            <h3 class="card-title">Filtros del Reporte</h3>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('attendance.reporte.estudiante', $estudiante) }}">
                <div class="grid grid-cols-3">
                    <div class="form-group mb-0">
                        <label class="form-label">Fecha Inicio</label>
                        <input type="date" name="start_date" class="form-input" value="{{ $startDate }}">
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label">Fecha Fin</label>
                        <input type="date" name="end_date" class="form-input" value="{{ $endDate }}">
                    </div>
                    <div class="form-group mb-0" style="display: flex; align-items: flex-end;">
                        <button type="submit" class="btn btn-primary" style="width: 100%; color: white;">
                            <i class="fas fa-filter"></i> Aplicar Filtros
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-5 mb-xl">
        <div class="stat-card">
            <div class="stat-value" style="color: var(--theme-color);">{{ $stats['total'] }}</div>
            <div class="stat-label">Total Días</div>
        </div>
        <div class="stat-card">
            <div class="stat-value" style="color: var(--success);">{{ $stats['presente'] }}</div>
            <div class="stat-label">Presente</div>
        </div>
        <div class="stat-card">
            <div class="stat-value" style="color: var(--warning);">{{ $stats['tarde'] }}</div>
            <div class="stat-label">Tarde</div>
        </div>
        <div class="stat-card">
            <div class="stat-value" style="color: var(--error);">{{ $stats['ausente'] }}</div>
            <div class="stat-label">Ausente</div>
        </div>
        <div class="stat-card">
            <div class="stat-value"
                style="color: {{ $stats['porcentaje'] >= 85 ? 'var(--success)' : ($stats['porcentaje'] >= 70 ? 'var(--warning)' : 'var(--error)') }};">
                {{ $stats['porcentaje'] }}%
            </div>
            <div class="stat-label">% Asistencia</div>
        </div>
    </div>

    @if($reporteAsignaturas->count() > 0)
        <div class="card mb-xl">
            <div class="card-header">
                <h3 class="card-title">Asistencia por Asignatura</h3>
            </div>
            <div class="card-body">
                <div style="overflow-x: auto;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Asignatura</th>
                                <th>Total Días</th>
                                <th>Presente</th>
                                <th>Tarde</th>
                                <th>Ausente</th>
                                <th>Justificado</th>
                                <th>% Asistencia</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reporteAsignaturas as $reporte)
                                <tr>
                                    <td>{{ $reporte['asignatura']->nombre }}</td>
                                    <td>{{ $reporte['total'] }}</td>
                                    <td><span class="badge badge-success">{{ $reporte['presente'] }}</span></td>
                                    <td><span class="badge badge-warning">{{ $reporte['tarde'] }}</span></td>
                                    <td><span class="badge badge-danger">{{ $reporte['ausente'] }}</span></td>
                                    <td><span class="badge badge-info">{{ $reporte['justificado'] }}</span></td>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: var(--spacing-sm);">
                                            <div
                                                style="flex: 1; background: var(--gray-200); height: 8px; border-radius: var(--radius-full); overflow: hidden;">
                                                <div
                                                    style="width: {{ $reporte['porcentaje'] }}%; background: {{ $reporte['porcentaje'] >= 85 ? 'var(--success)' : ($reporte['porcentaje'] >= 70 ? 'var(--warning)' : 'var(--error)') }}; height: 100%;">
                                                </div>
                                            </div>
                                            <span style="font-weight: 600;">{{ $reporte['porcentaje'] }}%</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Historial de Asistencia</h3>
        </div>
        <div class="card-body">
            @if($asistencias->count() > 0)
                <div style="overflow-x: auto;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Curso</th>
                                <th>Asignatura</th>
                                <th>Estado</th>
                                <th>Notas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($asistencias as $asistencia)
                                <tr>
                                    <td>{{ $asistencia->fecha->format('d/m/Y') }}</td>
                                    <td>{{ $asistencia->curso->nombre }}</td>
                                    <td>{{ $asistencia->asignatura->nombre }}</td>
                                    <td>
                                        <span class="badge badge-{{ $asistencia->estado_color }}">
                                            {{ $asistencia->estado_label }}
                                        </span>
                                    </td>
                                    <td>{{ $asistencia->notas ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div
                    style="text-align: center; padding: var(--spacing-2xl); background: var(--gray-50); border-radius: var(--radius-md);">
                    <i class="fas fa-calendar-times"
                        style="font-size: 3rem; color: var(--gray-300); margin-bottom: var(--spacing-md);"></i>
                    <p style="color: var(--gray-600);">No hay registros de asistencia para el período seleccionado</p>
                </div>
            @endif
        </div>
        <div class="card-footer">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <a href="{{ route('attendance.index') }}" class="btn btn-ghost">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
                <div style="color: var(--gray-600); font-size: 0.875rem;">
                    Período: {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} -
                    {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>