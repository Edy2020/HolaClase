<x-app-layout>
    <x-slot name="header">
        Detalle de Asistencia
    </x-slot>

    <!-- Header -->
    <div style="display: flex; align-items: center; gap: var(--spacing-md); margin-bottom: var(--spacing-xl);">
        <a href="{{ route('attendance.index') }}" class="btn btn-ghost">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--gray-900); margin: 0;">
                <i class="fas fa-calendar-check"></i> Registro de Asistencia #{{ $asistencia->id }}
            </h2>
            <p style="color: var(--gray-500); margin: 0; font-size: 0.875rem;">
                {{ $asistencia->fecha ? $asistencia->fecha->format('d/m/Y') : '–' }}
            </p>
        </div>
        <div style="margin-left: auto; display: flex; gap: var(--spacing-sm);">
            <form action="{{ route('attendance.destroy', $asistencia) }}" method="POST"
                  onsubmit="return confirm('¿Eliminar este registro?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline" style="border-color: var(--error); color: var(--error);">
                    <i class="fas fa-trash"></i> Eliminar
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-2" style="gap: var(--spacing-xl);">
        <!-- State Card -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Estado de Asistencia</h3>
            </div>
            <div class="card-body">
                @php
                    $colors = [
                        'presente'    => ['bg' => '#d1fae5', 'text' => '#065f46', 'icon' => 'fa-check-circle',    'border' => '#6ee7b7'],
                        'ausente'     => ['bg' => '#fee2e2', 'text' => '#991b1b', 'icon' => 'fa-times-circle',    'border' => '#fca5a5'],
                        'tarde'       => ['bg' => '#fef3c7', 'text' => '#92400e', 'icon' => 'fa-clock',           'border' => '#fcd34d'],
                        'justificado' => ['bg' => '#dbeafe', 'text' => '#1e40af', 'icon' => 'fa-file-alt',        'border' => '#93c5fd'],
                    ];
                    $c = $colors[$asistencia->estado] ?? ['bg' => '#f3f4f6', 'text' => '#374151', 'icon' => 'fa-question-circle', 'border' => '#d1d5db'];
                @endphp
                <div style="text-align: center; padding: var(--spacing-2xl); background: {{ $c['bg'] }}; border: 2px solid {{ $c['border'] }}; border-radius: var(--radius-xl);">
                    <i class="fas {{ $c['icon'] }}" style="font-size: 3.5rem; color: {{ $c['text'] }}; margin-bottom: var(--spacing-md);"></i>
                    <div style="font-size: 2rem; font-weight: 800; color: {{ $c['text'] }};">{{ $asistencia->estado_label }}</div>
                    <div style="font-size: 0.875rem; color: {{ $c['text'] }}; opacity: 0.7; margin-top: 4px;">
                        {{ $asistencia->fecha ? $asistencia->fecha->format('l, d \d\e F \d\e Y') : '–' }}
                    </div>
                </div>

                @if($asistencia->notas)
                    <div style="margin-top: var(--spacing-lg); padding: var(--spacing-md); background: #fffbeb; border: 1px solid #fde68a; border-radius: var(--radius-md);">
                        <div style="font-size: 0.75rem; font-weight: 600; color: #92400e; text-transform: uppercase; margin-bottom: 4px;">
                            <i class="fas fa-comment-alt"></i> Notas / Observaciones
                        </div>
                        <div style="color: #78350f; font-size: 0.875rem;">{{ $asistencia->notas }}</div>
                    </div>
                @endif

                <div style="display: flex; gap: var(--spacing-md); margin-top: var(--spacing-lg);">
                    <div style="flex: 1; text-align: center; padding: var(--spacing-md); background: var(--gray-50); border-radius: var(--radius-md);">
                        <div style="font-size: 0.7rem; color: var(--gray-500); font-weight: 600; text-transform: uppercase; margin-bottom: 4px;">Registrado</div>
                        <div style="font-size: 0.875rem; font-weight: 600; color: var(--gray-700);">{{ $asistencia->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                    <div style="flex: 1; text-align: center; padding: var(--spacing-md); background: var(--gray-50); border-radius: var(--radius-md);">
                        <div style="font-size: 0.7rem; color: var(--gray-500); font-weight: 600; text-transform: uppercase; margin-bottom: 4px;">Actualizado</div>
                        <div style="font-size: 0.875rem; font-weight: 600; color: var(--gray-700);">{{ $asistencia->updated_at->format('d/m/Y H:i') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Context Card -->
        <div style="display: flex; flex-direction: column; gap: var(--spacing-xl);">
            <!-- Student -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-user-graduate"></i> Estudiante</h3>
                </div>
                <div class="card-body">
                    <div style="display: flex; align-items: center; gap: var(--spacing-md);">
                        <div style="width: 52px; height: 52px; border-radius: 50%; background: linear-gradient(135deg, var(--theme-color), var(--theme-dark)); display: flex; align-items: center; justify-content: center; color: white; font-weight: 800; font-size: 1.1rem; flex-shrink: 0;">
                            {{ strtoupper(substr($asistencia->estudiante->nombre ?? '?', 0, 1) . substr($asistencia->estudiante->apellido ?? '?', 0, 1)) }}
                        </div>
                        <div>
                            <div style="font-weight: 700; font-size: 1.05rem; color: var(--gray-900);">
                                {{ $asistencia->estudiante->nombre ?? '–' }} {{ $asistencia->estudiante->apellido ?? '' }}
                            </div>
                            <div style="font-size: 0.8rem; color: var(--gray-500);">{{ $asistencia->estudiante->rut ?? '' }}</div>
                            <div style="font-size: 0.8rem; color: var(--gray-500);">{{ $asistencia->estudiante->email ?? '' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Academic Context -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-school"></i> Contexto Académico</h3>
                </div>
                <div class="card-body">
                    <dl style="display: grid; gap: var(--spacing-md);">
                        <div>
                            <dt style="font-size: 0.7rem; font-weight: 700; color: var(--gray-400); text-transform: uppercase; margin-bottom: 2px;">CURSO</dt>
                            <dd style="font-weight: 700; color: var(--gray-900); font-size: 1rem;">{{ $asistencia->curso->nombre ?? '–' }}</dd>
                        </div>
                        <div>
                            <dt style="font-size: 0.7rem; font-weight: 700; color: var(--gray-400); text-transform: uppercase; margin-bottom: 2px;">ASIGNATURA</dt>
                            <dd style="font-weight: 700; color: var(--gray-900); font-size: 1rem;">{{ $asistencia->asignatura->nombre ?? '–' }}</dd>
                        </div>
                        <div style="display: flex; gap: var(--spacing-md);">
                            <a href="{{ route('attendance.reporte.estudiante', $asistencia->estudiante_id) }}" class="btn btn-outline" style="flex: 1; text-align: center; font-size: 0.8rem;">
                                <i class="fas fa-user-chart"></i> Reporte Alumno
                            </a>
                            <a href="{{ route('attendance.reporte.curso', $asistencia->curso_id) }}" class="btn btn-outline" style="flex: 1; text-align: center; font-size: 0.8rem;">
                                <i class="fas fa-chalkboard"></i> Reporte Curso
                            </a>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
