<x-app-layout>
    <x-slot name="header">
        Detalle de Nota
    </x-slot>

    <!-- Header -->
    <div style="display: flex; align-items: center; gap: var(--spacing-md); margin-bottom: var(--spacing-xl);">
        <a href="{{ route('grades.index') }}" class="btn btn-ghost">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--gray-900); margin: 0;">
                <i class="fas fa-graduation-cap"></i> Detalle de Nota
            </h2>
            <p style="color: var(--gray-500); margin: 0; font-size: 0.875rem;">
                Registro #{{ $nota->id }}
            </p>
        </div>
        <div style="margin-left: auto;">
            <a href="{{ route('grades.edit', $nota->id) }}" class="btn btn-primary" style="color: white;">
                <i class="fas fa-edit"></i> Editar
            </a>
        </div>
    </div>

    <div class="grid grid-cols-2" style="gap: var(--spacing-xl);">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Información de la Nota</h3>
            </div>
            <div class="card-body">
                @php
                    $n = (float) $nota->nota;
                    $color = $n >= 6.0 ? 'var(--success)' : ($n >= 5.0 ? '#0ea5e9' : ($n >= 4.0 ? 'var(--warning)' : 'var(--error)'));
                    $estadoLabel = $n >= 4.0 ? 'Aprobado' : 'Reprobado';
                    $estadoClass = $n >= 4.0 ? 'badge-success' : 'badge-danger';
                @endphp

                <div
                    style="text-align: center; padding: var(--spacing-2xl); background: var(--gray-50); border-radius: var(--radius-xl); margin-bottom: var(--spacing-xl);">
                    <div style="font-size: 4rem; font-weight: 900; color: {{ $color }}; line-height: 1;">
                        {{ number_format($nota->nota, 1) }}
                    </div>
                    <div style="margin-top: var(--spacing-sm);">
                        <span class="badge {{ $estadoClass }}" style="font-size: 0.9rem; padding: 6px 16px;">
                            {{ $estadoLabel }}
                        </span>
                    </div>
                    <div style="margin-top: var(--spacing-md); color: var(--gray-500); font-size: 0.875rem;">
                        Ponderación: <strong>{{ round($nota->ponderacion * 100) }}%</strong>
                    </div>
                </div>

                <dl style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--spacing-md);">
                    <div>
                        <dt
                            style="font-size: 0.75rem; font-weight: 600; color: var(--gray-500); text-transform: uppercase; margin-bottom: 4px;">
                            Tipo Evaluación</dt>
                        <dd style="font-weight: 600; color: var(--gray-900);">{{ $nota->tipo_evaluacion }}</dd>
                    </div>
                    <div>
                        <dt
                            style="font-size: 0.75rem; font-weight: 600; color: var(--gray-500); text-transform: uppercase; margin-bottom: 4px;">
                            Período</dt>
                        <dd style="font-weight: 600; color: var(--gray-900);">{{ $nota->periodo }}</dd>
                    </div>
                    <div>
                        <dt
                            style="font-size: 0.75rem; font-weight: 600; color: var(--gray-500); text-transform: uppercase; margin-bottom: 4px;">
                            Fecha</dt>
                        <dd style="font-weight: 600; color: var(--gray-900);">
                            {{ $nota->fecha ? $nota->fecha->format('d/m/Y') : '–' }}</dd>
                    </div>
                    <div>
                        <dt
                            style="font-size: 0.75rem; font-weight: 600; color: var(--gray-500); text-transform: uppercase; margin-bottom: 4px;">
                            Registrado</dt>
                        <dd style="font-weight: 600; color: var(--gray-900);">
                            {{ $nota->created_at->format('d/m/Y H:i') }}</dd>
                    </div>
                </dl>

                @if($nota->observaciones)
                    <div
                        style="margin-top: var(--spacing-lg); padding: var(--spacing-md); background: #fffbeb; border: 1px solid #fde68a; border-radius: var(--radius-md);">
                        <div
                            style="font-size: 0.75rem; font-weight: 600; color: #92400e; text-transform: uppercase; margin-bottom: 4px;">
                            <i class="fas fa-comment-alt"></i> Observaciones
                        </div>
                        <div style="color: #78350f; font-size: 0.875rem;">{{ $nota->observaciones }}</div>
                    </div>
                @endif
            </div>
        </div>

        <div style="display: flex; flex-direction: column; gap: var(--spacing-xl);">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Estudiante</h3>
                </div>
                <div class="card-body">
                    <div style="display: flex; align-items: center; gap: var(--spacing-md);">
                        <div
                            style="width: 56px; height: 56px; border-radius: 50%; background: #84cc16; display: flex; align-items: center; justify-content: center; color: white; font-weight: 800; font-size: 1.25rem; flex-shrink: 0;">
                            {{ strtoupper(substr($nota->estudiante->nombre ?? '?', 0, 1) . substr($nota->estudiante->apellido ?? '?', 0, 1)) }}
                        </div>
                        <div>
                            <div style="font-weight: 700; font-size: 1.1rem; color: var(--gray-900);">
                                {{ $nota->estudiante->nombre ?? '–' }} {{ $nota->estudiante->apellido ?? '' }}
                            </div>
                            <div style="color: var(--gray-500); font-size: 0.875rem;">{{ $nota->estudiante->rut ?? '' }}
                            </div>
                            <div style="color: var(--gray-500); font-size: 0.875rem;">
                                {{ $nota->estudiante->email ?? '' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Contexto Académico</h3>
                </div>
                <div class="card-body">
                    <dl style="display: grid; gap: var(--spacing-md);">
                        <div>
                            <dt
                                style="font-size: 0.75rem; font-weight: 600; color: var(--gray-500); text-transform: uppercase; margin-bottom: 4px;">
                                <i class="fas fa-chalkboard"></i> Curso</dt>
                            <dd style="font-weight: 700; color: var(--gray-900);">{{ $nota->curso->nombre ?? '–' }}</dd>
                        </div>
                        <div>
                            <dt
                                style="font-size: 0.75rem; font-weight: 600; color: var(--gray-500); text-transform: uppercase; margin-bottom: 4px;">
                                <i class="fas fa-book"></i> Asignatura</dt>
                            <dd style="font-weight: 700; color: var(--gray-900);">{{ $nota->asignatura->nombre ?? '–' }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <div style="display: flex; gap: var(--spacing-md);">
                <a href="{{ route('grades.edit', $nota->id) }}" class="btn btn-primary"
                    style="color: white; flex: 1; text-align: center;">
                    <i class="fas fa-edit"></i> Editar Nota
                </a>
                <form action="{{ route('grades.destroy', $nota->id) }}" method="POST"
                    onsubmit="return confirm('¿Seguro que deseas eliminar esta nota?')" style="flex: 1;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline"
                        style="width: 100%; border-color: var(--error); color: var(--error);">
                        <i class="fas fa-trash"></i> Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>