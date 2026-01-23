<x-app-layout>
    <x-slot name="header">
        Gestión de Profesores
    </x-slot>

    <!-- Hero Header -->
    <div class="hero-header"
        style="background: var(--theme-dark); color: white; padding: var(--spacing-2xl); border-radius: var(--radius-xl); margin-bottom: var(--spacing-2xl); box-shadow: var(--shadow-lg); display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2 style="color: white; font-size: 1.75rem; font-weight: 700; margin-bottom: var(--spacing-sm);">
                <i class="fas fa-chalkboard-teacher"></i> Profesores
            </h2>
            <p class="hero-description" style="font-size: 1rem; opacity: 0.95; margin: 0;">
                Administra el personal docente de la institución
            </p>
        </div>
        <div class="hero-actions" style="display: flex; gap: var(--spacing-md); align-items: center;">
            <a href="{{ route('teachers.create') }}" class="btn btn-primary btn-new-teacher"
                style="background: white; color: var(--theme-dark); flex-shrink: 0;">
                <span><i class="fas fa-plus"></i></span>
                <span class="btn-text">Nuevo Profesor</span>
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

            .btn-new-teacher {
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

    <!-- Mobile Cards View (hidden on desktop) -->
    <div class="mobile-cards" style="display: none;">
        @forelse($profesores as $profesor)
            <div class="card mb-md" style="cursor: pointer;" onclick="window.location='{{ route('teachers.show', $profesor->id) }}'">
                <div style="display: flex; align-items: center; gap: var(--spacing-md); margin-bottom: var(--spacing-md);">
                    <div style="width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, var(--theme-color), var(--theme-dark)); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 1rem;">
                        {{ strtoupper(substr($profesor->nombre, 0, 1) . substr($profesor->apellido, 0, 1)) }}
                    </div>
                    <div style="flex: 1;">
                        <div style="font-weight: 700; color: var(--gray-900); font-size: 1.125rem;">{{ $profesor->nombre }} {{ $profesor->apellido }}</div>
                        <div style="font-size: 0.875rem; color: var(--gray-500);">{{ $profesor->rut }}</div>
                    </div>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr; gap: var(--spacing-md); margin-bottom: var(--spacing-md); padding: var(--spacing-md); background: var(--gray-50); border-radius: var(--radius-md);">
                    <div>
                        <div style="font-size: 0.75rem; color: var(--gray-500); text-transform: uppercase; margin-bottom: var(--spacing-xs);">Email</div>
                        <div style="font-weight: 600; color: var(--gray-900); font-size: 0.875rem; word-break: break-word;">{{ $profesor->email ?? 'Sin email' }}</div>
                    </div>
                    <div>
                        <div style="font-size: 0.75rem; color: var(--gray-500); text-transform: uppercase; margin-bottom: var(--spacing-xs);">Nivel</div>
                        <div>
                            @if($profesor->nivel_ensenanza)
                                <span class="badge badge-primary">{{ $profesor->nivel_ensenanza }}</span>
                            @else
                                <span class="badge">Sin nivel</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div style="display: flex; gap: var(--spacing-sm);" onclick="event.stopPropagation();">
                    <a href="{{ route('teachers.edit', $profesor->id) }}" class="btn btn-primary btn-sm" style="flex: 1; color: white;">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <form action="{{ route('teachers.destroy', $profesor->id) }}" method="POST" style="flex: 1;" onsubmit="return confirm('¿Está seguro de eliminar este profesor?');">
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
                <i class="fas fa-chalkboard-teacher" style="font-size: 3rem; margin-bottom: var(--spacing-md); opacity: 0.3; color: var(--gray-300);"></i>
                <p style="margin: 0; font-size: 1.125rem; color: var(--gray-500);">No hay profesores registrados</p>
                <p style="margin: var(--spacing-sm) 0 0 0; font-size: 0.875rem; color: var(--gray-500);">Haz clic en "Nuevo Profesor" para comenzar</p>
            </div>
        @endforelse
    </div>

    <!-- Desktop Table View (hidden on mobile) -->
    <div class="table-container">
        <table class="table">
            <thead>
                <tr style="background: var(--theme-dark);">
                    <th style="color: white !important;">Profesor</th>
                    <th style="color: white !important;">Email</th>
                    <th style="color: white !important;">Teléfono</th>
                    <th style="color: white !important;">Nivel</th>
                    <th style="color: white !important;">Título</th>
                    <th style="color: white !important;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($profesores as $profesor)
                    <tr style="cursor: pointer;" onclick="window.location='{{ route('teachers.show', $profesor->id) }}'">
                        <td>
                            <div style="display: flex; align-items: center; gap: var(--spacing-md);">
                                <div
                                    style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, var(--theme-color), var(--theme-dark)); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700;">
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
                                <span class="badge badge-primary">{{ $profesor->nivel_ensenanza }}</span>
                            @else
                                <span class="badge">Sin nivel</span>
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
</x-app-layout>