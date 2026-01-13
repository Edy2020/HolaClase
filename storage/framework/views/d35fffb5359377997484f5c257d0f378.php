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

    <!-- Asignaturas Grid -->
    <div class="grid grid-cols-3"
        style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: var(--spacing-lg);">
        <?php $__empty_1 = true; $__currentLoopData = $asignaturas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asignatura): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <!-- Asignatura Card -->
            <div class="card">
                <div style="text-align: center; margin-bottom: var(--spacing-lg);">
                    <div
                        style="width: 80px; height: 80px; margin: 0 auto var(--spacing-md); border-radius: var(--radius-lg); background: var(--theme-color); display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem; font-weight: 700; box-shadow: var(--shadow-lg);">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <h3
                        style="font-size: 1.125rem; font-weight: 700; color: var(--gray-900); margin-bottom: var(--spacing-xs);">
                        <?php echo e($asignatura->nombre); ?>

                    </h3>
                    <p style="color: var(--gray-600); font-size: 0.875rem; margin-bottom: var(--spacing-xs);">
                        <i class="fas fa-tag" style="margin-right: var(--spacing-xs);"></i><?php echo e($asignatura->codigo); ?>

                    </p>
                    <?php if($asignatura->descripcion): ?>
                        <p style="color: var(--gray-600); font-size: 0.875rem; margin: var(--spacing-sm) 0; line-height: 1.5;">
                            <?php echo e(Str::limit($asignatura->descripcion, 80)); ?>

                        </p>
                    <?php endif; ?>
                </div>

                <div style="display: flex; gap: var(--spacing-sm);">
                    <a href="<?php echo e(route('subjects.edit', $asignatura)); ?>" class="btn btn-primary btn-sm"
                        style="color: white; flex: 1;">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <form action="<?php echo e(route('subjects.destroy', $asignatura)); ?>" method="POST"
                        onsubmit="return confirm('¿Estás seguro de querer eliminar esta asignatura?');" style="flex: 1;">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-outline btn-sm"
                            style="width: 100%; color: #ef4444; border-color: #ef4444;">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
                    </form>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-3" style="grid-column: 1 / -1;">
                <div class="card text-center" style="padding: var(--spacing-2xl); width: 100%;">
                    <div style="margin-bottom: var(--spacing-md); font-size: 3rem; color: var(--gray-300);">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--gray-700);">No hay asignaturas registradas
                    </h3>
                    <p style="color: var(--gray-500); margin-bottom: var(--spacing-lg);">Comienza agregando una nueva
                        asignatura al sistema.</p>
                    <a href="<?php echo e(route('subjects.create')); ?>" class="btn btn-primary" style="color: white;">
                        <i class="fas fa-plus"></i> Crear Primera Asignatura
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <?php if($asignaturas->hasPages()): ?>
        <div style="margin-top: var(--spacing-xl);">
            <?php echo e($asignaturas->links()); ?>

        </div>
    <?php endif; ?>

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

            .grid-cols-3 {
                grid-template-columns: 1fr !important;
            }
        }
    </style>
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