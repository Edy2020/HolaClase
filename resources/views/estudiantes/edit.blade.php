<x-app-layout>
    <x-slot name="header">Editar Estudiante</x-slot>
    <link rel="stylesheet" href="{{ asset('css/shared-index.css') }}?v={{ time() }}">

    <div class="page-header" style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:var(--spacing-lg);gap:var(--spacing-md);flex-wrap:nowrap;">
        <div>
            <h2 style="font-size:1.5rem;font-weight:700;color:var(--text-color);margin:0;">
                <i class="fas fa-user-edit" style="color:var(--text-muted);margin-right:8px;"></i> Editar Estudiante
            </h2>
            <p style="color:var(--text-muted);margin:var(--spacing-xs) 0 0 0;font-size:0.9375rem;">{{ $estudiante->nombre_completo }}</p>
        </div>
        <a href="{{ route('students.show', $estudiante->id) }}" class="btn btn-outline" style="color:var(--text-muted);border-color:var(--border-color);flex-shrink:0;">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <form action="{{ route('students.update', $estudiante->id) }}" method="POST" enctype="multipart/form-data" id="studentForm">
        @csrf
        @method('PATCH')

        <div style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:var(--radius-lg);padding:var(--spacing-lg);margin-bottom:var(--spacing-lg);">
            <h3 style="font-size:1rem;font-weight:700;color:var(--text-color);margin:0 0 var(--spacing-lg) 0;padding-bottom:var(--spacing-sm);border-bottom:1px solid var(--border-color);">
                <i class="fas fa-user" style="color:var(--text-muted);margin-right:6px;"></i> Información Personal
            </h3>
            <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:var(--spacing-lg);">
                <div class="form-group mb-0">
                    <label class="form-label" style="font-size:0.85rem;color:var(--text-muted);font-weight:600;">RUT *</label>
                    <div style="position:relative;"><i class="fas fa-id-card" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--text-muted);pointer-events:none;z-index:1;"></i>
                        <input type="text" name="rut" id="rut" class="form-input" style="width:100%;padding-left:40px;border:1px solid var(--border-color);background:var(--bg-card);color:var(--text-color);" value="{{ old('rut', $estudiante->rut) }}" required placeholder="12345678-9" maxlength="12">
                    </div>
                    <small id="rutError" style="color:var(--error);font-size:0.875rem;display:none;">RUT inválido</small>
                    @error('rut')<span style="color:var(--error);font-size:0.875rem;display:block;margin-top:4px;">{{ $message }}</span>@enderror
                </div>
                <div class="form-group mb-0">
                    <label class="form-label" style="font-size:0.85rem;color:var(--text-muted);font-weight:600;">NOMBRE *</label>
                    <div style="position:relative;"><i class="fas fa-user" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--text-muted);pointer-events:none;z-index:1;"></i>
                        <input type="text" name="nombre" class="form-input" style="width:100%;padding-left:40px;border:1px solid var(--border-color);background:var(--bg-card);color:var(--text-color);" value="{{ old('nombre', $estudiante->nombre) }}" required placeholder="Ej. Juan">
                    </div>
                    @error('nombre')<span style="color:var(--error);font-size:0.875rem;display:block;margin-top:4px;">{{ $message }}</span>@enderror
                </div>
                <div class="form-group mb-0">
                    <label class="form-label" style="font-size:0.85rem;color:var(--text-muted);font-weight:600;">APELLIDO *</label>
                    <div style="position:relative;"><i class="fas fa-user" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--text-muted);pointer-events:none;z-index:1;"></i>
                        <input type="text" name="apellido" class="form-input" style="width:100%;padding-left:40px;border:1px solid var(--border-color);background:var(--bg-card);color:var(--text-color);" value="{{ old('apellido', $estudiante->apellido) }}" required placeholder="Ej. Pérez">
                    </div>
                    @error('apellido')<span style="color:var(--error);font-size:0.875rem;display:block;margin-top:4px;">{{ $message }}</span>@enderror
                </div>
                <div class="form-group mb-0">
                    <label class="form-label" style="font-size:0.85rem;color:var(--text-muted);font-weight:600;">FECHA NACIMIENTO</label>
                    <div style="position:relative;"><i class="fas fa-calendar" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--text-muted);pointer-events:none;z-index:1;"></i>
                        <input type="date" name="fecha_nacimiento" class="form-input" style="width:100%;padding-left:40px;border:1px solid var(--border-color);background:var(--bg-card);color:var(--text-color);" value="{{ old('fecha_nacimiento', $estudiante->fecha_nacimiento?->format('Y-m-d')) }}">
                    </div>
                    @error('fecha_nacimiento')<span style="color:var(--error);font-size:0.875rem;display:block;margin-top:4px;">{{ $message }}</span>@enderror
                </div>
                <div class="form-group mb-0">
                    <label class="form-label" style="font-size:0.85rem;color:var(--text-muted);font-weight:600;">GÉNERO</label>
                    <select name="genero" class="form-select" style="width:100%;border:1px solid var(--border-color);background:var(--bg-card);color:var(--text-color);">
                        <option value="">Seleccione...</option>
                        <option value="Masculino" {{ old('genero', $estudiante->genero) == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                        <option value="Femenino" {{ old('genero', $estudiante->genero) == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                        <option value="Otro" {{ old('genero', $estudiante->genero) == 'Otro' ? 'selected' : '' }}>Otro</option>
                    </select>
                </div>
                <div class="form-group mb-0">
                    <label class="form-label" style="font-size:0.85rem;color:var(--text-muted);font-weight:600;">NACIONALIDAD</label>
                    <div style="position:relative;"><i class="fas fa-flag" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--text-muted);pointer-events:none;z-index:1;"></i>
                        <input type="text" name="nacionalidad" class="form-input" style="width:100%;padding-left:40px;border:1px solid var(--border-color);background:var(--bg-card);color:var(--text-color);" value="{{ old('nacionalidad', $estudiante->nacionalidad ?? 'Chilena') }}" placeholder="Ej. Chilena">
                    </div>
                </div>
            </div>
        </div>

        <div style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:var(--radius-lg);padding:var(--spacing-lg);margin-bottom:var(--spacing-lg);">
            <h3 style="font-size:1rem;font-weight:700;color:var(--text-color);margin:0 0 var(--spacing-lg) 0;padding-bottom:var(--spacing-sm);border-bottom:1px solid var(--border-color);">
                <i class="fas fa-toggle-on" style="color:var(--text-muted);margin-right:6px;"></i> Estado
            </h3>
            <div class="form-group mb-0">
                <label class="form-label" style="font-size:0.85rem;color:var(--text-muted);font-weight:600;">ESTADO *</label>
                <select name="estado" class="form-select" style="width:100%;max-width:300px;border:1px solid var(--border-color);background:var(--bg-card);color:var(--text-color);" required>
                    <option value="activo" {{ old('estado', $estudiante->estado) == 'activo' ? 'selected' : '' }}>Activo</option>
                    <option value="inactivo" {{ old('estado', $estudiante->estado) == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                    <option value="retirado" {{ old('estado', $estudiante->estado) == 'retirado' ? 'selected' : '' }}>Retirado</option>
                </select>
            </div>
        </div>

        <div style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:var(--radius-lg);padding:var(--spacing-lg);margin-bottom:var(--spacing-lg);">
            <h3 style="font-size:1rem;font-weight:700;color:var(--text-color);margin:0 0 var(--spacing-lg) 0;padding-bottom:var(--spacing-sm);border-bottom:1px solid var(--border-color);">
                <i class="fas fa-address-book" style="color:var(--text-muted);margin-right:6px;"></i> Contacto
            </h3>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:var(--spacing-lg);">
                <div class="form-group mb-0">
                    <label class="form-label" style="font-size:0.85rem;color:var(--text-muted);font-weight:600;">EMAIL</label>
                    <div style="position:relative;"><i class="fas fa-envelope" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--text-muted);pointer-events:none;z-index:1;"></i>
                        <input type="email" name="email" class="form-input" style="width:100%;padding-left:40px;border:1px solid var(--border-color);background:var(--bg-card);color:var(--text-color);" value="{{ old('email', $estudiante->email) }}" placeholder="estudiante@email.com">
                    </div>
                </div>
                <div class="form-group mb-0">
                    <label class="form-label" style="font-size:0.85rem;color:var(--text-muted);font-weight:600;">TELÉFONO</label>
                    <div style="position:relative;"><i class="fas fa-phone" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--text-muted);pointer-events:none;z-index:1;"></i>
                        <input type="text" name="telefono" class="form-input" style="width:100%;padding-left:40px;border:1px solid var(--border-color);background:var(--bg-card);color:var(--text-color);" value="{{ old('telefono', $estudiante->telefono) }}" placeholder="+56 9 1234 5678">
                    </div>
                </div>
                <div class="form-group mb-0">
                    <label class="form-label" style="font-size:0.85rem;color:var(--text-muted);font-weight:600;">DIRECCIÓN</label>
                    <div style="position:relative;"><i class="fas fa-map-marker-alt" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--text-muted);pointer-events:none;z-index:1;"></i>
                        <input type="text" name="direccion" class="form-input" style="width:100%;padding-left:40px;border:1px solid var(--border-color);background:var(--bg-card);color:var(--text-color);" value="{{ old('direccion', $estudiante->direccion) }}" placeholder="Calle, número, comuna">
                    </div>
                </div>
                <div class="form-group mb-0">
                    <label class="form-label" style="font-size:0.85rem;color:var(--text-muted);font-weight:600;">CIUDAD</label>
                    <div style="position:relative;"><i class="fas fa-city" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--text-muted);pointer-events:none;z-index:1;"></i>
                        <input type="text" name="ciudad" class="form-input" style="width:100%;padding-left:40px;border:1px solid var(--border-color);background:var(--bg-card);color:var(--text-color);" value="{{ old('ciudad', $estudiante->ciudad) }}" placeholder="Ej. Santiago">
                    </div>
                </div>
                <div class="form-group mb-0" style="grid-column:1/-1;">
                    <label class="form-label" style="font-size:0.85rem;color:var(--text-muted);font-weight:600;">REGIÓN</label>
                    <select name="region" class="form-select" style="width:100%;border:1px solid var(--border-color);background:var(--bg-card);color:var(--text-color);">
                        <option value="">Seleccione región...</option>
                        <option value="Región Metropolitana" {{ old('region', $estudiante->region) == 'Región Metropolitana' ? 'selected' : '' }}>Región Metropolitana</option>
                        <option value="Región de Valparaíso" {{ old('region', $estudiante->region) == 'Región de Valparaíso' ? 'selected' : '' }}>Región de Valparaíso</option>
                        <option value="Región del Biobío" {{ old('region', $estudiante->region) == 'Región del Biobío' ? 'selected' : '' }}>Región del Biobío</option>
                        <option value="Región de La Araucanía" {{ old('region', $estudiante->region) == 'Región de La Araucanía' ? 'selected' : '' }}>Región de La Araucanía</option>
                        <option value="Región de Los Lagos" {{ old('region', $estudiante->region) == 'Región de Los Lagos' ? 'selected' : '' }}>Región de Los Lagos</option>
                    </select>
                </div>
            </div>
        </div>

        <div style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:var(--radius-lg);padding:var(--spacing-lg);margin-bottom:var(--spacing-lg);">
            <h3 style="font-size:1rem;font-weight:700;color:var(--text-color);margin:0 0 var(--spacing-lg) 0;padding-bottom:var(--spacing-sm);border-bottom:1px solid var(--border-color);">
                <i class="fas fa-user-tie" style="color:var(--text-muted);margin-right:6px;"></i> Apoderado
            </h3>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:var(--spacing-lg);">
                <div class="form-group mb-0">
                    <label class="form-label" style="font-size:0.85rem;color:var(--text-muted);font-weight:600;">RUT APODERADO *</label>
                    <div style="position:relative;"><i class="fas fa-id-card" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--text-muted);pointer-events:none;z-index:1;"></i>
                        <input type="text" name="apoderado_rut" id="apoderado_rut" class="form-input" style="width:100%;padding-left:40px;border:1px solid var(--border-color);background:var(--bg-card);color:var(--text-color);" value="{{ old('apoderado_rut', $estudiante->apoderado->rut ?? '') }}" required placeholder="12345678-9" maxlength="12">
                    </div>
                    <small id="apoderadoRutError" style="color:var(--error);font-size:0.875rem;display:none;">RUT inválido</small>
                </div>
                <div class="form-group mb-0">
                    <label class="form-label" style="font-size:0.85rem;color:var(--text-muted);font-weight:600;">RELACIÓN *</label>
                    <select name="apoderado_relacion" class="form-select" style="width:100%;border:1px solid var(--border-color);background:var(--bg-card);color:var(--text-color);" required>
                        <option value="">Seleccione...</option>
                        @foreach(['Padre','Madre','Tutor','Abuelo/a','Tío/a','Otro'] as $rel)
                            <option value="{{ $rel }}" {{ old('apoderado_relacion', $estudiante->apoderado->relacion ?? '') == $rel ? 'selected' : '' }}>{{ $rel }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-0">
                    <label class="form-label" style="font-size:0.85rem;color:var(--text-muted);font-weight:600;">NOMBRE *</label>
                    <div style="position:relative;"><i class="fas fa-user" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--text-muted);pointer-events:none;z-index:1;"></i>
                        <input type="text" name="apoderado_nombre" class="form-input" style="width:100%;padding-left:40px;border:1px solid var(--border-color);background:var(--bg-card);color:var(--text-color);" value="{{ old('apoderado_nombre', $estudiante->apoderado->nombre ?? '') }}" required placeholder="Ej. María">
                    </div>
                </div>
                <div class="form-group mb-0">
                    <label class="form-label" style="font-size:0.85rem;color:var(--text-muted);font-weight:600;">APELLIDO *</label>
                    <div style="position:relative;"><i class="fas fa-user" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--text-muted);pointer-events:none;z-index:1;"></i>
                        <input type="text" name="apoderado_apellido" class="form-input" style="width:100%;padding-left:40px;border:1px solid var(--border-color);background:var(--bg-card);color:var(--text-color);" value="{{ old('apoderado_apellido', $estudiante->apoderado->apellido ?? '') }}" required placeholder="Ej. González">
                    </div>
                </div>
                <div class="form-group mb-0">
                    <label class="form-label" style="font-size:0.85rem;color:var(--text-muted);font-weight:600;">EMAIL</label>
                    <div style="position:relative;"><i class="fas fa-envelope" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--text-muted);pointer-events:none;z-index:1;"></i>
                        <input type="email" name="apoderado_email" class="form-input" style="width:100%;padding-left:40px;border:1px solid var(--border-color);background:var(--bg-card);color:var(--text-color);" value="{{ old('apoderado_email', $estudiante->apoderado->email ?? '') }}" placeholder="apoderado@email.com">
                    </div>
                </div>
                <div class="form-group mb-0">
                    <label class="form-label" style="font-size:0.85rem;color:var(--text-muted);font-weight:600;">TELÉFONO</label>
                    <div style="position:relative;"><i class="fas fa-phone" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--text-muted);pointer-events:none;z-index:1;"></i>
                        <input type="text" name="apoderado_telefono" class="form-input" style="width:100%;padding-left:40px;border:1px solid var(--border-color);background:var(--bg-card);color:var(--text-color);" value="{{ old('apoderado_telefono', $estudiante->apoderado->telefono ?? '') }}" placeholder="+56 9 1234 5678">
                    </div>
                </div>
                <div class="form-group mb-0">
                    <label class="form-label" style="font-size:0.85rem;color:var(--text-muted);font-weight:600;">TEL. EMERGENCIA</label>
                    <div style="position:relative;"><i class="fas fa-phone-alt" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--text-muted);pointer-events:none;z-index:1;"></i>
                        <input type="text" name="apoderado_telefono_emergencia" class="form-input" style="width:100%;padding-left:40px;border:1px solid var(--border-color);background:var(--bg-card);color:var(--text-color);" value="{{ old('apoderado_telefono_emergencia', $estudiante->apoderado->telefono_emergencia ?? '') }}" placeholder="+56 9 8765 4321">
                    </div>
                </div>
                <div class="form-group mb-0">
                    <label class="form-label" style="font-size:0.85rem;color:var(--text-muted);font-weight:600;">OCUPACIÓN</label>
                    <div style="position:relative;"><i class="fas fa-briefcase" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--text-muted);pointer-events:none;z-index:1;"></i>
                        <input type="text" name="apoderado_ocupacion" class="form-input" style="width:100%;padding-left:40px;border:1px solid var(--border-color);background:var(--bg-card);color:var(--text-color);" value="{{ old('apoderado_ocupacion', $estudiante->apoderado->ocupacion ?? '') }}" placeholder="Ej. Ingeniero">
                    </div>
                </div>
                <div class="form-group mb-0">
                    <label class="form-label" style="font-size:0.85rem;color:var(--text-muted);font-weight:600;">LUGAR DE TRABAJO</label>
                    <div style="position:relative;"><i class="fas fa-building" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--text-muted);pointer-events:none;z-index:1;"></i>
                        <input type="text" name="apoderado_lugar_trabajo" class="form-input" style="width:100%;padding-left:40px;border:1px solid var(--border-color);background:var(--bg-card);color:var(--text-color);" value="{{ old('apoderado_lugar_trabajo', $estudiante->apoderado->lugar_trabajo ?? '') }}" placeholder="Ej. Empresa XYZ">
                    </div>
                </div>
                <div class="form-group mb-0">
                    <label class="form-label" style="font-size:0.85rem;color:var(--text-muted);font-weight:600;">DIRECCIÓN APODERADO</label>
                    <div style="position:relative;"><i class="fas fa-map-marker-alt" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--text-muted);pointer-events:none;z-index:1;"></i>
                        <input type="text" name="apoderado_direccion" class="form-input" style="width:100%;padding-left:40px;border:1px solid var(--border-color);background:var(--bg-card);color:var(--text-color);" value="{{ old('apoderado_direccion', $estudiante->apoderado->direccion ?? '') }}" placeholder="Calle, número, comuna">
                    </div>
                </div>
            </div>
        </div>

        @if($estudiante->documentos->count() > 0)
        <div style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:var(--radius-lg);padding:var(--spacing-lg);margin-bottom:var(--spacing-lg);">
            <h3 style="font-size:1rem;font-weight:700;color:var(--text-color);margin:0 0 var(--spacing-lg) 0;padding-bottom:var(--spacing-sm);border-bottom:1px solid var(--border-color);">
                <i class="fas fa-file-alt" style="color:var(--text-muted);margin-right:6px;"></i> Documentos Existentes
            </h3>
            <div style="border:1px solid var(--border-color);border-radius:var(--radius-md);overflow:hidden;">
                @foreach($estudiante->documentos as $documento)
                    <div style="display:flex;align-items:center;justify-content:space-between;padding:var(--spacing-md);{{ !$loop->last ? 'border-bottom:1px solid var(--border-color);' : '' }}">
                        <div style="display:flex;align-items:center;gap:var(--spacing-md);">
                            <div style="width:36px;height:36px;border-radius:var(--radius-md);border:1px solid var(--border-color);display:flex;align-items:center;justify-content:center;color:var(--text-muted);flex-shrink:0;"><i class="fas fa-file-pdf"></i></div>
                            <div>
                                <div style="font-weight:600;color:var(--text-color);font-size:0.9rem;">{{ $documento->tipo }}</div>
                                <div style="font-size:0.75rem;color:var(--text-muted);">{{ $documento->fecha_subida?->format('d/m/Y') ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <a href="{{ Storage::url($documento->ruta_archivo) }}" target="_blank" class="btn btn-sm btn-outline" style="color:var(--text-color);border-color:var(--border-color);">
                            <i class="fas fa-download"></i> Descargar
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <div style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:var(--radius-lg);padding:var(--spacing-lg);margin-bottom:var(--spacing-lg);">
            <h3 style="font-size:1rem;font-weight:700;color:var(--text-color);margin:0 0 var(--spacing-lg) 0;padding-bottom:var(--spacing-sm);border-bottom:1px solid var(--border-color);">
                <i class="fas fa-file-upload" style="color:var(--text-muted);margin-right:6px;"></i> Agregar Documentos
            </h3>
            <div id="documentosContainer"></div>
            <button type="button" id="addDocumento" class="btn btn-outline" style="width:100%;color:var(--text-muted);border-color:var(--border-color);">
                <i class="fas fa-plus"></i> Agregar Documento
            </button>
        </div>

        <div style="padding-top:var(--spacing-lg);border-top:1px solid var(--border-color);display:flex;justify-content:flex-end;">
            <button type="submit" class="btn btn-outline" style="color:var(--text-color);border-color:var(--border-color);">
                <i class="fas fa-save"></i> Guardar Cambios
            </button>
        </div>
    </form>

    <script>
        function formatRut(rut) { let v=rut.replace(/[^0-9kK]/g,''); if(v.length>1)v=v.substring(0,v.length-1)+'-'+v.substring(v.length-1); return v.toUpperCase(); }
        function validateRut(rut) { rut=rut.replace(/[^0-9kK]/g,''); if(rut.length<2)return false; const n=rut.substring(0,rut.length-1),d=rut.substring(rut.length-1).toUpperCase(); let s=0,m=2; for(let i=n.length-1;i>=0;i--){s+=parseInt(n[i])*m;m=m<7?m+1:2;} let c=11-(s%11); if(c===11)c='0';else if(c===10)c='K';else c=c.toString(); return d===c; }
        const ri=document.getElementById('rut'),re=document.getElementById('rutError');
        ri.addEventListener('input',e=>{e.target.value=formatRut(e.target.value);re.style.display=e.target.value&&!validateRut(e.target.value)?'block':'none';});
        const ai=document.getElementById('apoderado_rut'),ae=document.getElementById('apoderadoRutError');
        ai.addEventListener('input',e=>{e.target.value=formatRut(e.target.value);ae.style.display=e.target.value&&!validateRut(e.target.value)?'block':'none';});
        let idx=0;
        document.getElementById('addDocumento').addEventListener('click',function(){
            const c=document.getElementById('documentosContainer'),d=document.createElement('div');
            d.style.cssText='display:grid;grid-template-columns:1fr 1fr;gap:var(--spacing-lg);margin-bottom:var(--spacing-md);padding:var(--spacing-md);border:1px solid var(--border-color);border-radius:var(--radius-md);';
            d.innerHTML=`<div class="form-group mb-0"><label class="form-label" style="font-size:0.85rem;color:var(--text-muted);font-weight:600;">TIPO</label><select name="nuevos_documentos[${idx}][tipo]" class="form-select" style="width:100%;border:1px solid var(--border-color);background:var(--bg-card);color:var(--text-color);" required><option value="">Seleccione...</option><option>Carnet de Identidad</option><option>Certificado de Nacimiento</option><option>Certificado de Matrícula</option><option>Informe de Notas</option><option>Certificado Médico</option><option>Otro</option></select></div><div class="form-group mb-0"><label class="form-label" style="font-size:0.85rem;color:var(--text-muted);font-weight:600;">ARCHIVO <button type="button" class="rm" style="float:right;background:none;border:none;color:var(--error);cursor:pointer;font-size:0.8rem;"><i class="fas fa-trash"></i></button></label><input type="file" name="nuevos_documentos[${idx}][archivo]" class="form-input" style="border:1px solid var(--border-color);background:var(--bg-card);color:var(--text-color);" accept=".pdf,.jpg,.jpeg,.png" required></div>`;
            c.appendChild(d); d.querySelector('.rm').addEventListener('click',()=>d.remove()); idx++;
        });
        document.getElementById('studentForm').addEventListener('submit',function(e){
            if(!validateRut(ri.value)||!validateRut(ai.value)){e.preventDefault();if(!validateRut(ri.value))re.style.display='block';if(!validateRut(ai.value))ae.style.display='block';}
        });
    </script>
    <style>
        @media(max-width:768px){div[style*="grid-template-columns:1fr 1fr 1fr"]{grid-template-columns:1fr!important;}div[style*="grid-template-columns:1fr 1fr"]{grid-template-columns:1fr!important;}}
    </style>
</x-app-layout>