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
        Gestión de Asignaturas
     <?php $__env->endSlot(); ?>

    <!-- Success Message -->
    <?php if(session('success')): ?>
        <div class="alert alert-success"
            style="background: #10b981; color: white; padding: var(--spacing-md); border-radius: var(--radius-md); margin-bottom: var(--spacing-lg);">
            <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <!-- Hero Header -->
    <div class="hero-header"
        style="background: var(--theme-dark); color: white; padding: var(--spacing-2xl); border-radius: var(--radius-xl); margin-bottom: var(--spacing-2xl); box-shadow: var(--shadow-lg); display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2 style="color: white; font-size: 1.75rem; font-weight: 700; margin-bottom: var(--spacing-sm);">
                <i class="fas fa-book"></i> Asignaturas
            </h2>
            <p class="hero-description" style="font-size: 1rem; opacity: 0.95; margin: 0;">
                Administra todas las asignaturas del sistema educativo
            </p>
        </div>
        <div class="hero-actions">
            <a href="<?php echo e(route('subjects.create')); ?>" class="btn btn-primary btn-new-subject"
                style="background: white; color: var(--theme-dark); text-decoration: none;">
                <span><i class="fas fa-plus"></i></span>
                <span class="btn-text">Nueva Asignatura</span>
            </a>
        </div>
    </div>

    <style>
        /* Mobile Responsive Styles */
        @media (max-width: 768px) {
            .hero-header {
                flex-direction: column !important;
                gap: var(--spacing-lg) !important;
                padding: var(--spacing-lg) !important;
                text-align: center !important;
            }

            .hero-header h2 {
                font-size: 1.5rem !important;
            }

            .hero-description {
                font-size: 0.875rem !important;
            }

            .hero-actions {
                width: 100% !important;
            }

            .btn-new-subject {
                width: 100% !important;
                justify-content: center !important;
            }

            /* Hide table on mobile, show cards */
            .table-container {
                display: none !important;
            }

            .mobile-cards {
                display: block !important;
            }
        }

        /* Desktop: Show table, hide cards */
        @media (min-width: 769px) {
            .mobile-cards {
                display: none !important;
            }

            .table-container {
                display: block !important;
            }
        }
    </style>

    <!-- Mobile Cards View (hidden on desktop) -->
    <div class="mobile-cards" style="display: none;">
        <?php $__empty_1 = true; $__currentLoopData = $asignaturas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asignatura): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="card mb-md" style="cursor: pointer;" onclick="window.location='<?php echo e(route('subjects.show', $asignatura->id)); ?>'">
                <div style="display: flex; align-items: center; gap: var(--spacing-md); margin-bottom: var(--spacing-md);">
                    <div style="width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, var(--theme-color), var(--theme-dark)); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700;">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <div style="flex: 1;">
                        <div style="font-weight: 700; color: var(--gray-900); font-size: 1.125rem;"><?php echo e($asignatura->nombre); ?></div>
                        <span class="badge badge-primary" style="margin-top: var(--spacing-xs);"><?php echo e($asignatura->codigo); ?></span>
                    </div>
                </div>
                
                <div style="padding: var(--spacing-md); background: var(--gray-50); border-radius: var(--radius-md); margin-bottom: var(--spacing-md);">
                    <div style="font-size: 0.75rem; color: var(--gray-500); text-transform: uppercase; margin-bottom: var(--spacing-xs);">Descripción</div>
                    <div style="color: var(--gray-700); font-size: 0.875rem;"><?php echo e($asignatura->descripcion ? Str::limit($asignatura->descripcion, 100) : 'Sin descripción'); ?></div>
                </div>

                <div style="display: flex; gap: var(--spacing-sm);" onclick="event.stopPropagation();">
                    <a href="<?php echo e(route('subjects.edit', $asignatura->id)); ?>" class="btn btn-primary btn-sm" style="flex: 1; color: white;">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <form action="<?php echo e(route('subjects.destroy', $asignatura->id)); ?>" method="POST" style="flex: 1;" onsubmit="return confirm('¿Está seguro de eliminar esta asignatura?');">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-outline btn-sm" style="width: 100%; color: var(--error); border-color: var(--error);">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
                    </form>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="card text-center" style="padding: var(--spacing-2xl);">
                <i class="fas fa-book-open" style="font-size: 3rem; margin-bottom: var(--spacing-md); opacity: 0.3; color: var(--gray-300);"></i>
                <p style="margin: 0; font-size: 1.125rem; color: var(--gray-500);">No hay asignaturas registradas</p>
                <p style="margin: var(--spacing-sm) 0 0 0; font-size: 0.875rem; color: var(--gray-500);">Haz clic en "Nueva Asignatura" para comenzar</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Desktop Table View (hidden on mobile) -->
    <div class="table-container">
        <table class="table">
            <thead>
                <tr style="background: var(--theme-dark);">
                    <th style="color: white !important;">Asignatura</th>
                    <th style="color: white !important;">Código</th>
                    <th style="color: white !important;">Descripción</th>
                    <th style="color: white !important;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $asignaturas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asignatura): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr style="cursor: pointer;" onclick="window.location='<?php echo e(route('subjects.show', $asignatura->id)); ?>'">
                        <td>
                            <div style="display: flex; align-items: center; gap: var(--spacing-md);">
                                <div
                                    style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, var(--theme-color), var(--theme-dark)); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700;">
                                    <i class="fas fa-book-open"></i>
                                </div>
                                <div>
                                    <div style="font-weight: 600; color: var(--gray-900);">
                                        <?php echo e($asignatura->nombre); ?></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-primary"><?php echo e($asignatura->codigo); ?></span>
                        </td>
                        <td style="color: var(--gray-600); font-size: 0.875rem;">
                            <?php echo e($asignatura->descripcion ? Str::limit($asignatura->descripcion, 60) : 'Sin descripción'); ?>

                        </td>
                        <td>
                            <div style="display: flex; gap: var(--spacing-sm);" onclick="event.stopPropagation();">
                                <a href="<?php echo e(route('subjects.edit', $asignatura->id)); ?>" class="btn btn-ghost btn-sm"
                                    title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="<?php echo e(route('subjects.destroy', $asignatura->id)); ?>" method="POST"
                                    style="display: inline;"
                                    onsubmit="return confirm('¿Está seguro de eliminar esta asignatura?');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-ghost btn-sm" style="color: var(--error);"
                                        title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="4" style="text-align: center; padding: var(--spacing-2xl); color: var(--gray-500);">
                            <i class="fas fa-book-open"
                                style="font-size: 3rem; margin-bottom: var(--spacing-md); opacity: 0.3;"></i>
                            <p style="margin: 0; font-size: 1.125rem;">No hay asignaturas registradas</p>
                            <p style="margin: var(--spacing-sm) 0 0 0; font-size: 0.875rem;">Haz clic en "Nueva Asignatura"
                                para comenzar</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <?php if($asignaturas->hasPages()): ?>
        <div style="margin-top: var(--spacing-xl);">
            <?php echo e($asignaturas->links()); ?>

        </div>
    <?php endif; ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\Users\Edy\Downloads\laragon-portable\www\HolaClase\resources\views/asignaturas/index.blade.php ENDPATH**/ ?>