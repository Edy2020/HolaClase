<x-app-layout>
    <x-slot name="header">
        Gestión de Cursos
    </x-slot>

    <!-- Hero Header -->
    <div class="hero-header"
        style="background: var(--theme-dark); color: white; padding: var(--spacing-2xl); border-radius: var(--radius-xl); margin-bottom: var(--spacing-2xl); box-shadow: var(--shadow-lg); display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2 style="color: white; font-size: 1.75rem; font-weight: 700; margin-bottom: var(--spacing-sm);">
                <i class="fas fa-graduation-cap"></i> Cursos
            </h2>
            <p class="hero-description" style="font-size: 1rem; opacity: 0.95; margin: 0;">
                Administra todos los cursos de enseñanza básica y media
            </p>
        </div>
        <div class="hero-actions" style="display: flex; gap: var(--spacing-md); align-items: center;">
            <a href="{{ route('courses.create') }}" class="btn btn-primary btn-new-course"
                style="background: white; color: var(--theme-dark); flex-shrink: 0; text-decoration: none;">
                <span><i class="fas fa-plus"></i></span>
                <span class="btn-text">Nuevo Curso</span>
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

            .btn-new-course {
                width: 100% !important;
                justify-content: center !important;
            }

            .btn-text {
                display: inline !important;
            }

            /* Hide table on mobile, show cards */
            .table-container {
                display: none !important;
            }

            .mobile-table {
                display: block !important;
            }

            /* Show mobile filters, hide desktop */
            .filters-desktop {
                display: none !important;
            }

            .filters-mobile {
                display: flex !important;
            }

            /* Hide entire filters card on mobile */
            .filters-card {
                display: none !important;
            }

            /* Show mobile filter button */
            .mobile-filter-button {
                display: block !important;
            }
        }

        /* Desktop: Show table, hide cards */
        @media (min-width: 769px) {
            .mobile-table {
                display: none !important;
            }

            .table-container {
                display: block !important;
            }

            .filters-mobile,
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
            max-height: 80vh;
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
            from {
                transform: translateY(100%);
            }
            to {
                transform: translateY(0);
            }
        }
    </style>

    <!-- Search and Filters -->
    <div class="card mb-xl filters-card" style="border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
        <div class="card-body" style="padding: var(--spacing-lg);">
            <!-- Desktop: 3 columns -->
            <div class="filters-desktop" style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: var(--spacing-md); align-items: center;">
                <!-- Search Input -->
                <div class="form-group mb-0" style="position: relative;">
                    <div style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--gray-400); font-size: 1.125rem;">
                        <i class="fas fa-search"></i>
                    </div>
                    <input type="text" id="searchInput" class="form-input" 
                        placeholder="Buscar cursos..." 
                        style="padding-left: 40px; border: 2px solid var(--gray-200); border-radius: var(--radius-lg); transition: all 0.2s; font-size: 0.9375rem;"
                        onfocus="this.style.borderColor='var(--theme-color)'; this.style.boxShadow='0 0 0 3px rgba(139, 92, 246, 0.1)'"
                        onblur="this.style.borderColor='var(--gray-200)'; this.style.boxShadow='none'">
                </div>
                
                <!-- Nivel Filter -->
                <div class="form-group mb-0" style="position: relative;">
                    <div style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--gray-400); font-size: 1rem; pointer-events: none; z-index: 1;">
                        <i class="fas fa-layer-group"></i>
                    </div>
                    <select id="nivelFilter" class="form-select" 
                        style="padding-left: 40px; border: 2px solid var(--gray-200); border-radius: var(--radius-lg); transition: all 0.2s; font-size: 0.9375rem; cursor: pointer;"
                        onfocus="this.style.borderColor='var(--theme-color)'; this.style.boxShadow='0 0 0 3px rgba(139, 92, 246, 0.1)'"
                        onblur="this.style.borderColor='var(--gray-200)'; this.style.boxShadow='none'">
                        <option value="">Todos los niveles</option>
                        <option value="pre-kinder">Pre-Kinder</option>
                        <option value="kinder">Kinder</option>
                        <option value="basica">Básica</option>
                        <option value="media">Media</option>
                    </select>
                </div>
                
                <!-- Profesor Filter with Clear Button -->
                <div class="form-group mb-0" style="position: relative;">
                    <div style="display: flex; gap: var(--spacing-xs); align-items: center;">
                        <div style="position: relative; flex: 1;">
                            <div style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--gray-400); font-size: 1rem; pointer-events: none; z-index: 1;">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </div>
                            <select id="profesorFilter" class="form-select" 
                                style="padding-left: 40px; border: 2px solid var(--gray-200); border-radius: var(--radius-lg); transition: all 0.2s; font-size: 0.9375rem; cursor: pointer;"
                                onfocus="this.style.borderColor='var(--theme-color)'; this.style.boxShadow='0 0 0 3px rgba(139, 92, 246, 0.1)'"
                                onblur="this.style.borderColor='var(--gray-200)'; this.style.boxShadow='none'">
                                <option value="">Todos los profesores</option>
                                @foreach($cursos->unique('profesor_id')->filter(fn($c) => $c->profesor) as $curso)
                                    <option value="{{ $curso->profesor->id }}">{{ $curso->profesor->nombre }} {{ $curso->profesor->apellido }}</option>
                                @endforeach
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

            <!-- Mobile: Filter Button Only -->
            <div class="filters-mobile" style="display: none;">
                <!-- Filter/Search Button -->
                <button id="filterButton" class="btn btn-primary" onclick="openFiltersModal()" 
                    style="width: 100%; height: 48px; border-radius: var(--radius-lg); position: relative; display: flex; align-items: center; justify-content: center; gap: var(--spacing-sm); color: white;">
                    <i class="fas fa-search"></i>
                    <span>Buscar y Filtrar</span>
                    <span id="filterBadge" class="filter-badge" style="display: none;">0</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile: Standalone Filter Button (outside card) -->
    <div class="mobile-filter-button" style="display: none; margin-bottom: var(--spacing-lg);" >
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
                <!-- Search Input -->
                <div class="form-group">
                    <label class="form-label" style="font-size: 0.875rem; font-weight: 600; color: var(--gray-700); margin-bottom: var(--spacing-xs); display: flex; align-items: center; gap: var(--spacing-xs);">
                        <i class="fas fa-search" style="color: var(--theme-color);"></i>
                        Buscar
                    </label>
                    <input type="text" id="searchInputMobile" class="form-input" 
                        placeholder="Buscar cursos..." 
                        style="border: 2px solid var(--gray-200); border-radius: var(--radius-lg); font-size: 0.9375rem;">
                </div>
                
                <!-- Nivel Filter -->
                <div class="form-group">
                    <label class="form-label" style="font-size: 0.875rem; font-weight: 600; color: var(--gray-700); margin-bottom: var(--spacing-xs); display: flex; align-items: center; gap: var(--spacing-xs);">
                        <i class="fas fa-layer-group" style="color: var(--theme-color);"></i>
                        Nivel
                    </label>
                    <select id="nivelFilterMobile" class="form-select" 
                        style="border: 2px solid var(--gray-200); border-radius: var(--radius-lg); font-size: 0.9375rem;">
                        <option value="">Todos los niveles</option>
                        <option value="pre-kinder">Pre-Kinder</option>
                        <option value="kinder">Kinder</option>
                        <option value="basica">Básica</option>
                        <option value="media">Media</option>
                    </select>
                </div>
                
                <!-- Profesor Filter -->
                <div class="form-group mb-0">
                    <label class="form-label" style="font-size: 0.875rem; font-weight: 600; color: var(--gray-700); margin-bottom: var(--spacing-xs); display: flex; align-items: center; gap: var(--spacing-xs);">
                        <i class="fas fa-chalkboard-teacher" style="color: var(--theme-color);"></i>
                        Profesor
                    </label>
                    <select id="profesorFilterMobile" class="form-select" 
                        style="border: 2px solid var(--gray-200); border-radius: var(--radius-lg); font-size: 0.9375rem;">
                        <option value="">Todos los profesores</option>
                        @foreach($cursos->unique('profesor_id')->filter(fn($c) => $c->profesor) as $curso)
                            <option value="{{ $curso->profesor->id }}">{{ $curso->profesor->nombre }} {{ $curso->profesor->apellido }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="filters-modal-footer">
                <button onclick="clearFilters()" class="btn btn-outline" style="flex: 1;">
                    Limpiar
                </button>
                <button onclick="applyFilters()" class="btn btn-primary" style="flex: 1; color: white;">
                    Aplicar
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Table View (hidden on desktop) -->
    <div class="mobile-table" style="display: none;">
        <div class="mobile-table-container" style="background: white; border-radius: var(--radius-lg); overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            @forelse($cursos as $curso)
                <div class="curso-item mobile-table-row" 
                    style="border-bottom: 1px solid var(--gray-200); padding: var(--spacing-sm) var(--spacing-md); cursor: pointer; transition: background 0.2s;"
                    onclick="window.location='{{ route('courses.show', $curso->id) }}'" 
                    data-search="{{ strtolower($curso->nombre . ' ' . $curso->nivel) }}"
                    data-nivel="{{ $curso->nivel }}"
                    data-profesor="{{ $curso->profesor_id ?? '' }}"
                    onmouseover="this.style.background='var(--gray-50)'"
                    onmouseout="this.style.background='white'">
                    
                    <div style="display: flex; align-items: center; gap: var(--spacing-sm);">
                        <!-- Avatar -->
                        <div style="width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, var(--theme-color), var(--theme-dark)); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 0.75rem; flex-shrink: 0;">
                            @if($curso->nivel === 'pre-kinder' || $curso->nivel === 'kinder')
                                {{ strtoupper(substr($curso->nivel, 0, 2)) }}{{ $curso->letra }}
                            @else
                                {{ $curso->grado }}{{ $curso->letra }}
                            @endif
                        </div>
                        
                        <!-- Course Info -->
                        <div style="flex: 1; min-width: 0;">
                            <div style="font-weight: 700; color: var(--gray-900); font-size: 0.9375rem; line-height: 1.3;">{{ $curso->nombre }}</div>
                            <div style="font-size: 0.75rem; color: var(--gray-600); display: flex; align-items: center; gap: 6px; flex-wrap: wrap; margin-top: 2px;">
                                @if($curso->profesor)
                                    <span style="display: flex; align-items: center; gap: 3px;">
                                        <i class="fas fa-user" style="font-size: 0.625rem;"></i>
                                        {{ $curso->profesor->nombre }}
                                    </span>
                                    <span style="color: var(--gray-400);">•</span>
                                @endif
                                <span style="display: flex; align-items: center; gap: 3px;">
                                    <i class="fas fa-users" style="font-size: 0.625rem; color: var(--theme-color);"></i>
                                    {{ $curso->estudiantes_count ?? 0 }}
                                </span>
                            </div>
                        </div>
                        
                        <!-- Actions -->
                        <div style="display: flex; gap: 4px; flex-shrink: 0;" onclick="event.stopPropagation();">
                            <a href="{{ route('courses.edit', $curso->id) }}" 
                                style="width: 32px; height: 32px; border-radius: var(--radius-md); background: var(--theme-color); color: white; display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: 0.75rem;"
                                title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('courses.destroy', $curso->id) }}" method="POST" style="margin: 0;" onsubmit="return confirm('¿Está seguro de eliminar este curso?');">
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
                    <i class="fas fa-graduation-cap" style="font-size: 2rem; margin-bottom: var(--spacing-sm); opacity: 0.3;"></i>
                    <p style="margin: 0; font-size: 0.9375rem;">No hay cursos registrados</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Desktop Table View (hidden on mobile) -->
    <div class="table-container">
        <table class="table">
            <thead>
                <tr style="background: var(--theme-dark);">
                    <th style="color: white !important;">Curso</th>
                    <th style="color: white !important;">Nivel</th>
                    <th style="color: white !important;">Profesor Jefe</th>
                    <th style="color: white !important;">Estudiantes</th>
                    <th style="color: white !important;">Asignaturas</th>
                    <th style="color: white !important;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($cursos as $curso)
                    <tr class="curso-item" style="cursor: pointer;" onclick="window.location='{{ route('courses.show', $curso->id) }}'" 
                        data-search="{{ strtolower($curso->nombre . ' ' . $curso->nivel) }}"
                        data-nivel="{{ $curso->nivel }}"
                        data-profesor="{{ $curso->profesor_id ?? '' }}">
                        <td>
                            <div style="display: flex; align-items: center; gap: var(--spacing-md);">
                                <div
                                    style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, var(--theme-color), var(--theme-dark)); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 0.875rem;">
                                    @if($curso->nivel === 'pre-kinder' || $curso->nivel === 'kinder')
                                        {{ strtoupper(substr($curso->nivel, 0, 2)) }}{{ $curso->letra }}
                                    @else
                                        {{ $curso->grado }}{{ $curso->letra }}
                                    @endif
                                </div>
                                <div>
                                    <div style="font-weight: 600; color: var(--gray-900);">
                                        {{ $curso->nombre }}</div>
                                    <div style="font-size: 0.875rem; color: var(--gray-500);">
                                        {{ ucfirst($curso->nivel) }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-primary">{{ ucfirst($curso->nivel) }}</span>
                        </td>
                        <td style="color: var(--gray-600);">
                            @if($curso->profesor)
                                <div style="font-weight: 500;">{{ $curso->profesor->nombre }} {{ $curso->profesor->apellido }}</div>
                            @else
                                <span style="color: var(--gray-400);">Sin profesor asignado</span>
                            @endif
                        </td>
                        <td>
                            <div style="display: flex; align-items: center; gap: var(--spacing-xs);">
                                <i class="fas fa-users" style="color: var(--theme-color);"></i>
                                <span style="font-weight: 600; color: var(--gray-900);">{{ $curso->estudiantes_count ?? 0 }}</span>
                            </div>
                        </td>
                        <td>
                            <div style="display: flex; align-items: center; gap: var(--spacing-xs);">
                                <i class="fas fa-book" style="color: var(--theme-color);"></i>
                                <span style="font-weight: 600; color: var(--gray-900);">{{ $curso->asignaturas_count ?? 0 }}</span>
                            </div>
                        </td>
                        <td>
                            <div style="display: flex; gap: var(--spacing-sm);" onclick="event.stopPropagation();">
                                <a href="{{ route('courses.edit', $curso->id) }}" class="btn btn-ghost btn-sm"
                                    title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('courses.destroy', $curso->id) }}" method="POST"
                                    style="display: inline;"
                                    onsubmit="return confirm('¿Está seguro de eliminar este curso?');">
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
                            <i class="fas fa-graduation-cap"
                                style="font-size: 3rem; margin-bottom: var(--spacing-md); opacity: 0.3;"></i>
                            <p style="margin: 0; font-size: 1.125rem;">No hay cursos registrados</p>
                            <p style="margin: var(--spacing-sm) 0 0 0; font-size: 0.875rem;">Haz clic en "Nuevo Curso"
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
            <p style="color: var(--gray-600); margin: 0;">No se encontraron cursos que coincidan con tu búsqueda</p>
        </div>
    </div>

    <script>
        // Real-time search and filter functionality
        const searchInput = document.getElementById('searchInput');
        const searchInputMobile = document.getElementById('searchInputMobile');
        const nivelFilter = document.getElementById('nivelFilter');
        const profesorFilter = document.getElementById('profesorFilter');
        const nivelFilterMobile = document.getElementById('nivelFilterMobile');
        const profesorFilterMobile = document.getElementById('profesorFilterMobile');
        const noResults = document.getElementById('noResults');
        const filterBadge = document.getElementById('filterBadge');
        
        function filterCursos() {
            const searchTerm = (searchInput?.value || searchInputMobile?.value || '').toLowerCase();
            const selectedNivel = (nivelFilter?.value || nivelFilterMobile?.value || '').toLowerCase();
            const selectedProfesor = profesorFilter?.value || profesorFilterMobile?.value || '';
            
            const items = document.querySelectorAll('.curso-item');
            let visibleCount = 0;
            
            items.forEach(item => {
                const searchText = item.dataset.search || '';
                const nivel = item.dataset.nivel || '';
                const profesor = item.dataset.profesor || '';
                
                const matchesSearch = searchText.includes(searchTerm);
                const matchesNivel = !selectedNivel || nivel === selectedNivel;
                const matchesProfesor = !selectedProfesor || profesor === selectedProfesor;
                
                if (matchesSearch && matchesNivel && matchesProfesor) {
                    item.style.display = '';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });
            
            // Show/hide no results message
            if (noResults) {
                noResults.style.display = visibleCount === 0 ? 'block' : 'none';
            }
            
            // Update filter badge
            updateFilterBadge();
        }
        
        function updateFilterBadge() {
            const searchValue = searchInput?.value || searchInputMobile?.value || '';
            const nivelValue = nivelFilter?.value || nivelFilterMobile?.value || '';
            const profesorValue = profesorFilter?.value || profesorFilterMobile?.value || '';
            const activeFilters = (searchValue ? 1 : 0) + (nivelValue ? 1 : 0) + (profesorValue ? 1 : 0);
            
            const filterBadgeMobile = document.getElementById('filterBadgeMobile');
            
            // Update both badges
            [filterBadge, filterBadgeMobile].forEach(badge => {
                if (badge) {
                    if (activeFilters > 0) {
                        badge.textContent = activeFilters;
                        badge.style.display = 'flex';
                    } else {
                        badge.style.display = 'none';
                    }
                }
            });
            
            // Show/hide desktop clear button
            const clearFiltersBtn = document.getElementById('clearFiltersBtn');
            if (clearFiltersBtn) {
                clearFiltersBtn.style.display = activeFilters > 0 ? 'block' : 'none';
            }
        }
        
        // Sync search between desktop and mobile
        if (searchInput && searchInputMobile) {
            searchInput.addEventListener('input', () => {
                searchInputMobile.value = searchInput.value;
                filterCursos();
            });
            searchInputMobile.addEventListener('input', () => {
                searchInput.value = searchInputMobile.value;
                filterCursos();
            });
        }
        
        // Add event listeners for desktop filters
        if (nivelFilter) nivelFilter.addEventListener('change', filterCursos);
        if (profesorFilter) profesorFilter.addEventListener('change', filterCursos);
        
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
            // Sync mobile filters to desktop
            if (nivelFilter && nivelFilterMobile) {
                nivelFilter.value = nivelFilterMobile.value;
            }
            if (profesorFilter && profesorFilterMobile) {
                profesorFilter.value = profesorFilterMobile.value;
            }
            
            filterCursos();
            closeFiltersModal();
        }
        
        function clearFilters() {
            // Clear mobile filters
            const searchInputMobile = document.getElementById('searchInputMobile');
            const nivelFilterMobile = document.getElementById('nivelFilterMobile');
            const profesorFilterMobile = document.getElementById('profesorFilterMobile');
            
            if (searchInputMobile) searchInputMobile.value = '';
            if (nivelFilterMobile) nivelFilterMobile.value = '';
            if (profesorFilterMobile) profesorFilterMobile.value = '';
            
            // Clear desktop filters
            const searchInput = document.getElementById('searchInput');
            const nivelFilter = document.getElementById('nivelFilter');
            const profesorFilter = document.getElementById('profesorFilter');
            
            if (searchInput) searchInput.value = '';
            if (nivelFilter) nivelFilter.value = '';
            if (profesorFilter) profesorFilter.value = '';
            
            // Apply the cleared filters
            filterCursos();
            closeFiltersModal();
        }
        
        // Close modal on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeFiltersModal();
            }
        });
        
        // Initialize filter badge
        updateFilterBadge();
    </script>
</x-app-layout>