<x-app-layout>
    <x-slot name="header">
        {{ $asignatura->nombre }} - Detalle
    </x-slot>

    <link rel="stylesheet" href="{{ asset('css/shared-index.css') }}?v={{ time() }}">

    <div class="page-header"
        style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-lg); flex-wrap: wrap; gap: var(--spacing-md);">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--text-color); margin: 0;">
                {{ $asignatura->nombre }}
            </h2>
            <p style="color: var(--text-muted); margin: var(--spacing-xs) 0 0 0; font-size: 0.9375rem;">
                <i class="fas fa-barcode"></i> {{ $asignatura->codigo }}
                @if($asignatura->descripcion)
                    &middot; {{ $asignatura->descripcion }}
                @endif
            </p>
        </div>
        <div style="display: flex; gap: var(--spacing-sm); flex-wrap: wrap;">
            <a href="{{ route('subjects.edit', $asignatura) }}" class="btn btn-outline"
                style="color: var(--text-color); border-color: var(--border-color);">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="{{ route('subjects.index') }}" class="btn btn-outline"
                style="color: var(--text-muted); border-color: var(--border-color);">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: var(--spacing-md); margin-bottom: var(--spacing-lg);">
        <div class="stat-card" style="text-align: center;">
            <div class="stat-value">{{ $asignatura->cursos->count() }}</div>
            <div class="stat-label"><i class="fas fa-chalkboard"></i> Cursos</div>
        </div>
        <div class="stat-card" style="text-align: center;">
            <div class="stat-value">{{ $asignatura->cursos->sum(fn($c) => $c->estudiantes->count()) }}</div>
            <div class="stat-label"><i class="fas fa-users"></i> Estudiantes</div>
        </div>
        <div class="stat-card" style="text-align: center;">
            <div class="stat-value">{{ $asignatura->notas->count() }}</div>
            <div class="stat-label"><i class="fas fa-clipboard-check"></i> Notas</div>
        </div>
    </div>

    <div class="system-tabs-container">
        <div onclick="switchSystemTab('cursos')" class="system-tab active-tab" id="tab-cursos">Cursos</div>
        <div onclick="switchSystemTab('estadisticas')" class="system-tab" id="tab-estadisticas">Estadísticas</div>
    </div>

    <div id="section-cursos" class="system-tab-section active-section">
        <div style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: var(--spacing-lg);">
            <h3 style="font-size: 1rem; font-weight: 700; color: var(--text-color); margin: 0 0 var(--spacing-lg) 0; padding-bottom: var(--spacing-sm); border-bottom: 1px solid var(--border-color); display: flex; align-items: center; gap: var(--spacing-sm);">
                <i class="fas fa-chalkboard" style="color: var(--text-muted);"></i> Cursos donde se imparte
            </h3>

            @if($asignatura->cursos->count() > 0)
                <div style="display: flex; flex-direction: column; gap: var(--spacing-md);">
                    @foreach($asignatura->cursos as $curso)
                        @php
                            $notasCurso = $asignatura->notas->where('curso_id', $curso->id);
                            $promedio = $notasCurso->count() > 0 ? $notasCurso->avg('nota') : null;
                        @endphp
                        <div style="padding: var(--spacing-md); border: 1px solid var(--border-color); border-radius: var(--radius-md);">
                            <div style="display: flex; justify-content: space-between; align-items: start; flex-wrap: wrap; gap: var(--spacing-sm);">
                                <div style="flex: 1; min-width: 0;">
                                    <div style="font-weight: 700; font-size: 1rem; color: var(--text-color); margin-bottom: 4px;">
                                        {{ $curso->nombre }}
                                    </div>
                                    <div style="display: flex; flex-wrap: wrap; gap: var(--spacing-md); color: var(--text-muted); font-size: 0.875rem; margin-bottom: var(--spacing-sm);">
                                        <span><i class="fas fa-users"></i> {{ $curso->estudiantes->count() }} estudiantes</span>
                                        <span><i class="fas fa-clipboard-check"></i> {{ $notasCurso->count() }} notas</span>
                                        @if($promedio)
                                            <span><i class="fas fa-chart-line"></i> Promedio:
                                                <strong style="color: var(--text-color);">{{ number_format($promedio, 1) }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div style="display: flex; gap: var(--spacing-sm); flex-wrap: wrap;">
                                        <a href="{{ route('courses.show', $curso->id) }}" class="btn btn-sm btn-outline" style="color: var(--text-color); border-color: var(--border-color);">
                                            <i class="fas fa-eye"></i> Ver Curso
                                        </a>
                                        <a href="{{ route('grades.create', ['curso_id' => $curso->id, 'asignatura_id' => $asignatura->id]) }}"
                                            class="btn btn-sm btn-outline" style="color: var(--text-color); border-color: var(--border-color);">
                                            <i class="fas fa-plus"></i> Agregar Notas
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: var(--spacing-2xl); border: 1px dashed var(--border-color); border-radius: var(--radius-md);">
                    <i class="fas fa-chalkboard" style="font-size: 2.5rem; color: var(--text-muted); margin-bottom: var(--spacing-md); opacity: 0.6;"></i>
                    <p style="color: var(--text-color); margin: 0; font-weight: 500;">Esta asignatura no está asignada a ningún curso</p>
                </div>
            @endif
        </div>
    </div>

    <div id="section-estadisticas" class="system-tab-section">
        <div style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: var(--spacing-lg);">
            <h3 style="font-size: 1rem; font-weight: 700; color: var(--text-color); margin: 0 0 var(--spacing-lg) 0; padding-bottom: var(--spacing-sm); border-bottom: 1px solid var(--border-color); display: flex; align-items: center; gap: var(--spacing-sm);">
                <i class="fas fa-chart-bar" style="color: var(--text-muted);"></i> Estadísticas de Notas
            </h3>

            @if($asignatura->notas->count() > 0)
                <div style="display: flex; flex-direction: column; gap: 0;">
                    @php
                        $stats = [
                            ['label' => 'Total Notas',      'value' => $asignatura->notas->count()],
                            ['label' => 'Promedio General', 'value' => number_format($asignatura->notas->avg('nota'), 1)],
                            ['label' => 'Nota Máxima',      'value' => number_format($asignatura->notas->max('nota'), 1)],
                            ['label' => 'Nota Mínima',      'value' => number_format($asignatura->notas->min('nota'), 1)],
                            ['label' => 'Aprobados',        'value' => $asignatura->notas->where('nota', '>=', 4.0)->count()],
                            ['label' => 'Reprobados',       'value' => $asignatura->notas->where('nota', '<', 4.0)->count()],
                        ];
                    @endphp
                    @foreach($stats as $i => $s)
                        <div style="display: flex; justify-content: space-between; align-items: center; padding: var(--spacing-md) 0; {{ $i < count($stats) - 1 ? 'border-bottom: 1px solid var(--border-color);' : '' }}">
                            <span style="color: var(--text-muted); font-size: 0.9rem;">{{ $s['label'] }}</span>
                            <span style="font-weight: 700; color: var(--text-color);">{{ $s['value'] }}</span>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: var(--spacing-2xl); border: 1px dashed var(--border-color); border-radius: var(--radius-md);">
                    <i class="fas fa-chart-bar" style="font-size: 2.5rem; color: var(--text-muted); margin-bottom: var(--spacing-md); opacity: 0.6;"></i>
                    <p style="color: var(--text-color); margin: 0; font-weight: 500;">No hay notas registradas aún</p>
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
            .page-header { flex-wrap: nowrap !important; align-items: flex-start !important; }
            .page-header > div:last-child { display: flex; flex-wrap: nowrap !important; gap: var(--spacing-xs) !important; flex-shrink: 0; }
            .page-header .btn { padding: 0.5rem 1rem !important; min-width: 80px; justify-content: center; }
        }
    </style>
</x-app-layout>