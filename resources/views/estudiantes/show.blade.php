<x-app-layout>
    <x-slot name="header">
        Perfil de Estudiante
    </x-slot>

    <!-- Student Header -->
    <div class="card" style="margin-bottom: var(--spacing-xl);">
        <div style="display: flex; align-items: center; gap: var(--spacing-xl);">
            <div
                style="width: 100px; height: 100px; border-radius: var(--radius-full); background: linear-gradient(135deg, var(--theme-color), var(--theme-dark)); display: flex; align-items: center; justify-content: center; color: white; font-size: 2.5rem; font-weight: 700; box-shadow: var(--shadow-lg);">
                {{ strtoupper(substr($estudiante->nombre, 0, 1) . substr($estudiante->apellido, 0, 1)) }}
            </div>
            <div style="flex: 1;">
                <h1
                    style="font-size: 2rem; font-weight: 700; color: var(--gray-900); margin-bottom: var(--spacing-xs);">
                    {{ $estudiante->nombre_completo }}
                </h1>
                <div style="display: flex; gap: var(--spacing-lg); flex-wrap: wrap; color: var(--gray-600);">
                    <span><i class="fas fa-id-card"></i> RUT: {{ $estudiante->rut }}</span>
                    @if($estudiante->edad)
                        <span><i class="fas fa-birthday-cake"></i> {{ $estudiante->edad }} años</span>
                    @endif
                    @if($estudiante->email)
                        <span><i class="fas fa-envelope"></i> {{ $estudiante->email }}</span>
                    @endif
                </div>
            </div>
            <div>
                <span class="badge badge-{{ $estudiante->estado === 'activo' ? 'success' : 'warning' }}"
                    style="font-size: 1rem; padding: var(--spacing-sm) var(--spacing-lg);">
                    {{ ucfirst($estudiante->estado) }}
                </span>
            </div>
            <div style="display: flex; gap: var(--spacing-sm);">
                <a href="{{ route('students.edit', $estudiante->id) }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Editar
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-4" style="gap: var(--spacing-lg); margin-bottom: var(--spacing-xl);">
        <div class="card" style="text-align: center;">
            <div
                style="font-size: 2.5rem; font-weight: 700; color: var(--theme-color); margin-bottom: var(--spacing-xs);">
                {{ $estudiante->promedio_general ?? 'N/A' }}
            </div>
            <div style="color: var(--gray-600); font-weight: 600;">Promedio General</div>
        </div>
        <div class="card" style="text-align: center;">
            <div style="font-size: 2.5rem; font-weight: 700; color: var(--success); margin-bottom: var(--spacing-xs);">
                {{ $estudiante->cursos->count() }}
            </div>
            <div style="color: var(--gray-600); font-weight: 600;">Cursos Activos</div>
        </div>
        <div class="card" style="text-align: center;">
            <div style="font-size: 2.5rem; font-weight: 700; color: var(--accent); margin-bottom: var(--spacing-xs);">
                {{ $estudiante->documentos->count() }}
            </div>
            <div style="color: var(--gray-600); font-weight: 600;">Documentos</div>
        </div>
        <div class="card" style="text-align: center;">
            <div style="font-size: 2.5rem; font-weight: 700; color: var(--warning); margin-bottom: var(--spacing-xs);">
                95%
            </div>
            <div style="color: var(--gray-600); font-weight: 600;">Asistencia</div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-3" style="gap: var(--spacing-xl);">
        <!-- Left Column (2/3 width) -->
        <div style="grid-column: span 2;">
            <!-- Cursos Asignados -->
            <div class="card" style="margin-bottom: var(--spacing-xl);">
                <h3
                    style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900); margin-bottom: var(--spacing-lg); display: flex; align-items: center; gap: var(--spacing-sm);">
                    <i class="fas fa-school" style="color: var(--theme-color);"></i>
                    Cursos Asignados
                </h3>

                @if($estudiante->cursos->count() > 0)
                    <div style="display: flex; flex-direction: column; gap: var(--spacing-md);">
                        @foreach($estudiante->cursos as $curso)
                            <div
                                style="padding: var(--spacing-lg); background: var(--gray-50); border-radius: var(--radius-lg); border-left: 4px solid var(--theme-color);">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <div>
                                        <div
                                            style="font-weight: 700; font-size: 1.125rem; color: var(--gray-900); margin-bottom: var(--spacing-xs);">
                                            {{ $curso->nombre }}
                                        </div>
                                        @if($curso->profesor)
                                            <div style="color: var(--gray-600); font-size: 0.875rem;">
                                                <i class="fas fa-chalkboard-teacher"></i> Profesor Jefe:
                                                {{ $curso->profesor->nombre_completo }}
                                            </div>
                                        @endif
                                    </div>
                                    <a href="{{ route('courses.show', $curso->id) }}" class="btn btn-ghost btn-sm">
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p style="color: var(--gray-500); text-align: center; padding: var(--spacing-xl);">
                        <i class="fas fa-info-circle"></i> No hay cursos asignados
                    </p>
                @endif
            </div>

            <!-- Asignaturas y Notas -->
            <div class="card" style="margin-bottom: var(--spacing-xl);">
                <h3
                    style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900); margin-bottom: var(--spacing-lg); display: flex; align-items: center; gap: var(--spacing-sm);">
                    <i class="fas fa-book" style="color: var(--theme-color);"></i>
                    Asignaturas y Notas
                </h3>

                @if(count($promediosPorAsignatura) > 0)
                    <div class="table-container">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Asignatura</th>
                                    <th>Promedio</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($promediosPorAsignatura as $data)
                                    <tr>
                                        <td style="font-weight: 600;">{{ $data['asignatura']->nombre }}</td>
                                        <td>
                                            @if($data['promedio'])
                                                <span
                                                    style="font-size: 1.25rem; font-weight: 700; color: {{ $data['promedio'] >= 6.0 ? 'var(--success)' : ($data['promedio'] >= 4.0 ? 'var(--warning)' : 'var(--error)') }};">
                                                    {{ number_format($data['promedio'], 1) }}
                                                </span>
                                            @else
                                                <span style="color: var(--gray-400);">Sin notas</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($data['promedio'])
                                                @if($data['promedio'] >= 4.0)
                                                    <span class="badge badge-success">Aprobado</span>
                                                @else
                                                    <span class="badge badge-error">Reprobado</span>
                                                @endif
                                            @else
                                                <span class="badge">Pendiente</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p style="color: var(--gray-500); text-align: center; padding: var(--spacing-xl);">
                        <i class="fas fa-info-circle"></i> No hay asignaturas asignadas
                    </p>
                @endif
            </div>

            <!-- Documentos -->
            <div class="card">
                <h3
                    style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900); margin-bottom: var(--spacing-lg); display: flex; align-items: center; gap: var(--spacing-sm);">
                    <i class="fas fa-folder-open" style="color: var(--theme-color);"></i>
                    Documentos
                </h3>

                @if($estudiante->documentos->count() > 0)
                    <div class="grid grid-cols-2" style="gap: var(--spacing-md);">
                        @foreach($estudiante->documentos as $documento)
                            <div
                                style="padding: var(--spacing-md); background: var(--gray-50); border-radius: var(--radius-lg); border: 1px solid var(--gray-200);">
                                <div style="display: flex; align-items: center; gap: var(--spacing-md);">
                                    <div
                                        style="width: 48px; height: 48px; background: var(--theme-color); border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.25rem;">
                                        <i class="fas fa-file-pdf"></i>
                                    </div>
                                    <div style="flex: 1; min-width: 0;">
                                        <div
                                            style="font-weight: 600; color: var(--gray-900); font-size: 0.875rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            {{ $documento->tipo }}
                                        </div>
                                        <div style="font-size: 0.75rem; color: var(--gray-500);">
                                            {{ $documento->fecha_subida->format('d/m/Y') }}
                                        </div>
                                    </div>
                                    <a href="{{ $documento->url }}" target="_blank" class="btn btn-ghost btn-sm">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p style="color: var(--gray-500); text-align: center; padding: var(--spacing-xl);">
                        <i class="fas fa-info-circle"></i> No hay documentos cargados
                    </p>
                @endif
            </div>
        </div>

        <!-- Right Column (1/3 width) -->
        <div>
            <!-- Información del Apoderado -->
            <div class="card" style="margin-bottom: var(--spacing-xl);">
                <h3
                    style="font-size: 1.125rem; font-weight: 700; color: var(--gray-900); margin-bottom: var(--spacing-lg); display: flex; align-items: center; gap: var(--spacing-sm);">
                    <i class="fas fa-user-tie" style="color: var(--theme-color);"></i>
                    Apoderado
                </h3>

                @if($estudiante->apoderado)
                    <div style="display: flex; flex-direction: column; gap: var(--spacing-md);">
                        <div>
                            <div
                                style="font-weight: 700; font-size: 1.125rem; color: var(--gray-900); margin-bottom: var(--spacing-xs);">
                                {{ $estudiante->apoderado->nombre_completo }}
                            </div>
                            <div style="color: var(--gray-600); font-size: 0.875rem;">
                                {{ $estudiante->apoderado->relacion }}
                            </div>
                        </div>

                        <div style="border-top: 1px solid var(--gray-200); padding-top: var(--spacing-md);">
                            @if($estudiante->apoderado->rut)
                                <div
                                    style="margin-bottom: var(--spacing-sm); display: flex; align-items: center; gap: var(--spacing-sm);">
                                    <i class="fas fa-id-card" style="color: var(--gray-400); width: 20px;"></i>
                                    <span
                                        style="font-size: 0.875rem; color: var(--gray-700);">{{ $estudiante->apoderado->rut }}</span>
                                </div>
                            @endif
                            @if($estudiante->apoderado->email)
                                <div
                                    style="margin-bottom: var(--spacing-sm); display: flex; align-items: center; gap: var(--spacing-sm);">
                                    <i class="fas fa-envelope" style="color: var(--gray-400); width: 20px;"></i>
                                    <a href="mailto:{{ $estudiante->apoderado->email }}"
                                        style="font-size: 0.875rem; color: var(--theme-color); text-decoration: none;">
                                        {{ $estudiante->apoderado->email }}
                                    </a>
                                </div>
                            @endif
                            @if($estudiante->apoderado->telefono)
                                <div
                                    style="margin-bottom: var(--spacing-sm); display: flex; align-items: center; gap: var(--spacing-sm);">
                                    <i class="fas fa-phone" style="color: var(--gray-400); width: 20px;"></i>
                                    <a href="tel:{{ $estudiante->apoderado->telefono }}"
                                        style="font-size: 0.875rem; color: var(--theme-color); text-decoration: none;">
                                        {{ $estudiante->apoderado->telefono }}
                                    </a>
                                </div>
                            @endif
                            @if($estudiante->apoderado->telefono_emergencia)
                                <div
                                    style="margin-bottom: var(--spacing-sm); display: flex; align-items: center; gap: var(--spacing-sm);">
                                    <i class="fas fa-phone-alt" style="color: var(--error); width: 20px;"></i>
                                    <a href="tel:{{ $estudiante->apoderado->telefono_emergencia }}"
                                        style="font-size: 0.875rem; color: var(--error); text-decoration: none; font-weight: 600;">
                                        {{ $estudiante->apoderado->telefono_emergencia }}
                                    </a>
                                </div>
                            @endif
                        </div>

                        @if($estudiante->apoderado->ocupacion || $estudiante->apoderado->lugar_trabajo)
                            <div style="border-top: 1px solid var(--gray-200); padding-top: var(--spacing-md);">
                                @if($estudiante->apoderado->ocupacion)
                                    <div
                                        style="margin-bottom: var(--spacing-sm); display: flex; align-items: center; gap: var(--spacing-sm);">
                                        <i class="fas fa-briefcase" style="color: var(--gray-400); width: 20px;"></i>
                                        <span
                                            style="font-size: 0.875rem; color: var(--gray-700);">{{ $estudiante->apoderado->ocupacion }}</span>
                                    </div>
                                @endif
                                @if($estudiante->apoderado->lugar_trabajo)
                                    <div
                                        style="margin-bottom: var(--spacing-sm); display: flex; align-items: center; gap: var(--spacing-sm);">
                                        <i class="fas fa-building" style="color: var(--gray-400); width: 20px;"></i>
                                        <span
                                            style="font-size: 0.875rem; color: var(--gray-700);">{{ $estudiante->apoderado->lugar_trabajo }}</span>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                @else
                    <p style="color: var(--gray-500); text-align: center; padding: var(--spacing-lg);">
                        <i class="fas fa-info-circle"></i> Sin apoderado asignado
                    </p>
                @endif
            </div>

            <!-- Profesor Jefe -->
            @if($estudiante->curso_actual && $estudiante->curso_actual->profesor)
                <div class="card" style="margin-bottom: var(--spacing-xl);">
                    <h3
                        style="font-size: 1.125rem; font-weight: 700; color: var(--gray-900); margin-bottom: var(--spacing-lg); display: flex; align-items: center; gap: var(--spacing-sm);">
                        <i class="fas fa-chalkboard-teacher" style="color: var(--theme-color);"></i>
                        Profesor Jefe
                    </h3>

                    <div style="text-align: center;">
                        <div
                            style="width: 64px; height: 64px; margin: 0 auto var(--spacing-md); border-radius: var(--radius-full); background: var(--accent); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem; font-weight: 700;">
                            {{ strtoupper(substr($estudiante->curso_actual->profesor->nombre, 0, 1) . substr($estudiante->curso_actual->profesor->apellido, 0, 1)) }}
                        </div>
                        <div
                            style="font-weight: 700; font-size: 1rem; color: var(--gray-900); margin-bottom: var(--spacing-xs);">
                            {{ $estudiante->curso_actual->profesor->nombre_completo }}
                        </div>
                        <div style="color: var(--gray-600); font-size: 0.875rem; margin-bottom: var(--spacing-md);">
                            {{ $estudiante->curso_actual->nombre }}
                        </div>
                        @if($estudiante->curso_actual->profesor->email)
                            <a href="mailto:{{ $estudiante->curso_actual->profesor->email }}" class="btn btn-outline btn-sm"
                                style="width: 100%;">
                                <i class="fas fa-envelope"></i> Contactar
                            </a>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Información Personal -->
            <div class="card">
                <h3
                    style="font-size: 1.125rem; font-weight: 700; color: var(--gray-900); margin-bottom: var(--spacing-lg); display: flex; align-items: center; gap: var(--spacing-sm);">
                    <i class="fas fa-info-circle" style="color: var(--theme-color);"></i>
                    Información Personal
                </h3>

                <div style="display: flex; flex-direction: column; gap: var(--spacing-sm);">
                    @if($estudiante->genero)
                        <div
                            style="display: flex; justify-content: space-between; padding: var(--spacing-sm) 0; border-bottom: 1px solid var(--gray-100);">
                            <span style="color: var(--gray-600); font-size: 0.875rem;">Género</span>
                            <span style="font-weight: 600; font-size: 0.875rem;">{{ $estudiante->genero }}</span>
                        </div>
                    @endif
                    @if($estudiante->nacionalidad)
                        <div
                            style="display: flex; justify-content: space-between; padding: var(--spacing-sm) 0; border-bottom: 1px solid var(--gray-100);">
                            <span style="color: var(--gray-600); font-size: 0.875rem;">Nacionalidad</span>
                            <span style="font-weight: 600; font-size: 0.875rem;">{{ $estudiante->nacionalidad }}</span>
                        </div>
                    @endif
                    @if($estudiante->fecha_nacimiento)
                        <div
                            style="display: flex; justify-content: space-between; padding: var(--spacing-sm) 0; border-bottom: 1px solid var(--gray-100);">
                            <span style="color: var(--gray-600); font-size: 0.875rem;">Fecha Nacimiento</span>
                            <span
                                style="font-weight: 600; font-size: 0.875rem;">{{ $estudiante->fecha_nacimiento->format('d/m/Y') }}</span>
                        </div>
                    @endif
                    @if($estudiante->ciudad)
                        <div
                            style="display: flex; justify-content: space-between; padding: var(--spacing-sm) 0; border-bottom: 1px solid var(--gray-100);">
                            <span style="color: var(--gray-600); font-size: 0.875rem;">Ciudad</span>
                            <span style="font-weight: 600; font-size: 0.875rem;">{{ $estudiante->ciudad }}</span>
                        </div>
                    @endif
                    @if($estudiante->region)
                        <div style="display: flex; justify-content: space-between; padding: var(--spacing-sm) 0;">
                            <span style="color: var(--gray-600); font-size: 0.875rem;">Región</span>
                            <span style="font-weight: 600; font-size: 0.875rem;">{{ $estudiante->region }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        @media (max-width: 1024px) {

            .grid-cols-3,
            .grid-cols-4 {
                grid-template-columns: 1fr !important;
            }

            .grid-cols-3>div {
                grid-column: span 1 !important;
            }
        }

        @media (max-width: 768px) {
            .grid-cols-2 {
                grid-template-columns: 1fr !important;
            }
        }
    </style>
</x-app-layout>