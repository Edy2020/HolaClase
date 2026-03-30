<x-app-layout>
    <x-slot name="header">
        Gestión de Estudiantes
    </x-slot>

    <!-- Hero Header -->
    <div class="hero-header"
        style="background: var(--theme-dark); color: white; padding: var(--spacing-2xl); border-radius: var(--radius-xl); margin-bottom: var(--spacing-2xl); box-shadow: var(--shadow-lg); display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2 style="color: white; font-size: 1.75rem; font-weight: 700; margin-bottom: var(--spacing-sm);">
                <i class="fas fa-users"></i> Estudiantes
            </h2>
            <p class="hero-description" style="font-size: 1rem; opacity: 0.95; margin: 0;">
                Gestiona la información de todos tus estudiantes
            </p>
        </div>
        <div class="hero-actions" style="display: flex; gap: var(--spacing-md); align-items: center;">
            <a href="{{ route('students.create') }}" class="btn btn-primary btn-new-student"
                style="background: white; color: var(--theme-dark); flex-shrink: 0;">
                <span><i class="fas fa-plus"></i></span>
                <span class="btn-text">Nuevo Estudiante</span>
            </a>
        </div>
    </div>

    <style>
        /* Mobile Responsive Styles */
        @media (max-width: 768px) {
            .hero-header {
                flex-direction: column !important;
                gap: var(--spacing-lg) !important;
                padding: var(--spacing-lg) !important;
                text-align: center !important;
            }

            .hero-header h2 {
                font-size: 1.5rem !important;
            }

            .hero-description {
                font-size: 0.875rem !important;
            }

            .hero-actions {
                width: 100% !important;
                flex-direction: column !important;
                gap: var(--spacing-sm) !important;
            }

            .btn-new-student {
                width: 100% !important;
                justify-content: center !important;
            }

            .btn-text {
                display: inline !important;
            }

            /* Hide filters card on mobile */
            .filters-card {
                display: none !important;
            }

            /* Show mobile filter button */
            .mobile-filter-button {
                display: block !important;
            }

            /* Hide table on mobile, show table */
            .table-container {
                display: none !important;
            }

            .mobile-table {
                display: block !important;
            }
        }

        /* Desktop: Show table, hide mobile elements */
        @media (min-width: 769px) {
            .mobile-table {
                display: none !important;
            }

            .table-container {
                display: block !important;
            }

            .mobile-filter-button,
            .filters-modal {
                display: none !important;
            }
        }

        /* Filter Badge */
        .filter-badge {
            position: absolute;
            top: -6px;
            right: -6px;
            background: var(--error);
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 0.6875rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Filters Modal */
        .filters-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            animation: fadeIn 0.2s ease-out;
        }

        .filters-modal.active {
            display: flex;
            align-items: flex-end;
            justify-content: center;
        }

        .filters-modal-content {
            background: white;
            border-radius: var(--radius-xl) var(--radius-xl) 0 0;
            width: 100%;
            max-height: 70vh;
            overflow-y: auto;
            animation: slideUp 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .filters-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: var(--spacing-lg);
            border-bottom: 1px solid var(--gray-200);
            position: sticky;
            top: 0;
            background: white;
            z-index: 1;
        }

        .filters-modal-close {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--gray-100);
            border: none;
            color: var(--gray-600);
            font-size: 1.125rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .filters-modal-close:hover {
            background: var(--gray-200);
            color: var(--gray-900);
        }

        .filters-modal-body {
            padding: var(--spacing-lg);
        }

        .filters-modal-footer {
            padding: var(--spacing-lg);
            border-top: 1px solid var(--gray-200);
            display: flex;
            gap: var(--spacing-sm);
            position: sticky;
            bottom: 0;
            background: white;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from { transform: translateY(100%); }
            to { transform: translateY(0); }
        }
    </style>

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
                        onfocus="this.style.borderColor='var(--theme-color)'; this.style.boxShadow='0 0 0 3px rgba(139, 92, 246, 0.1)'"
                        onblur="this.style.borderColor='var(--gray-200)'; this.style.boxShadow='none'">
                </div>
                <div class="form-group mb-0" style="position: relative;">
                    <div style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--gray-400); font-size: 1rem; pointer-events: none; z-index: 1;">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <select id="cursoFilter" class="form-select" 
                        style="padding-left: 40px; border: 2px solid var(--gray-200); border-radius: var(--radius-lg); transition: all 0.2s; font-size: 0.9375rem; cursor: pointer;">
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
                                style="padding-left: 40px; border: 2px solid var(--gray-200); border-radius: var(--radius-lg); transition: all 0.2s; font-size: 0.9375rem; cursor: pointer;">
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
    <div class="mobile-filter-button" style="display: none; margin-bottom: var(--spacing-lg);">
        <button class="btn btn-primary" onclick="openFiltersModal()" 
            style="width: 100%; height: 48px; border-radius: var(--radius-lg); position: relative; display: flex; align-items: center; justify-content: center; gap: var(--spacing-sm); color: white;">
            <i class="fas fa-search"></i>
            <span>Buscar y Filtrar</span>
            <span id="filterBadgeMobile" class="filter-badge" style="display: none;">0</span>
        </button>
    </div>

    <!-- Filters Modal (Mobile only) -->
    <div id="filtersModal" class="filters-modal" onclick="closeFiltersModal()">
        <div class="filters-modal-content" onclick="event.stopPropagation()">
            <div class="filters-modal-header">
                <h3 style="margin: 0; font-size: 1.25rem; font-weight: 700; color: var(--gray-900);">
                    <i class="fas fa-search" style="color: var(--theme-color); margin-right: var(--spacing-sm);"></i>
                    Buscar y Filtrar
                </h3>
                <button onclick="closeFiltersModal()" class="filters-modal-close" aria-label="Cerrar">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="filters-modal-body">
                <div class="form-group">
                    <label class="form-label" style="font-size: 0.875rem; font-weight: 600; color: var(--gray-700); margin-bottom: var(--spacing-xs);">
                        <i class="fas fa-search" style="color: var(--theme-color);"></i> Buscar
                    </label>
                    <input type="text" id="searchInputMobile" class="form-input" 
                        placeholder="Buscar estudiantes..." 
                        style="border: 2px solid var(--gray-200); border-radius: var(--radius-lg); font-size: 0.9375rem;">
                </div>
                <div class="form-group">
                    <label class="form-label" style="font-size: 0.875rem; font-weight: 600; color: var(--gray-700); margin-bottom: var(--spacing-xs);">
                        <i class="fas fa-graduation-cap" style="color: var(--theme-color);"></i> Curso
                    </label>
                    <select id="cursoFilterMobile" class="form-select" 
                        style="border: 2px solid var(--gray-200); border-radius: var(--radius-lg); font-size: 0.9375rem;">
                        <option value="">Todos los cursos</option>
                        @foreach($estudiantes->pluck('curso_actual')->filter()->unique('id') as $curso)
                            <option value="{{ $curso->id }}">{{ $curso->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-0">
                    <label class="form-label" style="font-size: 0.875rem; font-weight: 600; color: var(--gray-700); margin-bottom: var(--spacing-xs);">
                        <i class="fas fa-check-circle" style="color: var(--theme-color);"></i> Estado
                    </label>
                    <select id="estadoFilterMobile" class="form-select" 
                        style="border: 2px solid var(--gray-200); border-radius: var(--radius-lg); font-size: 0.9375rem;">
                        <option value="">Todos los estados</option>
                        <option value="activo">Activo</option>
                        <option value="inactivo">Inactivo</option>
                        <option value="retirado">Retirado</option>
                    </select>
                </div>
            </div>
            <div class="filters-modal-footer">
                <button onclick="clearFilters()" class="btn btn-outline" style="flex: 1;">Limpiar</button>
                <button onclick="applyFilters()" class="btn btn-primary" style="flex: 1; color: white;">Aplicar</button>
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
                    data-estado="{{ $estudiante->estado }}"
                    onmouseover="this.style.background='var(--gray-50)'"
                    onmouseout="this.style.background='white'">
                    
                    <div style="display: flex; align-items: center; gap: var(--spacing-sm);">
                        <div style="width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, var(--theme-color), var(--theme-dark)); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 0.75rem; flex-shrink: 0;">
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
                                style="width: 32px; height: 32px; border-radius: var(--radius-md); background: var(--theme-color); color: white; display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: 0.75rem;"
                                title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('students.destroy', $estudiante->id) }}" method="POST" style="margin: 0;" onsubmit="return confirm('¿Está seguro de eliminar este estudiante?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                    style="width: 32px; height: 32px; border-radius: var(--radius-md); background: white; color: var(--error); border: 1px solid var(--error); display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 0.75rem;"
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
                <tr style="background: var(--theme-dark);">
                    <th style="color: white !important;">Estudiante</th>
                    <th style="color: white !important;">Email</th>
                    <th style="color: white !important;">Curso</th>
                    <th style="color: white !important;">Promedio</th>
                    <th style="color: white !important;">Asistencia</th>
                    <th style="color: white !important;">Estado</th>
                    <th style="color: white !important;">Acciones</th>
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
                                    style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, var(--theme-color), var(--theme-dark)); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700;">
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
                                <span class="badge badge-primary">{{ $estudiante->curso_actual->nombre }}</span>
                            @else
                                <span class="badge">Sin curso</span>
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
                                <span class="badge badge-success">Activo</span>
                            @elseif($estudiante->estado === 'inactivo')
                                <span class="badge badge-warning">Inactivo</span>
                            @else
                                <span class="badge">{{ ucfirst($estudiante->estado) }}</span>
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
    </script>
</x-app-layout>