<x-app-layout>
    <x-slot name="header">
        Gestión de Asignaturas
    </x-slot>

    <!-- Header Actions -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-2xl);">
        <div>
            <h2 style="font-size: 1.75rem; font-weight: 700; color: var(--gray-900); margin-bottom: var(--spacing-xs);">
                📖 Asignaturas
            </h2>
            <p style="color: var(--gray-600); margin: 0;">
                Administra todas las asignaturas del sistema educativo
            </p>
        </div>
        <button class="btn btn-primary">
            <span>➕</span>
            <span>Nueva Asignatura</span>
        </button>
    </div>

    <!-- Search and Filters -->
    <div class="card mb-xl">
        <div class="card-body">
            <div class="grid grid-cols-4">
                <div class="form-group mb-0">
                    <input 
                        type="text" 
                        class="form-input" 
                        placeholder="🔍 Buscar asignaturas..."
                    >
                </div>
                <div class="form-group mb-0">
                    <select class="form-select">
                        <option>Todas las áreas</option>
                        <option>Ciencias</option>
                        <option>Humanidades</option>
                        <option>Matemáticas</option>
                        <option>Artes</option>
                    </select>
                </div>
                <div class="form-group mb-0">
                    <select class="form-select">
                        <option>Todos los niveles</option>
                        <option>Básico</option>
                        <option>Intermedio</option>
                        <option>Avanzado</option>
                    </select>
                </div>
                <div class="form-group mb-0">
                    <button class="btn btn-outline" style="width: 100%;">
                        <i class="fas fa-chart-bar"></i> Exportar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="grid grid-cols-4 mb-xl">
        <div class="stat-card">
            <div class="stat-icon">
                📖
            </div>
            <div class="stat-value">24</div>
            <div class="stat-label">Total Asignaturas</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-check"></i>
            </div>
            <div class="stat-value">18</div>
            <div class="stat-label">Activas</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                👨‍<i class="fas fa-school"></i>
            </div>
            <div class="stat-value">15</div>
            <div class="stat-label">Profesores Asignados</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-value">248</div>
            <div class="stat-label">Estudiantes Inscritos</div>
        </div>
    </div>

    <!-- Subjects Table -->
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Asignatura</th>
                    <th>Área</th>
                    <th>Nivel</th>
                    <th>Horas Semanales</th>
                    <th>Profesor</th>
                    <th>Estudiantes</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="font-weight: 600; color: var(--gray-900);">MAT-301</td>
                    <td>
                        <div style="display: flex; align-items: center; gap: var(--spacing-md);">
                            <div style="width: 45px; height: 45px; border-radius: var(--radius-md); background: var(--theme-color), var(--theme-color)); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">
                                📐
                            </div>
                            <div>
                                <div style="font-weight: 600; color: var(--gray-900);">Matemáticas Avanzadas</div>
                                <div style="font-size: 0.875rem; color: var(--gray-500);">Cálculo y Álgebra Lineal</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge badge-primary">Matemáticas</span>
                    </td>
                    <td>
                        <span class="badge" style="background: var(--secondary-100); color: var(--secondary-700);">Avanzado</span>
                    </td>
                    <td style="font-weight: 600; color: var(--gray-700);">6 hrs</td>
                    <td style="color: var(--gray-600);">Dr. Carlos Ruiz</td>
                    <td>
                        <div style="font-weight: 600; color: var(--theme-color);">32</div>
                    </td>
                    <td>
                        <span class="badge badge-success">Activa</span>
                    </td>
                    <td>
                        <div style="display: flex; gap: var(--spacing-sm);">
                            <button class="btn btn-ghost btn-sm"><i class="fas fa-eye"></i></button>
                            <button class="btn btn-ghost btn-sm"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-ghost btn-sm" style="color: var(--error);"><i class="fas fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: 600; color: var(--gray-900);">QUI-201</td>
                    <td>
                        <div style="display: flex; align-items: center; gap: var(--spacing-md);">
                            <div style="width: 45px; height: 45px; border-radius: var(--radius-md); background: var(--theme-color), var(--theme-color)); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">
                                ⚗️
                            </div>
                            <div>
                                <div style="font-weight: 600; color: var(--gray-900);">Química Orgánica</div>
                                <div style="font-size: 0.875rem; color: var(--gray-500);">Compuestos y Reacciones</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge" style="background: var(--accent-100); color: var(--accent-700);">Ciencias</span>
                    </td>
                    <td>
                        <span class="badge" style="background: var(--warning); color: white;">Intermedio</span>
                    </td>
                    <td style="font-weight: 600; color: var(--gray-700);">5 hrs</td>
                    <td style="color: var(--gray-600);">Dra. Ana Martínez</td>
                    <td>
                        <div style="font-weight: 600; color: var(--theme-color);">28</div>
                    </td>
                    <td>
                        <span class="badge badge-success">Activa</span>
                    </td>
                    <td>
                        <div style="display: flex; gap: var(--spacing-sm);">
                            <button class="btn btn-ghost btn-sm"><i class="fas fa-eye"></i></button>
                            <button class="btn btn-ghost btn-sm"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-ghost btn-sm" style="color: var(--error);"><i class="fas fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: 600; color: var(--gray-900);">HIS-101</td>
                    <td>
                        <div style="display: flex; align-items: center; gap: var(--spacing-md);">
                            <div style="width: 45px; height: 45px; border-radius: var(--radius-md); background: var(--theme-color), #059669); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">
                                🌍
                            </div>
                            <div>
                                <div style="font-weight: 600; color: var(--gray-900);">Historia Universal</div>
                                <div style="font-size: 0.875rem; color: var(--gray-500);">Edad Media a Moderna</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge" style="background: #d1fae5; color: #065f46;">Humanidades</span>
                    </td>
                    <td>
                        <span class="badge" style="background: var(--primary-100); color: var(--theme-dark);">Básico</span>
                    </td>
                    <td style="font-weight: 600; color: var(--gray-700);">4 hrs</td>
                    <td style="color: var(--gray-600);">Prof. Luis González</td>
                    <td>
                        <div style="font-weight: 600; color: var(--theme-color);">45</div>
                    </td>
                    <td>
                        <span class="badge badge-success">Activa</span>
                    </td>
                    <td>
                        <div style="display: flex; gap: var(--spacing-sm);">
                            <button class="btn btn-ghost btn-sm"><i class="fas fa-eye"></i></button>
                            <button class="btn btn-ghost btn-sm"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-ghost btn-sm" style="color: var(--error);"><i class="fas fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: 600; color: var(--gray-900);">FIS-202</td>
                    <td>
                        <div style="display: flex; align-items: center; gap: var(--spacing-md);">
                            <div style="width: 45px; height: 45px; border-radius: var(--radius-md); background: var(--theme-color); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">
                                ⚛️
                            </div>
                            <div>
                                <div style="font-weight: 600; color: var(--gray-900);">Física Cuántica</div>
                                <div style="font-size: 0.875rem; color: var(--gray-500);">Mecánica Cuántica Aplicada</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge" style="background: var(--accent-100); color: var(--accent-700);">Ciencias</span>
                    </td>
                    <td>
                        <span class="badge" style="background: var(--secondary-100); color: var(--secondary-700);">Avanzado</span>
                    </td>
                    <td style="font-weight: 600; color: var(--gray-700);">6 hrs</td>
                    <td style="color: var(--gray-600);">Dr. Roberto Pérez</td>
                    <td>
                        <div style="font-weight: 600; color: var(--theme-color);">18</div>
                    </td>
                    <td>
                        <span class="badge badge-success">Activa</span>
                    </td>
                    <td>
                        <div style="display: flex; gap: var(--spacing-sm);">
                            <button class="btn btn-ghost btn-sm"><i class="fas fa-eye"></i></button>
                            <button class="btn btn-ghost btn-sm"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-ghost btn-sm" style="color: var(--error);"><i class="fas fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: 600; color: var(--gray-900);">ART-101</td>
                    <td>
                        <div style="display: flex; align-items: center; gap: var(--spacing-md);">
                            <div style="width: 45px; height: 45px; border-radius: var(--radius-md); background: var(--theme-color); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">
                                <i class="fas fa-palette"></i>
                            </div>
                            <div>
                                <div style="font-weight: 600; color: var(--gray-900);">Arte y Cultura</div>
                                <div style="font-size: 0.875rem; color: var(--gray-500);">Historia del Arte</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge" style="background: #fce7f3; color: #9f1239;">Artes</span>
                    </td>
                    <td>
                        <span class="badge" style="background: var(--primary-100); color: var(--theme-dark);">Básico</span>
                    </td>
                    <td style="font-weight: 600; color: var(--gray-700);">3 hrs</td>
                    <td style="color: var(--gray-600);">Prof. María Silva</td>
                    <td>
                        <div style="font-weight: 600; color: var(--theme-color);">35</div>
                    </td>
                    <td>
                        <span class="badge badge-success">Activa</span>
                    </td>
                    <td>
                        <div style="display: flex; gap: var(--spacing-sm);">
                            <button class="btn btn-ghost btn-sm"><i class="fas fa-eye"></i></button>
                            <button class="btn btn-ghost btn-sm"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-ghost btn-sm" style="color: var(--error);"><i class="fas fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div style="display: flex; justify-content: center; align-items: center; gap: var(--spacing-md); margin-top: var(--spacing-xl);">
        <button class="btn btn-ghost btn-sm">← Anterior</button>
        <div style="display: flex; gap: var(--spacing-xs);">
            <button class="btn btn-primary btn-sm">1</button>
            <button class="btn btn-ghost btn-sm">2</button>
            <button class="btn btn-ghost btn-sm">3</button>
        </div>
        <button class="btn btn-ghost btn-sm">Siguiente →</button>
    </div>
</x-app-layout>
