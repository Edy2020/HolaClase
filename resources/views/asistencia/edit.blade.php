<x-app-layout>
    <x-slot name="header">
        Editar Asistencia
    </x-slot>

    <!-- Header -->
    <div style="display: flex; align-items: center; gap: var(--spacing-md); margin-bottom: var(--spacing-xl);">
        <a href="{{ route('attendance.index') }}" class="btn btn-ghost">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--gray-900); margin: 0;">
                <i class="fas fa-edit"></i> Editar Asistencia
            </h2>
            <p style="color: var(--gray-500); margin: 0; font-size: 0.875rem;">
                {{ $curso->nombre }} — {{ $asignatura->nombre }} — {{ \Carbon\Carbon::parse($fecha)->format('d/m/Y') }}
            </p>
        </div>
    </div>

    <!-- Context Banner -->
    <div style="background: var(--gray-50); border: 1px solid var(--gray-200); border-radius: var(--radius-lg); padding: var(--spacing-lg); margin-bottom: var(--spacing-xl); display: flex; gap: var(--spacing-2xl);">
        <div>
            <div style="font-size: 0.7rem; font-weight: 700; color: var(--gray-400); text-transform: uppercase; margin-bottom: 2px;">CURSO</div>
            <div style="font-weight: 700; color: var(--gray-900);">{{ $curso->nombre }}</div>
        </div>
        <div>
            <div style="font-size: 0.7rem; font-weight: 700; color: var(--gray-400); text-transform: uppercase; margin-bottom: 2px;">ASIGNATURA</div>
            <div style="font-weight: 700; color: var(--gray-900);">{{ $asignatura->nombre }}</div>
        </div>
        <div>
            <div style="font-size: 0.7rem; font-weight: 700; color: var(--gray-400); text-transform: uppercase; margin-bottom: 2px;">FECHA</div>
            <div style="font-weight: 700; color: var(--gray-900);">{{ \Carbon\Carbon::parse($fecha)->format('d \d\e F \d\e Y') }}</div>
        </div>
        <div>
            <div style="font-size: 0.7rem; font-weight: 700; color: var(--gray-400); text-transform: uppercase; margin-bottom: 2px;">ESTUDIANTES</div>
            <div style="font-weight: 700; color: var(--gray-900);">{{ $estudiantes->count() }}</div>
        </div>
    </div>

    @if($errors->any())
        <div style="background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: var(--spacing-md); border-radius: var(--radius-lg); margin-bottom: var(--spacing-xl);">
            @foreach($errors->all() as $error)
                <div><i class="fas fa-exclamation-circle"></i> {{ $error }}</div>
            @endforeach
        </div>
    @endif

    <!-- Bulk actions bar -->
    <div class="card mb-xl">
        <div class="card-body" style="display: flex; align-items: center; gap: var(--spacing-md); flex-wrap: wrap;">
            <span style="font-size: 0.875rem; font-weight: 600; color: var(--gray-700);">Marcar todos como:</span>
            @foreach(['presente' => ['color' => '#10b981', 'icon' => 'fa-check-circle', 'label' => 'Presente'],
                       'ausente'  => ['color' => '#ef4444', 'icon' => 'fa-times-circle', 'label' => 'Ausente'],
                       'tarde'    => ['color' => '#f59e0b', 'icon' => 'fa-clock',        'label' => 'Tarde'],
                       'justificado' => ['color' => '#3b82f6', 'icon' => 'fa-file-alt',  'label' => 'Justificado']] as $estado => $cfg)
                <button type="button" onclick="setAllStatus('{{ $estado }}')"
                    style="padding: 6px 14px; border-radius: var(--radius-md); font-size: 0.8rem; font-weight: 600; cursor: pointer; border: 2px solid {{ $cfg['color'] }}; background: white; color: {{ $cfg['color'] }}; transition: all 0.15s;"
                    onmouseover="this.style.background='{{ $cfg['color'] }}'; this.style.color='white';"
                    onmouseout="this.style.background='white'; this.style.color='{{ $cfg['color'] }}';">
                    <i class="fas {{ $cfg['icon'] }}"></i> {{ $cfg['label'] }}
                </button>
            @endforeach
        </div>
    </div>

    <!-- Edit Form -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-users"></i> Estudiantes ({{ $estudiantes->count() }})</h3>
        </div>
        <div class="card-body" style="padding: 0;">
            <form action="{{ route('attendance.store') }}" method="POST" id="editForm">
                @csrf
                <input type="hidden" name="curso_id" value="{{ $curso->id }}">
                <input type="hidden" name="asignatura_id" value="{{ $asignatura->id }}">
                <input type="hidden" name="fecha" value="{{ $fecha }}">

                <div style="overflow-x: auto;">
                    <table class="table" style="margin: 0;">
                        <thead>
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th>Estudiante</th>
                                <th style="width: 320px; text-align: center;">Estado</th>
                                <th>Observaciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($estudiantes as $index => $estudiante)
                                @php
                                    $existing = $asistencias[$estudiante->id] ?? null;
                                    $currentEstado = $existing?->estado ?? 'presente';
                                @endphp
                                <tr>
                                    <td style="color: var(--gray-400); font-size: 0.8rem;">{{ $index + 1 }}</td>
                                    <td>
                                        <input type="hidden" name="asistencias[{{ $index }}][estudiante_id]" value="{{ $estudiante->id }}">
                                        <div style="display: flex; align-items: center; gap: var(--spacing-sm);">
                                            <div style="width: 34px; height: 34px; border-radius: 50%; background: linear-gradient(135deg, var(--theme-color), var(--theme-dark)); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 0.75rem; flex-shrink: 0;">
                                                {{ strtoupper(substr($estudiante->nombre, 0, 1) . substr($estudiante->apellido, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div style="font-weight: 600; font-size: 0.875rem; color: var(--gray-900);">{{ $estudiante->nombre }} {{ $estudiante->apellido }}</div>
                                                <div style="font-size: 0.75rem; color: var(--gray-500);">{{ $estudiante->rut }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <!-- Toggle buttons for status -->
                                        <div class="status-group" style="display: flex; gap: 4px; justify-content: center;" data-index="{{ $index }}">
                                            @foreach(['presente' => ['color' => '#10b981', 'bg' => '#d1fae5', 'icon' => 'fa-check', 'label' => 'P'],
                                                       'tarde'    => ['color' => '#f59e0b', 'bg' => '#fef3c7', 'icon' => 'fa-clock', 'label' => 'T'],
                                                       'justificado' => ['color' => '#3b82f6', 'bg' => '#dbeafe', 'icon' => 'fa-file-alt', 'label' => 'J'],
                                                       'ausente'  => ['color' => '#ef4444', 'bg' => '#fee2e2', 'icon' => 'fa-times', 'label' => 'A']] as $est => $cfg)
                                                <label style="cursor: pointer;" title="{{ ucfirst($est) }}">
                                                    <input type="radio"
                                                           name="asistencias[{{ $index }}][estado]"
                                                           value="{{ $est }}"
                                                           class="status-radio-{{ $index }}"
                                                           {{ $currentEstado === $est ? 'checked' : '' }}
                                                           style="display: none;"
                                                           onchange="updateStatusButton(this, '{{ $cfg['bg'] }}', '{{ $cfg['color'] }}')">
                                                    <span class="status-btn status-btn-{{ $est }}-{{ $index }}"
                                                          onclick="this.previousElementSibling.click()"
                                                          style="display: inline-flex; align-items: center; gap: 4px; padding: 5px 10px; border-radius: var(--radius-md); font-size: 0.75rem; font-weight: 600; cursor: pointer; transition: all 0.15s; border: 2px solid {{ $currentEstado === $est ? $cfg['color'] : 'var(--gray-200)' }}; background: {{ $currentEstado === $est ? $cfg['bg'] : 'white' }}; color: {{ $currentEstado === $est ? $cfg['color'] : 'var(--gray-500)' }};">
                                                        <i class="fas {{ $cfg['icon'] }}" style="font-size: 0.7rem;"></i> {{ $cfg['label'] }}
                                                    </span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td>
                                        <input type="text"
                                               name="asistencias[{{ $index }}][notas]"
                                               class="form-input"
                                               style="font-size: 0.8rem; padding: 6px 10px;"
                                               placeholder="Opcional"
                                               value="{{ $existing?->notas ?? '' }}"
                                               maxlength="500">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div style="padding: var(--spacing-lg); border-top: 1px solid var(--gray-100); display: flex; justify-content: space-between; align-items: center;">
                    <a href="{{ route('attendance.index') }}" class="btn btn-outline">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary" style="color: white;">
                        <i class="fas fa-save"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function updateStatusButton(radio, bg, color) {
            // Determine which student index this radio belongs to
            const name = radio.name; // e.g. asistencias[3][estado]
            const match = name.match(/asistencias\[(\d+)\]/);
            if (!match) return;
            const idx = match[1];

            // Reset all buttons for this student
            const labels = radio.closest('.status-group').querySelectorAll('span[class*="status-btn"]');
            labels.forEach(span => {
                span.style.borderColor = 'var(--gray-200)';
                span.style.background = 'white';
                span.style.color = 'var(--gray-500)';
            });

            // Highlight the selected button
            const selectedSpan = radio.nextElementSibling;
            if (selectedSpan) {
                selectedSpan.style.borderColor = color;
                selectedSpan.style.background = bg;
                selectedSpan.style.color = color;
            }
        }

        function setAllStatus(estado) {
            const configs = {
                presente:    { bg: '#d1fae5', color: '#10b981' },
                tarde:       { bg: '#fef3c7', color: '#f59e0b' },
                justificado: { bg: '#dbeafe', color: '#3b82f6' },
                ausente:     { bg: '#fee2e2', color: '#ef4444' },
            };
            const cfg = configs[estado];
            document.querySelectorAll(`input[type="radio"][value="${estado}"]`).forEach(radio => {
                radio.checked = true;
                updateStatusButton(radio, cfg.bg, cfg.color);
            });
        }
    </script>
</x-app-layout>
