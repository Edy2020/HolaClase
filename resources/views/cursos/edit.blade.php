<x-app-layout>
    <x-slot name="header">
        Editar Curso
    </x-slot>

    <div class="card" style="max-width: 800px; margin: 0 auto;">
        <!-- Header -->
        <div style="margin-bottom: var(--spacing-2xl); text-align: center;">
            <div style="width: 80px; height: 80px; margin: 0 auto var(--spacing-md); border-radius: var(--radius-lg); background: linear-gradient(135deg, var(--theme-color), var(--theme-dark)); display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem; box-shadow: var(--shadow-lg);">
                <i class="fas fa-edit"></i>
            </div>
            <h2 style="font-size: 1.75rem; font-weight: 700; color: var(--gray-900); margin-bottom: var(--spacing-xs);">
                Editar Curso
            </h2>
            <p style="color: var(--gray-600); font-size: 1rem;">{{ $curso->nombre }}</p>
        </div>

        <form action="{{ route('courses.update', $curso) }}" method="POST" id="cursoForm">
            @csrf
            @method('PUT')

            <!-- Información del Curso -->
            <div style="margin-bottom: var(--spacing-2xl);">
                <div style="display: flex; align-items: center; gap: var(--spacing-sm); margin-bottom: var(--spacing-lg); padding-bottom: var(--spacing-md); border-bottom: 2px solid var(--gray-200);">
                    <i class="fas fa-book" style="color: var(--theme-color); font-size: 1.25rem;"></i>
                    <h3 style="font-size: 1.125rem; font-weight: 700; color: var(--gray-900); margin: 0;">Información del Curso</h3>
                </div>

                <!-- Nivel -->
                <div class="form-group">
                    <label for="nivel" class="form-label">
                        <i class="fas fa-layer-group" style="margin-right: var(--spacing-xs); color: var(--theme-color);"></i>
                        Nivel de Enseñanza <span style="color: #ef4444;">*</span>
                    </label>
                    <select name="nivel" id="nivel" class="form-select" required>
                        <option value="">Seleccione un nivel...</option>
                        <option value="Pre-Kinder" {{ $curso->nivel == 'Pre-Kinder' ? 'selected' : '' }}>Pre-Kinder</option>
                        <option value="Kinder" {{ $curso->nivel == 'Kinder' ? 'selected' : '' }}>Kinder</option>
                        <option value="Basica" {{ $curso->nivel == 'Basica' ? 'selected' : '' }}>Educación Básica</option>
                        <option value="Media" {{ $curso->nivel == 'Media' ? 'selected' : '' }}>Educación Media</option>
                    </select>
                    @error('nivel')
                        <span style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Grado (conditional) -->
                <div class="form-group" id="gradoGroup" style="display: {{ ($curso->nivel == 'Basica' || $curso->nivel == 'Media') ? 'block' : 'none' }};">
                    <label for="grado" class="form-label">
                        <i class="fas fa-sort-numeric-up" style="margin-right: var(--spacing-xs); color: var(--theme-color);"></i>
                        Grado <span style="color: #ef4444;">*</span>
                    </label>
                    <select name="grado" id="grado" class="form-select">
                        <option value="">Seleccione un grado...</option>
                    </select>
                    @error('grado')
                        <span style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Sección -->
                <div class="form-group mb-0">
                    <label for="letra" class="form-label">
                        <i class="fas fa-font" style="margin-right: var(--spacing-xs); color: var(--theme-color);"></i>
                        Sección <span style="color: #ef4444;">*</span>
                    </label>
                    <select name="letra" id="letra" class="form-select" required>
                        <option value="">Seleccione una sección...</option>
                        <option value="A" {{ $curso->letra == 'A' ? 'selected' : '' }}>A</option>
                        <option value="B" {{ $curso->letra == 'B' ? 'selected' : '' }}>B</option>
                        <option value="C" {{ $curso->letra == 'C' ? 'selected' : '' }}>C</option>
                        <option value="D" {{ $curso->letra == 'D' ? 'selected' : '' }}>D</option>
                        <option value="E" {{ $curso->letra == 'E' ? 'selected' : '' }}>E</option>
                        <option value="F" {{ $curso->letra == 'F' ? 'selected' : '' }}>F</option>
                    </select>
                    @error('letra')
                        <span style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Vista Previa -->
            <div style="margin-bottom: var(--spacing-2xl);">
                <div style="display: flex; align-items: center; gap: var(--spacing-sm); margin-bottom: var(--spacing-lg); padding-bottom: var(--spacing-md); border-bottom: 2px solid var(--gray-200);">
                    <i class="fas fa-eye" style="color: var(--theme-color); font-size: 1.25rem;"></i>
                    <h3 style="font-size: 1.125rem; font-weight: 700; color: var(--gray-900); margin: 0;">Vista Previa del Curso</h3>
                </div>

                <div style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: var(--radius-lg); padding: var(--spacing-2xl); text-align: center; border: 2px dashed var(--gray-300);">
                    <!-- Badge del curso -->
                    <div id="cursoBadge" style="width: 120px; height: 120px; margin: 0 auto var(--spacing-lg); border-radius: var(--radius-lg); background: linear-gradient(135deg, var(--theme-color), var(--theme-dark)); display: flex; align-items: center; justify-content: center; color: white; font-size: 2.5rem; font-weight: 700; box-shadow: var(--shadow-xl); transition: all 0.3s ease;">
                        <span id="badgeText">?</span>
                    </div>

                    <!-- Nombre corto -->
                    <div style="margin-bottom: var(--spacing-lg);">
                        <div style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--gray-500); margin-bottom: var(--spacing-xs); font-weight: 600;">
                            Nombre Corto
                        </div>
                        <div id="nombreCorto" style="font-size: 1.75rem; font-weight: 700; color: var(--gray-900);">
                            -
                        </div>
                    </div>

                    <!-- Separador -->
                    <div style="width: 60px; height: 2px; background: var(--gray-300); margin: var(--spacing-lg) auto; border-radius: var(--radius-full);"></div>

                    <!-- Nombre completo -->
                    <div>
                        <div style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--gray-500); margin-bottom: var(--spacing-xs); font-weight: 600;">
                            Nombre Completo
                        </div>
                        <div id="nombreCompleto" style="font-size: 1.125rem; font-weight: 600; color: var(--gray-700);">
                            -
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons" style="display: flex; gap: var(--spacing-md); justify-content: flex-end; padding-top: var(--spacing-xl); border-top: 2px solid var(--gray-200);">
                <a href="{{ route('courses.index') }}" class="btn btn-ghost" style="min-width: 120px;">
                    <i class="fas fa-times" style="margin-right: 0.5rem;"></i>
                    Cancelar
                </a>
                <button type="submit" class="btn btn-primary" style="min-width: 150px;">
                    <i class="fas fa-save" style="margin-right: 0.5rem;"></i>
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>

    <script>
        const nivelSelect = document.getElementById('nivel');
        const gradoGroup = document.getElementById('gradoGroup');
        const gradoSelect = document.getElementById('grado');
        const letraSelect = document.getElementById('letra');
        const nombreCorto = document.getElementById('nombreCorto');
        const nombreCompleto = document.getElementById('nombreCompleto');
        const badgeText = document.getElementById('badgeText');
        const cursoBadge = document.getElementById('cursoBadge');

        // Valores actuales del curso
        const cursoActual = {
            nivel: '{{ $curso->nivel }}',
            grado: '{{ $curso->grado }}',
            letra: '{{ $curso->letra }}'
        };

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

        // Inicializar grados al cargar la página
        function inicializarGrados() {
            const nivel = nivelSelect.value;

            if (nivel === 'Basica' || nivel === 'Media') {
                gradoGroup.style.display = 'block';
                gradoSelect.required = true;

                // Limpiar y agregar opciones
                gradoSelect.innerHTML = '<option value="">Seleccione un grado...</option>';
                gradosPorNivel[nivel].forEach(grado => {
                    const option = document.createElement('option');
                    option.value = grado.value;
                    option.textContent = grado.text;
                    // Seleccionar el grado actual
                    if (grado.value === cursoActual.grado) {
                        option.selected = true;
                    }
                    gradoSelect.appendChild(option);
                });
            }

            actualizarPreview();
        }

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
                badgeText.textContent = '?';
                cursoBadge.style.background = 'linear-gradient(135deg, var(--theme-color), var(--theme-dark))';
                return;
            }

            let corto = '';
            let completo = '';
            let badge = '';

            if (nivel === 'Pre-Kinder' || nivel === 'Kinder') {
                corto = `${nivel} ${letra}`;
                completo = `${nivel} ${letra}`;
                badge = nivel === 'Pre-Kinder' ? `PK${letra}` : `K${letra}`;
                cursoBadge.style.background = 'linear-gradient(135deg, #10b981, #059669)';
            } else if (nivel === 'Basica') {
                if (grado) {
                    corto = `${grado}${letra}`;
                    completo = `${grado}${nombresGrados[grado]} Básico ${letra}`;
                    badge = `${grado}${letra}`;
                    cursoBadge.style.background = 'linear-gradient(135deg, #3b82f6, #2563eb)';
                }
            } else if (nivel === 'Media') {
                if (grado) {
                    corto = `${grado}${letra}`;
                    completo = `${grado}${nombresGrados[grado]} Medio ${letra}`;
                    badge = `${grado}${letra}`;
                    cursoBadge.style.background = 'linear-gradient(135deg, #f59e0b, #d97706)';
                }
            }

            nombreCorto.textContent = corto || '-';
            nombreCompleto.textContent = completo || '-';
            badgeText.textContent = badge || '?';
        }

        // Inicializar al cargar la página
        document.addEventListener('DOMContentLoaded', inicializarGrados);
    </script>

    <style>
        /* Mobile Responsive Styles */
        @media (max-width: 768px) {
            .card {
                padding: var(--spacing-md) !important;
                margin: 0 !important;
                max-width: 100% !important;
            }

            /* Header adjustments */
            .card > div:first-child {
                margin-bottom: var(--spacing-lg) !important;
            }

            .card > div:first-child > div:first-child {
                width: 60px !important;
                height: 60px !important;
                font-size: 1.5rem !important;
            }

            .card h2 {
                font-size: 1.25rem !important;
            }

            .card > div:first-child > p {
                font-size: 0.875rem !important;
            }

            /* Preview badge */
            #cursoBadge {
                width: 80px !important;
                height: 80px !important;
                font-size: 1.75rem !important;
            }

            /* Action buttons - stack vertically */
            .action-buttons {
                flex-direction: column-reverse !important;
                gap: var(--spacing-sm) !important;
            }

            .action-buttons .btn {
                width: 100% !important;
                min-width: auto !important;
                justify-content: center !important;
            }
        }
    </style>
</x-app-layout>