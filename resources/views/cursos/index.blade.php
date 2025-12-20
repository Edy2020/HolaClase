<x-app-layout>
    <x-slot name="header">
        Gestión de Cursos
    </x-slot>

    <!-- Hero Header -->
    <div
        style="background: var(--theme-dark); color: white; padding: var(--spacing-2xl); border-radius: var(--radius-xl); margin-bottom: var(--spacing-2xl); box-shadow: var(--shadow-lg); display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2 style="color: white; font-size: 1.75rem; font-weight: 700; margin-bottom: var(--spacing-sm);">
                <i class="fas fa-graduation-cap"></i> Cursos
            </h2>
            <p style="font-size: 1rem; opacity: 0.95; margin: 0;">
                Administra todos los cursos de enseñanza básica y media
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
            <a href="{{ route('courses.create') }}" class="btn btn-primary"
                style="background: white; color: var(--theme-dark); flex-shrink: 0; text-decoration: none;">
                <span><i class="fas fa-plus"></i></span>
                <span>Nuevo Curso</span>
            </a>
        </div>
    </div>

    <!-- Courses Grid View -->
    <div id="gridView" class="grid grid-cols-3">
        @forelse ($cursos as $curso)
            <!-- Course Card -->
            <div class="card">
                <div style="text-align: center; margin-bottom: var(--spacing-lg);">
                    <div
                        style="width: 100px; height: 100px; margin: 0 auto var(--spacing-md); border-radius: var(--radius-lg); background: var(--theme-color); display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem; font-weight: 700; box-shadow: var(--shadow-lg);">
                        @if($curso->nivel === 'Pre-Kinder' || $curso->nivel === 'Kinder')
                            {{ substr($curso->nivel, 0, 2) }}{{ $curso->letra }}
                        @else
                            {{ $curso->grado }}{{ $curso->letra }}
                        @endif
                    </div>
                    <h3
                        style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900); margin-bottom: var(--spacing-xs);">
                        {{ $curso->nombre }}
                    </h3>
                    <p style="color: var(--gray-600); font-size: 0.875rem; margin: 0;">
                        {{ $curso->nivel }}
                    </p>
                </div>

                <div
                    style="padding: var(--spacing-md); background: var(--gray-50); border-radius: var(--radius-md); margin-bottom: var(--spacing-lg);">
                    <div style="display: flex; justify-content: space-between; margin-bottom: var(--spacing-sm);">
                        <span style="color: var(--gray-600); font-size: 0.875rem;">Nivel:</span>
                        <span style="font-weight: 600;">{{ $curso->nivel }}</span>
                    </div>
                    @if($curso->grado)
                        <div style="display: flex; justify-content: space-between; margin-bottom: var(--spacing-sm);">
                            <span style="color: var(--gray-600); font-size: 0.875rem;">Grado:</span>
                            <span style="font-weight: 600;">{{ $curso->grado }}</span>
                        </div>
                    @endif
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: var(--gray-600); font-size: 0.875rem;">Sección:</span>
                        <span style="font-weight: 600;">{{ $curso->letra }}</span>
                    </div>
                </div>

                <div style="display: flex; gap: var(--spacing-sm);">
                    <a href="{{ route('courses.edit', $curso) }}" class="btn btn-primary btn-sm"
                        style="color: white; flex: 1;">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <form action="{{ route('courses.destroy', $curso) }}" method="POST"
                        onsubmit="return confirm('¿Estás seguro de querer eliminar este curso?');" style="flex: 1;">
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
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--gray-700);">No hay cursos registrados</h3>
                <p style="color: var(--gray-500);">Comienza agregando un nuevo curso al sistema.</p>
            </div>
        @endforelse
    </div>

    <!-- Courses List View -->
    <div id="listView" style="display: none;">
        @forelse ($cursos as $curso)
            <!-- Course List Item -->
            <div class="card mb-md" style="padding: var(--spacing-lg);">
                <div style="display: flex; align-items: center; gap: var(--spacing-xl);">
                    <!-- Icon -->
                    <div
                        style="width: 80px; height: 80px; flex-shrink: 0; border-radius: var(--radius-lg); background: var(--theme-color); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem; font-weight: 700; box-shadow: var(--shadow-md);">
                        @if($curso->nivel === 'Pre-Kinder' || $curso->nivel === 'Kinder')
                            {{ substr($curso->nivel, 0, 2) }}{{ $curso->letra }}
                        @else
                            {{ $curso->grado }}{{ $curso->letra }}
                        @endif
                    </div>

                    <!-- Info -->
                    <div
                        style="flex: 1; display: grid; grid-template-columns: 2fr 1fr 1fr; gap: var(--spacing-lg); align-items: center;">
                        <!-- Name & Level -->
                        <div>
                            <h3
                                style="font-size: 1.125rem; font-weight: 700; color: var(--gray-900); margin-bottom: var(--spacing-xs);">
                                {{ $curso->nombre }}
                            </h3>
                            <p style="color: var(--gray-600); font-size: 0.875rem; margin: 0;">
                                <i class="fas fa-layer-group" style="width: 16px;"></i> {{ $curso->nivel }}
                            </p>
                        </div>

                        <!-- Grado -->
                        <div>
                            <div
                                style="color: var(--gray-500); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: var(--spacing-xs);">
                                Grado
                            </div>
                            <div style="font-weight: 600; color: var(--gray-900);">
                                {{ $curso->grado ?? 'N/A' }}
                            </div>
                        </div>

                        <!-- Sección -->
                        <div>
                            <div
                                style="color: var(--gray-500); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: var(--spacing-xs);">
                                Sección
                            </div>
                            <div style="font-weight: 600;">
                                {{ $curso->letra }}
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div style="display: flex; gap: var(--spacing-sm); flex-shrink: 0;">
                        <a href="{{ route('courses.edit', $curso) }}" class="btn btn-primary btn-sm" style="color: white;">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('courses.destroy', $curso) }}" method="POST"
                            onsubmit="return confirm('¿Estás seguro de querer eliminar este curso?');">
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
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--gray-700);">No hay cursos registrados</h3>
                <p style="color: var(--gray-500);">Comienza agregando un nuevo curso al sistema.</p>
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
        const savedView = localStorage.getItem('coursesView') || 'grid';
        if (savedView === 'list') {
            showListView();
        }

        gridViewBtn.addEventListener('click', () => {
            showGridView();
            localStorage.setItem('coursesView', 'grid');
        });

        listViewBtn.addEventListener('click', () => {
            showListView();
            localStorage.setItem('coursesView', 'list');
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