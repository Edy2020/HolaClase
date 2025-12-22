<x-app-layout>
    <x-slot name="header">
        {{ $curso->nombre }} - Detalles
    </x-slot>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success" style="background: #10b981; color: white; padding: var(--spacing-md); border-radius: var(--radius-md); margin-bottom: var(--spacing-lg);">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Header Section -->
    <div class="card" style="margin-bottom: var(--spacing-xl);">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: var(--spacing-md);">
            <div>
                <h2 style="font-size: 2rem; font-weight: 700; color: var(--gray-900); margin-bottom: var(--spacing-xs);">
                    {{ $curso->nombre }}
                </h2>
                <p style="color: var(--gray-600); font-size: 1rem;">
                    <i class="fas fa-layer-group"></i> {{ $curso->nivel }}
                    @if($curso->grado)
                        | <i class="fas fa-graduation-cap"></i> Grado: {{ $curso->grado }}
                    @endif
                    | <i class="fas fa-tag"></i> Sección: {{ $curso->letra }}
                </p>
            </div>
            <div style="display: flex; gap: var(--spacing-sm);">
                <a href="{{ route('courses.index') }}" class="btn btn-outline">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
                <a href="{{ route('courses.edit', $curso) }}" class="btn btn-primary" style="color: white;">
                    <i class="fas fa-edit"></i> Editar Curso
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--spacing-xl); margin-bottom: var(--spacing-xl);">
        
        <!-- Teacher Assignment Section -->
        <div class="card">
            <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900); margin-bottom: var(--spacing-lg); display: flex; align-items: center; gap: var(--spacing-sm);">
                <i class="fas fa-chalkboard-teacher" style="color: var(--theme-color);"></i>
                Profesor Asignado
            </h3>

            @if($curso->profesor)
                <div style="background: var(--gray-50); padding: var(--spacing-lg); border-radius: var(--radius-md); margin-bottom: var(--spacing-md);">
                    <div style="display: flex; align-items: center; gap: var(--spacing-md);">
                        <div style="width: 60px; height: 60px; border-radius: 50%; background: var(--theme-color); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem; font-weight: 700;">
                            {{ substr($curso->profesor->nombre, 0, 1) }}{{ substr($curso->profesor->apellido, 0, 1) }}
                        </div>
                        <div style="flex: 1;">
                            <p style="font-weight: 600; font-size: 1.125rem; color: var(--gray-900); margin-bottom: var(--spacing-xs);">
                                {{ $curso->profesor->nombre }} {{ $curso->profesor->apellido }}
                            </p>
                            <p style="color: var(--gray-600); font-size: 0.875rem; margin: 0;">
                                <i class="fas fa-envelope"></i> {{ $curso->profesor->email }}
                            </p>
                            @if($curso->profesor->telefono)
                                <p style="color: var(--gray-600); font-size: 0.875rem; margin: 0;">
                                    <i class="fas fa-phone"></i> {{ $curso->profesor->telefono }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            @else
                <div style="text-align: center; padding: var(--spacing-xl); background: var(--gray-50); border-radius: var(--radius-md); margin-bottom: var(--spacing-md);">
                    <i class="fas fa-user-slash" style="font-size: 3rem; color: var(--gray-300); margin-bottom: var(--spacing-md);"></i>
                    <p style="color: var(--gray-600);">No hay profesor asignado</p>
                </div>
            @endif

            <form action="{{ route('courses.assign-teacher', $curso) }}" method="POST">
                @csrf
                <div style="margin-bottom: var(--spacing-md);">
                    <label style="display: block; font-weight: 600; color: var(--gray-700); margin-bottom: var(--spacing-sm);">
                        Seleccionar Profesor
                    </label>
                    <select name="profesor_id" class="form-input" style="width: 100%;">
                        <option value="">Sin profesor</option>
                        @foreach($profesores as $profesor)
                            <option value="{{ $profesor->id }}" {{ $curso->profesor_id == $profesor->id ? 'selected' : '' }}>
                                {{ $profesor->nombre }} {{ $profesor->apellido }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%; color: white;">
                    <i class="fas fa-user-check"></i> Asignar Profesor
                </button>
            </form>
        </div>

        <!-- Quick Stats Section -->
        <div class="card">
            <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900); margin-bottom: var(--spacing-lg); display: flex; align-items: center; gap: var(--spacing-sm);">
                <i class="fas fa-chart-bar" style="color: var(--theme-color);"></i>
                Estadísticas Rápidas
            </h3>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--spacing-md);">
                <div style="text-align: center; padding: var(--spacing-lg); background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: var(--radius-md); color: white;">
                    <div style="font-size: 2.5rem; font-weight: 700; margin-bottom: var(--spacing-xs);">
                        {{ $curso->estudiantes->count() }}
                    </div>
                    <div style="font-size: 0.875rem; opacity: 0.9;">
                        <i class="fas fa-users"></i> Estudiantes
                    </div>
                </div>

                <div style="text-align: center; padding: var(--spacing-lg); background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: var(--radius-md); color: white;">
                    <div style="font-size: 2.5rem; font-weight: 700; margin-bottom: var(--spacing-xs);">
                        {{ $curso->asignaturas->count() }}
                    </div>
                    <div style="font-size: 0.875rem; opacity: 0.9;">
                        <i class="fas fa-book"></i> Asignaturas
                    </div>
                </div>

                <div style="text-align: center; padding: var(--spacing-lg); background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: var(--radius-md); color: white;">
                    <div style="font-size: 2.5rem; font-weight: 700; margin-bottom: var(--spacing-xs);">
                        {{ $curso->eventos->count() }}
                    </div>
                    <div style="font-size: 0.875rem; opacity: 0.9;">
                        <i class="fas fa-calendar"></i> Eventos
                    </div>
                </div>

                <div style="text-align: center; padding: var(--spacing-lg); background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); border-radius: var(--radius-md); color: white;">
                    <div style="font-size: 2.5rem; font-weight: 700; margin-bottom: var(--spacing-xs);">
                        {{ $curso->pruebas->count() }}
                    </div>
                    <div style="font-size: 0.875rem; opacity: 0.9;">
                        <i class="fas fa-file-alt"></i> Pruebas
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Students Section -->
    <div class="card" style="margin-bottom: var(--spacing-xl);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-lg);">
            <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900); display: flex; align-items: center; gap: var(--spacing-sm); margin: 0;">
                <i class="fas fa-users" style="color: var(--theme-color);"></i>
                Estudiantes Inscritos ({{ $curso->estudiantes->count() }})
            </h3>
            <button onclick="document.getElementById('addStudentModal').style.display='flex'" class="btn btn-primary" style="color: white;">
                <i class="fas fa-user-plus"></i> Agregar Estudiante
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
                            <th>Fecha Inscripción</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($curso->estudiantes as $estudiante)
                            <tr>
                                <td>{{ $estudiante->rut }}</td>
                                <td>{{ $estudiante->nombre }} {{ $estudiante->apellido }}</td>
                                <td>{{ $estudiante->email ?? '-' }}</td>
                                <td>{{ $estudiante->telefono ?? '-' }}</td>
                                <td>{{ $estudiante->pivot->fecha_inscripcion->format('d/m/Y') }}</td>
                                <td>
                                    <form action="{{ route('courses.remove-student', [$curso, $estudiante]) }}" method="POST" 
                                        onsubmit="return confirm('¿Estás seguro de querer remover este estudiante del curso?');" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline" style="color: #ef4444; border-color: #ef4444;">
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
            <div style="text-align: center; padding: var(--spacing-2xl); background: var(--gray-50); border-radius: var(--radius-md);">
                <i class="fas fa-users-slash" style="font-size: 3rem; color: var(--gray-300); margin-bottom: var(--spacing-md);"></i>
                <p style="color: var(--gray-600);">No hay estudiantes inscritos en este curso</p>
            </div>
        @endif
    </div>

    <!-- Subjects Section -->
    <div class="card" style="margin-bottom: var(--spacing-xl);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-lg);">
            <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900); display: flex; align-items: center; gap: var(--spacing-sm); margin: 0;">
                <i class="fas fa-book" style="color: var(--theme-color);"></i>
                Asignaturas del Curso ({{ $curso->asignaturas->count() }})
            </h3>
            <button onclick="document.getElementById('addSubjectModal').style.display='flex'" class="btn btn-primary" style="color: white;">
                <i class="fas fa-plus"></i> Agregar Asignatura
            </button>
        </div>

        @if($curso->asignaturas->count() > 0)
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: var(--spacing-md);">
                @foreach($curso->asignaturas as $asignatura)
                    <div style="border: 2px solid var(--gray-200); border-radius: var(--radius-md); padding: var(--spacing-lg); position: relative;">
                        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: var(--spacing-md);">
                            <div>
                                <h4 style="font-weight: 700; color: var(--gray-900); margin-bottom: var(--spacing-xs);">
                                    {{ $asignatura->nombre }}
                                </h4>
                                <p style="color: var(--gray-600); font-size: 0.875rem; margin: 0;">
                                    Código: {{ $asignatura->codigo }}
                                </p>
                            </div>
                            <form action="{{ route('courses.remove-subject', [$curso, $asignatura]) }}" method="POST" 
                                onsubmit="return confirm('¿Estás seguro de querer remover esta asignatura?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline" style="color: #ef4444; border-color: #ef4444;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                        @if($asignatura->descripcion)
                            <p style="color: var(--gray-600); font-size: 0.875rem; margin-bottom: var(--spacing-sm);">
                                {{ $asignatura->descripcion }}
                            </p>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div style="text-align: center; padding: var(--spacing-2xl); background: var(--gray-50); border-radius: var(--radius-md);">
                <i class="fas fa-book-open" style="font-size: 3rem; color: var(--gray-300); margin-bottom: var(--spacing-md);"></i>
                <p style="color: var(--gray-600);">No hay asignaturas asignadas a este curso</p>
            </div>
        @endif
    </div>

    <!-- Events and Tests Grid -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--spacing-xl);">
        
        <!-- Academic Events Section -->
        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-lg);">
                <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900); display: flex; align-items: center; gap: var(--spacing-sm); margin: 0;">
                    <i class="fas fa-calendar-alt" style="color: var(--theme-color);"></i>
                    Calendario Académico
                </h3>
                <button onclick="document.getElementById('addEventModal').style.display='flex'" class="btn btn-primary btn-sm" style="color: white;">
                    <i class="fas fa-plus"></i> Nuevo Evento
                </button>
            </div>

            @if($curso->eventos->count() > 0)
                <div style="max-height: 400px; overflow-y: auto;">
                    @foreach($curso->eventos as $evento)
                        <div style="border-left: 4px solid var(--theme-color); padding: var(--spacing-md); background: var(--gray-50); border-radius: var(--radius-md); margin-bottom: var(--spacing-md);">
                            <div style="display: flex; justify-content: space-between; align-items: start;">
                                <div style="flex: 1;">
                                    <h4 style="font-weight: 700; color: var(--gray-900); margin-bottom: var(--spacing-xs);">
                                        {{ $evento->titulo }}
                                    </h4>
                                    <p style="color: var(--gray-600); font-size: 0.875rem; margin-bottom: var(--spacing-xs);">
                                        <i class="fas fa-calendar"></i> {{ $evento->fecha_inicio->format('d/m/Y') }}
                                        @if($evento->fecha_fin)
                                            - {{ $evento->fecha_fin->format('d/m/Y') }}
                                        @endif
                                    </p>
                                    <span style="display: inline-block; padding: 0.25rem 0.75rem; background: var(--theme-color); color: white; border-radius: var(--radius-sm); font-size: 0.75rem;">
                                        {{ ucfirst($evento->tipo) }}
                                    </span>
                                    @if($evento->descripcion)
                                        <p style="color: var(--gray-600); font-size: 0.875rem; margin-top: var(--spacing-sm);">
                                            {{ $evento->descripcion }}
                                        </p>
                                    @endif
                                </div>
                                <form action="{{ route('courses.destroy-event', [$curso, $evento]) }}" method="POST" 
                                    onsubmit="return confirm('¿Estás seguro de querer eliminar este evento?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline" style="color: #ef4444; border-color: #ef4444;">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: var(--spacing-xl); background: var(--gray-50); border-radius: var(--radius-md);">
                    <i class="fas fa-calendar-times" style="font-size: 2.5rem; color: var(--gray-300); margin-bottom: var(--spacing-md);"></i>
                    <p style="color: var(--gray-600);">No hay eventos programados</p>
                </div>
            @endif
        </div>

        <!-- Upcoming Tests Section -->
        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-lg);">
                <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900); display: flex; align-items: center; gap: var(--spacing-sm); margin: 0;">
                    <i class="fas fa-file-alt" style="color: var(--theme-color);"></i>
                    Próximas Pruebas
                </h3>
                <button onclick="document.getElementById('addTestModal').style.display='flex'" class="btn btn-primary btn-sm" style="color: white;">
                    <i class="fas fa-plus"></i> Nueva Prueba
                </button>
            </div>

            @if($curso->pruebas->count() > 0)
                <div style="max-height: 400px; overflow-y: auto;">
                    @foreach($curso->pruebas as $prueba)
                        <div style="border-left: 4px solid #f59e0b; padding: var(--spacing-md); background: var(--gray-50); border-radius: var(--radius-md); margin-bottom: var(--spacing-md);">
                            <div style="display: flex; justify-content: space-between; align-items: start;">
                                <div style="flex: 1;">
                                    <h4 style="font-weight: 700; color: var(--gray-900); margin-bottom: var(--spacing-xs);">
                                        {{ $prueba->titulo }}
                                    </h4>
                                    <p style="color: var(--gray-600); font-size: 0.875rem; margin-bottom: var(--spacing-xs);">
                                        <i class="fas fa-book"></i> {{ $prueba->asignatura->nombre }}
                                    </p>
                                    <p style="color: var(--gray-600); font-size: 0.875rem; margin-bottom: var(--spacing-xs);">
                                        <i class="fas fa-calendar"></i> {{ $prueba->fecha->format('d/m/Y') }}
                                        @if($prueba->hora)
                                            <i class="fas fa-clock"></i> {{ $prueba->hora }}
                                        @endif
                                    </p>
                                    @if($prueba->ponderacion)
                                        <span style="display: inline-block; padding: 0.25rem 0.75rem; background: #f59e0b; color: white; border-radius: var(--radius-sm); font-size: 0.75rem;">
                                            {{ $prueba->ponderacion }}%
                                        </span>
                                    @endif
                                    @if($prueba->descripcion)
                                        <p style="color: var(--gray-600); font-size: 0.875rem; margin-top: var(--spacing-sm);">
                                            {{ $prueba->descripcion }}
                                        </p>
                                    @endif
                                </div>
                                <form action="{{ route('courses.destroy-test', [$curso, $prueba]) }}" method="POST" 
                                    onsubmit="return confirm('¿Estás seguro de querer eliminar esta prueba?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline" style="color: #ef4444; border-color: #ef4444;">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: var(--spacing-xl); background: var(--gray-50); border-radius: var(--radius-md);">
                    <i class="fas fa-clipboard-list" style="font-size: 2.5rem; color: var(--gray-300); margin-bottom: var(--spacing-md);"></i>
                    <p style="color: var(--gray-600);">No hay pruebas programadas</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Add Student Modal -->
    <div id="addStudentModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; z-index: 1000;">
        <div class="card" style="max-width: 500px; width: 90%; max-height: 90vh; overflow-y: auto;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-lg);">
                <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900); margin: 0;">
                    Agregar Estudiante
                </h3>
                <button onclick="document.getElementById('addStudentModal').style.display='none'" style="background: none; border: none; font-size: 1.5rem; color: var(--gray-600); cursor: pointer;">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form action="{{ route('courses.add-student', $curso) }}" method="POST">
                @csrf
                <div style="margin-bottom: var(--spacing-md);">
                    <label style="display: block; font-weight: 600; color: var(--gray-700); margin-bottom: var(--spacing-sm);">
                        Seleccionar Estudiante
                    </label>
                    <select name="estudiante_id" class="form-input" style="width: 100%;" required>
                        <option value="">Seleccione un estudiante</option>
                        @foreach($estudiantesDisponibles as $estudiante)
                            <option value="{{ $estudiante->id }}">
                                {{ $estudiante->nombre }} {{ $estudiante->apellido }} ({{ $estudiante->rut }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div style="margin-bottom: var(--spacing-lg);">
                    <label style="display: block; font-weight: 600; color: var(--gray-700); margin-bottom: var(--spacing-sm);">
                        Fecha de Inscripción
                    </label>
                    <input type="date" name="fecha_inscripcion" class="form-input" style="width: 100%;" value="{{ date('Y-m-d') }}">
                </div>

                <div style="display: flex; gap: var(--spacing-sm);">
                    <button type="button" onclick="document.getElementById('addStudentModal').style.display='none'" class="btn btn-outline" style="flex: 1;">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary" style="flex: 1; color: white;">
                        <i class="fas fa-user-plus"></i> Agregar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Subject Modal -->
    <div id="addSubjectModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; z-index: 1000;">
        <div class="card" style="max-width: 500px; width: 90%; max-height: 90vh; overflow-y: auto;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-lg);">
                <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900); margin: 0;">
                    Agregar Asignatura
                </h3>
                <button onclick="document.getElementById('addSubjectModal').style.display='none'" style="background: none; border: none; font-size: 1.5rem; color: var(--gray-600); cursor: pointer;">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form action="{{ route('courses.add-subject', $curso) }}" method="POST">
                @csrf
                <div style="margin-bottom: var(--spacing-md);">
                    <label style="display: block; font-weight: 600; color: var(--gray-700); margin-bottom: var(--spacing-sm);">
                        Seleccionar Asignatura
                    </label>
                    <select name="asignatura_id" class="form-input" style="width: 100%;" required>
                        <option value="">Seleccione una asignatura</option>
                        @foreach($asignaturasDisponibles as $asignatura)
                            <option value="{{ $asignatura->id }}">
                                {{ $asignatura->nombre }} ({{ $asignatura->codigo }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div style="margin-bottom: var(--spacing-lg);">
                    <label style="display: block; font-weight: 600; color: var(--gray-700); margin-bottom: var(--spacing-sm);">
                        Profesor de la Asignatura (Opcional)
                    </label>
                    <select name="profesor_id" class="form-input" style="width: 100%;">
                        <option value="">Sin profesor específico</option>
                        @foreach($profesores as $profesor)
                            <option value="{{ $profesor->id }}">
                                {{ $profesor->nombre }} {{ $profesor->apellido }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div style="display: flex; gap: var(--spacing-sm);">
                    <button type="button" onclick="document.getElementById('addSubjectModal').style.display='none'" class="btn btn-outline" style="flex: 1;">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary" style="flex: 1; color: white;">
                        <i class="fas fa-plus"></i> Agregar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Event Modal -->
    <div id="addEventModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; z-index: 1000;">
        <div class="card" style="max-width: 500px; width: 90%; max-height: 90vh; overflow-y: auto;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-lg);">
                <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900); margin: 0;">
                    Nuevo Evento Académico
                </h3>
                <button onclick="document.getElementById('addEventModal').style.display='none'" style="background: none; border: none; font-size: 1.5rem; color: var(--gray-600); cursor: pointer;">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form action="{{ route('courses.store-event', $curso) }}" method="POST">
                @csrf
                <div style="margin-bottom: var(--spacing-md);">
                    <label style="display: block; font-weight: 600; color: var(--gray-700); margin-bottom: var(--spacing-sm);">
                        Título del Evento
                    </label>
                    <input type="text" name="titulo" class="form-input" style="width: 100%;" required>
                </div>

                <div style="margin-bottom: var(--spacing-md);">
                    <label style="display: block; font-weight: 600; color: var(--gray-700); margin-bottom: var(--spacing-sm);">
                        Tipo de Evento
                    </label>
                    <select name="tipo" class="form-input" style="width: 100%;" required>
                        <option value="reunion">Reunión</option>
                        <option value="actividad">Actividad</option>
                        <option value="examen">Examen</option>
                        <option value="vacaciones">Vacaciones</option>
                        <option value="otro">Otro</option>
                    </select>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--spacing-md); margin-bottom: var(--spacing-md);">
                    <div>
                        <label style="display: block; font-weight: 600; color: var(--gray-700); margin-bottom: var(--spacing-sm);">
                            Fecha Inicio
                        </label>
                        <input type="date" name="fecha_inicio" class="form-input" style="width: 100%;" required>
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600; color: var(--gray-700); margin-bottom: var(--spacing-sm);">
                            Fecha Fin (Opcional)
                        </label>
                        <input type="date" name="fecha_fin" class="form-input" style="width: 100%;">
                    </div>
                </div>

                <div style="margin-bottom: var(--spacing-lg);">
                    <label style="display: block; font-weight: 600; color: var(--gray-700); margin-bottom: var(--spacing-sm);">
                        Descripción (Opcional)
                    </label>
                    <textarea name="descripcion" class="form-input" style="width: 100%; min-height: 80px;"></textarea>
                </div>

                <div style="display: flex; gap: var(--spacing-sm);">
                    <button type="button" onclick="document.getElementById('addEventModal').style.display='none'" class="btn btn-outline" style="flex: 1;">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary" style="flex: 1; color: white;">
                        <i class="fas fa-calendar-plus"></i> Crear Evento
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Test Modal -->
    <div id="addTestModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; z-index: 1000;">
        <div class="card" style="max-width: 500px; width: 90%; max-height: 90vh; overflow-y: auto;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-lg);">
                <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900); margin: 0;">
                    Nueva Prueba
                </h3>
                <button onclick="document.getElementById('addTestModal').style.display='none'" style="background: none; border: none; font-size: 1.5rem; color: var(--gray-600); cursor: pointer;">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form action="{{ route('courses.store-test', $curso) }}" method="POST">
                @csrf
                <div style="margin-bottom: var(--spacing-md);">
                    <label style="display: block; font-weight: 600; color: var(--gray-700); margin-bottom: var(--spacing-sm);">
                        Asignatura
                    </label>
                    <select name="asignatura_id" class="form-input" style="width: 100%;" required>
                        <option value="">Seleccione una asignatura</option>
                        @foreach($curso->asignaturas as $asignatura)
                            <option value="{{ $asignatura->id }}">{{ $asignatura->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div style="margin-bottom: var(--spacing-md);">
                    <label style="display: block; font-weight: 600; color: var(--gray-700); margin-bottom: var(--spacing-sm);">
                        Título de la Prueba
                    </label>
                    <input type="text" name="titulo" class="form-input" style="width: 100%;" required>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: var(--spacing-md); margin-bottom: var(--spacing-md);">
                    <div>
                        <label style="display: block; font-weight: 600; color: var(--gray-700); margin-bottom: var(--spacing-sm);">
                            Fecha
                        </label>
                        <input type="date" name="fecha" class="form-input" style="width: 100%;" required>
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600; color: var(--gray-700); margin-bottom: var(--spacing-sm);">
                            Hora (Opcional)
                        </label>
                        <input type="time" name="hora" class="form-input" style="width: 100%;">
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600; color: var(--gray-700); margin-bottom: var(--spacing-sm);">
                            Ponderación %
                        </label>
                        <input type="number" name="ponderacion" class="form-input" style="width: 100%;" min="0" max="100">
                    </div>
                </div>

                <div style="margin-bottom: var(--spacing-lg);">
                    <label style="display: block; font-weight: 600; color: var(--gray-700); margin-bottom: var(--spacing-sm);">
                        Descripción (Opcional)
                    </label>
                    <textarea name="descripcion" class="form-input" style="width: 100%; min-height: 80px;"></textarea>
                </div>

                <div style="display: flex; gap: var(--spacing-sm);">
                    <button type="button" onclick="document.getElementById('addTestModal').style.display='none'" class="btn btn-outline" style="flex: 1;">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary" style="flex: 1; color: white;">
                        <i class="fas fa-file-alt"></i> Crear Prueba
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        /* Modal close on outside click */
        .modal-overlay {
            cursor: pointer;
        }
        .modal-content {
            cursor: default;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            div[style*="grid-template-columns: 1fr 1fr"] {
                grid-template-columns: 1fr !important;
            }
        }
    </style>

    <script>
        // Close modals when clicking outside
        document.querySelectorAll('[id$="Modal"]').forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.style.display = 'none';
                }
            });
        });
    </script>
</x-app-layout>
