<x-app-layout>
    <x-slot name="header">
        Gestionar Usuarios
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
                Gestionar Usuarios
            </h2>
            <p style="color: var(--text-muted); margin: var(--spacing-xs) 0 0 0; font-size: 0.9375rem;">
                Buscar y administrar accesos al sistema
            </p>
        </div>
        <a href="{{ route('users.index') }}" class="btn btn-outline" style="color: var(--text-muted); border-color: var(--border-color);">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <div style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: var(--spacing-lg);">

        <div style="margin-bottom: var(--spacing-lg);">
            <div style="position: relative;">
                <div style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: 1rem;">
                    <i class="fas fa-search"></i>
                </div>
                <input type="text" id="userSearchInput" class="form-input"
                    placeholder="Buscar por nombre, email o RUT..."
                    style="padding-left: 40px; width: 100%; border: 2px solid var(--border-color); border-radius: var(--radius-lg); font-size: 0.9375rem;"
                    oninput="filterCurrentSubTab()"
                    onfocus="this.style.borderColor='#84cc16'; this.style.boxShadow='0 0 0 3px rgba(132, 204, 22, 0.1)'"
                    onblur="this.style.borderColor='var(--border-color)'; this.style.boxShadow='none'">
            </div>
        </div>

        <div class="system-tabs-container" style="margin-bottom: var(--spacing-lg);">
            <div onclick="switchSubTab('profesores')" class="system-tab active-tab" id="subtab-profesores">
                <i class="fas fa-chalkboard-teacher"></i> Profesores ({{ $profesores->count() }})
            </div>
            <div onclick="switchSubTab('estudiantes')" class="system-tab" id="subtab-estudiantes">
                <i class="fas fa-user-graduate"></i> Estudiantes ({{ $estudiantes->count() }})
            </div>
            <div onclick="switchSubTab('sistema')" class="system-tab" id="subtab-sistema">
                <i class="fas fa-users-cog"></i> Sistema ({{ $usuarios->count() }})
            </div>
        </div>

        <div id="subsection-profesores" class="sub-tab-section active-sub-section">
            @if($profesores->count() > 0)
                <div style="overflow-x: auto;">
                    <table class="table" style="width: 100%;">
                        <thead>
                            <tr class="table-header-row">
                                <th style="text-align: left;">Profesor</th>
                                <th style="text-align: left;">Email</th>
                                <th style="text-align: left;">Teléfono</th>
                                <th style="text-align: left;">Acceso</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($profesores as $profesor)
                                <tr class="filterable-row"
                                    data-search="{{ strtolower($profesor->nombre . ' ' . $profesor->apellido . ' ' . $profesor->email . ' ' . $profesor->rut) }}">
                                    <td>
                                        <div style="display: flex; align-items: center; gap: var(--spacing-sm);">
                                            <div style="width: 36px; height: 36px; border-radius: 50%; background: #3b82f6; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 0.75rem; flex-shrink: 0;">
                                                {{ strtoupper(substr($profesor->nombre, 0, 1) . substr($profesor->apellido, 0, 1)) }}
                                            </div>
                                            <div style="min-width: 0;">
                                                <div style="font-weight: 600; color: var(--text-color);">{{ $profesor->nombre }} {{ $profesor->apellido }}</div>
                                                <div style="font-size: 0.8rem; color: var(--text-muted);">{{ $profesor->rut }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="color: var(--text-muted); font-size: 0.875rem;">{{ $profesor->email ?? '-' }}</td>
                                    <td style="color: var(--text-muted); font-size: 0.875rem;">{{ $profesor->telefono ?? '-' }}</td>
                                    <td>
                                        @if(in_array($profesor->id, $profesoresConAcceso))
                                            <span style="display: inline-block; padding: 0.25rem 0.625rem; font-size: 0.6875rem; font-weight: 700; color: #84cc16; background: rgba(132, 204, 22, 0.1); border-radius: 9999px;">
                                                <i class="fas fa-check"></i> Activo
                                            </span>
                                        @else
                                            <span style="display: inline-block; padding: 0.25rem 0.625rem; font-size: 0.6875rem; font-weight: 600; color: var(--text-muted); background: var(--gray-100); border-radius: 9999px;">Sin acceso</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if(!in_array($profesor->id, $profesoresConAcceso))
                                            <form action="{{ route('users.grant-access') }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Dar acceso al sistema a {{ $profesor->nombre }} {{ $profesor->apellido }}?');">
                                                @csrf
                                                <input type="hidden" name="profesor_id" value="{{ $profesor->id }}">
                                                <button type="submit" class="btn btn-sm btn-outline" style="color: #84cc16; border-color: #84cc16; font-size: 0.75rem;">
                                                    <i class="fas fa-key"></i> Dar Acceso
                                                </button>
                                            </form>
                                        @else
                                            @php $userAccess = $usuarios->where('profesor_id', $profesor->id)->first(); @endphp
                                            @if($userAccess)
                                                <a href="{{ route('users.show', $userAccess) }}" class="btn btn-sm btn-outline" style="color: var(--text-muted); border-color: var(--border-color); font-size: 0.75rem;">
                                                    <i class="fas fa-eye"></i> Ver
                                                </a>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div style="text-align: center; padding: var(--spacing-2xl); border: 1px dashed var(--border-color); border-radius: var(--radius-md);">
                    <i class="fas fa-chalkboard-teacher" style="font-size: 2.5rem; color: var(--text-muted); margin-bottom: var(--spacing-md); opacity: 0.6;"></i>
                    <p style="color: var(--text-color); margin: 0; font-weight: 500;">No hay profesores registrados</p>
                </div>
            @endif
        </div>

        <div id="subsection-estudiantes" class="sub-tab-section">
            @if($estudiantes->count() > 0)
                <div style="overflow-x: auto;">
                    <table class="table" style="width: 100%;">
                        <thead>
                            <tr class="table-header-row">
                                <th style="text-align: left;">Estudiante</th>
                                <th style="text-align: left;">Email</th>
                                <th style="text-align: left;">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($estudiantes as $estudiante)
                                <tr class="filterable-row"
                                    data-search="{{ strtolower($estudiante->nombre . ' ' . $estudiante->apellido . ' ' . $estudiante->email . ' ' . $estudiante->rut) }}">
                                    <td>
                                        <div style="display: flex; align-items: center; gap: var(--spacing-sm);">
                                            <div style="width: 36px; height: 36px; border-radius: 50%; background: #84cc16; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 0.75rem; flex-shrink: 0;">
                                                {{ strtoupper(substr($estudiante->nombre, 0, 1) . substr($estudiante->apellido, 0, 1)) }}
                                            </div>
                                            <div style="min-width: 0;">
                                                <div style="font-weight: 600; color: var(--text-color);">{{ $estudiante->nombre }} {{ $estudiante->apellido }}</div>
                                                <div style="font-size: 0.8rem; color: var(--text-muted);">{{ $estudiante->rut }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="color: var(--text-muted); font-size: 0.875rem;">{{ $estudiante->email ?? '-' }}</td>
                                    <td>
                                        <span style="display: inline-block; padding: 0.25rem 0.625rem; font-size: 0.6875rem; font-weight: 600; color: {{ ($estudiante->estado ?? 'activo') === 'activo' ? '#84cc16' : 'var(--text-muted)' }}; background: {{ ($estudiante->estado ?? 'activo') === 'activo' ? 'rgba(132, 204, 22, 0.1)' : 'var(--gray-100)' }}; border-radius: 9999px;">
                                            {{ ucfirst($estudiante->estado ?? 'Activo') }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div style="text-align: center; padding: var(--spacing-2xl); border: 1px dashed var(--border-color); border-radius: var(--radius-md);">
                    <i class="fas fa-user-graduate" style="font-size: 2.5rem; color: var(--text-muted); margin-bottom: var(--spacing-md); opacity: 0.6;"></i>
                    <p style="color: var(--text-color); margin: 0; font-weight: 500;">No hay estudiantes registrados</p>
                </div>
            @endif
        </div>

        <div id="subsection-sistema" class="sub-tab-section">
            @if($usuarios->count() > 0)
                <div style="overflow-x: auto;">
                    <table class="table" style="width: 100%;">
                        <thead>
                            <tr class="table-header-row">
                                <th style="text-align: left;">Usuario</th>
                                <th style="text-align: left;">Email del Sistema</th>
                                <th style="text-align: left;">Rol</th>
                                <th style="text-align: left;">Vinculado a</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($usuarios as $usuario)
                                <tr class="filterable-row"
                                    data-search="{{ strtolower($usuario->name . ' ' . $usuario->email . ' ' . $usuario->role) }}">
                                    <td>
                                        <div style="display: flex; align-items: center; gap: var(--spacing-sm);">
                                            <div style="width: 36px; height: 36px; border-radius: 50%; background: {{ $usuario->role === 'admin' ? '#a855f7' : '#3b82f6' }}; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 0.75rem; flex-shrink: 0;">
                                                {{ strtoupper(substr($usuario->name, 0, 1) . (str_contains($usuario->name, ' ') ? substr(explode(' ', $usuario->name)[1], 0, 1) : substr($usuario->name, 1, 1))) }}
                                            </div>
                                            <div style="font-weight: 600; color: var(--text-color);">{{ $usuario->name }}</div>
                                        </div>
                                    </td>
                                    <td style="color: var(--text-muted); font-size: 0.875rem;">{{ $usuario->email }}</td>
                                    <td>
                                        <span style="display: inline-block; padding: 0.25rem 0.625rem; font-size: 0.6875rem; font-weight: 700; color: {{ $usuario->role === 'admin' ? '#a855f7' : '#3b82f6' }}; background: {{ $usuario->role === 'admin' ? 'rgba(168, 85, 247, 0.1)' : 'rgba(59, 130, 246, 0.1)' }}; border-radius: 9999px; text-transform: capitalize;">
                                            {{ $usuario->role }}
                                        </span>
                                    </td>
                                    <td style="color: var(--text-muted); font-size: 0.875rem;">
                                        @if($usuario->profesor_id)
                                            <i class="fas fa-chalkboard-teacher"></i> Profesor
                                        @elseif($usuario->estudiante_id)
                                            <i class="fas fa-user-graduate"></i> Estudiante
                                        @else
                                            <span style="opacity: 0.5;">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div style="display: flex; gap: var(--spacing-xs);">
                                            <a href="{{ route('users.show', $usuario) }}" class="btn btn-sm btn-outline" style="color: var(--text-muted); border-color: var(--border-color);">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($usuario->id !== auth()->id())
                                                <form action="{{ route('users.revoke-access', $usuario) }}" method="POST" onsubmit="return confirm('¿Revocar acceso de {{ $usuario->name }}?');">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline" style="color: var(--error); border-color: var(--error);">
                                                        <i class="fas fa-ban"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div style="text-align: center; padding: var(--spacing-2xl); border: 1px dashed var(--border-color); border-radius: var(--radius-md);">
                    <i class="fas fa-users-cog" style="font-size: 2.5rem; color: var(--text-muted); margin-bottom: var(--spacing-md); opacity: 0.6;"></i>
                    <p style="color: var(--text-color); margin: 0; font-weight: 500;">No hay usuarios del sistema</p>
                </div>
            @endif
        </div>

        <div id="noUserResults" style="display: none; text-align: center; padding: var(--spacing-xl); color: var(--text-muted);">
            <i class="fas fa-search" style="font-size: 2rem; margin-bottom: var(--spacing-sm); opacity: 0.4;"></i>
            <p style="margin: 0;">No se encontraron resultados</p>
        </div>
    </div>

    <script>
        let currentSubTab = 'profesores';

        function switchSubTab(name) {
            currentSubTab = name;
            document.querySelectorAll('.sub-tab-section').forEach(s => s.classList.remove('active-sub-section'));
            document.querySelectorAll('[id^="subtab-"]').forEach(t => t.classList.remove('active-tab'));
            document.getElementById('subsection-' + name).classList.add('active-sub-section');
            document.getElementById('subtab-' + name).classList.add('active-tab');
            filterCurrentSubTab();
        }

        function filterCurrentSubTab() {
            const searchTerm = (document.getElementById('userSearchInput').value || '').toLowerCase();
            const activeSection = document.getElementById('subsection-' + currentSubTab);
            const rows = activeSection.querySelectorAll('.filterable-row');
            let visibleCount = 0;

            rows.forEach(row => {
                const data = row.dataset.search || '';
                const matches = data.includes(searchTerm);
                row.style.display = matches ? '' : 'none';
                if (matches) visibleCount++;
            });

            document.getElementById('noUserResults').style.display = (visibleCount === 0 && searchTerm) ? 'block' : 'none';
        }
    </script>

    <style>
        .sub-tab-section {
            display: none;
        }

        .sub-tab-section.active-sub-section {
            display: block;
        }

        @media (max-width: 768px) {
            .page-header {
                flex-direction: column;
                align-items: flex-start !important;
            }
        }
    </style>
</x-app-layout>
