<x-app-layout>
    <x-slot name="header">
        Tomar Asistencia
    </x-slot>

    <link rel="stylesheet" href="{{ asset('css/shared-index.css') }}?v={{ time() }}">

    @if($errors->any())
        <div class="alert alert-danger"
            style="background: #ef4444; color: white; padding: var(--spacing-md); border-radius: var(--radius-md); margin-bottom: var(--spacing-lg);">
            <ul style="margin: 0; padding-left: var(--spacing-lg);">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="page-header"
        style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-lg);">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--gray-900); margin: 0;">
                <i class="fas fa-plus-circle" style="color: var(--gray-400); margin-right: 8px;"></i> Tomar Asistencia
            </h2>
            <p style="color: var(--gray-500); margin: var(--spacing-xs) 0 0 0; font-size: 0.9375rem;">
                Registra la asistencia en sala de clase
            </p>
        </div>
        <div class="header-actions">
            <a href="{{ route('attendance.index') }}" class="btn btn-outline"
                style="display: flex; align-items: center; justify-content: center; gap: var(--spacing-sm); border: 1px solid var(--gray-300); color: var(--gray-700); background: transparent; padding: 0.625rem 1.25rem; border-radius: var(--radius-md); font-weight: 600; text-decoration: none; transition: all 0.2s;"
                onmouseover="this.style.background='var(--gray-50)'; this.style.color='var(--gray-900)'"
                onmouseout="this.style.background='transparent'; this.style.color='var(--gray-700)'">
                <i class="fas fa-arrow-left"></i>
                <span class="btn-text">Volver a Asistencia</span>
            </a>
        </div>
    </div>

    <div class="mb-xl"
        style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: var(--spacing-lg);">
        <h3
            style="font-size: 1.1rem; font-weight: 700; color: var(--gray-900); margin-top: 0; margin-bottom: var(--spacing-md); border-bottom: 1px solid var(--border-color); padding-bottom: var(--spacing-sm);">
            <i class="fas fa-filter" style="color: var(--gray-400); margin-right: 6px;"></i> Selección de Formulario
        </h3>
        <form method="GET" action="{{ route('attendance.create') }}" id="filterForm">
            <div class="grid grid-cols-1 md:grid-cols-3" style="gap: var(--spacing-lg);">
                <div class="form-group mb-0" style="position: relative;">
                    <label class="form-label"
                        style="font-size: 0.85rem; color: var(--gray-500); font-weight: 600;">Curso *</label>
                    <div
                        style="position: absolute; left: 12px; bottom: 10px; color: var(--gray-400); font-size: 1rem; pointer-events: none; z-index: 1;">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <select name="curso_id" class="form-select" required
                        style="padding-left: 40px; border: 2px solid var(--border-color); border-radius: var(--radius-lg); transition: all 0.2s; font-size: 0.9375rem; cursor: pointer; background-color: transparent;"
                        onfocus="this.style.borderColor='#84cc16'; this.style.boxShadow='0 0 0 3px rgba(132, 204, 22, 0.1)'"
                        onblur="this.style.borderColor='var(--border-color)'; this.style.boxShadow='none'"
                        onchange="document.getElementById('filterForm').submit()">
                        <option value="">Selecciona un curso</option>
                        @foreach($cursos as $curso)
                            <option value="{{ $curso->id }}" {{ $selectedCurso && $selectedCurso->id == $curso->id ? 'selected' : '' }}>
                                {{ $curso->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-0" style="position: relative;">
                    <label class="form-label"
                        style="font-size: 0.85rem; color: var(--gray-500); font-weight: 600;">Asignatura *</label>
                    <div
                        style="position: absolute; left: 12px; bottom: 10px; color: var(--gray-400); font-size: 1rem; pointer-events: none; z-index: 1;">
                        <i class="fas fa-book"></i>
                    </div>
                    <select name="asignatura_id" class="form-select" {{ !$selectedCurso ? 'disabled' : '' }} required
                        onchange="document.getElementById('filterForm').submit()"
                        style="padding-left: 40px; border: 2px solid var(--border-color); border-radius: var(--radius-lg); transition: all 0.2s; font-size: 0.9375rem; cursor: pointer; background-color: transparent;"
                        onfocus="this.style.borderColor='#84cc16'; this.style.boxShadow='0 0 0 3px rgba(132, 204, 22, 0.1)'"
                        onblur="this.style.borderColor='var(--border-color)'; this.style.boxShadow='none'">
                        <option value="">Selecciona una asignatura</option>
                        @if($selectedCurso)
                            @foreach($selectedCurso->asignaturas as $asignatura)
                                <option value="{{ $asignatura->id }}" {{ $selectedAsignatura && $selectedAsignatura->id == $asignatura->id ? 'selected' : '' }}>
                                    {{ $asignatura->nombre }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="form-group mb-0" style="position: relative;">
                    <label class="form-label"
                        style="font-size: 0.85rem; color: var(--gray-500); font-weight: 600;">Fecha *</label>
                    <div
                        style="position: absolute; left: 12px; bottom: 10px; color: var(--gray-400); font-size: 1rem; pointer-events: none; z-index: 1;">
                        <i class="fas fa-calendar"></i>
                    </div>
                    <input type="date" name="fecha" class="form-input" value="{{ $fecha }}"
                        max="{{ now()->format('Y-m-d') }}" required
                        style="padding-left: 40px; border: 2px solid var(--border-color); border-radius: var(--radius-lg); transition: all 0.2s; font-size: 0.9375rem; background-color: transparent;"
                        onfocus="this.style.borderColor='#84cc16'; this.style.boxShadow='0 0 0 3px rgba(132, 204, 22, 0.1)'"
                        onblur="this.style.borderColor='var(--border-color)'; this.style.boxShadow='none'"
                        onchange="document.getElementById('filterForm').submit()">
                </div>
            </div>
        </form>
    </div>

    @if($selectedCurso && $selectedAsignatura && $estudiantes->count() > 0)
        <form method="POST" action="{{ route('attendance.store') }}" id="attendanceForm">
            @csrf
            <input type="hidden" name="curso_id" value="{{ $selectedCurso->id }}">
            <input type="hidden" name="asignatura_id" value="{{ $selectedAsignatura->id }}">
            <input type="hidden" name="fecha" value="{{ $fecha }}">

            <div class="card">
                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <h3 class="card-title mb-0">
                        Lista de Estudiantes - {{ $selectedCurso->nombre }} - {{ $selectedAsignatura->nombre }}
                    </h3>
                    <div style="display: flex; gap: var(--spacing-sm);">
                        <button type="button" class="btn btn-sm btn-ghost" onclick="markAll('presente')">
                            <i class="fas fa-check"></i> Todos Presentes
                        </button>
                        <button type="button" class="btn btn-sm btn-ghost" onclick="markAll('ausente')">
                            <i class="fas fa-times"></i> Todos Ausentes
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div style="display: flex; flex-direction: column; gap: var(--spacing-md);">
                        @foreach($estudiantes as $index => $estudiante)
                            @php
                                $existingRecord = isset($existingAttendance) ? $existingAttendance->get($estudiante->id) : null;
                                $currentEstado = $existingRecord ? $existingRecord->estado : 'presente';
                                $currentNotas = $existingRecord ? $existingRecord->notas : '';
                            @endphp
                            <div class="student-row" data-student-id="{{ $estudiante->id }}"
                                style="display: flex; align-items: center; justify-content: space-between; padding: var(--spacing-md); background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-md); border-left: 4px solid var(--gray-300);">
                                <input type="hidden" name="asistencias[{{ $index }}][estudiante_id]"
                                    value="{{ $estudiante->id }}">

                                <div style="display: flex; align-items: center; gap: var(--spacing-md); flex: 1;">
                                    <div
                                        style="width: 50px; height: 50px; border-radius: var(--radius-full); background: #84cc16; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 1.125rem;">
                                        {{ substr($estudiante->nombre, 0, 1) }}{{ substr($estudiante->apellido, 0, 1) }}
                                    </div>
                                    <div style="flex: 1;">
                                        <div style="font-weight: 600; margin-bottom: var(--spacing-xs);">
                                            {{ $estudiante->nombre }} {{ $estudiante->apellido }}
                                        </div>
                                        <div style="font-size: 0.875rem; color: var(--gray-600);">
                                            {{ $estudiante->rut }} • {{ $estudiante->email ?? 'Sin email' }}
                                        </div>
                                    </div>
                                </div>

                                <div style="display: flex; gap: var(--spacing-md); align-items: center;">
                                    <div style="display: flex; gap: var(--spacing-sm);">
                                        <button type="button"
                                            class="estado-btn btn btn-sm {{ $currentEstado == 'presente' ? 'btn-success' : 'btn-ghost' }}"
                                            data-estado="presente" onclick="setEstado(this, {{ $index }}, 'presente')">
                                            <i class="fas fa-check"></i> Presente
                                        </button>
                                        <button type="button"
                                            class="estado-btn btn btn-sm {{ $currentEstado == 'tarde' ? 'btn-warning' : 'btn-ghost' }}"
                                            data-estado="tarde" onclick="setEstado(this, {{ $index }}, 'tarde')">
                                            <i class="fas fa-clock"></i> Tarde
                                        </button>
                                        <button type="button"
                                            class="estado-btn btn btn-sm {{ $currentEstado == 'ausente' ? 'btn-danger' : 'btn-ghost' }}"
                                            data-estado="ausente" onclick="setEstado(this, {{ $index }}, 'ausente')">
                                            <i class="fas fa-times"></i> Ausente
                                        </button>
                                        <button type="button"
                                            class="estado-btn btn btn-sm {{ $currentEstado == 'justificado' ? 'btn-info' : 'btn-ghost' }}"
                                            data-estado="justificado" onclick="setEstado(this, {{ $index }}, 'justificado')">
                                            <i class="fas fa-file-alt"></i> Justificado
                                        </button>
                                    </div>
                                    <input type="hidden" name="asistencias[{{ $index }}][estado]" value="{{ $currentEstado }}"
                                        class="estado-input">
                                    <input type="text" name="asistencias[{{ $index }}][notas]" class="form-input"
                                        placeholder="Notas..." style="width: 200px;" value="{{ $currentNotas }}">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="card-footer">
                    <div style="display: flex; justify-content: flex-end; gap: var(--spacing-md);">
                        <a href="{{ route('attendance.index') }}" class="btn btn-ghost">Cancelar</a>
                        <button type="submit" class="btn btn-primary" style="color: white;">
                            <i class="fas fa-save"></i> Guardar Asistencia
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <script>
            function setEstado(button, index, estado) {
                const row = button.closest('.student-row');
                const buttons = row.querySelectorAll('.estado-btn');
                const input = row.querySelector('.estado-input');

                buttons.forEach(btn => {
                    btn.classList.remove('btn-success', 'btn-warning', 'btn-danger', 'btn-info');
                    btn.classList.add('btn-ghost');
                });

                button.classList.remove('btn-ghost');
                if (estado === 'presente') button.classList.add('btn-success');
                else if (estado === 'tarde') button.classList.add('btn-warning');
                else if (estado === 'ausente') button.classList.add('btn-danger');
                else if (estado === 'justificado') button.classList.add('btn-info');

                input.value = estado;

                const colors = {
                    'presente': 'var(--success)',
                    'tarde': 'var(--warning)',
                    'ausente': 'var(--error)',
                    'justificado': 'var(--info)'
                };
                row.style.borderLeftColor = colors[estado];
            }

            function markAll(estado) {
                const rows = document.querySelectorAll('.student-row');
                rows.forEach((row, index) => {
                    const button = row.querySelector(`[data-estado="${estado}"]`);
                    if (button) {
                        setEstado(button, index, estado);
                    }
                });
            }
        </script>

        <style>
            .btn-success {
                background: var(--success);
                color: white;
                border-color: var(--success);
            }

            .btn-warning {
                background: var(--warning);
                color: white;
                border-color: var(--warning);
            }

            .btn-danger {
                background: var(--error);
                color: white;
                border-color: var(--error);
            }

            .btn-info {
                background: var(--info);
                color: white;
                border-color: var(--info);
            }
        </style>
    @elseif($selectedCurso && $selectedAsignatura)
        <div style="background: var(--bg-card); border: 1px dashed var(--border-color); border-radius: var(--radius-lg);">
            <div style="text-align: center; padding: var(--spacing-2xl);">
                <i class="fas fa-users-slash"
                    style="font-size: 3rem; color: var(--gray-300); margin-bottom: var(--spacing-md);"></i>
                <p style="color: var(--gray-600); margin: 0; font-weight: 500;">No hay estudiantes inscritos en este curso
                    para esta asignatura</p>
            </div>
        </div>
    @else
        <div style="background: var(--bg-card); border: 1px dashed var(--border-color); border-radius: var(--radius-lg);">
            <div style="text-align: center; padding: var(--spacing-2xl);">
                <i class="fas fa-hand-pointer"
                    style="font-size: 3rem; color: var(--gray-300); margin-bottom: var(--spacing-md);"></i>
                <p style="color: var(--gray-600); margin: 0; font-weight: 500;">Selecciona un curso y una asignatura para
                    comenzar a tomar asistencia</p>
            </div>
        </div>
    @endif
</x-app-layout>