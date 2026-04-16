<x-app-layout>
    <x-slot name="header">
        Crear Usuario
    </x-slot>

    <link rel="stylesheet" href="{{ asset('css/shared-index.css') }}?v={{ time() }}">

    <div class="page-header"
        style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-lg); flex-wrap: wrap; gap: var(--spacing-md);">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--text-color); margin: 0;">
                Crear Usuario
            </h2>
            <p style="color: var(--text-muted); margin: var(--spacing-xs) 0 0 0; font-size: 0.9375rem;">
                Selecciona el tipo de usuario que deseas crear
            </p>
        </div>
        <a href="{{ route('users.index') }}" class="btn btn-outline" style="color: var(--text-muted); border-color: var(--border-color);">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: var(--spacing-lg);">
        <a href="{{ route('students.create') }}"
            style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: var(--spacing-xl); text-decoration: none; display: flex; flex-direction: column; align-items: center; text-align: center; gap: var(--spacing-md);">
            <div style="width: 64px; height: 64px; border-radius: 50%; background: rgba(132, 204, 22, 0.1); display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-user-graduate" style="font-size: 1.75rem; color: #84cc16;"></i>
            </div>
            <div>
                <h3 style="font-weight: 700; color: var(--text-color); margin: 0 0 4px; font-size: 1.125rem;">Nuevo Estudiante</h3>
                <p style="color: var(--text-muted); font-size: 0.85rem; margin: 0;">Registrar un nuevo estudiante en el sistema</p>
            </div>
        </a>

        <a href="{{ route('teachers.create') }}"
            style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: var(--spacing-xl); text-decoration: none; display: flex; flex-direction: column; align-items: center; text-align: center; gap: var(--spacing-md);">
            <div style="width: 64px; height: 64px; border-radius: 50%; background: rgba(59, 130, 246, 0.1); display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-chalkboard-teacher" style="font-size: 1.75rem; color: #3b82f6;"></i>
            </div>
            <div>
                <h3 style="font-weight: 700; color: var(--text-color); margin: 0 0 4px; font-size: 1.125rem;">Nuevo Profesor</h3>
                <p style="color: var(--text-muted); font-size: 0.85rem; margin: 0;">Registrar un nuevo profesor en el sistema</p>
            </div>
        </a>

        <div onclick="document.getElementById('newUserModal').style.display='flex'"
            style="cursor: pointer; background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: var(--spacing-xl); text-decoration: none; display: flex; flex-direction: column; align-items: center; text-align: center; gap: var(--spacing-md);">
            <div style="width: 64px; height: 64px; border-radius: 50%; background: rgba(168, 85, 247, 0.1); display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-user-plus" style="font-size: 1.75rem; color: #a855f7;"></i>
            </div>
            <div>
                <h3 style="font-weight: 700; color: var(--text-color); margin: 0 0 4px; font-size: 1.125rem;">Nuevo Usuario</h3>
                <p style="color: var(--text-muted); font-size: 0.85rem; margin: 0;">Crear acceso al sistema con rol personalizado</p>
            </div>
        </div>
    </div>

    <div id="newUserModal"
        style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; z-index: 1000;">
        <div style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); max-width: 500px; width: 90%; max-height: 90vh; overflow-y: auto; padding: var(--spacing-lg);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-lg);">
                <h3 style="font-size: 1.125rem; font-weight: 700; color: var(--text-color); margin: 0;">Nuevo Usuario del Sistema</h3>
                <button onclick="document.getElementById('newUserModal').style.display='none'"
                    style="background: none; border: none; font-size: 1.5rem; color: var(--text-muted); cursor: pointer;"><i class="fas fa-times"></i></button>
            </div>
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div style="margin-bottom: var(--spacing-md);">
                    <label style="display: block; font-weight: 600; color: var(--text-muted); font-size: 0.85rem; margin-bottom: var(--spacing-xs);">NOMBRE COMPLETO</label>
                    <input type="text" name="name" class="form-input" placeholder="Nombre del usuario" style="width: 100%;" required>
                </div>
                <div style="margin-bottom: var(--spacing-md);">
                    <label style="display: block; font-weight: 600; color: var(--text-muted); font-size: 0.85rem; margin-bottom: var(--spacing-xs);">CORREO ELECTRÓNICO</label>
                    <input type="email" name="email" class="form-input" placeholder="correo@ejemplo.com" style="width: 100%;" required>
                </div>
                <div style="margin-bottom: var(--spacing-md);">
                    <label style="display: block; font-weight: 600; color: var(--text-muted); font-size: 0.85rem; margin-bottom: var(--spacing-xs);">CONTRASEÑA</label>
                    <input type="text" name="password" class="form-input" placeholder="Mínimo 6 caracteres" style="width: 100%;" minlength="6" required>
                </div>
                <div style="margin-bottom: var(--spacing-lg);">
                    <label style="display: block; font-weight: 600; color: var(--text-muted); font-size: 0.85rem; margin-bottom: var(--spacing-xs);">ROL</label>
                    <select name="role" class="form-select" style="width: 100%; background: var(--bg-card); color: var(--text-color);" required>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->display_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="display: flex; gap: var(--spacing-sm);">
                    <button type="button" onclick="document.getElementById('newUserModal').style.display='none'" class="btn btn-outline" style="flex: 1; color: var(--text-color); border-color: var(--border-color);">Cancelar</button>
                    <button type="submit" class="btn btn-primary" style="flex: 1; color: white;"><i class="fas fa-user-plus"></i> Crear</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.querySelectorAll('[id$="Modal"]').forEach(m => {
            m.addEventListener('click', e => { if (e.target === m) m.style.display = 'none'; });
        });
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') document.querySelectorAll('[id$="Modal"]').forEach(m => m.style.display = 'none');
        });
    </script>

    <style>
        @media (max-width: 768px) {
            .page-header {
                flex-direction: column;
                align-items: flex-start !important;
            }
        }
    </style>
</x-app-layout>
