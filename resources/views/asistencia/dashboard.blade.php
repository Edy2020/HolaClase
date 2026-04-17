<x-app-layout>
    <x-slot name="header">
        Dashboard de Asistencia
    </x-slot>

    <link rel="stylesheet" href="{{ asset('css/shared-index.css') }}?v={{ time() }}">

    <!-- Page Header -->
    <div class="page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-lg);">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--gray-900); margin: 0;">
                <i class="fas fa-chart-area" style="color: var(--gray-400); margin-right: 8px;"></i>Asistencia
            </h2>
            <p style="color: var(--gray-500); margin: var(--spacing-xs) 0 0 0; font-size: 0.9375rem;">
                {{ $periodos[$filtroPeriodo] ?? 'Este Mes' }} —
                {{ $startDate->format('d/m/Y') }} al {{ $endDate->format('d/m/Y') }}
            </p>
        </div>
        <div class="header-actions" style="display: flex; gap: var(--spacing-md);">
            <a href="{{ route('attendance.index') }}" class="btn btn-outline"
                style="display: flex; align-items: center; justify-content: center; gap: var(--spacing-sm); border: 1px solid var(--gray-300); color: var(--gray-700); background: transparent; padding: 0.625rem 1.25rem; border-radius: var(--radius-md); font-weight: 600; text-decoration: none; transition: all 0.2s;"
                onmouseover="this.style.background='var(--gray-50)'; this.style.color='var(--gray-900)'"
                onmouseout="this.style.background='transparent'; this.style.color='var(--gray-700)'">
                <i class="fas fa-list"></i>
                <span class="btn-text">Ver Registros</span>
            </a>
            <a href="{{ route('attendance.create') }}" class="btn btn-outline"
                style="display: flex; align-items: center; justify-content: center; gap: var(--spacing-sm); border: 1px solid var(--gray-300); color: var(--gray-700); background: transparent; padding: 0.625rem 1.25rem; border-radius: var(--radius-md); font-weight: 600; text-decoration: none; transition: all 0.2s;"
                onmouseover="this.style.background='var(--gray-50)'; this.style.color='var(--gray-900)'"
                onmouseout="this.style.background='transparent'; this.style.color='var(--gray-700)'">
                <i class="fas fa-plus"></i>
                <span class="btn-text">Tomar Asistencia</span>
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="mb-xl filters-card">
                        <form method="GET" action="{{ route('attendance.dashboard') }}" id="filterForm">
            <div style="display: flex; gap: var(--spacing-md); align-items: center; flex-wrap: wrap;">
                <div>
                    <div style="display: flex; gap: var(--spacing-xs);" class="periodo-buttons">
                        @foreach($periodos as $key => $label)
                            <button type="button" data-periodo="{{ $key }}"
                                style="padding: 6px 14px; border-radius: var(--radius-lg); font-size: 0.85rem; font-weight: 600; cursor: pointer; border: 1px solid {{ $filtroPeriodo === $key ? '#84cc16' : 'var(--gray-300)' }}; background: {{ $filtroPeriodo === $key ? '#84cc16' : 'transparent' }}; color: {{ $filtroPeriodo === $key ? 'white' : 'var(--gray-600)' }}; transition: all 0.2s;">
                                {{ $label }}
                            </button>
                        @endforeach
                    </div>
                </div>
                
                <div style="flex: 1; min-width: 250px;">
                    <div class="form-group mb-0" style="position: relative;">
                        <div style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--gray-400); font-size: 1rem; pointer-events: none; z-index: 1;">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <select name="curso_id" class="form-select" id="curso_filter"
                            style="padding-left: 40px; border: 2px solid var(--gray-200); border-radius: var(--radius-lg); transition: all 0.2s; font-size: 0.9375rem; cursor: pointer;"
                            onfocus="this.style.borderColor='#84cc16'; this.style.boxShadow='0 0 0 3px rgba(132, 204, 22, 0.1)'"
                            onblur="this.style.borderColor='var(--gray-200)'; this.style.boxShadow='none'">
                            <option value="">Todos los cursos</option>
                            @foreach($cursos as $curso)
                                <option value="{{ $curso->id }}" {{ $filtroCurso == $curso->id ? 'selected' : '' }}>
                                    {{ $curso->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                @if($filtroCurso)
                    <button type="button" id="limpiarFiltrosBtn" class="btn btn-outline" 
                        style="height: 48px; display: inline-flex; align-items: center; white-space: nowrap; border-radius: var(--radius-lg); background: var(--gray-100); border: 1px solid var(--gray-300); color: var(--gray-600); cursor: pointer; transition: all 0.2s;"
                        onmouseover="this.style.background='var(--gray-200)'; this.style.borderColor='var(--gray-400)'"
                        onmouseout="this.style.background='var(--gray-100)'; this.style.borderColor='var(--gray-300)'">
                        <i class="fas fa-times"></i> Limpiar
                    </button>
                @endif
                <!-- Hidden to preserve periodo when changing curso -->
                <input type="hidden" name="periodo" id="periodo_hidden" value="{{ $filtroPeriodo }}">
            </div>
        </form>
    </div>

    <!-- TABS NAVIGATION -->
    <div class="system-tabs-container">
        <div id="tab-general" onclick="switchSystemTab('general')" class="system-tab active-tab">
            Visión General
        </div>
        <div id="tab-tendencias" onclick="switchSystemTab('tendencias')" class="system-tab">
            Tendencias y Distribución
        </div>
        <div id="tab-detalles" onclick="switchSystemTab('detalles')" class="system-tab">
            Alertas y Detalles
        </div>
    </div>

    <!-- TAB 1: VISION GENERAL -->
    <div id="section-general" class="system-tab-section active-section">
        <!-- Stats Cards (compact row) -->
    @php $pctColor = $porcentajeAsistencia >= 85 ? 'var(--success)' : ($porcentajeAsistencia >= 75 ? 'var(--warning)' : 'var(--error)'); @endphp
    <div style="display: flex; gap: var(--spacing-md); margin-bottom: var(--spacing-xl); flex-wrap: wrap;">
        @foreach([
            ['icon' => 'fa-list-alt',      'value' => $totalRegistros,       'label' => 'Total',      'color' => '#84cc16'],
            ['icon' => 'fa-percent',        'value' => $porcentajeAsistencia.'%', 'label' => '% Asist.', 'color' => $pctColor],
            ['icon' => 'fa-check-circle',   'value' => $totalPresente,        'label' => 'Presentes',  'color' => 'var(--success)'],
            ['icon' => 'fa-times-circle',   'value' => $totalAusente,         'label' => 'Ausentes',   'color' => 'var(--error)'],
            ['icon' => 'fa-clock',          'value' => $totalTarde,           'label' => 'Tardanzas',  'color' => 'var(--warning)'],
            ['icon' => 'fa-file-alt',       'value' => $totalJustificado,     'label' => 'Justif.',    'color' => '#3b82f6'],
        ] as $s)
            <div class="card" style="flex: 1; min-width: 120px; padding: 12px 16px; display: flex; align-items: center; gap: 12px; border: 1px solid var(--border-color); background: var(--bg-card);">
                <div style="width: 32px; height: 32px; border-radius: var(--radius-sm); background: {{ $s['color'] }}18; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <i class="fas {{ $s['icon'] }}" style="color: {{ $s['color'] }}; font-size: 0.85rem;"></i>
                </div>
                <div>
                    <div style="font-size: 1.1rem; font-weight: 800; color: {{ $s['color'] }}; line-height: 1;">{{ $s['value'] }}</div>
                    <div style="font-size: 0.7rem; color: var(--gray-500); font-weight: 600; text-transform: uppercase;">{{ $s['label'] }}</div>
                </div>
            </div>
        @endforeach
    </div>

    </div>
    <!-- END TAB 1 -->

    <!-- TAB 2: TENDENCIAS -->
    <div id="section-tendencias" class="system-tab-section">
    <!-- Charts Row -->
    <div class="grid grid-cols-2 mb-lg" style="gap: var(--spacing-lg);">
        <!-- Trend Chart -->
        <div class="card" style="background: var(--bg-card); border: 1px solid var(--border-color); min-width: 0; overflow: hidden;">
            <div class="card-header" style="padding: var(--spacing-sm) var(--spacing-md); border-bottom: 1px solid var(--border-color);">
                <h3 class="card-title" style="font-size: 0.95rem; margin: 0; color: var(--text-color);">
                    <i class="fas fa-chart-line" style="color: var(--text-muted, var(--gray-400));"></i> Tendencia de Asistencia
                </h3>
            </div>
            <div class="card-body" style="padding: var(--spacing-sm);">
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
        <div class="card" style="background: var(--bg-card); border: 1px solid var(--border-color); min-width: 0; overflow: hidden;">
            <div class="card-header" style="padding: var(--spacing-sm) var(--spacing-md); border-bottom: 1px solid var(--border-color);">
                <h3 class="card-title" style="font-size: 0.95rem; margin: 0; color: var(--text-color);">
                    <i class="fas fa-chart-pie" style="color: var(--text-muted, var(--gray-400));"></i> Distribución de Estados
                </h3>
            </div>
            <div class="card-body mobile-col" style="display: flex; align-items: center; gap: var(--spacing-lg); padding: var(--spacing-md);">
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
    </div>
    <!-- END TAB 2 -->

    <!-- TAB 2: DETALLES -->
    <div id="section-detalles" class="system-tab-section">
        <!-- Bottom Row: Critical Students + Course Summary -->
    <div class="grid grid-cols-2 mb-lg" style="gap: var(--spacing-lg);">
        <!-- Critical Students -->
        <div class="card" style="min-width: 0; overflow: hidden;">
            <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; padding: var(--spacing-sm) var(--spacing-md); border-bottom: 1px solid var(--border-color);">
                <h3 class="card-title" style="font-size: 0.95rem; margin: 0; color: var(--text-color);">
                    <i class="fas fa-exclamation-triangle" style="color: var(--warning);"></i>
                    Asistencia Crítica
                    <span style="font-size: 0.75rem; font-weight: 400; color: var(--text-muted, var(--gray-500)); margin-left: 4px;">(menos del 75%)</span>
                </h3>
                @if($estudiantesCriticos->count() > 0)
                    <span class="badge badge-danger" style="font-size: 0.7rem; padding: 2px 6px;">{{ $estudiantesCriticos->count() }} alumnos</span>
                @endif
            </div>
            <div class="card-body" style="padding: 0;">
                @if($estudiantesCriticos->count() > 0)
                    <div style="overflow-x: auto;">
                        <table class="table" style="margin: 0;">
                            <thead>
                                <tr class="table-header-row">
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
                                    <tr class="asistencia-item">
                                        <td>
                                            <div style="font-weight: 600; font-size: 0.875rem; color: var(--text-color);">
                                                {{ $critico['estudiante']->nombre ?? '–' }} {{ $critico['estudiante']->apellido ?? '' }}
                                            </div>
                                            <div style="font-size: 0.75rem; color: var(--text-muted, var(--gray-500));">
                                                {{ $critico['estudiante']->rut ?? '' }}
                                            </div>
                                        </td>
                                        <td style="text-align: center; font-size: 0.875rem; color: var(--text-muted, var(--gray-600));">
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
        <div class="card" style="min-width: 0; overflow: hidden;">
            <div class="card-header" style="padding: var(--spacing-sm) var(--spacing-md); border-bottom: 1px solid var(--border-color);">
                <h3 class="card-title" style="font-size: 0.95rem; margin: 0; color: var(--text-color);">
                    <i class="fas fa-chalkboard" style="color: var(--text-muted, var(--gray-400));"></i> Resumen por Curso
                </h3>
            </div>
            <div class="card-body" style="padding: 0; overflow-x: auto; overflow-y: auto; max-height: 420px;">
                @if($resumenCursos->count() > 0)
                    <table class="table" style="margin: 0;">
                        <thead>
                            <tr class="table-header-row">
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
                                <tr class="asistencia-item">
                                    <td>
                                        <a href="{{ route('attendance.reporte.curso', $res['id']) }}" style="font-weight: 600; color: var(--text-color); text-decoration: none; font-size: 0.875rem;">
                                            {{ $res['nombre'] }}
                                        </a>
                                        <div style="font-size: 0.75rem; color: var(--text-muted, var(--gray-500));">{{ $res['estudiantes'] }} estudiantes</div>
                                    </td>
                                    <td style="text-align: center; font-size: 0.875rem; color: var(--text-muted, var(--gray-600));">{{ $res['total'] }}</td>
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

    </div>
    <!-- END TAB 2 -->

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        function switchSystemTab(tabId) {
            document.querySelectorAll('.system-tab').forEach(t => t.classList.remove('active-tab'));
            document.querySelectorAll('.system-tab-section').forEach(s => s.classList.remove('active-section'));

            document.getElementById('tab-' + tabId).classList.add('active-tab');
            document.getElementById('section-' + tabId).classList.add('active-section');
        }

        // --- Client-side REAL TIME Filtering via AJAX DOM Replacement ---
        function bindAjaxFilters() {
            const form = document.getElementById('filterForm');
            if (!form) return;

            const cursoSelect = document.getElementById('curso_filter');
            if(cursoSelect) {
                cursoSelect.addEventListener('change', fetchDashboardData);
            }

            const periodoBtns = form.querySelectorAll('.periodo-buttons button[data-periodo]');
            periodoBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    form.querySelector('input[name="periodo"]').value = this.dataset.periodo;
                    fetchDashboardData();
                });
            });

            const clearBtn = document.getElementById('limpiarFiltrosBtn');
            if (clearBtn) {
                clearBtn.addEventListener('click', function() {
                    const s = document.getElementById('curso_filter');
                    if(s) s.value = '';
                    fetchDashboardData();
                });
            }
        }

        function fetchDashboardData() {
            const form = document.getElementById('filterForm');
            const url = new URL(form.action);
            url.search = new URLSearchParams(new FormData(form)).toString();

            fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(res => res.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');

                    // Update filters-card visual state for buttons
                    const newFiltersCard = doc.querySelector('.filters-card');
                    const oldFiltersCard = document.querySelector('.filters-card');
                    if(newFiltersCard && oldFiltersCard) {
                        oldFiltersCard.innerHTML = newFiltersCard.innerHTML;
                        bindAjaxFilters(); // rebind since we replaced HTML
                    }
                    
                    // Update header title part
                    const newHeader = doc.querySelector('.page-header p');
                    const oldHeader = document.querySelector('.page-header p');
                    if (newHeader && oldHeader) oldHeader.innerHTML = newHeader.innerHTML;

                    // Replace main sections
                    const sections = ['section-general', 'section-tendencias', 'section-detalles'];
                    sections.forEach(id => {
                        const newSection = doc.getElementById(id);
                        const oldSection = document.getElementById(id);
                        if(newSection && oldSection) {
                            oldSection.innerHTML = newSection.innerHTML;
                        }
                    });

                    // Destroy old charts to prevent overlapping hover logic
                    if (window.trendChart instanceof Chart) window.trendChart.destroy();
                    if (window.donutChart instanceof Chart) window.donutChart.destroy();

                    // Re-run chart scripts
                    const scripts = doc.querySelectorAll('script');
                    scripts.forEach(script => {
                        if (script.innerText.includes('new Chart(')) {
                            // Convert script block bindings to window bindings
                            let code = script.innerText
                                .replace(/const\s+trendCtx/g, 'window.trendCtx')
                                .replace(/new\s+Chart\(trendCtx/g, 'window.trendChart = new Chart(window.trendCtx')
                                .replace(/const\s+donutCtx/g, 'window.donutCtx')
                                .replace(/new\s+Chart\(donutCtx/g, 'window.donutChart = new Chart(window.donutCtx');
                            try { eval(code); } catch(e) { console.error('chart eval err', e)}
                        }
                    });
                });
        }

        document.addEventListener('DOMContentLoaded', bindAjaxFilters);
    </script>
    <script>
        // Trend line chart
        @if(count($chartDias) > 0)
        window.trendCtx = document.getElementById('trendChart');
        if (window.trendCtx) {
            window.trendChart = new Chart(window.trendCtx, {
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
        window.donutCtx = document.getElementById('donutChart');
        if (window.donutCtx) {
            window.donutChart = new Chart(window.donutCtx, {
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
