<x-app-layout>
    <x-slot name="header">
        Editar Estudiante
    </x-slot>

    <div class="card" style="max-width: 1000px; margin: 0 auto;">
        <!-- Header -->
        <div style="margin-bottom: var(--spacing-2xl); text-align: center;">
            <div
                style="width: 80px; height: 80px; margin: 0 auto var(--spacing-md); border-radius: var(--radius-lg); background: linear-gradient(135deg, var(--theme-color), var(--theme-dark)); display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem; box-shadow: var(--shadow-lg);">
                <i class="fas fa-user-edit"></i>
            </div>
            <h2 style="font-size: 1.75rem; font-weight: 700; color: var(--gray-900); margin-bottom: var(--spacing-xs);">
                Editar Estudiante
            </h2>
            <p style="color: var(--gray-600); font-size: 1rem;">{{ $estudiante->nombre_completo }}</p>
        </div>

        <form action="{{ route('students.update', $estudiante->id) }}" method="POST" enctype="multipart/form-data"
            id="studentForm">
            @csrf
            @method('PATCH')

            <!-- Sección: Información Personal -->
            <div style="margin-bottom: var(--spacing-2xl);">
                <div
                    style="display: flex; align-items: center; gap: var(--spacing-sm); margin-bottom: var(--spacing-lg); padding-bottom: var(--spacing-md); border-bottom: 2px solid var(--gray-200);">
                    <i class="fas fa-user" style="color: var(--theme-color); font-size: 1.25rem;"></i>
                    <h3 style="font-size: 1.125rem; font-weight: 700; color: var(--gray-900); margin: 0;">Información
                        Personal</h3>
                </div>

                <div class="grid grid-cols-3" style="gap: var(--spacing-lg); margin-bottom: var(--spacing-lg);">
                    <div class="form-group mb-0">
                        <label class="form-label">
                            <i class="fas fa-id-card"
                                style="margin-right: var(--spacing-xs); color: var(--theme-color);"></i>
                            RUT <span style="color: #ef4444;">*</span>
                        </label>
                        <input type="text" name="rut" id="rut" class="form-input"
                            value="{{ old('rut', $estudiante->rut) }}" required placeholder="12345678-9" maxlength="12">
                        <small id="rutError" style="color: #ef4444; font-size: 0.875rem; display: none;">RUT
                            inválido</small>
                        @error('rut')
                            <span
                                style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label">
                            <i class="fas fa-user"
                                style="margin-right: var(--spacing-xs); color: var(--theme-color);"></i>
                            Nombre <span style="color: #ef4444;">*</span>
                        </label>
                        <input type="text" name="nombre" class="form-input"
                            value="{{ old('nombre', $estudiante->nombre) }}" required placeholder="Ej. Juan">
                        @error('nombre')
                            <span
                                style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label">
                            <i class="fas fa-user"
                                style="margin-right: var(--spacing-xs); color: var(--theme-color);"></i>
                            Apellido <span style="color: #ef4444;">*</span>
                        </label>
                        <input type="text" name="apellido" class="form-input"
                            value="{{ old('apellido', $estudiante->apellido) }}" required placeholder="Ej. Pérez">
                        @error('apellido')
                            <span
                                style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-3" style="gap: var(--spacing-lg); margin-bottom: var(--spacing-lg);">
                    <div class="form-group mb-0">
                        <label class="form-label">
                            <i class="fas fa-calendar"
                                style="margin-right: var(--spacing-xs); color: var(--theme-color);"></i>
                            Fecha de Nacimiento
                        </label>
                        <input type="date" name="fecha_nacimiento" class="form-input"
                            value="{{ old('fecha_nacimiento', $estudiante->fecha_nacimiento?->format('Y-m-d')) }}">
                        @error('fecha_nacimiento')
                            <span
                                style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label">
                            <i class="fas fa-venus-mars"
                                style="margin-right: var(--spacing-xs); color: var(--theme-color);"></i>
                            Género
                        </label>
                        <select name="genero" class="form-select">
                            <option value="">Seleccione...</option>
                            <option value="Masculino" {{ old('genero', $estudiante->genero) == 'Masculino' ? 'selected' : '' }}>Masculino
                            </option>
                            <option value="Femenino" {{ old('genero', $estudiante->genero) == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                            <option value="Otro" {{ old('genero', $estudiante->genero) == 'Otro' ? 'selected' : '' }}>Otro
                            </option>
                        </select>
                        @error('genero')
                            <span
                                style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label">
                            <i class="fas fa-flag"
                                style="margin-right: var(--spacing-xs); color: var(--theme-color);"></i>
                            Nacionalidad
                        </label>
                        <input type="text" name="nacionalidad" class="form-input"
                            value="{{ old('nacionalidad', $estudiante->nacionalidad ?? 'Chilena') }}"
                            placeholder="Ej. Chilena">
                        @error('nacionalidad')
                            <span
                                style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Sección: Información de Contacto -->
            <div style="margin-bottom: var(--spacing-2xl);">
                <div
                    style="display: flex; align-items: center; gap: var(--spacing-sm); margin-bottom: var(--spacing-lg); padding-bottom: var(--spacing-md); border-bottom: 2px solid var(--gray-200);">
                    <i class="fas fa-address-book" style="color: var(--theme-color); font-size: 1.25rem;"></i>
                    <h3 style="font-size: 1.125rem; font-weight: 700; color: var(--gray-900); margin: 0;">Información de
                        Contacto</h3>
                </div>

                <div class="grid grid-cols-2" style="gap: var(--spacing-lg); margin-bottom: var(--spacing-lg);">
                    <div class="form-group mb-0">
                        <label class="form-label">
                            <i class="fas fa-envelope"
                                style="margin-right: var(--spacing-xs); color: var(--theme-color);"></i>
                            Email
                        </label>
                        <input type="email" name="email" class="form-input"
                            value="{{ old('email', $estudiante->email) }}" placeholder="estudiante@email.com">
                        @error('email')
                            <span
                                style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label">
                            <i class="fas fa-phone"
                                style="margin-right: var(--spacing-xs); color: var(--theme-color);"></i>
                            Teléfono
                        </label>
                        <input type="text" name="telefono" class="form-input"
                            value="{{ old('telefono', $estudiante->telefono) }}" placeholder="+56 9 1234 5678">
                        @error('telefono')
                            <span
                                style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-map-marker-alt"
                            style="margin-right: var(--spacing-xs); color: var(--theme-color);"></i>
                        Dirección
                    </label>
                    <input type="text" name="direccion" class="form-input"
                        value="{{ old('direccion', $estudiante->direccion) }}" placeholder="Calle, número, comuna">
                    @error('direccion')
                        <span
                            style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="grid grid-cols-2" style="gap: var(--spacing-lg);">
                    <div class="form-group mb-0">
                        <label class="form-label">
                            <i class="fas fa-city"
                                style="margin-right: var(--spacing-xs); color: var(--theme-color);"></i>
                            Ciudad
                        </label>
                        <input type="text" name="ciudad" class="form-input"
                            value="{{ old('ciudad', $estudiante->ciudad) }}" placeholder="Ej. Santiago">
                        @error('ciudad')
                            <span
                                style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label">
                            <i class="fas fa-map"
                                style="margin-right: var(--spacing-xs); color: var(--theme-color);"></i>
                            Región
                        </label>
                        <select name="region" class="form-select">
                            <option value="">Seleccione región...</option>
                            <option value="Región Metropolitana" {{ old('region', $estudiante->region) == 'Región Metropolitana' ? 'selected' : '' }}>Región Metropolitana</option>
                            <option value="Región de Valparaíso" {{ old('region', $estudiante->region) == 'Región de Valparaíso' ? 'selected' : '' }}>Región de Valparaíso</option>
                            <option value="Región del Biobío" {{ old('region', $estudiante->region) == 'Región del Biobío' ? 'selected' : '' }}>Región del Biobío</option>
                            <option value="Región de La Araucanía" {{ old('region', $estudiante->region) == 'Región de La Araucanía' ? 'selected' : '' }}>Región de La Araucanía</option>
                            <option value="Región de Los Lagos" {{ old('region', $estudiante->region) == 'Región de Los Lagos' ? 'selected' : '' }}>Región de Los Lagos</option>
                        </select>
                        @error('region')
                            <span
                                style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Sección: Estado del Estudiante -->
            <div style="margin-bottom: var(--spacing-2xl);">
                <div
                    style="display: flex; align-items: center; gap: var(--spacing-sm); margin-bottom: var(--spacing-lg); padding-bottom: var(--spacing-md); border-bottom: 2px solid var(--gray-200);">
                    <i class="fas fa-toggle-on" style="color: var(--theme-color); font-size: 1.25rem;"></i>
                    <h3 style="font-size: 1.125rem; font-weight: 700; color: var(--gray-900); margin: 0;">Estado del
                        Estudiante</h3>
                </div>

                <div class="form-group mb-0">
                    <label class="form-label">
                        <i class="fas fa-info-circle"
                            style="margin-right: var(--spacing-xs); color: var(--theme-color);"></i>
                        Estado <span style="color: #ef4444;">*</span>
                    </label>
                    <select name="estado" class="form-select" required>
                        <option value="activo" {{ old('estado', $estudiante->estado) == 'activo' ? 'selected' : '' }}>
                            Activo</option>
                        <option value="inactivo" {{ old('estado', $estudiante->estado) == 'inactivo' ? 'selected' : '' }}>
                            Inactivo</option>
                        <option value="retirado" {{ old('estado', $estudiante->estado) == 'retirado' ? 'selected' : '' }}>
                            Retirado</option>
                    </select>
                    @error('estado')
                        <span
                            style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Sección: Información del Apoderado -->
            <div style="margin-bottom: var(--spacing-2xl);">
                <div
                    style="display: flex; align-items: center; gap: var(--spacing-sm); margin-bottom: var(--spacing-lg); padding-bottom: var(--spacing-md); border-bottom: 2px solid var(--gray-200);">
                    <i class="fas fa-user-tie" style="color: var(--theme-color); font-size: 1.25rem;"></i>
                    <h3 style="font-size: 1.125rem; font-weight: 700; color: var(--gray-900); margin: 0;">Información
                        del Apoderado</h3>
                </div>

                <div class="grid grid-cols-2" style="gap: var(--spacing-lg); margin-bottom: var(--spacing-lg);">
                    <div class="form-group mb-0">
                        <label class="form-label">
                            <i class="fas fa-id-card"
                                style="margin-right: var(--spacing-xs); color: var(--theme-color);"></i>
                            RUT Apoderado <span style="color: #ef4444;">*</span>
                        </label>
                        <input type="text" name="apoderado_rut" id="apoderado_rut" class="form-input"
                            value="{{ old('apoderado_rut', $estudiante->apoderado->rut ?? '') }}" required
                            placeholder="12345678-9" maxlength="12">
                        <small id="apoderadoRutError" style="color: #ef4444; font-size: 0.875rem; display: none;">RUT
                            inválido</small>
                        @error('apoderado_rut')
                            <span
                                style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label">
                            <i class="fas fa-heart"
                                style="margin-right: var(--spacing-xs); color: var(--theme-color);"></i>
                            Relación <span style="color: #ef4444;">*</span>
                        </label>
                        <select name="apoderado_relacion" class="form-select" required>
                            <option value="">Seleccione...</option>
                            <option value="Padre" {{ old('apoderado_relacion', $estudiante->apoderado->relacion ?? '') == 'Padre' ? 'selected' : '' }}>Padre
                            </option>
                            <option value="Madre" {{ old('apoderado_relacion', $estudiante->apoderado->relacion ?? '') == 'Madre' ? 'selected' : '' }}>Madre
                            </option>
                            <option value="Tutor" {{ old('apoderado_relacion', $estudiante->apoderado->relacion ?? '') == 'Tutor' ? 'selected' : '' }}>Tutor
                            </option>
                            <option value="Abuelo/a" {{ old('apoderado_relacion', $estudiante->apoderado->relacion ?? '') == 'Abuelo/a' ? 'selected' : '' }}>
                                Abuelo/a</option>
                            <option value="Tío/a" {{ old('apoderado_relacion', $estudiante->apoderado->relacion ?? '') == 'Tío/a' ? 'selected' : '' }}>Tío/a
                            </option>
                            <option value="Otro" {{ old('apoderado_relacion', $estudiante->apoderado->relacion ?? '') == 'Otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                        @error('apoderado_relacion')
                            <span
                                style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-2" style="gap: var(--spacing-lg); margin-bottom: var(--spacing-lg);">
                    <div class="form-group mb-0">
                        <label class="form-label">
                            <i class="fas fa-user"
                                style="margin-right: var(--spacing-xs); color: var(--theme-color);"></i>
                            Nombre <span style="color: #ef4444;">*</span>
                        </label>
                        <input type="text" name="apoderado_nombre" class="form-input"
                            value="{{ old('apoderado_nombre', $estudiante->apoderado->nombre ?? '') }}" required
                            placeholder="Ej. María">
                        @error('apoderado_nombre')
                            <span
                                style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label">
                            <i class="fas fa-user"
                                style="margin-right: var(--spacing-xs); color: var(--theme-color);"></i>
                            Apellido <span style="color: #ef4444;">*</span>
                        </label>
                        <input type="text" name="apoderado_apellido" class="form-input"
                            value="{{ old('apoderado_apellido', $estudiante->apoderado->apellido ?? '') }}" required
                            placeholder="Ej. González">
                        @error('apoderado_apellido')
                            <span
                                style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-2" style="gap: var(--spacing-lg); margin-bottom: var(--spacing-lg);">
                    <div class="form-group mb-0">
                        <label class="form-label">
                            <i class="fas fa-envelope"
                                style="margin-right: var(--spacing-xs); color: var(--theme-color);"></i>
                            Email
                        </label>
                        <input type="email" name="apoderado_email" class="form-input"
                            value="{{ old('apoderado_email', $estudiante->apoderado->email ?? '') }}"
                            placeholder="apoderado@email.com">
                        @error('apoderado_email')
                            <span
                                style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label">
                            <i class="fas fa-phone"
                                style="margin-right: var(--spacing-xs); color: var(--theme-color);"></i>
                            Teléfono
                        </label>
                        <input type="text" name="apoderado_telefono" class="form-input"
                            value="{{ old('apoderado_telefono', $estudiante->apoderado->telefono ?? '') }}"
                            placeholder="+56 9 1234 5678">
                        @error('apoderado_telefono')
                            <span
                                style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-2" style="gap: var(--spacing-lg); margin-bottom: var(--spacing-lg);">
                    <div class="form-group mb-0">
                        <label class="form-label">
                            <i class="fas fa-phone-alt"
                                style="margin-right: var(--spacing-xs); color: var(--theme-color);"></i>
                            Teléfono de Emergencia
                        </label>
                        <input type="text" name="apoderado_telefono_emergencia" class="form-input"
                            value="{{ old('apoderado_telefono_emergencia', $estudiante->apoderado->telefono_emergencia ?? '') }}"
                            placeholder="+56 9 8765 4321">
                        @error('apoderado_telefono_emergencia')
                            <span
                                style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label">
                            <i class="fas fa-briefcase"
                                style="margin-right: var(--spacing-xs); color: var(--theme-color);"></i>
                            Ocupación
                        </label>
                        <input type="text" name="apoderado_ocupacion" class="form-input"
                            value="{{ old('apoderado_ocupacion', $estudiante->apoderado->ocupacion ?? '') }}"
                            placeholder="Ej. Ingeniero">
                        @error('apoderado_ocupacion')
                            <span
                                style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-2" style="gap: var(--spacing-lg);">
                    <div class="form-group mb-0">
                        <label class="form-label">
                            <i class="fas fa-building"
                                style="margin-right: var(--spacing-xs); color: var(--theme-color);"></i>
                            Lugar de Trabajo
                        </label>
                        <input type="text" name="apoderado_lugar_trabajo" class="form-input"
                            value="{{ old('apoderado_lugar_trabajo', $estudiante->apoderado->lugar_trabajo ?? '') }}"
                            placeholder="Ej. Empresa XYZ">
                        @error('apoderado_lugar_trabajo')
                            <span
                                style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label">
                            <i class="fas fa-map-marker-alt"
                                style="margin-right: var(--spacing-xs); color: var(--theme-color);"></i>
                            Dirección
                        </label>
                        <input type="text" name="apoderado_direccion" class="form-input"
                            value="{{ old('apoderado_direccion', $estudiante->apoderado->direccion ?? '') }}"
                            placeholder="Calle, número, comuna">
                        @error('apoderado_direccion')
                            <span
                                style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Sección: Documentos Existentes -->
            @if($estudiante->documentos->count() > 0)
                <div style="margin-bottom: var(--spacing-2xl);">
                    <div
                        style="display: flex; align-items: center; gap: var(--spacing-sm); margin-bottom: var(--spacing-lg); padding-bottom: var(--spacing-md); border-bottom: 2px solid var(--gray-200);">
                        <i class="fas fa-file-alt" style="color: var(--theme-color); font-size: 1.25rem;"></i>
                        <h3 style="font-size: 1.125rem; font-weight: 700; color: var(--gray-900); margin: 0;">Documentos
                            Existentes</h3>
                    </div>

                    <div style="display: grid; gap: var(--spacing-md);">
                        @foreach($estudiante->documentos as $documento)
                            <div
                                style="padding: var(--spacing-md); background: var(--gray-50); border-radius: var(--radius-md); border: 1px solid var(--gray-200); display: flex; align-items: center; justify-content: space-between;">
                                <div style="display: flex; align-items: center; gap: var(--spacing-md);">
                                    <i class="fas fa-file-pdf" style="color: var(--theme-color); font-size: 1.5rem;"></i>
                                    <div>
                                        <div style="font-weight: 600; color: var(--gray-900);">{{ $documento->tipo }}</div>
                                        <div style="font-size: 0.875rem; color: var(--gray-600);">
                                            {{ $documento->nombre_original ?? 'Documento' }}</div>
                                        <div style="font-size: 0.75rem; color: var(--gray-500);">Subido:
                                            {{ $documento->fecha_subida?->format('d/m/Y') ?? 'N/A' }}</div>
                                    </div>
                                </div>
                                <a href="{{ Storage::url($documento->ruta_archivo) }}" target="_blank"
                                    class="btn btn-sm btn-outline">
                                    <i class="fas fa-download"></i> Descargar
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Sección: Nuevos Documentos -->
            <div style="margin-bottom: var(--spacing-2xl);">
                <div
                    style="display: flex; align-items: center; gap: var(--spacing-sm); margin-bottom: var(--spacing-lg); padding-bottom: var(--spacing-md); border-bottom: 2px solid var(--gray-200);">
                    <i class="fas fa-file-upload" style="color: var(--theme-color); font-size: 1.25rem;"></i>
                    <h3 style="font-size: 1.125rem; font-weight: 700; color: var(--gray-900); margin: 0;">Agregar Nuevos
                        Documentos
                    </h3>
                </div>

                <div id="documentosContainer">
                    <!-- Document upload fields will be added here dynamically -->
                </div>

                <button type="button" id="addDocumento" class="btn btn-outline" style="width: 100%;">
                    <i class="fas fa-plus"></i> Agregar Documento
                </button>
            </div>

            <!-- Botones de Acción -->
            <div class="action-buttons"
                style="display: flex; gap: var(--spacing-md); justify-content: flex-end; padding-top: var(--spacing-xl); border-top: 2px solid var(--gray-200);">
                <a href="{{ route('students.show', $estudiante->id) }}" class="btn btn-ghost" style="min-width: 120px;">
                    <i class="fas fa-times" style="margin-right: 0.5rem;"></i>
                    Cancelar
                </a>
                <button type="submit" class="btn btn-primary" style="min-width: 180px;">
                    <i class="fas fa-save" style="margin-right: 0.5rem;"></i>
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>

    <script>
        // RUT formatting and validation
        function formatRut(rut) {
            let value = rut.replace(/[^0-9kK]/g, '');
            if (value.length > 1) {
                value = value.substring(0, value.length - 1) + '-' + value.substring(value.length - 1);
            }
            return value.toUpperCase();
        }

        function validateRut(rut) {
            rut = rut.replace(/[^0-9kK]/g, '');
            if (rut.length < 2) return false;

            const rutNum = rut.substring(0, rut.length - 1);
            const dv = rut.substring(rut.length - 1).toUpperCase();

            let suma = 0;
            let multiplo = 2;

            for (let i = rutNum.length - 1; i >= 0; i--) {
                suma += parseInt(rutNum[i]) * multiplo;
                multiplo = multiplo < 7 ? multiplo + 1 : 2;
            }

            let dvCalculado = 11 - (suma % 11);
            if (dvCalculado === 11) dvCalculado = '0';
            else if (dvCalculado === 10) dvCalculado = 'K';
            else dvCalculado = dvCalculado.toString();

            return dv === dvCalculado;
        }

        // Student RUT
        const rutInput = document.getElementById('rut');
        const rutError = document.getElementById('rutError');

        rutInput.addEventListener('input', function (e) {
            e.target.value = formatRut(e.target.value);
            const isValid = validateRut(e.target.value);
            rutError.style.display = e.target.value && !isValid ? 'block' : 'none';
        });

        // Apoderado RUT
        const apoderadoRutInput = document.getElementById('apoderado_rut');
        const apoderadoRutError = document.getElementById('apoderadoRutError');

        apoderadoRutInput.addEventListener('input', function (e) {
            e.target.value = formatRut(e.target.value);
            const isValid = validateRut(e.target.value);
            apoderadoRutError.style.display = e.target.value && !isValid ? 'block' : 'none';
        });

        // Dynamic document upload
        let documentoIndex = 0;

        document.getElementById('addDocumento').addEventListener('click', function () {
            const container = document.getElementById('documentosContainer');
            const documentoDiv = document.createElement('div');
            documentoDiv.className = 'documento-item';
            documentoDiv.style.cssText = 'padding: var(--spacing-lg); background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: var(--radius-lg); border: 2px dashed var(--gray-300); margin-bottom: var(--spacing-md);';

            documentoDiv.innerHTML = `
                <div class="grid grid-cols-2" style="gap: var(--spacing-lg); margin-bottom: var(--spacing-md);">
                    <div class="form-group mb-0">
                        <label class="form-label">
                            <i class="fas fa-file-alt" style="margin-right: var(--spacing-xs); color: var(--theme-color);"></i>
                            Tipo de Documento
                        </label>
                        <select name="nuevos_documentos[${documentoIndex}][tipo]" class="form-select" required>
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
                        <label class="form-label">
                            <i class="fas fa-cloud-upload-alt" style="margin-right: var(--spacing-xs); color: var(--theme-color);"></i>
                            Archivo (PDF/Imagen)
                        </label>
                        <input type="file" name="nuevos_documentos[${documentoIndex}][archivo]" class="form-input" accept=".pdf,.jpg,.jpeg,.png" required>
                    </div>
                </div>
                <button type="button" class="btn btn-ghost btn-sm remove-documento" style="color: var(--error);">
                    <i class="fas fa-trash"></i> Eliminar
                </button>
            `;

            container.appendChild(documentoDiv);
            documentoIndex++;

            // Add remove functionality
            documentoDiv.querySelector('.remove-documento').addEventListener('click', function () {
                documentoDiv.remove();
            });
        });

        // Form validation before submit
        document.getElementById('studentForm').addEventListener('submit', function (e) {
            const rutValid = validateRut(rutInput.value);
            const apoderadoRutValid = validateRut(apoderadoRutInput.value);

            if (!rutValid || !apoderadoRutValid) {
                e.preventDefault();
                if (!rutValid) rutError.style.display = 'block';
                if (!apoderadoRutValid) apoderadoRutError.style.display = 'block';
                alert('Por favor corrija los errores en el formulario antes de continuar.');
            }
        });
    </script>

    <style>
        /* Mobile Responsive Styles */
        @media (max-width: 768px) {
            .card {
                padding: var(--spacing-md) !important;
                margin: 0 !important;
                max-width: 100% !important;
            }

            .card>div:first-child {
                margin-bottom: var(--spacing-lg) !important;
            }

            .card>div:first-child>div:first-child {
                width: 60px !important;
                height: 60px !important;
                font-size: 1.5rem !important;
            }

            .card h2 {
                font-size: 1.25rem !important;
            }

            .card>div:first-child>p {
                font-size: 0.875rem !important;
            }

            .card h3 {
                font-size: 1rem !important;
            }

            .grid-cols-2,
            .grid-cols-3 {
                grid-template-columns: 1fr !important;
                gap: var(--spacing-md) !important;
            }

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