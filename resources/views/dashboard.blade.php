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
            <div class="stat-value">12</div>
            <div class="stat-label">CURSOS ACTIVOS</div>
        </div>

        <div class="stat-card fade-in" style="animation-delay: 0.2s;">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-value">248</div>
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
                <a href="#" class="btn btn-primary" style="text-decoration: none;">
                    <span><i class="fas fa-book" style="color: white;"></i></span>
                    <span style="color: white;">Crear Curso</span>
                </a>
                <a href="#" class="btn btn-secondary" style="text-decoration: none;">
                    <span><i class="fas fa-users"></i></span>
                    <span>Añadir Estudiante</span>
                </a>
                <a href="#" class="btn btn-accent" style="text-decoration: none;">
                    <span><i class="fas fa-check" style="color: white;"></i></span>
                    <span style="color: white;">Pasar Asistencia</span>
                </a>
                <a href="#" class="btn btn-outline" style="text-decoration: none;">
                    <span><i class="fas fa-clipboard"></i></span>
                    <span>Registrar Calificaciones</span>
                </a>
                <a href="#" class="btn btn-outline" style="text-decoration: none;">
                    <span><i class="fas fa-chart-bar"></i></span>
                    <span>Ver Reportes</span>
                </a>
                <a href="#" class="btn btn-outline" style="text-decoration: none;">
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
                <div style="display: flex; flex-direction: column; gap: var(--spacing-lg);">
                    <div style="display: flex; gap: var(--spacing-md); padding: var(--spacing-md); background: var(--gray-50); border-radius: var(--radius-md);">
                        <div style="width: 40px; height: 40px; background: var(--theme-color); border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.25rem; flex-shrink: 0;">
                            <i class="fas fa-book"></i>
                        </div>
                        <div style="flex: 1;">
                            <div style="font-weight: 600; color: var(--gray-900); margin-bottom: var(--spacing-xs);">
                                Nuevo curso creado
                            </div>
                            <div style="font-size: 0.875rem; color: var(--gray-600);">
                                Matemáticas Avanzadas - Hace 2 horas
                            </div>
                        </div>
                    </div>

                    <div style="display: flex; gap: var(--spacing-md); padding: var(--spacing-md); background: var(--gray-50); border-radius: var(--radius-md);">
                        <div style="width: 40px; height: 40px; background: var(--theme-color); border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.25rem; flex-shrink: 0;">
                            <i class="fas fa-check"></i>
                        </div>
                        <div style="flex: 1;">
                            <div style="font-weight: 600; color: var(--gray-900); margin-bottom: var(--spacing-xs);">
                                Asistencia registrada
                            </div>
                            <div style="font-size: 0.875rem; color: var(--gray-600);">
                                Física I - Hace 3 horas
                            </div>
                        </div>
                    </div>

                    <div style="display: flex; gap: var(--spacing-md); padding: var(--spacing-md); background: var(--gray-50); border-radius: var(--radius-md);">
                        <div style="width: 40px; height: 40px; background: var(--theme-color); border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.25rem; flex-shrink: 0;">
                            <i class="fas fa-clipboard"></i>
                        </div>
                        <div style="flex: 1;">
                            <div style="font-weight: 600; color: var(--gray-900); margin-bottom: var(--spacing-xs);">
                                Calificaciones actualizadas
                            </div>
                            <div style="font-size: 0.875rem; color: var(--gray-600);">
                                Química Orgánica - Hace 5 horas
                            </div>
                        </div>
                    </div>

                    <div style="display: flex; gap: var(--spacing-md); padding: var(--spacing-md); background: var(--gray-50); border-radius: var(--radius-md);">
                        <div style="width: 40px; height: 40px; background: var(--theme-color); border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.25rem; flex-shrink: 0;">
                            <i class="fas fa-users"></i>
                        </div>
                        <div style="flex: 1;">
                            <div style="font-weight: 600; color: var(--gray-900); margin-bottom: var(--spacing-xs);">
                                Nuevo estudiante registrado
                            </div>
                            <div style="font-size: 0.875rem; color: var(--gray-600);">
                                María González - Hace 1 día
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upcoming Tasks -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-calendar-alt"></i> Próximas Tareas</h3>
            </div>
            <div class="card-body">
                <div style="display: flex; flex-direction: column; gap: var(--spacing-lg);">
                    <div style="padding: var(--spacing-md); border-left: 4px solid var(--error); background: var(--gray-50); border-radius: var(--radius-md);">
                        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: var(--spacing-xs);">
                            <div style="font-weight: 600; color: var(--gray-900);">
                                Examen Final - Cálculo II
                            </div>
                            <span class="badge badge-error">Urgente</span>
                        </div>
                        <div style="font-size: 0.875rem; color: var(--gray-600);">
                            Mañana, 10:00 AM
                        </div>
                    </div>

                    <div style="padding: var(--spacing-md); border-left: 4px solid var(--warning); background: var(--gray-50); border-radius: var(--radius-md);">
                        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: var(--spacing-xs);">
                            <div style="font-weight: 600; color: var(--gray-900);">
                                Entrega de Notas - Historia
                            </div>
                            <span class="badge badge-warning">Pendiente</span>
                        </div>
                        <div style="font-size: 0.875rem; color: var(--gray-600);">
                            En 3 días
                        </div>
                    </div>

                    <div style="padding: var(--spacing-md); border-left: 4px solid var(--theme-light); background: var(--gray-50); border-radius: var(--radius-md);">
                        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: var(--spacing-xs);">
                            <div style="font-weight: 600; color: var(--gray-900);">
                                Reunión de Profesores
                            </div>
                            <span class="badge badge-primary">Programado</span>
                        </div>
                        <div style="font-size: 0.875rem; color: var(--gray-600);">
                            Viernes, 3:00 PM
                        </div>
                    </div>

                    <div style="padding: var(--spacing-md); border-left: 4px solid var(--success); background: var(--gray-50); border-radius: var(--radius-md);">
                        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: var(--spacing-xs);">
                            <div style="font-weight: 600; color: var(--gray-900);">
                                Revisión de Asistencia
                            </div>
                            <span class="badge badge-success">Completado</span>
                        </div>
                        <div style="font-size: 0.875rem; color: var(--gray-600);">
                            Ayer
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
