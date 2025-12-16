<x-app-layout>
    <x-slot name="header">
        Gestión de Calificaciones
    </x-slot>

    <!-- Header -->
    <div style="margin-bottom: var(--spacing-2xl);">
        <h2 style="font-size: 1.75rem; font-weight: 700; color: var(--gray-900); margin-bottom: var(--spacing-xs);">
            <i class="fas fa-clipboard"></i> Gestión de Calificaciones
        </h2>
        <p style="color: var(--gray-600); margin: 0;">
            Registra y administra las calificaciones de tus estudiantes
        </p>
    </div>

    <!-- Course Selection -->
    <div class="card mb-xl">
        <div class="card-header">
            <h3 class="card-title">Seleccionar Curso y Evaluación</h3>
        </div>
        <div class="card-body">
            <div class="grid grid-cols-3">
                <div class="form-group mb-0">
                    <label class="form-label">Curso</label>
                    <select class="form-select">
                        <option>Selecciona un curso</option>
                        <option selected>Matemáticas Avanzadas</option>
                        <option>Química Orgánica</option>
                        <option>Historia Universal</option>
                        <option>Física I</option>
                    </select>
                </div>
                <div class="form-group mb-0">
                    <label class="form-label">Tipo de Evaluación</label>
                    <select class="form-select">
                        <option>Examen Parcial</option>
                        <option selected>Examen Final</option>
                        <option>Tarea</option>
                        <option>Proyecto</option>
                        <option>Participación</option>
                    </select>
                </div>
                <div class="form-group mb-0">
                    <label class="form-label">Peso (%)</label>
                    <input 
                        type="number" 
                        class="form-input" 
                        value="40"
                        min="0"
                        max="100"
                    >
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="grid grid-cols-4 mb-xl">
        <div class="stat-card">
            <div class="stat-value" style="color: var(--theme-color);">32</div>
            <div class="stat-label">Total Estudiantes</div>
        </div>
        <div class="stat-card">
            <div class="stat-value" style="color: var(--success);">8.5</div>
            <div class="stat-label">Promedio General</div>
        </div>
        <div class="stat-card">
            <div class="stat-value" style="color: var(--success);">9.8</div>
            <div class="stat-label">Nota Más Alta</div>
        </div>
        <div class="stat-card">
            <div class="stat-value" style="color: var(--warning);">6.2</div>
            <div class="stat-label">Nota Más Baja</div>
        </div>
    </div>

    <!-- Grades Table -->
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Estudiante</th>
                    <th>Parcial 1 (20%)</th>
                    <th>Parcial 2 (20%)</th>
                    <th>Final (40%)</th>
                    <th>Tareas (10%)</th>
                    <th>Participación (10%)</th>
                    <th>Promedio Final</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="font-weight: 600; color: var(--gray-900);">#001</td>
                    <td>
                        <div style="display: flex; align-items: center; gap: var(--spacing-md);">
                            <div style="width: 35px; height: 35px; border-radius: var(--radius-full); background: var(--theme-color), var(--theme-color)); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 0.875rem;">
                                JG
                            </div>
                            <div style="font-weight: 600; color: var(--gray-900);">Juan García</div>
                        </div>
                    </td>
                    <td>
                        <input 
                            type="number" 
                            class="form-input" 
                            value="9.0"
                            min="0"
                            max="10"
                            step="0.1"
                            style="width: 80px; padding: var(--spacing-sm);"
                        >
                    </td>
                    <td>
                        <input 
                            type="number" 
                            class="form-input" 
                            value="8.5"
                            min="0"
                            max="10"
                            step="0.1"
                            style="width: 80px; padding: var(--spacing-sm);"
                        >
                    </td>
                    <td>
                        <input 
                            type="number" 
                            class="form-input" 
                            value="9.5"
                            min="0"
                            max="10"
                            step="0.1"
                            style="width: 80px; padding: var(--spacing-sm);"
                        >
                    </td>
                    <td>
                        <input 
                            type="number" 
                            class="form-input" 
                            value="9.0"
                            min="0"
                            max="10"
                            step="0.1"
                            style="width: 80px; padding: var(--spacing-sm);"
                        >
                    </td>
                    <td>
                        <input 
                            type="number" 
                            class="form-input" 
                            value="10.0"
                            min="0"
                            max="10"
                            step="0.1"
                            style="width: 80px; padding: var(--spacing-sm);"
                        >
                    </td>
                    <td>
                        <div style="font-weight: 700; font-size: 1.125rem; color: var(--success);">9.2</div>
                    </td>
                    <td>
                        <span class="badge badge-success">Aprobado</span>
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: 600; color: var(--gray-900);">#002</td>
                    <td>
                        <div style="display: flex; align-items: center; gap: var(--spacing-md);">
                            <div style="width: 35px; height: 35px; border-radius: var(--radius-full); background: var(--theme-color), var(--theme-color)); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 0.875rem;">
                                ML
                            </div>
                            <div style="font-weight: 600; color: var(--gray-900);">María López</div>
                        </div>
                    </td>
                    <td>
                        <input 
                            type="number" 
                            class="form-input" 
                            value="8.5"
                            min="0"
                            max="10"
                            step="0.1"
                            style="width: 80px; padding: var(--spacing-sm);"
                        >
                    </td>
                    <td>
                        <input 
                            type="number" 
                            class="form-input" 
                            value="9.0"
                            min="0"
                            max="10"
                            step="0.1"
                            style="width: 80px; padding: var(--spacing-sm);"
                        >
                    </td>
                    <td>
                        <input 
                            type="number" 
                            class="form-input" 
                            value="8.8"
                            min="0"
                            max="10"
                            step="0.1"
                            style="width: 80px; padding: var(--spacing-sm);"
                        >
                    </td>
                    <td>
                        <input 
                            type="number" 
                            class="form-input" 
                            value="9.5"
                            min="0"
                            max="10"
                            step="0.1"
                            style="width: 80px; padding: var(--spacing-sm);"
                        >
                    </td>
                    <td>
                        <input 
                            type="number" 
                            class="form-input" 
                            value="8.0"
                            min="0"
                            max="10"
                            step="0.1"
                            style="width: 80px; padding: var(--spacing-sm);"
                        >
                    </td>
                    <td>
                        <div style="font-weight: 700; font-size: 1.125rem; color: var(--success);">8.8</div>
                    </td>
                    <td>
                        <span class="badge badge-success">Aprobado</span>
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: 600; color: var(--gray-900);">#003</td>
                    <td>
                        <div style="display: flex; align-items: center; gap: var(--spacing-md);">
                            <div style="width: 35px; height: 35px; border-radius: var(--radius-full); background: var(--theme-color), #059669); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 0.875rem;">
                                CR
                            </div>
                            <div style="font-weight: 600; color: var(--gray-900);">Carlos Rodríguez</div>
                        </div>
                    </td>
                    <td>
                        <input 
                            type="number" 
                            class="form-input" 
                            value="7.0"
                            min="0"
                            max="10"
                            step="0.1"
                            style="width: 80px; padding: var(--spacing-sm);"
                        >
                    </td>
                    <td>
                        <input 
                            type="number" 
                            class="form-input" 
                            value="7.5"
                            min="0"
                            max="10"
                            step="0.1"
                            style="width: 80px; padding: var(--spacing-sm);"
                        >
                    </td>
                    <td>
                        <input 
                            type="number" 
                            class="form-input" 
                            value="8.0"
                            min="0"
                            max="10"
                            step="0.1"
                            style="width: 80px; padding: var(--spacing-sm);"
                        >
                    </td>
                    <td>
                        <input 
                            type="number" 
                            class="form-input" 
                            value="7.0"
                            min="0"
                            max="10"
                            step="0.1"
                            style="width: 80px; padding: var(--spacing-sm);"
                        >
                    </td>
                    <td>
                        <input 
                            type="number" 
                            class="form-input" 
                            value="8.5"
                            min="0"
                            max="10"
                            step="0.1"
                            style="width: 80px; padding: var(--spacing-sm);"
                        >
                    </td>
                    <td>
                        <div style="font-weight: 700; font-size: 1.125rem; color: var(--warning);">7.5</div>
                    </td>
                    <td>
                        <span class="badge badge-warning">Regular</span>
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: 600; color: var(--gray-900);">#004</td>
                    <td>
                        <div style="display: flex; align-items: center; gap: var(--spacing-md);">
                            <div style="width: 35px; height: 35px; border-radius: var(--radius-full); background: var(--theme-color), var(--theme-dark)); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 0.875rem;">
                                AM
                            </div>
                            <div style="font-weight: 600; color: var(--gray-900);">Ana Martínez</div>
                        </div>
                    </td>
                    <td>
                        <input 
                            type="number" 
                            class="form-input" 
                            value="9.5"
                            min="0"
                            max="10"
                            step="0.1"
                            style="width: 80px; padding: var(--spacing-sm);"
                        >
                    </td>
                    <td>
                        <input 
                            type="number" 
                            class="form-input" 
                            value="9.8"
                            min="0"
                            max="10"
                            step="0.1"
                            style="width: 80px; padding: var(--spacing-sm);"
                        >
                    </td>
                    <td>
                        <input 
                            type="number" 
                            class="form-input" 
                            value="9.5"
                            min="0"
                            max="10"
                            step="0.1"
                            style="width: 80px; padding: var(--spacing-sm);"
                        >
                    </td>
                    <td>
                        <input 
                            type="number" 
                            class="form-input" 
                            value="10.0"
                            min="0"
                            max="10"
                            step="0.1"
                            style="width: 80px; padding: var(--spacing-sm);"
                        >
                    </td>
                    <td>
                        <input 
                            type="number" 
                            class="form-input" 
                            value="9.0"
                            min="0"
                            max="10"
                            step="0.1"
                            style="width: 80px; padding: var(--spacing-sm);"
                        >
                    </td>
                    <td>
                        <div style="font-weight: 700; font-size: 1.125rem; color: var(--success);">9.5</div>
                    </td>
                    <td>
                        <span class="badge badge-success">Aprobado</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Actions -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: var(--spacing-xl);">
        <button class="btn btn-outline">
            <i class="fas fa-chart-bar"></i> Exportar Reporte
        </button>
        <div style="display: flex; gap: var(--spacing-md);">
            <button class="btn btn-ghost">Cancelar</button>
            <button class="btn btn-primary">
                <i class="fas fa-save"></i> Guardar Calificaciones
            </button>
        </div>
    </div>
</x-app-layout>
