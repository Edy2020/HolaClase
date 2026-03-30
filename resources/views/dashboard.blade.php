<x-app-layout>
    <x-slot name="header">
        Dashboard
    </x-slot>

    <div class="dashboard-main-header" style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: flex-start; margin-bottom: var(--spacing-xl); padding-bottom: var(--spacing-lg); border-bottom: 1px solid var(--gray-200); gap: var(--spacing-md);">
        <div class="dashboard-greeting-box">
            <h2 class="dashboard-greeting-title" style="font-size: 1.5rem; font-weight: 600; color: var(--gray-800); margin: 0 0 4px 0; letter-spacing: -0.5px;">
                Bienvenido, {{ Auth::user()->name }}
            </h2>
            <p class="dashboard-greeting-subtitle" style="font-size: 0.875rem; color: var(--gray-500); margin: 0;">
                Panel de control y resumen general del sistema
            </p>
        </div>
        <div class="mobile-date-pill" style="font-size: 0.875rem; font-weight: 500; color: var(--gray-600); background: white; border: 1px solid var(--gray-200); padding: 8px 16px; border-radius: var(--radius-md); display: flex; align-items: center; gap: 8px; box-shadow: 0 1px 2px rgba(0,0,0,0.02);">
            <i class="fas fa-calendar-day" style="color: var(--theme-color);"></i> {{ ucfirst(\Carbon\Carbon::now()->translatedFormat('l, d \d\e F, Y')) }}
        </div>
    </div>

    <div class="stats-container" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(135px, 1fr)); gap: var(--spacing-md); margin-bottom: var(--spacing-xl);">
        @foreach([
            ['icon' => 'fa-book',      'value' => $totalCursos,      'label' => 'Cursos',      'color' => 'var(--theme-color)', 'delay' => '0.1s'],
            ['icon' => 'fa-users',     'value' => $totalEstudiantes, 'label' => 'Estudiantes', 'color' => '#3b82f6',          'delay' => '0.2s'],
            ['icon' => 'fa-check',     'value' => '94%',             'label' => 'Asistencia',  'color' => 'var(--success)',   'delay' => '0.3s'],
            ['icon' => 'fa-clipboard', 'value' => '8.5',             'label' => 'Promedio',    'color' => 'var(--warning)',    'delay' => '0.4s'],
        ] as $s)
            <div class="card stat-dash-card fade-in" style="animation-delay: {{ $s['delay'] }}; padding: 12px; display: flex; flex-direction: row; align-items: center; gap: 12px; border: 1px solid var(--gray-200); box-shadow: 0 2px 4px rgba(0,0,0,0.02); border-radius: var(--radius-lg);">
                <div class="stat-icon-box" style="width: 38px; height: 38px; border-radius: var(--radius-md); background: {{ $s['color'] }}15; color: {{ $s['color'] }}; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0;">
                    <i class="fas {{ $s['icon'] }}"></i>
                </div>
                <div style="overflow: hidden; min-width: 0;">
                    <div class="stat-value" style="font-size: 1.35rem; font-weight: 800; color: var(--gray-900); line-height: 1;">{{ $s['value'] }}</div>
                    <div class="stat-label" style="font-size: 0.7rem; font-weight: 600; color: var(--gray-500); text-transform: uppercase; letter-spacing: 0.05em; margin-top: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $s['label'] }}</div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="quick-actions-wrapper" style="margin-bottom: var(--spacing-2xl);">
        <h3 style="font-size: 0.8125rem; font-weight: 700; color: var(--gray-500); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: var(--spacing-sm);">Accesos Directos</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(130px, 1fr)); gap: var(--spacing-md);">
            <a href="{{ route('courses.create') }}" class="btn" style="background: white; border: 1px solid var(--gray-200); color: var(--theme-color); justify-content: center; text-align: center; padding: 16px 8px; height: auto; flex-direction: column; gap: 8px; font-weight: 600; border-radius: var(--radius-lg); transition: all 0.2s;" onmouseover="this.style.borderColor='var(--theme-color)'; this.style.backgroundColor='var(--gray-50)'" onmouseout="this.style.borderColor='var(--gray-200)'; this.style.backgroundColor='white'">
                <i class="fas fa-plus-circle" style="font-size: 1.25rem;"></i>
                <span style="font-size: 0.8125rem; white-space: normal; line-height: 1.2;">Crear Curso</span>
            </a>
            <a href="{{ route('students.index') }}" class="btn" style="background: white; border: 1px solid var(--gray-200); color: #3b82f6; justify-content: center; text-align: center; padding: 16px 8px; height: auto; flex-direction: column; gap: 8px; font-weight: 600; border-radius: var(--radius-lg); transition: all 0.2s;" onmouseover="this.style.borderColor='#3b82f6'; this.style.backgroundColor='var(--gray-50)'" onmouseout="this.style.borderColor='var(--gray-200)'; this.style.backgroundColor='white'">
                <i class="fas fa-user-plus" style="font-size: 1.25rem;"></i>
                <span style="font-size: 0.8125rem; white-space: normal; line-height: 1.2;">Estudiante</span>
            </a>
            <a href="{{ route('attendance.index') }}" class="btn" style="background: white; border: 1px solid var(--gray-200); color: var(--success); justify-content: center; text-align: center; padding: 16px 8px; height: auto; flex-direction: column; gap: 8px; font-weight: 600; border-radius: var(--radius-lg); transition: all 0.2s;" onmouseover="this.style.borderColor='var(--success)'; this.style.backgroundColor='var(--gray-50)'" onmouseout="this.style.borderColor='var(--gray-200)'; this.style.backgroundColor='white'">
                <i class="fas fa-clipboard-check" style="font-size: 1.25rem;"></i>
                <span style="font-size: 0.8125rem; white-space: normal; line-height: 1.2;">Asistencia</span>
            </a>
            <a href="{{ route('grades.index') }}" class="btn" style="background: white; border: 1px solid var(--gray-200); color: var(--warning); justify-content: center; text-align: center; padding: 16px 8px; height: auto; flex-direction: column; gap: 8px; font-weight: 600; border-radius: var(--radius-lg); transition: all 0.2s;" onmouseover="this.style.borderColor='var(--warning)'; this.style.backgroundColor='var(--gray-50)'" onmouseout="this.style.borderColor='var(--gray-200)'; this.style.backgroundColor='white'">
                <i class="fas fa-star" style="font-size: 1.25rem;"></i>
                <span style="font-size: 0.8125rem; white-space: normal; line-height: 1.2;">Notas</span>
            </a>
            <a href="{{ route('dashboard') }}" class="btn" style="background: white; border: 1px solid var(--gray-200); color: var(--gray-600); justify-content: center; text-align: center; padding: 16px 8px; height: auto; flex-direction: column; gap: 8px; font-weight: 600; border-radius: var(--radius-lg); transition: all 0.2s;" onmouseover="this.style.borderColor='var(--gray-400)'; this.style.backgroundColor='var(--gray-50)'" onmouseout="this.style.borderColor='var(--gray-200)'; this.style.backgroundColor='white'">
                <i class="fas fa-chart-pie" style="font-size: 1.25rem;"></i>
                <span style="font-size: 0.8125rem; white-space: normal; line-height: 1.2;">Reportes</span>
            </a>
            <a href="{{ route('settings.index') }}" class="btn" style="background: white; border: 1px solid var(--gray-200); color: var(--gray-600); justify-content: center; text-align: center; padding: 16px 8px; height: auto; flex-direction: column; gap: 8px; font-weight: 600; border-radius: var(--radius-lg); transition: all 0.2s;" onmouseover="this.style.borderColor='var(--gray-400)'; this.style.backgroundColor='var(--gray-50)'" onmouseout="this.style.borderColor='var(--gray-200)'; this.style.backgroundColor='white'">
                <i class="fas fa-cog" style="font-size: 1.25rem;"></i>
                <span style="font-size: 0.8125rem; white-space: normal; line-height: 1.2;">Ajustes</span>
            </a>
        </div>
    </div>

    <button id="fabButton" class="fab-button" onclick="toggleSpeedDial()" aria-label="Acciones Rápidas">
        <i id="fabIcon" class="fas fa-bolt"></i>
    </button>

    <div id="speedDialActions" class="speed-dial-actions">
        <a href="{{ route('courses.create') }}" class="speed-dial-item" style="text-decoration: none;">
            <span class="speed-dial-label">Crear Curso</span>
            <div class="speed-dial-button" style="background: white; color: var(--theme-color);">
                <i class="fas fa-book"></i>
            </div>
        </a>
        <a href="{{ route('students.create') }}" class="speed-dial-item" style="text-decoration: none;">
            <span class="speed-dial-label">Añadir Estudiante</span>
            <div class="speed-dial-button" style="background: white; color: var(--theme-color);">
                <i class="fas fa-user-plus"></i>
            </div>
        </a>
        <a href="{{ route('attendance.create') }}" class="speed-dial-item" style="text-decoration: none;">
            <span class="speed-dial-label">Tomar Asistencia</span>
            <div class="speed-dial-button" style="background: #10b981;">
                <i class="fas fa-clipboard-check" style="color: white;"></i>
            </div>
        </a>
        <a href="{{ route('grades.index') }}" class="speed-dial-item" style="text-decoration: none;">
            <span class="speed-dial-label">Registrar Notas</span>
            <div class="speed-dial-button">
                <i class="fas fa-star"></i>
            </div>
        </a>
        <a href="{{ route('dashboard') }}" class="speed-dial-item" style="text-decoration: none;">
            <span class="speed-dial-label">Ver Reportes</span>
            <div class="speed-dial-button">
                <i class="fas fa-chart-line"></i>
            </div>
        </a>
        <a href="{{ route('settings.index') }}" class="speed-dial-item" style="text-decoration: none;">
            <span class="speed-dial-label">Configuración</span>
            <div class="speed-dial-button">
                <i class="fas fa-cog"></i>
            </div>
        </a>
    </div>

    <div id="speedDialBackdrop" class="speed-dial-backdrop" onclick="closeSpeedDial()"></div>

    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

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
            const fabButton = document.getElementById('fabButton');
            const fabIcon = document.getElementById('fabIcon');
            const speedDialActions = document.getElementById('speedDialActions');
            const backdrop = document.getElementById('speedDialBackdrop');

            fabButton.classList.remove('active');
            fabIcon.className = 'fas fa-bolt';
            speedDialActions.classList.remove('active');
            backdrop.classList.remove('active');
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && speedDialOpen) {
                closeSpeedDial();
            }
        });
    </script>

    <div class="grid grid-cols-2" style="gap: var(--spacing-lg);">
        <div class="card">
            <div class="card-header" style="padding: var(--spacing-md) var(--spacing-lg);">
                <h3 class="card-title" style="font-size: 1rem;"><i class="fas fa-history"></i> Actividad Reciente</h3>
            </div>
            <div class="card-body" style="padding: var(--spacing-md) var(--spacing-lg);">
                @if($recentActivities->count() > 0)
                    <div style="display: flex; flex-direction: column; gap: var(--spacing-md);">
                        @foreach($recentActivities as $activity)
                            <div class="activity-item" style="display: flex; gap: var(--spacing-md); padding: 12px; background: var(--gray-50); border-radius: var(--radius-md);">
                                <div class="activity-icon" style="width: 40px; height: 40px; background: var(--theme-color); border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.25rem; flex-shrink: 0;">
                                    <i class="fas {{ $activity['icon'] }}"></i>
                                </div>
                                <div style="flex: 1; min-width: 0;">
                                    <div style="font-weight: 600; color: var(--gray-900); margin-bottom: var(--spacing-xs); word-break: break-word;">
                                        {{ $activity['title'] }}
                                    </div>
                                    <div style="font-size: 0.875rem; color: var(--gray-600); word-break: break-word;">
                                        {{ $activity['description'] }} - {{ $activity['created_at']->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div style="text-align: center; padding: var(--spacing-2xl); color: var(--gray-500);">
                        <i class="fas fa-inbox" style="font-size: 3rem; margin-bottom: var(--spacing-md); opacity: 0.3;"></i>
                        <p style="margin: 0;">No hay actividad reciente</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header" style="padding: var(--spacing-md) var(--spacing-lg);">
                <h3 class="card-title" style="font-size: 1rem;"><i class="fas fa-calendar-alt"></i> Próximas Tareas</h3>
            </div>
            <div class="card-body" style="padding: var(--spacing-md) var(--spacing-lg);">
                @if($upcomingPruebas->count() > 0)
                    <div style="display: flex; flex-direction: column; gap: var(--spacing-lg);">
                        @foreach($upcomingPruebas as $prueba)
                            @php
                                $daysUntil = now()->diffInDays($prueba->fecha, false);
                                if ($daysUntil == 0) {
                                    $borderColor = 'var(--error)';
                                    $badgeClass = 'badge-error';
                                    $badgeText = 'Hoy';
                                } elseif ($daysUntil == 1) {
                                    $borderColor = 'var(--error)';
                                    $badgeClass = 'badge-error';
                                    $badgeText = 'Mañana';
                                } elseif ($daysUntil <= 3) {
                                    $borderColor = 'var(--warning)';
                                    $badgeClass = 'badge-warning';
                                    $badgeText = 'Próximo';
                                } else {
                                    $borderColor = 'var(--theme-light)';
                                    $badgeClass = 'badge-primary';
                                    $badgeText = 'Programado';
                                }
                            @endphp
                            <div style="padding: var(--spacing-md); border-left: 4px solid {{ $borderColor }}; background: var(--gray-50); border-radius: var(--radius-md);">
                                <div class="task-item-header" style="display: flex; justify-content: space-between; align-items: start; margin-bottom: var(--spacing-xs);">
                                    <div class="task-item-title" style="font-weight: 600; color: var(--gray-900); flex: 1; min-width: 0; word-break: break-word;">
                                        {{ $prueba->titulo }} - {{ $prueba->curso->nombre }}
                                    </div>
                                    <span class="badge {{ $badgeClass }}" style="flex-shrink: 0; margin-left: var(--spacing-xs);">{{ $badgeText }}</span>
                                </div>
                                <div class="task-item-details" style="font-size: 0.875rem; color: var(--gray-600); word-break: break-word;">
                                    @if($prueba->asignatura)
                                        {{ $prueba->asignatura->nombre }} • 
                                    @endif
                                    {{ $prueba->fecha->format('d/m/Y') }}
                                    @if($prueba->hora)
                                        , {{ $prueba->hora }}
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div style="text-align: center; padding: var(--spacing-2xl); color: var(--gray-500);">
                        <i class="fas fa-calendar-check" style="font-size: 3rem; margin-bottom: var(--spacing-md); opacity: 0.3;"></i>
                        <p style="margin: 0;">No hay pruebas programadas</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
