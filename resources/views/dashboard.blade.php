<x-app-layout>
    <x-slot name="header">
        Dashboard
    </x-slot>


    <div style="margin-bottom: var(--spacing-xl);">
        <h1 style="font-size: 2.25rem; font-weight: 800; color: var(--gray-900); margin-bottom: var(--spacing-lg); letter-spacing: -0.02em;">
            ¡Bienvenido, {{ Auth::user()->name ?? 'Usuario' }}!
        </h1>
        
        <div class="mobile-tabs-container">
            <div id="tab-summary" onclick="switchDashboardTab('summary')" class="dash-tab active-tab">
                Resumen
            </div>
            <div id="tab-activity" onclick="switchDashboardTab('activity')" class="dash-tab">
                Reciente
            </div>
            <div id="tab-tasks" onclick="switchDashboardTab('tasks')" class="dash-tab">
                Próximas Tareas
            </div>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: var(--spacing-md);">
        <div class="desktop-quick-actions" style="display: flex; gap: var(--spacing-sm); flex-wrap: wrap;">
                <a href="{{ route('courses.create') }}" class="action-pill">
                    <i class="fas fa-book"></i> Curso
                </a>
                <a href="{{ route('students.create') }}" class="action-pill">
                    <i class="fas fa-user-plus"></i> Estudiante
                </a>
                <a href="{{ route('attendance.dashboard') }}" class="action-pill">
                    <i class="fas fa-clipboard-check"></i> Asistencia
                </a>
                <a href="{{ route('grades.dashboard') }}" class="action-pill">
                    <i class="fas fa-star"></i> Notas
                </a>
            </div>
        </div>
    </div>

    <div id="section-summary" class="tab-section active-section" style="display: flex; flex-wrap: wrap; margin-bottom: var(--spacing-2xl); padding-top: var(--spacing-xl);">
        @php
            $statsData = [
                ['label' => 'Total Cursos',      'value' => str_pad($totalCursos, 2, '0', STR_PAD_LEFT),      'color' => '#84cc16', 'trend' => '+ 20%'],
                ['label' => 'Total Estudiantes', 'value' => str_pad($totalEstudiantes, 2, '0', STR_PAD_LEFT), 'color' => '#ef4444', 'trend' => '- 5%'],
                ['label' => 'Asistencia Global', 'value' => '94%',             'color' => '#84cc16', 'trend' => '+ 12%'],
            ];
        @endphp
        
        @foreach($statsData as $index => $s)
            <div class="stat-item" style="flex: 1; min-width: 250px; padding: 0 var(--spacing-xl) var(--spacing-lg); {{ $index > 0 ? 'border-left: 1px solid var(--gray-200);' : 'padding-left: 0;' }}">
                <div style="font-size: 0.85rem; color: var(--gray-500); font-weight: 500; margin-bottom: 24px;">{{ $s['label'] }}</div>
                <div style="font-size: 2.75rem; font-weight: 800; color: var(--gray-900); line-height: 1; margin-bottom: 12px;">{{ $s['value'] }}</div>
            </div>
        @endforeach
    </div>

    <button id="fabButton" class="fab-button" onclick="toggleSpeedDial()" aria-label="Acciones Rápidas">
        <i id="fabIcon" class="fas fa-bolt"></i>
    </button>

    <div id="speedDialActions" class="speed-dial-actions">
        <a href="{{ route('courses.create') }}" class="speed-dial-item" style="text-decoration: none;">
            <span class="speed-dial-label">Crear Curso</span>
            <div class="speed-dial-button">
                <i class="fas fa-book"></i>
            </div>
        </a>
        <a href="{{ route('students.create') }}" class="speed-dial-item" style="text-decoration: none;">
            <span class="speed-dial-label">Añadir Estudiante</span>
            <div class="speed-dial-button">
                <i class="fas fa-user-plus"></i>
            </div>
        </a>
        <a href="{{ route('attendance.dashboard') }}" class="speed-dial-item" style="text-decoration: none;">
            <span class="speed-dial-label">Asistencia</span>
            <div class="speed-dial-button">
                <i class="fas fa-clipboard-check"></i>
            </div>
        </a>
        <a href="{{ route('grades.dashboard') }}" class="speed-dial-item" style="text-decoration: none;">
            <span class="speed-dial-label">Notas</span>
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

    </div>

    <div id="speedDialBackdrop" class="speed-dial-backdrop" onclick="closeSpeedDial()"></div>

    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}?v={{ time() }}">

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

    <div class="grid grid-cols-2 mobile-grid-break" style="gap: var(--spacing-2xl);">
        <div id="section-activity" class="tab-section">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-lg);">
                <h3 style="font-size: 1.125rem; font-weight: 700; color: var(--gray-900);">Actividad Reciente</h3>
                <i class="fas fa-ellipsis-h" style="color: var(--gray-400); cursor: pointer;"></i>
            </div>
            <div class="activity-card-bg" style="background: var(--bg-card, white); border: 1px solid var(--gray-200); border-radius: 8px; overflow: hidden;">
                @if($recentActivities->count() > 0)
                    <div style="display: flex; flex-direction: column;">
                        @foreach($recentActivities as $activity)
                            <div style="display: flex; gap: var(--spacing-md); padding: 16px var(--spacing-lg); border-bottom: 1px solid var(--gray-100); align-items: center;">
                                <div style="width: 8px; height: 8px; border-radius: 50%; background: #84cc16; flex-shrink: 0;"></div>
                                <div style="flex: 1; min-width: 0;">
                                    <div style="font-weight: 600; color: var(--gray-900); font-size: 0.9rem;">
                                        {{ $activity['title'] }}
                                    </div>
                                    <div style="font-size: 0.8rem; color: var(--gray-500);">
                                        {{ $activity['description'] }}
                                    </div>
                                </div>
                                <div style="font-size: 0.75rem; color: var(--gray-400); white-space: nowrap;">
                                    {{ $activity['created_at']->diffForHumans() }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div style="text-align: center; padding: var(--spacing-2xl); color: var(--gray-500);">
                        <p style="margin: 0; font-size: 0.9rem;">No hay actividad reciente</p>
                    </div>
                @endif
            </div>
        </div>

        <div id="section-tasks" class="tab-section">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-lg);">
                <h3 style="font-size: 1.125rem; font-weight: 700; color: var(--gray-900);">Próximas Tareas</h3>
                <i class="fas fa-ellipsis-h" style="color: var(--gray-400); cursor: pointer;"></i>
            </div>
            <div class="tasks-card-bg" style="background: var(--bg-card, white); border: 1px solid var(--gray-200); border-radius: 8px; overflow: hidden;">
                @if($upcomingPruebas->count() > 0)
                    <div style="display: flex; flex-direction: column;">
                        @foreach($upcomingPruebas as $prueba)
                            @php
                                $daysUntil = now()->diffInDays($prueba->fecha, false);
                                $dotColor = $daysUntil <= 1 ? '#ef4444' : ($daysUntil <= 3 ? '#f59e0b' : '#3b82f6');
                            @endphp
                            <div style="display: flex; gap: var(--spacing-md); padding: 16px var(--spacing-lg); border-bottom: 1px solid var(--gray-100); align-items: center;">
                                <div style="width: 8px; height: 8px; border-radius: 50%; background: {{ $dotColor }}; flex-shrink: 0;"></div>
                                <div style="flex: 1; min-width: 0;">
                                    <div style="font-weight: 600; color: var(--gray-900); font-size: 0.9rem; word-break: break-word;">
                                        {{ $prueba->titulo }} - {{ $prueba->curso->nombre }}
                                    </div>
                                    <div style="font-size: 0.8rem; color: var(--gray-500); word-break: break-word;">
                                        @if($prueba->asignatura) {{ $prueba->asignatura->nombre }} • @endif
                                        {{ $prueba->fecha->format('d/m/Y') }}
                                        @if($prueba->hora) , {{ $prueba->hora }} @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div style="text-align: center; padding: var(--spacing-2xl); color: var(--gray-500);">
                        <p style="margin: 0; font-size: 0.9rem;">No hay pruebas programadas</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function switchDashboardTab(tabId) {
            // Update tabs visually
            document.querySelectorAll('.dash-tab').forEach(t => t.classList.remove('active-tab'));
            document.getElementById('tab-' + tabId).classList.add('active-tab');

            // Toggle content visibility
            document.querySelectorAll('.tab-section').forEach(s => s.classList.remove('active-section'));
            document.getElementById('section-' + tabId).classList.add('active-section');
        }
    </script>
</x-app-layout>

