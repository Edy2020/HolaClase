<x-app-layout>
    <x-slot name="header">
        Gestión de Notas
    </x-slot>

    <link rel="stylesheet" href="{{ asset('css/shared-index.css') }}?v={{ time() }}">

    <!-- Page Header -->
    <div class="page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-lg);">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--gray-900); margin: 0;">
                Gestión de Notas
            </h2>
            <p style="color: var(--gray-500); margin: var(--spacing-xs) 0 0 0; font-size: 0.9375rem;">
                Registra y administra las notas de tus estudiantes
            </p>
        </div>
        <div class="header-actions" style="display: flex; gap: var(--spacing-md);">
            <a href="{{ route('grades.dashboard') }}" class="btn btn-outline"
                style="display: flex; align-items: center; justify-content: center; gap: var(--spacing-sm); border: 1px solid var(--gray-300); color: var(--gray-700); background: transparent; padding: 0.625rem 1.25rem; border-radius: var(--radius-md); font-weight: 600; text-decoration: none; transition: all 0.2s;"
                onmouseover="this.style.background='var(--gray-50)'; this.style.color='var(--gray-900)'"
                onmouseout="this.style.background='transparent'; this.style.color='var(--gray-700)'">
                <i class="fas fa-tachometer-alt"></i>
                <span class="btn-text">Dashboard</span>
            </a>
            <a href="{{ route('grades.create') }}" class="btn btn-outline"
                style="display: flex; align-items: center; justify-content: center; gap: var(--spacing-sm); border: 1px solid var(--gray-300); color: var(--gray-700); background: transparent; padding: 0.625rem 1.25rem; border-radius: var(--radius-md); font-weight: 600; text-decoration: none; transition: all 0.2s;"
                onmouseover="this.style.background='var(--gray-50)'; this.style.color='var(--gray-900)'"
                onmouseout="this.style.background='transparent'; this.style.color='var(--gray-700)'">
                <i class="fas fa-plus"></i>
                <span class="btn-text">Registrar Notas</span>
            </a>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="alert alert-success" style="background: #d1fae5; border: 1px solid #6ee7b7; color: #065f46; padding: var(--spacing-md) var(--spacing-lg); border-radius: var(--radius-lg); margin-bottom: var(--spacing-xl); display: flex; align-items: center; gap: var(--spacing-sm);">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger" style="background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: var(--spacing-md) var(--spacing-lg); border-radius: var(--radius-lg); margin-bottom: var(--spacing-xl);">
            <i class="fas fa-exclamation-circle"></i>
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <!-- Statistics -->
    <div class="grid grid-cols-4 mb-xl">
        <div class="stat-card">
            <div class="stat-value" style="color: #84cc16;">{{ $stats['total'] }}</div>
            <div class="stat-label">Total Notas</div>
        </div>
        <div class="stat-card">
            <div class="stat-value" style="color: {{ ($stats['promedio'] ?? 0) >= 4.0 ? 'var(--success)' : 'var(--error)' }};">
                {{ $stats['promedio'] ?? '–' }}
            </div>
            <div class="stat-label">Promedio General</div>
        </div>
        <div class="stat-card">
            <div class="stat-value" style="color: var(--success);">{{ $stats['aprobados'] }}</div>
            <div class="stat-label">Aprobados</div>
        </div>
        <div class="stat-card">
            <div class="stat-value" style="color: var(--error);">{{ $stats['reprobados'] }}</div>
            <div class="stat-label">Reprobados</div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="mb-xl filters-card">
        <form method="GET" action="{{ route('grades.index') }}" id="filterForm">
            <div class="grid grid-cols-4" style="gap: var(--spacing-md); align-items: center;">
                
                <!-- Curso Filter -->
                <div class="form-group mb-0" style="position: relative;">
                    <div style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--gray-400); font-size: 1rem; pointer-events: none; z-index: 1;">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <select name="curso_id" class="form-select" onchange="this.form.submit()"
                        style="padding-left: 40px; border: 2px solid var(--gray-200); border-radius: var(--radius-lg); transition: all 0.2s; font-size: 0.9375rem; cursor: pointer;"
                        onfocus="this.style.borderColor='#84cc16'; this.style.boxShadow='0 0 0 3px rgba(132, 204, 22, 0.1)'"
                        onblur="this.style.borderColor='var(--gray-200)'; this.style.boxShadow='none'">
                        <option value="">Todos los cursos</option>
                        @foreach($cursos as $curso)
                            <option value="{{ $curso->id }}" {{ request('curso_id') == $curso->id ? 'selected' : '' }}>
                                {{ $curso->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Asignatura Filter -->
                <div class="form-group mb-0" style="position: relative;">
                    <div style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--gray-400); font-size: 1rem; pointer-events: none; z-index: 1;">
                        <i class="fas fa-book"></i>
                    </div>
                    <select name="asignatura_id" class="form-select" onchange="this.form.submit()"
                        style="padding-left: 40px; border: 2px solid var(--gray-200); border-radius: var(--radius-lg); transition: all 0.2s; font-size: 0.9375rem; cursor: pointer;"
                        onfocus="this.style.borderColor='#84cc16'; this.style.boxShadow='0 0 0 3px rgba(132, 204, 22, 0.1)'"
                        onblur="this.style.borderColor='var(--gray-200)'; this.style.boxShadow='none'">
                        <option value="">Todas las asignaturas</option>
                        @foreach($asignaturas as $asignatura)
                            <option value="{{ $asignatura->id }}" {{ request('asignatura_id') == $asignatura->id ? 'selected' : '' }}>
                                {{ $asignatura->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Período Filter -->
                <div class="form-group mb-0" style="position: relative;">
                    <div style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--gray-400); font-size: 1rem; pointer-events: none; z-index: 1;">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <select name="periodo" class="form-select" onchange="this.form.submit()"
                        style="padding-left: 40px; border: 2px solid var(--gray-200); border-radius: var(--radius-lg); transition: all 0.2s; font-size: 0.9375rem; cursor: pointer;"
                        onfocus="this.style.borderColor='#84cc16'; this.style.boxShadow='0 0 0 3px rgba(132, 204, 22, 0.1)'"
                        onblur="this.style.borderColor='var(--gray-200)'; this.style.boxShadow='none'">
                        <option value="">Todos los períodos</option>
                        <option value="Semestre 1" {{ request('periodo') == 'Semestre 1' ? 'selected' : '' }}>Semestre 1</option>
                        <option value="Semestre 2" {{ request('periodo') == 'Semestre 2' ? 'selected' : '' }}>Semestre 2</option>
                        <option value="Anual" {{ request('periodo') == 'Anual' ? 'selected' : '' }}>Anual</option>
                    </select>
                </div>
                
                <!-- Tipo Evaluación Filter -->
                <div class="form-group mb-0" style="position: relative;">
                    <div style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--gray-400); font-size: 1rem; pointer-events: none; z-index: 1;">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <select name="tipo_evaluacion" class="form-select" onchange="this.form.submit()"
                        style="padding-left: 40px; border: 2px solid var(--gray-200); border-radius: var(--radius-lg); transition: all 0.2s; font-size: 0.9375rem; cursor: pointer;"
                        onfocus="this.style.borderColor='#84cc16'; this.style.boxShadow='0 0 0 3px rgba(132, 204, 22, 0.1)'"
                        onblur="this.style.borderColor='var(--gray-200)'; this.style.boxShadow='none'">
                        <option value="">Todos los tipos</option>
                        @foreach(['Prueba','Trabajo','Examen','Taller','Proyecto','Participación','Control'] as $tipo)
                            <option value="{{ $tipo }}" {{ request('tipo_evaluacion') == $tipo ? 'selected' : '' }}>{{ $tipo }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            @if(request()->anyFilled(['curso_id','asignatura_id','periodo','tipo_evaluacion','estudiante_id']))
                <div style="margin-top: var(--spacing-sm); display: flex; justify-content: flex-end;">
                    <a href="{{ route('grades.index') }}" class="btn btn-sm btn-outline"
                        style="background: var(--gray-100); border: 1px solid var(--gray-300); color: var(--gray-600); cursor: pointer; transition: all 0.2s;"
                        onmouseover="this.style.background='var(--gray-200)'; this.style.borderColor='var(--gray-400)'"
                        onmouseout="this.style.background='var(--gray-100)'; this.style.borderColor='var(--gray-300)'">
                        <i class="fas fa-times"></i> Limpiar filtros
                    </a>
                </div>
            @endif
        </form>
    </div>

    <!-- Grades Table -->
    <div class="card">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h3 class="card-title"><i class="fas fa-list"></i> Registro de Notas
                <span style="font-size: 0.85rem; font-weight: 400; color: var(--gray-500); margin-left: 8px;">
                    ({{ $notas->total() }} registros)
                </span>
            </h3>
            <div style="display: flex; gap: var(--spacing-sm);">
                <a href="{{ route('grades.export.excel', request()->query()) }}" class="btn btn-sm btn-outline">
                    <i class="fas fa-file-excel"></i> Exportar CSV
                </a>
                <a href="{{ route('grades.export.pdf', request()->query()) }}" class="btn btn-sm btn-outline" target="_blank">
                    <i class="fas fa-file-pdf"></i> Exportar PDF
                </a>
            </div>
        </div>
        <div class="card-body" style="padding: 0;">
            @if($notas->count() > 0)
                <div style="overflow-x: auto;">
                    <table class="table" style="margin: 0;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Estudiante</th>
                                <th>Curso</th>
                                <th>Asignatura</th>
                                <th>Tipo</th>
                                <th>Período</th>
                                <th>Fecha</th>
                                <th style="text-align: center;">Nota</th>
                                <th style="text-align: center;">Ponderación</th>
                                <th style="text-align: center;">Estado</th>
                                <th style="text-align: center;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($notas as $nota)
                                <tr class="nota-item">
                                    <td style="font-weight: 600; color: var(--gray-500); font-size: 0.8rem;">#{{ $nota->id }}</td>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: var(--spacing-sm);">
                                            <div style="width: 34px; height: 34px; border-radius: 50%; background: #84cc16; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 0.75rem; flex-shrink: 0;">
                                                {{ strtoupper(substr($nota->estudiante->nombre ?? '?', 0, 1) . substr($nota->estudiante->apellido ?? '?', 0, 1)) }}
                                            </div>
                                            <div>
                                                <div style="font-weight: 600; color: var(--gray-900); font-size: 0.875rem;">
                                                    {{ $nota->estudiante->nombre ?? '–' }} {{ $nota->estudiante->apellido ?? '' }}
                                                </div>
                                                <div style="font-size: 0.75rem; color: var(--gray-500);">
                                                    {{ $nota->estudiante->rut ?? '' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="font-size: 0.875rem;">{{ $nota->curso->nombre ?? '–' }}</td>
                                    <td style="font-size: 0.875rem;">{{ $nota->asignatura->nombre ?? '–' }}</td>
                                    <td>
                                        <span style="background: var(--gray-100); color: var(--gray-700); padding: 2px 8px; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">
                                            {{ $nota->tipo_evaluacion }}
                                        </span>
                                    </td>
                                    <td style="font-size: 0.875rem; color: var(--gray-600);">{{ $nota->periodo }}</td>
                                    <td style="font-size: 0.875rem; color: var(--gray-600);">
                                        {{ $nota->fecha ? $nota->fecha->format('d/m/Y') : '–' }}
                                    </td>
                                    <td style="text-align: center;">
                                        @php
                                            $n = (float) $nota->nota;
                                            $color = $n >= 6.0 ? 'var(--success)' : ($n >= 5.0 ? '#0ea5e9' : ($n >= 4.0 ? 'var(--warning)' : 'var(--error)'));
                                        @endphp
                                        <span style="font-size: 1.2rem; font-weight: 800; color: {{ $color }};">
                                            {{ number_format($nota->nota, 1) }}
                                        </span>
                                    </td>
                                    <td style="text-align: center; font-size: 0.875rem; color: var(--gray-600);">
                                        {{ round($nota->ponderacion * 100) }}%
                                    </td>
                                    <td style="text-align: center;">
                                        @if($nota->nota >= 4.0)
                                            <span class="badge badge-success">Aprobado</span>
                                        @else
                                            <span class="badge badge-danger">Reprobado</span>
                                        @endif
                                    </td>
                                    <td style="text-align: center;">
                                        <div style="display: flex; gap: 4px; justify-content: center;">
                                            <a href="{{ route('grades.edit', $nota->id) }}"
                                               class="btn btn-sm btn-outline"
                                               style="padding: 4px 10px;"
                                               title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('grades.destroy', $nota->id) }}" method="POST"
                                                  onsubmit="return confirm('¿Eliminar esta nota?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline"
                                                        style="padding: 4px 10px; border-color: var(--error); color: var(--error);"
                                                        title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <div style="padding: var(--spacing-lg); border-top: 1px solid var(--gray-100);">
                    {{ $notas->withQueryString()->links() }}
                </div>
            @else
                <div style="text-align: center; padding: var(--spacing-3xl);">
                    <i class="fas fa-clipboard-list" style="font-size: 3rem; color: var(--gray-200); margin-bottom: var(--spacing-md);"></i>
                    <p style="color: var(--gray-500); font-size: 1.125rem; margin-bottom: var(--spacing-sm);">
                        No hay notas registradas
                        @if(request()->anyFilled(['curso_id','asignatura_id','periodo','tipo_evaluacion']))
                            con los filtros seleccionados
                        @endif
                    </p>
                    <a href="{{ route('grades.create') }}" class="btn btn-primary" style="margin-top: var(--spacing-md); color: white;">
                        <i class="fas fa-plus"></i> Registrar primera nota
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
