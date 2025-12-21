<x-app-layout>
    <x-slot name="header">
        Nuevo Profesor
    </x-slot>

    <div class="card" style="max-width: 900px; margin: 0 auto;">
        <!-- Header -->
        <div style="margin-bottom: var(--spacing-2xl); text-align: center;">
            <div style="width: 80px; height: 80px; margin: 0 auto var(--spacing-md); border-radius: var(--radius-lg); background: linear-gradient(135deg, var(--theme-color), var(--theme-dark)); display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem; box-shadow: var(--shadow-lg);">
                <i class="fas fa-user-plus"></i>
            </div>
            <h2 style="font-size: 1.75rem; font-weight: 700; color: var(--gray-900); margin-bottom: var(--spacing-xs);">
                Registrar Nuevo Profesor
            </h2>
            <p style="color: var(--gray-600); font-size: 1rem;">Complete el formulario para añadir un nuevo docente al sistema.</p>
        </div>

        <form action="{{ route('teachers.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Sección: Información Personal -->
            <div style="margin-bottom: var(--spacing-2xl);">
                <div style="display: flex; align-items: center; gap: var(--spacing-sm); margin-bottom: var(--spacing-lg); padding-bottom: var(--spacing-md); border-bottom: 2px solid var(--gray-200);">
                    <i class="fas fa-user" style="color: var(--theme-color); font-size: 1.25rem;"></i>
                    <h3 style="font-size: 1.125rem; font-weight: 700; color: var(--gray-900); margin: 0;">Información Personal</h3>
                </div>

                <div class="grid grid-cols-2" style="gap: var(--spacing-lg); margin-bottom: var(--spacing-lg);">
                    <div class="form-group mb-0">
                        <label class="form-label">
                            <i class="fas fa-id-card" style="margin-right: var(--spacing-xs); color: var(--theme-color);"></i>
                            RUT <span style="color: #ef4444;">*</span>
                        </label>
                        <input type="text" name="rut" id="rut" class="form-input" value="{{ old('rut') }}" required
                            placeholder="12345678-9" maxlength="12">
                        @error('rut')
                            <span style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label">
                            <i class="fas fa-calendar" style="margin-right: var(--spacing-xs); color: var(--theme-color);"></i>
                            Fecha de Nacimiento
                        </label>
                        <input type="date" name="fecha_nacimiento" class="form-input" value="{{ old('fecha_nacimiento') }}">
                        @error('fecha_nacimiento')
                            <span style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-2" style="gap: var(--spacing-lg); margin-bottom: var(--spacing-lg);">
                    <div class="form-group mb-0">
                        <label class="form-label">
                            <i class="fas fa-user" style="margin-right: var(--spacing-xs); color: var(--theme-color);"></i>
                            Nombre <span style="color: #ef4444;">*</span>
                        </label>
                        <input type="text" name="nombre" class="form-input" value="{{ old('nombre') }}" required
                            placeholder="Ej. Juan">
                        @error('nombre')
                            <span style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label">
                            <i class="fas fa-user" style="margin-right: var(--spacing-xs); color: var(--theme-color);"></i>
                            Apellido <span style="color: #ef4444;">*</span>
                        </label>
                        <input type="text" name="apellido" class="form-input" value="{{ old('apellido') }}" required
                            placeholder="Ej. Pérez">
                        @error('apellido')
                            <span style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Sección: Información de Contacto -->
            <div style="margin-bottom: var(--spacing-2xl);">
                <div style="display: flex; align-items: center; gap: var(--spacing-sm); margin-bottom: var(--spacing-lg); padding-bottom: var(--spacing-md); border-bottom: 2px solid var(--gray-200);">
                    <i class="fas fa-address-book" style="color: var(--theme-color); font-size: 1.25rem;"></i>
                    <h3 style="font-size: 1.125rem; font-weight: 700; color: var(--gray-900); margin: 0;">Información de Contacto</h3>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-envelope" style="margin-right: var(--spacing-xs); color: var(--theme-color);"></i>
                        Email Institucional <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="email" name="email" class="form-input" value="{{ old('email') }}" required
                        placeholder="nombre.apellido@holaclase.edu">
                    @error('email')
                        <span style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-0">
                    <label class="form-label">
                        <i class="fas fa-phone" style="margin-right: var(--spacing-xs); color: var(--theme-color);"></i>
                        Teléfono
                    </label>
                    <input type="text" name="telefono" class="form-input" value="{{ old('telefono') }}"
                        placeholder="+56 9 1234 5678">
                    @error('telefono')
                        <span style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Sección: Información Académica -->
            <div style="margin-bottom: var(--spacing-2xl);">
                <div style="display: flex; align-items: center; gap: var(--spacing-sm); margin-bottom: var(--spacing-lg); padding-bottom: var(--spacing-md); border-bottom: 2px solid var(--gray-200);">
                    <i class="fas fa-graduation-cap" style="color: var(--theme-color); font-size: 1.25rem;"></i>
                    <h3 style="font-size: 1.125rem; font-weight: 700; color: var(--gray-900); margin: 0;">Información Académica</h3>
                </div>

                <div class="grid grid-cols-2" style="gap: var(--spacing-lg); margin-bottom: var(--spacing-lg);">
                    <div class="form-group mb-0">
                        <label class="form-label">
                            <i class="fas fa-layer-group" style="margin-right: var(--spacing-xs); color: var(--theme-color);"></i>
                            Nivel de Enseñanza
                        </label>
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
                            <span style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label">
                            <i class="fas fa-certificate" style="margin-right: var(--spacing-xs); color: var(--theme-color);"></i>
                            Título Profesional
                        </label>
                        <input type="text" name="titulo" class="form-input" value="{{ old('titulo') }}"
                            placeholder="Ej. Licenciado en Educación">
                        @error('titulo')
                            <span style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Sección: Documentación -->
            <div style="margin-bottom: var(--spacing-2xl);">
                <div style="display: flex; align-items: center; gap: var(--spacing-sm); margin-bottom: var(--spacing-lg); padding-bottom: var(--spacing-md); border-bottom: 2px solid var(--gray-200);">
                    <i class="fas fa-file-upload" style="color: var(--theme-color); font-size: 1.25rem;"></i>
                    <h3 style="font-size: 1.125rem; font-weight: 700; color: var(--gray-900); margin: 0;">Documentación</h3>
                </div>

                <div style="padding: var(--spacing-xl); background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: var(--radius-lg); border: 2px dashed var(--gray-300);">
                    <div class="grid grid-cols-2" style="gap: var(--spacing-lg);">
                        <div class="form-group mb-0">
                            <label class="form-label">
                                <i class="fas fa-file-alt" style="margin-right: var(--spacing-xs); color: var(--theme-color);"></i>
                                Tipo de Documento
                            </label>
                            <select name="documento_type" class="form-select">
                                <option value="">Seleccione tipo...</option>
                                <option value="Carnet" {{ old('documento_type') == 'Carnet' ? 'selected' : '' }}>Carnet
                                </option>
                                <option value="Certificado de Nacimiento" {{ old('documento_type') == 'Certificado de Nacimiento' ? 'selected' : '' }}>Certificado de Nacimiento</option>
                                <option value="Certificado de Titulo" {{ old('documento_type') == 'Certificado de Titulo' ? 'selected' : '' }}>Certificado de Título</option>
                                <option value="Certificado de Habilitacion" {{ old('documento_type') == 'Certificado de Habilitacion' ? 'selected' : '' }}>Certificado de Habilitación</option>
                            </select>
                            @error('documento_type')
                                <span style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-0">
                            <label class="form-label">
                                <i class="fas fa-cloud-upload-alt" style="margin-right: var(--spacing-xs); color: var(--theme-color);"></i>
                                Archivo (PDF/Imagen)
                            </label>
                            <input type="file" name="documento_archivo" class="form-input" accept=".pdf,.jpg,.jpeg,.png">
                            @error('documento_archivo')
                                <span style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <p style="margin-top: var(--spacing-md); color: var(--gray-600); font-size: 0.875rem; text-align: center;">
                        <i class="fas fa-info-circle" style="margin-right: var(--spacing-xs);"></i>
                        Formatos aceptados: PDF, JPG, PNG. Tamaño máximo: 5MB
                    </p>
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

            <!-- Botones de Acción -->
            <div class="action-buttons" style="display: flex; gap: var(--spacing-md); justify-content: flex-end; padding-top: var(--spacing-xl); border-top: 2px solid var(--gray-200);">
                <a href="{{ route('teachers.index') }}" class="btn btn-ghost" style="min-width: 120px;">
                    <i class="fas fa-times" style="margin-right: 0.5rem;"></i>
                    Cancelar
                </a>
                <button type="submit" class="btn btn-primary" style="min-width: 180px;">
                    <i class="fas fa-save" style="margin-right: 0.5rem;"></i>
                    Guardar Profesor
                </button>
            </div>
        </form>
    </div>

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

            /* Section headers */
            .card h3 {
                font-size: 1rem !important;
            }

            /* Convert all 2-column grids to single column */
            .grid-cols-2 {
                grid-template-columns: 1fr !important;
                gap: var(--spacing-md) !important;
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