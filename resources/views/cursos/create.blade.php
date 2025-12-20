<x-app-layout>
    <x-slot name="header">
        Crear Nuevo Curso
    </x-slot>

    <!-- Hero Header -->
    <div
        style="background: var(--theme-dark); color: white; padding: var(--spacing-2xl); border-radius: var(--radius-xl); margin-bottom: var(--spacing-2xl); box-shadow: var(--shadow-lg);">
        <div>
            <h2 style="color: white; font-size: 1.75rem; font-weight: 700; margin-bottom: var(--spacing-sm);">
                <i class="fas fa-plus-circle"></i> Crear Nuevo Curso
            </h2>
            <p style="font-size: 1rem; opacity: 0.95; margin: 0;">
                Complete los datos básicos del curso. Los detalles adicionales se agregarán posteriormente.
            </p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="card">
        <div class="card-body">
            <form action="{{ route('courses.store') }}" method="POST" id="cursoForm">
                @csrf

                <!-- Nivel -->
                <div class="form-group">
                    <label for="nivel" class="form-label">
                        <i class="fas fa-layer-group"></i> Nivel de Enseñanza *
                    </label>
                    <select name="nivel" id="nivel" class="form-select" required>
                        <option value="">Seleccione un nivel...</option>
                        <option value="Pre-Kinder">Pre-Kinder</option>
                        <option value="Kinder">Kinder</option>
                        <option value="Basica">Educación Básica</option>
                        <option value="Media">Educación Media</option>
                    </select>
                    @error('nivel')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Grado (conditional) -->
                <div class="form-group" id="gradoGroup" style="display: none;">
                    <label for="grado" class="form-label">
                        <i class="fas fa-sort-numeric-up"></i> Grado *
                    </label>
                    <select name="grado" id="grado" class="form-select">
                        <option value="">Seleccione un grado...</option>
                    </select>
                    @error('grado')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Sección -->
                <div class="form-group">
                    <label for="letra" class="form-label">
                        <i class="fas fa-font"></i> Sección *
                    </label>
                    <select name="letra" id="letra" class="form-select" required>
                        <option value="">Seleccione una sección...</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                        <option value="E">E</option>
                        <option value="F">F</option>
                    </select>
                    @error('letra')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Preview del nombre del curso -->
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-eye"></i> Vista Previa del Curso
                    </label>
                    <div
                        style="padding: var(--spacing-lg); background: var(--bg-secondary); border-radius: var(--radius-md); border-left: 4px solid var(--theme-primary);">
                        <div
                            style="font-size: 0.875rem; color: var(--text-secondary); margin-bottom: var(--spacing-xs);">
                            Nombre corto:
                        </div>
                        <div id="nombreCorto"
                            style="font-size: 1.25rem; font-weight: 600; color: var(--text-primary); margin-bottom: var(--spacing-md);">
                            -
                        </div>
                        <div
                            style="font-size: 0.875rem; color: var(--text-secondary); margin-bottom: var(--spacing-xs);">
                            Nombre completo:
                        </div>
                        <div id="nombreCompleto" style="font-size: 1rem; color: var(--text-primary);">
                            -
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div
                    style="display: flex; gap: var(--spacing-md); justify-content: flex-end; margin-top: var(--spacing-xl);">
                    <a href="{{ route('courses.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Crear Curso
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const nivelSelect = document.getElementById('nivel');
        const gradoGroup = document.getElementById('gradoGroup');
        const gradoSelect = document.getElementById('grado');
        const letraSelect = document.getElementById('letra');
        const nombreCorto = document.getElementById('nombreCorto');
        const nombreCompleto = document.getElementById('nombreCompleto');

        // Grados por nivel
        const gradosPorNivel = {
            'Basica': [
                { value: '1°', text: '1° Primero' },
                { value: '2°', text: '2° Segundo' },
                { value: '3°', text: '3° Tercero' },
                { value: '4°', text: '4° Cuarto' },
                { value: '5°', text: '5° Quinto' },
                { value: '6°', text: '6° Sexto' },
                { value: '7°', text: '7° Séptimo' },
                { value: '8°', text: '8° Octavo' }
            ],
            'Media': [
                { value: '1°', text: '1° Primero' },
                { value: '2°', text: '2° Segundo' },
                { value: '3°', text: '3° Tercero' },
                { value: '4°', text: '4° Cuarto' }
            ]
        };

        // Nombres completos de grados
        const nombresGrados = {
            '1°': 'Primero',
            '2°': 'Segundo',
            '3°': 'Tercero',
            '4°': 'Cuarto',
            '5°': 'Quinto',
            '6°': 'Sexto',
            '7°': 'Séptimo',
            '8°': 'Octavo'
        };

        // Actualizar grados según nivel
        nivelSelect.addEventListener('change', function () {
            const nivel = this.value;

            // Limpiar grado
            gradoSelect.innerHTML = '<option value="">Seleccione un grado...</option>';

            if (nivel === 'Basica' || nivel === 'Media') {
                gradoGroup.style.display = 'block';
                gradoSelect.required = true;

                // Agregar opciones de grado
                gradosPorNivel[nivel].forEach(grado => {
                    const option = document.createElement('option');
                    option.value = grado.value;
                    option.textContent = grado.text;
                    gradoSelect.appendChild(option);
                });
            } else {
                gradoGroup.style.display = 'none';
                gradoSelect.required = false;
            }

            actualizarPreview();
        });

        // Actualizar preview cuando cambian los valores
        gradoSelect.addEventListener('change', actualizarPreview);
        letraSelect.addEventListener('change', actualizarPreview);

        function actualizarPreview() {
            const nivel = nivelSelect.value;
            const grado = gradoSelect.value;
            const letra = letraSelect.value;

            if (!nivel || !letra) {
                nombreCorto.textContent = '-';
                nombreCompleto.textContent = '-';
                return;
            }

            let corto = '';
            let completo = '';

            if (nivel === 'Pre-Kinder' || nivel === 'Kinder') {
                corto = `${nivel} ${letra}`;
                completo = `${nivel} ${letra}`;
            } else if (nivel === 'Basica') {
                if (grado) {
                    corto = `${grado}${letra}`;
                    completo = `${grado}${nombresGrados[grado]} Básico ${letra}`;
                }
            } else if (nivel === 'Media') {
                if (grado) {
                    corto = `${grado}${letra}`;
                    completo = `${grado}${nombresGrados[grado]} Medio ${letra}`;
                }
            }

            nombreCorto.textContent = corto || '-';
            nombreCompleto.textContent = completo || '-';
        }
    </script>
</x-app-layout>