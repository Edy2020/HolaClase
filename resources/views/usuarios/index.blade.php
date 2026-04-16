<x-app-layout>
    <x-slot name="header">
        Gestión de Usuarios
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

    <div class="page-header"
        style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-xl); flex-wrap: wrap; gap: var(--spacing-md);">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--text-color); margin: 0;">
                Usuarios y Roles
            </h2>
            <p style="color: var(--text-muted); margin: var(--spacing-xs) 0 0 0; font-size: 0.9375rem;">
                <i class="fas fa-shield-alt"></i> Gestiona accesos, roles y permisos del sistema
            </p>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: var(--spacing-lg); margin-bottom: var(--spacing-xl);">
        <div class="stat-card" style="text-align: center;">
            <div class="stat-value">{{ $totalUsuarios }}</div>
            <div class="stat-label"><i class="fas fa-users"></i> Usuarios del Sistema</div>
        </div>
        <div class="stat-card" style="text-align: center;">
            <div class="stat-value">{{ $profesoresConAcceso }}</div>
            <div class="stat-label"><i class="fas fa-chalkboard-teacher"></i> Profesores con Acceso</div>
        </div>
        <div class="stat-card" style="text-align: center;">
            <div class="stat-value">{{ $totalRoles }}</div>
            <div class="stat-label"><i class="fas fa-user-tag"></i> Roles Definidos</div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: var(--spacing-lg);" class="actions-grid">
        <a href="{{ route('users.crear') }}"
            style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: var(--spacing-xl); text-decoration: none; display: flex; flex-direction: column; align-items: center; text-align: center; gap: var(--spacing-md);">
            <div style="width: 56px; height: 56px; border-radius: 50%; background: rgba(132, 204, 22, 0.1); display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-user-plus" style="font-size: 1.5rem; color: #84cc16;"></i>
            </div>
            <div>
                <h3 style="font-weight: 700; color: var(--text-color); margin: 0 0 4px; font-size: 1rem;">Crear Usuario</h3>
                <p style="color: var(--text-muted); font-size: 0.8rem; margin: 0;">Nuevo estudiante, profesor o usuario del sistema</p>
            </div>
        </a>

        <a href="{{ route('users.gestionar') }}"
            style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: var(--spacing-xl); text-decoration: none; display: flex; flex-direction: column; align-items: center; text-align: center; gap: var(--spacing-md);">
            <div style="width: 56px; height: 56px; border-radius: 50%; background: rgba(59, 130, 246, 0.1); display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-users-cog" style="font-size: 1.5rem; color: #3b82f6;"></i>
            </div>
            <div>
                <h3 style="font-weight: 700; color: var(--text-color); margin: 0 0 4px; font-size: 1rem;">Gestionar Usuarios</h3>
                <p style="color: var(--text-muted); font-size: 0.8rem; margin: 0;">Buscar, dar acceso y administrar usuarios</p>
            </div>
        </a>

        <a href="{{ route('users.roles') }}"
            style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: var(--spacing-xl); text-decoration: none; display: flex; flex-direction: column; align-items: center; text-align: center; gap: var(--spacing-md);">
            <div style="width: 56px; height: 56px; border-radius: 50%; background: rgba(168, 85, 247, 0.1); display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-user-tag" style="font-size: 1.5rem; color: #a855f7;"></i>
            </div>
            <div>
                <h3 style="font-weight: 700; color: var(--text-color); margin: 0 0 4px; font-size: 1rem;">Gestionar Roles</h3>
                <p style="color: var(--text-muted); font-size: 0.8rem; margin: 0;">Crear roles y configurar permisos</p>
            </div>
        </a>
    </div>

    <style>
        @media (max-width: 768px) {
            .page-header {
                flex-direction: column;
                align-items: flex-start !important;
            }
        }
    </style>
</x-app-layout>
