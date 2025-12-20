<x-app-layout>
    <x-slot name="header">
        Nuevo Profesor
    </x-slot>

    <div class="card" style="max-width: 800px; margin: 0 auto;">
        <div style="margin-bottom: var(--spacing-xl);">
            <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--gray-900); margin-bottom: var(--spacing-xs);">
                <i class="fas fa-user-plus" style="margin-right: var(--spacing-xs); color: var(--theme-color);"></i>
                Registrar Nuevo Profesor
            </h2>
            <p style="color: var(--gray-600);">Complete el formulario para añadir un nuevo docente al sistema.</p>
        </div>

        <form action="{{ route('teachers.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-2" style="gap: var(--spacing-lg); margin-bottom: var(--spacing-lg);">
                <div class="form-group mb-0">
                    <label class="form-label">RUT <span style="color: #ef4444;">*</span></label>
                    <input type="text" name="rut" id="rut" class="form-input" value="{{ old('rut') }}" required
                        placeholder="12345678-9" maxlength="12">
                    @error('rut')
                        <span
                            style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-0">
                    <label class="form-label">Fecha de Nacimiento</label>
                    <input type="date" name="fecha_nacimiento" class="form-input" value="{{ old('fecha_nacimiento') }}">
                    @error('fecha_nacimiento')
                        <span
                            style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-2" style="gap: var(--spacing-lg); margin-bottom: var(--spacing-lg);">
                <div class="form-group mb-0">
                    <label class="form-label">Nombre <span style="color: #ef4444;">*</span></label>
                    <input type="text" name="nombre" class="form-input" value="{{ old('nombre') }}" required
                        placeholder="Ej. Juan">
                    @error('nombre')
                        <span
                            style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-0">
                    <label class="form-label">Apellido <span style="color: #ef4444;">*</span></label>
                    <input type="text" name="apellido" class="form-input" value="{{ old('apellido') }}" required
                        placeholder="Ej. Pérez">
                    @error('apellido')
                        <span
                            style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Email Institucional <span style="color: #ef4444;">*</span></label>
                <input type="email" name="email" class="form-input" value="{{ old('email') }}" required
                    placeholder="nombre.apellido@holaclase.edu">
                @error('email')
                    <span
                        style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div class="grid grid-cols-2" style="gap: var(--spacing-lg); margin-bottom: var(--spacing-xl);">
                <div class="form-group mb-0">
                    <label class="form-label">Teléfono</label>
                    <input type="text" name="telefono" class="form-input" value="{{ old('telefono') }}"
                        placeholder="+56 9 1234 5678">
                    @error('telefono')
                        <span
                            style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-0">
                    <label class="form-label">Nivel de Enseñanza</label>
                    <select name="nivel_ensenanza" class="form-select">
                        <option value="">Seleccione nivel...</option>
                        <option value="Primer Ciclo" {{ old('nivel_ensenanza') == 'Primer Ciclo' ? 'selected' : '' }}>
                            Primer Ciclo</option>
                        <option value="Segundo Ciclo" {{ old('nivel_ensenanza') == 'Segundo Ciclo' ? 'selected' : '' }}>
                            Segundo Ciclo</option>
                        <option value="Superior" {{ old('nivel_ensenanza') == 'Superior' ? 'selected' : '' }}>Superior
                        </option>
                    </select>
                    @error('nivel_ensenanza')
                        <span
                            style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-2" style="gap: var(--spacing-lg); margin-bottom: var(--spacing-xl);">
                <div class="form-group mb-0">
                    <label class="form-label">Título Profesional</label>
                    <input type="text" name="titulo" class="form-input" value="{{ old('titulo') }}"
                        placeholder="Ej. Licenciado en Educación">
                    @error('titulo')
                        <span
                            style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div
                style="margin-bottom: var(--spacing-xl); padding: 1rem; background-color: #f9fafb; border-radius: 0.5rem; border: 1px solid #e5e7eb;">
                <h3 style="font-size: 1rem; font-weight: 600; color: var(--gray-800); margin-bottom: 1rem;">Cargar
                    Documento</h3>
                <div class="grid grid-cols-2" style="gap: var(--spacing-lg);">
                    <div class="form-group mb-0">
                        <label class="form-label">Tipo de Documento</label>
                        <select name="documento_type" class="form-select">
                            <option value="">Seleccione tipo...</option>
                            <option value="Carnet" {{ old('documento_type') == 'Carnet' ? 'selected' : '' }}>Carnet
                            </option>
                            <option value="Certificado de Nacimiento" {{ old('documento_type') == 'Certificado de Nacimiento' ? 'selected' : '' }}>Certificado de Nacimiento</option>
                            <option value="Certificado de Titulo" {{ old('documento_type') == 'Certificado de Titulo' ? 'selected' : '' }}>Certificado de Título</option>
                            <option value="Certificado de Habilitacion" {{ old('documento_type') == 'Certificado de Habilitacion' ? 'selected' : '' }}>Certificado de Habilitación</option>
                        </select>
                        @error('documento_type')
                            <span
                                style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label">Archivo (PDF/Imagen)</label>
                        <input type="file" name="documento_archivo" class="form-input">
                        @error('documento_archivo')
                            <span
                                style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <script>
                document.getElementById('rut').addEventListener('input', function (e) {
                    let value = e.target.value.replace(/[^0-9kK]/g, '');
                    if (value.length > 1) {
                        value = value.substring(0, value.length - 1) + '-' + value.substring(value.length - 1);
                    }
                    e.target.value = value;
                });
            </script>

            <div
                style="display: flex; gap: var(--spacing-md); justify-content: flex-end; padding-top: var(--spacing-lg); border-top: 1px solid var(--gray-200);">
                <a href="{{ route('teachers.index') }}" class="btn btn-ghost">Cancelar</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save" style="margin-right: 0.5rem;"></i>
                    Guardar Profesor
                </button>
            </div>
        </form>
    </div>
</x-app-layout>