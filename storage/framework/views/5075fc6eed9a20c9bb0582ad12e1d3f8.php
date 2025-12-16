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
        Gestión de Cursos
     <?php $__env->endSlot(); ?>

    <!-- Hero Header -->
    <div style="background: var(--theme-dark); color: white; padding: var(--spacing-2xl); border-radius: var(--radius-xl); margin-bottom: var(--spacing-2xl); box-shadow: var(--shadow-lg); display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2 style="color: white; font-size: 1.75rem; font-weight: 700; margin-bottom: var(--spacing-sm);">
                <i class="fas fa-graduation-cap"></i> Cursos
            </h2>
            <p style="font-size: 1rem; opacity: 0.95; margin: 0;">
                Administra todos los cursos de enseñanza básica y media
            </p>
        </div>
        <button class="btn btn-primary" style="background: white; color: var(--theme-dark); flex-shrink: 0;">
            <span><i class="fas fa-plus"></i></span>
            <span>Nuevo Curso</span>
        </button>
    </div>

    <!-- Search and Filters -->
    <div class="card mb-xl">
        <div class="card-body">
            <div class="grid grid-cols-3">
                <div class="form-group mb-0">
                    <input 
                        type="text" 
                        class="form-input" 
                        placeholder="🔍 Buscar cursos..."
                    >
                </div>
                <div class="form-group mb-0">
                    <select class="form-select">
                        <option>Todos los niveles</option>
                        <option>Enseñanza Básica</option>
                        <option>Enseñanza Media</option>
                    </select>
                </div>
                <div class="form-group mb-0">
                    <select class="form-select">
                        <option>Todos los estados</option>
                        <option>Activo</option>
                        <option>Inactivo</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Courses Grid -->
    <div class="grid grid-cols-3">
        <!-- Primero Básico -->
        <div class="card">
            <div style="height: 120px; background: var(--theme-color); border-radius: var(--radius-lg) var(--radius-lg) 0 0; margin: calc(var(--spacing-xl) * -1) calc(var(--spacing-xl) * -1) var(--spacing-lg); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;">
                1°
            </div>
            <div>
                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: var(--spacing-md);">
                    <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900); margin: 0;">
                        Primero Básico
                    </h3>
                    <span class="badge badge-success">Activo</span>
                </div>
                <p style="color: var(--gray-600); font-size: 0.875rem; margin-bottom: var(--spacing-lg);">
                    Primer año de enseñanza básica
                </p>
                <div style="display: flex; gap: var(--spacing-lg); margin-bottom: var(--spacing-lg); padding-bottom: var(--spacing-lg); border-bottom: 1px solid var(--gray-200);">
                    <div>
                        <div style="font-size: 0.75rem; color: var(--gray-500); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: var(--spacing-xs);">
                            Alumnos
                        </div>
                        <div style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900);">
                            28
                        </div>
                    </div>
                    <div>
                        <div style="font-size: 0.75rem; color: var(--gray-500); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: var(--spacing-xs);">
                            Asistencia
                        </div>
                        <div style="font-size: 1.25rem; font-weight: 700; color: var(--success);">
                            96%
                        </div>
                    </div>
                </div>
                <div style="display: flex; gap: var(--spacing-sm);">
                    <button class="btn btn-outline btn-sm" style="flex: 1;">Ver</button>
                    <button class="btn btn-ghost btn-sm" style="flex: 1;">Editar</button>
                </div>
            </div>
        </div>

        <!-- Segundo Básico -->
        <div class="card">
            <div style="height: 120px; background: var(--theme-color); border-radius: var(--radius-lg) var(--radius-lg) 0 0; margin: calc(var(--spacing-xl) * -1) calc(var(--spacing-xl) * -1) var(--spacing-lg); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;">
                2°
            </div>
            <div>
                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: var(--spacing-md);">
                    <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900); margin: 0;">
                        Segundo Básico
                    </h3>
                    <span class="badge badge-success">Activo</span>
                </div>
                <p style="color: var(--gray-600); font-size: 0.875rem; margin-bottom: var(--spacing-lg);">
                    Segundo año de enseñanza básica
                </p>
                <div style="display: flex; gap: var(--spacing-lg); margin-bottom: var(--spacing-lg); padding-bottom: var(--spacing-lg); border-bottom: 1px solid var(--gray-200);">
                    <div>
                        <div style="font-size: 0.75rem; color: var(--gray-500); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: var(--spacing-xs);">
                            Alumnos
                        </div>
                        <div style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900);">
                            30
                        </div>
                    </div>
                    <div>
                        <div style="font-size: 0.75rem; color: var(--gray-500); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: var(--spacing-xs);">
                            Asistencia
                        </div>
                        <div style="font-size: 1.25rem; font-weight: 700; color: var(--success);">
                            94%
                        </div>
                    </div>
                </div>
                <div style="display: flex; gap: var(--spacing-sm);">
                    <button class="btn btn-outline btn-sm" style="flex: 1;">Ver</button>
                    <button class="btn btn-ghost btn-sm" style="flex: 1;">Editar</button>
                </div>
            </div>
        </div>

        <!-- Tercero Básico -->
        <div class="card">
            <div style="height: 120px; background: var(--theme-color); border-radius: var(--radius-lg) var(--radius-lg) 0 0; margin: calc(var(--spacing-xl) * -1) calc(var(--spacing-xl) * -1) var(--spacing-lg); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;">
                3°
            </div>
            <div>
                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: var(--spacing-md);">
                    <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900); margin: 0;">
                        Tercero Básico
                    </h3>
                    <span class="badge badge-success">Activo</span>
                </div>
                <p style="color: var(--gray-600); font-size: 0.875rem; margin-bottom: var(--spacing-lg);">
                    Tercer año de enseñanza básica
                </p>
                <div style="display: flex; gap: var(--spacing-lg); margin-bottom: var(--spacing-lg); padding-bottom: var(--spacing-lg); border-bottom: 1px solid var(--gray-200);">
                    <div>
                        <div style="font-size: 0.75rem; color: var(--gray-500); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: var(--spacing-xs);">
                            Alumnos
                        </div>
                        <div style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900);">
                            32
                        </div>
                    </div>
                    <div>
                        <div style="font-size: 0.75rem; color: var(--gray-500); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: var(--spacing-xs);">
                            Asistencia
                        </div>
                        <div style="font-size: 1.25rem; font-weight: 700; color: var(--success);">
                            95%
                        </div>
                    </div>
                </div>
                <div style="display: flex; gap: var(--spacing-sm);">
                    <button class="btn btn-outline btn-sm" style="flex: 1;">Ver</button>
                    <button class="btn btn-ghost btn-sm" style="flex: 1;">Editar</button>
                </div>
            </div>
        </div>

        <!-- Cuarto Básico -->
        <div class="card">
            <div style="height: 120px; background: var(--theme-color); border-radius: var(--radius-lg) var(--radius-lg) 0 0; margin: calc(var(--spacing-xl) * -1) calc(var(--spacing-xl) * -1) var(--spacing-lg); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;">
                4°
            </div>
            <div>
                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: var(--spacing-md);">
                    <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900); margin: 0;">
                        Cuarto Básico
                    </h3>
                    <span class="badge badge-success">Activo</span>
                </div>
                <p style="color: var(--gray-600); font-size: 0.875rem; margin-bottom: var(--spacing-lg);">
                    Cuarto año de enseñanza básica
                </p>
                <div style="display: flex; gap: var(--spacing-lg); margin-bottom: var(--spacing-lg); padding-bottom: var(--spacing-lg); border-bottom: 1px solid var(--gray-200);">
                    <div>
                        <div style="font-size: 0.75rem; color: var(--gray-500); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: var(--spacing-xs);">
                            Alumnos
                        </div>
                        <div style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900);">
                            29
                        </div>
                    </div>
                    <div>
                        <div style="font-size: 0.75rem; color: var(--gray-500); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: var(--spacing-xs);">
                            Asistencia
                        </div>
                        <div style="font-size: 1.25rem; font-weight: 700; color: var(--success);">
                            93%
                        </div>
                    </div>
                </div>
                <div style="display: flex; gap: var(--spacing-sm);">
                    <button class="btn btn-outline btn-sm" style="flex: 1;">Ver</button>
                    <button class="btn btn-ghost btn-sm" style="flex: 1;">Editar</button>
                </div>
            </div>
        </div>

        <!-- Primero Medio -->
        <div class="card">
            <div style="height: 120px; background: var(--theme-color); border-radius: var(--radius-lg) var(--radius-lg) 0 0; margin: calc(var(--spacing-xl) * -1) calc(var(--spacing-xl) * -1) var(--spacing-lg); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;">
                1°M
            </div>
            <div>
                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: var(--spacing-md);">
                    <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900); margin: 0;">
                        Primero Medio
                    </h3>
                    <span class="badge badge-success">Activo</span>
                </div>
                <p style="color: var(--gray-600); font-size: 0.875rem; margin-bottom: var(--spacing-lg);">
                    Primer año de enseñanza media
                </p>
                <div style="display: flex; gap: var(--spacing-lg); margin-bottom: var(--spacing-lg); padding-bottom: var(--spacing-lg); border-bottom: 1px solid var(--gray-200);">
                    <div>
                        <div style="font-size: 0.75rem; color: var(--gray-500); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: var(--spacing-xs);">
                            Alumnos
                        </div>
                        <div style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900);">
                            35
                        </div>
                    </div>
                    <div>
                        <div style="font-size: 0.75rem; color: var(--gray-500); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: var(--spacing-xs);">
                            Asistencia
                        </div>
                        <div style="font-size: 1.25rem; font-weight: 700; color: var(--success);">
                            91%
                        </div>
                    </div>
                </div>
                <div style="display: flex; gap: var(--spacing-sm);">
                    <button class="btn btn-outline btn-sm" style="flex: 1;">Ver</button>
                    <button class="btn btn-ghost btn-sm" style="flex: 1;">Editar</button>
                </div>
            </div>
        </div>

        <!-- Segundo Medio -->
        <div class="card">
            <div style="height: 120px; background: var(--theme-color); border-radius: var(--radius-lg) var(--radius-lg) 0 0; margin: calc(var(--spacing-xl) * -1) calc(var(--spacing-xl) * -1) var(--spacing-lg); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;">
                2°M
            </div>
            <div>
                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: var(--spacing-md);">
                    <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900); margin: 0;">
                        Segundo Medio
                    </h3>
                    <span class="badge badge-success">Activo</span>
                </div>
                <p style="color: var(--gray-600); font-size: 0.875rem; margin-bottom: var(--spacing-lg);">
                    Segundo año de enseñanza media
                </p>
                <div style="display: flex; gap: var(--spacing-lg); margin-bottom: var(--spacing-lg); padding-bottom: var(--spacing-lg); border-bottom: 1px solid var(--gray-200);">
                    <div>
                        <div style="font-size: 0.75rem; color: var(--gray-500); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: var(--spacing-xs);">
                            Alumnos
                        </div>
                        <div style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900);">
                            33
                        </div>
                    </div>
                    <div>
                        <div style="font-size: 0.75rem; color: var(--gray-500); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: var(--spacing-xs);">
                            Asistencia
                        </div>
                        <div style="font-size: 1.25rem; font-weight: 700; color: var(--warning);">
                            88%
                        </div>
                    </div>
                </div>
                <div style="display: flex; gap: var(--spacing-sm);">
                    <button class="btn btn-outline btn-sm" style="flex: 1;">Ver</button>
                    <button class="btn btn-ghost btn-sm" style="flex: 1;">Editar</button>
                </div>
            </div>
        </div>

        <!-- Tercero Medio -->
        <div class="card">
            <div style="height: 120px; background: var(--theme-color); border-radius: var(--radius-lg) var(--radius-lg) 0 0; margin: calc(var(--spacing-xl) * -1) calc(var(--spacing-xl) * -1) var(--spacing-lg); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;">
                3°M
            </div>
            <div>
                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: var(--spacing-md);">
                    <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900); margin: 0;">
                        Tercero Medio
                    </h3>
                    <span class="badge badge-success">Activo</span>
                </div>
                <p style="color: var(--gray-600); font-size: 0.875rem; margin-bottom: var(--spacing-lg);">
                    Tercer año de enseñanza media
                </p>
                <div style="display: flex; gap: var(--spacing-lg); margin-bottom: var(--spacing-lg); padding-bottom: var(--spacing-lg); border-bottom: 1px solid var(--gray-200);">
                    <div>
                        <div style="font-size: 0.75rem; color: var(--gray-500); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: var(--spacing-xs);">
                            Alumnos
                        </div>
                        <div style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900);">
                            31
                        </div>
                    </div>
                    <div>
                        <div style="font-size: 0.75rem; color: var(--gray-500); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: var(--spacing-xs);">
                            Asistencia
                        </div>
                        <div style="font-size: 1.25rem; font-weight: 700; color: var(--warning);">
                            87%
                        </div>
                    </div>
                </div>
                <div style="display: flex; gap: var(--spacing-sm);">
                    <button class="btn btn-outline btn-sm" style="flex: 1;">Ver</button>
                    <button class="btn btn-ghost btn-sm" style="flex: 1;">Editar</button>
                </div>
            </div>
        </div>

        <!-- Cuarto Medio -->
        <div class="card">
            <div style="height: 120px; background: var(--theme-color); border-radius: var(--radius-lg) var(--radius-lg) 0 0; margin: calc(var(--spacing-xl) * -1) calc(var(--spacing-xl) * -1) var(--spacing-lg); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;">
                4°M
            </div>
            <div>
                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: var(--spacing-md);">
                    <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900); margin: 0;">
                        Cuarto Medio
                    </h3>
                    <span class="badge badge-success">Activo</span>
                </div>
                <p style="color: var(--gray-600); font-size: 0.875rem; margin-bottom: var(--spacing-lg);">
                    Cuarto año de enseñanza media
                </p>
                <div style="display: flex; gap: var(--spacing-lg); margin-bottom: var(--spacing-lg); padding-bottom: var(--spacing-lg); border-bottom: 1px solid var(--gray-200);">
                    <div>
                        <div style="font-size: 0.75rem; color: var(--gray-500); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: var(--spacing-xs);">
                            Alumnos
                        </div>
                        <div style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900);">
                            27
                        </div>
                    </div>
                    <div>
                        <div style="font-size: 0.75rem; color: var(--gray-500); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: var(--spacing-xs);">
                            Asistencia
                        </div>
                        <div style="font-size: 1.25rem; font-weight: 700; color: var(--warning);">
                            85%
                        </div>
                    </div>
                </div>
                <div style="display: flex; gap: var(--spacing-sm);">
                    <button class="btn btn-outline btn-sm" style="flex: 1;">Ver</button>
                    <button class="btn btn-ghost btn-sm" style="flex: 1;">Editar</button>
                </div>
            </div>
        </div>
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
<?php /**PATH C:\Users\Edy\Downloads\laragon-portable\www\HolaClase\resources\views/cursos/index.blade.php ENDPATH**/ ?>