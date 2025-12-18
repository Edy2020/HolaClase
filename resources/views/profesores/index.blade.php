<x-app-layout>
    <x-slot name="header">
        Gestión de Profesores
    </x-slot>

    <!-- Hero Header -->
    <div
        style="background: var(--theme-dark); color: white; padding: var(--spacing-2xl); border-radius: var(--radius-xl); margin-bottom: var(--spacing-2xl); box-shadow: var(--shadow-lg); display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2 style="color: white; font-size: 1.75rem; font-weight: 700; margin-bottom: var(--spacing-sm);">
                <i class="fas fa-chalkboard-teacher"></i> Profesores
            </h2>
            <p style="font-size: 1rem; opacity: 0.95; margin: 0;">
                Administra el personal docente de la institución
            </p>
        </div>
        <a href="{{ route('teachers.create') }}" class="btn btn-primary"
            style="background: white; color: var(--theme-dark); flex-shrink: 0;">
            <span><i class="fas fa-plus"></i></span>
            <span>Nuevo Profesor</span>
        </a>
    </div>

    <!-- Search and Filters -->
    <div class="card mb-xl">
        <div class="card-body">
            <div class="grid grid-cols-4">
                <div class="form-group mb-0">
                    <input type="text" class="form-input" placeholder="🔍 Buscar profesores...">
                </div>
                <div class="form-group mb-0">
                    <select class="form-select">
                        <option>Todas las especialidades</option>
                        <option>Matemáticas</option>
                        <option>Ciencias</option>
                        <option>Humanidades</option>
                        <option>Artes</option>
                    </select>
                </div>
                <div class="form-group mb-0">
                    <select class="form-select">
                        <option>Todos los estados</option>
                        <option>Activo</option>
                        <option>Inactivo</option>
                        <option>Licencia</option>
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

    <!-- Statistics -->
    <div class="grid grid-cols-4 mb-xl">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-school"></i>
            </div>
            <div class="stat-value">15</div>
            <div class="stat-label">Total Profesores</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-check"></i>
            </div>
            <div class="stat-value">13</div>
            <div class="stat-label">Activos</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-book"></i>
            </div>
            <div class="stat-value">24</div>
            <div class="stat-label">Asignaturas Asignadas</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-star"></i>
            </div>
            <div class="stat-value">4.7</div>
            <div class="stat-label">Calificación Promedio</div>
        </div>
    </div>

    <!-- Teachers Grid -->
    <div class="grid grid-cols-3">
        @forelse ($profesores as $profesor)
            <!-- Teacher Card -->
            <div class="card">
                <div style="text-align: center; margin-bottom: var(--spacing-lg);">
                    <div
                        style="width: 100px; height: 100px; margin: 0 auto var(--spacing-md); border-radius: var(--radius-full); background: var(--theme-color); display: flex; align-items: center; justify-content: center; color: white; font-size: 2.5rem; font-weight: 700; box-shadow: var(--shadow-lg);">
                        {{ substr($profesor->nombre, 0, 1) . substr($profesor->apellido, 0, 1) }}
                    </div>
                    <h3
                        style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900); margin-bottom: var(--spacing-xs);">
                        {{ $profesor->nombre }} {{ $profesor->apellido }}
                    </h3>
                    <p style="color: var(--gray-600); font-size: 0.875rem; margin-bottom: var(--spacing-xs);">
                        {{ $profesor->rut }}
                    </p>
                    <p style="color: var(--gray-600); font-size: 0.875rem; margin-bottom: var(--spacing-md);">
                        {{ $profesor->email }}
                    </p>
                    <span class="badge badge-success">Activo</span>
                </div>

                <div
                    style="padding: var(--spacing-md); background: var(--gray-50); border-radius: var(--radius-md); margin-bottom: var(--spacing-lg);">
                    <div style="display: flex; justify-content: space-between; margin-bottom: var(--spacing-sm);">
                        <span style="color: var(--gray-600); font-size: 0.875rem;">Especialidad:</span>
                        <span
                            style="font-weight: 600; color: var(--gray-900);">{{ $profesor->especialidad ?? 'N/A' }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: var(--spacing-sm);">
                        <span style="color: var(--gray-600); font-size: 0.875rem;">Teléfono:</span>
                        <span style="font-weight: 600; color: var(--theme-color);">{{ $profesor->telefono ?? 'N/A' }}</span>
                    </div>
                </div>

                <div style="display: flex; flex-direction: column; gap: var(--spacing-sm);">
                    <a href="{{ route('teachers.edit', $profesor) }}" class="btn btn-primary btn-sm"
                        style="flex: 1; text-align: center;">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <form action="{{ route('teachers.destroy', $profesor) }}" method="POST"
                        onsubmit="return confirm('¿Estás seguro de querer eliminar este profesor?');"
                        style="display: block; width: 100%;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline btn-sm"
                            style="width: 100%; color: #ef4444; border-color: #ef4444;">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-12">
                <div style="margin-bottom: var(--spacing-md); font-size: 3rem; color: var(--gray-300);">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--gray-700);">No hay profesores registrados</h3>
                <p style="color: var(--gray-500);">Comienza agregando un nuevo profesor al sistema.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div
        style="display: flex; justify-content: center; align-items: center; gap: var(--spacing-md); margin-top: var(--spacing-2xl);">
        <button class="btn btn-ghost btn-sm">← Anterior</button>
        <div style="display: flex; gap: var(--spacing-xs);">
            <button class="btn btn-primary btn-sm">1</button>
            <button class="btn btn-ghost btn-sm">2</button>
        </div>
        <button class="btn btn-ghost btn-sm">Siguiente →</button>
    </div>
</x-app-layout>