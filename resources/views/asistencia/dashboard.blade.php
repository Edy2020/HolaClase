<x-app-layout>
    <x-slot name="header">
        Dashboard de Asistencia
    </x-slot>

    <!-- Hero Header -->
    <div style="background: linear-gradient(135deg, var(--theme-dark) 0%, #1e1b4b 100%); color: white; padding: var(--spacing-2xl); border-radius: var(--radius-xl); margin-bottom: var(--spacing-2xl); box-shadow: var(--shadow-lg);">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: var(--spacing-md);">
            <div>
                <h2 style="color: white; font-size: 1.75rem; font-weight: 700; margin-bottom: var(--spacing-sm);">
                    <i class="fas fa-chart-area"></i> Dashboard de Asistencia
                </h2>
                <p style="opacity: 0.85; margin: 0; font-size: 0.95rem;">
                    {{ $periodos[$filtroPeriodo] ?? 'Este Mes' }} —
                    {{ $startDate->format('d/m/Y') }} al {{ $endDate->format('d/m/Y') }}
                </p>
            </div>
            <div style="display: flex; gap: var(--spacing-md);">
                <a href="{{ route('attendance.index') }}" class="btn btn-outline" style="color: white; border-color: rgba(255,255,255,0.4);">
                    <i class="fas fa-list"></i> Ver Registros
                </a>
                <a href="{{ route('attendance.create') }}" class="btn" style="background: white; color: var(--theme-dark); font-weight: 700;">
                    <i class="fas fa-plus"></i> Tomar Asistencia
                </a>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-xl">
        <div class="card-body">
            <form method="GET" action="{{ route('attendance.dashboard') }}">
                <div style="display: flex; gap: var(--spacing-md); align-items: end; flex-wrap: wrap;">
                    <div>
                        <label class="form-label">Período</label>
                        <div style="display: flex; gap: var(--spacing-xs);">
                            @foreach($periodos as $key => $label)
                                <button type="submit" name="periodo" value="{{ $key }}"
                                    style="padding: 8px 16px; border-radius: var(--radius-md); font-size: 0.875rem; font-weight: 600; cursor: pointer; border: 2px solid {{ $filtroPeriodo === $key ? 'var(--theme-color)' : 'var(--gray-200)' }}; background: {{ $filtroPeriodo === $key ? 'var(--theme-color)' : 'white' }}; color: {{ $filtroPeriodo === $key ? 'white' : 'var(--gray-700)' }}; transition: all 0.2s;">
                                    {{ $label }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Curso</label>
                        <select name="curso_id" class="form-select" onchange="this.form.submit()">
                            <option value="">Todos los cursos</option>
                            @foreach($cursos as $curso)
                                <option value="{{ $curso->id }}" {{ $filtroCurso == $curso->id ? 'selected' : '' }}>
                                    {{ $curso->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @if($filtroCurso)
                        <a href="{{ route('attendance.dashboard', ['periodo' => $filtroPeriodo]) }}" class="btn btn-outline" style="margin-top: 24px;">
                            <i class="fas fa-times"></i> Limpiar
                        </a>
                    @endif
                    <!-- Hidden to preserve periodo when changing curso -->
                    <input type="hidden" name="periodo" value="{{ $filtroPeriodo }}">
                </div>
            </form>
        </div>
    </div>

    <!-- Stats Cards (compact row) -->
    @php $pctColor = $porcentajeAsistencia >= 85 ? 'var(--success)' : ($porcentajeAsistencia >= 75 ? 'var(--warning)' : 'var(--error)'); @endphp
    <div style="display: flex; gap: var(--spacing-md); margin-bottom: var(--spacing-xl); flex-wrap: wrap;">
        @foreach([
            ['icon' => 'fa-list-alt',      'value' => $totalRegistros,       'label' => 'Total',      'color' => 'var(--theme-color)'],
            ['icon' => 'fa-percent',        'value' => $porcentajeAsistencia.'%', 'label' => '% Asist.', 'color' => $pctColor],
            ['icon' => 'fa-check-circle',   'value' => $totalPresente,        'label' => 'Presentes',  'color' => 'var(--success)'],
            ['icon' => 'fa-times-circle',   'value' => $totalAusente,         'label' => 'Ausentes',   'color' => 'var(--error)'],
            ['icon' => 'fa-clock',          'value' => $totalTarde,           'label' => 'Tardanzas',  'color' => 'var(--warning)'],
            ['icon' => 'fa-file-alt',       'value' => $totalJustificado,     'label' => 'Justif.',    'color' => '#3b82f6'],
        ] as $s)
            <div style="flex: 1; min-width: 120px; background: white; border: 1px solid var(--gray-100); border-radius: var(--radius-lg); padding: 12px 16px; display: flex; align-items: center; gap: 12px; box-shadow: 0 1px 4px rgba(0,0,0,0.06);">
                <div style="width: 36px; height: 36px; border-radius: var(--radius-md); background: {{ $s['color'] }}18; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <i class="fas {{ $s['icon'] }}" style="color: {{ $s['color'] }}; font-size: 0.875rem;"></i>
                </div>
                <div>
                    <div style="font-size: 1.25rem; font-weight: 800; color: {{ $s['color'] }}; line-height: 1.1;">{{ $s['value'] }}</div>
                    <div style="font-size: 0.7rem; color: var(--gray-500); font-weight: 600; text-transform: uppercase; letter-spacing: 0.03em;">{{ $s['label'] }}</div>
                </div>
            </div>
        @endforeach
    </div>


    <!-- Charts Row -->
    <div class="grid grid-cols-2 mb-xl" style="gap: var(--spacing-xl);">
        <!-- Trend Chart -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-chart-line"></i> Tendencia de Asistencia</h3>
            </div>
            <div class="card-body">
                @if(count($chartDias) > 0)
                    <canvas id="trendChart" height="120"></canvas>
                @else
                    <div style="text-align: center; padding: var(--spacing-2xl); color: var(--gray-400);">
                        <i class="fas fa-chart-line" style="font-size: 2.5rem; margin-bottom: 8px; display: block;"></i>
                        Sin datos en el período
                    </div>
                @endif
            </div>
        </div>

        <!-- Donut Chart -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-chart-pie"></i> Distribución de Estados</h3>
            </div>
            <div class="card-body" style="display: flex; align-items: center; gap: var(--spacing-xl);">
                @if($totalRegistros > 0)
                    <div style="flex: 0 0 180px;">
                        <canvas id="donutChart" width="180" height="180"></canvas>
                    </div>
                    <div style="flex: 1; display: flex; flex-direction: column; gap: var(--spacing-md);">
                        @foreach([
                            ['label' => 'Presente',    'value' => $totalPresente,    'color' => '#10b981'],
                            ['label' => 'Ausente',     'value' => $totalAusente,     'color' => '#ef4444'],
                            ['label' => 'Tardanza',    'value' => $totalTarde,       'color' => '#f59e0b'],
                            ['label' => 'Justificado', 'value' => $totalJustificado, 'color' => '#3b82f6'],
                        ] as $item)
                            <div style="display: flex; align-items: center; gap: var(--spacing-sm);">
                                <div style="width: 12px; height: 12px; border-radius: 3px; background: {{ $item['color'] }}; flex-shrink: 0;"></div>
                                <span style="flex: 1; font-size: 0.875rem; color: var(--gray-700);">{{ $item['label'] }}</span>
                                <span style="font-weight: 700; color: var(--gray-900);">{{ $item['value'] }}</span>
                                <span style="font-size: 0.75rem; color: var(--gray-400);">
                                    ({{ $totalRegistros > 0 ? round($item['value']/$totalRegistros*100) : 0 }}%)
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div style="text-align: center; width: 100%; padding: var(--spacing-2xl); color: var(--gray-400);">
                        <i class="fas fa-chart-pie" style="font-size: 2.5rem; margin-bottom: 8px; display: block;"></i>
                        Sin datos en el período
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Bottom Row: Critical Students + Course Summary -->
    <div class="grid grid-cols-2 mb-xl" style="gap: var(--spacing-xl);">
        <!-- Critical Students -->
        <div class="card">
            <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                <h3 class="card-title">
                    <i class="fas fa-exclamation-triangle" style="color: var(--warning);"></i>
                    Asistencia Crítica
                    <span style="font-size: 0.75rem; font-weight: 400; color: var(--gray-500); margin-left: 4px;">(menos del 75%)</span>
                </h3>
                @if($estudiantesCriticos->count() > 0)
                    <span class="badge badge-danger">{{ $estudiantesCriticos->count() }} alumnos</span>
                @endif
            </div>
            <div class="card-body" style="padding: 0;">
                @if($estudiantesCriticos->count() > 0)
                    <div style="overflow-x: auto;">
                        <table class="table" style="margin: 0;">
                            <thead>
                                <tr>
                                    <th>Estudiante</th>
                                    <th style="text-align: center;">Asistidas</th>
                                    <th style="text-align: center;">% Asistencia</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($estudiantesCriticos as $critico)
                                    @php
                                        $pct = $critico['porcentaje'];
                                        $barColor = $pct >= 70 ? '#f59e0b' : '#ef4444';
                                    @endphp
                                    <tr>
                                        <td>
                                            <div style="font-weight: 600; font-size: 0.875rem; color: var(--gray-900);">
                                                {{ $critico['estudiante']->nombre ?? '–' }} {{ $critico['estudiante']->apellido ?? '' }}
                                            </div>
                                            <div style="font-size: 0.75rem; color: var(--gray-500);">
                                                {{ $critico['estudiante']->rut ?? '' }}
                                            </div>
                                        </td>
                                        <td style="text-align: center; font-size: 0.875rem; color: var(--gray-600);">
                                            {{ $critico['asistio'] }} / {{ $critico['total'] }}
                                        </td>
                                        <td>
                                            <div style="display: flex; align-items: center; gap: 8px;">
                                                <div style="flex: 1; height: 6px; background: var(--gray-100); border-radius: 9999px; overflow: hidden;">
                                                    <div style="width: {{ $pct }}%; height: 100%; background: {{ $barColor }}; border-radius: 9999px;"></div>
                                                </div>
                                                <span style="font-weight: 700; color: {{ $barColor }}; font-size: 0.875rem; flex-shrink: 0;">{{ $pct }}%</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div style="text-align: center; padding: var(--spacing-2xl); color: var(--gray-500);">
                        <i class="fas fa-check-circle" style="font-size: 2.5rem; color: var(--success); margin-bottom: 8px; display: block;"></i>
                        <p style="margin: 0; font-weight: 600;">¡Sin alumnos en riesgo!</p>
                        <p style="margin: 0; font-size: 0.875rem; margin-top: 4px;">Todos mantienen asistencia ≥ 75%</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Course Summary -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-chalkboard"></i> Resumen por Curso</h3>
            </div>
            <div class="card-body" style="padding: 0; overflow-y: auto; max-height: 420px;">
                @if($resumenCursos->count() > 0)
                    <table class="table" style="margin: 0;">
                        <thead>
                            <tr>
                                <th>Curso</th>
                                <th style="text-align: center;">Registros</th>
                                <th style="text-align: center;">% Asistencia</th>
                                <th style="text-align: center;">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($resumenCursos as $res)
                                @php
                                    $sem = $res['semaforo'];
                                    $semColor  = match($sem) { 'green' => 'var(--success)', 'yellow' => 'var(--warning)', 'red' => 'var(--error)', default => 'var(--gray-400)' };
                                    $badgeClass = match($sem) { 'green' => 'badge-success', 'yellow' => 'badge-warning', 'red' => 'badge-danger', default => '' };
                                @endphp
                                <tr>
                                    <td>
                                        <a href="{{ route('attendance.reporte.curso', $res['id']) }}" style="font-weight: 600; color: var(--theme-color); text-decoration: none; font-size: 0.875rem;">
                                            {{ $res['nombre'] }}
                                        </a>
                                        <div style="font-size: 0.75rem; color: var(--gray-500);">{{ $res['estudiantes'] }} estudiantes</div>
                                    </td>
                                    <td style="text-align: center; font-size: 0.875rem; color: var(--gray-600);">{{ $res['total'] }}</td>
                                    <td>
                                        @if(!is_null($res['porcentaje']))
                                            <div style="display: flex; align-items: center; gap: 8px;">
                                                <div style="flex: 1; height: 6px; background: var(--gray-100); border-radius: 9999px; overflow: hidden;">
                                                    <div style="width: {{ $res['porcentaje'] }}%; height: 100%; background: {{ $semColor }}; border-radius: 9999px;"></div>
                                                </div>
                                                <span style="font-weight: 700; color: {{ $semColor }}; font-size: 0.875rem; flex-shrink: 0;">{{ $res['porcentaje'] }}%</span>
                                            </div>
                                        @else
                                            <span style="color: var(--gray-300); font-size: 0.875rem;">Sin datos</span>
                                        @endif
                                    </td>
                                    <td style="text-align: center;">
                                        @if(!is_null($res['porcentaje']))
                                            <div style="width: 14px; height: 14px; border-radius: 50%; background: {{ $semColor }}; margin: 0 auto;" title="{{ $res['semaforo'] === 'green' ? 'Óptima' : ($res['semaforo'] === 'yellow' ? 'Regular' : 'Crítica') }}"></div>
                                        @else
                                            <div style="width: 14px; height: 14px; border-radius: 50%; background: var(--gray-200); margin: 0 auto;"></div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div style="text-align: center; padding: var(--spacing-2xl); color: var(--gray-400);">
                        <i class="fas fa-chalkboard" style="font-size: 2.5rem; margin-bottom: 8px; display: block;"></i>
                        Sin cursos con datos
                    </div>
                @endif
            </div>
            <!-- Semaphore Legend -->
            <div style="padding: var(--spacing-md) var(--spacing-lg); border-top: 1px solid var(--gray-100); display: flex; gap: var(--spacing-lg);">
                @foreach([['color' => 'var(--success)', 'label' => '≥ 85% Óptima'], ['color' => 'var(--warning)', 'label' => '75-84% Regular'], ['color' => 'var(--error)', 'label' => '< 75% Crítica']] as $s)
                    <div style="display: flex; align-items: center; gap: 6px; font-size: 0.75rem; color: var(--gray-600);">
                        <div style="width: 10px; height: 10px; border-radius: 50%; background: {{ $s['color'] }};"></div>
                        {{ $s['label'] }}
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        // Trend line chart
        @if(count($chartDias) > 0)
        const trendCtx = document.getElementById('trendChart');
        if (trendCtx) {
            new Chart(trendCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($chartDias) !!},
                    datasets: [{
                        label: '% Asistencia',
                        data: {!! json_encode($chartPorcentajes) !!},
                        borderColor: 'rgb(124, 58, 237)',
                        backgroundColor: 'rgba(124, 58, 237, 0.08)',
                        borderWidth: 2.5,
                        pointRadius: 4,
                        pointBackgroundColor: 'rgb(124, 58, 237)',
                        pointBorderColor: 'white',
                        pointBorderWidth: 2,
                        fill: true,
                        tension: 0.4,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: ctx => ` ${ctx.raw}% asistencia`
                            }
                        }
                    },
                    scales: {
                        y: {
                            min: 0, max: 100,
                            ticks: {
                                callback: v => v + '%',
                                font: { size: 11 }
                            },
                            grid: { color: 'rgba(0,0,0,0.04)' }
                        },
                        x: {
                            ticks: { font: { size: 11 } },
                            grid: { display: false }
                        }
                    }
                }
            });
        }
        @endif

        // Donut chart
        @if($totalRegistros > 0)
        const donutCtx = document.getElementById('donutChart');
        if (donutCtx) {
            new Chart(donutCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Presente', 'Ausente', 'Tardanza', 'Justificado'],
                    datasets: [{
                        data: [{{ $totalPresente }}, {{ $totalAusente }}, {{ $totalTarde }}, {{ $totalJustificado }}],
                        backgroundColor: ['#10b981', '#ef4444', '#f59e0b', '#3b82f6'],
                        borderWidth: 2,
                        borderColor: 'white',
                    }]
                },
                options: {
                    responsive: false,
                    cutout: '70%',
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: ctx => ` ${ctx.label}: ${ctx.raw} (${Math.round(ctx.raw / {{ $totalRegistros }} * 100)}%)`
                            }
                        }
                    }
                }
            });
        }
        @endif
    </script>
</x-app-layout>
