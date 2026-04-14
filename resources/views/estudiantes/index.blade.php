<x-app-layout>
    <x-slot name="header">
        Gestión de Estudiantes
    </x-slot>

    <link rel="stylesheet" href="{{ asset('css/shared-index.css') }}?v={{ time() }}">

    <!-- Page Header -->
    <div class="page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-lg);">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--gray-900); margin: 0;">
                Gestión de Estudiantes
            </h2>
            <p style="color: var(--gray-500); margin: var(--spacing-xs) 0 0 0; font-size: 0.9375rem;">
                Gestiona la información de todos tus estudiantes
            </p>
        </div>
        <div class="header-actions" style="display: flex; gap: var(--spacing-sm);">
            <button onclick="openImportModal()" class="btn btn-outline"
                style="display: flex; align-items: center; justify-content: center; gap: var(--spacing-sm); border: 1px solid var(--info); color: var(--info); background: transparent; padding: 0.625rem 1.25rem; border-radius: var(--radius-md); font-weight: 600; text-decoration: none; transition: all 0.2s;"
                onmouseover="this.style.background='rgba(59, 130, 246, 0.1)';"
                onmouseout="this.style.background='transparent';">
                <i class="fas fa-file-csv"></i>
                <span class="btn-text">Importar CSV</span>
            </button>
            <a href="{{ route('students.create') }}" class="btn btn-outline"
                style="display: flex; align-items: center; justify-content: center; gap: var(--spacing-sm); border: 1px solid var(--gray-300); color: var(--gray-700); background: transparent; padding: 0.625rem 1.25rem; border-radius: var(--radius-md); font-weight: 600; text-decoration: none; transition: all 0.2s;"
                onmouseover="this.style.background='var(--gray-50)'; this.style.color='var(--gray-900)'"
                onmouseout="this.style.background='transparent'; this.style.color='var(--gray-700)'">
                <i class="fas fa-plus"></i>
                <span class="btn-text">Nuevo Estudiante</span>
            </a>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="mb-xl filters-card">
        <div class="grid" style="grid-template-columns: 2fr 1fr 1fr; gap: var(--spacing-md); align-items: center;">
                <div class="form-group mb-0" style="position: relative;">
                    <div style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--gray-400); font-size: 1.125rem;">
                        <i class="fas fa-search"></i>
                    </div>
                    <input type="text" id="searchInput" class="form-input" 
                        placeholder="Buscar estudiantes..." 
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
                        @foreach($estudiantes->pluck('curso_actual')->filter()->unique('id') as $curso)
                            <option value="{{ $curso->id }}">{{ $curso->nombre }}</option>
                        @endforeach
                    </select>
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
                                <option value="">Todos los estados</option>
                                <option value="activo">Activo</option>
                                <option value="inactivo">Inactivo</option>
                                <option value="retirado">Retirado</option>
                            </select>
                        </div>
                        <!-- Clear Button (only visible when filters are active) -->
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

    <!-- Mobile: Standalone Filter Button -->
    <div class="mobile-filter-button" style="display: none; margin-bottom: var(--spacing-md);">
        <button onclick="openFiltersModal()" 
            style="width: 100%; height: 48px; border-radius: var(--radius-lg); background: transparent; border: 1px solid var(--gray-300); position: relative; display: flex; align-items: center; justify-content: center; gap: var(--spacing-sm); color: var(--gray-700); font-weight: 600; cursor: pointer;">
            <i class="fas fa-search"></i>
            <span>Buscar y Filtrar</span>
            <span id="filterBadgeMobile" class="filter-badge" style="display: none; background: #84cc16;">0</span>
        </button>
    </div>

    <!-- Filters Modal (Mobile only) -->
    <div id="filtersModal" class="filters-modal" onclick="closeFiltersModal()">
        <div class="filters-modal-content" onclick="event.stopPropagation()">
            <div class="filters-modal-header">
                <h3 style="margin: 0; font-size: 1.125rem; font-weight: 600; color: var(--gray-900);">
                    <i class="fas fa-search" style="color: var(--gray-400); margin-right: var(--spacing-sm);"></i>
                    Buscar y Filtrar
                </h3>
                <button onclick="closeFiltersModal()" class="filters-modal-close" aria-label="Cerrar">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="filters-modal-body">
                <div class="form-group">
                    <label class="form-label" style="font-size: 0.875rem; font-weight: 600; color: var(--gray-700); margin-bottom: var(--spacing-xs); display: flex; align-items: center; gap: var(--spacing-xs);">
                        <i class="fas fa-search" style="color: var(--gray-400);"></i> Buscar
                    </label>
                    <input type="text" id="searchInputMobile" class="form-input" 
                        placeholder="Buscar estudiantes..." 
                        style="border: 2px solid var(--gray-200); border-radius: var(--radius-lg); font-size: 0.9375rem;"
                        onfocus="this.style.borderColor='#84cc16'" onblur="this.style.borderColor='var(--gray-200)'">
                </div>
                <div class="form-group">
                    <label class="form-label" style="font-size: 0.875rem; font-weight: 600; color: var(--gray-700); margin-bottom: var(--spacing-xs); display: flex; align-items: center; gap: var(--spacing-xs);">
                        <i class="fas fa-graduation-cap" style="color: var(--gray-400);"></i> Curso
                    </label>
                    <select id="cursoFilterMobile" class="form-select" 
                        style="border: 2px solid var(--gray-200); border-radius: var(--radius-lg); font-size: 0.9375rem;"
                        onfocus="this.style.borderColor='#84cc16'" onblur="this.style.borderColor='var(--gray-200)'">
                        <option value="">Todos los cursos</option>
                        @foreach($estudiantes->pluck('curso_actual')->filter()->unique('id') as $curso)
                            <option value="{{ $curso->id }}">{{ $curso->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-0">
                    <label class="form-label" style="font-size: 0.875rem; font-weight: 600; color: var(--gray-700); margin-bottom: var(--spacing-xs); display: flex; align-items: center; gap: var(--spacing-xs);">
                        <i class="fas fa-check-circle" style="color: var(--gray-400);"></i> Estado
                    </label>
                    <select id="estadoFilterMobile" class="form-select" 
                        style="border: 2px solid var(--gray-200); border-radius: var(--radius-lg); font-size: 0.9375rem;"
                        onfocus="this.style.borderColor='#84cc16'" onblur="this.style.borderColor='var(--gray-200)'">
                        <option value="">Todos los estados</option>
                        <option value="activo">Activo</option>
                        <option value="inactivo">Inactivo</option>
                        <option value="retirado">Retirado</option>
                    </select>
                </div>
            </div>
            <div class="filters-modal-footer">
                <button onclick="clearFilters()" class="btn btn-outline" style="flex: 1; border: 1px solid var(--gray-300); background: transparent; color: var(--gray-700);">Limpiar</button>
                <button onclick="applyFilters()" style="flex: 1; background: #84cc16; color: white; border: none; border-radius: var(--radius-md); font-weight: 600; padding: 0.625rem;">Aplicar</button>
            </div>
        </div>
    </div>

    <!-- Mobile Table View (hidden on desktop) -->
    <div class="mobile-table" style="display: none;">
        <div class="mobile-table-container" style="background: white; border-radius: var(--radius-lg); overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            @forelse($estudiantes as $estudiante)
                <div class="estudiante-item mobile-table-row" 
                    style="border-bottom: 1px solid var(--gray-200); padding: var(--spacing-sm) var(--spacing-md); cursor: pointer; transition: background 0.2s;"
                    onclick="window.location='{{ route('students.show', $estudiante->id) }}'" 
                    data-search="{{ strtolower($estudiante->nombre . ' ' . $estudiante->apellido . ' ' . $estudiante->rut) }}"
                    data-curso="{{ $estudiante->curso_actual->id ?? '' }}"
                    data-estado="{{ $estudiante->estado }}">
                    
                    <div style="display: flex; align-items: center; gap: var(--spacing-sm);">
                        <div style="width: 36px; height: 36px; border-radius: 50%; background: #84cc16; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 0.75rem; flex-shrink: 0;">
                            {{ strtoupper(substr($estudiante->nombre, 0, 1) . substr($estudiante->apellido, 0, 1)) }}
                        </div>
                        
                        <div style="flex: 1; min-width: 0;">
                            <div style="font-weight: 700; color: var(--gray-900); font-size: 0.9375rem; line-height: 1.3;">{{ $estudiante->nombre_completo }}</div>
                            <div style="font-size: 0.75rem; color: var(--gray-600); margin-top: 2px;">
                                <i class="fas fa-graduation-cap" style="font-size: 0.625rem;"></i> 
                                @if($estudiante->curso_actual)
                                    {{ $estudiante->curso_actual->nombre }}
                                @else
                                    Sin curso
                                @endif
                            </div>
                        </div>
                        
                        <div style="display: flex; gap: 4px; flex-shrink: 0;" onclick="event.stopPropagation();">
                            <a href="{{ route('students.edit', $estudiante->id) }}" 
                                style="width: 32px; height: 32px; border-radius: var(--radius-md); background: transparent; color: var(--gray-600); border: 1px solid var(--gray-300); display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: 0.75rem; transition: background 0.2s;"
                                onmouseover="this.style.background='var(--gray-100)';"
                                onmouseout="this.style.background='transparent';"
                                title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('students.destroy', $estudiante->id) }}" method="POST" style="margin: 0;" onsubmit="return confirm('¿Está seguro de eliminar este estudiante?');">
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
            @empty
                <div style="padding: var(--spacing-xl); text-align: center; color: var(--gray-500);">
                    <i class="fas fa-users" style="font-size: 2rem; margin-bottom: var(--spacing-sm); opacity: 0.3;"></i>
                    <p style="margin: 0; font-size: 0.9375rem;">No hay estudiantes registrados</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Desktop Table View (hidden on mobile) -->
    <div class="table-container">
        <table class="table">
            <thead>
                <tr class="table-header-row">
                    <th style="text-align: left;">Estudiante</th>
                    <th style="text-align: left;">Email</th>
                    <th style="text-align: left;">Curso</th>
                    <th style="text-align: left;">Promedio</th>
                    <th style="text-align: left;">Asistencia</th>
                    <th style="text-align: left;">Estado</th>
                    <th style="text-align: left;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($estudiantes as $estudiante)
                    <tr class="estudiante-item" style="cursor: pointer;" onclick="window.location='{{ route('students.show', $estudiante->id) }}'" 
                        data-search="{{ strtolower($estudiante->nombre . ' ' . $estudiante->apellido . ' ' . $estudiante->rut) }}"
                        data-curso="{{ $estudiante->curso_actual->id ?? '' }}"
                        data-estado="{{ $estudiante->estado }}">
                        <td>
                            <div style="display: flex; align-items: center; gap: var(--spacing-md);">
                                <div
                                    style="width: 40px; height: 40px; border-radius: 50%; background: #84cc16; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700;">
                                    {{ strtoupper(substr($estudiante->nombre, 0, 1) . substr($estudiante->apellido, 0, 1)) }}
                                </div>
                                <div>
                                    <div style="font-weight: 600; color: var(--gray-900);">
                                        {{ $estudiante->nombre_completo }}</div>
                                    <div style="font-size: 0.875rem; color: var(--gray-500);">{{ $estudiante->rut }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="color: var(--gray-600);">{{ $estudiante->email ?? 'Sin email' }}</td>
                        <td>
                            @if($estudiante->curso_actual)
                                <span style="display: inline-block; padding: 0.25rem 0.625rem; font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.05em; color: #84cc16; background: rgba(132, 204, 22, 0.1); border-radius: 9999px;">{{ $estudiante->curso_actual->nombre }}</span>
                            @else
                                <span style="display: inline-block; padding: 0.25rem 0.625rem; font-size: 0.6875rem; font-weight: 600; color: var(--gray-500); background: var(--gray-100); border-radius: 9999px;">Sin curso</span>
                            @endif
                        </td>
                        <td>
                            @if($estudiante->promedio_general)
                                <div
                                    style="font-weight: 700; color: {{ $estudiante->promedio_general >= 6.0 ? 'var(--success)' : ($estudiante->promedio_general >= 4.0 ? 'var(--warning)' : 'var(--error)') }}; font-size: 1.125rem;">
                                    {{ number_format($estudiante->promedio_general, 1) }}
                                </div>
                            @else
                                <div style="color: var(--gray-400);">-</div>
                            @endif
                        </td>
                        <td>
                            <div style="font-weight: 600; color: var(--gray-400);">-</div>
                        </td>
                        <td>
                            @if($estudiante->estado === 'activo')
                                <span style="display: inline-block; padding: 0.25rem 0.625rem; font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.05em; color: var(--success); background: rgba(34, 197, 94, 0.1); border-radius: 9999px;">Activo</span>
                            @elseif($estudiante->estado === 'inactivo')
                                <span style="display: inline-block; padding: 0.25rem 0.625rem; font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.05em; color: var(--warning); background: rgba(245, 158, 11, 0.1); border-radius: 9999px;">Inactivo</span>
                            @else
                                <span style="display: inline-block; padding: 0.25rem 0.625rem; font-size: 0.6875rem; font-weight: 600; color: var(--gray-500); background: var(--gray-100); border-radius: 9999px;">{{ ucfirst($estudiante->estado) }}</span>
                            @endif
                        </td>
                        <td>
                            <div style="display: flex; gap: var(--spacing-sm);" onclick="event.stopPropagation();">
                                <a href="{{ route('students.edit', $estudiante->id) }}" class="btn btn-ghost btn-sm"
                                    title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('students.destroy', $estudiante->id) }}" method="POST"
                                    style="display: inline;"
                                    onsubmit="return confirm('¿Está seguro de eliminar este estudiante?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-ghost btn-sm" style="color: var(--error);"
                                        title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align: center; padding: var(--spacing-2xl); color: var(--gray-500);">
                            <i class="fas fa-users"
                                style="font-size: 3rem; margin-bottom: var(--spacing-md); opacity: 0.3;"></i>
                            <p style="margin: 0; font-size: 1.125rem;">No hay estudiantes registrados</p>
                            <p style="margin: var(--spacing-sm) 0 0 0; font-size: 0.875rem;">Haz clic en "Nuevo Estudiante"
                                para comenzar</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- No Results Message (hidden by default) -->
    <div id="noResults" class="card mb-xl" style="display: none;">
        <div class="card-body text-center" style="padding: var(--spacing-2xl);">
            <i class="fas fa-search" style="font-size: 3rem; color: var(--gray-300); margin-bottom: var(--spacing-md);"></i>
            <p style="color: var(--gray-600); margin: 0;">No se encontraron estudiantes que coincidan con tu búsqueda</p>
        </div>
    </div>

    <div id="importModal" class="filters-modal" onclick="closeImportModal()">
        <div class="filters-modal-content" onclick="event.stopPropagation()">
            <div class="filters-modal-header">
                <h3 style="margin: 0; font-size: 1.125rem; font-weight: 600; color: var(--gray-900);">
                    <i class="fas fa-file-import" style="color: var(--gray-400); margin-right: var(--spacing-sm);"></i>
                    Importar Estudiantes desde CSV
                </h3>
                <button type="button" onclick="closeImportModal()" class="filters-modal-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="{{ route('students.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="filters-modal-body">
                    <p style="color: var(--gray-600); margin-bottom: var(--spacing-md); font-size: 0.9375rem;">
                        Sube un archivo CSV con tus estudiantes. Incluye estas columnas requeridas en orden:
                    </p>
                    <ul style="color: var(--gray-600); font-size: 0.875rem; margin-bottom: var(--spacing-lg); padding-left: var(--spacing-md);">
                        <li><strong>RUT Estudiante</strong> (Ej: 22345678-9)</li>
                        <li><strong>Nombre Estudiante</strong></li>
                        <li><strong>Apellido Estudiante</strong></li>
                        <li><strong>RUT Apoderado</strong> (Ej: 12345678-9)</li>
                        <li><strong>Nombre Apoderado</strong></li>
                        <li><strong>Apellido Apoderado</strong></li>
                        <li><strong>Relación Apoderado</strong> (Ej: Padre, Madre)</li>
                    </ul>
                    <div class="form-group mb-0">
                        <label class="form-label" style="font-size: 0.875rem; font-weight: 600; color: var(--gray-700); margin-bottom: var(--spacing-xs); display: block;">Archivo CSV</label>
                        <input type="file" name="csv_file" accept=".csv" required style="width: 100%; padding: var(--spacing-sm); border: 2px dashed var(--gray-300); border-radius: var(--radius-md); font-size: 0.9375rem; cursor: pointer; color: var(--gray-700);">
                    </div>
                </div>
                <div class="filters-modal-footer">
                    <button type="button" onclick="closeImportModal()" class="btn btn-outline" style="flex: 1; border: 1px solid var(--gray-300); background: transparent; color: var(--gray-700);">
                        Cancelar
                    </button>
                    <button type="submit" style="flex: 1; background: #84cc16; color: white; border: none; border-radius: var(--radius-md); font-weight: 600; padding: 0.625rem; transition: background 0.2s; cursor: pointer;" onmouseover="this.style.background='#65a30d'" onmouseout="this.style.background='#84cc16'">
                        Importar Estudiantes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        @media (min-width: 769px) {
            #importModal.active {
                display: flex !important;
                align-items: center;
            }
            #importModal .filters-modal-content {
                max-width: 500px;
                border-radius: var(--radius-xl);
            }
        }
    </style>

    <script>
        // Real-time search and filter functionality
        const searchInput = document.getElementById('searchInput');
        const cursoFilter = document.getElementById('cursoFilter');
        const estadoFilter = document.getElementById('estadoFilter');
        const noResults = document.getElementById('noResults');
        
        function filterEstudiantes() {
            const searchTerm = searchInput.value.toLowerCase();
            const selectedCurso = cursoFilter.value;
            const selectedEstado = estadoFilter.value;
            const items = document.querySelectorAll('.estudiante-item');
            let visibleCount = 0;
            
            items.forEach(item => {
                const searchText = item.dataset.search || '';
                const curso = item.dataset.curso || '';
                const estado = item.dataset.estado || '';
                
                const matchesSearch = searchText.includes(searchTerm);
                const matchesCurso = !selectedCurso || curso === selectedCurso;
                const matchesEstado = !selectedEstado || estado === selectedEstado;
                
                if (matchesSearch && matchesCurso && matchesEstado) {
                    item.style.display = '';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });
            
            noResults.style.display = visibleCount === 0 ? 'block' : 'none';
            
            // Show/hide desktop clear button
            const activeFilters = (searchTerm ? 1 : 0) + (selectedCurso ? 1 : 0) + (selectedEstado ? 1 : 0);
            const clearFiltersBtn = document.getElementById('clearFiltersBtn');
            if (clearFiltersBtn) {
                clearFiltersBtn.style.display = activeFilters > 0 ? 'block' : 'none';
            }
        }
        
        searchInput.addEventListener('input', filterEstudiantes);
        cursoFilter.addEventListener('change', filterEstudiantes);
        estadoFilter.addEventListener('change', filterEstudiantes);
        
        // Filter Modal Functions
        function openFiltersModal() {
            const modal = document.getElementById('filtersModal');
            if (modal) {
                modal.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
        }
        
        function closeFiltersModal() {
            const modal = document.getElementById('filtersModal');
            if (modal) {
                modal.classList.remove('active');
                document.body.style.overflow = '';
            }
        }

        function openImportModal() {
            const modal = document.getElementById('importModal');
            if (modal) {
                modal.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
        }
        
        function closeImportModal() {
            const modal = document.getElementById('importModal');
            if (modal) {
                modal.classList.remove('active');
                document.body.style.overflow = '';
            }
        }
        
        // Apply filters function
        function applyFilters() {
            const searchInput = document.getElementById('searchInputMobile');
            const cursoFilter = document.getElementById('cursoFilterMobile');
            const estadoFilter = document.getElementById('estadoFilterMobile');
            
            // Sync with desktop filters
            document.getElementById('searchInput').value = searchInput.value;
            document.getElementById('cursoFilter').value = cursoFilter.value;
            document.getElementById('estadoFilter').value = estadoFilter.value;
            
            // Apply the filters
            filterEstudiantes();
            
            // Close the modal
            closeFiltersModal();
        }
        
        // Clear filters function
        function clearFilters() {
            // Clear mobile filters
            document.getElementById('searchInputMobile').value = '';
            document.getElementById('cursoFilterMobile').value = '';
            document.getElementById('estadoFilterMobile').value = '';
            
            // Clear desktop filters
            document.getElementById('searchInput').value = '';
            document.getElementById('cursoFilter').value = '';
            document.getElementById('estadoFilter').value = '';
            
            // Apply the cleared filters
            filterEstudiantes();
            
            // Close the modal
            closeFiltersModal();
        }
        
        // Responsive table switching
        function updateTableView() {
            const mobileTable = document.querySelector('.mobile-table');
            const desktopTable = document.querySelector('.table-container');
            
            if (window.innerWidth <= 768) {
                if (mobileTable) mobileTable.style.display = 'block';
                if (desktopTable) desktopTable.style.display = 'none';
            } else {
                if (mobileTable) mobileTable.style.display = 'none';
                if (desktopTable) desktopTable.style.display = 'block';
            }
        }
        
        updateTableView();
        window.addEventListener('resize', updateTableView);

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeFiltersModal();
                closeImportModal();
            }
        });
    </script>
</x-app-layout>