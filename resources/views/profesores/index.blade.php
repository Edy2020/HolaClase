<x-app-layout>
    <x-slot name="header">
        Gestión de Profesores
    </x-slot>

    <!-- Hero Header -->
    <div
        style="background: var(--theme-dark); color: white; padding: var(--spacing-2xl); border-radius: var(--radius-xl); margin-bottom: var(--spacing-2xl); box-shadow: var(--shadow-lg); display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2 style="color: white; font-size: 1.75rem; font-weight: 700; margin-bottom: var(--spacing-sm);">
                <i class="fas fa-chalkboard-teacher"></i> Profesores
            </h2>
            <p style="font-size: 1rem; opacity: 0.95; margin: 0;">
                Administra el personal docente de la institución
            </p>
        </div>
        <div style="display: flex; gap: var(--spacing-md); align-items: center;">
            <!-- View Toggle -->
            <div
                style="display: flex; gap: var(--spacing-xs); background: rgba(255,255,255,0.1); padding: var(--spacing-xs); border-radius: var(--radius-md);">
                <button id="gridViewBtn" class="btn btn-sm"
                    style="background: white; color: var(--theme-dark); border: none; padding: var(--spacing-sm) var(--spacing-md); border-radius: var(--radius-md);">
                    <i class="fas fa-th"></i>
                </button>
                <button id="listViewBtn" class="btn btn-sm"
                    style="background: transparent; color: white; border: none; padding: var(--spacing-sm) var(--spacing-md); border-radius: var(--radius-md);">
                    <i class="fas fa-list"></i>
                </button>
            </div>
            <a href="{{ route('teachers.create') }}" class="btn btn-primary"
                style="background: white; color: var(--theme-dark); flex-shrink: 0;">
                <span><i class="fas fa-plus"></i></span>
                <span>Nuevo Profesor</span>
            </a>
        </div>
    </div>

    <!-- Teachers Grid View -->
    <div id="gridView" class="grid grid-cols-3">
        @forelse ($profesores as $profesor)
            <!-- Teacher Card -->
            <div class="card">
                <div style="text-align: center; margin-bottom: var(--spacing-lg);">
                    <div
                        style="width: 100px; height: 100px; margin: 0 auto var(--spacing-md); border-radius: var(--radius-lg); background: var(--theme-color); display: flex; align-items: center; justify-content: center; color: white; font-size: 2.5rem; font-weight: 700; box-shadow: var(--shadow-lg);">
                        {{ substr($profesor->nombre, 0, 1) . substr($profesor->apellido, 0, 1) }}
                    </div>
                    <h3
                        style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900); margin-bottom: var(--spacing-xs);">
                        {{ $profesor->nombre }} {{ $profesor->apellido }}
                    </h3>
                    <p style="color: var(--gray-600); font-size: 0.875rem; margin-bottom: var(--spacing-xs);">
                        {{ $profesor->rut }}
                    </p>
                    <p style="color: var(--gray-600); font-size: 0.875rem; margin: 0;">
                        {{ $profesor->email }}
                    </p>
                </div>

                <div
                    style="padding: var(--spacing-md); background: var(--gray-50); border-radius: var(--radius-md); margin-bottom: var(--spacing-lg);">
                    <div style="display: flex; justify-content: space-between; margin-bottom: var(--spacing-sm);">
                        <span style="color: var(--gray-600); font-size: 0.875rem;">Teléfono:</span>
                        <span style="font-weight: 600;">{{ $profesor->telefono ?? 'N/A' }}</span>
                    </div>
                </div>

                <div style="display: flex; gap: var(--spacing-sm);">
                    <a href="{{ route('teachers.edit', $profesor) }}" class="btn btn-primary btn-sm"
                        style="color: white; flex: 1;">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <form action="{{ route('teachers.destroy', $profesor) }}" method="POST"
                        onsubmit="return confirm('¿Estás seguro de querer eliminar este profesor?');" style="flex: 1;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline btn-sm"
                            style="width: 100%; color: #ef4444; border-color: #ef4444;">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-12">
                <div style="margin-bottom: var(--spacing-md); font-size: 3rem; color: var(--gray-300);">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--gray-700);">No hay profesores registrados</h3>
                <p style="color: var(--gray-500);">Comienza agregando un nuevo profesor al sistema.</p>
            </div>
        @endforelse
    </div>

    <!-- Teachers List View -->
    <div id="listView" style="display: none;">
        @forelse ($profesores as $profesor)
            <!-- Teacher List Item -->
            <div class="card mb-md" style="padding: var(--spacing-lg);">
                <div style="display: flex; align-items: center; gap: var(--spacing-xl);">
                    <!-- Avatar -->
                    <div
                        style="width: 80px; height: 80px; flex-shrink: 0; border-radius: var(--radius-lg); background: var(--theme-color); display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem; font-weight: 700; box-shadow: var(--shadow-md);">
                        {{ substr($profesor->nombre, 0, 1) . substr($profesor->apellido, 0, 1) }}
                    </div>

                    <!-- Info -->
                    <div
                        style="flex: 1; display: grid; grid-template-columns: 2fr 1fr 1fr; gap: var(--spacing-lg); align-items: center;">
                        <!-- Name & Email -->
                        <div>
                            <h3
                                style="font-size: 1.125rem; font-weight: 700; color: var(--gray-900); margin-bottom: var(--spacing-xs);">
                                {{ $profesor->nombre }} {{ $profesor->apellido }}
                            </h3>
                            <p style="color: var(--gray-600); font-size: 0.875rem; margin-bottom: var(--spacing-xs);">
                                <i class="fas fa-envelope" style="width: 16px;"></i> {{ $profesor->email }}
                            </p>
                            <p style="color: var(--gray-600); font-size: 0.875rem; margin: 0;">
                                <i class="fas fa-id-card" style="width: 16px;"></i> {{ $profesor->rut }}
                            </p>
                        </div>

                        <!-- Especialidad -->
                        <div>
                            <div
                                style="color: var(--gray-500); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: var(--spacing-xs);">
                                Especialidad
                            </div>
                            <div style="font-weight: 600; color: var(--gray-900);">
                                {{ $profesor->especialidad ?? 'N/A' }}
                            </div>
                        </div>

                        <!-- Teléfono -->
                        <div>
                            <div
                                style="color: var(--gray-500); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: var(--spacing-xs);">
                                Teléfono
                            </div>
                            <div style="font-weight: 600;">
                                {{ $profesor->telefono ?? 'N/A' }}
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div style="display: flex; gap: var(--spacing-sm); flex-shrink: 0;">
                        <a href="{{ route('teachers.edit', $profesor) }}" class="btn btn-primary btn-sm"
                            style="color: white;">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('teachers.destroy', $profesor) }}" method="POST"
                            onsubmit="return confirm('¿Estás seguro de querer eliminar este profesor?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline btn-sm"
                                style="color: #ef4444; border-color: #ef4444;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="card text-center" style="padding: var(--spacing-2xl);">
                <div style="margin-bottom: var(--spacing-md); font-size: 3rem; color: var(--gray-300);">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--gray-700);">No hay profesores registrados</h3>
                <p style="color: var(--gray-500);">Comienza agregando un nuevo profesor al sistema.</p>
            </div>
        @endforelse
    </div>

    <script>
        // View toggle functionality
        const gridViewBtn = document.getElementById('gridViewBtn');
        const listViewBtn = document.getElementById('listViewBtn');
        const gridView = document.getElementById('gridView');
        const listView = document.getElementById('listView');

        // Load saved preference or default to grid
        const savedView = localStorage.getItem('teachersView') || 'grid';
        if (savedView === 'list') {
            showListView();
        }

        gridViewBtn.addEventListener('click', () => {
            showGridView();
            localStorage.setItem('teachersView', 'grid');
        });

        listViewBtn.addEventListener('click', () => {
            showListView();
            localStorage.setItem('teachersView', 'list');
        });

        function showGridView() {
            gridView.style.display = 'grid';
            listView.style.display = 'none';
            gridViewBtn.style.background = 'white';
            gridViewBtn.style.color = 'var(--theme-dark)';
            listViewBtn.style.background = 'transparent';
            listViewBtn.style.color = 'white';
        }

        function showListView() {
            gridView.style.display = 'none';
            listView.style.display = 'block';
            listViewBtn.style.background = 'white';
            listViewBtn.style.color = 'var(--theme-dark)';
            gridViewBtn.style.background = 'transparent';
            gridViewBtn.style.color = 'white';
        }
    </script>
</x-app-layout>