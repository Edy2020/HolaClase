<x-app-layout>
    <x-slot name="header">
        {{ $curso->nombre }} - Detalles
    </x-slot>

    <!-- Success Message -->
    @if(session('success'))
        <div id="successMessage" class="alert alert-success" style="background: #10b981; color: white; padding: var(--spacing-md); border-radius: var(--radius-md); margin-bottom: var(--spacing-lg); transition: opacity 0.5s ease;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
        <script>
            setTimeout(function() {
                const message = document.getElementById('successMessage');
                if (message) {
                    message.style.opacity = '0';
                    setTimeout(function() {
                        message.style.display = 'none';
                    }, 500);
                }
            }, 3000);
        </script>
    @endif

    <!-- Header Section -->
    <div class="card" style="margin-bottom: var(--spacing-xl);">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: var(--spacing-md);">
            <div>
                <h2 style="font-size: 2rem; font-weight: 700; color: var(--gray-900); margin-bottom: var(--spacing-xs);">
                    {{ $curso->nombre }}
                </h2>
                <p style="color: var(--gray-600); font-size: 1rem;">
                    <i class="fas fa-graduation-cap"></i> Grado: {{ $curso->grado }}
                    @if($curso->grado)
                        | <i class="fas fa-layer-group"></i> {{ $curso->nivel }}
                    @endif
                    | <i class="fas fa-tag"></i> Sección: {{ $curso->letra }}
                </p>
            </div>
            <div style="display: flex; gap: var(--spacing-sm);">
                <a href="{{ route('attendance.create', ['curso_id' => $curso->id]) }}" class="btn btn-accent" style="color: white;">
                    <i class="fas fa-check"></i> Pasar Asistencia
                </a>
                <a href="{{ route('courses.edit', $curso) }}" class="btn btn-primary" style="color: white;">
                    <i class="fas fa-edit"></i> Editar Curso
                </a>
                <a href="{{ route('courses.index') }}" class="btn btn-outline">
                    <i class="fas fa-arrow-left"></i> Volver
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
                <div id="teacherCard" onclick="toggleTeacherForm()" style="background: var(--gray-50); padding: var(--spacing-lg); border-radius: var(--radius-md); margin-bottom: var(--spacing-md); cursor: pointer; transition: all 0.3s ease; min-height: 200px; display: flex; flex-direction: column; justify-content: center;">
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
                        <form action="{{ route('courses.assign-teacher', $curso) }}" method="POST" style="margin: 0;" onclick="event.stopPropagation();" onsubmit="return confirm('¿Estás seguro de querer quitar el profesor asignado?');">
                            @csrf
                            <input type="hidden" name="profesor_id" value="">
                            <button type="submit" class="btn btn-outline" style="color: #ef4444; border-color: #ef4444; white-space: nowrap;">
                                <i class="fas fa-trash"></i> Quitar
                            </button>
                        </form>
                    </div>
                    <p style="text-align: center; color: var(--gray-500); font-size: 0.75rem; margin-top: var(--spacing-sm); margin-bottom: 0;">
                        Click para cambiar profesor
                    </p>
                </div>
            @else
                <div onclick="toggleTeacherForm()" style="text-align: center; padding: var(--spacing-2xl); background: var(--gray-50); border-radius: var(--radius-md); margin-bottom: var(--spacing-md); cursor: pointer; transition: all 0.3s ease; min-height: 200px; display: flex; flex-direction: column; justify-content: center;" id="emptyTeacherCard">
                    <i class="fas fa-user-slash" style="font-size: 3rem; color: var(--gray-300); margin-bottom: var(--spacing-md);"></i>
                    <p style="color: var(--gray-600); margin-bottom: var(--spacing-xs);">No hay profesor asignado</p>
                    <p style="color: var(--gray-500); font-size: 0.75rem; margin: 0;">Click para asignar un profesor</p>
                </div>
            @endif

            <form id="teacherForm" action="{{ route('courses.assign-teacher', $curso) }}" method="POST" style="display: none; animation: slideDown 0.3s ease;">
                @csrf
                <div style="margin-bottom: var(--spacing-md);">
                    <label style="display: block; font-weight: 600; color: var(--gray-700); margin-bottom: var(--spacing-sm);">
                        Buscar Profesor
                    </label>
                    <input type="text" id="teacherSearch" class="form-input" placeholder="Escribe el nombre del profesor..." style="width: 100%; padding: var(--spacing-sm);" autocomplete="off" oninput="filterTeachers(this.value)">
                    <input type="hidden" name="profesor_id" id="selectedTeacherId">
                    <div id="teacherSuggestions" style="display: none; position: absolute; background: white; border: 1px solid var(--gray-300); border-radius: var(--radius-md); margin-top: 0.25rem; max-height: 200px; overflow-y: auto; width: calc(100% - 2rem); box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); z-index: 10;"></div>
                </div>
                <div style="display: flex; gap: var(--spacing-sm);">
                    <button type="submit" class="btn btn-primary" style="flex: 1; color: white;">
                        <i class="fas fa-user-check"></i> Asignar Profesor
                    </button>
                    @if($curso->profesor)
                        <button type="button" onclick="toggleTeacherForm()" class="btn btn-outline" style="flex: 1;">
                            <i class="fas fa-times"></i> Cancelar
                        </button>
                    @endif
                </div>
            </form>

            <script>
                const profesores = @json($profesores->map(function($p) {
                    return ['id' => $p->id, 'nombre' => $p->nombre . ' ' . $p->apellido];
                }));

                function filterTeachers(query) {
                    const suggestions = document.getElementById('teacherSuggestions');
                    const searchInput = document.getElementById('teacherSearch');
                    
                    if (!query || query.length < 2) {
                        suggestions.style.display = 'none';
                        return;
                    }

                    const filtered = profesores.filter(p => 
                        p.nombre.toLowerCase().includes(query.toLowerCase())
                    );

                    if (filtered.length === 0) {
                        suggestions.style.display = 'none';
                        return;
                    }

                    suggestions.innerHTML = filtered.map(p => `
                        <div onclick="selectTeacher(${p.id}, '${p.nombre}')" style="padding: var(--spacing-sm); cursor: pointer; border-bottom: 1px solid var(--gray-100); transition: background 0.2s;" onmouseover="this.style.background='var(--gray-50)'" onmouseout="this.style.background='white'">
                            <i class="fas fa-user"></i> ${p.nombre}
                        </div>
                    `).join('');
                    
                    suggestions.style.display = 'block';
                }

                function selectTeacher(id, nombre) {
                    document.getElementById('teacherSearch').value = nombre;
                    document.getElementById('selectedTeacherId').value = id;
                    document.getElementById('teacherSuggestions').style.display = 'none';
                }

                // Close suggestions when clicking outside
                document.addEventListener('click', function(e) {
                    const suggestions = document.getElementById('teacherSuggestions');
                    const searchInput = document.getElementById('teacherSearch');
                    if (e.target !== searchInput && e.target !== suggestions) {
                        suggestions.style.display = 'none';
                    }
                });
            </script>
            <script>
                function toggleTeacherForm() {
                    const form = document.getElementById('teacherForm');
                    const card = document.getElementById('teacherCard');
                    const emptyCard = document.getElementById('emptyTeacherCard');
                    
                    if (form.style.display === 'none') {
                        form.style.display = 'block';
                        if (card) card.style.display = 'none';
                        if (emptyCard) emptyCard.style.display = 'none';
                    } else {
                        form.style.display = 'none';
                        if (card) card.style.display = 'block';
                        if (emptyCard && !card) emptyCard.style.display = 'block'; // Show empty card if no teacher is assigned and form is hidden
                    }
                }

                // Add hover effect to teacher cards
                document.addEventListener('DOMContentLoaded', function() {
                    const card = document.getElementById('teacherCard');
                    const emptyCard = document.getElementById('emptyTeacherCard');
                    
                    function addHoverEffect(element) {
                        if (element) {
                            element.addEventListener('mouseenter', function() {
                                this.style.transform = 'translateY(-2px)';
                                this.style.boxShadow = '0 4px 12px rgba(0, 0, 0, 0.1)';
                            });
                            element.addEventListener('mouseleave', function() {
                                this.style.transform = 'translateY(0)';
                                this.style.boxShadow = 'none';
                            });
                        }
                    }
                    
                    addHoverEffect(card);
                    addHoverEffect(emptyCard);
                });
            </script>
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
        <div class="section-header">
            <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900); display: flex; align-items: center; gap: var(--spacing-sm); margin: 0;">
                <i class="fas fa-users" style="color: var(--theme-color);"></i>
                Estudiantes Inscritos ({{ $curso->estudiantes->count() }})
            </h3>
            
            <button onclick="document.getElementById('addStudentModal').style.display='flex'" class="btn btn-primary section-button" style="color: white;">
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
                                <td>
                                    @if($estudiante->pivot->fecha_inscripcion)
                                        {{ is_string($estudiante->pivot->fecha_inscripcion) ? \Carbon\Carbon::parse($estudiante->pivot->fecha_inscripcion)->format('d/m/Y') : $estudiante->pivot->fecha_inscripcion->format('d/m/Y') }}
                                    @else
                                        -
                                    @endif
                                </td>
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
        <div class="section-header">
            <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900); display: flex; align-items: center; gap: var(--spacing-sm); margin: 0;">
                <i class="fas fa-book" style="color: var(--theme-color);"></i>
                Asignaturas del Curso ({{ $curso->asignaturas->count() }})
            </h3>
            
            <button onclick="document.getElementById('addSubjectModal').style.display='flex'" class="btn btn-primary section-button" style="color: white;">
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

    <!-- Grades Management Section -->
    <div class="card" style="margin-bottom: var(--spacing-xl);">
        <div class="section-header">
            <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900); display: flex; align-items: center; gap: var(--spacing-sm); margin: 0;">
                <i class="fas fa-clipboard-list" style="color: var(--theme-color);"></i>
                Gestión de Notas
            </h3>
            
            <a href="{{ route('grades.create', ['curso_id' => $curso->id]) }}" class="btn btn-primary section-button" style="color: white;">
                <i class="fas fa-plus"></i> Agregar Notas
            </a>
        </div>

        <!-- Quick Stats -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: var(--spacing-md); margin-bottom: var(--spacing-lg);">
            <div style="text-align: center; padding: var(--spacing-md); background: var(--gray-50); border-radius: var(--radius-md);">
                <div style="font-size: 1.5rem; font-weight: 700; color: var(--theme-color);">
                    {{ $curso->notas->count() }}
                </div>
                <div style="color: var(--gray-600); font-size: 0.875rem;">Total Notas</div>
            </div>
            <div style="text-align: center; padding: var(--spacing-md); background: var(--gray-50); border-radius: var(--radius-md);">
                <div style="font-size: 1.5rem; font-weight: 700; color: var(--success);">
                    {{ $curso->notas->count() > 0 ? number_format($curso->notas->avg('nota'), 1) : 'N/A' }}
                </div>
                <div style="color: var(--gray-600); font-size: 0.875rem;">Promedio General</div>
            </div>
            <div style="text-align: center; padding: var(--spacing-md); background: var(--gray-50); border-radius: var(--radius-md);">
                <div style="font-size: 1.5rem; font-weight: 700; color: var(--accent);">
                    {{ $curso->notas->where('nota', '>=', 4.0)->count() }}
                </div>
                <div style="color: var(--gray-600); font-size: 0.875rem;">Aprobados</div>
            </div>
            <div style="text-align: center; padding: var(--spacing-md); background: var(--gray-50); border-radius: var(--radius-md);">
                <div style="font-size: 1.5rem; font-weight: 700; color: var(--error);">
                    {{ $curso->notas->where('nota', '<', 4.0)->count() }}
                </div>
                <div style="color: var(--gray-600); font-size: 0.875rem;">Reprobados</div>
            </div>
        </div>

        <!-- Grades by Subject -->
        @if($curso->asignaturas->count() > 0)
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: var(--spacing-md); margin-bottom: var(--spacing-lg);">
                @foreach($curso->asignaturas as $asignatura)
                    @php
                        $notasAsignatura = $curso->notas->where('asignatura_id', $asignatura->id);
                        $promedio = $notasAsignatura->count() > 0 ? $notasAsignatura->avg('nota') : null;
                    @endphp
                    <div style="padding: var(--spacing-md); border: 1px solid var(--gray-200); border-radius: var(--radius-md); transition: all 0.3s ease;" 
                         onmouseover="this.style.boxShadow='0 4px 12px rgba(0,0,0,0.1)'; this.style.transform='translateY(-2px)';" 
                         onmouseout="this.style.boxShadow='none'; this.style.transform='translateY(0)';">
                        <h4 style="font-weight: 600; color: var(--gray-900); margin-bottom: var(--spacing-sm); font-size: 0.875rem;">
                            {{ $asignatura->nombre }}
                        </h4>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-sm);">
                            <span style="color: var(--gray-600); font-size: 0.75rem;">
                                <i class="fas fa-clipboard-check"></i> {{ $notasAsignatura->count() }} notas
                            </span>
                            @if($promedio)
                                <span style="font-weight: 700; font-size: 1.125rem; color: {{ $promedio >= 6.0 ? 'var(--success)' : ($promedio >= 4.0 ? 'var(--warning)' : 'var(--error)') }};">
                                    {{ number_format($promedio, 1) }}
                                </span>
                            @else
                                <span style="color: var(--gray-400); font-size: 0.875rem;">Sin notas</span>
                            @endif
                        </div>
                        <a href="{{ route('grades.create', ['curso_id' => $curso->id, 'asignatura_id' => $asignatura->id]) }}" 
                           class="btn btn-sm btn-outline" style="width: 100%; font-size: 0.75rem;">
                            <i class="fas fa-plus"></i> Agregar Notas
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <p style="text-align: center; color: var(--gray-500); padding: var(--spacing-lg); background: var(--gray-50); border-radius: var(--radius-md);">
                <i class="fas fa-info-circle"></i> Agrega asignaturas al curso para poder registrar notas
            </p>
        @endif

        <!-- View All Grades Link -->
        <div style="text-align: center; margin-top: var(--spacing-md);">
            <a href="{{ route('grades.reporte.curso', $curso) }}" class="btn btn-outline">
                <i class="fas fa-chart-bar"></i> Ver Reporte Completo de Notas
            </a>
        </div>
    </div>

    <!-- Events and Tests Grid -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--spacing-xl);">
        
        <!-- Academic Events Section -->
        <div class="card">
            <div class="section-header">
                <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900); display: flex; align-items: center; gap: var(--spacing-sm); margin: 0;">
                    <i class="fas fa-calendar-alt" style="color: var(--theme-color);"></i>
                    Calendario Académico
                </h3>
                
                <button onclick="document.getElementById('addEventModal').style.display='flex'" class="btn btn-primary section-button" style="color: white;">
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
            <div class="section-header">
                <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900); display: flex; align-items: center; gap: var(--spacing-sm); margin: 0;">
                    <i class="fas fa-file-alt" style="color: var(--theme-color);"></i>
                    Próximas Pruebas
                </h3>
                
                <button onclick="document.getElementById('addTestModal').style.display='flex'" class="btn btn-primary section-button" style="color: white;">
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

        /* Section header responsive layout */
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: var(--spacing-lg);
            gap: var(--spacing-md);
        }

        /* Slide down animation for forms */
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
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

    <style>
        /* Mobile Responsive Styles */
        @media (max-width: 768px) {
            /* Header Section */
            .card:first-of-type > div:first-child {
                flex-direction: column !important;
                align-items: flex-start !important;
                gap: var(--spacing-md) !important;
            }

            .card:first-of-type h2 {
                font-size: 1.5rem !important;
            }

            .card:first-of-type p {
                font-size: 0.875rem !important;
            }

            /* Action buttons in header */
            .card:first-of-type > div:first-child > div:last-child {
                width: 100% !important;
                flex-direction: column !important;
                gap: var(--spacing-xs) !important;
            }

            .card:first-of-type .btn {
                width: 100% !important;
                justify-content: center !important;
                padding: var(--spacing-sm) var(--spacing-md) !important;
                font-size: 0.875rem !important;
            }

            /* Main grid - stack vertically (but not stats grid) */
            div[style*="grid-template-columns: 1fr 1fr"]:not(.card div) {
                grid-template-columns: 1fr !important;
                gap: var(--spacing-md) !important;
            }

            /* Stats grid - explicitly keep 2 columns */
            .card div[style*="display: grid"][style*="grid-template-columns: 1fr 1fr"] {
                grid-template-columns: 1fr 1fr !important;
                gap: var(--spacing-sm) !important;
            }


            /* Cards */
            .card {
                padding: var(--spacing-md) !important;
            }

            .card h3 {
                font-size: 1.125rem !important;
                margin-bottom: var(--spacing-md) !important;
            }

            /* Teacher avatar */
            .card div[style*="width: 60px"] {
                width: 50px !important;
                height: 50px !important;
                font-size: 1.25rem !important;
            }

            /* Form inputs and buttons */
            .form-input,
            select.form-input {
                font-size: 0.875rem !important;
                padding: var(--spacing-sm) !important;
            }

            /* Fix select dropdown text overflow */
            select.form-input {
                padding-right: 2.5rem !important;
                min-height: 44px !important;
            }

            select.form-input option {
                padding: var(--spacing-sm);
            }

            /* Fix subject cards overflow on mobile */
            div[style*="grid-template-columns: repeat(auto-fill, minmax(300px, 1fr))"] {
                grid-template-columns: 1fr !important;
                gap: var(--spacing-sm) !important;
            }


            /* Student cards in grid */
            .grid-cols-3 {
                grid-template-columns: 1fr !important;
                gap: var(--spacing-sm) !important;
            }

            /* Student card content */
            .grid-cols-3 .card {
                padding: var(--spacing-sm) !important;
            }

            .grid-cols-3 .card div[style*="width: 50px"] {
                width: 40px !important;
                height: 40px !important;
                font-size: 1rem !important;
            }

            .grid-cols-3 .card h4 {
                font-size: 0.9rem !important;
                margin-bottom: 0.25rem !important;
            }

            .grid-cols-3 .card p {
                font-size: 0.75rem !important;
                margin-bottom: 0.125rem !important;
            }

            /* Teacher card mobile layout */
            #teacherCard > div:first-child {
                flex-direction: column !important;
                align-items: flex-start !important;
                gap: var(--spacing-md) !important;
            }

            #teacherCard form {
                width: 100% !important;
            }

            #teacherCard form button {
                width: 100% !important;
                justify-content: center !important;
            }

            /* Stats cards - keep 2 columns on mobile with better spacing */
            .card div[style*="display: grid"][style*="grid-template-columns: 1fr 1fr"] {
                grid-template-columns: 1fr 1fr !important;
                gap: var(--spacing-sm) !important;
            }

            /* Stat card content - much more compact */
            div[style*="text-align: center"][style*="padding: var(--spacing-lg)"] {
                padding: var(--spacing-sm) !important;
            }

            div[style*="text-align: center"] i.fas {
                font-size: 1.25rem !important;
                margin-right: 0.25rem !important;
            }

            div[style*="text-align: center"] div[style*="font-size: 2.5rem"] {
                font-size: 1.75rem !important;
                margin-bottom: 0.25rem !important;
            }

            div[style*="text-align: center"] div[style*="font-size: 0.875rem"] {
                font-size: 0.8125rem !important;
            }


            /* Modal */
            div[style*="position: fixed"] > div {
                width: 95% !important;
                max-width: 95% !important;
                margin: var(--spacing-md) !important;
            }

            /* Modal content */
            div[id$="Modal"] h3 {
                font-size: 1.125rem !important;
            }

            div[id$="Modal"] .form-input {
                font-size: 0.875rem !important;
            }

            /* Table responsive */
            .table-container {
                overflow-x: auto !important;
            }

            table {
                font-size: 0.75rem !important;
            }

            table th,
            table td {
                padding: var(--spacing-xs) !important;
            }

            /* Hide some table columns on very small screens */
            @media (max-width: 480px) {
                table th:nth-child(3),
                table td:nth-child(3) {
                    display: none !important;
                }
            }

            /* Section buttons - full width on mobile */
            .section-button {
                width: 100% !important;
            }

            /* Section headers - stack vertically on mobile */
            .section-header {
                flex-direction: column;
                align-items: stretch !important;
                gap: var(--spacing-sm);
            }

            .section-header h3 {
                margin-bottom: var(--spacing-sm) !important;
            }

            /* Button optimizations for mobile */

            .btn {
                min-height: 44px !important; /* Better touch target */
                padding: var(--spacing-sm) var(--spacing-md) !important;
                font-size: 0.875rem !important;
            }

            /* Section header buttons */
            div[style*="justify-content: space-between"] .btn {
                padding: var(--spacing-sm) var(--spacing-md) !important;
                font-size: 0.875rem !important;
                white-space: nowrap !important;
            }

            /* Icon-only buttons (delete, etc) */
            .btn-sm {
                min-width: 40px !important;
                min-height: 40px !important;
                padding: var(--spacing-sm) !important;
            }

            /* Button icons */
            .btn i {
                font-size: 0.875rem !important;
            }

            /* Form buttons */
            form .btn {
                width: 100% !important;
                justify-content: center !important;
            }

            /* Action button groups */
            div[style*="display: flex"][style*="gap"] .btn {
                flex: 1 !important;
                min-width: 0 !important;
            }

            /* Delete buttons in tables */
            table .btn {
                padding: 0.5rem !important;
                min-width: 36px !important;
                min-height: 36px !important;
            }
        }

    </style>
</x-app-layout>
