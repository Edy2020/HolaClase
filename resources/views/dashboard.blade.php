<x-app-layout>
    <x-slot name="header">
        Dashboard
    </x-slot>

    <!-- Welcome Card -->
    <div style="background: var(--theme-dark); color: white; padding: var(--spacing-2xl); border-radius: var(--radius-xl); margin-bottom: var(--spacing-2xl); box-shadow: var(--shadow-lg);">
        <h2 style="color: white; font-size: 1.75rem; font-weight: 700; margin-bottom: var(--spacing-sm);">
            ¡Bienvenido, {{ Auth::user()->name }}! <i class="fas fa-hand-wave"></i>
        </h2>
        <p style="font-size: 1rem; opacity: 0.95; margin: 0;">
            Aquí tienes un resumen de tu actividad y accesos rápidos a las funciones principales
        </p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-4 mb-2xl">
        <div class="stat-card fade-in" style="animation-delay: 0.1s;">
            <div class="stat-icon">
                <i class="fas fa-book"></i>
            </div>
            <div class="stat-value">{{ $totalCursos }}</div>
            <div class="stat-label">CURSOS ACTIVOS</div>
        </div>

        <div class="stat-card fade-in" style="animation-delay: 0.2s;">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-value">{{ $totalEstudiantes }}</div>
            <div class="stat-label">ESTUDIANTES</div>
        </div>

        <div class="stat-card fade-in" style="animation-delay: 0.3s;">
            <div class="stat-icon">
                <i class="fas fa-check"></i>
            </div>
            <div class="stat-value">94%</div>
            <div class="stat-label">ASISTENCIA PROMEDIO</div>
        </div>

        <div class="stat-card fade-in" style="animation-delay: 0.4s;">
            <div class="stat-icon">
                <i class="fas fa-clipboard"></i>
            </div>
            <div class="stat-value">8.5</div>
            <div class="stat-label">PROMEDIO GENERAL</div>
        </div>
    </div>

    <!-- Quick Actions (Hidden on mobile) -->
    <div class="card mb-2xl quick-actions-card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-bolt"></i> Acciones Rápidas</h3>
        </div>
        <div class="card-body">
            <div class="grid grid-cols-3">
                <a href="{{ route('courses.create') }}" class="btn btn-primary" style="text-decoration: none;">
                    <span><i class="fas fa-book" style="color: white;"></i></span>
                    <span style="color: white;">Crear Curso</span>
                </a>
                <a href="{{ route('students.index') }}" class="btn btn-secondary" style="text-decoration: none;">
                    <span><i class="fas fa-users"></i></span>
                    <span>Añadir Estudiante</span>
                </a>
                <a href="{{ route('attendance.index') }}" class="btn btn-accent" style="text-decoration: none;">
                    <span><i class="fas fa-check" style="color: white;"></i></span>
                    <span style="color: white;">Pasar Asistencia</span>
                </a>
                <a href="{{ route('grades.index') }}" class="btn btn-outline" style="text-decoration: none;">
                    <span><i class="fas fa-clipboard"></i></span>
                    <span>Registrar Notas</span>
                </a>
                <a href="{{ route('dashboard') }}" class="btn btn-outline" style="text-decoration: none;">
                    <span><i class="fas fa-chart-bar"></i></span>
                    <span>Ver Reportes</span>
                </a>
                <a href="{{ route('settings.index') }}" class="btn btn-outline" style="text-decoration: none;">
                    <span><i class="fas fa-cog"></i></span>
                    <span>Configuración</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Floating Action Button (Mobile only) -->
    <button id="fabButton" class="fab-button" onclick="toggleSpeedDial()" aria-label="Acciones Rápidas">
        <i id="fabIcon" class="fas fa-bolt"></i>
    </button>

    <!-- Speed Dial Actions (Mobile only) -->
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

    <!-- Backdrop overlay -->
    <div id="speedDialBackdrop" class="speed-dial-backdrop" onclick="closeSpeedDial()"></div>

    <style>
        /* Floating Action Button */
        .fab-button {
            display: none;
            position: fixed;
            bottom: 24px;
            right: 24px;
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: var(--theme-color);
            color: white;
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15), 0 2px 6px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            z-index: 999;
            font-size: 1.5rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .fab-button:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2), 0 3px 8px rgba(0, 0, 0, 0.15);
        }

        .fab-button:active {
            transform: scale(0.95);
        }

        .fab-button.active {
            background: var(--error);
        }

        .fab-button.active #fabIcon::before {
            content: "\f00d";
        }

        #fabIcon {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Speed Dial Actions */
        .speed-dial-actions {
            display: none;
            position: fixed;
            bottom: 92px;
            right: 24px;
            z-index: 998;
            flex-direction: column;
            gap: 12px;
            align-items: flex-end;
        }

        .speed-dial-actions.active {
            display: flex;
        }

        .speed-dial-item {
            display: flex;
            align-items: center;
            gap: 12px;
            opacity: 0;
            transform: translateY(20px) scale(0.8);
            animation: speedDialItemIn 0.3s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        .speed-dial-item:nth-child(1) { animation-delay: 0.05s; }
        .speed-dial-item:nth-child(2) { animation-delay: 0.1s; }
        .speed-dial-item:nth-child(3) { animation-delay: 0.15s; }
        .speed-dial-item:nth-child(4) { animation-delay: 0.2s; }
        .speed-dial-item:nth-child(5) { animation-delay: 0.25s; }
        .speed-dial-item:nth-child(6) { animation-delay: 0.3s; }

        .speed-dial-button {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: var(--theme-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.375rem;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.15), 0 1px 4px rgba(0, 0, 0, 0.1);
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .speed-dial-button i {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .speed-dial-button:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.2), 0 2px 6px rgba(0, 0, 0, 0.15);
        }

        .speed-dial-label {
            background: white;
            color: var(--theme-color);
            padding: 10px 16px;
            border-radius: 24px;
            font-size: 1rem;
            font-weight: 600;
            white-space: nowrap;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            opacity: 1;
            transform: translateX(0);
        }

        /* Backdrop */
        .speed-dial-backdrop {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.3);
            z-index: 997;
            animation: fadeIn 0.2s ease-out;
        }

        .speed-dial-backdrop.active {
            display: block;
        }

        @keyframes speedDialItemIn {
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Mobile Responsive Styles for Dashboard */
        @media (max-width: 768px) {
            /* Hide quick actions card on mobile */
            .quick-actions-card {
                display: none !important;
            }

            /* Show FAB on mobile */
            .fab-button {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            /* Stack grid columns on mobile */
            .grid.grid-cols-2,
            .grid.grid-cols-3 {
                grid-template-columns: 1fr !important;
                gap: var(--spacing-md) !important;
            }

            /* Statistics grid - 2 columns on mobile */
            .grid.grid-cols-4 {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: var(--spacing-md) !important;
            }

            /* Make activity items more compact on mobile */
            .activity-item {
                gap: var(--spacing-sm) !important;
                padding: var(--spacing-sm) !important;
                align-items: center !important;
            }

            .activity-item .activity-icon {
                width: 32px !important;
                height: 32px !important;
                font-size: 1rem !important;
            }

            /* Optimize task items for mobile */
            .task-item-header {
                flex-direction: row !important;
                align-items: center !important;
                gap: var(--spacing-xs) !important;
                flex-wrap: wrap !important;
            }

            .task-item-title {
                font-size: 0.9375rem !important;
                word-break: break-word !important;
                line-height: 1.4 !important;
            }

            .task-item-details {
                font-size: 0.8125rem !important;
                display: flex !important;
                align-items: center !important;
                gap: var(--spacing-xs) !important;
                flex-wrap: wrap !important;
            }

            /* Make task cards more compact */
            .task-item-header + .task-item-details {
                margin-top: var(--spacing-xs) !important;
            }

            /* Smaller badges in tasks */
            .task-item-header .badge {
                font-size: 0.6875rem !important;
                padding: 2px 8px !important;
                font-weight: 600 !important;
            }

            /* Compact task cards container */
            .card-body > div {
                gap: var(--spacing-sm) !important;
            }

            /* Reduce padding in task cards */
            .card-body > div > div[style*="padding"] {
                padding: var(--spacing-sm) !important;
            }
        }

        /* Desktop: Hide FAB and speed dial */
        @media (min-width: 769px) {
            .fab-button,
            .speed-dial-actions,
            .speed-dial-backdrop {
                display: none !important;
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
            const fabButton = document.getElementById('fabButton');
            const fabIcon = document.getElementById('fabIcon');
            const speedDialActions = document.getElementById('speedDialActions');
            const backdrop = document.getElementById('speedDialBackdrop');

            fabButton.classList.remove('active');
            fabIcon.className = 'fas fa-bolt';
            speedDialActions.classList.remove('active');
            backdrop.classList.remove('active');
        }

        // Close on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && speedDialOpen) {
                closeSpeedDial();
            }
        });
    </script>

    <div class="grid grid-cols-2" style="gap: var(--spacing-lg);">
        <!-- Recent Activity -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-history"></i> Actividad Reciente</h3>
            </div>
            <div class="card-body">
                @if($recentActivities->count() > 0)
                    <div style="display: flex; flex-direction: column; gap: var(--spacing-lg);">
                        @foreach($recentActivities as $activity)
                            <div class="activity-item" style="display: flex; gap: var(--spacing-md); padding: var(--spacing-md); background: var(--gray-50); border-radius: var(--radius-md);">
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

        <!-- Upcoming Tasks -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-calendar-alt"></i> Próximas Tareas</h3>
            </div>
            <div class="card-body">
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
