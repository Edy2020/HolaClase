<x-app-layout>
    <x-slot name="header">
        Editar Profesor
    </x-slot>

    <link rel="stylesheet" href="{{ asset('css/shared-index.css') }}?v={{ time() }}">

    <div class="page-header" style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: var(--spacing-lg); gap: var(--spacing-md); flex-wrap: nowrap;">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--text-color); margin: 0;">
                <i class="fas fa-user-edit" style="color: var(--text-muted); margin-right: 8px;"></i>
                Editar Profesor
            </h2>
            <p style="color: var(--text-muted); margin: var(--spacing-xs) 0 0 0; font-size: 0.9375rem;">
                {{ $profesor->nombre }} {{ $profesor->apellido }}
            </p>
        </div>
        <a href="{{ route('teachers.index') }}" class="btn btn-outline"
            style="color: var(--text-muted); border-color: var(--border-color); flex-shrink: 0;">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <form action="{{ route('teachers.update', $profesor->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: var(--spacing-lg); margin-bottom: var(--spacing-lg);">
            <h3 style="font-size: 1rem; font-weight: 700; color: var(--text-color); margin: 0 0 var(--spacing-lg) 0; padding-bottom: var(--spacing-sm); border-bottom: 1px solid var(--border-color);">
                <i class="fas fa-user" style="color: var(--text-muted); margin-right: 6px;"></i>
                Información Personal
            </h3>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--spacing-lg);">
                <div class="form-group mb-0">
                    <label class="form-label" style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">RUT *</label>
                    <div style="position: relative;">
                        <i class="fas fa-id-card" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none; z-index: 1;"></i>
                        <input type="text" name="rut" id="rut" class="form-input @error('rut') is-invalid @enderror"
                            style="width: 100%; padding-left: 40px; border: 1px solid var(--border-color); background: var(--bg-card); color: var(--text-color);"
                            value="{{ old('rut', $profesor->rut) }}" placeholder="12345678-9" maxlength="12" required>
                    </div>
                    @error('rut')<span style="color: var(--error); font-size: 0.875rem; display: block; margin-top: 4px;">{{ $message }}</span>@enderror
                </div>
                <div class="form-group mb-0">
                    <label class="form-label" style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">FECHA DE NACIMIENTO</label>
                    <div style="position: relative;">
                        <i class="fas fa-calendar" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none; z-index: 1;"></i>
                        <input type="date" name="fecha_nacimiento" class="form-input"
                            style="width: 100%; padding-left: 40px; border: 1px solid var(--border-color); background: var(--bg-card); color: var(--text-color);"
                            value="{{ old('fecha_nacimiento', optional($profesor->fecha_nacimiento)->format('Y-m-d')) }}">
                    </div>
                    @error('fecha_nacimiento')<span style="color: var(--error); font-size: 0.875rem; display: block; margin-top: 4px;">{{ $message }}</span>@enderror
                </div>
                <div class="form-group mb-0">
                    <label class="form-label" style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">NOMBRE *</label>
                    <div style="position: relative;">
                        <i class="fas fa-user" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none; z-index: 1;"></i>
                        <input type="text" name="nombre" class="form-input @error('nombre') is-invalid @enderror"
                            style="width: 100%; padding-left: 40px; border: 1px solid var(--border-color); background: var(--bg-card); color: var(--text-color);"
                            value="{{ old('nombre', $profesor->nombre) }}" placeholder="Ej. Juan" required>
                    </div>
                    @error('nombre')<span style="color: var(--error); font-size: 0.875rem; display: block; margin-top: 4px;">{{ $message }}</span>@enderror
                </div>
                <div class="form-group mb-0">
                    <label class="form-label" style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">APELLIDO *</label>
                    <div style="position: relative;">
                        <i class="fas fa-user" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none; z-index: 1;"></i>
                        <input type="text" name="apellido" class="form-input @error('apellido') is-invalid @enderror"
                            style="width: 100%; padding-left: 40px; border: 1px solid var(--border-color); background: var(--bg-card); color: var(--text-color);"
                            value="{{ old('apellido', $profesor->apellido) }}" placeholder="Ej. Pérez" required>
                    </div>
                    @error('apellido')<span style="color: var(--error); font-size: 0.875rem; display: block; margin-top: 4px;">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>

        <div style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: var(--spacing-lg); margin-bottom: var(--spacing-lg);">
            <h3 style="font-size: 1rem; font-weight: 700; color: var(--text-color); margin: 0 0 var(--spacing-lg) 0; padding-bottom: var(--spacing-sm); border-bottom: 1px solid var(--border-color);">
                <i class="fas fa-address-book" style="color: var(--text-muted); margin-right: 6px;"></i>
                Contacto
            </h3>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--spacing-lg);">
                <div class="form-group mb-0">
                    <label class="form-label" style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">EMAIL *</label>
                    <div style="position: relative;">
                        <i class="fas fa-envelope" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none; z-index: 1;"></i>
                        <input type="email" name="email" class="form-input @error('email') is-invalid @enderror"
                            style="width: 100%; padding-left: 40px; border: 1px solid var(--border-color); background: var(--bg-card); color: var(--text-color);"
                            value="{{ old('email', $profesor->email) }}" placeholder="nombre.apellido@holaclase.edu" required>
                    </div>
                    @error('email')<span style="color: var(--error); font-size: 0.875rem; display: block; margin-top: 4px;">{{ $message }}</span>@enderror
                </div>
                <div class="form-group mb-0">
                    <label class="form-label" style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">TELÉFONO</label>
                    <div style="position: relative;">
                        <i class="fas fa-phone" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none; z-index: 1;"></i>
                        <input type="text" name="telefono" class="form-input"
                            style="width: 100%; padding-left: 40px; border: 1px solid var(--border-color); background: var(--bg-card); color: var(--text-color);"
                            value="{{ old('telefono', $profesor->telefono) }}" placeholder="+56 9 1234 5678">
                    </div>
                    @error('telefono')<span style="color: var(--error); font-size: 0.875rem; display: block; margin-top: 4px;">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>

        <div style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: var(--spacing-lg); margin-bottom: var(--spacing-lg);">
            <h3 style="font-size: 1rem; font-weight: 700; color: var(--text-color); margin: 0 0 var(--spacing-lg) 0; padding-bottom: var(--spacing-sm); border-bottom: 1px solid var(--border-color);">
                <i class="fas fa-graduation-cap" style="color: var(--text-muted); margin-right: 6px;"></i>
                Información Académica
            </h3>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--spacing-lg);">
                <div class="form-group mb-0">
                    <label class="form-label" style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">NIVEL DE ENSEÑANZA</label>
                    <select name="nivel_ensenanza" class="form-select"
                        style="width: 100%; border: 1px solid var(--border-color); background: var(--bg-card); color: var(--text-color);">
                        <option value="">Seleccione nivel...</option>
                        <option value="Primer Ciclo" {{ old('nivel_ensenanza', $profesor->nivel_ensenanza) == 'Primer Ciclo' ? 'selected' : '' }}>Primer Ciclo</option>
                        <option value="Segundo Ciclo" {{ old('nivel_ensenanza', $profesor->nivel_ensenanza) == 'Segundo Ciclo' ? 'selected' : '' }}>Segundo Ciclo</option>
                        <option value="Superior" {{ old('nivel_ensenanza', $profesor->nivel_ensenanza) == 'Superior' ? 'selected' : '' }}>Superior</option>
                    </select>
                    @error('nivel_ensenanza')<span style="color: var(--error); font-size: 0.875rem; display: block; margin-top: 4px;">{{ $message }}</span>@enderror
                </div>
                <div class="form-group mb-0">
                    <label class="form-label" style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">TÍTULO PROFESIONAL</label>
                    <div style="position: relative;">
                        <i class="fas fa-certificate" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none; z-index: 1;"></i>
                        <input type="text" name="titulo" class="form-input"
                            style="width: 100%; padding-left: 40px; border: 1px solid var(--border-color); background: var(--bg-card); color: var(--text-color);"
                            value="{{ old('titulo', $profesor->titulo) }}" placeholder="Ej. Licenciado en Educación">
                    </div>
                    @error('titulo')<span style="color: var(--error); font-size: 0.875rem; display: block; margin-top: 4px;">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>

        <div style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: var(--spacing-lg); margin-bottom: var(--spacing-lg);">
            <h3 style="font-size: 1rem; font-weight: 700; color: var(--text-color); margin: 0 0 var(--spacing-lg) 0; padding-bottom: var(--spacing-sm); border-bottom: 1px solid var(--border-color);">
                <i class="fas fa-folder-open" style="color: var(--text-muted); margin-right: 6px;"></i>
                Documentación
            </h3>

            @if($profesor->documentos->count() > 0)
                <div style="margin-bottom: var(--spacing-lg);">
                    <p style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600; margin-bottom: var(--spacing-sm);">DOCUMENTOS ACTUALES</p>
                    <div style="border: 1px solid var(--border-color); border-radius: var(--radius-md); overflow: hidden;">
                        @foreach($profesor->documentos as $documento)
                            <div style="display: flex; align-items: center; justify-content: space-between; padding: var(--spacing-md); {{ !$loop->last ? 'border-bottom: 1px solid var(--border-color);' : '' }}">
                                <div style="display: flex; align-items: center; gap: var(--spacing-md);">
                                    <div style="width: 36px; height: 36px; border-radius: var(--radius-md); background: var(--gray-100); border: 1px solid var(--border-color); display: flex; align-items: center; justify-content: center; color: var(--text-muted);">
                                        <i class="fas fa-file-alt"></i>
                                    </div>
                                    <div>
                                        <div style="font-weight: 600; color: var(--text-color); font-size: 0.9rem;">{{ $documento->tipo }}</div>
                                        <div style="font-size: 0.75rem; color: var(--text-muted);">{{ $documento->created_at->format('d/m/Y') }}</div>
                                    </div>
                                </div>
                                <a href="{{ asset('storage/' . $documento->ruta_archivo) }}" target="_blank"
                                    class="btn btn-sm btn-outline" style="color: var(--text-color); border-color: var(--border-color);">
                                    <i class="fas fa-eye"></i> Ver
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <p style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600; margin-bottom: var(--spacing-md);">AGREGAR DOCUMENTO</p>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--spacing-lg);">
                <div class="form-group mb-0">
                    <label class="form-label" style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">TIPO</label>
                    <select name="documento_type" class="form-select"
                        style="width: 100%; border: 1px solid var(--border-color); background: var(--bg-card); color: var(--text-color);">
                        <option value="">Seleccione tipo...</option>
                        <option value="Carnet" {{ old('documento_type') == 'Carnet' ? 'selected' : '' }}>Carnet</option>
                        <option value="Certificado de Nacimiento" {{ old('documento_type') == 'Certificado de Nacimiento' ? 'selected' : '' }}>Certificado de Nacimiento</option>
                        <option value="Certificado de Titulo" {{ old('documento_type') == 'Certificado de Titulo' ? 'selected' : '' }}>Certificado de Título</option>
                        <option value="Certificado de Habilitacion" {{ old('documento_type') == 'Certificado de Habilitacion' ? 'selected' : '' }}>Certificado de Habilitación</option>
                    </select>
                    @error('documento_type')<span style="color: var(--error); font-size: 0.875rem; display: block; margin-top: 4px;">{{ $message }}</span>@enderror
                </div>
                <div class="form-group mb-0">
                    <label class="form-label" style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">ARCHIVO (PDF/IMAGEN)</label>
                    <input type="file" name="documento_archivo" class="form-input"
                        style="border: 1px solid var(--border-color); background: var(--bg-card); color: var(--text-color);"
                        accept=".pdf,.jpg,.jpeg,.png">
                    @error('documento_archivo')<span style="color: var(--error); font-size: 0.875rem; display: block; margin-top: 4px;">{{ $message }}</span>@enderror
                    <p style="color: var(--text-muted); font-size: 0.8rem; margin-top: 4px;"><i class="fas fa-info-circle"></i> PDF, JPG, PNG. Máx. 5MB</p>
                </div>
            </div>
        </div>

        <div style="padding-top: var(--spacing-lg); border-top: 1px solid var(--border-color); display: flex; justify-content: flex-end;">
            <button type="submit" class="btn btn-outline" style="color: var(--text-color); border-color: var(--border-color);">
                <i class="fas fa-save"></i> Guardar Cambios
            </button>
        </div>
    </form>

    <script>
        document.getElementById('rut').addEventListener('input', function(e) {
            let value = e.target.value.replace(/[^0-9kK]/g, '');
            if (value.length > 1) {
                value = value.substring(0, value.length - 1) + '-' + value.substring(value.length - 1);
            }
            e.target.value = value;
        });
    </script>

    <style>
        @media (max-width: 768px) {
            div[style*="grid-template-columns: 1fr 1fr"] { grid-template-columns: 1fr !important; }
        }
    </style>
</x-app-layout>