<x-app-layout>
    <x-slot name="header">
        Editar Curso
    </x-slot>

    <link rel="stylesheet" href="{{ asset('css/shared-index.css') }}?v={{ time() }}">

    <div class="page-header"
        style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-lg);">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--text-color); margin: 0;">
                <i class="fas fa-edit" style="color: var(--text-muted); margin-right: 8px;"></i>
                Editar Curso
            </h2>
            <p style="color: var(--text-muted); margin: var(--spacing-xs) 0 0 0; font-size: 0.9375rem;">
                {{ $curso->nombre }}
            </p>
        </div>
        <a href="{{ route('courses.show', $curso) }}"
            style="display: inline-flex; align-items: center; gap: var(--spacing-sm); border: 1px solid var(--border-color); color: var(--text-muted); background: transparent; padding: 0.5rem 1rem; border-radius: var(--radius-md); font-weight: 600; text-decoration: none; font-size: 0.9rem;">
            <i class="fas fa-arrow-left"></i>
            <span>Volver al Curso</span>
        </a>
    </div>

    <form action="{{ route('courses.update', $curso) }}" method="POST" id="cursoForm">
        @csrf
        @method('PUT')

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--spacing-lg);">

            <div
                style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: var(--spacing-lg);">
                <h3
                    style="font-size: 1rem; font-weight: 700; color: var(--text-color); margin: 0 0 var(--spacing-lg) 0; padding-bottom: var(--spacing-sm); border-bottom: 1px solid var(--border-color);">
                    <i class="fas fa-book" style="color: var(--text-muted); margin-right: 6px;"></i>
                    Información del Curso
                </h3>

                <div class="form-group" style="position: relative;">
                    <label class="form-label"
                        style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">NIVEL *</label>
                    <div
                        style="position: absolute; left: 12px; bottom: 10px; color: var(--text-muted); font-size: 1rem; pointer-events: none; z-index: 1;">
                        <i class="fas fa-layer-group"></i>
                    </div>
                    <select name="nivel" id="nivel" class="form-select" required
                        style="padding-left: 40px; border: 2px solid var(--border-color); border-radius: var(--radius-lg); background-color: var(--bg-card); color: var(--text-color); font-size: 0.9375rem; cursor: pointer;"
                        onfocus="this.style.borderColor='#84cc16'; this.style.boxShadow='0 0 0 3px rgba(132,204,22,0.1)'"
                        onblur="this.style.borderColor='var(--border-color)'; this.style.boxShadow='none'">
                        <option value="">Seleccione un nivel...</option>
                        <option value="Pre-Kinder" {{ $curso->nivel == 'Pre-Kinder' ? 'selected' : '' }}>Pre-Kinder
                        </option>
                        <option value="Kinder" {{ $curso->nivel == 'Kinder' ? 'selected' : '' }}>Kinder</option>
                        <option value="Basica" {{ $curso->nivel == 'Basica' ? 'selected' : '' }}>Educación Básica</option>
                        <option value="Media" {{ $curso->nivel == 'Media' ? 'selected' : '' }}>Educación Media</option>
                    </select>
                    @error('nivel')
                        <span
                            style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group" id="gradoGroup"
                    style="display: {{ ($curso->nivel == 'Basica' || $curso->nivel == 'Media') ? 'block' : 'none' }}; position: relative;">
                    <label class="form-label"
                        style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">GRADO *</label>
                    <div
                        style="position: absolute; left: 12px; bottom: 10px; color: var(--text-muted); font-size: 1rem; pointer-events: none; z-index: 1;">
                        <i class="fas fa-sort-numeric-up"></i>
                    </div>
                    <select name="grado" id="grado" class="form-select"
                        style="padding-left: 40px; border: 2px solid var(--border-color); border-radius: var(--radius-lg); background-color: var(--bg-card); color: var(--text-color); font-size: 0.9375rem; cursor: pointer;"
                        onfocus="this.style.borderColor='#84cc16'; this.style.boxShadow='0 0 0 3px rgba(132,204,22,0.1)'"
                        onblur="this.style.borderColor='var(--border-color)'; this.style.boxShadow='none'">
                        <option value="">Seleccione un grado...</option>
                    </select>
                    @error('grado')
                        <span
                            style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-0" style="position: relative;">
                    <label class="form-label"
                        style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">SECCIÓN *</label>
                    <div
                        style="position: absolute; left: 12px; bottom: 10px; color: var(--text-muted); font-size: 1rem; pointer-events: none; z-index: 1;">
                        <i class="fas fa-font"></i>
                    </div>
                    <select name="letra" id="letra" class="form-select" required
                        style="padding-left: 40px; border: 2px solid var(--border-color); border-radius: var(--radius-lg); background-color: var(--bg-card); color: var(--text-color); font-size: 0.9375rem; cursor: pointer;"
                        onfocus="this.style.borderColor='#84cc16'; this.style.boxShadow='0 0 0 3px rgba(132,204,22,0.1)'"
                        onblur="this.style.borderColor='var(--border-color)'; this.style.boxShadow='none'">
                        <option value="">Seleccione una sección...</option>
                        <option value="A" {{ $curso->letra == 'A' ? 'selected' : '' }}>A</option>
                        <option value="B" {{ $curso->letra == 'B' ? 'selected' : '' }}>B</option>
                        <option value="C" {{ $curso->letra == 'C' ? 'selected' : '' }}>C</option>
                        <option value="D" {{ $curso->letra == 'D' ? 'selected' : '' }}>D</option>
                        <option value="E" {{ $curso->letra == 'E' ? 'selected' : '' }}>E</option>
                        <option value="F" {{ $curso->letra == 'F' ? 'selected' : '' }}>F</option>
                    </select>
                    @error('letra')
                        <span
                            style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div
                style="background: var(--bg-card); border: 1px dashed var(--border-color); border-radius: var(--radius-lg); padding: var(--spacing-lg); display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center;">
                <h3
                    style="font-size: 1rem; font-weight: 700; color: var(--text-color); margin: 0 0 var(--spacing-lg) 0; padding-bottom: var(--spacing-sm); border-bottom: 1px solid var(--border-color); width: 100%;">
                    <i class="fas fa-eye" style="color: var(--text-muted); margin-right: 6px;"></i>
                    Vista Previa
                </h3>

                <div id="cursoBadge"
                    style="width: 90px; height: 90px; margin: 0 auto var(--spacing-md); border-radius: var(--radius-lg); background: var(--gray-200); display: flex; align-items: center; justify-content: center; color: var(--text-color); font-size: 1.75rem; font-weight: 700;">
                    <span id="badgeText">?</span>
                </div>

                <div
                    style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-muted); font-weight: 600; margin-bottom: 4px;">
                    Nombre Corto</div>
                <div id="nombreCorto"
                    style="font-size: 1.5rem; font-weight: 700; color: var(--text-color); margin-bottom: var(--spacing-md);">
                    -</div>

                <div
                    style="width: 40px; height: 1px; background: var(--border-color); margin: 0 auto var(--spacing-md);">
                </div>

                <div
                    style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-muted); font-weight: 600; margin-bottom: 4px;">
                    Nombre Completo</div>
                <div id="nombreCompleto" style="font-size: 1rem; font-weight: 600; color: var(--text-color);">-</div>
            </div>
        </div>

        <div
            style="margin-top: var(--spacing-lg); padding-top: var(--spacing-lg); border-top: 1px solid var(--border-color); display: flex; justify-content: flex-end;">
            <button type="submit" class="btn btn-outline"
                style="color: var(--text-color); border-color: var(--border-color);">
                <i class="fas fa-save"></i> Guardar Cambios
            </button>
        </div>
    </form>

    <script>
        const nivelSelect = document.getElementById('nivel');
        const gradoGroup = document.getElementById('gradoGroup');
        const gradoSelect = document.getElementById('grado');
        const letraSelect = document.getElementById('letra');
        const nombreCorto = document.getElementById('nombreCorto');
        const nombreCompleto = document.getElementById('nombreCompleto');
        const badgeText = document.getElementById('badgeText');
        const cursoBadge = document.getElementById('cursoBadge');

        const cursoActual = {
            nivel: '{{ $curso->nivel }}',
            grado: '{{ $curso->grado }}',
            letra: '{{ $curso->letra }}'
        };

        const gradosPorNivel = {
            'Basica': [
                { value: '1°', text: '1° Primero' }, { value: '2°', text: '2° Segundo' },
                { value: '3°', text: '3° Tercero' }, { value: '4°', text: '4° Cuarto' },
                { value: '5°', text: '5° Quinto' }, { value: '6°', text: '6° Sexto' },
                { value: '7°', text: '7° Séptimo' }, { value: '8°', text: '8° Octavo' }
            ],
            'Media': [
                { value: '1°', text: '1° Primero' }, { value: '2°', text: '2° Segundo' },
                { value: '3°', text: '3° Tercero' }, { value: '4°', text: '4° Cuarto' }
            ]
        };

        const nombresGrados = {
            '1°': 'Primero', '2°': 'Segundo', '3°': 'Tercero', '4°': 'Cuarto',
            '5°': 'Quinto', '6°': 'Sexto', '7°': 'Séptimo', '8°': 'Octavo'
        };

        function inicializarGrados() {
            const nivel = nivelSelect.value;
            if (nivel === 'Basica' || nivel === 'Media') {
                gradoGroup.style.display = 'block';
                gradoSelect.required = true;
                gradoSelect.innerHTML = '<option value="">Seleccione un grado...</option>';
                gradosPorNivel[nivel].forEach(g => {
                    const o = document.createElement('option');
                    o.value = g.value; o.textContent = g.text;
                    if (g.value === cursoActual.grado) o.selected = true;
                    gradoSelect.appendChild(o);
                });
            }
            actualizarPreview();
        }

        nivelSelect.addEventListener('change', function () {
            gradoSelect.innerHTML = '<option value="">Seleccione un grado...</option>';
            if (this.value === 'Basica' || this.value === 'Media') {
                gradoGroup.style.display = 'block'; gradoSelect.required = true;
                gradosPorNivel[this.value].forEach(g => {
                    const o = document.createElement('option');
                    o.value = g.value; o.textContent = g.text;
                    gradoSelect.appendChild(o);
                });
            } else {
                gradoGroup.style.display = 'none'; gradoSelect.required = false;
            }
            actualizarPreview();
        });

        gradoSelect.addEventListener('change', actualizarPreview);
        letraSelect.addEventListener('change', actualizarPreview);

        function actualizarPreview() {
            const nivel = nivelSelect.value, grado = gradoSelect.value, letra = letraSelect.value;
            if (!nivel || !letra) {
                nombreCorto.textContent = '-'; nombreCompleto.textContent = '-'; badgeText.textContent = '?'; return;
            }
            let corto = '', completo = '', badge = '';
            if (nivel === 'Pre-Kinder' || nivel === 'Kinder') {
                corto = `${nivel} ${letra}`; completo = corto;
                badge = nivel === 'Pre-Kinder' ? `PK${letra}` : `K${letra}`;
            } else if (nivel === 'Basica' && grado) {
                corto = `${grado}${letra}`; completo = `${grado}${nombresGrados[grado]} Básico ${letra}`; badge = corto;
            } else if (nivel === 'Media' && grado) {
                corto = `${grado}${letra}`; completo = `${grado}${nombresGrados[grado]} Medio ${letra}`; badge = corto;
            }
            nombreCorto.textContent = corto || '-'; nombreCompleto.textContent = completo || '-'; badgeText.textContent = badge || '?';
        }

        document.addEventListener('DOMContentLoaded', inicializarGrados);
    </script>

    <style>
        @media (max-width: 768px) {
            form>div:first-of-type {
                grid-template-columns: 1fr !important;
            }
        }
    </style>
</x-app-layout>