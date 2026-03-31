<x-app-layout>
    <x-slot name="header">
        {{ $profesor->nombre_completo }} - Perfil
    </x-slot>

    <link rel="stylesheet" href="{{ asset('css/shared-index.css') }}?v={{ time() }}">

    <div class="page-header"
        style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-lg); flex-wrap: wrap; gap: var(--spacing-md);">
        <div style="display: flex; align-items: center; gap: var(--spacing-md);">
            <div style="width: 52px; height: 52px; border-radius: 50%; background: var(--gray-200); display: flex; align-items: center; justify-content: center; color: var(--text-color); font-size: 1.25rem; font-weight: 700; flex-shrink: 0;">
                {{ strtoupper(substr($profesor->nombre, 0, 1) . substr($profesor->apellido, 0, 1)) }}
            </div>
            <div>
                <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--text-color); margin: 0;">
                    {{ $profesor->nombre_completo }}
                </h2>
                <p style="color: var(--text-muted); margin: 2px 0 0 0; font-size: 0.9rem;">
                    <i class="fas fa-id-card"></i> {{ $profesor->rut }}
                    @if($profesor->email) &middot; <i class="fas fa-envelope"></i> {{ $profesor->email }} @endif
                </p>
            </div>
        </div>
        <div style="display: flex; gap: var(--spacing-sm); flex-wrap: wrap;">
            <a href="{{ route('teachers.edit', $profesor->id) }}" class="btn btn-outline"
                style="color: var(--text-color); border-color: var(--border-color);">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="{{ route('teachers.index') }}" class="btn btn-outline"
                style="color: var(--text-muted); border-color: var(--border-color);">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: var(--spacing-md); margin-bottom: var(--spacing-lg);">
        <div class="stat-card" style="text-align: center;">
            <div class="stat-value">{{ $profesor->cursos->count() }}</div>
            <div class="stat-label"><i class="fas fa-chalkboard"></i> Cursos</div>
        </div>
        <div class="stat-card" style="text-align: center;">
            <div class="stat-value">{{ $profesor->cursos->sum(fn($c) => $c->estudiantes->count()) }}</div>
            <div class="stat-label"><i class="fas fa-users"></i> Estudiantes</div>
        </div>
        <div class="stat-card" style="text-align: center;">
            <div class="stat-value">{{ $profesor->cursos->flatMap->asignaturas->unique('id')->count() }}</div>
            <div class="stat-label"><i class="fas fa-book"></i> Asignaturas</div>
        </div>
        <div class="stat-card" style="text-align: center;">
            <div class="stat-value">{{ $profesor->documentos->count() }}</div>
            <div class="stat-label"><i class="fas fa-file-alt"></i> Documentos</div>
        </div>
    </div>

    <div class="system-tabs-container">
        <div onclick="switchSystemTab('cursos')" class="system-tab active-tab" id="tab-cursos">Cursos</div>
        <div onclick="switchSystemTab('info')" class="system-tab" id="tab-info">Información</div>
        <div onclick="switchSystemTab('documentos')" class="system-tab" id="tab-documentos">Documentos</div>
    </div>

    <div id="section-cursos" class="system-tab-section active-section">
        <div style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: var(--spacing-lg);">
            <h3 style="font-size: 1rem; font-weight: 700; color: var(--text-color); margin: 0 0 var(--spacing-lg) 0; padding-bottom: var(--spacing-sm); border-bottom: 1px solid var(--border-color); display: flex; align-items: center; gap: var(--spacing-sm);">
                <i class="fas fa-chalkboard-teacher" style="color: var(--text-muted);"></i> Cursos Asignados
            </h3>

            @if($profesor->cursos->count() > 0)
                <div style="display: flex; flex-direction: column; gap: var(--spacing-md);">
                    @foreach($profesor->cursos as $curso)
                        <div style="padding: var(--spacing-md); border: 1px solid var(--border-color); border-radius: var(--radius-md);">
                            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: var(--spacing-sm);">
                                <div style="flex: 1; min-width: 0;">
                                    <div style="font-weight: 700; font-size: 1rem; color: var(--text-color); margin-bottom: 4px;">{{ $curso->nombre }}</div>
                                    <div style="display: flex; flex-wrap: wrap; gap: var(--spacing-md); color: var(--text-muted); font-size: 0.875rem; margin-bottom: var(--spacing-sm);">
                                        <span><i class="fas fa-users"></i> {{ $curso->estudiantes->count() }} estudiantes</span>
                                        <span><i class="fas fa-book"></i> {{ $curso->asignaturas->count() }} asignaturas</span>
                                    </div>
                                    @if($curso->asignaturas->count() > 0)
                                        <div style="display: flex; gap: var(--spacing-xs); flex-wrap: wrap;">
                                            @foreach($curso->asignaturas->take(4) as $asignatura)
                                                <span style="padding: 2px 8px; border: 1px solid var(--border-color); border-radius: var(--radius-sm); font-size: 0.75rem; color: var(--text-muted);">{{ $asignatura->nombre }}</span>
                                            @endforeach
                                            @if($curso->asignaturas->count() > 4)
                                                <span style="padding: 2px 8px; border: 1px solid var(--border-color); border-radius: var(--radius-sm); font-size: 0.75rem; color: var(--text-muted);">+{{ $curso->asignaturas->count() - 4 }} más</span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                                <a href="{{ route('courses.show', $curso->id) }}" class="btn btn-sm btn-outline"
                                    style="color: var(--text-color); border-color: var(--border-color); flex-shrink: 0;">
                                    <i class="fas fa-eye"></i> Ver
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: var(--spacing-2xl); border: 1px dashed var(--border-color); border-radius: var(--radius-md);">
                    <i class="fas fa-chalkboard" style="font-size: 2.5rem; color: var(--text-muted); margin-bottom: var(--spacing-md); opacity: 0.6;"></i>
                    <p style="color: var(--text-color); margin: 0; font-weight: 500;">No hay cursos asignados</p>
                </div>
            @endif
        </div>
    </div>

    <div id="section-info" class="system-tab-section">
        <div style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: var(--spacing-lg);">
            <h3 style="font-size: 1rem; font-weight: 700; color: var(--text-color); margin: 0 0 var(--spacing-lg) 0; padding-bottom: var(--spacing-sm); border-bottom: 1px solid var(--border-color); display: flex; align-items: center; gap: var(--spacing-sm);">
                <i class="fas fa-info-circle" style="color: var(--text-muted);"></i> Información Personal
            </h3>
            @php
                $infoRows = array_filter([
                    ['label' => 'RUT',              'value' => $profesor->rut],
                    ['label' => 'Email',             'value' => $profesor->email],
                    ['label' => 'Teléfono',          'value' => $profesor->telefono],
                    ['label' => 'Fecha Nacimiento',  'value' => $profesor->fecha_nacimiento ? $profesor->fecha_nacimiento->format('d/m/Y') : null],
                    ['label' => 'Edad',              'value' => $profesor->edad ? $profesor->edad . ' años' : null],
                    ['label' => 'Nivel Enseñanza',   'value' => $profesor->nivel_ensenanza],
                    ['label' => 'Título',            'value' => $profesor->titulo],
                ], fn($r) => !empty($r['value']));
            @endphp
            <div style="display: flex; flex-direction: column; gap: 0;">
                @foreach(array_values($infoRows) as $i => $row)
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: var(--spacing-md) 0; {{ $i < count($infoRows) - 1 ? 'border-bottom: 1px solid var(--border-color);' : '' }}">
                        <span style="color: var(--text-muted); font-size: 0.9rem;">{{ $row['label'] }}</span>
                        <span style="font-weight: 600; color: var(--text-color); font-size: 0.9rem; text-align: right; max-width: 60%; word-break: break-word;">{{ $row['value'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div id="section-documentos" class="system-tab-section">
        <div style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: var(--spacing-lg);">
            <h3 style="font-size: 1rem; font-weight: 700; color: var(--text-color); margin: 0 0 var(--spacing-lg) 0; padding-bottom: var(--spacing-sm); border-bottom: 1px solid var(--border-color); display: flex; align-items: center; gap: var(--spacing-sm);">
                <i class="fas fa-folder-open" style="color: var(--text-muted);"></i> Documentos
            </h3>

            @if($profesor->documentos->count() > 0)
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--spacing-md);">
                    @foreach($profesor->documentos as $documento)
                        <div style="padding: var(--spacing-md); border: 1px solid var(--border-color); border-radius: var(--radius-md); display: flex; align-items: center; gap: var(--spacing-md);">
                            <div style="width: 40px; height: 40px; border-radius: var(--radius-md); border: 1px solid var(--border-color); display: flex; align-items: center; justify-content: center; color: var(--text-muted); flex-shrink: 0;">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <div style="font-weight: 600; color: var(--text-color); font-size: 0.9rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $documento->tipo }}</div>
                                <div style="font-size: 0.75rem; color: var(--text-muted);">{{ $documento->created_at->format('d/m/Y') }}</div>
                            </div>
                            <a href="{{ Storage::url($documento->ruta_archivo) }}" target="_blank"
                                class="btn btn-sm btn-outline" style="color: var(--text-color); border-color: var(--border-color); flex-shrink: 0;">
                                <i class="fas fa-download"></i>
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: var(--spacing-2xl); border: 1px dashed var(--border-color); border-radius: var(--radius-md);">
                    <i class="fas fa-folder-open" style="font-size: 2.5rem; color: var(--text-muted); margin-bottom: var(--spacing-md); opacity: 0.6;"></i>
                    <p style="color: var(--text-color); margin: 0; font-weight: 500;">No hay documentos cargados</p>
                </div>
            @endif
        </div>
    </div>

    <script>
        function switchSystemTab(name) {
            document.querySelectorAll('.system-tab').forEach(t => t.classList.remove('active-tab'));
            document.querySelectorAll('.system-tab-section').forEach(s => s.classList.remove('active-section'));
            document.getElementById('tab-' + name).classList.add('active-tab');
            document.getElementById('section-' + name).classList.add('active-section');
        }
    </script>

    <style>
        @media (max-width: 768px) {
            div[style*="grid-template-columns: repeat(4, 1fr)"] { grid-template-columns: repeat(2, 1fr) !important; }
            div[style*="grid-template-columns: 1fr 1fr"] { grid-template-columns: 1fr !important; }
            .page-header { flex-wrap: nowrap !important; align-items: flex-start !important; }
            .page-header > div:last-child { display: flex; flex-wrap: nowrap !important; gap: var(--spacing-xs) !important; flex-shrink: 0; }
            .page-header .btn { padding: 0.5rem 1rem !important; min-width: 80px; justify-content: center; }
        }
    </style>
</x-app-layout>