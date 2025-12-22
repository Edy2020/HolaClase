<x-app-layout>
    <x-slot name="header">
        Nueva Asignatura
    </x-slot>

    <!-- Header -->
    <div class="card" style="margin-bottom: var(--spacing-xl);">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h2
                    style="font-size: 1.5rem; font-weight: 700; color: var(--gray-900); margin-bottom: var(--spacing-xs);">
                    <i class="fas fa-plus-circle" style="color: var(--theme-color);"></i> Crear Nueva Asignatura
                </h2>
                <p style="color: var(--gray-600); margin: 0;">
                    Completa los datos para registrar una nueva asignatura en el sistema
                </p>
            </div>
            <a href="{{ route('subjects.index') }}" class="btn btn-outline">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="card">
        <form action="{{ route('subjects.store') }}" method="POST">
            @csrf

            <div
                style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--spacing-lg); margin-bottom: var(--spacing-xl);">
                <!-- Nombre -->
                <div style="grid-column: 1 / -1;">
                    <label for="nombre"
                        style="display: block; font-weight: 600; color: var(--gray-700); margin-bottom: var(--spacing-sm);">
                        Nombre de la Asignatura <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="text" id="nombre" name="nombre"
                        class="form-input @error('nombre') is-invalid @enderror" style="width: 100%;"
                        value="{{ old('nombre') }}" placeholder="Ej: Matemáticas, Lenguaje, Historia..." required>
                    @error('nombre')
                        <p style="color: #ef4444; font-size: 0.875rem; margin-top: var(--spacing-xs);">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Código -->
                <div>
                    <label for="codigo"
                        style="display: block; font-weight: 600; color: var(--gray-700); margin-bottom: var(--spacing-sm);">
                        Código <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="text" id="codigo" name="codigo"
                        class="form-input @error('codigo') is-invalid @enderror" style="width: 100%;"
                        value="{{ old('codigo') }}" placeholder="Ej: MAT-101, LEN-201..." required>
                    @error('codigo')
                        <p style="color: #ef4444; font-size: 0.875rem; margin-top: var(--spacing-xs);">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </p>
                    @enderror
                    <p style="color: var(--gray-500); font-size: 0.875rem; margin-top: var(--spacing-xs);">
                        <i class="fas fa-info-circle"></i> Código único de identificación
                    </p>
                </div>

                <!-- Descripción -->
                <div style="grid-column: 1 / -1;">
                    <label for="descripcion"
                        style="display: block; font-weight: 600; color: var(--gray-700); margin-bottom: var(--spacing-sm);">
                        Descripción (Opcional)
                    </label>
                    <textarea id="descripcion" name="descripcion"
                        class="form-input @error('descripcion') is-invalid @enderror"
                        style="width: 100%; min-height: 120px; resize: vertical;"
                        placeholder="Describe brevemente el contenido y objetivos de la asignatura...">{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                        <p style="color: #ef4444; font-size: 0.875rem; margin-top: var(--spacing-xs);">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <!-- Info Box -->
            <div
                style="background: var(--primary-50); border-left: 4px solid var(--theme-color); padding: var(--spacing-lg); border-radius: var(--radius-md); margin-bottom: var(--spacing-xl);">
                <h4
                    style="font-weight: 600; color: var(--theme-dark); margin-bottom: var(--spacing-sm); display: flex; align-items: center; gap: var(--spacing-sm);">
                    <i class="fas fa-lightbulb"></i> Consejos
                </h4>
                <ul style="margin: 0; padding-left: var(--spacing-lg); color: var(--gray-700); line-height: 1.8;">
                    <li>El código debe ser único y fácil de recordar</li>
                    <li>Usa un formato consistente para los códigos (ej: MAT-101, MAT-102)</li>
                    <li>La descripción ayuda a los profesores y estudiantes a entender el contenido</li>
                </ul>
            </div>

            <!-- Actions -->
            <div
                style="display: flex; gap: var(--spacing-md); justify-content: flex-end; padding-top: var(--spacing-lg); border-top: 1px solid var(--gray-200);">
                <a href="{{ route('subjects.index') }}" class="btn btn-outline">
                    <i class="fas fa-times"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-primary" style="color: white;">
                    <i class="fas fa-save"></i> Crear Asignatura
                </button>
            </div>
        </form>
    </div>

    <style>
        @media (max-width: 768px) {
            div[style*="grid-template-columns: 1fr 1fr"] {
                grid-template-columns: 1fr !important;
            }
        }
    </style>
</x-app-layout>