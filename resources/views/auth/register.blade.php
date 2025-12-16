<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="form-group">
            <label for="name" class="form-label">Nombre Completo</label>
            <input 
                id="name" 
                class="form-input" 
                type="text" 
                name="name" 
                value="{{ old('name') }}" 
                required 
                autofocus 
                autocomplete="name"
                placeholder="Juan Pérez"
            >
            @error('name')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="form-group">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input 
                id="email" 
                class="form-input" 
                type="email" 
                name="email" 
                value="{{ old('email') }}" 
                required 
                autocomplete="username"
                placeholder="tu@email.com"
            >
            @error('email')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password" class="form-label">Contraseña</label>
            <input 
                id="password" 
                class="form-input" 
                type="password" 
                name="password" 
                required 
                autocomplete="new-password"
                placeholder="Mínimo 8 caracteres"
            >
            @error('password')
                <div class="form-error">{{ $message }}</div>
            @enderror
            <div class="form-help">Debe tener al menos 8 caracteres</div>
        </div>

        <!-- Confirm Password -->
        <div class="form-group">
            <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
            <input 
                id="password_confirmation" 
                class="form-input" 
                type="password" 
                name="password_confirmation" 
                required 
                autocomplete="new-password"
                placeholder="Repite tu contraseña"
            >
            @error('password_confirmation')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <div style="display: flex; flex-direction: column; gap: var(--spacing-md); margin-top: var(--spacing-xl);">
            <button type="submit" class="btn btn-primary btn-lg" style="width: 100%;">
                Crear Cuenta
            </button>

            <div style="text-align: center; padding-top: var(--spacing-md); border-top: 1px solid var(--gray-200); color: var(--gray-600); font-size: 0.875rem;">
                ¿Ya tienes cuenta? 
                <a href="{{ route('login') }}" style="color: var(--theme-color); text-decoration: none; font-weight: 600;">
                    Inicia sesión aquí
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>
