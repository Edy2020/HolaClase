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
    <div
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
    <div class="card mb-xl">
        <div class="card-header">
            <h3 class="card-title">Filtros</h3>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('attendance.index') }}">
                <div class="grid grid-cols-5">
                    <div class="form-group mb-0">
                        <label class="form-label">Curso</label>
                        <select name="curso_id" class="form-select">
                            <option value="">Todos los cursos</option>
                            @foreach($cursos as $curso)
                                <option value="{{ $curso->id }}" {{ request('curso_id') == $curso->id ? 'selected' : '' }}>
                                    {{ $curso->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label">Asignatura</label>
                        <select name="asignatura_id" class="form-select">
                            <option value="">Todas las asignaturas</option>
                            @foreach($asignaturas as $asignatura)
                                <option value="{{ $asignatura->id }}" {{ request('asignatura_id') == $asignatura->id ? 'selected' : '' }}>
                                    {{ $asignatura->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label">Fecha</label>
                        <input type="date" name="fecha" class="form-input" value="{{ request('fecha') }}">
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label">Estado</label>
                        <select name="estado" class="form-select">
                            <option value="">Todos</option>
                            <option value="presente" {{ request('estado') == 'presente' ? 'selected' : '' }}>Presente
                            </option>
                            <option value="ausente" {{ request('estado') == 'ausente' ? 'selected' : '' }}>Ausente
                            </option>
                            <option value="tarde" {{ request('estado') == 'tarde' ? 'selected' : '' }}>Tarde</option>
                            <option value="justificado" {{ request('estado') == 'justificado' ? 'selected' : '' }}>
                                Justificado</option>
                        </select>
                    </div>
                    <div class="form-group mb-0" style="display: flex; align-items: flex-end;">
                        <button type="submit" class="btn btn-primary" style="width: 100%; color: white;">
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
                <div style="overflow-x: auto;">
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