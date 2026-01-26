<x-app-layout>
    <x-slot name="header">
        Registrar Notas
    </x-slot>

    <!-- Header Section -->
    <div class="card" style="margin-bottom: var(--spacing-xl);">
        <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--gray-900); margin-bottom: var(--spacing-sm);">
            <i class="fas fa-clipboard-list"></i> Registrar Notas
        </h2>
        <p style="color: var(--gray-600);">
            Selecciona el curso y la asignatura para registrar las notas de los estudiantes.
        </p>
    </div>

    <!-- Course and Subject Selection Form -->
    <div class="card" style="margin-bottom: var(--spacing-xl);">
        <form method="GET" action="{{ route('grades.create') }}" id="filterForm">
            <div class="grid grid-cols-2" style="gap: var(--spacing-md); margin-bottom: var(--spacing-lg);">
                <div>
                    <label style="display: block; font-weight: 600; color: var(--gray-700); margin-bottom: var(--spacing-sm);">
                        <i class="fas fa-chalkboard"></i> Curso *
                    </label>
                    <select name="curso_id" id="cursoSelect" class="form-input" style="width: 100%;" required onchange="this.form.submit()">
                        <option value="">Seleccione un curso</option>
                        @foreach($cursos as $curso)
                            <option value="{{ $curso->id }}" {{ $selectedCurso && $selectedCurso->id == $curso->id ? 'selected' : '' }}>
                                {{ $curso->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label style="display: block; font-weight: 600; color: var(--gray-700); margin-bottom: var(--spacing-sm);">
                        <i class="fas fa-book"></i> Asignatura *
                    </label>
                    <select name="asignatura_id" id="asignaturaSelect" class="form-input" style="width: 100%;" 
                            {{ !$selectedCurso ? 'disabled' : '' }} required onchange="this.form.submit()">
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
            <div class="card" style="margin-bottom: var(--spacing-xl);">
                <h3 style="font-size: 1.125rem; font-weight: 700; color: var(--gray-900); margin-bottom: var(--spacing-lg);">
                    <i class="fas fa-info-circle"></i> Detalles de la Evaluación
                </h3>

                <div class="grid grid-cols-2" style="gap: var(--spacing-md);">
                    <div>
                        <label style="display: block; font-weight: 600; color: var(--gray-700); margin-bottom: var(--spacing-sm);">
                            Tipo de Evaluación *
                        </label>
                        <select name="tipo_evaluacion" class="form-input" style="width: 100%;" required>
                            <option value="">Seleccione tipo</option>
                            @foreach($tiposEvaluacion as $tipo)
                                <option value="{{ $tipo }}">{{ $tipo }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label style="display: block; font-weight: 600; color: var(--gray-700); margin-bottom: var(--spacing-sm);">
                            Período *
                        </label>
                        <select name="periodo" class="form-input" style="width: 100%;" required>
                            <option value="">Seleccione período</option>
                            @foreach($periodos as $periodo)
                                <option value="{{ $periodo }}">{{ $periodo }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label style="display: block; font-weight: 600; color: var(--gray-700); margin-bottom: var(--spacing-sm);">
                            Fecha *
                        </label>
                        <input type="date" name="fecha" class="form-input" style="width: 100%;" 
                               value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}" required>
                    </div>

                    <div>
                        <label style="display: block; font-weight: 600; color: var(--gray-700); margin-bottom: var(--spacing-sm);">
                            Ponderación (0.01 - 1.00) *
                        </label>
                        <input type="number" name="ponderacion" class="form-input" style="width: 100%;" 
                               step="0.01" min="0.01" max="1" value="0.3" required>
                        <small style="color: var(--gray-500); font-size: 0.75rem;">
                            Ejemplo: 0.3 = 30%, 0.5 = 50%, 1.0 = 100%
                        </small>
                    </div>
                </div>
            </div>

            <!-- Students Grades Table -->
            <div class="card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-lg);">
                    <h3 style="font-size: 1.125rem; font-weight: 700; color: var(--gray-900); margin: 0;">
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

                <div style="margin-top: var(--spacing-lg); padding-top: var(--spacing-lg); border-top: 1px solid var(--gray-200); display: flex; justify-content: space-between; align-items: center;">
                    <a href="{{ route('grades.index') }}" class="btn btn-outline">
                        <i class="fas fa-arrow-left"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary" style="color: white;">
                        <i class="fas fa-save"></i> Guardar Notas
                    </button>
                </div>
            </div>
        </form>
    @elseif($selectedCurso && $selectedAsignatura && $estudiantes->count() == 0)
        <div class="card">
            <div style="text-align: center; padding: var(--spacing-2xl);">
                <i class="fas fa-users-slash" style="font-size: 3rem; color: var(--gray-300); margin-bottom: var(--spacing-md);"></i>
                <p style="color: var(--gray-600); font-size: 1.125rem; margin-bottom: var(--spacing-sm);">
                    No hay estudiantes inscritos en este curso
                </p>
                <p style="color: var(--gray-500); font-size: 0.875rem;">
                    Agrega estudiantes al curso <strong>{{ $selectedCurso->nombre }}</strong> para poder registrar notas.
                </p>
                <a href="{{ route('courses.show', $selectedCurso->id) }}" class="btn btn-primary" style="margin-top: var(--spacing-md); color: white;">
                    <i class="fas fa-user-plus"></i> Ir al Curso
                </a>
            </div>
        </div>
    @else
        <div class="card">
            <div style="text-align: center; padding: var(--spacing-2xl);">
                <i class="fas fa-hand-pointer" style="font-size: 3rem; color: var(--gray-300); margin-bottom: var(--spacing-md);"></i>
                <p style="color: var(--gray-600); font-size: 1.125rem;">
                    Selecciona un curso y una asignatura para comenzar
                </p>
            </div>
        </div>
    @endif

    <style>
        .grade-input:focus {
            border-color: var(--theme-color);
            box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
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
