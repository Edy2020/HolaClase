<x-app-layout>
    <x-slot name="header">
        Gestionar Roles
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
                Gestionar Roles
            </h2>
            <p style="color: var(--text-muted); margin: var(--spacing-xs) 0 0 0; font-size: 0.9375rem;">
                Crear roles y configurar permisos del sistema
            </p>
        </div>
        <div style="display: flex; gap: var(--spacing-sm);">
            <button onclick="document.getElementById('newRoleModal').style.display='flex'" class="btn btn-outline"
                style="color: var(--text-color); border-color: var(--border-color);">
                <i class="fas fa-plus"></i> Nuevo Rol
            </button>
            <a href="{{ route('users.index') }}" class="btn btn-outline" style="color: var(--text-muted); border-color: var(--border-color);">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(400px, 1fr)); gap: var(--spacing-lg);" class="roles-grid">
        @foreach($roles as $role)
            <div style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); overflow: hidden;">
                <div style="padding: var(--spacing-lg); border-bottom: 1px solid var(--border-color);">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div style="display: flex; align-items: center; gap: var(--spacing-sm);">
                            <div style="width: 40px; height: 40px; border-radius: var(--radius-md); background: {{ $role->name === 'admin' ? 'rgba(168, 85, 247, 0.1)' : ($role->name === 'profesor' ? 'rgba(59, 130, 246, 0.1)' : 'rgba(132, 204, 22, 0.1)') }}; display: flex; align-items: center; justify-content: center;">
                                <i class="fas {{ $role->name === 'admin' ? 'fa-crown' : ($role->name === 'profesor' ? 'fa-chalkboard-teacher' : 'fa-user-tag') }}"
                                    style="color: {{ $role->name === 'admin' ? '#a855f7' : ($role->name === 'profesor' ? '#3b82f6' : '#84cc16') }}; font-size: 1rem;"></i>
                            </div>
                            <div>
                                <div style="font-weight: 700; color: var(--text-color); font-size: 1rem;">{{ $role->display_name }}</div>
                                <div style="font-size: 0.75rem; color: var(--text-muted);">{{ $role->name }}</div>
                            </div>
                        </div>
                        <div style="display: flex; gap: var(--spacing-xs);">
                            @if($role->name !== 'admin')
                                <button onclick="toggleRoleEdit('{{ $role->id }}')" class="btn btn-sm btn-outline" style="color: var(--text-muted); border-color: var(--border-color);">
                                    <i class="fas fa-edit"></i>
                                </button>
                            @endif
                            @if(!in_array($role->name, ['admin', 'profesor']))
                                <form action="{{ route('users.roles.destroy', $role) }}" method="POST" onsubmit="return confirm('¿Eliminar rol {{ $role->display_name }}?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline" style="color: var(--error); border-color: var(--error);">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                    @if($role->description)
                        <p style="color: var(--text-muted); font-size: 0.85rem; margin: var(--spacing-sm) 0 0; line-height: 1.4;">{{ $role->description }}</p>
                    @endif
                </div>

                <div style="padding: var(--spacing-md) var(--spacing-lg);">
                    <div style="font-size: 0.75rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: var(--spacing-sm);">
                        Permisos ({{ $role->name === 'admin' ? 'Todos' : $role->permissions->count() }})
                    </div>
                    @if($role->name === 'admin')
                        <div style="padding: var(--spacing-sm); background: rgba(168, 85, 247, 0.05); border: 1px solid rgba(168, 85, 247, 0.15); border-radius: var(--radius-md); text-align: center;">
                            <span style="font-size: 0.8rem; color: #a855f7; font-weight: 600;">
                                <i class="fas fa-infinity"></i> Acceso total al sistema
                            </span>
                        </div>
                    @else
                        <div style="display: flex; flex-wrap: wrap; gap: 4px;">
                            @forelse($role->permissions as $perm)
                                <span style="padding: 3px 8px; font-size: 0.6875rem; font-weight: 500; color: var(--text-muted); background: var(--gray-50); border: 1px solid var(--border-color); border-radius: var(--radius-sm);">
                                    {{ $perm->display_name }}
                                </span>
                            @empty
                                <span style="font-size: 0.8rem; color: var(--text-muted); opacity: 0.6;">Sin permisos asignados</span>
                            @endforelse
                        </div>
                    @endif
                </div>

                <div id="roleEdit-{{ $role->id }}" style="display: none; padding: var(--spacing-lg); border-top: 1px solid var(--border-color); background: var(--gray-50);">
                    <form action="{{ route('users.roles.update', $role) }}" method="POST">
                        @csrf @method('PATCH')
                        <div style="margin-bottom: var(--spacing-md);">
                            <label style="display: block; font-weight: 600; color: var(--text-muted); font-size: 0.8rem; margin-bottom: 4px;">NOMBRE VISIBLE</label>
                            <input type="text" name="display_name" class="form-input" value="{{ $role->display_name }}" style="width: 100%;">
                        </div>
                        <div style="margin-bottom: var(--spacing-md);">
                            <label style="display: block; font-weight: 600; color: var(--text-muted); font-size: 0.8rem; margin-bottom: 4px;">DESCRIPCIÓN</label>
                            <input type="text" name="description" class="form-input" value="{{ $role->description }}" style="width: 100%;">
                        </div>
                        <div style="margin-bottom: var(--spacing-lg);">
                            <label style="display: block; font-weight: 600; color: var(--text-muted); font-size: 0.8rem; margin-bottom: var(--spacing-sm);">PERMISOS</label>
                            @foreach($permissions as $group => $perms)
                                <div style="margin-bottom: var(--spacing-sm); padding: var(--spacing-sm); background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-md);">
                                    <div style="font-weight: 700; color: var(--text-color); font-size: 0.8rem; margin-bottom: var(--spacing-xs);">{{ $group }}</div>
                                    <div style="display: flex; flex-wrap: wrap; gap: var(--spacing-xs);">
                                        @foreach($perms as $perm)
                                            <label style="display: flex; align-items: center; gap: 4px; padding: 4px 8px; border: 1px solid var(--border-color); border-radius: var(--radius-sm); font-size: 0.75rem; color: var(--text-muted); cursor: pointer; background: var(--bg-card);">
                                                <input type="checkbox" name="permissions[]" value="{{ $perm->id }}" {{ $role->permissions->contains($perm->id) ? 'checked' : '' }} style="accent-color: #84cc16;">
                                                {{ $perm->display_name }}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div style="display: flex; gap: var(--spacing-sm);">
                            <button type="button" onclick="toggleRoleEdit('{{ $role->id }}')" class="btn btn-outline" style="flex: 1; color: var(--text-muted); border-color: var(--border-color);">Cancelar</button>
                            <button type="submit" class="btn btn-primary" style="flex: 1; color: white;">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    <div id="newRoleModal"
        style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; z-index: 1000;">
        <div style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); max-width: 600px; width: 90%; max-height: 90vh; overflow-y: auto; padding: var(--spacing-lg);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-lg);">
                <h3 style="font-size: 1.125rem; font-weight: 700; color: var(--text-color); margin: 0;">Nuevo Rol</h3>
                <button onclick="document.getElementById('newRoleModal').style.display='none'"
                    style="background: none; border: none; font-size: 1.5rem; color: var(--text-muted); cursor: pointer;"><i class="fas fa-times"></i></button>
            </div>
            <form action="{{ route('users.roles.store') }}" method="POST">
                @csrf
                <div style="margin-bottom: var(--spacing-md);">
                    <label style="display: block; font-weight: 600; color: var(--text-muted); font-size: 0.85rem; margin-bottom: var(--spacing-xs);">NOMBRE INTERNO</label>
                    <input type="text" name="name" class="form-input" placeholder="ej: coordinador" style="width: 100%;" required>
                </div>
                <div style="margin-bottom: var(--spacing-md);">
                    <label style="display: block; font-weight: 600; color: var(--text-muted); font-size: 0.85rem; margin-bottom: var(--spacing-xs);">NOMBRE VISIBLE</label>
                    <input type="text" name="display_name" class="form-input" placeholder="ej: Coordinador Académico" style="width: 100%;" required>
                </div>
                <div style="margin-bottom: var(--spacing-md);">
                    <label style="display: block; font-weight: 600; color: var(--text-muted); font-size: 0.85rem; margin-bottom: var(--spacing-xs);">DESCRIPCIÓN</label>
                    <input type="text" name="description" class="form-input" placeholder="Descripción breve del rol" style="width: 100%;">
                </div>
                <div style="margin-bottom: var(--spacing-lg);">
                    <label style="display: block; font-weight: 600; color: var(--text-muted); font-size: 0.85rem; margin-bottom: var(--spacing-sm);">PERMISOS</label>
                    @foreach($permissions as $group => $perms)
                        <div style="margin-bottom: var(--spacing-sm); padding: var(--spacing-sm); border: 1px solid var(--border-color); border-radius: var(--radius-md);">
                            <div style="font-weight: 700; color: var(--text-color); font-size: 0.8rem; margin-bottom: var(--spacing-xs);">{{ $group }}</div>
                            <div style="display: flex; flex-wrap: wrap; gap: var(--spacing-xs);">
                                @foreach($perms as $perm)
                                    <label style="display: flex; align-items: center; gap: 4px; padding: 4px 8px; border: 1px solid var(--border-color); border-radius: var(--radius-sm); font-size: 0.75rem; color: var(--text-muted); cursor: pointer;">
                                        <input type="checkbox" name="permissions[]" value="{{ $perm->id }}" style="accent-color: #84cc16;">
                                        {{ $perm->display_name }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                <div style="display: flex; gap: var(--spacing-sm);">
                    <button type="button" onclick="document.getElementById('newRoleModal').style.display='none'" class="btn btn-outline" style="flex: 1; color: var(--text-color); border-color: var(--border-color);">Cancelar</button>
                    <button type="submit" class="btn btn-primary" style="flex: 1; color: white;"><i class="fas fa-plus"></i> Crear Rol</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleRoleEdit(id) {
            const el = document.getElementById('roleEdit-' + id);
            el.style.display = el.style.display === 'none' ? 'block' : 'none';
        }

        document.querySelectorAll('[id$="Modal"]').forEach(m => {
            m.addEventListener('click', e => { if (e.target === m) m.style.display = 'none'; });
        });
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') document.querySelectorAll('[id$="Modal"]').forEach(m => m.style.display = 'none');
        });
    </script>

    <style>
        @media (max-width: 768px) {
            .roles-grid {
                grid-template-columns: 1fr !important;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start !important;
            }

            .page-header > div:last-child {
                width: 100%;
            }

            .page-header .btn {
                flex: 1;
                justify-content: center;
            }
        }
    </style>
</x-app-layout>
