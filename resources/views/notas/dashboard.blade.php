<x-app-layout>
    <x-slot name="header">
        Dashboard de Notas
    </x-slot>

    <!-- Hero Header -->
    <div
        style="background: linear-gradient(135deg, var(--theme-color) 0%, var(--theme-dark) 100%); color: white; padding: var(--spacing-2xl); border-radius: var(--radius-xl); margin-bottom: var(--spacing-2xl); box-shadow: var(--shadow-lg);">
        <div
            style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: var(--spacing-lg);">
            <div>
                <h2 style="color: white; font-size: 1.875rem; font-weight: 700; margin-bottom: var(--spacing-sm);">
                    <i class="fas fa-chart-bar"></i> Dashboard de Notas
                </h2>
                <p style="font-size: 1rem; opacity: 0.95; margin: 0;">
                    Gestión integral de calificaciones y estadísticas académicas
                </p>
            </div>
            <div style="display: flex; gap: var(--spacing-md);">
                <a href="{{ route('grades.index') }}" class="btn btn-outline"
                    style="background: rgba(255,255,255,0.2); border-color: white; color: white;">
                    <i class="fas fa-list"></i> Ver Todas las Notas
                </a>
                <a href="{{ route('grades.create') }}" class="btn"
                    style="background: white; color: var(--theme-color);">
                    <i class="fas fa-plus"></i> Ingresar Notas
                </a>
            </div>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="card mb-xl">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-filter"></i> Filtros
            </h3>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('grades.dashboard') }}" id="filterForm"
                style="display: flex; gap: var(--spacing-lg); align-items: flex-end; flex-wrap: wrap;">
                <div class="form-group" style="flex: 1; min-width: 200px; margin-bottom: 0;">
                    <label class="form-label">Período Académico</label>
                    <select name="periodo" class="form-select"
                        onchange="document.getElementById('filterForm').submit()">
                        <option value="">Todos los períodos</option>
                        @foreach($periodos as $periodo)
                            <option value="{{ $periodo }}" {{ $filtroPeriodo === $periodo ? 'selected' : '' }}>
                                {{ $periodo }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group" style="flex: 1; min-width: 200px; margin-bottom: 0;">
                    <label class="form-label">Nivel Educativo</label>
                    <select name="nivel" class="form-select" onchange="document.getElementById('filterForm').submit()">
                        <option value="">Todos los niveles</option>
                        @foreach($niveles as $key => $label)
                            <option value="{{ $key }}" {{ $filtroNivel === $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div style="display: flex; gap: var(--spacing-sm);">
                    @if($filtroPeriodo || $filtroNivel)
                        <a href="{{ route('grades.dashboard') }}" class="btn btn-outline">
                            <i class="fas fa-times"></i> Limpiar Filtros
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-2 mb-xl">
        <!-- Bar Chart - Course Averages -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-bar"></i> Promedios por Curso (Top 10)
                </h3>
            </div>
            <div class="card-body">
                <canvas id="chartPromedios" style="max-height: 300px;"></canvas>
            </div>
        </div>

        <!-- Doughnut Chart - Pass/Fail Distribution -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-pie"></i> Distribución de Notas
                </h3>
            </div>
            <div class="card-body">
                <canvas id="chartDistribucion" style="max-height: 300px;"></canvas>
            </div>
        </div>
    </div>

    <!-- General Statistics -->
    <div class="grid grid-cols-4 mb-xl">
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ $totalEstudiantes }}</div>
                <div class="stat-label">Total Estudiantes</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                <i class="fas fa-file-alt"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ $totalNotas }}</div>
                <div class="stat-label">Notas Registradas</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ $promedioGeneral }}</div>
                <div class="stat-label">Promedio General</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
                <i class="fas fa-percentage"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ $porcentajeAprobacion }}%</div>
                <div class="stat-label">Aprobación</div>
            </div>
        </div>
    </div>

    <!-- Statistics by Education Level -->
    <div class="grid grid-cols-2 mb-xl">
        <!-- Básica Statistics -->
        <div class="card">
            <div class="card-header"
                style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white;">
                <h3 class="card-title" style="color: white; margin: 0;">
                    <i class="fas fa-school"></i> Educación Básica
                </h3>
            </div>
            <div class="card-body">
                <div class="grid grid-cols-2 mb-lg">
                    <div style="text-align: center; padding: var(--spacing-lg);">
                        <div
                            style="font-size: 2.5rem; font-weight: 700; color: var(--success); margin-bottom: var(--spacing-sm);">
                            {{ $estadisticasBasica['porcentaje_aprobacion'] }}%
                        </div>
                        <div style="color: var(--gray-600); font-size: 0.875rem; font-weight: 500;">Aprobación</div>
                    </div>
                    <div style="text-align: center; padding: var(--spacing-lg);">
                        <div
                            style="font-size: 2.5rem; font-weight: 700; color: var(--theme-color); margin-bottom: var(--spacing-sm);">
                            {{ $estadisticasBasica['promedio'] }}
                        </div>
                        <div style="color: var(--gray-600); font-size: 0.875rem; font-weight: 500;">Promedio</div>
                    </div>
                </div>
                <div
                    style="display: flex; justify-content: space-around; padding-top: var(--spacing-lg); border-top: 1px solid var(--gray-200);">
                    <div style="text-align: center;">
                        <div style="font-size: 1.5rem; font-weight: 600; color: var(--success);">
                            {{ $estadisticasBasica['aprobados'] }}
                        </div>
                        <div style="color: var(--gray-600); font-size: 0.75rem;">Aprobados</div>
                    </div>
                    <div style="text-align: center;">
                        <div style="font-size: 1.5rem; font-weight: 600; color: var(--danger);">
                            {{ $estadisticasBasica['reprobados'] }}
                        </div>
                        <div style="color: var(--gray-600); font-size: 0.75rem;">Reprobados</div>
                    </div>
                    <div style="text-align: center;">
                        <div style="font-size: 1.5rem; font-weight: 600; color: var(--gray-700);">
                            {{ $estadisticasBasica['total'] }}
                        </div>
                        <div style="color: var(--gray-600); font-size: 0.75rem;">Total</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Media Statistics -->
        <div class="card">
            <div class="card-header"
                style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); color: white;">
                <h3 class="card-title" style="color: white; margin: 0;">
                    <i class="fas fa-graduation-cap"></i> Educación Media
                </h3>
            </div>
            <div class="card-body">
                <div class="grid grid-cols-2 mb-lg">
                    <div style="text-align: center; padding: var(--spacing-lg);">
                        <div
                            style="font-size: 2.5rem; font-weight: 700; color: var(--success); margin-bottom: var(--spacing-sm);">
                            {{ $estadisticasMedia['porcentaje_aprobacion'] }}%
                        </div>
                        <div style="color: var(--gray-600); font-size: 0.875rem; font-weight: 500;">Aprobación</div>
                    </div>
                    <div style="text-align: center; padding: var(--spacing-lg);">
                        <div
                            style="font-size: 2.5rem; font-weight: 700; color: var(--theme-color); margin-bottom: var(--spacing-sm);">
                            {{ $estadisticasMedia['promedio'] }}
                        </div>
                        <div style="color: var(--gray-600); font-size: 0.875rem; font-weight: 500;">Promedio</div>
                    </div>
                </div>
                <div
                    style="display: flex; justify-content: space-around; padding-top: var(--spacing-lg); border-top: 1px solid var(--gray-200);">
                    <div style="text-align: center;">
                        <div style="font-size: 1.5rem; font-weight: 600; color: var(--success);">
                            {{ $estadisticasMedia['aprobados'] }}
                        </div>
                        <div style="color: var(--gray-600); font-size: 0.75rem;">Aprobados</div>
                    </div>
                    <div style="text-align: center;">
                        <div style="font-size: 1.5rem; font-weight: 600; color: var(--danger);">
                            {{ $estadisticasMedia['reprobados'] }}
                        </div>
                        <div style="color: var(--gray-600); font-size: 0.75rem;">Reprobados</div>
                    </div>
                    <div style="text-align: center;">
                        <div style="font-size: 1.5rem; font-weight: 600; color: var(--gray-700);">
                            {{ $estadisticasMedia['total'] }}
                        </div>
                        <div style="color: var(--gray-600); font-size: 0.75rem;">Total</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Export Section -->
    <div class="card mb-xl">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-download"></i> Exportar Reportes por Curso
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
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-table"></i> Resumen por Curso
            </h3>
        </div>
        <div class="card-body" style="padding: 0;">
            <div class="table-container">
                <table class="table" id="cursosTable">
                    <thead>
                        <tr>
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
                            <tr>
                                <td style="font-weight: 600;" data-value="{{ $curso['nombre'] }}">{{ $curso['nombre'] }}</td>
                                <td data-value="{{ $curso['nivel'] }}">
                                    <span class="badge"
                                        style="background: {{ $curso['nivel'] === 'basica' ? '#3b82f6' : '#8b5cf6' }};">
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
                                    <a href="{{ route('courses.show', $curso['id']) }}" class="btn btn-sm btn-outline">
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
                    backgroundColor: 'rgba(124, 58, 237, 0.8)',
                    borderColor: 'rgba(124, 58, 237, 1)',
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
    </script>
</x-app-layout>
