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

    <!-- Asignaturas Grid -->
    <div class="grid grid-cols-3"
        style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: var(--spacing-lg);">
        @forelse ($asignaturas as $asignatura)
            <!-- Asignatura Card -->
            <div class="card">
                <div style="text-align: center; margin-bottom: var(--spacing-lg);">
                    <div
                        style="width: 80px; height: 80px; margin: 0 auto var(--spacing-md); border-radius: var(--radius-lg); background: var(--theme-color); display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem; font-weight: 700; box-shadow: var(--shadow-lg);">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <h3
                        style="font-size: 1.125rem; font-weight: 700; color: var(--gray-900); margin-bottom: var(--spacing-xs);">
                        {{ $asignatura->nombre }}
                    </h3>
                    <p style="color: var(--gray-600); font-size: 0.875rem; margin-bottom: var(--spacing-xs);">
                        <i class="fas fa-tag" style="margin-right: var(--spacing-xs);"></i>{{ $asignatura->codigo }}
                    </p>
                    @if($asignatura->descripcion)
                        <p style="color: var(--gray-600); font-size: 0.875rem; margin: var(--spacing-sm) 0; line-height: 1.5;">
                            {{ Str::limit($asignatura->descripcion, 80) }}
                        </p>
                    @endif
                </div>

                <div style="display: flex; gap: var(--spacing-sm);">
                    <a href="{{ route('subjects.edit', $asignatura) }}" class="btn btn-primary btn-sm"
                        style="color: white; flex: 1;">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <form action="{{ route('subjects.destroy', $asignatura) }}" method="POST"
                        onsubmit="return confirm('¿Estás seguro de querer eliminar esta asignatura?');" style="flex: 1;">
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
            <div class="col-span-3" style="grid-column: 1 / -1;">
                <div class="card text-center" style="padding: var(--spacing-2xl); width: 100%;">
                    <div style="margin-bottom: var(--spacing-md); font-size: 3rem; color: var(--gray-300);">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--gray-700);">No hay asignaturas registradas
                    </h3>
                    <p style="color: var(--gray-500); margin-bottom: var(--spacing-lg);">Comienza agregando una nueva
                        asignatura al sistema.</p>
                    <a href="{{ route('subjects.create') }}" class="btn btn-primary" style="color: white;">
                        <i class="fas fa-plus"></i> Crear Primera Asignatura
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($asignaturas->hasPages())
        <div style="margin-top: var(--spacing-xl);">
            {{ $asignaturas->links() }}
        </div>
    @endif

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

            .grid-cols-3 {
                grid-template-columns: 1fr !important;
            }
        }
    </style>
</x-app-layout>