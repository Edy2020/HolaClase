<x-app-layout>
    <x-slot name="header">
        Gestión de Asignaturas
    </x-slot>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success"
            style="background: #10b981; color: white; padding: var(--spacing-md); border-radius: var(--radius-md); margin-bottom: var(--spacing-lg);">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Hero Header -->
    <div class="hero-header"
        style="background: var(--theme-dark); color: white; padding: var(--spacing-2xl); border-radius: var(--radius-xl); margin-bottom: var(--spacing-2xl); box-shadow: var(--shadow-lg); display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2 style="color: white; font-size: 1.75rem; font-weight: 700; margin-bottom: var(--spacing-sm);">
                <i class="fas fa-book"></i> Asignaturas
            </h2>
            <p class="hero-description" style="font-size: 1rem; opacity: 0.95; margin: 0;">
                Administra todas las asignaturas del sistema educativo
            </p>
        </div>
        <div class="hero-actions">
            <a href="{{ route('subjects.create') }}" class="btn btn-primary btn-new-subject"
                style="background: white; color: var(--theme-dark); text-decoration: none;">
                <span><i class="fas fa-plus"></i></span>
                <span class="btn-text">Nueva Asignatura</span>
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
            }

            .btn-new-subject {
                width: 100% !important;
                justify-content: center !important;
            }

            /* Hide search card on mobile */
            .search-card {
                display: none !important;
            }

            /* Show mobile search button */
            .mobile-search-button {
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

            .mobile-search-button,
            .search-modal {
                display: none !important;
            }
        }

        /* Search Modal */
        .search-modal {
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

        .search-modal.active {
            display: flex;
            align-items: flex-end;
            justify-content: center;
        }

        .search-modal-content {
            background: white;
            border-radius: var(--radius-xl) var(--radius-xl) 0 0;
            width: 100%;
            max-height: 40vh;
            overflow-y: auto;
            animation: slideUp 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .search-modal-header {
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

        .search-modal-close {
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

        .search-modal-close:hover {
            background: var(--gray-200);
            color: var(--gray-900);
        }

        .search-modal-body {
            padding: var(--spacing-lg);
        }

        .search-modal-footer {
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

    <!-- Search -->
    <div class="mb-xl search-card">
        <div style="display: flex; gap: var(--spacing-xs); align-items: center;">
                <div class="form-group mb-0" style="position: relative; flex: 1;">
                    <div style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--gray-400); font-size: 1.125rem;">
                        <i class="fas fa-search"></i>
                    </div>
                    <input type="text" id="searchInput" class="form-input" 
                        placeholder="Buscar por nombre o código..." 
                        style="padding-left: 40px; border: 2px solid var(--gray-200); border-radius: var(--radius-lg); transition: all 0.2s; font-size: 0.9375rem;"
                        onfocus="this.style.borderColor='var(--theme-color)'; this.style.boxShadow='0 0 0 3px rgba(139, 92, 246, 0.1)'"
                        onblur="this.style.borderColor='var(--gray-200)'; this.style.boxShadow='none'">
                </div>
                <!-- Clear Button (only visible when search is active) -->
                <button type="button" id="clearFiltersBtn" onclick="clearFilters()" 
                    style="display: none; width: 42px; height: 42px; border-radius: var(--radius-lg); background: var(--gray-100); border: 1px solid var(--gray-300); color: var(--gray-600); cursor: pointer; transition: all 0.2s; flex-shrink: 0;"
                    onmouseover="this.style.background='var(--gray-200)'; this.style.borderColor='var(--gray-400)'"
                    onmouseout="this.style.background='var(--gray-100)'; this.style.borderColor='var(--gray-300)'"
                    title="Limpiar búsqueda">
                    <i class="fas fa-times" style="font-size: 1.125rem;"></i>
                </button>
            </div>
    </div>

    <!-- Mobile: Standalone Search Button -->
    <div class="mobile-search-button" style="display: none; margin-bottom: var(--spacing-lg);">
        <button class="btn btn-primary" onclick="openSearchModal()" 
            style="width: 100%; height: 48px; border-radius: var(--radius-lg); display: flex; align-items: center; justify-content: center; gap: var(--spacing-sm); color: white;">
            <i class="fas fa-search"></i>
            <span>Buscar Asignaturas</span>
        </button>
    </div>

    <!-- Search Modal (Mobile only) -->
    <div id="searchModal" class="search-modal" onclick="closeSearchModal()">
        <div class="search-modal-content" onclick="event.stopPropagation()">
            <div class="search-modal-header">
                <h3 style="margin: 0; font-size: 1.25rem; font-weight: 700; color: var(--gray-900);">
                    <i class="fas fa-search" style="color: var(--theme-color); margin-right: var(--spacing-sm);"></i>
                    Buscar
                </h3>
                <button onclick="closeSearchModal()" class="search-modal-close" aria-label="Cerrar">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="search-modal-body">
                <div class="form-group mb-0">
                    <label class="form-label" style="font-size: 0.875rem; font-weight: 600; color: var(--gray-700); margin-bottom: var(--spacing-xs);">
                        <i class="fas fa-search" style="color: var(--theme-color);"></i> Buscar
                    </label>
                    <input type="text" id="searchInputMobile" class="form-input" 
                        placeholder="Buscar por nombre o código..." 
                        style="border: 2px solid var(--gray-200); border-radius: var(--radius-lg); font-size: 0.9375rem;">
                </div>
            </div>
            <div class="search-modal-footer">
                <button onclick="clearFilters()" class="btn btn-outline" style="flex: 1;">Limpiar</button>
                <button onclick="applySearch()" class="btn btn-primary" style="flex: 1; color: white;">Aplicar</button>
            </div>
        </div>
    </div>

    <!-- Mobile Table View (hidden on desktop) -->
    <div class="mobile-table" style="display: none;">
        <div class="mobile-table-container" style="background: white; border-radius: var(--radius-lg); overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            @forelse($asignaturas as $asignatura)
                <div class="asignatura-item mobile-table-row" 
                    style="border-bottom: 1px solid var(--gray-200); padding: var(--spacing-sm) var(--spacing-md); cursor: pointer; transition: background 0.2s;"
                    onclick="window.location='{{ route('subjects.show', $asignatura->id) }}'" 
                    data-search="{{ strtolower($asignatura->nombre . ' ' . $asignatura->codigo) }}"
                    onmouseover="this.style.background='var(--gray-50)'"
                    onmouseout="this.style.background='white'">
                    
                    <div style="display: flex; align-items: center; gap: var(--spacing-sm);">
                        <div style="width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, var(--theme-color), var(--theme-dark)); display: flex; align-items: center; justify-content: center; color: white; font-size: 0.875rem; flex-shrink: 0;">
                            <i class="fas fa-book-open"></i>
                        </div>
                        
                        <div style="flex: 1; min-width: 0;">
                            <div style="font-weight: 700; color: var(--gray-900); font-size: 0.9375rem; line-height: 1.3;">{{ $asignatura->nombre }}</div>
                            <div style="font-size: 0.75rem; color: var(--gray-600); margin-top: 2px;">Código: {{ $asignatura->codigo }}</div>
                        </div>
                        
                        <div style="display: flex; gap: 4px; flex-shrink: 0;" onclick="event.stopPropagation();">
                            <a href="{{ route('subjects.edit', $asignatura->id) }}" 
                                style="width: 32px; height: 32px; border-radius: var(--radius-md); background: var(--theme-color); color: white; display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: 0.75rem;"
                                title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('subjects.destroy', $asignatura->id) }}" method="POST" style="margin: 0;" onsubmit="return confirm('¿Está seguro de eliminar esta asignatura?');">
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
                    <i class="fas fa-book-open" style="font-size: 2rem; margin-bottom: var(--spacing-sm); opacity: 0.3;"></i>
                    <p style="margin: 0; font-size: 0.9375rem;">No hay asignaturas registradas</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Desktop Table View (hidden on mobile) -->
    <div class="table-container">
        <table class="table">
            <thead>
                <tr style="background: var(--theme-dark);">
                    <th style="color: white !important;">Asignatura</th>
                    <th style="color: white !important;">Código</th>
                    <th style="color: white !important;">Descripción</th>
                    <th style="color: white !important;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($asignaturas as $asignatura)
                    <tr class="asignatura-item" style="cursor: pointer;" onclick="window.location='{{ route('subjects.show', $asignatura->id) }}'" 
                        data-search="{{ strtolower($asignatura->nombre . ' ' . $asignatura->codigo) }}">
                        <td>
                            <div style="display: flex; align-items: center; gap: var(--spacing-md);">
                                <div
                                    style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, var(--theme-color), var(--theme-dark)); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700;">
                                    <i class="fas fa-book-open"></i>
                                </div>
                                <div>
                                    <div style="font-weight: 600; color: var(--gray-900);">
                                        {{ $asignatura->nombre }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-primary">{{ $asignatura->codigo }}</span>
                        </td>
                        <td style="color: var(--gray-600); font-size: 0.875rem;">
                            {{ $asignatura->descripcion ? Str::limit($asignatura->descripcion, 60) : 'Sin descripción' }}
                        </td>
                        <td>
                            <div style="display: flex; gap: var(--spacing-sm);" onclick="event.stopPropagation();">
                                <a href="{{ route('subjects.edit', $asignatura->id) }}" class="btn btn-ghost btn-sm"
                                    title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('subjects.destroy', $asignatura->id) }}" method="POST"
                                    style="display: inline;"
                                    onsubmit="return confirm('¿Está seguro de eliminar esta asignatura?');">
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
                        <td colspan="4" style="text-align: center; padding: var(--spacing-2xl); color: var(--gray-500);">
                            <i class="fas fa-book-open"
                                style="font-size: 3rem; margin-bottom: var(--spacing-md); opacity: 0.3;"></i>
                            <p style="margin: 0; font-size: 1.125rem;">No hay asignaturas registradas</p>
                            <p style="margin: var(--spacing-sm) 0 0 0; font-size: 0.875rem;">Haz clic en "Nueva Asignatura"
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
            <p style="color: var(--gray-600); margin: 0;">No se encontraron asignaturas que coincidan con tu búsqueda</p>
        </div>
    </div>

    <script>
        const searchInput = document.getElementById('searchInput');
        const searchInputMobile = document.getElementById('searchInputMobile');
        const noResults = document.getElementById('noResults');
        
        function filterAsignaturas() {
            const searchTerm = (searchInput?.value || searchInputMobile?.value || '').toLowerCase();
            const items = document.querySelectorAll('.asignatura-item');
            let visibleCount = 0;
            
            items.forEach(item => {
                const searchText = item.dataset.search || '';
                if (searchText.includes(searchTerm)) {
                    item.style.display = '';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });
            
            if (noResults) {
                noResults.style.display = visibleCount === 0 ? 'block' : 'none';
            }
            
            // Show/hide desktop clear button
            const clearFiltersBtn = document.getElementById('clearFiltersBtn');
            if (clearFiltersBtn) {
                clearFiltersBtn.style.display = searchTerm ? 'block' : 'none';
            }
        }
        
        function clearFilters() {
            if (searchInput) searchInput.value = '';
            if (searchInputMobile) searchInputMobile.value = '';
            filterAsignaturas();
        }
        
        // Sync search between desktop and mobile
        if (searchInput && searchInputMobile) {
            searchInput.addEventListener('input', () => {
                searchInputMobile.value = searchInput.value;
                filterAsignaturas();
            });
            searchInputMobile.addEventListener('input', () => {
                searchInput.value = searchInputMobile.value;
                filterAsignaturas();
            });
        } else if (searchInput) {
            searchInput.addEventListener('input', filterAsignaturas);
        }
        
        // Modal functions
        function openSearchModal() {
            const modal = document.getElementById('searchModal');
            if (modal) {
                modal.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
        }
        
        function closeSearchModal() {
            const modal = document.getElementById('searchModal');
            if (modal) {
                modal.classList.remove('active');
                document.body.style.overflow = '';
            }
        }
        
        function applySearch() {
            filterAsignaturas();
            closeSearchModal();
        }
        
        // Close on escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeSearchModal();
            }
        });
    </script>
</x-app-layout>