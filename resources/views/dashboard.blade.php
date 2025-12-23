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

    <!-- Quick Actions -->
    <div class="card mb-2xl">
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

    <div class="grid grid-cols-2">
        <!-- Recent Activity -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-history"></i> Actividad Reciente</h3>
            </div>
            <div class="card-body">
                @if($recentActivities->count() > 0)
                    <div style="display: flex; flex-direction: column; gap: var(--spacing-lg);">
                        @foreach($recentActivities as $activity)
                            <div style="display: flex; gap: var(--spacing-md); padding: var(--spacing-md); background: var(--gray-50); border-radius: var(--radius-md);">
                                <div style="width: 40px; height: 40px; background: var(--theme-color); border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.25rem; flex-shrink: 0;">
                                    <i class="fas {{ $activity['icon'] }}"></i>
                                </div>
                                <div style="flex: 1;">
                                    <div style="font-weight: 600; color: var(--gray-900); margin-bottom: var(--spacing-xs);">
                                        {{ $activity['title'] }}
                                    </div>
                                    <div style="font-size: 0.875rem; color: var(--gray-600);">
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
                                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: var(--spacing-xs);">
                                    <div style="font-weight: 600; color: var(--gray-900);">
                                        {{ $prueba->titulo }} - {{ $prueba->curso->nombre }}
                                    </div>
                                    <span class="badge {{ $badgeClass }}">{{ $badgeText }}</span>
                                </div>
                                <div style="font-size: 0.875rem; color: var(--gray-600);">
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
