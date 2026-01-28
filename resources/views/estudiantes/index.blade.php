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

    <!-- Search and Filters -->
    <div class="card mb-xl" style="border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
        <div class="card-body" style="padding: var(--spacing-lg);">
            <div class="grid" style="grid-template-columns: 2fr 1fr 1fr; gap: var(--spacing-md); align-items: center;">
                <!-- Search Input -->
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
                
                <!-- Curso Filter -->
                <div class="form-group mb-0" style="position: relative;">
                    <div style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--gray-400); font-size: 1rem; pointer-events: none; z-index: 1;">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <select id="cursoFilter" class="form-select" 
                        style="padding-left: 40px; border: 2px solid var(--gray-200); border-radius: var(--radius-lg); transition: all 0.2s; font-size: 0.9375rem; cursor: pointer;"
                        onfocus="this.style.borderColor='var(--theme-color)'; this.style.boxShadow='0 0 0 3px rgba(139, 92, 246, 0.1)'"
                        onblur="this.style.borderColor='var(--gray-200)'; this.style.boxShadow='none'">
                        <option value="">Todos los cursos</option>
                        @foreach($estudiantes->pluck('curso_actual')->filter()->unique('id') as $curso)
                            <option value="{{ $curso->id }}">{{ $curso->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Estado Filter -->
                <div class="form-group mb-0" style="position: relative;">
                    <div style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--gray-400); font-size: 1rem; pointer-events: none; z-index: 1;">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <select id="estadoFilter" class="form-select" 
                        style="padding-left: 40px; border: 2px solid var(--gray-200); border-radius: var(--radius-lg); transition: all 0.2s; font-size: 0.9375rem; cursor: pointer;"
                        onfocus="this.style.borderColor='var(--theme-color)'; this.style.boxShadow='0 0 0 3px rgba(139, 92, 246, 0.1)'"
                        onblur="this.style.borderColor='var(--gray-200)'; this.style.boxShadow='none'">
                        <option value="">Todos los estados</option>
                        <option value="activo">Activo</option>
                        <option value="inactivo">Inactivo</option>
                        <option value="retirado">Retirado</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Cards View (hidden on desktop) -->
    <div class="mobile-cards" style="display: none;">
        @forelse($estudiantes as $estudiante)
            <div class="card mb-md estudiante-item" style="cursor: pointer;" onclick="window.location='{{ route('students.show', $estudiante->id) }}'" 
                data-search="{{ strtolower($estudiante->nombre . ' ' . $estudiante->apellido . ' ' . $estudiante->rut) }}"
                data-curso="{{ $estudiante->curso_actual->id ?? '' }}"
                data-estado="{{ $estudiante->estado }}">
                <div style="display: flex; align-items: center; gap: var(--spacing-md); margin-bottom: var(--spacing-md);">
                    <div style="width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, var(--theme-color), var(--theme-dark)); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 1rem;">
                        {{ strtoupper(substr($estudiante->nombre, 0, 1) . substr($estudiante->apellido, 0, 1)) }}
                    </div>
                    <div style="flex: 1;">
                        <div style="font-weight: 700; color: var(--gray-900); font-size: 1.125rem;">{{ $estudiante->nombre_completo }}</div>
                        <div style="font-size: 0.875rem; color: var(--gray-500);">{{ $estudiante->rut }}</div>
                    </div>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--spacing-md); margin-bottom: var(--spacing-md); padding: var(--spacing-md); background: var(--gray-50); border-radius: var(--radius-md);">
                    <div>
                        <div style="font-size: 0.75rem; color: var(--gray-500); text-transform: uppercase; margin-bottom: var(--spacing-xs);">Curso</div>
                        <div style="font-weight: 600; color: var(--gray-900); font-size: 0.875rem;">
                            @if($estudiante->curso_actual)
                                {{ $estudiante->curso_actual->nombre }}
                            @else
                                Sin curso
                            @endif
                        </div>
                    </div>
                    <div>
                        <div style="font-size: 0.75rem; color: var(--gray-500); text-transform: uppercase; margin-bottom: var(--spacing-xs);">Estado</div>
                        <div>
                            @if($estudiante->estado === 'activo')
                                <span class="badge badge-success">Activo</span>
                            @else
                                <span class="badge badge-warning">{{ ucfirst($estudiante->estado) }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div style="display: flex; gap: var(--spacing-sm);" onclick="event.stopPropagation();">
                    <a href="{{ route('students.edit', $estudiante->id) }}" class="btn btn-primary btn-sm" style="flex: 1; color: white;">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <form action="{{ route('students.destroy', $estudiante->id) }}" method="POST" style="flex: 1;" onsubmit="return confirm('¿Está seguro de eliminar este estudiante?');">
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
                <i class="fas fa-users" style="font-size: 3rem; margin-bottom: var(--spacing-md); opacity: 0.3; color: var(--gray-300);"></i>
                <p style="margin: 0; font-size: 1.125rem; color: var(--gray-500);">No hay estudiantes registrados</p>
                <p style="margin: var(--spacing-sm) 0 0 0; font-size: 0.875rem; color: var(--gray-500);">Haz clic en "Nuevo Estudiante" para comenzar</p>
            </div>
        @endforelse
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
        }
        
        searchInput.addEventListener('input', filterEstudiantes);
        cursoFilter.addEventListener('change', filterEstudiantes);
        estadoFilter.addEventListener('change', filterEstudiantes);
    </script>
</x-app-layout>