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
        <div onclick="switchSystemTab('anotaciones')" class="system-tab" id="tab-anotaciones">
            Anotaciones
            @if($estudiante->anotaciones->count() > 0)
                <span style="background: var(--gray-200); color: var(--gray-600); font-size: 0.6875rem; font-weight: 700; padding: 1px 6px; border-radius: 9999px; margin-left: 4px;">{{ $estudiante->anotaciones->count() }}</span>
            @endif
        </div>
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

    <div id="section-anotaciones" class="system-tab-section">
        <div style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: var(--spacing-lg);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-lg); padding-bottom: var(--spacing-sm); border-bottom: 1px solid var(--border-color); flex-wrap: wrap; gap: var(--spacing-sm);">
                <h3 style="font-size: 1rem; font-weight: 700; color: var(--text-color); margin: 0; display: flex; align-items: center; gap: var(--spacing-sm);">
                    <i class="fas fa-clipboard-list" style="color: var(--text-muted);"></i> Hoja de Vida
                </h3>
                <button onclick="openAnotacionModal()" style="display: flex; align-items: center; gap: var(--spacing-xs); background: #84cc16; color: white; border: none; border-radius: var(--radius-md); padding: 0.5rem 1rem; font-weight: 600; font-size: 0.875rem; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='#65a30d'" onmouseout="this.style.background='#84cc16'">
                    <i class="fas fa-plus" style="font-size: 0.75rem;"></i> Nueva Anotación
                </button>
            </div>

            @if($estudiante->anotaciones->count() > 0)
                <div style="display: flex; gap: var(--spacing-xs); margin-bottom: var(--spacing-lg); flex-wrap: wrap;">
                    <button onclick="filterAnotaciones('todas')" class="anotacion-filter active" data-filter="todas" style="padding: 0.35rem 0.875rem; border-radius: 9999px; border: 1px solid var(--text-color); background: var(--text-color); color: var(--bg-card); font-size: 0.8125rem; font-weight: 600; cursor: pointer; transition: all 0.2s;">
                        Todas ({{ $estudiante->anotaciones->count() }})
                    </button>
                    <button onclick="filterAnotaciones('positiva')" class="anotacion-filter" data-filter="positiva" style="padding: 0.35rem 0.875rem; border-radius: 9999px; border: 1px solid var(--border-color); background: transparent; color: var(--text-color); font-size: 0.8125rem; font-weight: 600; cursor: pointer; transition: all 0.2s;">
                        <span style="color: var(--success);">●</span> Positivas ({{ $estudiante->anotaciones->where('tipo', 'positiva')->count() }})
                    </button>
                    <button onclick="filterAnotaciones('negativa')" class="anotacion-filter" data-filter="negativa" style="padding: 0.35rem 0.875rem; border-radius: 9999px; border: 1px solid var(--border-color); background: transparent; color: var(--text-color); font-size: 0.8125rem; font-weight: 600; cursor: pointer; transition: all 0.2s;">
                        <span style="color: var(--error);">●</span> Negativas ({{ $estudiante->anotaciones->where('tipo', 'negativa')->count() }})
                    </button>
                    <button onclick="filterAnotaciones('neutra')" class="anotacion-filter" data-filter="neutra" style="padding: 0.35rem 0.875rem; border-radius: 9999px; border: 1px solid var(--border-color); background: transparent; color: var(--text-color); font-size: 0.8125rem; font-weight: 600; cursor: pointer; transition: all 0.2s;">
                        <span style="color: var(--info);">●</span> Neutras ({{ $estudiante->anotaciones->where('tipo', 'neutra')->count() }})
                    </button>
                </div>

                <div id="anotacionesTimeline" style="display: flex; flex-direction: column; gap: 0; position: relative;">
                    @foreach($estudiante->anotaciones->sortByDesc('fecha') as $anotacion)
                        <div class="anotacion-item" data-tipo="{{ $anotacion->tipo }}" style="display: flex; gap: var(--spacing-md); padding: var(--spacing-md) 0; {{ !$loop->last ? 'border-bottom: 1px solid var(--border-color);' : '' }}">
                            <div style="flex-shrink: 0; display: flex; flex-direction: column; align-items: center; gap: 4px;">
                                <div style="width: 12px; height: 12px; border-radius: 50%; margin-top: 4px;
                                    {{ $anotacion->tipo === 'positiva' ? 'background: var(--success);' : '' }}
                                    {{ $anotacion->tipo === 'negativa' ? 'background: var(--error);' : '' }}
                                    {{ $anotacion->tipo === 'neutra' ? 'background: var(--info);' : '' }}
                                "></div>
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: var(--spacing-sm); flex-wrap: wrap;">
                                    <div style="flex: 1; min-width: 0;">
                                        <div style="display: flex; align-items: center; gap: var(--spacing-sm); flex-wrap: wrap; margin-bottom: 4px;">
                                            <span style="font-weight: 700; color: var(--text-color); font-size: 0.9375rem;">{{ $anotacion->titulo }}</span>
                                            <span style="display: inline-block; padding: 1px 8px; font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.03em; border-radius: 9999px;
                                                {{ $anotacion->tipo === 'positiva' ? 'color: var(--success); background: rgba(34, 197, 94, 0.1);' : '' }}
                                                {{ $anotacion->tipo === 'negativa' ? 'color: var(--error); background: rgba(239, 68, 68, 0.1);' : '' }}
                                                {{ $anotacion->tipo === 'neutra' ? 'color: var(--info); background: rgba(59, 130, 246, 0.1);' : '' }}
                                            ">{{ ucfirst($anotacion->tipo) }}</span>
                                        </div>
                                        @if($anotacion->descripcion)
                                            <p style="color: var(--text-muted); font-size: 0.875rem; margin: 0 0 var(--spacing-sm) 0; line-height: 1.5; word-wrap: break-word;">{{ $anotacion->descripcion }}</p>
                                        @endif
                                        <div style="display: flex; align-items: center; gap: var(--spacing-md); flex-wrap: wrap;">
                                            <span style="font-size: 0.75rem; color: var(--text-muted); display: flex; align-items: center; gap: 4px;">
                                                <i class="fas fa-calendar-alt" style="font-size: 0.625rem;"></i>
                                                {{ $anotacion->fecha->format('d/m/Y') }}
                                            </span>
                                            @if($anotacion->user)
                                                <span style="font-size: 0.75rem; color: var(--text-muted); display: flex; align-items: center; gap: 4px;">
                                                    <i class="fas fa-user" style="font-size: 0.625rem;"></i>
                                                    {{ $anotacion->user->name }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <form action="{{ route('students.anotaciones.destroy', [$estudiante->id, $anotacion->id]) }}" method="POST" style="margin: 0; flex-shrink: 0;" onsubmit="return confirm('¿Eliminar esta anotación?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="width: 30px; height: 30px; border-radius: var(--radius-md); background: transparent; color: var(--text-muted); border: 1px solid var(--border-color); display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 0.6875rem; transition: all 0.2s;" onmouseover="this.style.color='var(--error)'; this.style.borderColor='var(--error)'" onmouseout="this.style.color='var(--text-muted)'; this.style.borderColor='var(--border-color)'" title="Eliminar anotación">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: var(--spacing-2xl); border: 1px dashed var(--border-color); border-radius: var(--radius-md);">
                    <i class="fas fa-clipboard-list" style="font-size: 2.5rem; color: var(--text-muted); margin-bottom: var(--spacing-md); opacity: 0.6;"></i>
                    <p style="color: var(--text-color); margin: 0 0 4px 0; font-weight: 500;">Sin anotaciones registradas</p>
                    <p style="color: var(--text-muted); margin: 0; font-size: 0.875rem;">Haz clic en "Nueva Anotación" para comenzar</p>
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

    <div id="anotacionModal" class="filters-modal" onclick="closeAnotacionModal()">
        <div class="filters-modal-content" onclick="event.stopPropagation()">
            <div class="filters-modal-header">
                <h3 style="margin: 0; font-size: 1.125rem; font-weight: 600; color: var(--text-color);">
                    <i class="fas fa-clipboard-list" style="color: var(--text-muted); margin-right: var(--spacing-sm);"></i>
                    Nueva Anotación
                </h3>
                <button onclick="closeAnotacionModal()" class="filters-modal-close" aria-label="Cerrar">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="{{ route('students.anotaciones.store', $estudiante->id) }}" method="POST">
                @csrf
                <div class="filters-modal-body">
                    <div class="form-group">
                        <label class="form-label" style="font-size: 0.875rem; font-weight: 600; color: var(--text-muted); margin-bottom: var(--spacing-xs); display: block;">Tipo de Anotación</label>
                        <div style="display: flex; gap: var(--spacing-sm);">
                            <label style="flex: 1; display: flex; align-items: center; gap: var(--spacing-xs); padding: 0.625rem; border: 2px solid var(--border-color); border-radius: var(--radius-md); cursor: pointer; transition: all 0.2s; font-size: 0.875rem; font-weight: 600;" id="tipoLabel-positiva" onclick="selectTipo('positiva')">
                                <input type="radio" name="tipo" value="positiva" style="display: none;">
                                <span style="color: var(--success);">●</span> Positiva
                            </label>
                            <label style="flex: 1; display: flex; align-items: center; gap: var(--spacing-xs); padding: 0.625rem; border: 2px solid var(--border-color); border-radius: var(--radius-md); cursor: pointer; transition: all 0.2s; font-size: 0.875rem; font-weight: 600;" id="tipoLabel-negativa" onclick="selectTipo('negativa')">
                                <input type="radio" name="tipo" value="negativa" style="display: none;">
                                <span style="color: var(--error);">●</span> Negativa
                            </label>
                            <label style="flex: 1; display: flex; align-items: center; gap: var(--spacing-xs); padding: 0.625rem; border: 2px solid var(--border-color); border-radius: var(--radius-md); cursor: pointer; transition: all 0.2s; font-size: 0.875rem; font-weight: 600;" id="tipoLabel-neutra" onclick="selectTipo('neutra')">
                                <input type="radio" name="tipo" value="neutra" style="display: none;">
                                <span style="color: var(--info);">●</span> Neutra
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" style="font-size: 0.875rem; font-weight: 600; color: var(--text-muted); margin-bottom: var(--spacing-xs); display: block;">Título</label>
                        <input type="text" name="titulo" class="form-input" placeholder="Ej: Destacado rendimiento, Falta disciplinaria..." required style="border: 2px solid var(--border-color); border-radius: var(--radius-lg); font-size: 0.9375rem;" onfocus="this.style.borderColor='#84cc16'" onblur="this.style.borderColor='var(--border-color)'">
                    </div>
                    <div class="form-group">
                        <label class="form-label" style="font-size: 0.875rem; font-weight: 600; color: var(--text-muted); margin-bottom: var(--spacing-xs); display: block;">Descripción</label>
                        <textarea name="descripcion" class="form-input" rows="3" placeholder="Detalle de la anotación..." style="border: 2px solid var(--border-color); border-radius: var(--radius-lg); font-size: 0.9375rem; resize: vertical;" onfocus="this.style.borderColor='#84cc16'" onblur="this.style.borderColor='var(--border-color)'"></textarea>
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label" style="font-size: 0.875rem; font-weight: 600; color: var(--text-muted); margin-bottom: var(--spacing-xs); display: block;">Fecha</label>
                        <input type="date" name="fecha" class="form-input" required value="{{ date('Y-m-d') }}" style="border: 2px solid var(--border-color); border-radius: var(--radius-lg); font-size: 0.9375rem;" onfocus="this.style.borderColor='#84cc16'" onblur="this.style.borderColor='var(--border-color)'">
                    </div>
                </div>
                <div class="filters-modal-footer">
                    <button type="button" onclick="closeAnotacionModal()" class="btn btn-outline" style="flex: 1; border: 1px solid var(--border-color); background: transparent; color: var(--text-color);">Cancelar</button>
                    <button type="submit" style="flex: 1; background: #84cc16; color: white; border: none; border-radius: var(--radius-md); font-weight: 600; padding: 0.625rem; transition: background 0.2s; cursor: pointer;" onmouseover="this.style.background='#65a30d'" onmouseout="this.style.background='#84cc16'">Guardar Anotación</button>
                </div>
            </form>
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

        function openAnotacionModal() {
            const modal = document.getElementById('anotacionModal');
            if (modal) {
                modal.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeAnotacionModal() {
            const modal = document.getElementById('anotacionModal');
            if (modal) {
                modal.classList.remove('active');
                document.body.style.overflow = '';
            }
        }

        function selectTipo(tipo) {
            ['positiva', 'negativa', 'neutra'].forEach(t => {
                const label = document.getElementById('tipoLabel-' + t);
                if (label) {
                    label.style.borderColor = t === tipo ? '#84cc16' : 'var(--border-color)';
                    label.style.background = t === tipo ? 'rgba(132, 204, 22, 0.05)' : 'transparent';
                }
                const radio = label.querySelector('input[type=radio]');
                if (radio) radio.checked = (t === tipo);
            });
        }

        function filterAnotaciones(tipo) {
            const items = document.querySelectorAll('.anotacion-item');
            const buttons = document.querySelectorAll('.anotacion-filter');

            buttons.forEach(btn => {
                if (btn.dataset.filter === tipo) {
                    btn.style.background = 'var(--text-color)';
                    btn.style.color = 'var(--bg-card)';
                    btn.style.borderColor = 'var(--text-color)';
                } else {
                    btn.style.background = 'transparent';
                    btn.style.color = 'var(--text-color)';
                    btn.style.borderColor = 'var(--border-color)';
                }
            });

            items.forEach(item => {
                if (tipo === 'todas' || item.dataset.tipo === tipo) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeAnotacionModal();
        });
    </script>

    <style>
        @media (max-width: 768px) {
            div[style*="grid-template-columns: repeat(4, 1fr)"] { grid-template-columns: repeat(2, 1fr) !important; }
            div[style*="grid-template-columns: 1fr 1fr"] { grid-template-columns: 1fr !important; }
            .page-header { flex-wrap: nowrap !important; align-items: flex-start !important; }
            .page-header > div:last-child { flex-wrap: wrap !important; }
        }

        @media (min-width: 769px) {
            #anotacionModal.active {
                display: flex !important;
                align-items: center;
            }
            #anotacionModal .filters-modal-content {
                max-width: 540px;
                border-radius: var(--radius-xl);
            }
        }
    </style>
</x-app-layout>

