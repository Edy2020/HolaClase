<x-app-layout>
    <x-slot name="header">
        Control de Asistencia
    </x-slot>

    @if(session('success'))
        <div id="successMessage" class="alert alert-success"
            style="background: #10b981; color: white; padding: var(--spacing-md); border-radius: var(--radius-md); margin-bottom: var(--spacing-lg);">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
        <script>
            setTimeout(() => {
                const msg = document.getElementById('successMessage');
                if (msg) {
                    msg.style.opacity = '0';
                    setTimeout(() => msg.style.display = 'none', 500);
                }
            }, 3000);
        </script>
    @endif

    <!-- Hero Header -->
    <div class="hero-header"
        style="background: var(--theme-dark); color: white; padding: var(--spacing-2xl); border-radius: var(--radius-xl); margin-bottom: var(--spacing-2xl); box-shadow: var(--shadow-lg);">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h2 style="color: white; font-size: 1.75rem; font-weight: 700; margin-bottom: var(--spacing-sm);">
                    <i class="fas fa-calendar-check"></i> Control de Asistencia
                </h2>
                <p style="font-size: 1rem; opacity: 0.95; margin: 0;">
                    Gestiona y monitorea la asistencia de los estudiantes
                </p>
            </div>
            <a href="{{ route('attendance.create') }}" class="btn btn-accent" style="color: white;">
                <i class="fas fa-plus"></i> Tomar Asistencia
            </a>
        </div>
    </div>

    <style>
        /* Mobile Responsive Styles for Asistencia */
        @media (max-width: 768px) {
            /* Hero header responsive */
            .hero-header {
                flex-direction: column !important;
                gap: var(--spacing-md) !important;
                text-align: center !important;
            }

            .hero-header > div:first-child {
                width: 100%;
            }

            .hero-header h2 {
                font-size: 1.5rem !important;
            }

            .hero-header p {
                font-size: 0.875rem !important;
            }

            .hero-header .btn {
                width: 100% !important;
            }

            /* Statistics grid - 2 columns on mobile */
            .grid.grid-cols-5 {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: var(--spacing-sm) !important;
            }

            /* Last stat card spans 2 columns */
            .grid.grid-cols-5 > .stat-card:last-child {
                grid-column: 1 / -1 !important;
            }

            /* Stat cards more compact */
            .stat-card {
                padding: var(--spacing-md) !important;
            }

            .stat-value {
                font-size: 1.5rem !important;
            }

            .stat-label {
                font-size: 0.75rem !important;
            }

            /* Hide table on mobile, show cards */
            .attendance-table-container {
                display: none !important;
            }

            .mobile-attendance-cards {
                display: block !important;
            }
        }

        /* Desktop: Show table, hide cards */
        @media (min-width: 769px) {
            .mobile-attendance-cards {
                display: none !important;
            }

            .attendance-table-container {
                display: block !important;
            }
        }
    </style>

    <!-- Statistics -->
    <div class="grid grid-cols-5 mb-xl">
        <div class="stat-card">
            <div class="stat-value" style="color: var(--theme-color);">{{ $stats['total'] }}</div>
            <div class="stat-label">Total Registros</div>
        </div>
        <div class="stat-card">
            <div class="stat-value" style="color: var(--success);">{{ $stats['presente'] }}</div>
            <div class="stat-label">Presentes</div>
        </div>
        <div class="stat-card">
            <div class="stat-value" style="color: var(--error);">{{ $stats['ausente'] }}</div>
            <div class="stat-label">Ausentes</div>
        </div>
        <div class="stat-card">
            <div class="stat-value" style="color: var(--warning);">{{ $stats['tarde'] }}</div>
            <div class="stat-label">Tardanzas</div>
        </div>
        <div class="stat-card">
            <div class="stat-value" style="color: var(--info);">{{ $stats['porcentaje_asistencia'] }}%</div>
            <div class="stat-label">% Asistencia</div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-xl" style="border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
        <div class="card-body" style="padding: var(--spacing-lg);">
            <form method="GET" action="{{ route('attendance.index') }}">
                <div class="grid grid-cols-5" style="gap: var(--spacing-md); align-items: end;">
                    <!-- Curso Filter -->
                    <div class="form-group mb-0">
                        <label class="form-label" style="font-size: 0.875rem; font-weight: 600; color: var(--gray-700); margin-bottom: var(--spacing-xs);">Curso</label>
                        <div style="position: relative;">
                            <div style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--gray-400); font-size: 1rem; pointer-events: none; z-index: 1;">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <select name="curso_id" class="form-select" 
                                style="padding-left: 40px; border: 2px solid var(--gray-200); border-radius: var(--radius-lg); transition: all 0.2s; font-size: 0.9375rem; cursor: pointer;"
                                onfocus="this.style.borderColor='var(--theme-color)'; this.style.boxShadow='0 0 0 3px rgba(139, 92, 246, 0.1)'"
                                onblur="this.style.borderColor='var(--gray-200)'; this.style.boxShadow='none'">
                                <option value="">Todos los cursos</option>
                                @foreach($cursos as $curso)
                                    <option value="{{ $curso->id }}" {{ request('curso_id') == $curso->id ? 'selected' : '' }}>
                                        {{ $curso->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <!-- Asignatura Filter -->
                    <div class="form-group mb-0">
                        <label class="form-label" style="font-size: 0.875rem; font-weight: 600; color: var(--gray-700); margin-bottom: var(--spacing-xs);">Asignatura</label>
                        <div style="position: relative;">
                            <div style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--gray-400); font-size: 1rem; pointer-events: none; z-index: 1;">
                                <i class="fas fa-book"></i>
                            </div>
                            <select name="asignatura_id" class="form-select" 
                                style="padding-left: 40px; border: 2px solid var(--gray-200); border-radius: var(--radius-lg); transition: all 0.2s; font-size: 0.9375rem; cursor: pointer;"
                                onfocus="this.style.borderColor='var(--theme-color)'; this.style.boxShadow='0 0 0 3px rgba(139, 92, 246, 0.1)'"
                                onblur="this.style.borderColor='var(--gray-200)'; this.style.boxShadow='none'">
                                <option value="">Todas las asignaturas</option>
                                @foreach($asignaturas as $asignatura)
                                    <option value="{{ $asignatura->id }}" {{ request('asignatura_id') == $asignatura->id ? 'selected' : '' }}>
                                        {{ $asignatura->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <!-- Fecha Filter -->
                    <div class="form-group mb-0">
                        <label class="form-label" style="font-size: 0.875rem; font-weight: 600; color: var(--gray-700); margin-bottom: var(--spacing-xs);">Fecha</label>
                        <div style="position: relative;">
                            <div style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--gray-400); font-size: 1rem; pointer-events: none; z-index: 1;">
                                <i class="fas fa-calendar"></i>
                            </div>
                            <input type="date" name="fecha" class="form-input" value="{{ request('fecha') }}" 
                                style="padding-left: 40px; border: 2px solid var(--gray-200); border-radius: var(--radius-lg); transition: all 0.2s; font-size: 0.9375rem;"
                                onfocus="this.style.borderColor='var(--theme-color)'; this.style.boxShadow='0 0 0 3px rgba(139, 92, 246, 0.1)'"
                                onblur="this.style.borderColor='var(--gray-200)'; this.style.boxShadow='none'">
                        </div>
                    </div>
                    
                    <!-- Estado Filter -->
                    <div class="form-group mb-0">
                        <label class="form-label" style="font-size: 0.875rem; font-weight: 600; color: var(--gray-700); margin-bottom: var(--spacing-xs);">Estado</label>
                        <div style="position: relative;">
                            <div style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--gray-400); font-size: 1rem; pointer-events: none; z-index: 1;">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <select name="estado" class="form-select" 
                                style="padding-left: 40px; border: 2px solid var(--gray-200); border-radius: var(--radius-lg); transition: all 0.2s; font-size: 0.9375rem; cursor: pointer;"
                                onfocus="this.style.borderColor='var(--theme-color)'; this.style.boxShadow='0 0 0 3px rgba(139, 92, 246, 0.1)'"
                                onblur="this.style.borderColor='var(--gray-200)'; this.style.boxShadow='none'">
                                <option value="">Todos</option>
                                <option value="presente" {{ request('estado') == 'presente' ? 'selected' : '' }}>Presente</option>
                                <option value="ausente" {{ request('estado') == 'ausente' ? 'selected' : '' }}>Ausente</option>
                                <option value="tarde" {{ request('estado') == 'tarde' ? 'selected' : '' }}>Tarde</option>
                                <option value="justificado" {{ request('estado') == 'justificado' ? 'selected' : '' }}>Justificado</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Submit Button -->
                    <div class="form-group mb-0">
                        <button type="submit" class="btn btn-primary" style="width: 100%; color: white; height: 42px; border-radius: var(--radius-lg); font-weight: 600;">
                            <i class="fas fa-search"></i> Filtrar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Attendance Records -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Registros de Asistencia</h3>
        </div>
        <div class="card-body">
            @if($asistencias->count() > 0)
                <!-- Mobile Cards View (hidden on desktop) -->
                <div class="mobile-attendance-cards" style="display: none;">
                    @foreach($asistencias as $asistencia)
                        <div class="card mb-md" style="padding: var(--spacing-md);">
                            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: var(--spacing-md);">
                                <div style="flex: 1;">
                                    <div style="font-weight: 700; color: var(--gray-900); font-size: 1rem; margin-bottom: var(--spacing-xs);">{{ $asistencia->estudiante->nombre }} {{ $asistencia->estudiante->apellido }}</div>
                                    <div style="font-size: 0.875rem; color: var(--gray-600);">{{ $asistencia->fecha->format('d/m/Y') }}</div>
                                </div>
                                <span class="badge badge-{{ $asistencia->estado_color }}">
                                    {{ $asistencia->estado_label }}
                                </span>
                            </div>
                            
                            <div style="display: grid; grid-template-columns: 1fr; gap: var(--spacing-sm); margin-bottom: var(--spacing-md); padding: var(--spacing-md); background: var(--gray-50); border-radius: var(--radius-md);">
                                <div>
                                    <div style="font-size: 0.75rem; color: var(--gray-500); text-transform: uppercase; margin-bottom: var(--spacing-xs);">Curso</div>
                                    <div style="font-weight: 600; color: var(--gray-900); font-size: 0.875rem;">{{ $asistencia->curso->nombre }}</div>
                                </div>
                                <div>
                                    <div style="font-size: 0.75rem; color: var(--gray-500); text-transform: uppercase; margin-bottom: var(--spacing-xs);">Asignatura</div>
                                    <div style="font-weight: 600; color: var(--gray-900); font-size: 0.875rem;">{{ $asistencia->asignatura->nombre }}</div>
                                </div>
                                @if($asistencia->notas)
                                    <div>
                                        <div style="font-size: 0.75rem; color: var(--gray-500); text-transform: uppercase; margin-bottom: var(--spacing-xs);">Notas</div>
                                        <div style="color: var(--gray-700); font-size: 0.875rem;">{{ $asistencia->notas }}</div>
                                    </div>
                                @endif
                            </div>

                            <form action="{{ route('attendance.destroy', $asistencia) }}" method="POST" onsubmit="return confirm('¿Eliminar este registro?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline btn-sm" style="width: 100%; color: var(--error); border-color: var(--error);">
                                    <i class="fas fa-trash"></i> Eliminar Registro
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>

                <!-- Desktop Table View (hidden on mobile) -->
                <div class="attendance-table-container" style="overflow-x: auto;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Curso</th>
                                <th>Asignatura</th>
                                <th>Estudiante</th>
                                <th>Estado</th>
                                <th>Notas</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($asistencias as $asistencia)
                                <tr>
                                    <td>{{ $asistencia->fecha->format('d/m/Y') }}</td>
                                    <td>{{ $asistencia->curso->nombre }}</td>
                                    <td>{{ $asistencia->asignatura->nombre }}</td>
                                    <td>{{ $asistencia->estudiante->nombre }} {{ $asistencia->estudiante->apellido }}</td>
                                    <td>
                                        <span class="badge badge-{{ $asistencia->estado_color }}">
                                            {{ $asistencia->estado_label }}
                                        </span>
                                    </td>
                                    <td>{{ $asistencia->notas ? Str::limit($asistencia->notas, 30) : '-' }}</td>
                                    <td>
                                        <form action="{{ route('attendance.destroy', $asistencia) }}" method="POST"
                                            style="display: inline;" onsubmit="return confirm('¿Eliminar este registro?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline"
                                                style="color: #ef4444; border-color: #ef4444;">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div style="margin-top: var(--spacing-lg);">
                    {{ $asistencias->links() }}
                </div>
            @else
                <div
                    style="text-align: center; padding: var(--spacing-2xl); background: var(--gray-50); border-radius: var(--radius-md);">
                    <i class="fas fa-calendar-times"
                        style="font-size: 3rem; color: var(--gray-300); margin-bottom: var(--spacing-md);"></i>
                    <p style="color: var(--gray-600);">No hay registros de asistencia</p>
                    <a href="{{ route('attendance.create') }}" class="btn btn-primary"
                        style="margin-top: var(--spacing-md); color: white;">
                        <i class="fas fa-plus"></i> Tomar Asistencia
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>