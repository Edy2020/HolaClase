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
    <div class="hero-header"
        style="background: var(--theme-dark); color: white; padding: var(--spacing-2xl); border-radius: var(--radius-xl); margin-bottom: var(--spacing-2xl); box-shadow: var(--shadow-lg); display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2 style="color: white; font-size: 1.75rem; font-weight: 700; margin-bottom: var(--spacing-sm);">
                <i class="fas fa-graduation-cap"></i> Cursos
            </h2>
            <p class="hero-description" style="font-size: 1rem; opacity: 0.95; margin: 0;">
                Administra todos los cursos de enseñanza básica y media
            </p>
        </div>
        <div class="hero-actions" style="display: flex; gap: var(--spacing-md); align-items: center;">
            <a href="<?php echo e(route('courses.create')); ?>" class="btn btn-primary btn-new-course"
                style="background: white; color: var(--theme-dark); flex-shrink: 0; text-decoration: none;">
                <span><i class="fas fa-plus"></i></span>
                <span class="btn-text">Nuevo Curso</span>
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
                flex-direction: column !important;
                gap: var(--spacing-sm) !important;
            }

            .btn-new-course {
                width: 100% !important;
                justify-content: center !important;
            }

            .btn-text {
                display: inline !important;
            }

            /* Table responsive */
            .table-container {
                overflow-x: auto !important;
            }

            .table {
                font-size: 0.875rem !important;
            }

            .table th,
            .table td {
                padding: var(--spacing-sm) !important;
            }

            /* Hide some columns on mobile */
            .table th:nth-child(3),
            .table td:nth-child(3),
            .table th:nth-child(4),
            .table td:nth-child(4) {
                display: none !important;
            }
        }
    </style>

    <!-- Courses Table -->
    <div class="table-container">
        <table class="table">
            <thead>
                <tr style="background: var(--theme-dark);">
                    <th style="color: white !important;">Curso</th>
                    <th style="color: white !important;">Nivel</th>
                    <th style="color: white !important;">Profesor Jefe</th>
                    <th style="color: white !important;">Estudiantes</th>
                    <th style="color: white !important;">Asignaturas</th>
                    <th style="color: white !important;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $cursos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $curso): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr style="cursor: pointer;" onclick="window.location='<?php echo e(route('courses.show', $curso->id)); ?>'">
                        <td>
                            <div style="display: flex; align-items: center; gap: var(--spacing-md);">
                                <div
                                    style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, var(--theme-color), var(--theme-dark)); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 0.875rem;">
                                    <?php if($curso->nivel === 'pre-kinder' || $curso->nivel === 'kinder'): ?>
                                        <?php echo e(strtoupper(substr($curso->nivel, 0, 2))); ?><?php echo e($curso->letra); ?>

                                    <?php else: ?>
                                        <?php echo e($curso->grado); ?><?php echo e($curso->letra); ?>

                                    <?php endif; ?>
                                </div>
                                <div>
                                    <div style="font-weight: 600; color: var(--gray-900);">
                                        <?php echo e($curso->nombre); ?></div>
                                    <div style="font-size: 0.875rem; color: var(--gray-500);">
                                        <?php echo e(ucfirst($curso->nivel)); ?>

                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-primary"><?php echo e(ucfirst($curso->nivel)); ?></span>
                        </td>
                        <td style="color: var(--gray-600);">
                            <?php if($curso->profesor): ?>
                                <div style="font-weight: 500;"><?php echo e($curso->profesor->nombre); ?> <?php echo e($curso->profesor->apellido); ?></div>
                            <?php else: ?>
                                <span style="color: var(--gray-400);">Sin profesor asignado</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div style="display: flex; align-items: center; gap: var(--spacing-xs);">
                                <i class="fas fa-users" style="color: var(--theme-color);"></i>
                                <span style="font-weight: 600; color: var(--gray-900);"><?php echo e($curso->estudiantes_count ?? 0); ?></span>
                            </div>
                        </td>
                        <td>
                            <div style="display: flex; align-items: center; gap: var(--spacing-xs);">
                                <i class="fas fa-book" style="color: var(--theme-color);"></i>
                                <span style="font-weight: 600; color: var(--gray-900);"><?php echo e($curso->asignaturas_count ?? 0); ?></span>
                            </div>
                        </td>
                        <td>
                            <div style="display: flex; gap: var(--spacing-sm);" onclick="event.stopPropagation();">
                                <a href="<?php echo e(route('courses.edit', $curso->id)); ?>" class="btn btn-ghost btn-sm"
                                    title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="<?php echo e(route('courses.destroy', $curso->id)); ?>" method="POST"
                                    style="display: inline;"
                                    onsubmit="return confirm('¿Está seguro de eliminar este curso?');">
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
                        <td colspan="6" style="text-align: center; padding: var(--spacing-2xl); color: var(--gray-500);">
                            <i class="fas fa-graduation-cap"
                                style="font-size: 3rem; margin-bottom: var(--spacing-md); opacity: 0.3;"></i>
                            <p style="margin: 0; font-size: 1.125rem;">No hay cursos registrados</p>
                            <p style="margin: var(--spacing-sm) 0 0 0; font-size: 0.875rem;">Haz clic en "Nuevo Curso"
                                para comenzar</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
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
<?php endif; ?><?php /**PATH C:\Users\Edy\Downloads\laragon-portable\www\HolaClase\resources\views/cursos/index.blade.php ENDPATH**/ ?>