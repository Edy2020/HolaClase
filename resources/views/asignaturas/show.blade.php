<x-app-layout>
    <x-slot name="header">
        Detalle de Asignatura
    </x-slot>

    <!-- Header Section -->
    <div class="card" style="margin-bottom: var(--spacing-xl);">
        <div
            style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: var(--spacing-md);">
            <div>
                <h2
                    style="font-size: 2rem; font-weight: 700; color: var(--gray-900); margin-bottom: var(--spacing-xs);">
                    {{ $asignatura->nombre }}
                </h2>
                <p style="color: var(--gray-600); font-size: 1rem;">
                    <i class="fas fa-barcode"></i> Código: {{ $asignatura->codigo }}
                </p>
                @if($asignatura->descripcion)
                    <p style="color: var(--gray-600); font-size: 0.875rem; margin-top: var(--spacing-sm);">
                        {{ $asignatura->descripcion }}
                    </p>
                @endif
            </div>
            <div style="display: flex; gap: var(--spacing-sm);">
                <a href="{{ route('subjects.edit', $asignatura) }}" class="btn btn-primary" style="color: white;">
                    <i class="fas fa-edit"></i> Editar
                </a>
                <a href="{{ route('subjects.index') }}" class="btn btn-outline">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-3" style="gap: var(--spacing-lg); margin-bottom: var(--spacing-xl);">
        <div class="card" style="text-align: center;">
            <div
                style="font-size: 2.5rem; font-weight: 700; color: var(--theme-color); margin-bottom: var(--spacing-xs);">
                {{ $asignatura->cursos->count() }}
            </div>
            <div style="color: var(--gray-600); font-weight: 600;">Cursos Asignados</div>
        </div>
        <div class="card" style="text-align: center;">
            <div style="font-size: 2.5rem; font-weight: 700; color: var(--success); margin-bottom: var(--spacing-xs);">
                {{ $asignatura->cursos->sum(function ($curso) {
    return $curso->estudiantes->count(); }) }}
            </div>
            <div style="color: var(--gray-600); font-weight: 600;">Total Estudiantes</div>
        </div>
        <div class="card" style="text-align: center;">
            <div style="font-size: 2.5rem; font-weight: 700; color: var(--accent); margin-bottom: var(--spacing-xs);">
                {{ $asignatura->notas->count() }}
            </div>
            <div style="color: var(--gray-600); font-weight: 600;">Notas Registradas</div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-3" style="gap: var(--spacing-xl);">
        <!-- Left Column (2/3 width) -->
        <div style="grid-column: span 2;">
            <!-- Cursos donde se imparte -->
            <div class="card" style="margin-bottom: var(--spacing-xl);">
                <h3
                    style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900); margin-bottom: var(--spacing-lg); display: flex; align-items: center; gap: var(--spacing-sm);">
                    <i class="fas fa-chalkboard" style="color: var(--theme-color);"></i>
                    Cursos donde se imparte
                </h3>

                @if($asignatura->cursos->count() > 0)
                    <div style="display: flex; flex-direction: column; gap: var(--spacing-md);">
                        @foreach($asignatura->cursos as $curso)
                            @php
                                $notasCurso = $asignatura->notas->where('curso_id', $curso->id);
                                $promedio = $notasCurso->count() > 0 ? $notasCurso->avg('nota') : null;
                            @endphp
                            <div
                                style="padding: var(--spacing-lg); background: var(--gray-50); border-radius: var(--radius-lg); border-left: 4px solid var(--accent);">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <div style="flex: 1;">
                                        <div
                                            style="font-weight: 700; font-size: 1.125rem; color: var(--gray-900); margin-bottom: var(--spacing-xs);">
                                            {{ $curso->nombre }}
                                        </div>
                                        <div
                                            style="display: flex; gap: var(--spacing-lg); color: var(--gray-600); font-size: 0.875rem; margin-bottom: var(--spacing-sm);">
                                            <span>
                                                <i class="fas fa-users"></i> {{ $curso->estudiantes->count() }} estudiantes
                                            </span>
                                            <span>
                                                <i class="fas fa-clipboard-check"></i> {{ $notasCurso->count() }} notas
                                            </span>
                                            @if($promedio)
                                                <span>
                                                    <i class="fas fa-chart-line"></i> Promedio:
                                                    <strong
                                                        style="color: {{ $promedio >= 6.0 ? 'var(--success)' : ($promedio >= 4.0 ? 'var(--warning)' : 'var(--error)') }};">
                                                        {{ number_format($promedio, 1) }}
                                                    </strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div style="display: flex; gap: var(--spacing-sm);">
                                            <a href="{{ route('courses.show', $curso->id) }}" class="btn btn-sm btn-outline">
                                                <i class="fas fa-eye"></i> Ver Curso
                                            </a>
                                            <a href="{{ route('grades.create', ['curso_id' => $curso->id, 'asignatura_id' => $asignatura->id]) }}"
                                                class="btn btn-sm btn-primary" style="color: white;">
                                                <i class="fas fa-plus"></i> Agregar Notas
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p style="color: var(--gray-500); text-align: center; padding: var(--spacing-xl);">
                        <i class="fas fa-info-circle"></i> Esta asignatura no está asignada a ningún curso
                    </p>
                @endif
            </div>
        </div>

        <!-- Right Column (1/3 width) -->
        <div>
            <!-- Estadísticas de Notas -->
            <div class="card">
                <h3
                    style="font-size: 1.125rem; font-weight: 700; color: var(--gray-900); margin-bottom: var(--spacing-lg); display: flex; align-items: center; gap: var(--spacing-sm);">
                    <i class="fas fa-chart-bar" style="color: var(--theme-color);"></i>
                    Estadísticas de Notas
                </h3>

                @if($asignatura->notas->count() > 0)
                    <div style="display: flex; flex-direction: column; gap: var(--spacing-md);">
                        <div
                            style="display: flex; justify-content: space-between; padding: var(--spacing-sm) 0; border-bottom: 1px solid var(--gray-100);">
                            <span style="color: var(--gray-600); font-size: 0.875rem;">Total Notas</span>
                            <span style="font-weight: 600; font-size: 0.875rem;">{{ $asignatura->notas->count() }}</span>
                        </div>
                        <div
                            style="display: flex; justify-content: space-between; padding: var(--spacing-sm) 0; border-bottom: 1px solid var(--gray-100);">
                            <span style="color: var(--gray-600); font-size: 0.875rem;">Promedio General</span>
                            <span style="font-weight: 600; font-size: 0.875rem; color: var(--success);">
                                {{ number_format($asignatura->notas->avg('nota'), 1) }}
                            </span>
                        </div>
                        <div
                            style="display: flex; justify-content: space-between; padding: var(--spacing-sm) 0; border-bottom: 1px solid var(--gray-100);">
                            <span style="color: var(--gray-600); font-size: 0.875rem;">Nota Máxima</span>
                            <span style="font-weight: 600; font-size: 0.875rem; color: var(--success);">
                                {{ number_format($asignatura->notas->max('nota'), 1) }}
                            </span>
                        </div>
                        <div
                            style="display: flex; justify-content: space-between; padding: var(--spacing-sm) 0; border-bottom: 1px solid var(--gray-100);">
                            <span style="color: var(--gray-600); font-size: 0.875rem;">Nota Mínima</span>
                            <span style="font-weight: 600; font-size: 0.875rem; color: var(--error);">
                                {{ number_format($asignatura->notas->min('nota'), 1) }}
                            </span>
                        </div>
                        <div
                            style="display: flex; justify-content: space-between; padding: var(--spacing-sm) 0; border-bottom: 1px solid var(--gray-100);">
                            <span style="color: var(--gray-600); font-size: 0.875rem;">Aprobados</span>
                            <span style="font-weight: 600; font-size: 0.875rem; color: var(--success);">
                                {{ $asignatura->notas->where('nota', '>=', 4.0)->count() }}
                            </span>
                        </div>
                        <div style="display: flex; justify-content: space-between; padding: var(--spacing-sm) 0;">
                            <span style="color: var(--gray-600); font-size: 0.875rem;">Reprobados</span>
                            <span style="font-weight: 600; font-size: 0.875rem; color: var(--error);">
                                {{ $asignatura->notas->where('nota', '<', 4.0)->count() }}
                            </span>
                        </div>
                    </div>
                @else
                    <p style="color: var(--gray-500); text-align: center; padding: var(--spacing-lg);">
                        <i class="fas fa-info-circle"></i> No hay notas registradas
                    </p>
                @endif
            </div>
        </div>
    </div>

    <style>
        @media (max-width: 1024px) {
            .grid-cols-3 {
                grid-template-columns: 1fr !important;
            }

            .grid-cols-3>div {
                grid-column: span 1 !important;
            }
        }
    </style>
</x-app-layout>