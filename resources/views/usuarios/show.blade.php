<x-app-layout>
    <x-slot name="header">
        Usuario - {{ $user->name }}
    </x-slot>

    <link rel="stylesheet" href="{{ asset('css/shared-index.css') }}?v={{ time() }}">

    @if(session('success'))
        <div id="successMessage"
            style="background: var(--success); color: white; padding: var(--spacing-md); border-radius: var(--radius-md); margin-bottom: var(--spacing-lg);">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
        <script>
            setTimeout(() => {
                const m = document.getElementById('successMessage');
                if (m) { m.style.opacity = '0'; setTimeout(() => m.style.display = 'none', 500); }
            }, 3000);
        </script>
    @endif

    @if(session('error'))
        <div id="errorMessage"
            style="background: var(--error); color: white; padding: var(--spacing-md); border-radius: var(--radius-md); margin-bottom: var(--spacing-lg);">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
        <script>
            setTimeout(() => {
                const m = document.getElementById('errorMessage');
                if (m) { m.style.opacity = '0'; setTimeout(() => m.style.display = 'none', 500); }
            }, 4000);
        </script>
    @endif

    <div class="page-header"
        style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-lg); flex-wrap: wrap; gap: var(--spacing-md);">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--text-color); margin: 0;">
                {{ $user->name }}
            </h2>
            <p style="color: var(--text-muted); margin: var(--spacing-xs) 0 0 0; font-size: 0.9375rem;">
                <i class="fas fa-shield-alt"></i> {{ ucfirst($user->role) }}
                @if($user->profesor)
                    &middot; <i class="fas fa-chalkboard-teacher"></i> Profesor vinculado
                @endif
            </p>
        </div>
        <div style="display: flex; gap: var(--spacing-sm); flex-wrap: wrap;">
            @if($user->id !== auth()->id())
                <form action="{{ route('users.revoke-access', $user) }}" method="POST" onsubmit="return confirm('¿Revocar acceso de {{ $user->name }}?');">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-outline" style="color: var(--error); border-color: var(--error);">
                        <i class="fas fa-ban"></i> Revocar
                    </button>
                </form>
            @endif
            <a href="{{ route('users.index') }}" class="btn btn-outline" style="color: var(--text-muted); border-color: var(--border-color);">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--spacing-lg);" class="show-grid">

        <div style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: var(--spacing-lg);">
            <h3 style="font-size: 1rem; font-weight: 700; color: var(--text-color); margin: 0 0 var(--spacing-lg) 0; padding-bottom: var(--spacing-sm); border-bottom: 1px solid var(--border-color); display: flex; align-items: center; gap: var(--spacing-sm);">
                <i class="fas fa-user" style="color: var(--text-muted);"></i> Información de Acceso
            </h3>

            <div style="margin-bottom: var(--spacing-md);">
                <label style="display: block; font-weight: 600; color: var(--text-muted); font-size: 0.8rem; margin-bottom: 4px;">NOMBRE</label>
                <p style="color: var(--text-color); margin: 0; font-size: 0.9375rem; font-weight: 500;">{{ $user->name }}</p>
            </div>

            <div style="margin-bottom: var(--spacing-md);">
                <label style="display: block; font-weight: 600; color: var(--text-muted); font-size: 0.8rem; margin-bottom: 4px;">EMAIL DEL SISTEMA</label>
                <p style="color: var(--text-color); margin: 0; font-size: 0.9375rem; font-weight: 500;">{{ $user->email }}</p>
            </div>

            <div style="margin-bottom: var(--spacing-md);">
                <label style="display: block; font-weight: 600; color: var(--text-muted); font-size: 0.8rem; margin-bottom: 4px;">ROL</label>
                <span style="display: inline-block; padding: 0.25rem 0.625rem; font-size: 0.75rem; font-weight: 700; color: {{ $user->role === 'admin' ? '#a855f7' : '#3b82f6' }}; background: {{ $user->role === 'admin' ? 'rgba(168, 85, 247, 0.1)' : 'rgba(59, 130, 246, 0.1)' }}; border-radius: 9999px; text-transform: capitalize;">
                    {{ $user->role }}
                </span>
            </div>

            <div style="margin-bottom: var(--spacing-md);">
                <label style="display: block; font-weight: 600; color: var(--text-muted); font-size: 0.8rem; margin-bottom: 4px;">CONTRASEÑA</label>
                <div style="display: flex; align-items: center; gap: var(--spacing-sm);">
                    <div style="flex: 1; padding: var(--spacing-sm); background: var(--gray-50); border: 1px solid var(--border-color); border-radius: var(--radius-md); font-family: monospace; font-size: 0.9375rem; color: var(--text-color);">
                        <span id="passwordText">{{ $user->plain_password ? str_repeat('•', strlen($user->plain_password)) : 'No disponible' }}</span>
                        <span id="passwordPlain" style="display: none;">{{ $user->plain_password ?? 'N/A' }}</span>
                    </div>
                    @if($user->plain_password)
                        <button type="button" onclick="togglePassword()" style="background: none; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: var(--spacing-sm); cursor: pointer; color: var(--text-muted); width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-eye" id="passwordIcon"></i>
                        </button>
                    @endif
                </div>
            </div>

            <div>
                <label style="display: block; font-weight: 600; color: var(--text-muted); font-size: 0.8rem; margin-bottom: 4px;">CREADO</label>
                <p style="color: var(--text-muted); margin: 0; font-size: 0.875rem;">{{ $user->created_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        <div style="display: flex; flex-direction: column; gap: var(--spacing-lg);">

            <div style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: var(--spacing-lg);">
                <h3 style="font-size: 1rem; font-weight: 700; color: var(--text-color); margin: 0 0 var(--spacing-lg) 0; padding-bottom: var(--spacing-sm); border-bottom: 1px solid var(--border-color); display: flex; align-items: center; gap: var(--spacing-sm);">
                    <i class="fas fa-key" style="color: var(--text-muted);"></i> Cambiar Contraseña
                </h3>
                <form action="{{ route('users.update-password', $user) }}" method="POST">
                    @csrf @method('PATCH')
                    <div style="margin-bottom: var(--spacing-md);">
                        <label style="display: block; font-weight: 600; color: var(--text-muted); font-size: 0.85rem; margin-bottom: var(--spacing-xs);">NUEVA CONTRASEÑA</label>
                        <input type="text" name="password" class="form-input" placeholder="Mínimo 6 caracteres" style="width: 100%;" minlength="6" required>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width: 100%; color: white;">
                        <i class="fas fa-save"></i> Actualizar Contraseña
                    </button>
                </form>
            </div>

            <div style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: var(--spacing-lg);">
                <h3 style="font-size: 1rem; font-weight: 700; color: var(--text-color); margin: 0 0 var(--spacing-lg) 0; padding-bottom: var(--spacing-sm); border-bottom: 1px solid var(--border-color); display: flex; align-items: center; gap: var(--spacing-sm);">
                    <i class="fas fa-envelope" style="color: var(--text-muted);"></i> Notificar al Usuario
                </h3>
                <p style="color: var(--text-muted); font-size: 0.8rem; margin: 0 0 var(--spacing-md);">
                    Envía las credenciales de acceso al correo personal del usuario.
                </p>
                <form action="{{ route('users.notify', $user) }}" method="POST">
                    @csrf
                    <div style="margin-bottom: var(--spacing-md);">
                        <label style="display: block; font-weight: 600; color: var(--text-muted); font-size: 0.85rem; margin-bottom: var(--spacing-xs);">CORREO DESTINO</label>
                        <input type="email" name="notify_email" class="form-input"
                            value="{{ $user->profesor ? $user->profesor->email : '' }}"
                            placeholder="correo@personal.com" style="width: 100%;" required>
                    </div>
                    <button type="submit" class="btn btn-outline" style="width: 100%; color: var(--text-color); border-color: var(--border-color);">
                        <i class="fas fa-paper-plane"></i> Enviar Credenciales
                    </button>
                </form>
            </div>

            @if($user->profesor)
                <div style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: var(--spacing-lg);">
                    <h3 style="font-size: 1rem; font-weight: 700; color: var(--text-color); margin: 0 0 var(--spacing-lg) 0; padding-bottom: var(--spacing-sm); border-bottom: 1px solid var(--border-color); display: flex; align-items: center; gap: var(--spacing-sm);">
                        <i class="fas fa-chalkboard-teacher" style="color: var(--text-muted);"></i> Datos del Profesor
                    </h3>
                    <div style="display: flex; align-items: center; gap: var(--spacing-sm); margin-bottom: var(--spacing-md);">
                        <div style="width: 44px; height: 44px; border-radius: 50%; background: #3b82f6; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; flex-shrink: 0;">
                            {{ strtoupper(substr($user->profesor->nombre, 0, 1) . substr($user->profesor->apellido, 0, 1)) }}
                        </div>
                        <div>
                            <div style="font-weight: 600; color: var(--text-color);">{{ $user->profesor->nombre }} {{ $user->profesor->apellido }}</div>
                            <div style="font-size: 0.8rem; color: var(--text-muted);">{{ $user->profesor->rut }}</div>
                        </div>
                    </div>
                    <div style="font-size: 0.875rem; color: var(--text-muted);">
                        <p style="margin: 0 0 4px;"><i class="fas fa-envelope" style="width: 16px;"></i> {{ $user->profesor->email }}</p>
                        @if($user->profesor->telefono)
                            <p style="margin: 0;"><i class="fas fa-phone" style="width: 16px;"></i> {{ $user->profesor->telefono }}</p>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        let passwordVisible = false;

        function togglePassword() {
            const textEl = document.getElementById('passwordText');
            const plainEl = document.getElementById('passwordPlain');
            const icon = document.getElementById('passwordIcon');
            passwordVisible = !passwordVisible;

            if (passwordVisible) {
                textEl.style.display = 'none';
                plainEl.style.display = 'inline';
                icon.className = 'fas fa-eye-slash';
            } else {
                textEl.style.display = 'inline';
                plainEl.style.display = 'none';
                icon.className = 'fas fa-eye';
            }
        }
    </script>

    <style>
        @media (max-width: 768px) {
            .show-grid {
                grid-template-columns: 1fr !important;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start !important;
            }
        }
    </style>
</x-app-layout>
