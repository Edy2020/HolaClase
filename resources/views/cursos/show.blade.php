<x-app-layout>
    <x-slot name="header">
        {{ $curso->nombre }} - Detalles
    </x-slot>

    <link rel="stylesheet" href="{{ asset('css/shared-index.css') }}?v={{ time() }}">

    @if(session('success'))
        <div id="successMessage"
            style="background: var(--success); color: white; padding: var(--spacing-md); border-radius: var(--radius-md); margin-bottom: var(--spacing-lg);">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
        <script>
            setTimeout(() => {
                const m = document.getElementById('successMessage');
                if (m) { m.style.opacity = '0'; setTimeout(() => m.style.display = 'none', 500); }
            }, 3000);
        </script>
    @endif

    <div class="page-header"
        style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-lg); flex-wrap: wrap; gap: var(--spacing-md);">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--text-color); margin: 0;">
                {{ $curso->nombre }}
            </h2>
            <p style="color: var(--text-muted); margin: var(--spacing-xs) 0 0 0; font-size: 0.9375rem;">
                <i class="fas fa-layer-group"></i> {{ $curso->nivel }}
                @if($curso->grado) &middot; <i class="fas fa-graduation-cap"></i> {{ $curso->grado }} @endif
                &middot; <i class="fas fa-tag"></i> Sección {{ $curso->letra }}
            </p>
        </div>
        <div style="display: flex; gap: var(--spacing-sm); flex-wrap: wrap;">
            <a href="{{ route('attendance.create', ['curso_id' => $curso->id]) }}" class="btn btn-outline"
                style="color: var(--text-color); border-color: var(--border-color);">
                <i class="fas fa-check"></i> Asistencia
            </a>
            <a href="{{ route('courses.edit', $curso) }}" class="btn btn-outline"
                style="color: var(--text-color); border-color: var(--border-color);">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="{{ route('courses.index') }}" class="btn btn-outline"
                style="color: var(--text-muted); border-color: var(--border-color);">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    <div class="system-tabs-container">
        <div onclick="switchSystemTab('general')" class="system-tab active-tab" id="tab-general">General</div>
        <div onclick="switchSystemTab('estudiantes')" class="system-tab" id="tab-estudiantes">Estudiantes</div>
        <div onclick="switchSystemTab('asignaturas')" class="system-tab" id="tab-asignaturas">Asignaturas</div>
        <div onclick="switchSystemTab('notas')" class="system-tab" id="tab-notas">Notas</div>
        <div onclick="switchSystemTab('eventos')" class="system-tab" id="tab-eventos">Eventos</div>
    </div>

    <div id="section-general" class="system-tab-section active-section">
        <div
            style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--spacing-lg); margin-bottom: var(--spacing-lg);">


            <div
                style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: var(--spacing-lg);">
                <h3
                    style="font-size: 1rem; font-weight: 700; color: var(--text-color); margin: 0 0 var(--spacing-lg) 0; padding-bottom: var(--spacing-sm); border-bottom: 1px solid var(--border-color); display: flex; align-items: center; gap: var(--spacing-sm);">
                    <i class="fas fa-chalkboard-teacher" style="color: var(--text-muted);"></i> Profesor Asignado
                </h3>

                @if($curso->profesor)
                    <div id="teacherCard" onclick="toggleTeacherForm()"
                        style="padding: var(--spacing-md); border-radius: var(--radius-md); border: 1px solid var(--border-color); margin-bottom: var(--spacing-md); cursor: pointer;">
                        <div style="display: flex; align-items: center; gap: var(--spacing-sm); flex-wrap: wrap;">
                            <div
                                style="width: 40px; height: 40px; border-radius: 50%; background: var(--gray-200); display: flex; align-items: center; justify-content: center; color: var(--text-color); font-size: 1rem; font-weight: 700; flex-shrink: 0;">
                                {{ substr($curso->profesor->nombre, 0, 1) }}{{ substr($curso->profesor->apellido, 0, 1) }}
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <p
                                    style="font-weight: 600; color: var(--text-color); margin: 0 0 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $curso->profesor->nombre }} {{ $curso->profesor->apellido }}</p>
                                <p
                                    style="color: var(--text-muted); font-size: 0.8rem; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    <i class="fas fa-envelope"></i> {{ $curso->profesor->email }}</p>
                                @if($curso->profesor->telefono)
                                    <p style="color: var(--text-muted); font-size: 0.8rem; margin: 0;"><i
                                            class="fas fa-phone"></i> {{ $curso->profesor->telefono }}</p>
                                @endif
                            </div>
                            <form action="{{ route('courses.assign-teacher', $curso) }}" method="POST"
                                onclick="event.stopPropagation();"
                                onsubmit="return confirm('¿Quitar el profesor asignado?');" style="flex-shrink: 0;">
                                @csrf
                                <input type="hidden" name="profesor_id" value="">
                                <button type="submit" class="btn btn-sm btn-outline"
                                    style="color: var(--error); border-color: var(--error);">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                        <p
                            style="text-align: center; color: var(--text-muted); font-size: 0.7rem; margin: var(--spacing-xs) 0 0;">
                            Click para cambiar profesor</p>
                    </div>
                @else
                    <div onclick="toggleTeacherForm()" id="emptyTeacherCard"
                        style="text-align: center; padding: var(--spacing-2xl); border: 1px dashed var(--border-color); border-radius: var(--radius-md); margin-bottom: var(--spacing-md); cursor: pointer; min-height: 120px; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                        <i class="fas fa-user-slash"
                            style="font-size: 2.5rem; color: var(--text-muted); margin-bottom: var(--spacing-md); opacity: 0.6;"></i>
                        <p style="color: var(--text-color); margin: 0; font-weight: 500;">No hay profesor asignado</p>
                        <p style="color: var(--text-muted); font-size: 0.8rem; margin: 4px 0 0;">Click para asignar un
                            profesor</p>
                    </div>
                @endif

                <form id="teacherForm" action="{{ route('courses.assign-teacher', $curso) }}" method="POST"
                    style="display: none;">
                    @csrf
                    <div style="margin-bottom: var(--spacing-md); position: relative;">
                        <label
                            style="display: block; font-weight: 600; color: var(--text-muted); font-size: 0.85rem; margin-bottom: var(--spacing-sm);">BUSCAR
                            PROFESOR</label>
                        <input type="text" id="teacherSearch" class="form-input" placeholder="Escribe el nombre..."
                            style="width: 100%;" autocomplete="off" oninput="filterTeachers(this.value)">
                        <input type="hidden" name="profesor_id" id="selectedTeacherId">
                        <div id="teacherSuggestions"
                            style="display: none; position: absolute; background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-md); margin-top: 4px; max-height: 200px; overflow-y: auto; width: 100%; z-index: 10;">
                        </div>
                    </div>
                    <div style="display: flex; gap: var(--spacing-sm);">
                        <button type="submit" class="btn btn-primary" style="flex: 1; color: white;">
                            <i class="fas fa-user-check"></i> Asignar
                        </button>
                        @if($curso->profesor)
                            <button type="button" onclick="toggleTeacherForm()" class="btn btn-outline" style="flex: 1;">
                                <i class="fas fa-times"></i> Cancelar
                            </button>
                        @endif
                    </div>
                </form>
            </div>


            <div
                style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: var(--spacing-lg);">
                <h3
                    style="font-size: 1rem; font-weight: 700; color: var(--text-color); margin: 0 0 var(--spacing-lg) 0; padding-bottom: var(--spacing-sm); border-bottom: 1px solid var(--border-color); display: flex; align-items: center; gap: var(--spacing-sm);">
                    <i class="fas fa-chart-bar" style="color: var(--text-muted);"></i> Estadísticas
                </h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--spacing-md);">
                    <div class="stat-card" style="text-align: center;">
                        <div class="stat-value">{{ $curso->estudiantes->count() }}</div>
                        <div class="stat-label"><i class="fas fa-users"></i> Estudiantes</div>
                    </div>
                    <div class="stat-card" style="text-align: center;">
                        <div class="stat-value">{{ $curso->asignaturas->count() }}</div>
                        <div class="stat-label"><i class="fas fa-book"></i> Asignaturas</div>
                    </div>
                    <div class="stat-card" style="text-align: center;">
                        <div class="stat-value">{{ $curso->eventos->count() }}</div>
                        <div class="stat-label"><i class="fas fa-calendar"></i> Eventos</div>
                    </div>
                    <div class="stat-card" style="text-align: center;">
                        <div class="stat-value">{{ $curso->pruebas->count() }}</div>
                        <div class="stat-label"><i class="fas fa-file-alt"></i> Pruebas</div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div id="section-estudiantes" class="system-tab-section">
        <div
            style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: var(--spacing-lg); margin-bottom: var(--spacing-lg);">
            <div class="section-header">
                <h3
                    style="font-size: 1rem; font-weight: 700; color: var(--text-color); margin: 0; display: flex; align-items: center; gap: var(--spacing-sm);">
                    <i class="fas fa-users" style="color: var(--text-muted);"></i>
                    Estudiantes Inscritos ({{ $curso->estudiantes->count() }})
                </h3>
                <button onclick="document.getElementById('addStudentModal').style.display='flex'"
                    class="btn btn-outline section-button"
                    style="color: var(--text-color); border-color: var(--border-color);">
                    <i class="fas fa-user-plus"></i> Agregar
                </button>
            </div>

            @if($curso->estudiantes->count() > 0)
                <div style="overflow-x: auto;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>RUT</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Teléfono</th>
                                <th>Inscripción</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($curso->estudiantes as $estudiante)
                                <tr>
                                    <td>{{ $estudiante->rut }}</td>
                                    <td>{{ $estudiante->nombre }} {{ $estudiante->apellido }}</td>
                                    <td>{{ $estudiante->email ?? '-' }}</td>
                                    <td>{{ $estudiante->telefono ?? '-' }}</td>
                                    <td>
                                        @if($estudiante->pivot->fecha_inscripcion)
                                            {{ is_string($estudiante->pivot->fecha_inscripcion) ? \Carbon\Carbon::parse($estudiante->pivot->fecha_inscripcion)->format('d/m/Y') : $estudiante->pivot->fecha_inscripcion->format('d/m/Y') }}
                                        @else -
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('courses.remove-student', [$curso, $estudiante]) }}"
                                            method="POST" onsubmit="return confirm('¿Remover estudiante del curso?');"
                                            style="display: inline;">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline"
                                                style="color: var(--error); border-color: var(--error);">
                                                <i class="fas fa-user-minus"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div
                    style="text-align: center; padding: var(--spacing-2xl); border: 1px dashed var(--border-color); border-radius: var(--radius-md);">
                    <i class="fas fa-users-slash"
                        style="font-size: 2.5rem; color: var(--text-muted); margin-bottom: var(--spacing-md); opacity: 0.6;"></i>
                    <p style="color: var(--text-color); margin: 0; font-weight: 500;">No hay estudiantes inscritos</p>
                </div>
            @endif
        </div>
    </div>


    <div id="section-asignaturas" class="system-tab-section">
        <div
            style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: var(--spacing-lg); margin-bottom: var(--spacing-lg);">
            <div class="section-header">
                <h3
                    style="font-size: 1rem; font-weight: 700; color: var(--text-color); margin: 0; display: flex; align-items: center; gap: var(--spacing-sm);">
                    <i class="fas fa-book" style="color: var(--text-muted);"></i>
                    Asignaturas del Curso ({{ $curso->asignaturas->count() }})
                </h3>
                <button onclick="document.getElementById('addSubjectModal').style.display='flex'"
                    class="btn btn-outline section-button"
                    style="color: var(--text-color); border-color: var(--border-color);">
                    <i class="fas fa-plus"></i> Agregar
                </button>
            </div>

            @if($curso->asignaturas->count() > 0)
                <div
                    style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: var(--spacing-md);">
                    @foreach($curso->asignaturas as $asignatura)
                        <div
                            style="border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: var(--spacing-md);">
                            <div
                                style="display: flex; justify-content: space-between; align-items: start; margin-bottom: var(--spacing-sm);">
                                <div>
                                    <h4 style="font-weight: 700; color: var(--text-color); margin: 0 0 2px;">
                                        {{ $asignatura->nombre }}</h4>
                                    <p style="color: var(--text-muted); font-size: 0.875rem; margin: 0;">Código:
                                        {{ $asignatura->codigo }}</p>
                                </div>
                                <form action="{{ route('courses.remove-subject', [$curso, $asignatura]) }}" method="POST"
                                    onsubmit="return confirm('¿Remover asignatura?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline"
                                        style="color: var(--error); border-color: var(--error);">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                            @if($asignatura->descripcion)
                                <p style="color: var(--text-muted); font-size: 0.875rem; margin: 0;">{{ $asignatura->descripcion }}
                                </p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div
                    style="text-align: center; padding: var(--spacing-2xl); border: 1px dashed var(--border-color); border-radius: var(--radius-md);">
                    <i class="fas fa-book-open"
                        style="font-size: 2.5rem; color: var(--text-muted); margin-bottom: var(--spacing-md); opacity: 0.6;"></i>
                    <p style="color: var(--text-color); margin: 0; font-weight: 500;">No hay asignaturas asignadas</p>
                </div>
            @endif
        </div>
    </div>


    <div id="section-notas" class="system-tab-section">
        <div
            style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: var(--spacing-lg); margin-bottom: var(--spacing-lg);">
            <div class="section-header">
                <h3
                    style="font-size: 1rem; font-weight: 700; color: var(--text-color); margin: 0; display: flex; align-items: center; gap: var(--spacing-sm);">
                    <i class="fas fa-clipboard-list" style="color: var(--text-muted);"></i> Gestión de Notas
                </h3>
                <a href="{{ route('grades.create', ['curso_id' => $curso->id]) }}"
                    class="btn btn-outline section-button"
                    style="color: var(--text-color); border-color: var(--border-color);">
                    <i class="fas fa-plus"></i> Agregar Notas
                </a>
            </div>

            <div
                style="display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: var(--spacing-md); margin-bottom: var(--spacing-lg);">
                <div class="stat-card" style="text-align: center;">
                    <div class="stat-value">{{ $curso->notas->count() }}</div>
                    <div class="stat-label">Total Notas</div>
                </div>
                <div class="stat-card" style="text-align: center;">
                    <div class="stat-value">
                        {{ $curso->notas->count() > 0 ? number_format($curso->notas->avg('nota'), 1) : 'N/A' }}</div>
                    <div class="stat-label">Promedio General</div>
                </div>
                <div class="stat-card" style="text-align: center;">
                    <div class="stat-value">{{ $curso->notas->where('nota', '>=', 4.0)->count() }}</div>
                    <div class="stat-label">Aprobados</div>
                </div>
                <div class="stat-card" style="text-align: center;">
                    <div class="stat-value">{{ $curso->notas->where('nota', '<', 4.0)->count() }}</div>
                    <div class="stat-label">Reprobados</div>
                </div>
            </div>

            @if($curso->asignaturas->count() > 0)
                <div
                    style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: var(--spacing-md); margin-bottom: var(--spacing-lg);">
                    @foreach($curso->asignaturas as $asignatura)
                        @php
                            $notasAsignatura = $curso->notas->where('asignatura_id', $asignatura->id);
                            $promedio = $notasAsignatura->count() > 0 ? $notasAsignatura->avg('nota') : null;
                        @endphp
                        <div
                            style="padding: var(--spacing-md); border: 1px solid var(--border-color); border-radius: var(--radius-md);">
                            <h4
                                style="font-weight: 600; color: var(--text-color); margin: 0 0 var(--spacing-sm); font-size: 0.875rem;">
                                {{ $asignatura->nombre }}</h4>
                            <div
                                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-sm);">
                                <span style="color: var(--text-muted); font-size: 0.75rem;"><i
                                        class="fas fa-clipboard-check"></i> {{ $notasAsignatura->count() }} notas</span>
                                @if($promedio)
                                    <span
                                        style="font-weight: 700; font-size: 1.125rem; color: var(--text-color);">{{ number_format($promedio, 1) }}</span>
                                @else
                                    <span style="color: var(--text-muted); font-size: 0.875rem;">Sin notas</span>
                                @endif
                            </div>
                            <a href="{{ route('grades.create', ['curso_id' => $curso->id, 'asignatura_id' => $asignatura->id]) }}"
                                class="btn btn-sm btn-outline"
                                style="width: 100%; font-size: 0.75rem; justify-content: center;">
                                <i class="fas fa-plus"></i> Agregar Notas
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <p
                    style="text-align: center; color: var(--text-muted); padding: var(--spacing-lg); border: 1px dashed var(--border-color); border-radius: var(--radius-md); margin-bottom: var(--spacing-lg);">
                    <i class="fas fa-info-circle"></i> Agrega asignaturas al curso para registrar notas
                </p>
            @endif

            <div style="text-align: center;">
                <a href="{{ route('grades.reporte.curso', $curso) }}" class="btn btn-outline"
                    style="color: var(--text-color); border-color: var(--border-color);">
                    <i class="fas fa-chart-bar"></i> Ver Reporte Completo
                </a>
            </div>
        </div>
    </div>


    <div id="section-eventos" class="system-tab-section">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--spacing-lg);">


            <div
                style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: var(--spacing-lg);">
                <div class="section-header">
                    <h3
                        style="font-size: 1rem; font-weight: 700; color: var(--text-color); margin: 0; display: flex; align-items: center; gap: var(--spacing-sm);">
                        <i class="fas fa-calendar-alt" style="color: var(--text-muted);"></i> Calendario Académico
                    </h3>
                    <button onclick="document.getElementById('addEventModal').style.display='flex'"
                        class="btn btn-outline section-button"
                        style="color: var(--text-color); border-color: var(--border-color);">
                        <i class="fas fa-plus"></i> Nuevo
                    </button>
                </div>

                @if($curso->eventos->count() > 0)
                    <div style="max-height: 400px; overflow-y: auto;">
                        @foreach($curso->eventos as $evento)
                            <div
                                style="border-left: 3px solid var(--border-color); padding: var(--spacing-md); background: var(--gray-50); border-radius: 0 var(--radius-md) var(--radius-md) 0; margin-bottom: var(--spacing-md);">
                                <div style="display: flex; justify-content: space-between; align-items: start;">
                                    <div style="flex: 1; min-width: 0;">
                                        <h4 style="font-weight: 700; color: var(--text-color); margin: 0 0 4px;">
                                            {{ $evento->titulo }}</h4>
                                        <p style="color: var(--text-muted); font-size: 0.875rem; margin: 0 0 4px;"><i
                                                class="fas fa-calendar"></i>
                                            {{ $evento->fecha_inicio->format('d/m/Y') }}@if($evento->fecha_fin) -
                                            {{ $evento->fecha_fin->format('d/m/Y') }}@endif</p>
                                        <span
                                            style="display: inline-block; padding: 2px 8px; border: 1px solid var(--border-color); border-radius: var(--radius-sm); font-size: 0.75rem; color: var(--text-muted);">{{ ucfirst($evento->tipo) }}</span>
                                        @if($evento->descripcion)
                                            <p
                                                style="color: var(--text-muted); font-size: 0.875rem; margin: var(--spacing-sm) 0 0;">
                                        {{ $evento->descripcion }}</p>@endif
                                    </div>
                                    <form action="{{ route('courses.destroy-event', [$curso, $evento]) }}" method="POST"
                                        onsubmit="return confirm('¿Eliminar evento?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline"
                                            style="color: var(--error); border-color: var(--error); margin-left: var(--spacing-sm);">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div
                        style="text-align: center; padding: var(--spacing-xl); border: 1px dashed var(--border-color); border-radius: var(--radius-md);">
                        <i class="fas fa-calendar-times"
                            style="font-size: 2.5rem; color: var(--text-muted); margin-bottom: var(--spacing-md); opacity: 0.6;"></i>
                        <p style="color: var(--text-color); margin: 0; font-weight: 500;">No hay eventos programados</p>
                    </div>
                @endif
            </div>


            <div
                style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: var(--spacing-lg);">
                <div class="section-header">
                    <h3
                        style="font-size: 1rem; font-weight: 700; color: var(--text-color); margin: 0; display: flex; align-items: center; gap: var(--spacing-sm);">
                        <i class="fas fa-file-alt" style="color: var(--text-muted);"></i> Próximas Pruebas
                    </h3>
                    <button onclick="document.getElementById('addTestModal').style.display='flex'"
                        class="btn btn-outline section-button"
                        style="color: var(--text-color); border-color: var(--border-color);">
                        <i class="fas fa-plus"></i> Nueva
                    </button>
                </div>

                @if($curso->pruebas->count() > 0)
                    <div style="max-height: 400px; overflow-y: auto;">
                        @foreach($curso->pruebas as $prueba)
                            <div
                                style="border-left: 3px solid var(--border-color); padding: var(--spacing-md); background: var(--gray-50); border-radius: 0 var(--radius-md) var(--radius-md) 0; margin-bottom: var(--spacing-md);">
                                <div style="display: flex; justify-content: space-between; align-items: start;">
                                    <div style="flex: 1; min-width: 0;">
                                        <h4 style="font-weight: 700; color: var(--text-color); margin: 0 0 4px;">
                                            {{ $prueba->titulo }}</h4>
                                        <p style="color: var(--text-muted); font-size: 0.875rem; margin: 0;"><i
                                                class="fas fa-book"></i> {{ $prueba->asignatura->nombre }}</p>
                                        <p style="color: var(--text-muted); font-size: 0.875rem; margin: 0;"><i
                                                class="fas fa-calendar"></i>
                                            {{ $prueba->fecha->format('d/m/Y') }}@if($prueba->hora) <i class="fas fa-clock"></i>
                                            {{ $prueba->hora }}@endif</p>
                                        @if($prueba->ponderacion)
                                            <span
                                                style="display: inline-block; padding: 2px 8px; border: 1px solid var(--border-color); border-radius: var(--radius-sm); font-size: 0.75rem; color: var(--text-muted); margin-top: 4px;">{{ $prueba->ponderacion }}%</span>
                                        @endif
                                    </div>
                                    <form action="{{ route('courses.destroy-test', [$curso, $prueba]) }}" method="POST"
                                        onsubmit="return confirm('¿Eliminar prueba?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline"
                                            style="color: var(--error); border-color: var(--error); margin-left: var(--spacing-sm);">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div
                        style="text-align: center; padding: var(--spacing-xl); border: 1px dashed var(--border-color); border-radius: var(--radius-md);">
                        <i class="fas fa-clipboard-list"
                            style="font-size: 2.5rem; color: var(--text-muted); margin-bottom: var(--spacing-md); opacity: 0.6;"></i>
                        <p style="color: var(--text-color); margin: 0; font-weight: 500;">No hay pruebas programadas</p>
                    </div>
                @endif
            </div>
        </div>
    </div>


    <div id="addStudentModal"
        style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; z-index: 1000;">
        <div
            style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); max-width: 500px; width: 90%; max-height: 90vh; overflow-y: auto; padding: var(--spacing-lg);">
            <div
                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-lg);">
                <h3 style="font-size: 1.125rem; font-weight: 700; color: var(--text-color); margin: 0;">Agregar
                    Estudiante</h3>
                <button onclick="document.getElementById('addStudentModal').style.display='none'"
                    style="background: none; border: none; font-size: 1.5rem; color: var(--text-muted); cursor: pointer;"><i
                        class="fas fa-times"></i></button>
            </div>
            <form action="{{ route('courses.add-student', $curso) }}" method="POST">
                @csrf
                <div style="margin-bottom: var(--spacing-md);">
                    <label
                        style="display: block; font-weight: 600; color: var(--text-muted); font-size: 0.85rem; margin-bottom: var(--spacing-sm);">ESTUDIANTE</label>
                    <select name="estudiante_id" class="form-select"
                        style="width: 100%; background: var(--bg-card); color: var(--text-color);" required>
                        <option value="">Seleccione un estudiante</option>
                        @foreach($estudiantesDisponibles as $e)
                            <option value="{{ $e->id }}">{{ $e->nombre }} {{ $e->apellido }} ({{ $e->rut }})</option>
                        @endforeach
                    </select>
                </div>
                <div style="margin-bottom: var(--spacing-lg);">
                    <label
                        style="display: block; font-weight: 600; color: var(--text-muted); font-size: 0.85rem; margin-bottom: var(--spacing-sm);">FECHA
                        DE INSCRIPCIÓN</label>
                    <input type="date" name="fecha_inscripcion" class="form-input"
                        style="width: 100%; background: var(--bg-card); color: var(--text-color);"
                        value="{{ date('Y-m-d') }}">
                </div>
                <div style="display: flex; gap: var(--spacing-sm);">
                    <button type="button" onclick="document.getElementById('addStudentModal').style.display='none'"
                        class="btn btn-outline"
                        style="flex: 1; color: var(--text-color); border-color: var(--border-color);">Cancelar</button>
                    <button type="submit" class="btn btn-primary" style="flex: 1; color: white;"><i
                            class="fas fa-user-plus"></i> Agregar</button>
                </div>
            </form>
        </div>
    </div>


    <div id="addSubjectModal"
        style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; z-index: 1000;">
        <div
            style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); max-width: 500px; width: 90%; max-height: 90vh; overflow-y: auto; padding: var(--spacing-lg);">
            <div
                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-lg);">
                <h3 style="font-size: 1.125rem; font-weight: 700; color: var(--text-color); margin: 0;">Agregar
                    Asignatura</h3>
                <button onclick="document.getElementById('addSubjectModal').style.display='none'"
                    style="background: none; border: none; font-size: 1.5rem; color: var(--text-muted); cursor: pointer;"><i
                        class="fas fa-times"></i></button>
            </div>
            <form action="{{ route('courses.add-subject', $curso) }}" method="POST">
                @csrf
                <div style="margin-bottom: var(--spacing-md);">
                    <label
                        style="display: block; font-weight: 600; color: var(--text-muted); font-size: 0.85rem; margin-bottom: var(--spacing-sm);">ASIGNATURA</label>
                    <select name="asignatura_id" class="form-select"
                        style="width: 100%; background: var(--bg-card); color: var(--text-color);" required>
                        <option value="">Seleccione una asignatura</option>
                        @foreach($asignaturasDisponibles as $a)
                            <option value="{{ $a->id }}">{{ $a->nombre }} ({{ $a->codigo }})</option>
                        @endforeach
                    </select>
                </div>
                <div style="margin-bottom: var(--spacing-lg);">
                    <label
                        style="display: block; font-weight: 600; color: var(--text-muted); font-size: 0.85rem; margin-bottom: var(--spacing-sm);">PROFESOR
                        DE LA ASIGNATURA (OPCIONAL)</label>
                    <select name="profesor_id" class="form-select"
                        style="width: 100%; background: var(--bg-card); color: var(--text-color);">
                        <option value="">Sin profesor específico</option>
                        @foreach($profesores as $p)
                            <option value="{{ $p->id }}">{{ $p->nombre }} {{ $p->apellido }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="display: flex; gap: var(--spacing-sm);">
                    <button type="button" onclick="document.getElementById('addSubjectModal').style.display='none'"
                        class="btn btn-outline"
                        style="flex: 1; color: var(--text-color); border-color: var(--border-color);">Cancelar</button>
                    <button type="submit" class="btn btn-primary" style="flex: 1; color: white;"><i
                            class="fas fa-plus"></i> Agregar</button>
                </div>
            </form>
        </div>
    </div>


    <div id="addEventModal"
        style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; z-index: 1000;">
        <div
            style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); max-width: 500px; width: 90%; max-height: 90vh; overflow-y: auto; padding: var(--spacing-lg);">
            <div
                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-lg);">
                <h3 style="font-size: 1.125rem; font-weight: 700; color: var(--text-color); margin: 0;">Nuevo Evento
                    Académico</h3>
                <button onclick="document.getElementById('addEventModal').style.display='none'"
                    style="background: none; border: none; font-size: 1.5rem; color: var(--text-muted); cursor: pointer;"><i
                        class="fas fa-times"></i></button>
            </div>
            <form action="{{ route('courses.store-event', $curso) }}" method="POST">
                @csrf
                <div style="margin-bottom: var(--spacing-md);">
                    <label
                        style="display: block; font-weight: 600; color: var(--text-muted); font-size: 0.85rem; margin-bottom: var(--spacing-sm);">TÍTULO</label>
                    <input type="text" name="titulo" class="form-input"
                        style="width: 100%; background: var(--bg-card); color: var(--text-color);" required>
                </div>
                <div style="margin-bottom: var(--spacing-md);">
                    <label
                        style="display: block; font-weight: 600; color: var(--text-muted); font-size: 0.85rem; margin-bottom: var(--spacing-sm);">TIPO</label>
                    <select name="tipo" class="form-select"
                        style="width: 100%; background: var(--bg-card); color: var(--text-color);" required>
                        <option value="reunion">Reunión</option>
                        <option value="actividad">Actividad</option>
                        <option value="examen">Examen</option>
                        <option value="vacaciones">Vacaciones</option>
                        <option value="otro">Otro</option>
                    </select>
                </div>
                <div
                    style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--spacing-md); margin-bottom: var(--spacing-md);">
                    <div>
                        <label
                            style="display: block; font-weight: 600; color: var(--text-muted); font-size: 0.85rem; margin-bottom: var(--spacing-sm);">FECHA
                            INICIO</label>
                        <input type="date" name="fecha_inicio" class="form-input"
                            style="width: 100%; background: var(--bg-card); color: var(--text-color);" required>
                    </div>
                    <div>
                        <label
                            style="display: block; font-weight: 600; color: var(--text-muted); font-size: 0.85rem; margin-bottom: var(--spacing-sm);">FECHA
                            FIN (OPCIONAL)</label>
                        <input type="date" name="fecha_fin" class="form-input"
                            style="width: 100%; background: var(--bg-card); color: var(--text-color);">
                    </div>
                </div>
                <div style="margin-bottom: var(--spacing-lg);">
                    <label
                        style="display: block; font-weight: 600; color: var(--text-muted); font-size: 0.85rem; margin-bottom: var(--spacing-sm);">DESCRIPCIÓN
                        (OPCIONAL)</label>
                    <textarea name="descripcion" class="form-input"
                        style="width: 100%; min-height: 80px; background: var(--bg-card); color: var(--text-color);"></textarea>
                </div>
                <div style="display: flex; gap: var(--spacing-sm);">
                    <button type="button" onclick="document.getElementById('addEventModal').style.display='none'"
                        class="btn btn-outline"
                        style="flex: 1; color: var(--text-color); border-color: var(--border-color);">Cancelar</button>
                    <button type="submit" class="btn btn-primary" style="flex: 1; color: white;"><i
                            class="fas fa-calendar-plus"></i> Crear Evento</button>
                </div>
            </form>
        </div>
    </div>


    <div id="addTestModal"
        style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; z-index: 1000;">
        <div
            style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); max-width: 500px; width: 90%; max-height: 90vh; overflow-y: auto; padding: var(--spacing-lg);">
            <div
                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-lg);">
                <h3 style="font-size: 1.125rem; font-weight: 700; color: var(--text-color); margin: 0;">Nueva Prueba
                </h3>
                <button onclick="document.getElementById('addTestModal').style.display='none'"
                    style="background: none; border: none; font-size: 1.5rem; color: var(--text-muted); cursor: pointer;"><i
                        class="fas fa-times"></i></button>
            </div>
            <form action="{{ route('courses.store-test', $curso) }}" method="POST">
                @csrf
                <div style="margin-bottom: var(--spacing-md);">
                    <label
                        style="display: block; font-weight: 600; color: var(--text-muted); font-size: 0.85rem; margin-bottom: var(--spacing-sm);">ASIGNATURA</label>
                    <select name="asignatura_id" class="form-select"
                        style="width: 100%; background: var(--bg-card); color: var(--text-color);" required>
                        <option value="">Seleccione una asignatura</option>
                        @foreach($curso->asignaturas as $a)
                            <option value="{{ $a->id }}">{{ $a->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="margin-bottom: var(--spacing-md);">
                    <label
                        style="display: block; font-weight: 600; color: var(--text-muted); font-size: 0.85rem; margin-bottom: var(--spacing-sm);">TÍTULO</label>
                    <input type="text" name="titulo" class="form-input"
                        style="width: 100%; background: var(--bg-card); color: var(--text-color);" required>
                </div>
                <div
                    style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: var(--spacing-md); margin-bottom: var(--spacing-md);">
                    <div>
                        <label
                            style="display: block; font-weight: 600; color: var(--text-muted); font-size: 0.85rem; margin-bottom: var(--spacing-sm);">FECHA</label>
                        <input type="date" name="fecha" class="form-input"
                            style="width: 100%; background: var(--bg-card); color: var(--text-color);" required>
                    </div>
                    <div>
                        <label
                            style="display: block; font-weight: 600; color: var(--text-muted); font-size: 0.85rem; margin-bottom: var(--spacing-sm);">HORA
                            (OPC.)</label>
                        <input type="time" name="hora" class="form-input"
                            style="width: 100%; background: var(--bg-card); color: var(--text-color);">
                    </div>
                    <div>
                        <label
                            style="display: block; font-weight: 600; color: var(--text-muted); font-size: 0.85rem; margin-bottom: var(--spacing-sm);">PONDER.
                            %</label>
                        <input type="number" name="ponderacion" class="form-input"
                            style="width: 100%; background: var(--bg-card); color: var(--text-color);" min="0"
                            max="100">
                    </div>
                </div>
                <div style="margin-bottom: var(--spacing-lg);">
                    <label
                        style="display: block; font-weight: 600; color: var(--text-muted); font-size: 0.85rem; margin-bottom: var(--spacing-sm);">DESCRIPCIÓN
                        (OPCIONAL)</label>
                    <textarea name="descripcion" class="form-input"
                        style="width: 100%; min-height: 80px; background: var(--bg-card); color: var(--text-color);"></textarea>
                </div>
                <div style="display: flex; gap: var(--spacing-sm);">
                    <button type="button" onclick="document.getElementById('addTestModal').style.display='none'"
                        class="btn btn-outline"
                        style="flex: 1; color: var(--text-color); border-color: var(--border-color);">Cancelar</button>
                    <button type="submit" class="btn btn-primary" style="flex: 1; color: white;"><i
                            class="fas fa-file-alt"></i> Crear Prueba</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const profesores = @json($profesores->map(fn($p) => ['id' => $p->id, 'nombre' => $p->nombre . ' ' . $p->apellido]));

        function filterTeachers(query) {
            const s = document.getElementById('teacherSuggestions');
            if (!query || query.length < 2) { s.style.display = 'none'; return; }
            const f = profesores.filter(p => p.nombre.toLowerCase().includes(query.toLowerCase()));
            if (!f.length) { s.style.display = 'none'; return; }
            s.innerHTML = f.map(p => `<div onclick="selectTeacher(${p.id},'${p.nombre}')" style="padding: var(--spacing-sm); cursor: pointer; border-bottom: 1px solid var(--border-color); color: var(--text-color);" onmouseover="this.style.background='var(--gray-100)'" onmouseout="this.style.background=''">${p.nombre}</div>`).join('');
            s.style.display = 'block';
        }

        function selectTeacher(id, nombre) {
            document.getElementById('teacherSearch').value = nombre;
            document.getElementById('selectedTeacherId').value = id;
            document.getElementById('teacherSuggestions').style.display = 'none';
        }

        function toggleTeacherForm() {
            const form = document.getElementById('teacherForm');
            const card = document.getElementById('teacherCard');
            const empty = document.getElementById('emptyTeacherCard');
            const showing = form.style.display !== 'none';
            form.style.display = showing ? 'none' : 'block';
            if (card) card.style.display = showing ? 'block' : 'none';
            if (empty) empty.style.display = showing ? 'flex' : 'none';
        }

        document.addEventListener('click', e => {
            const s = document.getElementById('teacherSuggestions');
            if (s && e.target !== document.getElementById('teacherSearch')) s.style.display = 'none';
        });

        document.querySelectorAll('[id$="Modal"]').forEach(m => {
            m.addEventListener('click', e => { if (e.target === m) m.style.display = 'none'; });
        });

        function switchSystemTab(name) {
            document.querySelectorAll('.system-tab').forEach(t => t.classList.remove('active-tab'));
            document.querySelectorAll('.system-tab-section').forEach(s => s.classList.remove('active-section'));
            document.getElementById('tab-' + name).classList.add('active-tab');
            document.getElementById('section-' + name).classList.add('active-section');
        }
    </script>

    <style>
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: var(--spacing-lg);
            gap: var(--spacing-md);
        }

        @media (max-width: 1024px) {
            #section-general>div[style*="grid-template-columns: 1fr 1fr"] {
                grid-template-columns: 1fr !important;
            }
        }

        @media (max-width: 768px) {
            div[style*="grid-template-columns: 1fr 1fr"] {
                grid-template-columns: 1fr !important;
            }

            .section-header {
                flex-direction: column;
                align-items: stretch !important;
            }

            .section-button {
                width: 100% !important;
                justify-content: center !important;
            }

            .stat-value {
                font-size: 1.75rem !important;
            }

            .stat-card {
                padding: var(--spacing-md) !important;
            }

            .page-header {
                flex-wrap: nowrap !important;
                align-items: flex-start !important;
            }

            .page-header>div:last-child {
                display: flex;
                flex-wrap: nowrap !important;
                gap: var(--spacing-xs) !important;
                flex-shrink: 0;
            }

            .page-header .btn {
                padding: 0.5rem 1rem !important;
                min-width: 90px;
                justify-content: center;
            }
        }
    </style>
</x-app-layout>
