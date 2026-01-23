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
            .table th:nth-child(4),
            .table td:nth-child(4),
            .table th:nth-child(5),
            .table td:nth-child(5) {
                display: none !important;
            }
        }
    </style>

    <!-- Students Table -->
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
                    <tr style="cursor: pointer;" onclick="window.location='{{ route('students.show', $estudiante->id) }}'">
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
    </div>
</x-app-layout>