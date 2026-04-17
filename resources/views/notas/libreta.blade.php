<x-app-layout>
    <x-slot name="header">
        Libreta de Notas
    </x-slot>

    <!-- Header -->
    <div style="background: var(--theme-dark); color: white; padding: var(--spacing-2xl); border-radius: var(--radius-xl); margin-bottom: var(--spacing-2xl);">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; align-items: center; gap: var(--spacing-lg);">
                <div style="width: 60px; height: 60px; border-radius: 50%; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.5rem;">
                    {{ strtoupper(substr($estudiante->nombre, 0, 1) . substr($estudiante->apellido, 0, 1)) }}
                </div>
                <div>
                    <h2 style="color: white; font-size: 1.75rem; font-weight: 700; margin-bottom: 4px;">
                        <i class="fas fa-book-open"></i> Libreta de Notas
                    </h2>
                    <p style="opacity: 0.85; margin: 0;">
                        {{ $estudiante->nombre }} {{ $estudiante->apellido }} — {{ $estudiante->rut }}
                    </p>
                </div>
            </div>
            <div style="display: flex; gap: var(--spacing-md); align-items: center;">
                @php
                    $finalColor = $promedioFinal >= 6 ? '#4ade80' : ($promedioFinal >= 5 ? '#38bdf8' : ($promedioFinal >= 4 ? '#fbbf24' : '#f87171'));
                @endphp
                <div style="text-align: center; background: rgba(255,255,255,0.1); padding: var(--spacing-md) var(--spacing-xl); border-radius: var(--radius-lg);">
                    <div style="font-size: 2.5rem; font-weight: 900; color: {{ $finalColor }};">{{ $promedioFinal ?: '–' }}</div>
                    <div style="font-size: 0.75rem; opacity: 0.8; margin-top: 2px;">Promedio Final</div>
                    @if($promedioFinal >= 4.0)
                        <div style="font-size: 0.7rem; color: #4ade80; margin-top: 2px; font-weight: 700;">✓ PROMOVIDO</div>
                    @elseif($promedioFinal > 0)
                        <div style="font-size: 0.7rem; color: #f87171; margin-top: 2px; font-weight: 700;">✗ REPROBADO</div>
                    @endif
                </div>
                <div style="display: flex; flex-direction: column; gap: var(--spacing-sm);">
                    <a href="{{ route('grades.reporte.estudiante', $estudiante->id) }}" class="btn btn-outline" style="color: white; border-color: rgba(255,255,255,0.4);">
                        <i class="fas fa-chart-bar"></i> Ver Reporte
                    </a>
                    <a href="{{ route('grades.export.pdf', ['estudiante_id' => $estudiante->id]) }}" class="btn btn-outline" style="color: white; border-color: rgba(255,255,255,0.4);" target="_blank">
                        <i class="fas fa-file-pdf"></i> Exportar PDF
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if($libreta->count() > 0)
        @foreach($libreta as $periodo => $asignaturas)
            <div style="margin-bottom: var(--spacing-2xl);">
                <!-- Period Header -->
                <div style="display: flex; align-items: center; gap: var(--spacing-md); margin-bottom: var(--spacing-lg);">
                    <div style="height: 2px; flex: 0 0 40px; background: #84cc16;"></div>
                    <h3 style="font-size: 1.2rem; font-weight: 700; color: var(--theme-dark); margin: 0; white-space: nowrap;">
                        <i class="fas fa-calendar-alt" style="color: #84cc16;"></i> {{ $periodo }}
                    </h3>
                    <div style="height: 2px; flex: 1; background: var(--gray-200);"></div>
                </div>

                <div class="card">
                    <div class="card-body" style="padding: 0; overflow-x: auto;">
                        <table class="table" style="margin: 0;">
                            <thead>
                                <tr>
                                    <th>Asignatura</th>
                                    <th style="text-align: center; min-width: 80px;">Promedio</th>
                                    <th style="text-align: center;">Estado</th>
                                    <th>Detalle de Evaluaciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($asignaturas as $asignaturaData)
                                    @php
                                        $prom = $asignaturaData['promedio'];
                                        $pColor = $prom >= 6.0 ? 'var(--success)' : ($prom >= 5.0 ? '#0ea5e9' : ($prom >= 4.0 ? 'var(--warning)' : 'var(--error)'));
                                    @endphp
                                    <tr>
                                        <td style="font-weight: 600; color: var(--gray-900);">
                                            {{ $asignaturaData['asignatura']->nombre ?? '–' }}
                                        </td>
                                        <td style="text-align: center;">
                                            <span style="font-size: 1.5rem; font-weight: 800; color: {{ $pColor }};">
                                                {{ $prom ?: '–' }}
                                            </span>
                                        </td>
                                        <td style="text-align: center;">
                                            @if($prom >= 4.0)
                                                <span class="badge badge-success">Aprobado</span>
                                            @elseif($prom > 0)
                                                <span class="badge badge-danger">Reprobado</span>
                                            @else
                                                <span class="badge">–</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div style="display: flex; gap: var(--spacing-sm); flex-wrap: wrap;">
                                                @foreach($asignaturaData['notas'] as $nota)
                                                    @php
                                                        $nc = (float)$nota->nota;
                                                        $nbg = $nc >= 4.0 ? '#d1fae5' : '#fee2e2';
                                                        $ntc = $nc >= 4.0 ? '#065f46' : '#991b1b';
                                                    @endphp
                                                    <span title="{{ $nota->tipo_evaluacion }} ({{ round($nota->ponderacion*100) }}%)"
                                                          style="background: {{ $nbg }}; color: {{ $ntc }}; padding: 3px 10px; border-radius: 9999px; font-size: 0.8rem; font-weight: 700; cursor: default;">
                                                        {{ number_format($nota->nota, 1) }}
                                                        <span style="font-size: 0.65rem; opacity: 0.7;">{{ round($nota->ponderacion*100) }}%</span>
                                                    </span>
                                                @endforeach
                                            </div>
                                        </td>
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
                <i class="fas fa-book-open" style="font-size: 3rem; color: var(--gray-200); margin-bottom: var(--spacing-md);"></i>
                <p style="color: var(--gray-500); font-size: 1.125rem;">Este estudiante no tiene notas registradas.</p>
                <a href="{{ route('grades.create') }}" class="btn btn-primary" style="margin-top: var(--spacing-md); color: white;">
                    <i class="fas fa-plus"></i> Registrar Notas
                </a>
            </div>
        </div>
    @endif
</x-app-layout>
