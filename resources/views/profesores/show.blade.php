<x-app-layout>
    <x-slot name="header">
        Perfil de Profesor
    </x-slot>

    <!-- Teacher Header -->
    <div class="card" style="margin-bottom: var(--spacing-xl);">
        <div style="display: flex; align-items: center; gap: var(--spacing-xl);">
            <div
                style="width: 100px; height: 100px; border-radius: var(--radius-full); background: linear-gradient(135deg, var(--accent), #9333ea); display: flex; align-items: center; justify-content: center; color: white; font-size: 2.5rem; font-weight: 700; box-shadow: var(--shadow-lg);">
                {{ strtoupper(substr($profesor->nombre, 0, 1) . substr($profesor->apellido, 0, 1)) }}
            </div>
            <div style="flex: 1;">
                <h1
                    style="font-size: 2rem; font-weight: 700; color: var(--gray-900); margin-bottom: var(--spacing-xs);">
                    {{ $profesor->nombre_completo }}
                </h1>
                <div style="display: flex; gap: var(--spacing-lg); flex-wrap: wrap; color: var(--gray-600);">
                    <span><i class="fas fa-id-card"></i> RUT: {{ $profesor->rut }}</span>
                    @if($profesor->edad)
                        <span><i class="fas fa-birthday-cake"></i> {{ $profesor->edad }} años</span>
                    @endif
                    @if($profesor->email)
                        <span><i class="fas fa-envelope"></i> {{ $profesor->email }}</span>
                    @endif
                </div>
            </div>
            <div style="display: flex; gap: var(--spacing-sm);">
                <a href="{{ route('teachers.edit', $profesor->id) }}" class="btn btn-primary">
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
                {{ $profesor->cursos->count() }}
            </div>
            <div style="color: var(--gray-600); font-weight: 600;">Cursos Asignados</div>
        </div>
        <div class="card" style="text-align: center;">
            <div style="font-size: 2.5rem; font-weight: 700; color: var(--success); margin-bottom: var(--spacing-xs);">
                {{ $profesor->cursos->sum(function ($curso) {
    return $curso->estudiantes->count(); }) }}
            </div>
            <div style="color: var(--gray-600); font-weight: 600;">Total Estudiantes</div>
        </div>
        <div class="card" style="text-align: center;">
            <div style="font-size: 2.5rem; font-weight: 700; color: var(--accent); margin-bottom: var(--spacing-xs);">
                {{ $profesor->documentos->count() }}
            </div>
            <div style="color: var(--gray-600); font-weight: 600;">Documentos</div>
        </div>
        <div class="card" style="text-align: center;">
            <div style="font-size: 2.5rem; font-weight: 700; color: var(--warning); margin-bottom: var(--spacing-xs);">
                {{ $profesor->cursos->flatMap->asignaturas->unique('id')->count() }}
            </div>
            <div style="color: var(--gray-600); font-weight: 600;">Asignaturas</div>
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
                    <i class="fas fa-chalkboard-teacher" style="color: var(--theme-color);"></i>
                    Cursos Asignados
                </h3>

                @if($profesor->cursos->count() > 0)
                    <div style="display: flex; flex-direction: column; gap: var(--spacing-md);">
                        @foreach($profesor->cursos as $curso)
                            <div
                                style="padding: var(--spacing-lg); background: var(--gray-50); border-radius: var(--radius-lg); border-left: 4px solid var(--accent);">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <div style="flex: 1;">
                                        <div
                                            style="font-weight: 700; font-size: 1.125rem; color: var(--gray-900); margin-bottom: var(--spacing-xs);">
                                            {{ $curso->nombre }}
                                        </div>
                                        <div
                                            style="display: flex; gap: var(--spacing-lg); color: var(--gray-600); font-size: 0.875rem; margin-bottom: var(--spacing-sm);">
                                            <span>
                                                <i class="fas fa-users"></i> {{ $curso->estudiantes->count() }} estudiantes
                                            </span>
                                            <span>
                                                <i class="fas fa-book"></i> {{ $curso->asignaturas->count() }} asignaturas
                                            </span>
                                        </div>
                                        @if($curso->asignaturas->count() > 0)
                                            <div style="display: flex; gap: var(--spacing-xs); flex-wrap: wrap;">
                                                @foreach($curso->asignaturas->take(5) as $asignatura)
                                                    <span class="badge" style="background: var(--gray-200); color: var(--gray-700);">
                                                        {{ $asignatura->nombre }}
                                                    </span>
                                                @endforeach
                                                @if($curso->asignaturas->count() > 5)
                                                    <span class="badge" style="background: var(--gray-200); color: var(--gray-700);">
                                                        +{{ $curso->asignaturas->count() - 5 }} más
                                                    </span>
                                                @endif
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

            <!-- Documentos -->
            <div class="card">
                <h3
                    style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900); margin-bottom: var(--spacing-lg); display: flex; align-items: center; gap: var(--spacing-sm);">
                    <i class="fas fa-folder-open" style="color: var(--theme-color);"></i>
                    Documentos
                </h3>

                @if($profesor->documentos->count() > 0)
                    <div class="grid grid-cols-2" style="gap: var(--spacing-md);">
                        @foreach($profesor->documentos as $documento)
                            <div
                                style="padding: var(--spacing-md); background: var(--gray-50); border-radius: var(--radius-lg); border: 1px solid var(--gray-200);">
                                <div style="display: flex; align-items: center; gap: var(--spacing-md);">
                                    <div
                                        style="width: 48px; height: 48px; background: var(--accent); border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.25rem;">
                                        <i class="fas fa-file-pdf"></i>
                                    </div>
                                    <div style="flex: 1; min-width: 0;">
                                        <div
                                            style="font-weight: 600; color: var(--gray-900); font-size: 0.875rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            {{ $documento->tipo }}
                                        </div>
                                        <div style="font-size: 0.75rem; color: var(--gray-500);">
                                            {{ $documento->created_at->format('d/m/Y') }}
                                        </div>
                                    </div>
                                    <a href="{{ Storage::url($documento->ruta_archivo) }}" target="_blank"
                                        class="btn btn-ghost btn-sm">
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
            <!-- Información Personal -->
            <div class="card">
                <h3
                    style="font-size: 1.125rem; font-weight: 700; color: var(--gray-900); margin-bottom: var(--spacing-lg); display: flex; align-items: center; gap: var(--spacing-sm);">
                    <i class="fas fa-info-circle" style="color: var(--theme-color);"></i>
                    Información Personal
                </h3>

                <div style="display: flex; flex-direction: column; gap: var(--spacing-sm);">
                    @if($profesor->fecha_nacimiento)
                        <div
                            style="display: flex; justify-content: space-between; padding: var(--spacing-sm) 0; border-bottom: 1px solid var(--gray-100);">
                            <span style="color: var(--gray-600); font-size: 0.875rem;">Fecha Nacimiento</span>
                            <span
                                style="font-weight: 600; font-size: 0.875rem;">{{ $profesor->fecha_nacimiento->format('d/m/Y') }}</span>
                        </div>
                    @endif
                    @if($profesor->telefono)
                        <div
                            style="display: flex; justify-content: space-between; padding: var(--spacing-sm) 0; border-bottom: 1px solid var(--gray-100);">
                            <span style="color: var(--gray-600); font-size: 0.875rem;">Teléfono</span>
                            <span style="font-weight: 600; font-size: 0.875rem;">{{ $profesor->telefono }}</span>
                        </div>
                    @endif
                    @if($profesor->email)
                        <div
                            style="display: flex; justify-content: space-between; padding: var(--spacing-sm) 0; border-bottom: 1px solid var(--gray-100);">
                            <span style="color: var(--gray-600); font-size: 0.875rem;">Email</span>
                            <span
                                style="font-weight: 600; font-size: 0.875rem; word-break: break-all;">{{ $profesor->email }}</span>
                        </div>
                    @endif
                    @if($profesor->nivel_ensenanza)
                        <div
                            style="display: flex; justify-content: space-between; padding: var(--spacing-sm) 0; border-bottom: 1px solid var(--gray-100);">
                            <span style="color: var(--gray-600); font-size: 0.875rem;">Nivel Enseñanza</span>
                            <span style="font-weight: 600; font-size: 0.875rem;">{{ $profesor->nivel_ensenanza }}</span>
                        </div>
                    @endif
                    @if($profesor->titulo)
                        <div style="display: flex; justify-content: space-between; padding: var(--spacing-sm) 0;">
                            <span style="color: var(--gray-600); font-size: 0.875rem;">Título</span>
                            <span style="font-weight: 600; font-size: 0.875rem;">{{ $profesor->titulo }}</span>
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