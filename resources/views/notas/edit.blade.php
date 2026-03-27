<x-app-layout>
    <x-slot name="header">
        Editar Nota
    </x-slot>

    <!-- Header -->
    <div style="display: flex; align-items: center; gap: var(--spacing-md); margin-bottom: var(--spacing-xl);">
        <a href="{{ route('grades.index') }}" class="btn btn-ghost">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--gray-900); margin: 0;">
                <i class="fas fa-edit"></i> Editar Nota
            </h2>
            <p style="color: var(--gray-500); margin: 0; font-size: 0.875rem;">
                {{ $nota->estudiante->nombre ?? '' }} {{ $nota->estudiante->apellido ?? '' }} —
                {{ $nota->asignatura->nombre ?? '' }}
            </p>
        </div>
    </div>

    <!-- Context Info -->
    <div class="card mb-xl" style="background: var(--gray-50); border: 1px solid var(--gray-200);">
        <div class="card-body">
            <div class="grid grid-cols-3">
                <div>
                    <div style="font-size: 0.75rem; color: var(--gray-500); font-weight: 600; text-transform: uppercase; margin-bottom: 4px;">Estudiante</div>
                    <div style="font-weight: 700; color: var(--gray-900);">
                        {{ $nota->estudiante->nombre ?? '–' }} {{ $nota->estudiante->apellido ?? '' }}
                    </div>
                    <div style="font-size: 0.8rem; color: var(--gray-500);">{{ $nota->estudiante->rut ?? '' }}</div>
                </div>
                <div>
                    <div style="font-size: 0.75rem; color: var(--gray-500); font-weight: 600; text-transform: uppercase; margin-bottom: 4px;">Curso</div>
                    <div style="font-weight: 700; color: var(--gray-900);">{{ $nota->curso->nombre ?? '–' }}</div>
                </div>
                <div>
                    <div style="font-size: 0.75rem; color: var(--gray-500); font-weight: 600; text-transform: uppercase; margin-bottom: 4px;">Asignatura</div>
                    <div style="font-weight: 700; color: var(--gray-900);">{{ $nota->asignatura->nombre ?? '–' }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Modificar Nota</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('grades.update', $nota->id) }}" method="POST">
                @csrf
                @method('PUT')

                @if($errors->any())
                    <div style="background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: var(--spacing-md); border-radius: var(--radius-lg); margin-bottom: var(--spacing-lg);">
                        @foreach($errors->all() as $error)
                            <div><i class="fas fa-exclamation-circle"></i> {{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <div class="grid grid-cols-2" style="gap: var(--spacing-lg);">
                    <!-- Nota -->
                    <div class="form-group">
                        <label class="form-label">Nota * <span style="color: var(--gray-500); font-weight: 400;">(1.0 – 7.0)</span></label>
                        <input type="number"
                               name="nota"
                               class="form-input"
                               step="0.1"
                               min="1.0"
                               max="7.0"
                               value="{{ old('nota', number_format($nota->nota, 1)) }}"
                               required
                               oninput="updatePreview(this.value)">
                        <!-- Live preview -->
                        <div id="notaPreview" style="margin-top: var(--spacing-sm); padding: var(--spacing-sm) var(--spacing-md); background: var(--gray-50); border-radius: var(--radius-md); display: flex; align-items: center; gap: var(--spacing-sm);">
                            <span id="notaColor" style="font-size: 1.5rem; font-weight: 800;">{{ number_format($nota->nota, 1) }}</span>
                            <span id="notaEstado" class="badge">—</span>
                        </div>
                    </div>

                    <!-- Tipo Evaluacion -->
                    <div class="form-group">
                        <label class="form-label">Tipo de Evaluación *</label>
                        <select name="tipo_evaluacion" class="form-select" required>
                            @foreach($tiposEvaluacion as $tipo)
                                <option value="{{ $tipo }}" {{ old('tipo_evaluacion', $nota->tipo_evaluacion) == $tipo ? 'selected' : '' }}>
                                    {{ $tipo }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Período -->
                    <div class="form-group">
                        <label class="form-label">Período *</label>
                        <select name="periodo" class="form-select" required>
                            @foreach($periodos as $periodo)
                                <option value="{{ $periodo }}" {{ old('periodo', $nota->periodo) == $periodo ? 'selected' : '' }}>
                                    {{ $periodo }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Fecha -->
                    <div class="form-group">
                        <label class="form-label">Fecha *</label>
                        <input type="date"
                               name="fecha"
                               class="form-input"
                               value="{{ old('fecha', $nota->fecha ? $nota->fecha->format('Y-m-d') : '') }}"
                               max="{{ date('Y-m-d') }}"
                               required>
                    </div>

                    <!-- Ponderación -->
                    <div class="form-group">
                        <label class="form-label">Ponderación * <span style="color: var(--gray-500); font-weight: 400;">(0.01 – 1.00, ej: 0.30 = 30%)</span></label>
                        <input type="number"
                               name="ponderacion"
                               class="form-input"
                               step="0.01"
                               min="0.01"
                               max="1"
                               value="{{ old('ponderacion', number_format($nota->ponderacion, 2)) }}"
                               required>
                        <small style="color: var(--gray-500); font-size: 0.75rem;">Valor decimal: 0.30 equivale al 30%</small>
                    </div>

                    <!-- Observaciones -->
                    <div class="form-group" style="grid-column: 1 / -1;">
                        <label class="form-label">Observaciones <span style="color: var(--gray-500); font-weight: 400;">(opcional)</span></label>
                        <textarea name="observaciones" class="form-input" rows="3"
                                  style="resize: vertical;" maxlength="500"
                                  placeholder="Notas adicionales sobre esta evaluación...">{{ old('observaciones', $nota->observaciones) }}</textarea>
                    </div>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: var(--spacing-xl); padding-top: var(--spacing-lg); border-top: 1px solid var(--gray-100);">
                    <a href="{{ route('grades.index') }}" class="btn btn-outline">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary" style="color: white;">
                        <i class="fas fa-save"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function updatePreview(value) {
            const v = parseFloat(value);
            const colorEl = document.getElementById('notaColor');
            const estadoEl = document.getElementById('notaEstado');

            if (isNaN(v)) {
                colorEl.textContent = '–';
                colorEl.style.color = 'var(--gray-400)';
                estadoEl.textContent = '–';
                estadoEl.className = 'badge';
                return;
            }

            colorEl.textContent = v.toFixed(1);

            if (v >= 6.0) {
                colorEl.style.color = 'var(--success)';
                estadoEl.textContent = 'Excelente';
                estadoEl.className = 'badge badge-success';
            } else if (v >= 5.0) {
                colorEl.style.color = '#0ea5e9';
                estadoEl.textContent = 'Bueno';
                estadoEl.className = 'badge';
                estadoEl.style.background = '#e0f2fe';
                estadoEl.style.color = '#0369a1';
            } else if (v >= 4.0) {
                colorEl.style.color = 'var(--warning)';
                estadoEl.textContent = 'Aprobado';
                estadoEl.className = 'badge badge-warning';
            } else {
                colorEl.style.color = 'var(--error)';
                estadoEl.textContent = 'Reprobado';
                estadoEl.className = 'badge badge-danger';
            }
        }

        // Initialize preview on load
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.querySelector('input[name="nota"]');
            if (input) updatePreview(input.value);
        });
    </script>
</x-app-layout>
