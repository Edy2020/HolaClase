<x-app-layout>
    <x-slot name="header">
        Dashboard
    </x-slot>

    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}?v={{ time() }}">

    <div style="margin-bottom: var(--spacing-xl);">
        <h1 style="font-size: 2.25rem; font-weight: 800; color: var(--gray-900); margin-bottom: 4px; letter-spacing: -0.02em;">
            ¡Hola, {{ $profesor->nombre }}!
        </h1>
        <p style="color: var(--gray-500); font-size: 0.9375rem; margin: 0;">
            <i class="fas fa-chalkboard-teacher" style="margin-right: 4px;"></i>
            {{ $profesor->titulo ?? 'Profesor' }} · {{ $cursos->count() }} {{ $cursos->count() === 1 ? 'curso' : 'cursos' }} asignados
        </p>
    </div>

    <div class="mobile-tabs-container">
        <div id="tab-resumen" onclick="switchProfesorTab('resumen')" class="dash-tab active-tab">Resumen</div>
        <div id="tab-cursos" onclick="switchProfesorTab('cursos')" class="dash-tab">Mis Cursos</div>
        <div id="tab-agenda" onclick="switchProfesorTab('agenda')" class="dash-tab">Agenda</div>
        <div id="tab-calendario" onclick="switchProfesorTab('calendario')" class="dash-tab">Calendario</div>
        <div id="tab-asistencia" onclick="switchProfesorTab('asistencia')" class="dash-tab">Asistencia</div>
    </div>

    <div class="desktop-tabs-container">
        <div id="d-tab-general" onclick="switchDesktopProfesorTab('general')" class="dash-tab active-tab">Vista General</div>
        <div id="d-tab-calendario" onclick="switchDesktopProfesorTab('calendario')" class="dash-tab">Calendario</div>
    </div>

    <div id="desktop-section-general" class="desktop-tab-section active-desktop-section">
    <div id="section-resumen" class="prof-section active-prof-section">
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: var(--spacing-md); margin-bottom: var(--spacing-xl);">
            <div style="background: var(--bg-card, white); border: 1px solid var(--border-color, var(--gray-200)); border-radius: var(--radius-lg); padding: var(--spacing-lg); text-align: center;">
                <div style="font-size: 2.5rem; font-weight: 800; color: #84cc16; line-height: 1;">{{ $cursos->count() }}</div>
                <div style="font-size: 0.8125rem; color: var(--gray-500); margin-top: 8px; font-weight: 500;">
                    <i class="fas fa-graduation-cap"></i> Cursos
                </div>
            </div>
            <div style="background: var(--bg-card, white); border: 1px solid var(--border-color, var(--gray-200)); border-radius: var(--radius-lg); padding: var(--spacing-lg); text-align: center;">
                <div style="font-size: 2.5rem; font-weight: 800; color: var(--gray-900); line-height: 1;">{{ $totalEstudiantes }}</div>
                <div style="font-size: 0.8125rem; color: var(--gray-500); margin-top: 8px; font-weight: 500;">
                    <i class="fas fa-users"></i> Estudiantes
                </div>
            </div>
            <div style="background: var(--bg-card, white); border: 1px solid var(--border-color, var(--gray-200)); border-radius: var(--radius-lg); padding: var(--spacing-lg); text-align: center;">
                <div style="font-size: 2.5rem; font-weight: 800; color: var(--gray-900); line-height: 1;">{{ $totalAsignaturas }}</div>
                <div style="font-size: 0.8125rem; color: var(--gray-500); margin-top: 8px; font-weight: 500;">
                    <i class="fas fa-book"></i> Asignaturas
                </div>
            </div>
            <div style="background: var(--bg-card, white); border: 1px solid var(--border-color, var(--gray-200)); border-radius: var(--radius-lg); padding: var(--spacing-lg); text-align: center;">
                @php
                    $attColor = $globalAttendance >= 85 ? '#84cc16' : ($globalAttendance >= 75 ? '#f59e0b' : '#ef4444');
                @endphp
                <div style="font-size: 2.5rem; font-weight: 800; color: {{ $attColor }}; line-height: 1;">{{ $globalAttendance }}%</div>
                <div style="font-size: 0.8125rem; color: var(--gray-500); margin-top: 8px; font-weight: 500;">
                    <i class="fas fa-calendar-check"></i> Asistencia
                </div>
            </div>
        </div>

        <div class="desktop-quick-actions" style="display: flex; gap: var(--spacing-sm); flex-wrap: wrap; margin-bottom: var(--spacing-xl);">
            <a href="{{ route('attendance.create') }}" class="action-pill" style="text-decoration: none;">
                <i class="fas fa-clipboard-check"></i> Tomar Asistencia
            </a>
            <a href="{{ route('grades.create') }}" class="action-pill" style="text-decoration: none;">
                <i class="fas fa-star"></i> Registrar Notas
            </a>
            <a href="{{ route('courses.index') }}" class="action-pill" style="text-decoration: none;">
                <i class="fas fa-graduation-cap"></i> Ver Mis Cursos
            </a>
            <a href="{{ route('attendance.dashboard') }}" class="action-pill" style="text-decoration: none;">
                <i class="fas fa-chart-bar"></i> Reportes Asistencia
            </a>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--spacing-lg);" class="prof-grid-2col">
            <div style="background: var(--bg-card, white); border: 1px solid var(--border-color, var(--gray-200)); border-radius: var(--radius-lg); overflow: hidden;">
                <div style="padding: var(--spacing-md) var(--spacing-lg); border-bottom: 1px solid var(--border-color, var(--gray-200)); display: flex; justify-content: space-between; align-items: center;">
                    <h3 style="font-size: 1rem; font-weight: 700; color: var(--gray-900); margin: 0;">
                        <i class="fas fa-file-alt" style="color: var(--gray-400); margin-right: 6px;"></i>Próximas Pruebas
                    </h3>
                </div>
                @if($upcomingPruebas->count() > 0)
                    @foreach($upcomingPruebas as $prueba)
                        @php
                            $daysUntil = now()->diffInDays($prueba->fecha, false);
                            $dotColor = $daysUntil <= 1 ? '#ef4444' : ($daysUntil <= 3 ? '#f59e0b' : '#3b82f6');
                        @endphp
                        <div style="display: flex; gap: var(--spacing-md); padding: 14px var(--spacing-lg); border-bottom: 1px solid var(--gray-100); align-items: center;">
                            <div style="width: 8px; height: 8px; border-radius: 50%; background: {{ $dotColor }}; flex-shrink: 0;"></div>
                            <div style="flex: 1; min-width: 0;">
                                <div style="font-weight: 600; color: var(--gray-900); font-size: 0.9rem;">
                                    {{ $prueba->titulo }}
                                </div>
                                <div style="font-size: 0.8rem; color: var(--gray-500);">
                                    {{ $prueba->curso->nombre }}
                                    @if($prueba->asignatura) · {{ $prueba->asignatura->nombre }} @endif
                                    · {{ $prueba->fecha->format('d/m/Y') }}
                                    @if($prueba->hora) {{ $prueba->hora }} @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div style="text-align: center; padding: var(--spacing-2xl); color: var(--gray-500);">
                        <i class="fas fa-clipboard-list" style="font-size: 2rem; margin-bottom: var(--spacing-sm); opacity: 0.3;"></i>
                        <p style="margin: 0; font-size: 0.9rem;">No hay pruebas programadas</p>
                    </div>
                @endif
            </div>

            <div style="background: var(--bg-card, white); border: 1px solid var(--border-color, var(--gray-200)); border-radius: var(--radius-lg); overflow: hidden;">
                <div style="padding: var(--spacing-md) var(--spacing-lg); border-bottom: 1px solid var(--border-color, var(--gray-200)); display: flex; justify-content: space-between; align-items: center;">
                    <h3 style="font-size: 1rem; font-weight: 700; color: var(--gray-900); margin: 0;">
                        <i class="fas fa-calendar-alt" style="color: var(--gray-400); margin-right: 6px;"></i>Próximos Eventos
                    </h3>
                </div>
                @if($upcomingEvents->count() > 0)
                    @foreach($upcomingEvents as $evento)
                        <div style="display: flex; gap: var(--spacing-md); padding: 14px var(--spacing-lg); border-bottom: 1px solid var(--gray-100); align-items: center;">
                            <div style="width: 8px; height: 8px; border-radius: 50%; background: #84cc16; flex-shrink: 0;"></div>
                            <div style="flex: 1; min-width: 0;">
                                <div style="font-weight: 600; color: var(--gray-900); font-size: 0.9rem;">
                                    {{ $evento->titulo }}
                                </div>
                                <div style="font-size: 0.8rem; color: var(--gray-500);">
                                    {{ $evento->curso->nombre }} · {{ $evento->fecha_inicio->format('d/m/Y') }}
                                    · <span style="text-transform: capitalize;">{{ $evento->tipo }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div style="text-align: center; padding: var(--spacing-2xl); color: var(--gray-500);">
                        <i class="fas fa-calendar-times" style="font-size: 2rem; margin-bottom: var(--spacing-sm); opacity: 0.3;"></i>
                        <p style="margin: 0; font-size: 0.9rem;">No hay eventos próximos</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div id="section-cursos" class="prof-section">
        <h3 style="font-size: 1.125rem; font-weight: 700; color: var(--gray-900); margin-bottom: var(--spacing-lg);">
            Mis Cursos ({{ $cursos->count() }})
        </h3>
        @if($cursos->count() > 0)
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: var(--spacing-md);">
                @foreach($cursos as $curso)
                    <a href="{{ route('courses.show', $curso) }}" style="text-decoration: none; color: inherit;">
                        <div style="background: var(--bg-card, white); border: 1px solid var(--border-color, var(--gray-200)); border-radius: var(--radius-lg); padding: var(--spacing-lg); transition: all 0.2s; cursor: pointer;"
                            onmouseover="this.style.borderColor='#84cc16'; this.style.boxShadow='0 4px 12px rgba(132,204,22,0.1)'"
                            onmouseout="this.style.borderColor='var(--border-color, var(--gray-200))'; this.style.boxShadow='none'">
                            <div style="display: flex; align-items: center; gap: var(--spacing-md); margin-bottom: var(--spacing-md);">
                                <div style="width: 48px; height: 48px; border-radius: 50%; background: #84cc16; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 0.875rem; flex-shrink: 0;">
                                    @if($curso->nivel === 'Pre-Kinder' || $curso->nivel === 'Kinder')
                                        {{ strtoupper(substr($curso->nivel, 0, 2)) }}{{ $curso->letra }}
                                    @else
                                        {{ $curso->grado }}{{ $curso->letra }}
                                    @endif
                                </div>
                                <div style="flex: 1; min-width: 0;">
                                    <div style="font-weight: 700; color: var(--gray-900); font-size: 1.0625rem;">{{ $curso->nombre }}</div>
                                    <div style="font-size: 0.8125rem; color: var(--gray-500);">{{ ucfirst($curso->nivel) }}</div>
                                </div>
                            </div>
                            <div style="display: flex; gap: var(--spacing-lg);">
                                <div style="display: flex; align-items: center; gap: 6px; font-size: 0.8125rem; color: var(--gray-600);">
                                    <i class="fas fa-users" style="color: var(--gray-400);"></i>
                                    <span style="font-weight: 600;">{{ $curso->estudiantes_count }}</span> estudiantes
                                </div>
                                <div style="display: flex; align-items: center; gap: 6px; font-size: 0.8125rem; color: var(--gray-600);">
                                    <i class="fas fa-book" style="color: var(--gray-400);"></i>
                                    <span style="font-weight: 600;">{{ $curso->asignaturas->count() }}</span> asignaturas
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div style="background: var(--bg-card, white); border: 1px dashed var(--border-color, var(--gray-300)); border-radius: var(--radius-lg); padding: var(--spacing-2xl); text-align: center;">
                <i class="fas fa-graduation-cap" style="font-size: 3rem; color: var(--gray-300); margin-bottom: var(--spacing-md);"></i>
                <p style="color: var(--gray-500); margin: 0; font-size: 1rem;">No tienes cursos asignados actualmente</p>
                <p style="color: var(--gray-400); margin: 8px 0 0; font-size: 0.875rem;">Contacta al administrador para que te asigne cursos</p>
            </div>
        @endif
    </div>

    <div id="section-agenda" class="prof-section">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--spacing-lg);" class="prof-grid-2col">
            <div>
                <h3 style="font-size: 1.125rem; font-weight: 700; color: var(--gray-900); margin-bottom: var(--spacing-lg);">
                    <i class="fas fa-file-alt" style="color: var(--gray-400); margin-right: 6px;"></i>Pruebas Programadas
                </h3>
                <div style="background: var(--bg-card, white); border: 1px solid var(--border-color, var(--gray-200)); border-radius: var(--radius-lg); overflow: hidden;">
                    @if($upcomingPruebas->count() > 0)
                        @foreach($upcomingPruebas as $prueba)
                            @php
                                $daysUntil = now()->diffInDays($prueba->fecha, false);
                                $urgencyColor = $daysUntil <= 1 ? '#ef4444' : ($daysUntil <= 3 ? '#f59e0b' : '#84cc16');
                            @endphp
                            <div style="padding: var(--spacing-md) var(--spacing-lg); border-bottom: 1px solid var(--gray-100);">
                                <div style="display: flex; justify-content: space-between; align-items: start;">
                                    <div style="flex: 1; min-width: 0;">
                                        <div style="font-weight: 700; color: var(--gray-900); font-size: 0.9375rem; margin-bottom: 4px;">
                                            {{ $prueba->titulo }}
                                        </div>
                                        <div style="font-size: 0.8125rem; color: var(--gray-500);">
                                            <i class="fas fa-graduation-cap"></i> {{ $prueba->curso->nombre }}
                                            @if($prueba->asignatura) · <i class="fas fa-book"></i> {{ $prueba->asignatura->nombre }} @endif
                                        </div>
                                        <div style="font-size: 0.8125rem; color: var(--gray-500); margin-top: 2px;">
                                            <i class="fas fa-calendar"></i> {{ $prueba->fecha->format('d/m/Y') }}
                                            @if($prueba->hora) · <i class="fas fa-clock"></i> {{ $prueba->hora }} @endif
                                            @if($prueba->ponderacion) · {{ $prueba->ponderacion }}% @endif
                                        </div>
                                    </div>
                                    <div style="padding: 4px 10px; border-radius: 9999px; font-size: 0.6875rem; font-weight: 700; background: {{ $urgencyColor }}20; color: {{ $urgencyColor }}; white-space: nowrap;">
                                        @if($daysUntil <= 0) Hoy
                                        @elseif($daysUntil == 1) Mañana
                                        @else En {{ $daysUntil }} días
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div style="text-align: center; padding: var(--spacing-2xl); color: var(--gray-500);">
                            <i class="fas fa-clipboard-list" style="font-size: 2rem; margin-bottom: var(--spacing-sm); opacity: 0.3;"></i>
                            <p style="margin: 0; font-size: 0.9rem;">No hay pruebas programadas</p>
                        </div>
                    @endif
                </div>
            </div>

            <div>
                <h3 style="font-size: 1.125rem; font-weight: 700; color: var(--gray-900); margin-bottom: var(--spacing-lg);">
                    <i class="fas fa-calendar-alt" style="color: var(--gray-400); margin-right: 6px;"></i>Eventos Académicos
                </h3>
                <div style="background: var(--bg-card, white); border: 1px solid var(--border-color, var(--gray-200)); border-radius: var(--radius-lg); overflow: hidden;">
                    @if($upcomingEvents->count() > 0)
                        @foreach($upcomingEvents as $evento)
                            @php
                                $typeColors = [
                                    'vacaciones' => '#84cc16',
                                    'reunion' => '#3b82f6',
                                    'actividad' => '#f59e0b',
                                    'examen' => '#ef4444',
                                    'otro' => '#6b7280',
                                ];
                                $evColor = $typeColors[$evento->tipo] ?? '#6b7280';
                            @endphp
                            <div style="padding: var(--spacing-md) var(--spacing-lg); border-bottom: 1px solid var(--gray-100);">
                                <div style="display: flex; align-items: start; gap: var(--spacing-sm);">
                                    <div style="width: 4px; height: 36px; border-radius: 2px; background: {{ $evColor }}; flex-shrink: 0; margin-top: 2px;"></div>
                                    <div style="flex: 1; min-width: 0;">
                                        <div style="font-weight: 700; color: var(--gray-900); font-size: 0.9375rem;">{{ $evento->titulo }}</div>
                                        <div style="font-size: 0.8125rem; color: var(--gray-500);">
                                            {{ $evento->curso->nombre }} · {{ $evento->fecha_inicio->format('d/m/Y') }}
                                            · <span style="text-transform: capitalize;">{{ $evento->tipo }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div style="text-align: center; padding: var(--spacing-2xl); color: var(--gray-500);">
                            <i class="fas fa-calendar-times" style="font-size: 2rem; margin-bottom: var(--spacing-sm); opacity: 0.3;"></i>
                            <p style="margin: 0; font-size: 0.9rem;">No hay eventos próximos</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div id="section-asistencia" class="prof-section">
        <h3 style="font-size: 1.125rem; font-weight: 700; color: var(--gray-900); margin-bottom: var(--spacing-lg);">
            Asistencia por Curso (Este Mes)
        </h3>
        @if(count($attendanceStats) > 0)
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: var(--spacing-md);">
                @foreach($attendanceStats as $stat)
                    <div style="background: var(--bg-card, white); border: 1px solid var(--border-color, var(--gray-200)); border-radius: var(--radius-lg); padding: var(--spacing-lg);">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-md);">
                            <div style="font-weight: 700; color: var(--gray-900); font-size: 0.9375rem;">{{ $stat['curso'] }}</div>
                            @if($stat['porcentaje'] !== null)
                                @php
                                    $barColor = $stat['porcentaje'] >= 85 ? '#84cc16' : ($stat['porcentaje'] >= 75 ? '#f59e0b' : '#ef4444');
                                @endphp
                                <span style="font-weight: 800; font-size: 1.25rem; color: {{ $barColor }};">{{ $stat['porcentaje'] }}%</span>
                            @else
                                <span style="font-size: 0.8125rem; color: var(--gray-400);">Sin datos</span>
                            @endif
                        </div>
                        @if($stat['porcentaje'] !== null)
                            <div style="height: 6px; background: var(--gray-200); border-radius: 3px; overflow: hidden;">
                                <div style="height: 100%; width: {{ $stat['porcentaje'] }}%; background: {{ $barColor }}; border-radius: 3px; transition: width 0.5s;"></div>
                            </div>
                            <div style="font-size: 0.75rem; color: var(--gray-500); margin-top: 8px;">
                                {{ $stat['total'] }} registros este mes
                            </div>
                        @else
                            <div style="height: 6px; background: var(--gray-200); border-radius: 3px;"></div>
                            <div style="font-size: 0.75rem; color: var(--gray-400); margin-top: 8px;">
                                No se ha registrado asistencia este mes
                            </div>
                        @endif
                        <a href="{{ route('attendance.create', ['curso_id' => $stat['curso_id']]) }}" 
                            style="display: inline-flex; align-items: center; gap: 6px; margin-top: var(--spacing-sm); font-size: 0.8125rem; color: #84cc16; text-decoration: none; font-weight: 600;"
                            onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">
                            <i class="fas fa-clipboard-check"></i> Tomar Asistencia
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div style="background: var(--bg-card, white); border: 1px dashed var(--border-color, var(--gray-300)); border-radius: var(--radius-lg); padding: var(--spacing-2xl); text-align: center;">
                <i class="fas fa-calendar-check" style="font-size: 3rem; color: var(--gray-300); margin-bottom: var(--spacing-md);"></i>
                <p style="color: var(--gray-500); margin: 0;">No tienes cursos asignados para gestionar asistencia</p>
            </div>
        @endif
    </div>
    </div>

    <div id="desktop-section-calendario" class="desktop-tab-section">
        @include('partials.calendario')
    </div>

    <button id="fabButton" class="fab-button" onclick="toggleSpeedDial()" aria-label="Acciones Rápidas">
        <i id="fabIcon" class="fas fa-bolt"></i>
    </button>

    <div id="speedDialActions" class="speed-dial-actions">
        <a href="{{ route('attendance.create') }}" class="speed-dial-item" style="text-decoration: none;">
            <span class="speed-dial-label">Tomar Asistencia</span>
            <div class="speed-dial-button">
                <i class="fas fa-clipboard-check"></i>
            </div>
        </a>
        <a href="{{ route('grades.create') }}" class="speed-dial-item" style="text-decoration: none;">
            <span class="speed-dial-label">Registrar Notas</span>
            <div class="speed-dial-button">
                <i class="fas fa-star"></i>
            </div>
        </a>
        <a href="{{ route('courses.index') }}" class="speed-dial-item" style="text-decoration: none;">
            <span class="speed-dial-label">Mis Cursos</span>
            <div class="speed-dial-button">
                <i class="fas fa-graduation-cap"></i>
            </div>
        </a>
    </div>

    <div id="speedDialBackdrop" class="speed-dial-backdrop" onclick="closeSpeedDial()"></div>

    <style>
        .prof-section { display: none; }
        .prof-section.active-prof-section { display: block; }

        @media (min-width: 1025px) {
            .prof-section { display: block !important; }
            .prof-section + .prof-section { margin-top: var(--spacing-xl); }
        }

        @media (max-width: 768px) {
            .prof-grid-2col {
                grid-template-columns: 1fr !important;
            }
            #section-resumen > div:first-child {
                grid-template-columns: repeat(2, 1fr) !important;
            }
        }
    </style>

    <script>
        let speedDialOpen = false;

        function toggleSpeedDial() {
            speedDialOpen = !speedDialOpen;
            const fabButton = document.getElementById('fabButton');
            const fabIcon = document.getElementById('fabIcon');
            const speedDialActions = document.getElementById('speedDialActions');
            const backdrop = document.getElementById('speedDialBackdrop');

            if (speedDialOpen) {
                fabButton.classList.add('active');
                fabIcon.className = 'fas fa-times';
                speedDialActions.classList.add('active');
                backdrop.classList.add('active');
            } else {
                closeSpeedDial();
            }
        }

        function closeSpeedDial() {
            speedDialOpen = false;
            document.getElementById('fabButton').classList.remove('active');
            document.getElementById('fabIcon').className = 'fas fa-bolt';
            document.getElementById('speedDialActions').classList.remove('active');
            document.getElementById('speedDialBackdrop').classList.remove('active');
        }

        function switchDesktopProfesorTab(tabId) {
            document.getElementById('d-tab-general').classList.remove('active-tab');
            document.getElementById('d-tab-calendario').classList.remove('active-tab');
            document.getElementById('d-tab-' + tabId).classList.add('active-tab');

            document.getElementById('desktop-section-general').classList.remove('active-desktop-section');
            document.getElementById('desktop-section-calendario').classList.remove('active-desktop-section');
            document.getElementById('desktop-section-' + tabId).classList.add('active-desktop-section');
        }

        function switchProfesorTab(tabId) {
            document.querySelectorAll('.dash-tab').forEach(t => t.classList.remove('active-tab'));
            document.getElementById('tab-' + tabId).classList.add('active-tab');
            document.querySelectorAll('.prof-section').forEach(s => s.classList.remove('active-prof-section'));
            document.getElementById('section-' + tabId).classList.add('active-prof-section');
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && speedDialOpen) closeSpeedDial();
        });
    </script>
</x-app-layout>
