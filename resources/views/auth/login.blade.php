<x-guest-layout>
    <!-- Session Status -->
    @if (session('status'))
        <div style="padding: var(--spacing-md); background: var(--success); color: white; border-radius: var(--radius-md); margin-bottom: var(--spacing-lg); text-align: center; font-weight: 600;">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

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
                autofocus 
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
                autocomplete="current-password"
                placeholder="••••••••"
            >
            @error('password')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="form-group" style="display: flex; align-items: center; gap: var(--spacing-sm);">
            <input 
                id="remember_me" 
                type="checkbox" 
                name="remember"
                style="width: auto; cursor: pointer;"
            >
            <label for="remember_me" style="margin: 0; font-weight: 500; cursor: pointer; color: var(--gray-700);">
                Recordarme
            </label>
        </div>

        <div style="display: flex; flex-direction: column; gap: var(--spacing-md); margin-top: var(--spacing-xl);">
            <button type="submit" class="btn btn-primary btn-lg" style="width: 100%;">
                Iniciar Sesión
            </button>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" style="text-align: center; color: var(--theme-color); text-decoration: none; font-size: 0.875rem; font-weight: 600;">
                    ¿Olvidaste tu contraseña?
                </a>
            @endif

            @if (Route::has('register'))
                <div style="text-align: center; padding-top: var(--spacing-md); border-top: 1px solid var(--gray-200); color: var(--gray-600); font-size: 0.875rem;">
                    ¿No tienes cuenta? 
                    <a href="{{ route('register') }}" style="color: var(--theme-color); text-decoration: none; font-weight: 600;">
                        Regístrate aquí
                    </a>
                </div>
            @endif
        </div>
    </form>
</x-guest-layout>
