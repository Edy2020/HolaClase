<x-app-layout>
    <x-slot name="header">
        Nuevo Estudiante
    </x-slot>

    <link rel="stylesheet" href="{{ asset('css/shared-index.css') }}?v={{ time() }}">

    <div class="page-header" style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: var(--spacing-lg); gap: var(--spacing-md); flex-wrap: nowrap;">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--text-color); margin: 0;">
                <i class="fas fa-user-graduate" style="color: var(--text-muted); margin-right: 8px;"></i>
                Nuevo Estudiante
            </h2>
            <p style="color: var(--text-muted); margin: var(--spacing-xs) 0 0 0; font-size: 0.9375rem;">
                Completa el formulario para registrar un nuevo estudiante en el sistema.
            </p>
        </div>
        <a href="{{ route('students.index') }}" class="btn btn-outline"
            style="color: var(--text-muted); border-color: var(--border-color); flex-shrink: 0;">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data" id="studentForm">
        @csrf

        <div style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: var(--spacing-lg); margin-bottom: var(--spacing-lg);">
            <h3 style="font-size: 1rem; font-weight: 700; color: var(--text-color); margin: 0 0 var(--spacing-lg) 0; padding-bottom: var(--spacing-sm); border-bottom: 1px solid var(--border-color);">
                <i class="fas fa-user" style="color: var(--text-muted); margin-right: 6px;"></i>
                Información Personal
            </h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: var(--spacing-lg);">
                <div class="form-group mb-0">
                    <label class="form-label" style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">RUT *</label>
                    <div style="position: relative;">
                        <i class="fas fa-id-card" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none; z-index: 1;"></i>
                        <input type="text" name="rut" id="rut" class="form-input" style="width: 100%; padding-left: 40px; border: 1px solid var(--border-color); background: var(--bg-card); color: var(--text-color);" value="{{ old('rut') }}" required placeholder="12345678-9" maxlength="12">
                    </div>
                    <small id="rutError" style="color: var(--error); font-size: 0.875rem; display: none;">RUT inválido</small>
                    @error('rut')<span style="color: var(--error); font-size: 0.875rem; display: block; margin-top: 4px;">{{ $message }}</span>@enderror
                </div>
                <div class="form-group mb-0">
                    <label class="form-label" style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">NOMBRE *</label>
                    <div style="position: relative;">
                        <i class="fas fa-user" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none; z-index: 1;"></i>
                        <input type="text" name="nombre" class="form-input" style="width: 100%; padding-left: 40px; border: 1px solid var(--border-color); background: var(--bg-card); color: var(--text-color);" value="{{ old('nombre') }}" required placeholder="Ej. Juan">
                    </div>
                    @error('nombre')<span style="color: var(--error); font-size: 0.875rem; display: block; margin-top: 4px;">{{ $message }}</span>@enderror
                </div>
                <div class="form-group mb-0">
                    <label class="form-label" style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">APELLIDO *</label>
                    <div style="position: relative;">
                        <i class="fas fa-user" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none; z-index: 1;"></i>
                        <input type="text" name="apellido" class="form-input" style="width: 100%; padding-left: 40px; border: 1px solid var(--border-color); background: var(--bg-card); color: var(--text-color);" value="{{ old('apellido') }}" required placeholder="Ej. Pérez">
                    </div>
                    @error('apellido')<span style="color: var(--error); font-size: 0.875rem; display: block; margin-top: 4px;">{{ $message }}</span>@enderror
                </div>
                <div class="form-group mb-0">
                    <label class="form-label" style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">FECHA DE NACIMIENTO</label>
                    <div style="position: relative;">
                        <i class="fas fa-calendar" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none; z-index: 1;"></i>
                        <input type="date" name="fecha_nacimiento" class="form-input" style="width: 100%; padding-left: 40px; border: 1px solid var(--border-color); background: var(--bg-card); color: var(--text-color);" value="{{ old('fecha_nacimiento') }}">
                    </div>
                    @error('fecha_nacimiento')<span style="color: var(--error); font-size: 0.875rem; display: block; margin-top: 4px;">{{ $message }}</span>@enderror
                </div>
                <div class="form-group mb-0">
                    <label class="form-label" style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">GÉNERO</label>
                    <select name="genero" class="form-select" style="width: 100%; border: 1px solid var(--border-color); background: var(--bg-card); color: var(--text-color);">
                        <option value="">Seleccione...</option>
                        <option value="Masculino" {{ old('genero') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                        <option value="Femenino" {{ old('genero') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                        <option value="Otro" {{ old('genero') == 'Otro' ? 'selected' : '' }}>Otro</option>
                    </select>
                    @error('genero')<span style="color: var(--error); font-size: 0.875rem; display: block; margin-top: 4px;">{{ $message }}</span>@enderror
                </div>
                <div class="form-group mb-0">
                    <label class="form-label" style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">NACIONALIDAD</label>
                    <div style="position: relative;">
                        <i class="fas fa-flag" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none; z-index: 1;"></i>
                        <input type="text" name="nacionalidad" class="form-input" style="width: 100%; padding-left: 40px; border: 1px solid var(--border-color); background: var(--bg-card); color: var(--text-color);" value="{{ old('nacionalidad', 'Chilena') }}" placeholder="Ej. Chilena">
                    </div>
                    @error('nacionalidad')<span style="color: var(--error); font-size: 0.875rem; display: block; margin-top: 4px;">{{ $message }}</span>@enderror
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
                    <label class="form-label" style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">EMAIL</label>
                    <div style="position: relative;">
                        <i class="fas fa-envelope" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none; z-index: 1;"></i>
                        <input type="email" name="email" class="form-input" style="width: 100%; padding-left: 40px; border: 1px solid var(--border-color); background: var(--bg-card); color: var(--text-color);" value="{{ old('email') }}" placeholder="estudiante@email.com">
                    </div>
                    @error('email')<span style="color: var(--error); font-size: 0.875rem; display: block; margin-top: 4px;">{{ $message }}</span>@enderror
                </div>
                <div class="form-group mb-0">
                    <label class="form-label" style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">TELÉFONO</label>
                    <div style="position: relative;">
                        <i class="fas fa-phone" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none; z-index: 1;"></i>
                        <input type="text" name="telefono" class="form-input" style="width: 100%; padding-left: 40px; border: 1px solid var(--border-color); background: var(--bg-card); color: var(--text-color);" value="{{ old('telefono') }}" placeholder="+56 9 1234 5678">
                    </div>
                    @error('telefono')<span style="color: var(--error); font-size: 0.875rem; display: block; margin-top: 4px;">{{ $message }}</span>@enderror
                </div>
                <div class="form-group mb-0">
                    <label class="form-label" style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">DIRECCIÓN</label>
                    <div style="position: relative;">
                        <i class="fas fa-map-marker-alt" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none; z-index: 1;"></i>
                        <input type="text" name="direccion" class="form-input" style="width: 100%; padding-left: 40px; border: 1px solid var(--border-color); background: var(--bg-card); color: var(--text-color);" value="{{ old('direccion') }}" placeholder="Calle, número, comuna">
                    </div>
                    @error('direccion')<span style="color: var(--error); font-size: 0.875rem; display: block; margin-top: 4px;">{{ $message }}</span>@enderror
                </div>
                <div class="form-group mb-0">
                    <label class="form-label" style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">CIUDAD</label>
                    <div style="position: relative;">
                        <i class="fas fa-city" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none; z-index: 1;"></i>
                        <input type="text" name="ciudad" class="form-input" style="width: 100%; padding-left: 40px; border: 1px solid var(--border-color); background: var(--bg-card); color: var(--text-color);" value="{{ old('ciudad') }}" placeholder="Ej. Santiago">
                    </div>
                    @error('ciudad')<span style="color: var(--error); font-size: 0.875rem; display: block; margin-top: 4px;">{{ $message }}</span>@enderror
                </div>
                <div class="form-group mb-0" style="grid-column: 1 / -1;">
                    <label class="form-label" style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">REGIÓN</label>
                    <select name="region" class="form-select" style="width: 100%; border: 1px solid var(--border-color); background: var(--bg-card); color: var(--text-color);">
                        <option value="">Seleccione región...</option>
                        <option value="Región Metropolitana" {{ old('region') == 'Región Metropolitana' ? 'selected' : '' }}>Región Metropolitana</option>
                        <option value="Región de Valparaíso" {{ old('region') == 'Región de Valparaíso' ? 'selected' : '' }}>Región de Valparaíso</option>
                        <option value="Región del Biobío" {{ old('region') == 'Región del Biobío' ? 'selected' : '' }}>Región del Biobío</option>
                        <option value="Región de La Araucanía" {{ old('region') == 'Región de La Araucanía' ? 'selected' : '' }}>Región de La Araucanía</option>
                        <option value="Región de Los Lagos" {{ old('region') == 'Región de Los Lagos' ? 'selected' : '' }}>Región de Los Lagos</option>
                    </select>
                    @error('region')<span style="color: var(--error); font-size: 0.875rem; display: block; margin-top: 4px;">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>

        <div style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: var(--spacing-lg); margin-bottom: var(--spacing-lg);">
            <h3 style="font-size: 1rem; font-weight: 700; color: var(--text-color); margin: 0 0 var(--spacing-lg) 0; padding-bottom: var(--spacing-sm); border-bottom: 1px solid var(--border-color);">
                <i class="fas fa-user-tie" style="color: var(--text-muted); margin-right: 6px;"></i>
                Apoderado
            </h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--spacing-lg);">
                <div class="form-group mb-0">
                    <label class="form-label" style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">RUT APODERADO *</label>
                    <div style="position: relative;">
                        <i class="fas fa-id-card" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none; z-index: 1;"></i>
                        <input type="text" name="apoderado_rut" id="apoderado_rut" class="form-input" style="width: 100%; padding-left: 40px; border: 1px solid var(--border-color); background: var(--bg-card); color: var(--text-color);" value="{{ old('apoderado_rut') }}" required placeholder="12345678-9" maxlength="12">
                    </div>
                    <small id="apoderadoRutError" style="color: var(--error); font-size: 0.875rem; display: none;">RUT inválido</small>
                    @error('apoderado_rut')<span style="color: var(--error); font-size: 0.875rem; display: block; margin-top: 4px;">{{ $message }}</span>@enderror
                </div>
                <div class="form-group mb-0">
                    <label class="form-label" style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">RELACIÓN *</label>
                    <select name="apoderado_relacion" class="form-select" style="width: 100%; border: 1px solid var(--border-color); background: var(--bg-card); color: var(--text-color);" required>
                        <option value="">Seleccione...</option>
                        <option value="Padre" {{ old('apoderado_relacion') == 'Padre' ? 'selected' : '' }}>Padre</option>
                        <option value="Madre" {{ old('apoderado_relacion') == 'Madre' ? 'selected' : '' }}>Madre</option>
                        <option value="Tutor" {{ old('apoderado_relacion') == 'Tutor' ? 'selected' : '' }}>Tutor</option>
                        <option value="Abuelo/a" {{ old('apoderado_relacion') == 'Abuelo/a' ? 'selected' : '' }}>Abuelo/a</option>
                        <option value="Tío/a" {{ old('apoderado_relacion') == 'Tío/a' ? 'selected' : '' }}>Tío/a</option>
                        <option value="Otro" {{ old('apoderado_relacion') == 'Otro' ? 'selected' : '' }}>Otro</option>
                    </select>
                    @error('apoderado_relacion')<span style="color: var(--error); font-size: 0.875rem; display: block; margin-top: 4px;">{{ $message }}</span>@enderror
                </div>
                <div class="form-group mb-0">
                    <label class="form-label" style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">NOMBRE *</label>
                    <div style="position: relative;">
                        <i class="fas fa-user" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none; z-index: 1;"></i>
                        <input type="text" name="apoderado_nombre" class="form-input" style="width: 100%; padding-left: 40px; border: 1px solid var(--border-color); background: var(--bg-card); color: var(--text-color);" value="{{ old('apoderado_nombre') }}" required placeholder="Ej. María">
                    </div>
                    @error('apoderado_nombre')<span style="color: var(--error); font-size: 0.875rem; display: block; margin-top: 4px;">{{ $message }}</span>@enderror
                </div>
                <div class="form-group mb-0">
                    <label class="form-label" style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">APELLIDO *</label>
                    <div style="position: relative;">
                        <i class="fas fa-user" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none; z-index: 1;"></i>
                        <input type="text" name="apoderado_apellido" class="form-input" style="width: 100%; padding-left: 40px; border: 1px solid var(--border-color); background: var(--bg-card); color: var(--text-color);" value="{{ old('apoderado_apellido') }}" required placeholder="Ej. González">
                    </div>
                    @error('apoderado_apellido')<span style="color: var(--error); font-size: 0.875rem; display: block; margin-top: 4px;">{{ $message }}</span>@enderror
                </div>
                <div class="form-group mb-0">
                    <label class="form-label" style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">EMAIL</label>
                    <div style="position: relative;">
                        <i class="fas fa-envelope" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none; z-index: 1;"></i>
                        <input type="email" name="apoderado_email" class="form-input" style="width: 100%; padding-left: 40px; border: 1px solid var(--border-color); background: var(--bg-card); color: var(--text-color);" value="{{ old('apoderado_email') }}" placeholder="apoderado@email.com">
                    </div>
                    @error('apoderado_email')<span style="color: var(--error); font-size: 0.875rem; display: block; margin-top: 4px;">{{ $message }}</span>@enderror
                </div>
                <div class="form-group mb-0">
                    <label class="form-label" style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">TELÉFONO</label>
                    <div style="position: relative;">
                        <i class="fas fa-phone" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none; z-index: 1;"></i>
                        <input type="text" name="apoderado_telefono" class="form-input" style="width: 100%; padding-left: 40px; border: 1px solid var(--border-color); background: var(--bg-card); color: var(--text-color);" value="{{ old('apoderado_telefono') }}" placeholder="+56 9 1234 5678">
                    </div>
                    @error('apoderado_telefono')<span style="color: var(--error); font-size: 0.875rem; display: block; margin-top: 4px;">{{ $message }}</span>@enderror
                </div>
                <div class="form-group mb-0">
                    <label class="form-label" style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">TEL. EMERGENCIA</label>
                    <div style="position: relative;">
                        <i class="fas fa-phone-alt" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none; z-index: 1;"></i>
                        <input type="text" name="apoderado_telefono_emergencia" class="form-input" style="width: 100%; padding-left: 40px; border: 1px solid var(--border-color); background: var(--bg-card); color: var(--text-color);" value="{{ old('apoderado_telefono_emergencia') }}" placeholder="+56 9 8765 4321">
                    </div>
                    @error('apoderado_telefono_emergencia')<span style="color: var(--error); font-size: 0.875rem; display: block; margin-top: 4px;">{{ $message }}</span>@enderror
                </div>
                <div class="form-group mb-0">
                    <label class="form-label" style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">OCUPACIÓN</label>
                    <div style="position: relative;">
                        <i class="fas fa-briefcase" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none; z-index: 1;"></i>
                        <input type="text" name="apoderado_ocupacion" class="form-input" style="width: 100%; padding-left: 40px; border: 1px solid var(--border-color); background: var(--bg-card); color: var(--text-color);" value="{{ old('apoderado_ocupacion') }}" placeholder="Ej. Ingeniero">
                    </div>
                    @error('apoderado_ocupacion')<span style="color: var(--error); font-size: 0.875rem; display: block; margin-top: 4px;">{{ $message }}</span>@enderror
                </div>
                <div class="form-group mb-0">
                    <label class="form-label" style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">LUGAR DE TRABAJO</label>
                    <div style="position: relative;">
                        <i class="fas fa-building" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none; z-index: 1;"></i>
                        <input type="text" name="apoderado_lugar_trabajo" class="form-input" style="width: 100%; padding-left: 40px; border: 1px solid var(--border-color); background: var(--bg-card); color: var(--text-color);" value="{{ old('apoderado_lugar_trabajo') }}" placeholder="Ej. Empresa XYZ">
                    </div>
                    @error('apoderado_lugar_trabajo')<span style="color: var(--error); font-size: 0.875rem; display: block; margin-top: 4px;">{{ $message }}</span>@enderror
                </div>
                <div class="form-group mb-0">
                    <label class="form-label" style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">DIRECCIÓN APODERADO</label>
                    <div style="position: relative;">
                        <i class="fas fa-map-marker-alt" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none; z-index: 1;"></i>
                        <input type="text" name="apoderado_direccion" class="form-input" style="width: 100%; padding-left: 40px; border: 1px solid var(--border-color); background: var(--bg-card); color: var(--text-color);" value="{{ old('apoderado_direccion') }}" placeholder="Calle, número, comuna">
                    </div>
                    @error('apoderado_direccion')<span style="color: var(--error); font-size: 0.875rem; display: block; margin-top: 4px;">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>

        <div style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: var(--spacing-lg); margin-bottom: var(--spacing-lg);">
            <h3 style="font-size: 1rem; font-weight: 700; color: var(--text-color); margin: 0 0 var(--spacing-lg) 0; padding-bottom: var(--spacing-sm); border-bottom: 1px solid var(--border-color);">
                <i class="fas fa-school" style="color: var(--text-muted); margin-right: 6px;"></i>
                Inscripción a Curso
            </h3>
            <div class="form-group mb-0">
                <label class="form-label" style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">CURSO (OPCIONAL)</label>
                <select name="curso_id" class="form-select" style="width: 100%; border: 1px solid var(--border-color); background: var(--bg-card); color: var(--text-color);">
                    <option value="">Seleccione un curso...</option>
                    @foreach($cursos as $curso)
                        <option value="{{ $curso->id }}" {{ old('curso_id') == $curso->id ? 'selected' : '' }}>{{ $curso->nombre }}</option>
                    @endforeach
                </select>
                <p style="color: var(--text-muted); font-size: 0.8rem; margin-top: 4px;"><i class="fas fa-info-circle"></i> Puede asignar el estudiante a un curso ahora o hacerlo más tarde.</p>
                @error('curso_id')<span style="color: var(--error); font-size: 0.875rem; display: block; margin-top: 4px;">{{ $message }}</span>@enderror
            </div>
        </div>

        <div style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: var(--spacing-lg); margin-bottom: var(--spacing-lg);">
            <h3 style="font-size: 1rem; font-weight: 700; color: var(--text-color); margin: 0 0 var(--spacing-lg) 0; padding-bottom: var(--spacing-sm); border-bottom: 1px solid var(--border-color);">
                <i class="fas fa-file-upload" style="color: var(--text-muted); margin-right: 6px;"></i>
                Documentos
            </h3>
            <div id="documentosContainer"></div>
            <button type="button" id="addDocumento" class="btn btn-outline" style="width: 100%; color: var(--text-muted); border-color: var(--border-color);">
                <i class="fas fa-plus"></i> Agregar Documento
            </button>
        </div>

        <div style="padding-top: var(--spacing-lg); border-top: 1px solid var(--border-color); display: flex; justify-content: flex-end;">
            <button type="submit" class="btn btn-outline" style="color: var(--text-color); border-color: var(--border-color);">
                <i class="fas fa-save"></i> Crear Estudiante
            </button>
        </div>
    </form>

    <script>
        function formatRut(rut) {
            let value = rut.replace(/[^0-9kK]/g, '');
            if (value.length > 1) value = value.substring(0, value.length - 1) + '-' + value.substring(value.length - 1);
            return value.toUpperCase();
        }
        function validateRut(rut) {
            rut = rut.replace(/[^0-9kK]/g, '');
            if (rut.length < 2) return false;
            const rutNum = rut.substring(0, rut.length - 1);
            const dv = rut.substring(rut.length - 1).toUpperCase();
            let suma = 0, multiplo = 2;
            for (let i = rutNum.length - 1; i >= 0; i--) { suma += parseInt(rutNum[i]) * multiplo; multiplo = multiplo < 7 ? multiplo + 1 : 2; }
            let dvCalc = 11 - (suma % 11);
            if (dvCalc === 11) dvCalc = '0'; else if (dvCalc === 10) dvCalc = 'K'; else dvCalc = dvCalc.toString();
            return dv === dvCalc;
        }
        const rutInput = document.getElementById('rut');
        const rutError = document.getElementById('rutError');
        rutInput.addEventListener('input', e => { e.target.value = formatRut(e.target.value); rutError.style.display = e.target.value && !validateRut(e.target.value) ? 'block' : 'none'; });
        const apoderadoRutInput = document.getElementById('apoderado_rut');
        const apoderadoRutError = document.getElementById('apoderadoRutError');
        apoderadoRutInput.addEventListener('input', e => { e.target.value = formatRut(e.target.value); apoderadoRutError.style.display = e.target.value && !validateRut(e.target.value) ? 'block' : 'none'; });
        let documentoIndex = 0;
        document.getElementById('addDocumento').addEventListener('click', function() {
            const container = document.getElementById('documentosContainer');
            const div = document.createElement('div');
            div.style.cssText = 'display: grid; grid-template-columns: 1fr 1fr; gap: var(--spacing-lg); margin-bottom: var(--spacing-md); padding: var(--spacing-md); border: 1px solid var(--border-color); border-radius: var(--radius-md);';
            div.innerHTML = `
                <div class="form-group mb-0">
                    <label class="form-label" style="font-size:0.85rem;color:var(--text-muted);font-weight:600;">TIPO</label>
                    <select name="documentos[${documentoIndex}][tipo]" class="form-select" style="width:100%;border:1px solid var(--border-color);background:var(--bg-card);color:var(--text-color);" required>
                        <option value="">Seleccione tipo...</option>
                        <option value="Carnet de Identidad">Carnet de Identidad</option>
                        <option value="Certificado de Nacimiento">Certificado de Nacimiento</option>
                        <option value="Certificado de Matrícula">Certificado de Matrícula</option>
                        <option value="Informe de Notas">Informe de Notas</option>
                        <option value="Certificado Médico">Certificado Médico</option>
                        <option value="Otro">Otro</option>
                    </select>
                </div>
                <div class="form-group mb-0">
                    <label class="form-label" style="font-size:0.85rem;color:var(--text-muted);font-weight:600;">ARCHIVO <button type="button" class="remove-doc" style="float:right;background:none;border:none;color:var(--error);cursor:pointer;font-size:0.8rem;"><i class="fas fa-trash"></i> Eliminar</button></label>
                    <input type="file" name="documentos[${documentoIndex}][archivo]" class="form-input" style="border:1px solid var(--border-color);background:var(--bg-card);color:var(--text-color);" accept=".pdf,.jpg,.jpeg,.png" required>
                </div>`;
            container.appendChild(div);
            div.querySelector('.remove-doc').addEventListener('click', () => div.remove());
            documentoIndex++;
        });
        document.getElementById('studentForm').addEventListener('submit', function(e) {
            const rutValid = validateRut(rutInput.value);
            const apodValid = validateRut(apoderadoRutInput.value);
            if (!rutValid || !apodValid) {
                e.preventDefault();
                if (!rutValid) rutError.style.display = 'block';
                if (!apodValid) apoderadoRutError.style.display = 'block';
            }
        });
    </script>

    <style>
        @media (max-width: 768px) {
            div[style*="grid-template-columns: 1fr 1fr 1fr"] { grid-template-columns: 1fr !important; }
            div[style*="grid-template-columns: 1fr 1fr"] { grid-template-columns: 1fr !important; }
        }
    </style>
</x-app-layout>