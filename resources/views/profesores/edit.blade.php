<x-app-layout>
    <x-slot name="header">
        Editar Profesor
    </x-slot>

    <div class="card" style="max-width: 800px; margin: 0 auto;">
        <div style="margin-bottom: var(--spacing-xl);">
            <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--gray-900); margin-bottom: var(--spacing-xs);">
                <i class="fas fa-user-edit" style="margin-right: var(--spacing-xs); color: var(--theme-color);"></i>
                Editar Profesor: {{ $profesor->nombre }} {{ $profesor->apellido }}
            </h2>
            <p style="color: var(--gray-600);">Actualice la información del docente.</p>
        </div>

        <form action="{{ route('teachers.update', $profesor->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-2" style="gap: var(--spacing-lg); margin-bottom: var(--spacing-lg);">
                <div class="form-group mb-0">
                    <label class="form-label">RUT <span style="color: #ef4444;">*</span></label>
                    <input type="text" name="rut" class="form-input" value="{{ old('rut', $profesor->rut) }}" required
                        placeholder="12345678-9">
                    @error('rut')
                        <span
                            style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-0">
                    <label class="form-label">Fecha de Nacimiento</label>
                    <input type="date" name="fecha_nacimiento" class="form-input"
                        value="{{ old('fecha_nacimiento', optional($profesor->fecha_nacimiento)->format('Y-m-d')) }}">
                    @error('fecha_nacimiento')
                        <span
                            style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-2" style="gap: var(--spacing-lg); margin-bottom: var(--spacing-lg);">
                <div class="form-group mb-0">
                    <label class="form-label">Nombre <span style="color: #ef4444;">*</span></label>
                    <input type="text" name="nombre" class="form-input" value="{{ old('nombre', $profesor->nombre) }}"
                        required placeholder="Ej. Juan">
                    @error('nombre')
                        <span
                            style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-0">
                    <label class="form-label">Apellido <span style="color: #ef4444;">*</span></label>
                    <input type="text" name="apellido" class="form-input"
                        value="{{ old('apellido', $profesor->apellido) }}" required placeholder="Ej. Pérez">
                    @error('apellido')
                        <span
                            style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Email Institucional <span style="color: #ef4444;">*</span></label>
                <input type="email" name="email" class="form-input" value="{{ old('email', $profesor->email) }}"
                    required placeholder="nombre.apellido@holaclase.edu">
                @error('email')
                    <span
                        style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div class="grid grid-cols-2" style="gap: var(--spacing-lg); margin-bottom: var(--spacing-xl);">
                <div class="form-group mb-0">
                    <label class="form-label">Teléfono</label>
                    <input type="text" name="telefono" class="form-input"
                        value="{{ old('telefono', $profesor->telefono) }}" placeholder="+56 9 1234 5678">
                    @error('telefono')
                        <span
                            style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-0">
                    <label class="form-label">Especialidad</label>
                    <select name="especialidad" class="form-select">
                        <option value="">Seleccione una especialidad...</option>
                        <option value="Matemáticas" {{ old('especialidad', $profesor->especialidad) == 'Matemáticas' ? 'selected' : '' }}>Matemáticas</option>
                        <option value="Ciencias" {{ old('especialidad', $profesor->especialidad) == 'Ciencias' ? 'selected' : '' }}>Ciencias</option>
                        <option value="Historia" {{ old('especialidad', $profesor->especialidad) == 'Historia' ? 'selected' : '' }}>Historia</option>
                        <option value="Lenguaje" {{ old('especialidad', $profesor->especialidad) == 'Lenguaje' ? 'selected' : '' }}>Lenguaje</option>
                        <option value="Inglés" {{ old('especialidad', $profesor->especialidad) == 'Inglés' ? 'selected' : '' }}>Inglés</option>
                        <option value="Artes" {{ old('especialidad', $profesor->especialidad) == 'Artes' ? 'selected' : '' }}>Artes</option>
                        <option value="Música" {{ old('especialidad', $profesor->especialidad) == 'Música' ? 'selected' : '' }}>Música</option>
                        <option value="Educación Física" {{ old('especialidad', $profesor->especialidad) == 'Educación Física' ? 'selected' : '' }}>Educación Física</option>
                        <option value="Tecnología" {{ old('especialidad', $profesor->especialidad) == 'Tecnología' ? 'selected' : '' }}>Tecnología</option>
                    </select>
                    @error('especialidad')
                        <span
                            style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-2" style="gap: var(--spacing-lg); margin-bottom: var(--spacing-xl);">
                <div class="form-group mb-0">
                    <label class="form-label">Título Profesional</label>
                    <input type="text" name="titulo" class="form-input" value="{{ old('titulo', $profesor->titulo) }}"
                        placeholder="Ej. Licenciado en Educación">
                    @error('titulo')
                        <span
                            style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-0">
                    <label class="form-label">Documento de Identidad (PDF/Imagen)</label>
                    <input type="file" name="documento_identidad" class="form-input">
                    @if($profesor->documento_identidad)
                        <div style="margin-top: 5px;">
                            <a href="{{ asset('storage/' . $profesor->documento_identidad) }}" target="_blank"
                                style="color: var(--theme-color); font-size: 0.875rem;">
                                <i class="fas fa-file-alt"></i> Ver documento actual
                            </a>
                        </div>
                    @endif
                    @error('documento_identidad')
                        <span
                            style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div
                style="display: flex; gap: var(--spacing-md); justify-content: flex-end; padding-top: var(--spacing-lg); border-top: 1px solid var(--gray-200);">
                <a href="{{ route('teachers.index') }}" class="btn btn-ghost">Cancelar</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save" style="margin-right: 0.5rem;"></i>
                    Actualizar Profesor
                </button>
            </div>
        </form>
    </div>
</x-app-layout>