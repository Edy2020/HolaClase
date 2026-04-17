<x-app-layout>
    <x-slot name="header">
        Gestión de Profesores
    </x-slot>

    <link rel="stylesheet" href="{{ asset('css/shared-index.css') }}?v={{ time() }}">

    <!-- Page Header -->
    <div class="page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-lg);">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--gray-900); margin: 0;">
                Profesores
            </h2>
            <p style="color: var(--gray-500); margin: var(--spacing-xs) 0 0 0; font-size: 0.9375rem;">
                Administra el personal docente de la institución
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

            <a href="{{ route('teachers.create') }}" class="btn btn-outline"
                style="display: flex; align-items: center; justify-content: center; gap: var(--spacing-sm); border: 1px solid var(--gray-300); color: var(--gray-700); background: transparent; padding: 0.625rem 1.25rem; border-radius: var(--radius-md); font-weight: 600; text-decoration: none; transition: all 0.2s;"
                onmouseover="this.style.background='var(--gray-50)'; this.style.color='var(--gray-900)'"
                onmouseout="this.style.background='transparent'; this.style.color='var(--gray-700)'">
                <i class="fas fa-plus"></i>
                <span class="btn-text">Nuevo Profesor</span>
            </a>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="mb-xl filters-card">
        <div class="grid" style="grid-template-columns: 2fr 1fr; gap: var(--spacing-md); align-items: center;">
                <!-- Search Input -->
                <div class="form-group mb-0" style="position: relative;">
                    <div style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--gray-400); font-size: 1.125rem;">
                        <i class="fas fa-search"></i>
                    </div>
                    <input type="text" id="searchInput" class="form-input" 
                        placeholder="Buscar profesores..." 
                        style="padding-left: 40px; border: 2px solid var(--gray-200); border-radius: var(--radius-lg); transition: all 0.2s; font-size: 0.9375rem;"
                        onfocus="this.style.borderColor='#84cc16'; this.style.boxShadow='0 0 0 3px rgba(132, 204, 22, 0.1)'"
                        onblur="this.style.borderColor='var(--gray-200)'; this.style.boxShadow='none'">
                </div>
                
                <!-- Nivel Filter with Clear Button -->
                <div class="form-group mb-0" style="position: relative;">
                    <div style="display: flex; gap: var(--spacing-xs); align-items: center;">
                        <div style="position: relative; flex: 1;">
                            <div style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--gray-400); font-size: 1rem; pointer-events: none; z-index: 1;">
                                <i class="fas fa-layer-group"></i>
                            </div>
                            <select id="nivelFilter" class="form-select" 
                                style="padding-left: 40px; border: 2px solid var(--gray-200); border-radius: var(--radius-lg); transition: all 0.2s; font-size: 0.9375rem; cursor: pointer;"
                                onfocus="this.style.borderColor='#84cc16'; this.style.boxShadow='0 0 0 3px rgba(132, 204, 22, 0.1)'"
                                onblur="this.style.borderColor='var(--gray-200)'; this.style.boxShadow='none'">
                                <option value="">Todos los niveles</option>
                                <option value="Básica">Básica</option>
                                <option value="Media">Media</option>
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
                        placeholder="Buscar profesores..." 
                        style="border: 2px solid var(--gray-200); border-radius: var(--radius-lg); font-size: 0.9375rem;"
                        onfocus="this.style.borderColor='#84cc16'" onblur="this.style.borderColor='var(--gray-200)'">
                </div>
                <div class="form-group mb-0">
                    <label class="form-label" style="font-size: 0.875rem; font-weight: 600; color: var(--gray-700); margin-bottom: var(--spacing-xs); display: flex; align-items: center; gap: var(--spacing-xs);">
                        <i class="fas fa-layer-group" style="color: var(--gray-400);"></i> Nivel
                    </label>
                    <select id="nivelFilterMobile" class="form-select" 
                        style="border: 2px solid var(--gray-200); border-radius: var(--radius-lg); font-size: 0.9375rem;"
                        onfocus="this.style.borderColor='#84cc16'" onblur="this.style.borderColor='var(--gray-200)'">
                        <option value="">Todos los niveles</option>
                        <option value="Básica">Básica</option>
                        <option value="Media">Media</option>
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
        <div class="mobile-table-container" style="background: white; border-radius: var(--radius-lg); overflow: hidden;">
            @forelse($profesores as $profesor)
                <div class="profesor-item mobile-table-row" 
                    style="border-bottom: 1px solid var(--gray-200); padding: var(--spacing-sm) var(--spacing-md); cursor: pointer; transition: background 0.2s;"
                    onclick="window.location='{{ route('teachers.show', $profesor->id) }}'" 
                    data-search="{{ strtolower($profesor->nombre . ' ' . $profesor->apellido . ' ' . $profesor->rut) }}"
                    data-nivel="{{ $profesor->nivel_ensenanza ?? '' }}">
                    
                    <div style="display: flex; align-items: center; gap: var(--spacing-sm);">
                        <div style="width: 36px; height: 36px; border-radius: 50%; background: #84cc16; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 0.75rem; flex-shrink: 0;">
                            {{ strtoupper(substr($profesor->nombre, 0, 1) . substr($profesor->apellido, 0, 1)) }}
                        </div>
                        
                        <div style="flex: 1; min-width: 0;">
                            <div style="font-weight: 700; color: var(--gray-900); font-size: 0.9375rem; line-height: 1.3;">{{ $profesor->nombre }} {{ $profesor->apellido }}</div>
                            <div style="font-size: 0.75rem; color: var(--gray-600); margin-top: 2px;">
                                <i class="fas fa-envelope" style="font-size: 0.625rem;"></i> {{ $profesor->email ?? 'Sin email' }}
                            </div>
                        </div>
                        
                        <div style="display: flex; gap: 4px; flex-shrink: 0;" onclick="event.stopPropagation();">
                            <a href="{{ route('teachers.edit', $profesor->id) }}" 
                                style="width: 32px; height: 32px; border-radius: var(--radius-md); background: transparent; color: var(--gray-600); border: 1px solid var(--gray-300); display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: 0.75rem; transition: background 0.2s;"
                                onmouseover="this.style.background='var(--gray-100)';"
                                onmouseout="this.style.background='transparent';"
                                title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('teachers.destroy', $profesor->id) }}" method="POST" style="margin: 0;" onsubmit="return confirm('¿Está seguro de eliminar este profesor?');">
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
                    <i class="fas fa-chalkboard-teacher" style="font-size: 2rem; margin-bottom: var(--spacing-sm); opacity: 0.3;"></i>
                    <p style="margin: 0; font-size: 0.9375rem;">No hay profesores registrados</p>
                </div>
            @endforelse
        </div>
    </div>


    <!-- Desktop Table View (hidden on mobile) -->
    <div class="table-container">
        <table class="table">
            <thead>
                <tr class="table-header-row">
                    <th style="text-align: left;">Profesor</th>
                    <th style="text-align: left;">Email</th>
                    <th style="text-align: left;">Teléfono</th>
                    <th style="text-align: left;">Nivel</th>
                    <th style="text-align: left;">Título</th>
                    <th style="text-align: left;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($profesores as $profesor)
                    <tr class="profesor-item" style="cursor: pointer;" onclick="window.location='{{ route('teachers.show', $profesor->id) }}'" \n                        data-search="{{ strtolower($profesor->nombre . ' ' . $profesor->apellido . ' ' . $profesor->rut) }}"\n                        data-nivel="{{ $profesor->nivel_ensenanza ?? '' }}">
                        <td>
                            <div style="display: flex; align-items: center; gap: var(--spacing-md);">
                                <div
                                    style="width: 40px; height: 40px; border-radius: 50%; background: #84cc16; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700;">
                                    {{ strtoupper(substr($profesor->nombre, 0, 1) . substr($profesor->apellido, 0, 1)) }}
                                </div>
                                <div>
                                    <div style="font-weight: 600; color: var(--gray-900);">
                                        {{ $profesor->nombre }} {{ $profesor->apellido }}</div>
                                    <div style="font-size: 0.875rem; color: var(--gray-500);">{{ $profesor->rut }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="color: var(--gray-600);">{{ $profesor->email ?? 'Sin email' }}</td>
                        <td style="color: var(--gray-600);">{{ $profesor->telefono ?? 'Sin teléfono' }}</td>
                        <td>
                            @if($profesor->nivel_ensenanza)
                                <span style="display: inline-block; padding: 0.25rem 0.625rem; font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.05em; color: #84cc16; background: rgba(132, 204, 22, 0.1); border-radius: 9999px;">{{ $profesor->nivel_ensenanza }}</span>
                            @else
                                <span style="display: inline-block; padding: 0.25rem 0.625rem; font-size: 0.6875rem; font-weight: 600; color: var(--gray-500); background: var(--gray-100); border-radius: 9999px;">Sin nivel</span>
                            @endif
                        </td>
                        <td style="color: var(--gray-600); font-size: 0.875rem;">
                            {{ $profesor->titulo ?? 'Sin título' }}
                        </td>
                        <td>
                            <div style="display: flex; gap: var(--spacing-sm);" onclick="event.stopPropagation();">
                                <a href="{{ route('teachers.edit', $profesor->id) }}" class="btn btn-ghost btn-sm"
                                    title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('teachers.destroy', $profesor->id) }}" method="POST"
                                    style="display: inline;"
                                    onsubmit="return confirm('¿Está seguro de eliminar este profesor?');">
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
                        <td colspan="6" style="text-align: center; padding: var(--spacing-2xl); color: var(--gray-500);">
                            <i class="fas fa-chalkboard-teacher"
                                style="font-size: 3rem; margin-bottom: var(--spacing-md); opacity: 0.3;"></i>
                            <p style="margin: 0; font-size: 1.125rem;">No hay profesores registrados</p>
                            <p style="margin: var(--spacing-sm) 0 0 0; font-size: 0.875rem;">Haz clic en "Nuevo Profesor"
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
            <p style="color: var(--gray-600); margin: 0;">No se encontraron profesores que coincidan con tu búsqueda</p>
        </div>
    </div>

    <!-- Import CSV Modal -->
    <div id="importModal" class="filters-modal" onclick="closeImportModal()">
        <div class="filters-modal-content" onclick="event.stopPropagation()">
            <div class="filters-modal-header">
                <h3 style="margin: 0; font-size: 1.125rem; font-weight: 600; color: var(--gray-900);">
                    <i class="fas fa-file-import" style="color: var(--gray-400); margin-right: var(--spacing-sm);"></i>
                    Importar Profesores desde CSV
                </h3>
                <button type="button" onclick="closeImportModal()" class="filters-modal-close" aria-label="Cerrar">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="{{ route('teachers.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="filters-modal-body">
                    <p style="color: var(--gray-600); margin-bottom: var(--spacing-md); font-size: 0.9375rem;">
                        Sube un archivo CSV con tus profesores. Asegúrate de incluir las siguientes columnas requeridas en este orden (con encabezado):
                    </p>
                    <ul style="color: var(--gray-600); font-size: 0.875rem; margin-bottom: var(--spacing-lg); padding-left: var(--spacing-md);">
                        <li><strong>RUT</strong> (Ej: 12345678-9)</li>
                        <li><strong>Nombre</strong> (Ej: Juan)</li>
                        <li><strong>Apellido</strong> (Ej: Pérez)</li>
                        <li><strong>Email</strong> (Ej: juan.perez@escuela.cl)</li>
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
                        Importar Profesores
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        /* Override desktop hiding for the import modal */
        @media (min-width: 769px) {
            #importModal.active {
                display: flex !important;
                align-items: center; /* Center on desktop instead of bottom sheet */
            }
            #importModal .filters-modal-content {
                max-width: 500px;
                border-radius: var(--radius-xl);
            }
        }
    </style>

    <script>
        const searchInput = document.getElementById('searchInput');
        const searchInputMobile = document.getElementById('searchInputMobile');
        const nivelFilter = document.getElementById('nivelFilter');
        const nivelFilterMobile = document.getElementById('nivelFilterMobile');
        const noResults = document.getElementById('noResults');
        const filterBadge = document.getElementById('filterBadgeMobile');
        
        function filterProfesores() {
            const searchTerm = (searchInput?.value || searchInputMobile?.value || '').toLowerCase();
            const selectedNivel = nivelFilter?.value || nivelFilterMobile?.value || '';
            const items = document.querySelectorAll('.profesor-item');
            let visibleCount = 0;
            
            items.forEach(item => {
                const searchText = item.dataset.search || '';
                const nivel = item.dataset.nivel || '';
                const matchesSearch = searchText.includes(searchTerm);
                const matchesNivel = !selectedNivel || nivel === selectedNivel;
                
                if (matchesSearch && matchesNivel) {
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
            const nivelValue = nivelFilter?.value || nivelFilterMobile?.value || '';
            const activeFilters = (searchValue ? 1 : 0) + (nivelValue ? 1 : 0);
            
            if (filterBadge) {
                filterBadge.textContent = activeFilters;
                filterBadge.style.display = activeFilters > 0 ? 'flex' : 'none';
            }
            
            // Show/hide desktop clear button
            const clearFiltersBtn = document.getElementById('clearFiltersBtn');
            if (clearFiltersBtn) {
                clearFiltersBtn.style.display = activeFilters > 0 ? 'block' : 'none';
            }
        }
        
        // Sync search and filters
        if (searchInput && searchInputMobile) {
            searchInput.addEventListener('input', () => {
                searchInputMobile.value = searchInput.value;
                filterProfesores();
            });
            searchInputMobile.addEventListener('input', () => {
                searchInput.value = searchInputMobile.value;
                filterProfesores();
            });
        }
        if (nivelFilter) nivelFilter.addEventListener('change', filterProfesores);
        
        // Modal functions
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
        
        function applyFilters() {
            if (nivelFilter && nivelFilterMobile) {
                nivelFilter.value = nivelFilterMobile.value;
            }
            filterProfesores();
            closeFiltersModal();
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
        
        function clearFilters() {
            // Clear mobile filters
            const searchInputMobile = document.getElementById('searchInputMobile');
            const nivelFilterMobile = document.getElementById('nivelFilterMobile');
            
            if (searchInputMobile) searchInputMobile.value = '';
            if (nivelFilterMobile) nivelFilterMobile.value = '';
            
            // Clear desktop filters
            const searchInput = document.getElementById('searchInput');
            const nivelFilter = document.getElementById('nivelFilter');
            
            if (searchInput) searchInput.value = '';
            if (nivelFilter) nivelFilter.value = '';
            
            // Apply the cleared filters
            filterProfesores();
            closeFiltersModal();
        }
        
        // Close on escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeFiltersModal();
                closeImportModal();
            }
        });
        
        updateFilterBadge();
    </script>
</x-app-layout>