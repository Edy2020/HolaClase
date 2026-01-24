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

            /* Hide table on mobile, show cards */
            .table-container {
                display: none !important;
            }

            .mobile-cards {
                display: block !important;
            }
        }

        /* Desktop: Show table, hide cards */
        @media (min-width: 769px) {
            .mobile-cards {
                display: none !important;
            }

            .table-container {
                display: block !important;
            }
        }
    </style>

    <!-- Search -->
    <div class="card mb-xl" style="border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
        <div class="card-body" style="padding: var(--spacing-lg);">
            <div class="form-group mb-0" style="position: relative;">
                <div style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--gray-400); font-size: 1.125rem;">
                    <i class="fas fa-search"></i>
                </div>
                <input type="text" id="searchInput" class="form-input" 
                    placeholder="Buscar por nombre o código..." 
                    style="padding-left: 40px; border: 2px solid var(--gray-200); border-radius: var(--radius-lg); transition: all 0.2s; font-size: 0.9375rem;"
                    onfocus="this.style.borderColor='var(--theme-color)'; this.style.boxShadow='0 0 0 3px rgba(139, 92, 246, 0.1)'"
                    onblur="this.style.borderColor='var(--gray-200)'; this.style.boxShadow='none'">
            </div>
        </div>
    </div>

    <!-- No Results Message (hidden by default) -->
    <div id="noResults" class="card mb-xl" style="display: none;">
        <div class="card-body text-center" style="padding: var(--spacing-2xl);">
            <i class="fas fa-search" style="font-size: 3rem; color: var(--gray-300); margin-bottom: var(--spacing-md);"></i>
            <p style="color: var(--gray-600); margin: 0;">No se encontraron asignaturas que coincidan con tu búsqueda</p>
        </div>
    </div>

    <!-- Mobile Cards View (hidden on desktop) -->
    <div class="mobile-cards" style="display: none;">
        @forelse($asignaturas as $asignatura)
            <div class="card mb-md asignatura-item" style="cursor: pointer;" onclick="window.location='{{ route('subjects.show', $asignatura->id) }}'" 
                data-search="{{ strtolower($asignatura->nombre . ' ' . $asignatura->codigo) }}">
                <div style="display: flex; align-items: center; gap: var(--spacing-md); margin-bottom: var(--spacing-md);">
                    <div style="width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, var(--theme-color), var(--theme-dark)); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700;">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <div style="flex: 1;">
                        <div style="font-weight: 700; color: var(--gray-900); font-size: 1.125rem;">{{ $asignatura->nombre }}</div>
                        <span class="badge badge-primary" style="margin-top: var(--spacing-xs);">{{ $asignatura->codigo }}</span>
                    </div>
                </div>
                
                <div style="padding: var(--spacing-md); background: var(--gray-50); border-radius: var(--radius-md); margin-bottom: var(--spacing-md);">
                    <div style="font-size: 0.75rem; color: var(--gray-500); text-transform: uppercase; margin-bottom: var(--spacing-xs);">Descripción</div>
                    <div style="color: var(--gray-700); font-size: 0.875rem;">{{ $asignatura->descripcion ? Str::limit($asignatura->descripcion, 100) : 'Sin descripción' }}</div>
                </div>

                <div style="display: flex; gap: var(--spacing-sm);" onclick="event.stopPropagation();">
                    <a href="{{ route('subjects.edit', $asignatura->id) }}" class="btn btn-primary btn-sm" style="flex: 1; color: white;">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <form action="{{ route('subjects.destroy', $asignatura->id) }}" method="POST" style="flex: 1;" onsubmit="return confirm('¿Está seguro de eliminar esta asignatura?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline btn-sm" style="width: 100%; color: var(--error); border-color: var(--error);">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="card text-center" style="padding: var(--spacing-2xl);">
                <i class="fas fa-book-open" style="font-size: 3rem; margin-bottom: var(--spacing-md); opacity: 0.3; color: var(--gray-300);"></i>
                <p style="margin: 0; font-size: 1.125rem; color: var(--gray-500);">No hay asignaturas registradas</p>
                <p style="margin: var(--spacing-sm) 0 0 0; font-size: 0.875rem; color: var(--gray-500);">Haz clic en "Nueva Asignatura" para comenzar</p>
            </div>
        @endforelse
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

    <!-- Pagination -->
    @if($asignaturas->hasPages())
        <div style="margin-top: var(--spacing-xl);">
            {{ $asignaturas->links() }}
        </div>
    @endif

    <script>
        // Real-time search functionality
        const searchInput = document.getElementById('searchInput');
        const noResults = document.getElementById('noResults');
        
        function filterAsignaturas() {
            const searchTerm = searchInput.value.toLowerCase();
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
            
            noResults.style.display = visibleCount === 0 ? 'block' : 'none';
        }
        
        searchInput.addEventListener('input', filterAsignaturas);
    </script>
</x-app-layout>