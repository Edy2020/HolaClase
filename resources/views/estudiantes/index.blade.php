<x-app-layout>
    <x-slot name="header">
        Gestión de Estudiantes
    </x-slot>

    <!-- Header Actions -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-2xl);">
        <div>
            <h2 style="font-size: 1.75rem; font-weight: 700; color: var(--gray-900); margin-bottom: var(--spacing-xs);">
                <i class="fas fa-users"></i> Estudiantes
            </h2>
            <p style="color: var(--gray-600); margin: 0;">
                Gestiona la información de todos tus estudiantes
            </p>
        </div>
        <a href="{{ route('students.create') }}" class="btn btn-primary">
            <span>➕</span>
            <span>Nuevo Estudiante</span>
        </a>
    </div>

    <!-- Search and Filters -->
    <div class="card mb-xl">
        <div class="card-body">
            <div class="grid grid-cols-4">
                <div class="form-group mb-0">
                    <input type="text" class="form-input" placeholder="🔍 Buscar estudiantes...">
                </div>
                <div class="form-group mb-0">
                    <select class="form-select">
                        <option>Todos los cursos</option>
                        <option>Matemáticas Avanzadas</option>
                        <option>Química Orgánica</option>
                        <option>Historia Universal</option>
                    </select>
                </div>
                <div class="form-group mb-0">
                    <select class="form-select">
                        <option>Todos los estados</option>
                        <option>Activo</option>
                        <option>Inactivo</option>
                    </select>
                </div>
                <div class="form-group mb-0">
                    <button class="btn btn-outline" style="width: 100%;">
                        <i class="fas fa-chart-bar"></i> Exportar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Students Table -->
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Estudiante</th>
                    <th>Email</th>
                    <th>Curso Principal</th>
                    <th>Promedio</th>
                    <th>Asistencia</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($estudiantes as $estudiante)
                    <tr>
                        <td style="font-weight: 600; color: var(--gray-900);">
                            #{{ str_pad($estudiante->id, 3, '0', STR_PAD_LEFT) }}</td>
                        <td>
                            <div style="display: flex; align-items: center; gap: var(--spacing-md);">
                                <div
                                    style="width: 40px; height: 40px; border-radius: var(--radius-full); background: linear-gradient(135deg, var(--theme-color), var(--theme-dark)); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700;">
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
                            <div style="display: flex; gap: var(--spacing-sm);">
                                <a href="{{ route('students.show', $estudiante->id) }}" class="btn btn-ghost btn-sm"
                                    title="Ver detalles">
                                    <i class="fas fa-eye"></i>
                                </a>
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
    </td>
    </tr>
    </tbody>
    </table>
    </div>

    <!-- Pagination -->
    <div
        style="display: flex; justify-content: center; align-items: center; gap: var(--spacing-md); margin-top: var(--spacing-xl);">
        <button class="btn btn-ghost btn-sm">← Anterior</button>
        <div style="display: flex; gap: var(--spacing-xs);">
            <button class="btn btn-primary btn-sm">1</button>
            <button class="btn btn-ghost btn-sm">2</button>
            <button class="btn btn-ghost btn-sm">3</button>
            <button class="btn btn-ghost btn-sm">4</button>
        </div>
        <button class="btn btn-ghost btn-sm">Siguiente →</button>
    </div>
</x-app-layout>