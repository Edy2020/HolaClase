<x-app-layout>
    <x-slot name="header">
        {{ $estudiante->nombre_completo }} - Perfil
    </x-slot>

    <link rel="stylesheet" href="{{ asset('css/shared-index.css') }}?v={{ time() }}">

    <div class="page-header"
        style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-lg); flex-wrap: wrap; gap: var(--spacing-md);">
        <div style="display: flex; align-items: center; gap: var(--spacing-md);">
            <div style="width: 52px; height: 52px; border-radius: 50%; background: var(--gray-200); display: flex; align-items: center; justify-content: center; color: var(--text-color); font-size: 1.25rem; font-weight: 700; flex-shrink: 0;">
                {{ strtoupper(substr($estudiante->nombre, 0, 1) . substr($estudiante->apellido, 0, 1)) }}
            </div>
            <div>
                <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--text-color); margin: 0;">
                    {{ $estudiante->nombre_completo }}
                </h2>
                <p style="color: var(--text-muted); margin: 2px 0 0 0; font-size: 0.9rem;">
                    <i class="fas fa-id-card"></i> {{ $estudiante->rut }}
                    @if($estudiante->email) &middot; <i class="fas fa-envelope"></i> {{ $estudiante->email }} @endif
                </p>
            </div>
        </div>
        <div style="display: flex; gap: var(--spacing-sm); align-items: center; flex-wrap: nowrap;">
            <select id="statusSelect" class="form-select"
                style="font-size: 0.875rem; padding: 0.4rem 0.75rem; cursor: pointer; border: 1px solid var(--border-color); background: var(--bg-card); color: var(--text-color); border-radius: var(--radius-md); font-weight: 600; text-align: center;">
                <option value="activo" {{ $estudiante->estado === 'activo' ? 'selected' : '' }}>✓ Activo</option>
                <option value="inactivo" {{ $estudiante->estado === 'inactivo' ? 'selected' : '' }}>⏸ Inactivo</option>
                <option value="retirado" {{ $estudiante->estado === 'retirado' ? 'selected' : '' }}>✕ Retirado</option>
            </select>
            <a href="{{ route('students.edit', $estudiante->id) }}" class="btn btn-sm btn-outline"
                style="color: var(--text-color); border-color: var(--border-color);">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="{{ route('students.index') }}" class="btn btn-sm btn-outline"
                style="color: var(--text-muted); border-color: var(--border-color);">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: var(--spacing-md); margin-bottom: var(--spacing-lg);">
        <div class="stat-card" style="text-align: center;">
            <div class="stat-value">{{ $estudiante->promedio_general ?? 'N/A' }}</div>
            <div class="stat-label"><i class="fas fa-chart-line"></i> Promedio</div>
        </div>
        <div class="stat-card" style="text-align: center;">
            <div class="stat-value">{{ $estudiante->cursos->count() }}</div>
            <div class="stat-label"><i class="fas fa-school"></i> Cursos</div>
        </div>
        <div class="stat-card" style="text-align: center;">
            <div class="stat-value">{{ $estudiante->documentos->count() }}</div>
            <div class="stat-label"><i class="fas fa-file-alt"></i> Documentos</div>
        </div>
        <div class="stat-card" style="text-align: center;">
            <div class="stat-value">{{ count($promediosPorAsignatura) }}</div>
            <div class="stat-label"><i class="fas fa-book"></i> Asignaturas</div>
        </div>
    </div>

    <div class="system-tabs-container">
        <div onclick="switchSystemTab('cursos')" class="system-tab active-tab" id="tab-cursos">Cursos</div>
        <div onclick="switchSystemTab('notas')" class="system-tab" id="tab-notas">Notas</div>
        <div onclick="switchSystemTab('apoderado')" class="system-tab" id="tab-apoderado">Apoderado</div>
        <div onclick="switchSystemTab('info')" class="system-tab" id="tab-info">Información</div>
        <div onclick="switchSystemTab('documentos')" class="system-tab" id="tab-documentos">Documentos</div>
    </div>

    <div id="section-cursos" class="system-tab-section active-section">
        <div style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: var(--spacing-lg);">
            <h3 style="font-size: 1rem; font-weight: 700; color: var(--text-color); margin: 0 0 var(--spacing-lg) 0; padding-bottom: var(--spacing-sm); border-bottom: 1px solid var(--border-color); display: flex; align-items: center; gap: var(--spacing-sm);">
                <i class="fas fa-school" style="color: var(--text-muted);"></i> Cursos Asignados
            </h3>
            @if($estudiante->cursos->count() > 0)
                <div style="display: flex; flex-direction: column; gap: var(--spacing-md);">
                    @foreach($estudiante->cursos as $curso)
                        <div style="padding: var(--spacing-md); border: 1px solid var(--border-color); border-radius: var(--radius-md); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: var(--spacing-sm);">
                            <div>
                                <div style="font-weight: 700; color: var(--text-color); margin-bottom: 4px;">{{ $curso->nombre }}</div>
                                @if($curso->profesor)
                                    <div style="color: var(--text-muted); font-size: 0.875rem;"><i class="fas fa-chalkboard-teacher"></i> {{ $curso->profesor->nombre_completo }}</div>
                                @endif
                            </div>
                            <a href="{{ route('courses.show', $curso->id) }}" class="btn btn-sm btn-outline" style="color: var(--text-color); border-color: var(--border-color);">
                                <i class="fas fa-eye"></i> Ver
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: var(--spacing-2xl); border: 1px dashed var(--border-color); border-radius: var(--radius-md);">
                    <i class="fas fa-school" style="font-size: 2.5rem; color: var(--text-muted); margin-bottom: var(--spacing-md); opacity: 0.6;"></i>
                    <p style="color: var(--text-color); margin: 0; font-weight: 500;">No hay cursos asignados</p>
                </div>
            @endif
        </div>
    </div>

    <div id="section-notas" class="system-tab-section">
        <div style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: var(--spacing-lg);">
            <h3 style="font-size: 1rem; font-weight: 700; color: var(--text-color); margin: 0 0 var(--spacing-lg) 0; padding-bottom: var(--spacing-sm); border-bottom: 1px solid var(--border-color); display: flex; align-items: center; gap: var(--spacing-sm);">
                <i class="fas fa-book" style="color: var(--text-muted);"></i> Asignaturas y Notas
            </h3>
            @if(count($promediosPorAsignatura) > 0)
                <div style="display: flex; flex-direction: column; gap: 0; border: 1px solid var(--border-color); border-radius: var(--radius-md); overflow: hidden;">
                    @foreach($promediosPorAsignatura as $data)
                        <div style="display: flex; justify-content: space-between; align-items: center; padding: var(--spacing-md); {{ !$loop->last ? 'border-bottom: 1px solid var(--border-color);' : '' }} flex-wrap: wrap; gap: var(--spacing-sm);">
                            <span style="font-weight: 600; color: var(--text-color); font-size: 0.9rem;">{{ $data['asignatura']->nombre }}</span>
                            <div style="display: flex; align-items: center; gap: var(--spacing-sm);">
                                @if($data['promedio'])
                                    <span style="font-size: 1rem; font-weight: 700; color: {{ $data['promedio'] >= 6.0 ? 'var(--success)' : ($data['promedio'] >= 4.0 ? 'var(--warning)' : 'var(--error)') }};">
                                        {{ number_format($data['promedio'], 1) }}
                                    </span>
                                    <span class="badge {{ $data['promedio'] >= 4.0 ? 'badge-success' : 'badge-error' }}">{{ $data['promedio'] >= 4.0 ? 'Aprobado' : 'Reprobado' }}</span>
                                @else
                                    <span style="color: var(--text-muted); font-size: 0.875rem;">Sin notas</span>
                                    <span class="badge">Pendiente</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: var(--spacing-2xl); border: 1px dashed var(--border-color); border-radius: var(--radius-md);">
                    <i class="fas fa-book" style="font-size: 2.5rem; color: var(--text-muted); margin-bottom: var(--spacing-md); opacity: 0.6;"></i>
                    <p style="color: var(--text-color); margin: 0; font-weight: 500;">No hay asignaturas asignadas</p>
                </div>
            @endif
        </div>
    </div>

    <div id="section-apoderado" class="system-tab-section">
        <div style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: var(--spacing-lg);">
            <h3 style="font-size: 1rem; font-weight: 700; color: var(--text-color); margin: 0 0 var(--spacing-lg) 0; padding-bottom: var(--spacing-sm); border-bottom: 1px solid var(--border-color); display: flex; align-items: center; gap: var(--spacing-sm);">
                <i class="fas fa-user-tie" style="color: var(--text-muted);"></i> Apoderado
            </h3>
            @if($estudiante->apoderado)
                <div>
                    <div style="font-weight: 700; font-size: 1.1rem; color: var(--text-color); margin-bottom: 2px;">{{ $estudiante->apoderado->nombre_completo }}</div>
                    <div style="color: var(--text-muted); font-size: 0.875rem; margin-bottom: var(--spacing-md);">{{ $estudiante->apoderado->relacion }}</div>
                    <div style="display: flex; flex-direction: column; gap: 0; border-top: 1px solid var(--border-color);">
                        @foreach(array_filter([
                            ['icon' => 'fa-id-card',    'val' => $estudiante->apoderado->rut],
                            ['icon' => 'fa-envelope',   'val' => $estudiante->apoderado->email],
                            ['icon' => 'fa-phone',      'val' => $estudiante->apoderado->telefono],
                            ['icon' => 'fa-phone-alt',  'val' => $estudiante->apoderado->telefono_emergencia],
                            ['icon' => 'fa-briefcase',  'val' => $estudiante->apoderado->ocupacion],
                            ['icon' => 'fa-building',   'val' => $estudiante->apoderado->lugar_trabajo],
                        ], fn($r) => !empty($r['val'])) as $row)
                            <div style="display: flex; align-items: center; gap: var(--spacing-md); padding: var(--spacing-sm) 0; border-bottom: 1px solid var(--border-color);">
                                <i class="fas {{ $row['icon'] }}" style="color: var(--text-muted); width: 18px;"></i>
                                <span style="font-size: 0.875rem; color: var(--text-color);">{{ $row['val'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div style="text-align: center; padding: var(--spacing-2xl); border: 1px dashed var(--border-color); border-radius: var(--radius-md);">
                    <p style="color: var(--text-color); margin: 0; font-weight: 500;">Sin apoderado asignado</p>
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
                    ['label' => 'Género',           'value' => $estudiante->genero],
                    ['label' => 'Nacionalidad',     'value' => $estudiante->nacionalidad],
                    ['label' => 'Fecha Nacimiento', 'value' => $estudiante->fecha_nacimiento?->format('d/m/Y')],
                    ['label' => 'Edad',             'value' => $estudiante->edad ? $estudiante->edad . ' años' : null],
                    ['label' => 'Ciudad',           'value' => $estudiante->ciudad],
                    ['label' => 'Región',           'value' => $estudiante->region],
                    ['label' => 'Dirección',        'value' => $estudiante->direccion],
                ], fn($r) => !empty($r['value']));
            @endphp
            <div>
                @foreach(array_values($infoRows) as $i => $row)
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: var(--spacing-md) 0; {{ $i < count($infoRows) - 1 ? 'border-bottom: 1px solid var(--border-color);' : '' }}">
                        <span style="color: var(--text-muted); font-size: 0.9rem;">{{ $row['label'] }}</span>
                        <span style="font-weight: 600; color: var(--text-color); font-size: 0.9rem;">{{ $row['value'] }}</span>
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
            @if($estudiante->documentos->count() > 0)
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--spacing-md);">
                    @foreach($estudiante->documentos as $documento)
                        <div style="padding: var(--spacing-md); border: 1px solid var(--border-color); border-radius: var(--radius-md); display: flex; align-items: center; gap: var(--spacing-md);">
                            <div style="width: 40px; height: 40px; border-radius: var(--radius-md); border: 1px solid var(--border-color); display: flex; align-items: center; justify-content: center; color: var(--text-muted); flex-shrink: 0;">
                                <i class="fas fa-file-pdf"></i>
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <div style="font-weight: 600; color: var(--text-color); font-size: 0.9rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $documento->tipo }}</div>
                                <div style="font-size: 0.75rem; color: var(--text-muted);">{{ $documento->fecha_subida->format('d/m/Y') }}</div>
                            </div>
                            <a href="{{ $documento->url }}" target="_blank" class="btn btn-sm btn-outline" style="color: var(--text-color); border-color: var(--border-color); flex-shrink: 0;">
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
        document.getElementById('statusSelect').addEventListener('change', function(e) {
            const newStatus = e.target.value;
            const select = e.target;
            select.disabled = true;
            fetch('{{ route("students.update-status", $estudiante->id) }}', {
                method: 'PATCH',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                body: JSON.stringify({ estado: newStatus })
            })
            .then(r => r.json())
            .then(data => {
                if (!data.success) select.value = '{{ $estudiante->estado }}';
            })
            .catch(() => select.value = '{{ $estudiante->estado }}')
            .finally(() => select.disabled = false);
        });
    </script>

    <style>
        @media (max-width: 768px) {
            div[style*="grid-template-columns: repeat(4, 1fr)"] { grid-template-columns: repeat(2, 1fr) !important; }
            div[style*="grid-template-columns: 1fr 1fr"] { grid-template-columns: 1fr !important; }
            .page-header { flex-wrap: nowrap !important; align-items: flex-start !important; }
            .page-header > div:last-child { flex-wrap: wrap !important; }
        }
    </style>
</x-app-layout>
