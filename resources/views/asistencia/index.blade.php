<x-app-layout>
    <x-slot name="header">
        Control de Asistencia
    </x-slot>

    @if(session('success'))
        <div id="successMessage" class="alert alert-success"
            style="background: #10b981; color: white; padding: var(--spacing-md); border-radius: var(--radius-md); margin-bottom: var(--spacing-lg);">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
        <script>
            setTimeout(() => {
                const msg = document.getElementById('successMessage');
                if (msg) {
                    msg.style.opacity = '0';
                    setTimeout(() => msg.style.display = 'none', 500);
                }
            }, 3000);
        </script>
    @endif

    <link rel="stylesheet" href="{{ asset('css/shared-index.css') }}?v={{ time() }}">

    <div class="page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-lg);">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--gray-900); margin: 0;">
                Control de Asistencia
            </h2>
            <p style="color: var(--gray-500); margin: var(--spacing-xs) 0 0 0; font-size: 0.9375rem;">
                Gestiona y monitorea la asistencia de los estudiantes
            </p>
        </div>
        <div class="header-actions" style="display: flex; gap: var(--spacing-md);">
            <a href="{{ route('attendance.dashboard') }}" class="btn btn-outline"
                style="display: flex; align-items: center; justify-content: center; gap: var(--spacing-sm); border: 1px solid var(--gray-300); color: var(--gray-700); background: transparent; padding: 0.625rem 1.25rem; border-radius: var(--radius-md); font-weight: 600; text-decoration: none; transition: all 0.2s;"
                onmouseover="this.style.background='var(--gray-50)'; this.style.color='var(--gray-900)'"
                onmouseout="this.style.background='transparent'; this.style.color='var(--gray-700)'">
                <i class="fas fa-chart-area"></i>
                <span class="btn-text">Dashboard</span>
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

    <div class="grid grid-cols-5 mb-xl">
        <div class="stat-card">
            <div class="stat-value">{{ $stats['total'] }}</div>
            <div class="stat-label">Total Registros</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $stats['presente'] }}</div>
            <div class="stat-label">Presentes</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $stats['ausente'] }}</div>
            <div class="stat-label">Ausentes</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $stats['tarde'] }}</div>
            <div class="stat-label">Tardanzas</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $stats['porcentaje_asistencia'] }}%</div>
            <div class="stat-label">% Asistencia</div>
        </div>
    </div>

    <div class="mobile-filter-button" style="display: none; margin-bottom: var(--spacing-md);">
        <button type="button" onclick="openFilterModal()" 
            style="width: 100%; height: 48px; border-radius: var(--radius-lg); background: transparent; border: 1px solid var(--gray-300); position: relative; display: flex; align-items: center; justify-content: center; gap: var(--spacing-sm); color: var(--gray-700); font-weight: 600; cursor: pointer;">
            <i class="fas fa-search"></i>
            <span>Buscar y Filtrar</span>
            <span id="activeFiltersBadge" class="filter-badge" style="display: none; background: #84cc16;">0</span>
        </button>
    </div>

    <div id="filterModal" class="filters-modal" onclick="if(event.target === this) closeFilterModal()">
        <div class="filters-modal-content">
            <div class="filters-modal-header" style="position: sticky; top: 0; background: white; z-index: 10; border-bottom: 1px solid var(--gray-200); padding: var(--spacing-lg);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-md); width: 100%;">
                    <h3 style="margin: 0; font-size: 1.125rem; font-weight: 600; color: var(--gray-900);">
                        <i class="fas fa-search" style="color: var(--gray-400); margin-right: var(--spacing-sm);"></i>
                        Buscar y Filtrar
                    </h3>
                    <button type="button" onclick="closeFilterModal()" class="filters-modal-close" 
                        style="width: 32px; height: 32px; border-radius: 50%; background: transparent; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: background 0.2s;"
                        onmouseover="this.style.background='var(--gray-100)'"
                        onmouseout="this.style.background='transparent'">
                        <i class="fas fa-times" style="color: var(--gray-600);"></i>
                    </button>
                </div>
            </div>
            
            <div class="filters-modal-body" style="padding: var(--spacing-lg);">
                <div class="form-group">
                    <label class="form-label" style="font-size: 0.875rem; font-weight: 600; color: var(--gray-700); margin-bottom: var(--spacing-xs); display: flex; align-items: center; gap: var(--spacing-xs);">
                        <i class="fas fa-search" style="color: var(--gray-400);"></i>
                        Buscar
                    </label>
                    <input type="text" id="searchInputMobile" class="form-input" 
                        placeholder="Buscar estudiante..." 
                        style="border: 2px solid var(--gray-200); border-radius: var(--radius-lg); font-size: 0.9375rem;"
                        onfocus="this.style.borderColor='#84cc16'" onblur="this.style.borderColor='var(--gray-200)'">
                </div>
                
                <div class="form-group">
                    <label class="form-label" style="font-size: 0.875rem; font-weight: 600; color: var(--gray-700); margin-bottom: var(--spacing-xs); display: flex; align-items: center; gap: var(--spacing-xs);">
                        <i class="fas fa-graduation-cap" style="color: var(--gray-400);"></i>
                        Curso
                    </label>
                    <select id="cursoFilterMobile" class="form-select" 
                        style="border: 2px solid var(--gray-200); border-radius: var(--radius-lg); font-size: 0.9375rem;"
                        onfocus="this.style.borderColor='#84cc16'" onblur="this.style.borderColor='var(--gray-200)'">
                        <option value="">Todos los cursos</option>
                        @foreach($cursos as $curso)
                            <option value="{{ $curso->id }}">{{ $curso->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" style="font-size: 0.875rem; font-weight: 600; color: var(--gray-700); margin-bottom: var(--spacing-xs); display: flex; align-items: center; gap: var(--spacing-xs);">
                        <i class="fas fa-book" style="color: var(--gray-400);"></i>
                        Asignatura
                    </label>
                    <select id="asignaturaFilterMobile" class="form-select" 
                        style="border: 2px solid var(--gray-200); border-radius: var(--radius-lg); font-size: 0.9375rem;"
                        onfocus="this.style.borderColor='#84cc16'" onblur="this.style.borderColor='var(--gray-200)'">
                        <option value="">Todas las asignaturas</option>
                        @foreach($asignaturas as $asignatura)
                            <option value="{{ $asignatura->id }}">{{ $asignatura->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" style="font-size: 0.875rem; font-weight: 600; color: var(--gray-700); margin-bottom: var(--spacing-xs); display: flex; align-items: center; gap: var(--spacing-xs);">
                        <i class="fas fa-calendar" style="color: var(--gray-400);"></i>
                        Fecha
                    </label>
                    <input type="date" id="fechaFilterMobile" class="form-control"
                        style="border: 2px solid var(--gray-200); border-radius: var(--radius-lg); font-size: 0.9375rem;"
                        onfocus="this.style.borderColor='#84cc16'" onblur="this.style.borderColor='var(--gray-200)'">
                </div>

                <div class="form-group mb-0">
                    <label class="form-label" style="font-size: 0.875rem; font-weight: 600; color: var(--gray-700); margin-bottom: var(--spacing-xs); display: flex; align-items: center; gap: var(--spacing-xs);">
                        <i class="fas fa-check-circle" style="color: var(--gray-400);"></i>
                        Estado
                    </label>
                    <select id="estadoFilterMobile" class="form-select" 
                        style="border: 2px solid var(--gray-200); border-radius: var(--radius-lg); font-size: 0.9375rem;"
                        onfocus="this.style.borderColor='#84cc16'" onblur="this.style.borderColor='var(--gray-200)'">
                        <option value="">Todos</option>
                        <option value="presente">Presente</option>
                        <option value="ausente">Ausente</option>
                        <option value="tarde">Tarde</option>
                        <option value="justificado">Justificado</option>
                    </select>
                </div>
            </div>
            
            <div class="filters-modal-footer" style="position: sticky; bottom: 0; background: white; padding: var(--spacing-lg); border-top: 1px solid var(--gray-200); display: flex; gap: var(--spacing-sm);">
                <button type="button" onclick="clearFilters()" class="btn btn-outline" style="flex: 1; height: 44px; border-radius: var(--radius-lg); font-weight: 600; background: transparent; border: 1px solid var(--gray-300); color: var(--gray-700);">
                    Limpiar
                </button>
                <button type="button" onclick="applyFilters()" style="flex: 1; color: white; height: 44px; border-radius: var(--radius-lg); font-weight: 600; background: #84cc16; border: none;">
                    Aplicar
                </button>
            </div>
        </div>
    </div>

    <div class="filters-card mb-xl">
        <div class="grid grid-cols-5" style="gap: var(--spacing-md); align-items: center;">
                <div class="form-group mb-0" style="position: relative;">
                    <div style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--gray-400); font-size: 1.125rem;">
                        <i class="fas fa-search"></i>
                    </div>
                    <input type="text" id="searchInput" class="form-input" 
                        placeholder="Buscar estudiante..." 
                        style="padding-left: 40px; border: 2px solid var(--gray-200); border-radius: var(--radius-lg); transition: all 0.2s; font-size: 0.9375rem;"
                        onfocus="this.style.borderColor='#84cc16'; this.style.boxShadow='0 0 0 3px rgba(132, 204, 22, 0.1)'"
                        onblur="this.style.borderColor='var(--gray-200)'; this.style.boxShadow='none'">
                </div>
                
                <div class="form-group mb-0" style="position: relative;">
                    <div style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--gray-400); font-size: 1rem; pointer-events: none; z-index: 1;">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <select id="cursoFilter" class="form-select" 
                        style="padding-left: 40px; border: 2px solid var(--gray-200); border-radius: var(--radius-lg); transition: all 0.2s; font-size: 0.9375rem; cursor: pointer;"
                        onfocus="this.style.borderColor='#84cc16'; this.style.boxShadow='0 0 0 3px rgba(132, 204, 22, 0.1)'"
                        onblur="this.style.borderColor='var(--gray-200)'; this.style.boxShadow='none'">
                        <option value="">Todos los cursos</option>
                        @foreach($cursos as $curso)
                            <option value="{{ $curso->id }}">{{ $curso->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group mb-0" style="position: relative;">
                    <div style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--gray-400); font-size: 1rem; pointer-events: none; z-index: 1;">
                        <i class="fas fa-book"></i>
                    </div>
                    <select id="asignaturaFilter" class="form-select" 
                        style="padding-left: 40px; border: 2px solid var(--gray-200); border-radius: var(--radius-lg); transition: all 0.2s; font-size: 0.9375rem; cursor: pointer;"
                        onfocus="this.style.borderColor='#84cc16'; this.style.boxShadow='0 0 0 3px rgba(132, 204, 22, 0.1)'"
                        onblur="this.style.borderColor='var(--gray-200)'; this.style.boxShadow='none'">
                        <option value="">Todas las asignaturas</option>
                        @foreach($asignaturas as $asignatura)
                            <option value="{{ $asignatura->id }}">{{ $asignatura->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group mb-0" style="position: relative;">
                    <div style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--gray-400); font-size: 1rem; pointer-events: none; z-index: 1;">
                        <i class="fas fa-calendar"></i>
                    </div>
                    <input type="date" id="fechaFilter" class="form-input" 
                        style="padding-left: 40px; border: 2px solid var(--gray-200); border-radius: var(--radius-lg); transition: all 0.2s; font-size: 0.9375rem;"
                        onfocus="this.style.borderColor='#84cc16'; this.style.boxShadow='0 0 0 3px rgba(132, 204, 22, 0.1)'"
                        onblur="this.style.borderColor='var(--gray-200)'; this.style.boxShadow='none'">
                </div>
                
                <div class="form-group mb-0" style="position: relative;">
                    <div style="display: flex; gap: var(--spacing-xs); align-items: center;">
                        <div style="position: relative; flex: 1;">
                            <div style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--gray-400); font-size: 1rem; pointer-events: none; z-index: 1;">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <select id="estadoFilter" class="form-select" 
                                style="padding-left: 40px; border: 2px solid var(--gray-200); border-radius: var(--radius-lg); transition: all 0.2s; font-size: 0.9375rem; cursor: pointer;"
                                onfocus="this.style.borderColor='#84cc16'; this.style.boxShadow='0 0 0 3px rgba(132, 204, 22, 0.1)'"
                                onblur="this.style.borderColor='var(--gray-200)'; this.style.boxShadow='none'">
                                <option value="">Todos</option>
                                <option value="presente">Presente</option>
                                <option value="ausente">Ausente</option>
                                <option value="tarde">Tarde</option>
                                <option value="justificado">Justificado</option>
                            </select>
                        </div>
                        <button type="button" id="clearFiltersBtn" onclick="clearFilters()" 
                            style="display: none; width: 42px; height: 42px; border-radius: var(--radius-lg); background: var(--gray-100); border: 1px solid var(--gray-300); color: var(--gray-600); cursor: pointer; transition: all 0.2s; flex-shrink: 0;"
                            onmouseover="this.style.background='var(--gray-200)'; this.style.borderColor='var(--gray-400)'"
                            onmouseout="this.style.background='var(--gray-100)'; this.style.borderColor='var(--gray-300)'"
                            title="Limpiar filtros">
                            <i class="fas fa-times" style="font-size: 1.125rem;"></i>
                        </button>
                    </div>
                </div>
            </div>
    </div>

    <div id="noResults" class="card mb-xl" style="display: none;">
        <div class="card-body text-center" style="padding: var(--spacing-2xl);">
            <i class="fas fa-search" style="font-size: 3rem; color: var(--gray-300); margin-bottom: var(--spacing-md);"></i>
            <p style="color: var(--gray-600); margin: 0;">No se encontraron registros que coincidan con tu búsqueda</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Registros de Asistencia</h3>
        </div>
        <div class="card-body">
            @if($asistencias->count() > 0)
                <div class="mobile-attendance-table" style="display: none;">
                    <div class="mobile-table-container" style="background: white; border-radius: var(--radius-lg); overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                        @foreach($asistencias as $asistencia)
                            <div class="asistencia-item mobile-table-row" 
                                style="border-bottom: 1px solid var(--gray-200); padding: var(--spacing-sm) var(--spacing-md); transition: background 0.2s;"
                                data-search="{{ strtolower($asistencia->estudiante->nombre . ' ' . $asistencia->estudiante->apellido . ' ' . $asistencia->curso->nombre . ' ' . $asistencia->asignatura->nombre) }}"
                                data-curso-id="{{ $asistencia->curso_id }}"
                                data-asignatura-id="{{ $asistencia->asignatura_id }}"
                                data-fecha="{{ $asistencia->fecha->format('Y-m-d') }}"
                                data-estado="{{ $asistencia->estado }}"
                                onmouseover="this.style.background='var(--gray-50)'"
                                onmouseout="this.style.background='white'">
                                
                                <div style="display: flex; align-items: center; gap: var(--spacing-sm);">
                                    <div style="width: 36px; height: 36px; border-radius: 50%; background: #84cc16; display: flex; align-items: center; justify-content: center; color: white; flex-shrink: 0;">
                                        <i class="fas fa-calendar-check" style="font-size: 0.875rem;"></i>
                                    </div>
                                    
                                    <div style="flex: 1; min-width: 0;">
                                        <div style="display: flex; align-items: center; gap: var(--spacing-xs); margin-bottom: 2px;">
                                            <span style="font-weight: 700; color: var(--gray-900); font-size: 0.9375rem; line-height: 1.3;">{{ $asistencia->estudiante->nombre }} {{ $asistencia->estudiante->apellido }}</span>
                                            <span class="badge badge-{{ $asistencia->estado_color }}" style="font-size: 0.625rem; padding: 2px 6px;">{{ $asistencia->estado_label }}</span>
                                        </div>
                                        <div style="font-size: 0.75rem; color: var(--gray-600);">
                                            <i class="fas fa-calendar" style="font-size: 0.625rem;"></i> {{ $asistencia->fecha->format('d/m/Y') }}
                                            <span style="margin: 0 var(--spacing-xs);">•</span>
                                            <i class="fas fa-graduation-cap" style="font-size: 0.625rem;"></i> {{ $asistencia->curso->nombre }}
                                        </div>
                                    </div>
                                    
                                    <div style="flex-shrink: 0;" onclick="event.stopPropagation();">
                                        <form action="{{ route('attendance.destroy', $asistencia) }}" method="POST" style="margin: 0;" onsubmit="return confirm('¿Eliminar este registro?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                style="width: 32px; height: 32px; border-radius: var(--radius-md); background: transparent; color: var(--error); border: 1px solid var(--error); display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 0.75rem; transition: background 0.2s;"
                                                title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="attendance-table-container" style="overflow-x: auto;">
                    <table class="table">
                        <thead>
                            <tr class="table-header-row">
                                <th style="text-align: left;">Fecha</th>
                                <th style="text-align: left;">Curso</th>
                                <th style="text-align: left;">Asignatura</th>
                                <th style="text-align: left;">Estudiante</th>
                                <th style="text-align: left;">Estado</th>
                                <th style="text-align: left;">Notas</th>
                                <th style="text-align: left;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($asistencias as $asistencia)
                                <tr class="asistencia-item"
                                    data-search="{{ strtolower($asistencia->estudiante->nombre . ' ' . $asistencia->estudiante->apellido . ' ' . $asistencia->curso->nombre . ' ' . $asistencia->asignatura->nombre) }}"
                                    data-curso-id="{{ $asistencia->curso_id }}"
                                    data-asignatura-id="{{ $asistencia->asignatura_id }}"
                                    data-fecha="{{ $asistencia->fecha->format('Y-m-d') }}"
                                    data-estado="{{ $asistencia->estado }}">
                                    <td>{{ $asistencia->fecha->format('d/m/Y') }}</td>
                                    <td>{{ $asistencia->curso->nombre }}</td>
                                    <td>{{ $asistencia->asignatura->nombre }}</td>
                                    <td>{{ $asistencia->estudiante->nombre }} {{ $asistencia->estudiante->apellido }}</td>
                                    <td>
                                        <span class="badge badge-{{ $asistencia->estado_color }}">
                                            {{ $asistencia->estado_label }}
                                        </span>
                                    </td>
                                    <td>{{ $asistencia->notas ? Str::limit($asistencia->notas, 30) : '-' }}</td>
                                    <td>
                                        <div style="display: flex; gap: 4px;">
                                        <a href="{{ route('attendance.show', $asistencia) }}" 
                                            style="width: 32px; height: 32px; border-radius: var(--radius-md); background: transparent; color: var(--gray-600); border: 1px solid var(--gray-300); display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: 0.75rem; transition: background 0.2s;"
                                            onmouseover="this.style.background='var(--gray-100)';"
                                            onmouseout="this.style.background='transparent';"
                                            title="Ver detalle">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <form action="{{ route('attendance.destroy', $asistencia) }}" method="POST"
                                            style="display: inline;" onsubmit="return confirm('¿Eliminar este registro?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                style="width: 32px; height: 32px; border-radius: var(--radius-md); background: transparent; color: var(--error); border: 1px solid var(--error); display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 0.75rem; transition: background 0.2s;"
                                                title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div style="margin-top: var(--spacing-lg);">
                    {{ $asistencias->links() }}
                </div>
            @else
                <div
                    style="text-align: center; padding: var(--spacing-2xl); background: var(--gray-50); border-radius: var(--radius-md);">
                    <i class="fas fa-calendar-times"
                        style="font-size: 3rem; color: var(--gray-300); margin-bottom: var(--spacing-md);"></i>
                    <p style="color: var(--gray-600);">No hay registros de asistencia</p>
                    <a href="{{ route('attendance.create') }}" class="btn"
                        style="margin-top: var(--spacing-md); background: #10b981; color: white; border: none;">
                        <i class="fas fa-plus"></i> Tomar Asistencia
                    </a>
                </div>
            @endif
        </div>
    </div>

    <script>
        const searchInput = document.getElementById('searchInput');
        const searchInputMobile = document.getElementById('searchInputMobile');
        const cursoFilter = document.getElementById('cursoFilter');
        const asignaturaFilter = document.getElementById('asignaturaFilter');
        const fechaFilter = document.getElementById('fechaFilter');
        const estadoFilter = document.getElementById('estadoFilter');
        const cursoFilterMobile = document.getElementById('cursoFilterMobile');
        const asignaturaFilterMobile = document.getElementById('asignaturaFilterMobile');
        const fechaFilterMobile = document.getElementById('fechaFilterMobile');
        const estadoFilterMobile = document.getElementById('estadoFilterMobile');
        const noResults = document.getElementById('noResults');
        const activeFiltersBadge = document.getElementById('activeFiltersBadge');
        
        function filterAsistencias() {
            const searchTerm = (searchInput?.value || searchInputMobile?.value || '').toLowerCase();
            const selectedCurso = cursoFilter?.value || cursoFilterMobile?.value || '';
            const selectedAsignatura = asignaturaFilter?.value || asignaturaFilterMobile?.value || '';
            const selectedFecha = fechaFilter?.value || fechaFilterMobile?.value || '';
            const selectedEstado = estadoFilter?.value || estadoFilterMobile?.value || '';
            
            const items = document.querySelectorAll('.asistencia-item');
            let visibleCount = 0;
            
            items.forEach(item => {
                const searchText = item.dataset.search || '';
                const cursoId = item.dataset.cursoId || '';
                const asignaturaId = item.dataset.asignaturaId || '';
                const fecha = item.dataset.fecha || '';
                const estado = item.dataset.estado || '';
                
                const matchesSearch = searchText.includes(searchTerm);
                const matchesCurso = !selectedCurso || cursoId === selectedCurso;
                const matchesAsignatura = !selectedAsignatura || asignaturaId === selectedAsignatura;
                const matchesFecha = !selectedFecha || fecha === selectedFecha;
                const matchesEstado = !selectedEstado || estado === selectedEstado;
                
                if (matchesSearch && matchesCurso && matchesAsignatura && matchesFecha && matchesEstado) {
                    item.style.display = '';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });
            
            if (noResults) {
                noResults.style.display = visibleCount === 0 ? 'block' : 'none';
            }
            
            updateFilterBadge();
        }
        
        function updateFilterBadge() {
            const searchValue = searchInput?.value || searchInputMobile?.value || '';
            const cursoValue = cursoFilter?.value || cursoFilterMobile?.value || '';
            const asignaturaValue = asignaturaFilter?.value || asignaturaFilterMobile?.value || '';
            const fechaValue = fechaFilter?.value || fechaFilterMobile?.value || '';
            const estadoValue = estadoFilter?.value || estadoFilterMobile?.value || '';
            const activeFilters = (searchValue ? 1 : 0) + (cursoValue ? 1 : 0) + (asignaturaValue ? 1 : 0) + (fechaValue ? 1 : 0) + (estadoValue ? 1 : 0);
            
            if (activeFiltersBadge) {
                if (activeFilters > 0) {
                    activeFiltersBadge.textContent = activeFilters;
                    activeFiltersBadge.style.display = 'flex';
                } else {
                    activeFiltersBadge.style.display = 'none';
                }
            }
            
            const clearFiltersBtn = document.getElementById('clearFiltersBtn');
            if (clearFiltersBtn) {
                clearFiltersBtn.style.display = activeFilters > 0 ? 'block' : 'none';
            }
        }
        
        if (searchInput && searchInputMobile) {
            searchInput.addEventListener('input', () => {
                searchInputMobile.value = searchInput.value;
                filterAsistencias();
            });
            searchInputMobile.addEventListener('input', () => {
                searchInput.value = searchInputMobile.value;
                filterAsistencias();
            });
        }
        
        if (cursoFilter) cursoFilter.addEventListener('change', filterAsistencias);
        if (asignaturaFilter) asignaturaFilter.addEventListener('change', filterAsistencias);
        if (fechaFilter) fechaFilter.addEventListener('change', filterAsistencias);
        if (estadoFilter) estadoFilter.addEventListener('change', filterAsistencias);
        
        function openFilterModal() {
            const modal = document.getElementById('filterModal');
            if (modal) {
                modal.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
        }
        
        function closeFilterModal() {
            const modal = document.getElementById('filterModal');
            if (modal) {
                modal.classList.remove('active');
                document.body.style.overflow = '';
            }
        }
        
        function applyFilters() {
            if (cursoFilter && cursoFilterMobile) {
                cursoFilter.value = cursoFilterMobile.value;
            }
            if (asignaturaFilter && asignaturaFilterMobile) {
                asignaturaFilter.value = asignaturaFilterMobile.value;
            }
            if (fechaFilter && fechaFilterMobile) {
                fechaFilter.value = fechaFilterMobile.value;
            }
            if (estadoFilter && estadoFilterMobile) {
                estadoFilter.value = estadoFilterMobile.value;
            }
            
            filterAsistencias();
            closeFilterModal();
        }
        
        function clearFilters() {
            if (searchInputMobile) searchInputMobile.value = '';
            if (cursoFilterMobile) cursoFilterMobile.value = '';
            if (asignaturaFilterMobile) asignaturaFilterMobile.value = '';
            if (fechaFilterMobile) fechaFilterMobile.value = '';
            if (estadoFilterMobile) estadoFilterMobile.value = '';
            
            if (searchInput) searchInput.value = '';
            if (cursoFilter) cursoFilter.value = '';
            if (asignaturaFilter) asignaturaFilter.value = '';
            if (fechaFilter) fechaFilter.value = '';
            if (estadoFilter) estadoFilter.value = '';
            
            filterAsistencias();
            closeFilterModal();
        }
        
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeFilterModal();
            }
        });
        
        updateFilterBadge();
    </script>
</x-app-layout>