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

            /* Table responsive */
            .table-container {
                overflow-x: auto !important;
            }

            .table {
                font-size: 0.875rem !important;
            }

            .table th,
            .table td {
                padding: var(--spacing-sm) !important;
            }

            /* Hide some columns on mobile */
            .table th:nth-child(3),
            .table td:nth-child(3),
            .table th:nth-child(5),
            .table td:nth-child(5) {
                display: none !important;
            }
        }
    </style>

    <!-- Teachers Table -->
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