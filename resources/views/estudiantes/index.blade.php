<x-app-layout>
    <x-slot name="header">
        Gestión de Estudiantes
    </x-slot>

    <!-- Header Actions -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-2xl);">
        <div>
            <h2 style="font-size: 1.75rem; font-weight: 700; color: var(--gray-900); margin-bottom: var(--spacing-xs);">
                <i class="fas fa-users"></i> Estudiantes
            </h2>
            <p style="color: var(--gray-600); margin: 0;">
                Gestiona la información de todos tus estudiantes
            </p>
        </div>
        <button class="btn btn-primary">
            <span>➕</span>
            <span>Nuevo Estudiante</span>
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
                        placeholder="🔍 Buscar estudiantes..."
                    >
                </div>
                <div class="form-group mb-0">
                    <select class="form-select">
                        <option>Todos los cursos</option>
                        <option>Matemáticas Avanzadas</option>
                        <option>Química Orgánica</option>
                        <option>Historia Universal</option>
                    </select>
                </div>
                <div class="form-group mb-0">
                    <select class="form-select">
                        <option>Todos los estados</option>
                        <option>Activo</option>
                        <option>Inactivo</option>
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

    <!-- Students Table -->
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Estudiante</th>
                    <th>Email</th>
                    <th>Curso Principal</th>
                    <th>Promedio</th>
                    <th>Asistencia</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="font-weight: 600; color: var(--gray-900);">#001</td>
                    <td>
                        <div style="display: flex; align-items: center; gap: var(--spacing-md);">
                            <div style="width: 40px; height: 40px; border-radius: var(--radius-full); background: var(--theme-color), var(--theme-color)); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700;">
                                JG
                            </div>
                            <div>
                                <div style="font-weight: 600; color: var(--gray-900);">Juan García</div>
                                <div style="font-size: 0.875rem; color: var(--gray-500);">Estudiante</div>
                            </div>
                        </div>
                    </td>
                    <td style="color: var(--gray-600);">juan.garcia@email.com</td>
                    <td>
                        <span class="badge badge-primary">Matemáticas</span>
                    </td>
                    <td>
                        <div style="font-weight: 700; color: var(--success); font-size: 1.125rem;">9.2</div>
                    </td>
                    <td>
                        <div style="font-weight: 600; color: var(--success);">96%</div>
                    </td>
                    <td>
                        <span class="badge badge-success">Activo</span>
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
                    <td style="font-weight: 600; color: var(--gray-900);">#002</td>
                    <td>
                        <div style="display: flex; align-items: center; gap: var(--spacing-md);">
                            <div style="width: 40px; height: 40px; border-radius: var(--radius-full); background: var(--theme-color), var(--theme-color)); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700;">
                                ML
                            </div>
                            <div>
                                <div style="font-weight: 600; color: var(--gray-900);">María López</div>
                                <div style="font-size: 0.875rem; color: var(--gray-500);">Estudiante</div>
                            </div>
                        </div>
                    </td>
                    <td style="color: var(--gray-600);">maria.lopez@email.com</td>
                    <td>
                        <span class="badge" style="background: var(--accent-100); color: var(--accent-700);">Química</span>
                    </td>
                    <td>
                        <div style="font-weight: 700; color: var(--success); font-size: 1.125rem;">8.8</div>
                    </td>
                    <td>
                        <div style="font-weight: 600; color: var(--success);">94%</div>
                    </td>
                    <td>
                        <span class="badge badge-success">Activo</span>
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
                    <td style="font-weight: 600; color: var(--gray-900);">#003</td>
                    <td>
                        <div style="display: flex; align-items: center; gap: var(--spacing-md);">
                            <div style="width: 40px; height: 40px; border-radius: var(--radius-full); background: var(--theme-color), #059669); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700;">
                                CR
                            </div>
                            <div>
                                <div style="font-weight: 600; color: var(--gray-900);">Carlos Rodríguez</div>
                                <div style="font-size: 0.875rem; color: var(--gray-500);">Estudiante</div>
                            </div>
                        </div>
                    </td>
                    <td style="color: var(--gray-600);">carlos.rodriguez@email.com</td>
                    <td>
                        <span class="badge" style="background: #d1fae5; color: #065f46;">Historia</span>
                    </td>
                    <td>
                        <div style="font-weight: 700; color: var(--warning); font-size: 1.125rem;">7.5</div>
                    </td>
                    <td>
                        <div style="font-weight: 600; color: var(--warning);">85%</div>
                    </td>
                    <td>
                        <span class="badge badge-success">Activo</span>
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
                    <td style="font-weight: 600; color: var(--gray-900);">#004</td>
                    <td>
                        <div style="display: flex; align-items: center; gap: var(--spacing-md);">
                            <div style="width: 40px; height: 40px; border-radius: var(--radius-full); background: var(--theme-color), var(--theme-dark)); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700;">
                                AM
                            </div>
                            <div>
                                <div style="font-weight: 600; color: var(--gray-900);">Ana Martínez</div>
                                <div style="font-size: 0.875rem; color: var(--gray-500);">Estudiante</div>
                            </div>
                        </div>
                    </td>
                    <td style="color: var(--gray-600);">ana.martinez@email.com</td>
                    <td>
                        <span class="badge badge-primary">Matemáticas</span>
                    </td>
                    <td>
                        <div style="font-weight: 700; color: var(--success); font-size: 1.125rem;">9.5</div>
                    </td>
                    <td>
                        <div style="font-weight: 600; color: var(--success);">98%</div>
                    </td>
                    <td>
                        <span class="badge badge-success">Activo</span>
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
            <button class="btn btn-ghost btn-sm">4</button>
        </div>
        <button class="btn btn-ghost btn-sm">Siguiente →</button>
    </div>
</x-app-layout>
