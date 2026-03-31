<x-app-layout>
    <x-slot name="header">
        Nueva Asignatura
    </x-slot>

    <link rel="stylesheet" href="{{ asset('css/shared-index.css') }}?v={{ time() }}">

    <div class="page-header" style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: var(--spacing-lg); gap: var(--spacing-md); flex-wrap: nowrap;">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--text-color); margin: 0;">
                <i class="fas fa-plus-circle" style="color: var(--text-muted); margin-right: 8px;"></i>
                Nueva Asignatura
            </h2>
            <p style="color: var(--text-muted); margin: var(--spacing-xs) 0 0 0; font-size: 0.9375rem;">
                Completa los datos para registrar una nueva asignatura en el sistema.
            </p>
        </div>
        <a href="{{ route('subjects.index') }}" class="btn btn-outline"
            style="color: var(--text-muted); border-color: var(--border-color); flex-shrink: 0;">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <form action="{{ route('subjects.store') }}" method="POST">
        @csrf

        <div style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: var(--spacing-lg); margin-bottom: var(--spacing-lg);">
            <h3 style="font-size: 1rem; font-weight: 700; color: var(--text-color); margin: 0 0 var(--spacing-lg) 0; padding-bottom: var(--spacing-sm); border-bottom: 1px solid var(--border-color);">
                <i class="fas fa-book" style="color: var(--text-muted); margin-right: 6px;"></i>
                Información de la Asignatura
            </h3>

            <div class="form-group">
                <label class="form-label" style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">NOMBRE *</label>
                <div style="position: relative;">
                    <i class="fas fa-signature" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none; z-index: 1;"></i>
                    <input type="text" id="nombre" name="nombre"
                        class="form-input @error('nombre') is-invalid @enderror"
                        style="width: 100%; padding-left: 40px; border: 2px solid var(--border-color); border-radius: var(--radius-lg); background: var(--bg-card); color: var(--text-color);"
                        value="{{ old('nombre') }}" placeholder="Ej: Matemáticas, Lenguaje, Historia..." required
                        onfocus="this.style.borderColor='#84cc16'; this.style.boxShadow='0 0 0 3px rgba(132,204,22,0.1)'"
                        onblur="this.style.borderColor='var(--border-color)'; this.style.boxShadow='none'">
                </div>
                @error('nombre')
                    <span style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">CÓDIGO *</label>
                <div style="position: relative;">
                    <i class="fas fa-hashtag" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none; z-index: 1;"></i>
                    <input type="text" id="codigo" name="codigo"
                        class="form-input @error('codigo') is-invalid @enderror"
                        style="width: 100%; padding-left: 40px; border: 2px solid var(--border-color); border-radius: var(--radius-lg); background: var(--bg-card); color: var(--text-color);"
                        value="{{ old('codigo') }}" placeholder="Ej: MAT-101, LEN-201..." required
                        onfocus="this.style.borderColor='#84cc16'; this.style.boxShadow='0 0 0 3px rgba(132,204,22,0.1)'"
                        onblur="this.style.borderColor='var(--border-color)'; this.style.boxShadow='none'">
                </div>
                @error('codigo')
                    <span style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                @enderror
                <p style="color: var(--text-muted); font-size: 0.8rem; margin: 4px 0 0;"><i class="fas fa-info-circle"></i> Código único de identificación</p>
            </div>

            <div class="form-group mb-0">
                <label class="form-label" style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">DESCRIPCIÓN (OPCIONAL)</label>
                <textarea id="descripcion" name="descripcion"
                    class="form-input @error('descripcion') is-invalid @enderror"
                    style="width: 100%; min-height: 120px; resize: vertical; border: 2px solid var(--border-color); border-radius: var(--radius-lg); background: var(--bg-card); color: var(--text-color);"
                    placeholder="Describe brevemente el contenido y objetivos de la asignatura..."
                    onfocus="this.style.borderColor='#84cc16'; this.style.boxShadow='0 0 0 3px rgba(132,204,22,0.1)'"
                    onblur="this.style.borderColor='var(--border-color)'; this.style.boxShadow='none'">{{ old('descripcion') }}</textarea>
                @error('descripcion')
                    <span style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div style="padding-top: var(--spacing-lg); border-top: 1px solid var(--border-color); display: flex; justify-content: flex-end;">
            <button type="submit" class="btn btn-outline" style="color: var(--text-color); border-color: var(--border-color);">
                <i class="fas fa-save"></i> Crear Asignatura
            </button>
        </div>
    </form>
</x-app-layout>