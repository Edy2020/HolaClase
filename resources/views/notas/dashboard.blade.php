<x-app-layout>
    <x-slot name="header">
        Dashboard de Notas
    </x-slot>

    <link rel="stylesheet" href="{{ asset('css/shared-index.css') }}?v={{ time() }}">

    <!-- Page Header -->
    <div class="page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-lg);">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--gray-900); margin: 0;">
                <i class="fas fa-chart-bar" style="color: var(--gray-400); margin-right: 8px;"></i> Dashboard de Notas
            </h2>
            <p style="color: var(--gray-500); margin: var(--spacing-xs) 0 0 0; font-size: 0.9375rem;">
                Gestión integral de calificaciones y estadísticas académicas
            </p>
        </div>
        <div class="header-actions" style="display: flex; gap: var(--spacing-md);">
            <a href="{{ route('grades.index') }}" class="btn btn-outline"
                style="display: flex; align-items: center; justify-content: center; gap: var(--spacing-sm); border: 1px solid var(--gray-300); color: var(--gray-700); background: transparent; padding: 0.625rem 1.25rem; border-radius: var(--radius-md); font-weight: 600; text-decoration: none; transition: all 0.2s;"
                onmouseover="this.style.background='var(--gray-50)'; this.style.color='var(--gray-900)'"
                onmouseout="this.style.background='transparent'; this.style.color='var(--gray-700)'">
                <i class="fas fa-list"></i>
                <span class="btn-text">Ver Todas las Notas</span>
            </a>
            <a href="{{ route('grades.create') }}" class="btn btn-outline"
                style="display: flex; align-items: center; justify-content: center; gap: var(--spacing-sm); border: 1px solid var(--gray-300); color: var(--gray-700); background: transparent; padding: 0.625rem 1.25rem; border-radius: var(--radius-md); font-weight: 600; text-decoration: none; transition: all 0.2s;"
                onmouseover="this.style.background='var(--gray-50)'; this.style.color='var(--gray-900)'"
                onmouseout="this.style.background='transparent'; this.style.color='var(--gray-700)'">
                <i class="fas fa-plus"></i>
                <span class="btn-text">Ingresar Notas</span>
            </a>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="mb-xl filters-card">
        <form method="GET" action="{{ route('grades.dashboard') }}" id="filterForm">
            <div class="grid" style="grid-template-columns: 1fr 1fr; gap: var(--spacing-md); align-items: center;">
                
                <div class="form-group mb-0" style="position: relative;">
                    <div style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--gray-400); font-size: 1rem; pointer-events: none; z-index: 1;">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <select name="periodo" class="form-select" onchange="document.getElementById('filterForm').submit()"
                        style="padding-left: 40px; border: 2px solid var(--gray-200); border-radius: var(--radius-lg); transition: all 0.2s; font-size: 0.9375rem; cursor: pointer;"
                        onfocus="this.style.borderColor='#84cc16'; this.style.boxShadow='0 0 0 3px rgba(132, 204, 22, 0.1)'"
                        onblur="this.style.borderColor='var(--gray-200)'; this.style.boxShadow='none'">
                        <option value="">Todos los períodos</option>
                        @foreach($periodos as $periodo)
                            <option value="{{ $periodo }}" {{ $filtroPeriodo === $periodo ? 'selected' : '' }}>
                                {{ $periodo }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-0" style="position: relative;">
                    <div style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--gray-400); font-size: 1rem; pointer-events: none; z-index: 1;">
                        <i class="fas fa-layer-group"></i>
                    </div>
                    <select name="nivel" class="form-select" onchange="document.getElementById('filterForm').submit()"
                        style="padding-left: 40px; border: 2px solid var(--gray-200); border-radius: var(--radius-lg); transition: all 0.2s; font-size: 0.9375rem; cursor: pointer;"
                        onfocus="this.style.borderColor='#84cc16'; this.style.boxShadow='0 0 0 3px rgba(132, 204, 22, 0.1)'"
                        onblur="this.style.borderColor='var(--gray-200)'; this.style.boxShadow='none'">
                        <option value="">Todos los niveles</option>
                        @foreach($niveles as $key => $label)
                            <option value="{{ $key }}" {{ $filtroNivel === $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            @if($filtroPeriodo || $filtroNivel)
                <div style="margin-top: var(--spacing-sm); display: flex; justify-content: flex-end;">
                    <a href="{{ route('grades.dashboard') }}" class="btn btn-sm btn-outline"
                        style="background: var(--gray-100); border: 1px solid var(--gray-300); color: var(--gray-600); cursor: pointer; transition: all 0.2s;"
                        onmouseover="this.style.background='var(--gray-200)'; this.style.borderColor='var(--gray-400)'"
                        onmouseout="this.style.background='var(--gray-100)'; this.style.borderColor='var(--gray-300)'">
                        <i class="fas fa-times"></i> Limpiar Filtros
                    </a>
                </div>
            @endif
        </form>
    </div>

    <!-- TABS CONTAINER (MOBILE ONLY via CSS) -->
    <div class="system-tabs-container">
        <div onclick="switchSystemTab('general')" class="system-tab active-tab" id="tab-general">Visión General</div>
        <div onclick="switchSystemTab('rendimiento')" class="system-tab" id="tab-rendimiento">Rendimiento</div>
        <div onclick="switchSystemTab('detalles')" class="system-tab" id="tab-detalles">Detalles y Exportación</div>
    </div>

    <!-- TAB 1: VISIÓN GENERAL -->
    <div id="section-general" class="system-tab-section active-section">
        <!-- General Statistics -->
        <div class="grid grid-cols-4 mb-lg" style="gap: var(--spacing-md);">
            <div class="card" style="padding: 12px; text-align: center; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); border: 1px solid var(--border-color); background: var(--bg-card);">
                <div style="font-size: 1.5rem; font-weight: 800; color: #3b82f6; line-height: 1;">{{ $totalEstudiantes }}</div>
                <div style="font-size: 0.7rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; margin-top: 4px;">Total Estudiantes</div>
            </div>
            <div class="card" style="padding: 12px; text-align: center; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); border: 1px solid var(--border-color); background: var(--bg-card);">
                <div style="font-size: 1.5rem; font-weight: 800; color: #10b981; line-height: 1;">{{ $totalNotas }}</div>
                <div style="font-size: 0.7rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; margin-top: 4px;">Notas Registradas</div>
            </div>
            <div class="card" style="padding: 12px; text-align: center; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); border: 1px solid var(--border-color); background: var(--bg-card);">
                <div style="font-size: 1.5rem; font-weight: 800; color: #84cc16; line-height: 1;">{{ $promedioGeneral }}</div>
                <div style="font-size: 0.7rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; margin-top: 4px;">Promedio General</div>
            </div>
            <div class="card" style="padding: 12px; text-align: center; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); border: 1px solid var(--border-color); background: var(--bg-card);">
                <div style="font-size: 1.5rem; font-weight: 800; color: {{ $porcentajeAprobacion >= 60 ? 'var(--success)' : 'var(--warning)' }}; line-height: 1;">{{ $porcentajeAprobacion }}%</div>
                <div style="font-size: 0.7rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; margin-top: 4px;">Aprobación</div>
            </div>
        </div>

    <!-- Statistics by Education Level -->
    <div class="grid grid-cols-2 mb-xl" style="gap: var(--spacing-lg);">
        <!-- Básica Statistics -->
        <div class="card" style="min-width: 0; overflow: hidden; background: var(--bg-card); border: 1px solid var(--border-color);">
            <div class="card-header" style="padding-bottom: var(--spacing-sm); border-bottom: 1px solid var(--border-color);">
                <h3 class="card-title" style="margin: 0; font-size: 1.1rem; color: var(--text-color);">
                    <i class="fas fa-school" style="color: #3b82f6; margin-right: 6px;"></i> Educación Básica
                </h3>
            </div>
            <div class="card-body" style="padding: var(--spacing-md) var(--spacing-lg);">
                <div class="grid grid-cols-2 mb-md">
                    <div style="text-align: center;">
                        <div style="font-size: 1.8rem; font-weight: 800; color: var(--success); margin-bottom: 2px;">
                            {{ $estadisticasBasica['porcentaje_aprobacion'] }}%
                        </div>
                        <div style="color: var(--text-muted); font-size: 0.75rem; font-weight: 600; text-transform: uppercase;">Aprobación</div>
                    </div>
                    <div style="text-align: center;">
                        <div style="font-size: 1.8rem; font-weight: 800; color: #84cc16; margin-bottom: 2px;">
                            {{ $estadisticasBasica['promedio'] }}
                        </div>
                        <div style="color: var(--text-muted); font-size: 0.75rem; font-weight: 600; text-transform: uppercase;">Promedio</div>
                    </div>
                </div>
                <div style="display: flex; justify-content: space-around; padding-top: var(--spacing-md); border-top: 1px solid var(--border-color);">
                    <div style="text-align: center;">
                        <div style="font-size: 1.25rem; font-weight: 700; color: var(--success);">
                            {{ $estadisticasBasica['aprobados'] }}
                        </div>
                        <div style="color: var(--text-muted); font-size: 0.7rem; font-weight: 600; text-transform: uppercase;">Aprobados</div>
                    </div>
                    <div style="text-align: center;">
                        <div style="font-size: 1.25rem; font-weight: 700; color: var(--danger);">
                            {{ $estadisticasBasica['reprobados'] }}
                        </div>
                        <div style="color: var(--text-muted); font-size: 0.7rem; font-weight: 600; text-transform: uppercase;">Reprobados</div>
                    </div>
                    <div style="text-align: center;">
                        <div style="font-size: 1.25rem; font-weight: 700; color: var(--text-color);">
                            {{ $estadisticasBasica['total'] }}
                        </div>
                        <div style="color: var(--text-muted); font-size: 0.7rem; font-weight: 600; text-transform: uppercase;">Total</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Media Statistics -->
        <div class="card" style="min-width: 0; overflow: hidden; background: var(--bg-card); border: 1px solid var(--border-color);">
            <div class="card-header" style="padding-bottom: var(--spacing-sm); border-bottom: 1px solid var(--border-color);">
                <h3 class="card-title" style="margin: 0; font-size: 1.1rem; color: var(--text-color);">
                    <i class="fas fa-graduation-cap" style="color: #8b5cf6; margin-right: 6px;"></i> Educación Media
                </h3>
            </div>
            <div class="card-body" style="padding: var(--spacing-md) var(--spacing-lg);">
                <div class="grid grid-cols-2 mb-md">
                    <div style="text-align: center;">
                        <div style="font-size: 1.8rem; font-weight: 800; color: var(--success); margin-bottom: 2px;">
                            {{ $estadisticasMedia['porcentaje_aprobacion'] }}%
                        </div>
                        <div style="color: var(--text-muted); font-size: 0.75rem; font-weight: 600; text-transform: uppercase;">Aprobación</div>
                    </div>
                    <div style="text-align: center;">
                        <div style="font-size: 1.8rem; font-weight: 800; color: #84cc16; margin-bottom: 2px;">
                            {{ $estadisticasMedia['promedio'] }}
                        </div>
                        <div style="color: var(--text-muted); font-size: 0.75rem; font-weight: 600; text-transform: uppercase;">Promedio</div>
                    </div>
                </div>
                <div style="display: flex; justify-content: space-around; padding-top: var(--spacing-md); border-top: 1px solid var(--border-color);">
                    <div style="text-align: center;">
                        <div style="font-size: 1.25rem; font-weight: 700; color: var(--success);">
                            {{ $estadisticasMedia['aprobados'] }}
                        </div>
                        <div style="color: var(--text-muted); font-size: 0.7rem; font-weight: 600; text-transform: uppercase;">Aprobados</div>
                    </div>
                    <div style="text-align: center;">
                        <div style="font-size: 1.25rem; font-weight: 700; color: var(--danger);">
                            {{ $estadisticasMedia['reprobados'] }}
                        </div>
                        <div style="color: var(--text-muted); font-size: 0.7rem; font-weight: 600; text-transform: uppercase;">Reprobados</div>
                    </div>
                    <div style="text-align: center;">
                        <div style="font-size: 1.25rem; font-weight: 700; color: var(--text-color);">
                            {{ $estadisticasMedia['total'] }}
                        </div>
                        <div style="color: var(--text-muted); font-size: 0.7rem; font-weight: 600; text-transform: uppercase;">Total</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- END TAB 1 -->

    <!-- TAB 2: RENDIMIENTO -->
    <div id="section-rendimiento" class="system-tab-section">
        <!-- Charts Section (Moved from top) -->
        <div class="grid grid-cols-2 mb-lg" style="gap: var(--spacing-lg);">
            <!-- Bar Chart - Course Averages -->
            <div class="card" style="min-width: 0; overflow: hidden; background: var(--bg-card); border: 1px solid var(--border-color);">
                <div class="card-header" style="padding: var(--spacing-sm) var(--spacing-md); border-bottom: 1px solid var(--border-color);">
                    <h3 class="card-title" style="font-size: 0.95rem; margin: 0; color: var(--text-color);">
                        <i class="fas fa-chart-bar" style="color: var(--text-muted);"></i> Promedios por Curso (Top 10)
                    </h3>
                </div>
                <div class="card-body" style="padding: var(--spacing-sm);">
                    <canvas id="chartPromedios" style="max-height: 180px; width: 100%;"></canvas>
                </div>
            </div>

            <!-- Doughnut Chart - Pass/Fail Distribution -->
            <div class="card" style="min-width: 0; overflow: hidden; background: var(--bg-card); border: 1px solid var(--border-color);">
                <div class="card-header" style="padding: var(--spacing-sm) var(--spacing-md); border-bottom: 1px solid var(--border-color);">
                    <h3 class="card-title" style="font-size: 0.95rem; margin: 0; color: var(--text-color);">
                        <i class="fas fa-chart-pie" style="color: var(--text-muted);"></i> Distribución de Notas
                    </h3>
                </div>
                <div class="card-body" style="padding: var(--spacing-sm);">
                    <canvas id="chartDistribucion" style="max-height: 180px; width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>
    <!-- END TAB 2 -->

    <!-- TAB 3: DETALLES Y EXPORTACIÓN -->
    <div id="section-detalles" class="system-tab-section">

    <!-- Export Section -->
    <div class="card mb-xl" style="background: var(--bg-card); border: 1px solid var(--border-color);">
        <div class="card-header" style="border-bottom: 1px solid var(--border-color);">
            <h3 class="card-title" style="color: var(--text-color);">
                <i class="fas fa-download" style="color: var(--text-muted);"></i> Exportar Reportes por Curso
            </h3>
        </div>
        <div class="card-body">
            <form id="exportForm" method="GET"
                style="display: flex; gap: var(--spacing-lg); align-items: flex-end; flex-wrap: wrap;">
                <div class="form-group" style="flex: 1; min-width: 250px; margin-bottom: 0;">
                    <label class="form-label">Seleccionar Curso</label>
                    <select name="curso_id" id="curso_filter" class="form-select">
                        <option value="">Todos los cursos</option>
                        @foreach($cursosSelect as $curso)
                            <option value="{{ $curso->id }}">{{ $curso->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group" style="flex: 1; min-width: 200px; margin-bottom: 0;">
                    <label class="form-label">Período (Opcional)</label>
                    <select name="periodo" id="periodo_filter" class="form-select">
                        <option value="">Todos los períodos</option>
                        @foreach($periodos as $periodo)
                            <option value="{{ $periodo }}">{{ $periodo }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="display: flex; gap: var(--spacing-md);">
                    <button type="button" onclick="exportPDF()" class="btn btn-danger">
                        <i class="fas fa-file-pdf"></i> Exportar PDF
                    </button>
                    <button type="button" onclick="exportExcel()" class="btn btn-success">
                        <i class="fas fa-file-excel"></i> Exportar Excel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function exportPDF() {
            const cursoId = document.getElementById('curso_filter').value;
            const periodo = document.getElementById('periodo_filter').value;
            let url = '{{ route("grades.export.pdf") }}?';
            if (cursoId) url += 'curso_id=' + cursoId + '&';
            if (periodo) url += 'periodo=' + periodo;
            window.open(url, '_blank');
        }

        function exportExcel() {
            const cursoId = document.getElementById('curso_filter').value;
            const periodo = document.getElementById('periodo_filter').value;
            let url = '{{ route("grades.export.excel") }}?';
            if (cursoId) url += 'curso_id=' + cursoId + '&';
            if (periodo) url += 'periodo=' + periodo;
            window.location.href = url;
        }
    </script>


    <!-- Course Summary Table -->
    <div class="card" style="background: var(--bg-card); border: 1px solid var(--border-color);">
        <div class="card-header" style="border-bottom: 1px solid var(--border-color);">
            <h3 class="card-title" style="color: var(--text-color);">
                <i class="fas fa-table" style="color: var(--text-muted);"></i> Resumen por Curso
            </h3>
        </div>
        <div class="card-body" style="padding: 0; overflow-x: auto;">
            <div>
                <table class="table" id="cursosTable">
                    <thead>
                        <tr class="table-header-row">
                            <th class="sortable" data-column="nombre" style="cursor: pointer;">
                                Curso <i class="fas fa-sort sort-icon"></i>
                            </th>
                            <th class="sortable" data-column="nivel" style="cursor: pointer;">
                                Nivel <i class="fas fa-sort sort-icon"></i>
                            </th>
                            <th class="sortable" data-column="total_estudiantes" style="cursor: pointer;">
                                Estudiantes <i class="fas fa-sort sort-icon"></i>
                            </th>
                            <th class="sortable" data-column="total_notas" style="cursor: pointer;">
                                Notas Registradas <i class="fas fa-sort sort-icon"></i>
                            </th>
                            <th class="sortable" data-column="promedio" style="cursor: pointer;">
                                Promedio <i class="fas fa-sort sort-icon"></i>
                            </th>
                            <th class="sortable" data-column="aprobados" style="cursor: pointer;">
                                Aprobados <i class="fas fa-sort sort-icon"></i>
                            </th>
                            <th class="sortable" data-column="reprobados" style="cursor: pointer;">
                                Reprobados <i class="fas fa-sort sort-icon"></i>
                            </th>
                            <th class="sortable" data-column="porcentaje_aprobacion" style="cursor: pointer;">
                                % Aprobación <i class="fas fa-sort sort-icon"></i>
                            </th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cursos as $curso)
                            <tr class="nota-item">
                                <td style="font-weight: 600;" data-value="{{ $curso['nombre'] }}">{{ $curso['nombre'] }}</td>
                                <td data-value="{{ $curso['nivel'] }}">
                                    <span class="badge"
                                        style="background: {{ $curso['nivel'] === 'basica' ? '#3b82f6' : '#84cc16' }}; color: white;">
                                        {{ ucfirst($curso['nivel']) }}
                                    </span>
                                </td>
                                <td data-value="{{ $curso['total_estudiantes'] }}">{{ $curso['total_estudiantes'] }}</td>
                                <td data-value="{{ $curso['total_notas'] }}">{{ $curso['total_notas'] }}</td>
                                <td data-value="{{ $curso['promedio'] }}">
                                    <span
                                        style="font-weight: 600; color: {{ $curso['promedio'] >= 5.0 ? 'var(--success)' : ($curso['promedio'] >= 4.0 ? 'var(--warning)' : 'var(--danger)') }};">
                                        {{ $curso['promedio'] }}
                                    </span>
                                </td>
                                <td style="color: var(--success); font-weight: 600;" data-value="{{ $curso['aprobados'] }}">{{ $curso['aprobados'] }}</td>
                                <td style="color: var(--danger); font-weight: 600;" data-value="{{ $curso['reprobados'] }}">{{ $curso['reprobados'] }}</td>
                                <td data-value="{{ $curso['porcentaje_aprobacion'] }}">
                                    <div style="display: flex; align-items: center; gap: var(--spacing-sm);">
                                        <div
                                            style="flex: 1; height: 8px; background: var(--gray-200); border-radius: var(--radius-full); overflow: hidden;">
                                            <div
                                                style="height: 100%; background: {{ $curso['porcentaje_aprobacion'] >= 70 ? 'var(--success)' : ($curso['porcentaje_aprobacion'] >= 50 ? 'var(--warning)' : 'var(--danger)') }}; width: {{ $curso['porcentaje_aprobacion'] }}%;">
                                            </div>
                                        </div>
                                        <span
                                            style="font-weight: 600; min-width: 45px;">{{ $curso['porcentaje_aprobacion'] }}%</span>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('courses.show', $curso['id']) }}" class="btn btn-sm btn-outline"
                                        style="color: var(--gray-600); border-color: var(--gray-300);"
                                        onmouseover="this.style.background='var(--gray-50)'; this.style.color='var(--gray-900)'"
                                        onmouseout="this.style.background='transparent'; this.style.color='var(--gray-600)'">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9"
                                    style="text-align: center; padding: var(--spacing-2xl); color: var(--gray-500);">
                                    <i class="fas fa-inbox"
                                        style="font-size: 3rem; margin-bottom: var(--spacing-md); opacity: 0.5;"></i>
                                    <p>No hay cursos registrados</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
    <!-- END TAB 3 -->

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <script>
        // Chart.js - Bar Chart for Course Averages
        const ctxPromedios = document.getElementById('chartPromedios').getContext('2d');
        const chartPromedios = new Chart(ctxPromedios, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartCursos) !!},
                datasets: [{
                    label: 'Promedio',
                    data: {!! json_encode($chartPromedios) !!},
                    backgroundColor: 'rgba(132, 204, 22, 0.8)',
                    borderColor: '#84cc16',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 7.0,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Promedio: ' + context.parsed.y.toFixed(1);
                            }
                        }
                    }
                }
            }
        });

        // Chart.js - Doughnut Chart for Pass/Fail Distribution
        const ctxDistribucion = document.getElementById('chartDistribucion').getContext('2d');
        const chartDistribucion = new Chart(ctxDistribucion, {
            type: 'doughnut',
            data: {
                labels: ['Aprobados', 'Reprobados'],
                datasets: [{
                    data: [{{ $aprobados }}, {{ $reprobados }}],
                    backgroundColor: [
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(239, 68, 68, 0.8)'
                    ],
                    borderColor: [
                        'rgba(16, 185, 129, 1)',
                        'rgba(239, 68, 68, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed || 0;
                                const total = {{ $totalNotas }};
                                const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                return label + ': ' + value + ' (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });

        // Sortable Table Functionality
        let sortDirection = {};
        const table = document.getElementById('cursosTable');
        const headers = table.querySelectorAll('th.sortable');

        headers.forEach(header => {
            header.addEventListener('click', function() {
                const column = this.getAttribute('data-column');
                const tbody = table.querySelector('tbody');
                const rows = Array.from(tbody.querySelectorAll('tr')).filter(row => !row.querySelector('td[colspan]'));

                // Toggle sort direction
                if (!sortDirection[column]) {
                    sortDirection[column] = 'asc';
                } else {
                    sortDirection[column] = sortDirection[column] === 'asc' ? 'desc' : 'asc';
                }

                // Sort rows
                rows.sort((a, b) => {
                    const aValue = a.querySelector(`td[data-value]`)?.getAttribute('data-value') || '';
                    const bValue = b.querySelector(`td[data-value]`)?.getAttribute('data-value') || '';
                    
                    // Find the correct cell index
                    const columnIndex = Array.from(header.parentElement.children).indexOf(header);
                    const aCellValue = a.children[columnIndex]?.getAttribute('data-value') || '';
                    const bCellValue = b.children[columnIndex]?.getAttribute('data-value') || '';

                    let comparison = 0;
                    
                    // Try to parse as number
                    const aNum = parseFloat(aCellValue);
                    const bNum = parseFloat(bCellValue);
                    
                    if (!isNaN(aNum) && !isNaN(bNum)) {
                        comparison = aNum - bNum;
                    } else {
                        comparison = aCellValue.localeCompare(bCellValue);
                    }

                    return sortDirection[column] === 'asc' ? comparison : -comparison;
                });

                // Clear tbody and append sorted rows
                tbody.innerHTML = '';
                rows.forEach(row => tbody.appendChild(row));

                // Update sort icons
                headers.forEach(h => {
                    const icon = h.querySelector('.sort-icon');
                    if (h === header) {
                        icon.className = sortDirection[column] === 'asc' ? 'fas fa-sort-up sort-icon' : 'fas fa-sort-down sort-icon';
                    } else {
                        icon.className = 'fas fa-sort sort-icon';
                    }
                });

                // Save sort preference
                localStorage.setItem('tableSort', JSON.stringify({column, direction: sortDirection[column]}));
            });
        });

        // Load saved sort preference
        const savedSort = localStorage.getItem('tableSort');
        if (savedSort) {
            const {column, direction} = JSON.parse(savedSort);
            const header = table.querySelector(`th[data-column="${column}"]`);
            if (header) {
                sortDirection[column] = direction === 'asc' ? 'desc' : 'asc'; // Toggle will flip it back
                header.click();
            }
        }

        // --- System Tabs Logic ---
        function switchSystemTab(tabId) {
            // Update Tab Active State
            document.querySelectorAll('.system-tab').forEach(tab => {
                tab.classList.remove('active-tab');
            });
            document.getElementById('tab-' + tabId).classList.add('active-tab');

            // Show Relevant Section
            document.querySelectorAll('.system-tab-section').forEach(section => {
                section.style.display = 'none';
                section.classList.remove('active-section'); // Force hide logic
            });
            
            const targetSection = document.getElementById('section-' + tabId);
            if (targetSection) {
                targetSection.style.display = 'block';
                targetSection.classList.add('active-section');
            }
        }
    </script>
</x-app-layout>
