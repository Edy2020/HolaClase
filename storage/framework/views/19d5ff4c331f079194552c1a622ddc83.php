<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        Gestión de Profesores
     <?php $__env->endSlot(); ?>

    <!-- Hero Header -->
    <div style="background: var(--theme-dark); color: white; padding: var(--spacing-2xl); border-radius: var(--radius-xl); margin-bottom: var(--spacing-2xl); box-shadow: var(--shadow-lg); display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2 style="color: white; font-size: 1.75rem; font-weight: 700; margin-bottom: var(--spacing-sm);">
                <i class="fas fa-chalkboard-teacher"></i> Profesores
            </h2>
            <p style="font-size: 1rem; opacity: 0.95; margin: 0;">
                Administra el personal docente de la institución
            </p>
        </div>
        <button class="btn btn-primary" style="background: white; color: var(--theme-dark); flex-shrink: 0;">
            <span><i class="fas fa-plus"></i></span>
            <span>Nuevo Profesor</span>
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
                        placeholder="🔍 Buscar profesores..."
                    >
                </div>
                <div class="form-group mb-0">
                    <select class="form-select">
                        <option>Todas las especialidades</option>
                        <option>Matemáticas</option>
                        <option>Ciencias</option>
                        <option>Humanidades</option>
                        <option>Artes</option>
                    </select>
                </div>
                <div class="form-group mb-0">
                    <select class="form-select">
                        <option>Todos los estados</option>
                        <option>Activo</option>
                        <option>Inactivo</option>
                        <option>Licencia</option>
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
                <i class="fas fa-school"></i>
            </div>
            <div class="stat-value">15</div>
            <div class="stat-label">Total Profesores</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-check"></i>
            </div>
            <div class="stat-value">13</div>
            <div class="stat-label">Activos</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-book"></i>
            </div>
            <div class="stat-value">24</div>
            <div class="stat-label">Asignaturas Asignadas</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-star"></i>
            </div>
            <div class="stat-value">4.7</div>
            <div class="stat-label">Calificación Promedio</div>
        </div>
    </div>

    <!-- Teachers Grid -->
    <div class="grid grid-cols-3">
        <!-- Teacher Card 1 -->
        <div class="card">
            <div style="text-align: center; margin-bottom: var(--spacing-lg);">
                <div style="width: 100px; height: 100px; margin: 0 auto var(--spacing-md); border-radius: var(--radius-full); background: var(--theme-color), var(--theme-color)); display: flex; align-items: center; justify-content: center; color: white; font-size: 2.5rem; font-weight: 700; box-shadow: var(--shadow-lg);">
                    CR
                </div>
                <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900); margin-bottom: var(--spacing-xs);">
                    Dr. Carlos Ruiz
                </h3>
                <p style="color: var(--gray-600); font-size: 0.875rem; margin-bottom: var(--spacing-md);">
                    carlos.ruiz@holaclase.edu
                </p>
                <span class="badge badge-success">Activo</span>
            </div>
            
            <div style="padding: var(--spacing-md); background: var(--gray-50); border-radius: var(--radius-md); margin-bottom: var(--spacing-lg);">
                <div style="display: flex; justify-content: space-between; margin-bottom: var(--spacing-sm);">
                    <span style="color: var(--gray-600); font-size: 0.875rem;">Especialidad:</span>
                    <span style="font-weight: 600; color: var(--gray-900);">Matemáticas</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: var(--spacing-sm);">
                    <span style="color: var(--gray-600); font-size: 0.875rem;">Asignaturas:</span>
                    <span style="font-weight: 600; color: var(--theme-color);">3</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: var(--spacing-sm);">
                    <span style="color: var(--gray-600); font-size: 0.875rem;">Estudiantes:</span>
                    <span style="font-weight: 600; color: var(--theme-color);">85</span>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: var(--gray-600); font-size: 0.875rem;">Calificación:</span>
                    <span style="font-weight: 600; color: var(--warning);">⭐ 4.8</span>
                </div>
            </div>

            <div style="display: flex; flex-direction: column; gap: var(--spacing-sm);">
                <button class="btn btn-outline btn-sm">Ver Perfil</button>
                <div style="display: flex; gap: var(--spacing-sm);">
                    <button class="btn btn-ghost btn-sm" style="flex: 1;"><i class="fas fa-edit"></i> Editar</button>
                    <button class="btn btn-ghost btn-sm" style="flex: 1;">📧 Contactar</button>
                </div>
            </div>
        </div>

        <!-- Teacher Card 2 -->
        <div class="card">
            <div style="text-align: center; margin-bottom: var(--spacing-lg);">
                <div style="width: 100px; height: 100px; margin: 0 auto var(--spacing-md); border-radius: var(--radius-full); background: var(--theme-color), var(--theme-color)); display: flex; align-items: center; justify-content: center; color: white; font-size: 2.5rem; font-weight: 700; box-shadow: var(--shadow-lg);">
                    AM
                </div>
                <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900); margin-bottom: var(--spacing-xs);">
                    Dra. Ana Martínez
                </h3>
                <p style="color: var(--gray-600); font-size: 0.875rem; margin-bottom: var(--spacing-md);">
                    ana.martinez@holaclase.edu
                </p>
                <span class="badge badge-success">Activo</span>
            </div>
            
            <div style="padding: var(--spacing-md); background: var(--gray-50); border-radius: var(--radius-md); margin-bottom: var(--spacing-lg);">
                <div style="display: flex; justify-content: space-between; margin-bottom: var(--spacing-sm);">
                    <span style="color: var(--gray-600); font-size: 0.875rem;">Especialidad:</span>
                    <span style="font-weight: 600; color: var(--gray-900);">Química</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: var(--spacing-sm);">
                    <span style="color: var(--gray-600); font-size: 0.875rem;">Asignaturas:</span>
                    <span style="font-weight: 600; color: var(--theme-color);">2</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: var(--spacing-sm);">
                    <span style="color: var(--gray-600); font-size: 0.875rem;">Estudiantes:</span>
                    <span style="font-weight: 600; color: var(--theme-color);">56</span>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: var(--gray-600); font-size: 0.875rem;">Calificación:</span>
                    <span style="font-weight: 600; color: var(--warning);">⭐ 4.9</span>
                </div>
            </div>

            <div style="display: flex; flex-direction: column; gap: var(--spacing-sm);">
                <button class="btn btn-outline btn-sm">Ver Perfil</button>
                <div style="display: flex; gap: var(--spacing-sm);">
                    <button class="btn btn-ghost btn-sm" style="flex: 1;"><i class="fas fa-edit"></i> Editar</button>
                    <button class="btn btn-ghost btn-sm" style="flex: 1;">📧 Contactar</button>
                </div>
            </div>
        </div>

        <!-- Teacher Card 3 -->
        <div class="card">
            <div style="text-align: center; margin-bottom: var(--spacing-lg);">
                <div style="width: 100px; height: 100px; margin: 0 auto var(--spacing-md); border-radius: var(--radius-full); background: var(--theme-color), #059669); display: flex; align-items: center; justify-content: center; color: white; font-size: 2.5rem; font-weight: 700; box-shadow: var(--shadow-lg);">
                    LG
                </div>
                <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900); margin-bottom: var(--spacing-xs);">
                    Prof. Luis González
                </h3>
                <p style="color: var(--gray-600); font-size: 0.875rem; margin-bottom: var(--spacing-md);">
                    luis.gonzalez@holaclase.edu
                </p>
                <span class="badge badge-success">Activo</span>
            </div>
            
            <div style="padding: var(--spacing-md); background: var(--gray-50); border-radius: var(--radius-md); margin-bottom: var(--spacing-lg);">
                <div style="display: flex; justify-content: space-between; margin-bottom: var(--spacing-sm);">
                    <span style="color: var(--gray-600); font-size: 0.875rem;">Especialidad:</span>
                    <span style="font-weight: 600; color: var(--gray-900);">Historia</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: var(--spacing-sm);">
                    <span style="color: var(--gray-600); font-size: 0.875rem;">Asignaturas:</span>
                    <span style="font-weight: 600; color: var(--theme-color);">2</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: var(--spacing-sm);">
                    <span style="color: var(--gray-600); font-size: 0.875rem;">Estudiantes:</span>
                    <span style="font-weight: 600; color: var(--theme-color);">72</span>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: var(--gray-600); font-size: 0.875rem;">Calificación:</span>
                    <span style="font-weight: 600; color: var(--warning);">⭐ 4.6</span>
                </div>
            </div>

            <div style="display: flex; flex-direction: column; gap: var(--spacing-sm);">
                <button class="btn btn-outline btn-sm">Ver Perfil</button>
                <div style="display: flex; gap: var(--spacing-sm);">
                    <button class="btn btn-ghost btn-sm" style="flex: 1;"><i class="fas fa-edit"></i> Editar</button>
                    <button class="btn btn-ghost btn-sm" style="flex: 1;">📧 Contactar</button>
                </div>
            </div>
        </div>

        <!-- Teacher Card 4 -->
        <div class="card">
            <div style="text-align: center; margin-bottom: var(--spacing-lg);">
                <div style="width: 100px; height: 100px; margin: 0 auto var(--spacing-md); border-radius: var(--radius-full); background: var(--theme-color); display: flex; align-items: center; justify-content: center; color: white; font-size: 2.5rem; font-weight: 700; box-shadow: var(--shadow-lg);">
                    RP
                </div>
                <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900); margin-bottom: var(--spacing-xs);">
                    Dr. Roberto Pérez
                </h3>
                <p style="color: var(--gray-600); font-size: 0.875rem; margin-bottom: var(--spacing-md);">
                    roberto.perez@holaclase.edu
                </p>
                <span class="badge badge-success">Activo</span>
            </div>
            
            <div style="padding: var(--spacing-md); background: var(--gray-50); border-radius: var(--radius-md); margin-bottom: var(--spacing-lg);">
                <div style="display: flex; justify-content: space-between; margin-bottom: var(--spacing-sm);">
                    <span style="color: var(--gray-600); font-size: 0.875rem;">Especialidad:</span>
                    <span style="font-weight: 600; color: var(--gray-900);">Física</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: var(--spacing-sm);">
                    <span style="color: var(--gray-600); font-size: 0.875rem;">Asignaturas:</span>
                    <span style="font-weight: 600; color: var(--theme-color);">2</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: var(--spacing-sm);">
                    <span style="color: var(--gray-600); font-size: 0.875rem;">Estudiantes:</span>
                    <span style="font-weight: 600; color: var(--theme-color);">43</span>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: var(--gray-600); font-size: 0.875rem;">Calificación:</span>
                    <span style="font-weight: 600; color: var(--warning);">⭐ 4.7</span>
                </div>
            </div>

            <div style="display: flex; flex-direction: column; gap: var(--spacing-sm);">
                <button class="btn btn-outline btn-sm">Ver Perfil</button>
                <div style="display: flex; gap: var(--spacing-sm);">
                    <button class="btn btn-ghost btn-sm" style="flex: 1;"><i class="fas fa-edit"></i> Editar</button>
                    <button class="btn btn-ghost btn-sm" style="flex: 1;">📧 Contactar</button>
                </div>
            </div>
        </div>

        <!-- Teacher Card 5 -->
        <div class="card">
            <div style="text-align: center; margin-bottom: var(--spacing-lg);">
                <div style="width: 100px; height: 100px; margin: 0 auto var(--spacing-md); border-radius: var(--radius-full); background: var(--theme-color); display: flex; align-items: center; justify-content: center; color: white; font-size: 2.5rem; font-weight: 700; box-shadow: var(--shadow-lg);">
                    MS
                </div>
                <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900); margin-bottom: var(--spacing-xs);">
                    Prof. María Silva
                </h3>
                <p style="color: var(--gray-600); font-size: 0.875rem; margin-bottom: var(--spacing-md);">
                    maria.silva@holaclase.edu
                </p>
                <span class="badge badge-success">Activo</span>
            </div>
            
            <div style="padding: var(--spacing-md); background: var(--gray-50); border-radius: var(--radius-md); margin-bottom: var(--spacing-lg);">
                <div style="display: flex; justify-content: space-between; margin-bottom: var(--spacing-sm);">
                    <span style="color: var(--gray-600); font-size: 0.875rem;">Especialidad:</span>
                    <span style="font-weight: 600; color: var(--gray-900);">Artes</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: var(--spacing-sm);">
                    <span style="color: var(--gray-600); font-size: 0.875rem;">Asignaturas:</span>
                    <span style="font-weight: 600; color: var(--theme-color);">2</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: var(--spacing-sm);">
                    <span style="color: var(--gray-600); font-size: 0.875rem;">Estudiantes:</span>
                    <span style="font-weight: 600; color: var(--theme-color);">68</span>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: var(--gray-600); font-size: 0.875rem;">Calificación:</span>
                    <span style="font-weight: 600; color: var(--warning);">⭐ 4.9</span>
                </div>
            </div>

            <div style="display: flex; flex-direction: column; gap: var(--spacing-sm);">
                <button class="btn btn-outline btn-sm">Ver Perfil</button>
                <div style="display: flex; gap: var(--spacing-sm);">
                    <button class="btn btn-ghost btn-sm" style="flex: 1;"><i class="fas fa-edit"></i> Editar</button>
                    <button class="btn btn-ghost btn-sm" style="flex: 1;">📧 Contactar</button>
                </div>
            </div>
        </div>

        <!-- Teacher Card 6 -->
        <div class="card">
            <div style="text-align: center; margin-bottom: var(--spacing-lg);">
                <div style="width: 100px; height: 100px; margin: 0 auto var(--spacing-md); border-radius: var(--radius-full); background: var(--theme-color), var(--theme-dark)); display: flex; align-items: center; justify-content: center; color: white; font-size: 2.5rem; font-weight: 700; box-shadow: var(--shadow-lg);">
                    JR
                </div>
                <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900); margin-bottom: var(--spacing-xs);">
                    Prof. Jorge Ramírez
                </h3>
                <p style="color: var(--gray-600); font-size: 0.875rem; margin-bottom: var(--spacing-md);">
                    jorge.ramirez@holaclase.edu
                </p>
                <span class="badge badge-warning">Licencia</span>
            </div>
            
            <div style="padding: var(--spacing-md); background: var(--gray-50); border-radius: var(--radius-md); margin-bottom: var(--spacing-lg);">
                <div style="display: flex; justify-content: space-between; margin-bottom: var(--spacing-sm);">
                    <span style="color: var(--gray-600); font-size: 0.875rem;">Especialidad:</span>
                    <span style="font-weight: 600; color: var(--gray-900);">Biología</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: var(--spacing-sm);">
                    <span style="color: var(--gray-600); font-size: 0.875rem;">Asignaturas:</span>
                    <span style="font-weight: 600; color: var(--theme-color);">1</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: var(--spacing-sm);">
                    <span style="color: var(--gray-600); font-size: 0.875rem;">Estudiantes:</span>
                    <span style="font-weight: 600; color: var(--theme-color);">38</span>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: var(--gray-600); font-size: 0.875rem;">Calificación:</span>
                    <span style="font-weight: 600; color: var(--warning);">⭐ 4.5</span>
                </div>
            </div>

            <div style="display: flex; flex-direction: column; gap: var(--spacing-sm);">
                <button class="btn btn-outline btn-sm">Ver Perfil</button>
                <div style="display: flex; gap: var(--spacing-sm);">
                    <button class="btn btn-ghost btn-sm" style="flex: 1;"><i class="fas fa-edit"></i> Editar</button>
                    <button class="btn btn-ghost btn-sm" style="flex: 1;">📧 Contactar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div style="display: flex; justify-content: center; align-items: center; gap: var(--spacing-md); margin-top: var(--spacing-2xl);">
        <button class="btn btn-ghost btn-sm">← Anterior</button>
        <div style="display: flex; gap: var(--spacing-xs);">
            <button class="btn btn-primary btn-sm">1</button>
            <button class="btn btn-ghost btn-sm">2</button>
        </div>
        <button class="btn btn-ghost btn-sm">Siguiente →</button>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\Users\Edy\Downloads\laragon-portable\www\HolaClase\resources\views/profesores/index.blade.php ENDPATH**/ ?>