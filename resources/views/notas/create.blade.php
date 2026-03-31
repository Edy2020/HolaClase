<x-app-layout>
    <x-slot name="header">
        Registrar Notas
    </x-slot>

    <!-- Page Header -->
    <div class="page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-lg);">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--text-color); margin: 0;">
                <i class="fas fa-clipboard-list" style="color: var(--text-muted); margin-right: 8px;"></i> Registrar Notas
            </h2>
            <p style="color: var(--text-muted); margin: var(--spacing-xs) 0 0 0; font-size: 0.9375rem;">
                Selecciona el curso y la asignatura para registrar las notas de los estudiantes.
            </p>
        </div>
        <div class="header-actions">
            <a href="{{ route('grades.index') }}" class="btn btn-outline"
                style="display: flex; align-items: center; justify-content: center; gap: var(--spacing-sm); border: 1px solid var(--border-color); color: var(--text-color); background: transparent; padding: 0.625rem 1.25rem; border-radius: var(--radius-md); font-weight: 600; text-decoration: none; transition: all 0.2s;"
                onmouseover="this.style.background='var(--bg-card)'; this.style.color='var(--text-color)'"
                onmouseout="this.style.background='transparent'; this.style.color='var(--text-color)'">
                <i class="fas fa-arrow-left"></i>
                <span class="btn-text">Volver a Notas</span>
            </a>
        </div>
    </div>

    <!-- Filters Container -->
    <div class="mb-xl" style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: var(--spacing-lg);">
        <h3 style="font-size: 1.1rem; font-weight: 700; color: var(--text-color); margin-top: 0; margin-bottom: var(--spacing-md); border-bottom: 1px solid var(--border-color); padding-bottom: var(--spacing-sm);">
            <i class="fas fa-filter" style="color: var(--text-muted); margin-right: 6px;"></i> Selección de Formulario
        </h3>
        <form method="GET" action="{{ route('grades.create') }}" id="filterForm">
            <div class="grid grid-cols-1 md:grid-cols-2" style="gap: var(--spacing-lg);">
                <div class="form-group mb-0" style="position: relative;">
                    <label class="form-label" style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">CURSO *</label>
                    <div style="position: absolute; left: 12px; bottom: 10px; color: var(--text-muted); font-size: 1rem; pointer-events: none; z-index: 1;">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <select name="curso_id" id="cursoSelect" class="form-select" required onchange="this.form.submit()"
                        style="padding-left: 40px; border: 2px solid var(--border-color); border-radius: var(--radius-lg); transition: all 0.2s; font-size: 0.9375rem; cursor: pointer; background-color: var(--bg-card); color: var(--text-color);"
                        onfocus="this.style.borderColor='#84cc16'; this.style.boxShadow='0 0 0 3px rgba(132, 204, 22, 0.1)'"
                        onblur="this.style.borderColor='var(--border-color)'; this.style.boxShadow='none'">
                        <option value="">Seleccione un curso</option>
                        @foreach($cursos as $curso)
                            <option value="{{ $curso->id }}" {{ $selectedCurso && $selectedCurso->id == $curso->id ? 'selected' : '' }}>
                                {{ $curso->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-0" style="position: relative;">
                    <label class="form-label" style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">ASIGNATURA *</label>
                    <div style="position: absolute; left: 12px; bottom: 10px; color: var(--text-muted); font-size: 1rem; pointer-events: none; z-index: 1;">
                        <i class="fas fa-book"></i>
                    </div>
                    <select name="asignatura_id" id="asignaturaSelect" class="form-select" {{ !$selectedCurso ? 'disabled' : '' }} required onchange="this.form.submit()"
                        style="padding-left: 40px; border: 2px solid var(--border-color); border-radius: var(--radius-lg); transition: all 0.2s; font-size: 0.9375rem; cursor: pointer; background-color: var(--bg-card); color: var(--text-color);"
                        onfocus="this.style.borderColor='#84cc16'; this.style.boxShadow='0 0 0 3px rgba(132, 204, 22, 0.1)'"
                        onblur="this.style.borderColor='var(--border-color)'; this.style.boxShadow='none'">
                        <option value="">Seleccione una asignatura</option>
                        @if($selectedCurso)
                            @foreach($selectedCurso->asignaturas as $asignatura)
                                <option value="{{ $asignatura->id }}" {{ $selectedAsignatura && $selectedAsignatura->id == $asignatura->id ? 'selected' : '' }}>
                                    {{ $asignatura->nombre }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </form>
    </div>

    @if($selectedCurso && $selectedAsignatura && $estudiantes->count() > 0)
        <!-- Grades Entry Form -->
        <form action="{{ route('grades.store') }}" method="POST" id="gradesForm">
            @csrf
            
            <input type="hidden" name="curso_id" value="{{ $selectedCurso->id }}">
            <input type="hidden" name="asignatura_id" value="{{ $selectedAsignatura->id }}">

            <!-- Evaluation Details -->
            <div class="mb-xl" style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: var(--spacing-lg);">
                <h3 style="font-size: 1.1rem; font-weight: 700; color: var(--text-color); margin-top: 0; margin-bottom: var(--spacing-md); border-bottom: 1px solid var(--border-color); padding-bottom: var(--spacing-sm);">
                    <i class="fas fa-info-circle" style="color: var(--text-muted); margin-right: 6px;"></i> Detalles de la Evaluación
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-4" style="gap: var(--spacing-lg);">
                    <div class="form-group mb-0" style="position: relative;">
                        <label class="form-label" style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">TIPO EV. *</label>
                        <div style="position: absolute; left: 12px; bottom: 10px; color: var(--text-muted); font-size: 1rem; pointer-events: none; z-index: 1;">
                            <i class="fas fa-clipboard-check"></i>
                        </div>
                        <select name="tipo_evaluacion" class="form-select" required
                            style="padding-left: 40px; border: 2px solid var(--border-color); border-radius: var(--radius-lg); transition: all 0.2s; font-size: 0.9375rem; cursor: pointer; background-color: var(--bg-card); color: var(--text-color);"
                            onfocus="this.style.borderColor='#84cc16'; this.style.boxShadow='0 0 0 3px rgba(132, 204, 22, 0.1)'"
                            onblur="this.style.borderColor='var(--border-color)'; this.style.boxShadow='none'">
                            <option value="">Seleccione tipo</option>
                            @foreach($tiposEvaluacion as $tipo)
                                <option value="{{ $tipo }}">{{ $tipo }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-0" style="position: relative;">
                        <label class="form-label" style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">PERÍODO *</label>
                        <div style="position: absolute; left: 12px; bottom: 10px; color: var(--text-muted); font-size: 1rem; pointer-events: none; z-index: 1;">
                            <i class="fas fa-clock"></i>
                        </div>
                        <select name="periodo" class="form-select" required
                            style="padding-left: 40px; border: 2px solid var(--border-color); border-radius: var(--radius-lg); transition: all 0.2s; font-size: 0.9375rem; cursor: pointer; background-color: var(--bg-card); color: var(--text-color);"
                            onfocus="this.style.borderColor='#84cc16'; this.style.boxShadow='0 0 0 3px rgba(132, 204, 22, 0.1)'"
                            onblur="this.style.borderColor='var(--border-color)'; this.style.boxShadow='none'">
                            <option value="">Seleccione período</option>
                            @foreach($periodos as $periodo)
                                <option value="{{ $periodo }}">{{ $periodo }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-0" style="position: relative;">
                        <label class="form-label" style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">FECHA *</label>
                        <div style="position: absolute; left: 12px; bottom: 10px; color: var(--text-muted); font-size: 1rem; pointer-events: none; z-index: 1;">
                            <i class="fas fa-calendar"></i>
                        </div>
                        <input type="date" name="fecha" class="form-input" value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}" required
                            style="padding-left: 40px; border: 2px solid var(--border-color); border-radius: var(--radius-lg); transition: all 0.2s; font-size: 0.9375rem; background-color: var(--bg-card); color: var(--text-color);"
                            onfocus="this.style.borderColor='#84cc16'; this.style.boxShadow='0 0 0 3px rgba(132, 204, 22, 0.1)'"
                            onblur="this.style.borderColor='var(--border-color)'; this.style.boxShadow='none'">
                    </div>

                    <div class="form-group mb-0" style="position: relative;">
                        <label class="form-label" style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">PONDERACIÓN *</label>
                        <div style="position: absolute; left: 12px; bottom: 10px; color: var(--text-muted); font-size: 1rem; pointer-events: none; z-index: 1;">
                            <i class="fas fa-percent"></i>
                        </div>
                        <input type="number" name="ponderacion" class="form-input" step="1" min="1" max="100" value="30" required
                            style="padding-left: 40px; border: 2px solid var(--border-color); border-radius: var(--radius-lg); transition: all 0.2s; font-size: 0.9375rem; background-color: var(--bg-card); color: var(--text-color);"
                            onfocus="this.style.borderColor='#84cc16'; this.style.boxShadow='0 0 0 3px rgba(132, 204, 22, 0.1)'"
                            onblur="this.style.borderColor='var(--border-color)'; this.style.boxShadow='none'">
                    </div>
                </div>
            </div>

            <!-- Students Grades Table -->
            <div class="card" style="background: var(--bg-card); border: 1px solid var(--border-color);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-lg);">
                    <h3 style="font-size: 1.125rem; font-weight: 700; color: var(--text-color); margin: 0;">
                        <i class="fas fa-users"></i> Notas de Estudiantes ({{ $estudiantes->count() }})
                    </h3>
                    <div style="display: flex; gap: var(--spacing-sm);">
                        <button type="button" onclick="fillAllGrades()" class="btn btn-sm btn-outline">
                            <i class="fas fa-fill"></i> Rellenar Todas
                        </button>
                        <button type="button" onclick="clearAllGrades()" class="btn btn-sm btn-outline">
                            <i class="fas fa-eraser"></i> Limpiar Todas
                        </button>
                    </div>
                </div>

                <div style="overflow-x: auto;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th>RUT</th>
                                <th>Nombre Completo</th>
                                <th style="width: 120px;">Nota (1.0 - 7.0) *</th>
                                <th style="width: 250px;">Observaciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($estudiantes as $index => $estudiante)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $estudiante->rut }}</td>
                                    <td>
                                        <strong>{{ $estudiante->nombre }} {{ $estudiante->apellido }}</strong>
                                    </td>
                                    <td>
                                        <input type="hidden" name="notas[{{ $index }}][estudiante_id]" value="{{ $estudiante->id }}">
                                        <input type="number" 
                                               name="notas[{{ $index }}][nota]" 
                                               class="form-input grade-input" 
                                               style="width: 100%;" 
                                               step="0.1" 
                                               min="1.0" 
                                               max="7.0" 
                                               placeholder="1.0 - 7.0"
                                               oninput="validateGrade(this)">
                                    </td>
                                    <td>
                                        <input type="text" 
                                               name="notas[{{ $index }}][observaciones]" 
                                               class="form-input" 
                                               style="width: 100%;" 
                                               placeholder="Opcional"
                                               maxlength="500">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div style="margin-top: var(--spacing-lg); padding-top: var(--spacing-lg); border-top: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center;">
                    <a href="{{ route('grades.index') }}" class="btn btn-outline" style="color: var(--text-color); border-color: var(--border-color);">
                        <i class="fas fa-arrow-left"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary" style="color: white;">
                        <i class="fas fa-save"></i> Guardar Notas
                    </button>
                </div>
            </div>
        </form>
    @elseif($selectedCurso && $selectedAsignatura && $estudiantes->count() == 0)
        <div style="background: var(--bg-card); border: 1px dashed var(--border-color); border-radius: var(--radius-lg);">
            <div style="text-align: center; padding: var(--spacing-2xl);">
                <i class="fas fa-users-slash" style="font-size: 3rem; color: var(--text-muted); margin-bottom: var(--spacing-md); opacity: 0.8;"></i>
                <p style="color: var(--text-color); margin: 0; font-weight: 500;">No hay estudiantes inscritos en este curso para esta asignatura</p>
                <p style="color: var(--text-muted); font-size: 0.875rem; margin-top: var(--spacing-sm);">
                    Agrega estudiantes al curso <strong>{{ $selectedCurso->nombre }}</strong> para poder registrar notas.
                </p>
                <a href="{{ route('courses.show', $selectedCurso->id) }}" class="btn btn-primary" style="margin-top: var(--spacing-md); color: white;">
                    <i class="fas fa-user-plus"></i> Ir al Curso
                </a>
            </div>
        </div>
    @else
        <div style="background: var(--bg-card); border: 1px dashed var(--border-color); border-radius: var(--radius-lg);">
            <div style="text-align: center; padding: var(--spacing-2xl);">
                <i class="fas fa-hand-pointer" style="font-size: 3rem; color: var(--text-muted); margin-bottom: var(--spacing-md); opacity: 0.8;"></i>
                <p style="color: var(--text-color); margin: 0; font-weight: 500;">Selecciona un curso y una asignatura para comenzar a registrar notas</p>
            </div>
        </div>
    @endif

    <style>
        .grade-input:focus {
            border-color: #84cc16;
            box-shadow: 0 0 0 3px rgba(132, 204, 22, 0.1);
        }

        .grade-input.invalid {
            border-color: var(--error);
        }

        .grade-input.valid {
            border-color: var(--success);
        }

        @media (max-width: 768px) {
            .grid-cols-2 {
                grid-template-columns: 1fr !important;
            }

            table {
                font-size: 0.875rem;
            }

            th, td {
                padding: var(--spacing-sm) !important;
            }
        }
    </style>

    <script>
        function validateGrade(input) {
            const value = parseFloat(input.value);
            
            if (input.value === '') {
                input.classList.remove('valid', 'invalid');
                return;
            }
            
            if (value < 1.0 || value > 7.0 || isNaN(value)) {
                input.classList.add('invalid');
                input.classList.remove('valid');
            } else {
                input.classList.add('valid');
                input.classList.remove('invalid');
            }
        }

        function fillAllGrades() {
            const grade = prompt('Ingrese la nota para todos los estudiantes (1.0 - 7.0):');
            
            if (grade === null) return;
            
            const gradeValue = parseFloat(grade);
            
            if (gradeValue < 1.0 || gradeValue > 7.0 || isNaN(gradeValue)) {
                alert('Por favor ingrese una nota válida entre 1.0 y 7.0');
                return;
            }
            
            document.querySelectorAll('.grade-input').forEach(input => {
                input.value = gradeValue.toFixed(1);
                validateGrade(input);
            });
        }

        function clearAllGrades() {
            if (!confirm('¿Está seguro de que desea limpiar todas las notas?')) {
                return;
            }
            
            document.querySelectorAll('.grade-input').forEach(input => {
                input.value = '';
                input.classList.remove('valid', 'invalid');
            });
        }

        // Form validation before submit
        document.getElementById('gradesForm')?.addEventListener('submit', function(e) {
            const gradeInputs = document.querySelectorAll('.grade-input');
            let hasGrades = false;
            let hasInvalidGrades = false;
            
            gradeInputs.forEach(input => {
                if (input.value !== '') {
                    hasGrades = true;
                    const value = parseFloat(input.value);
                    if (value < 1.0 || value > 7.0 || isNaN(value)) {
                        hasInvalidGrades = true;
                    }
                }
            });
            
            if (!hasGrades) {
                e.preventDefault();
                alert('Por favor ingrese al menos una nota antes de guardar.');
                return;
            }
            
            if (hasInvalidGrades) {
                e.preventDefault();
                alert('Hay notas inválidas. Por favor corrija las notas marcadas en rojo (deben estar entre 1.0 y 7.0).');
                return;
            }
        });
    </script>
</x-app-layout>
