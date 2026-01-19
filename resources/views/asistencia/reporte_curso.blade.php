<x-app-layout>
    <x-slot name="header">
        Reporte de Asistencia - {{ $curso->nombre }}
    </x-slot>

    <!-- Header -->
    <div class="card mb-xl">
        <div class="card-header">
            <h3 class="card-title">Filtros del Reporte</h3>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('attendance.reporte.curso', $curso) }}">
                <div class="grid grid-cols-4">
                    <div class="form-group mb-0">
                        <label class="form-label">Fecha Inicio</label>
                        <input type="date" name="start_date" class="form-input" value="{{ $startDate }}">
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label">Fecha Fin</label>
                        <input type="date" name="end_date" class="form-input" value="{{ $endDate }}">
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label">Asignatura</label>
                        <select name="asignatura_id" class="form-select">
                            <option value="">Todas las asignaturas</option>
                            @foreach($asignaturas as $asignatura)
                                <option value="{{ $asignatura->id }}" {{ $asignaturaId == $asignatura->id ? 'selected' : '' }}>
                                    {{ $asignatura->nombre }}
                                </option>
                            @endforeach
                        </select>
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

    <!-- Report Table -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Reporte de Asistencia por Estudiante</h3>
        </div>
        <div class="card-body">
            @if($reporteEstudiantes->count() > 0)
                <div style="overflow-x: auto;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Estudiante</th>
                                <th>RUT</th>
                                <th>Total Días</th>
                                <th>Presente</th>
                                <th>Tarde</th>
                                <th>Ausente</th>
                                <th>Justificado</th>
                                <th>% Asistencia</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reporteEstudiantes as $reporte)
                                <tr>
                                    <td>
                                        <a href="{{ route('attendance.reporte.estudiante', $reporte['estudiante']) }}"
                                            style="color: var(--theme-color); text-decoration: none;">
                                            {{ $reporte['estudiante']->nombre }} {{ $reporte['estudiante']->apellido }}
                                        </a>
                                    </td>
                                    <td>{{ $reporte['estudiante']->rut }}</td>
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
                                            <span
                                                style="font-weight: 600; color: {{ $reporte['porcentaje'] >= 85 ? 'var(--success)' : ($reporte['porcentaje'] >= 70 ? 'var(--warning)' : 'var(--error)') }};">
                                                {{ $reporte['porcentaje'] }}%
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div
                    style="text-align: center; padding: var(--spacing-2xl); background: var(--gray-50); border-radius: var(--radius-md);">
                    <i class="fas fa-chart-bar"
                        style="font-size: 3rem; color: var(--gray-300); margin-bottom: var(--spacing-md);"></i>
                    <p style="color: var(--gray-600);">No hay datos de asistencia para el período seleccionado</p>
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