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
            <!-- View Toggle -->
            <div class="view-toggle"
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
            <a href="<?php echo e(route('courses.create')); ?>" class="btn btn-primary btn-new-course"
                style="background: white; color: var(--theme-dark); flex-shrink: 0; text-decoration: none;">
                <span><i class="fas fa-plus"></i></span>
                <span class="btn-text">Nuevo Curso</span>
            </a>
        </div>
    </div>

    <style>
        /* Clickable card styles */
        .clickable-card {
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .clickable-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
        }

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

            .view-toggle {
                width: 100% !important;
                justify-content: center !important;
            }

            .btn-new-course {
                width: 100% !important;
                justify-content: center !important;
            }

            .btn-text {
                display: inline !important;
            }

            /* Grid responsive */
            .grid-cols-3 {
                grid-template-columns: 1fr !important;
                gap: var(--spacing-md) !important;
            }

            /* Compact cards on mobile */
            #gridView .card {
                padding: var(--spacing-md) !important;
            }

            #gridView .card>div:first-child {
                margin-bottom: var(--spacing-sm) !important;
            }

            #gridView .card>div:first-child>div:first-child {
                width: 60px !important;
                height: 60px !important;
                font-size: 1.5rem !important;
                margin-bottom: var(--spacing-sm) !important;
            }

            #gridView .card h3 {
                font-size: 1rem !important;
                margin-bottom: 0.25rem !important;
            }

            #gridView .card p,
            #gridView .card div[style*="font-size: 0.875rem"] {
                font-size: 0.75rem !important;
                margin-bottom: 0.25rem !important;
            }

            #gridView .card .btn {
                padding: var(--spacing-sm) var(--spacing-md) !important;
                font-size: 0.875rem !important;
            }

            /* Compact list view on mobile */
            #listView .card {
                padding: var(--spacing-md) !important;
                margin-bottom: var(--spacing-sm) !important;
            }

            #listView .card>div:first-child {
                gap: var(--spacing-md) !important;
            }

            /* Badge in list view */
            #listView .card>div:first-child>div:first-child {
                width: 50px !important;
                height: 50px !important;
                font-size: 1.25rem !important;
            }

            /* Info grid in list view - stack vertically */
            #listView .card>div:first-child>div:nth-child(2) {
                grid-template-columns: 1fr !important;
                gap: var(--spacing-xs) !important;
            }

            /* Titles in list view */
            #listView .card h3 {
                font-size: 0.9rem !important;
                margin-bottom: 0.125rem !important;
            }

            /* Text in list view */
            #listView .card p,
            #listView .card div[style*="font-weight: 600"] {
                font-size: 0.75rem !important;
                margin-bottom: 0.125rem !important;
            }

            /* Section labels - make smaller */
            #listView .card div[style*="text-transform: uppercase"] {
                font-size: 0.65rem !important;
                margin-bottom: 0.125rem !important;
            }

            /* Buttons in list view */
            #listView .card .btn {
                padding: 0.375rem 0.5rem !important;
                font-size: 0.75rem !important;
            }

            #listView .card>div:last-child {
                gap: var(--spacing-xs) !important;
                margin-top: var(--spacing-sm) !important;
                flex-wrap: wrap !important;
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
            .table th:nth-child(4),
            .table td:nth-child(4),
            .table th:nth-child(5),
            .table td:nth-child(5) {
                display: none !important;
            }
        }
    </style>


    <!-- Courses Grid View -->
    <div id="gridView" class="grid grid-cols-3">
        <?php $__empty_1 = true; $__currentLoopData = $cursos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $curso): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <!-- Course Card -->
            <div class="card clickable-card" data-curso-url="<?php echo e(route('courses.show', $curso)); ?>">
                <div style="text-align: center; margin-bottom: var(--spacing-lg);">
                    <div
                        style="width: 100px; height: 100px; margin: 0 auto var(--spacing-md); border-radius: var(--radius-lg); background: var(--theme-color); display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem; font-weight: 700; box-shadow: var(--shadow-lg);">
                        <?php if($curso->nivel === 'Pre-Kinder' || $curso->nivel === 'Kinder'): ?>
                            <?php echo e(substr($curso->nivel, 0, 2)); ?><?php echo e($curso->letra); ?>

                        <?php else: ?>
                            <?php echo e($curso->grado); ?><?php echo e($curso->letra); ?>

                        <?php endif; ?>
                    </div>
                    <h3
                        style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900); margin-bottom: var(--spacing-xs);">
                        <?php echo e($curso->nombre); ?>

                    </h3>
                    <p style="color: var(--gray-600); font-size: 0.875rem; margin: 0;">
                        <i class="fas fa-layer-group" style="margin-right: var(--spacing-xs);"></i><?php echo e($curso->nivel); ?>

                    </p>
                    <p style="color: var(--gray-600); font-size: 0.875rem; margin: var(--spacing-xs) 0 0 0;">
                        <i class="fas fa-users" style="margin-right: var(--spacing-xs);"></i><?php echo e($curso->estudiantes_count); ?> estudiante<?php echo e($curso->estudiantes_count != 1 ? 's' : ''); ?>

                    </p>
                    <p style="color: var(--gray-600); font-size: 0.875rem; margin: var(--spacing-xs) 0 0 0;">
                        <i class="fas fa-chalkboard-teacher" style="margin-right: var(--spacing-xs);"></i><?php echo e($curso->profesor ? $curso->profesor->nombre . ' ' . $curso->profesor->apellido : 'Sin profesor'); ?>

                    </p>
                </div>

                <div class="card-actions" style="display: flex; gap: var(--spacing-sm);">
                    <a href="<?php echo e(route('courses.edit', $curso)); ?>" class="btn btn-primary btn-sm"
                        style="color: white; flex: 1;">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <form action="<?php echo e(route('courses.destroy', $curso)); ?>" method="POST"
                        onsubmit="return confirm('¿Estás seguro de querer eliminar este curso?');" style="flex: 1;">
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
            <div class="col-span-3">
                <div class="card text-center" style="padding: var(--spacing-2xl); width: 100%;">
                    <div style="margin-bottom: var(--spacing-md); font-size: 3rem; color: var(--gray-300);">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--gray-700);">No hay cursos registrados</h3>
                    <p style="color: var(--gray-500);">Comienza agregando un nuevo curso al sistema.</p>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Courses List View -->
    <div id="listView" style="display: none;">
        <?php $__empty_1 = true; $__currentLoopData = $cursos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $curso): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <!-- Course List Item -->
            <div class="card clickable-card mb-md" style="padding: var(--spacing-md);" data-curso-url="<?php echo e(route('courses.show', $curso)); ?>">
                <div style="display: flex; align-items: center; gap: var(--spacing-md);">
                    <!-- Icon -->
                    <div
                        style="width: 50px; height: 50px; flex-shrink: 0; border-radius: var(--radius-md); background: var(--theme-color); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.25rem; font-weight: 700; box-shadow: var(--shadow-sm);">
                        <?php if($curso->nivel === 'Pre-Kinder' || $curso->nivel === 'Kinder'): ?>
                            <?php echo e(substr($curso->nivel, 0, 2)); ?><?php echo e($curso->letra); ?>

                        <?php else: ?>
                            <?php echo e($curso->grado); ?><?php echo e($curso->letra); ?>

                        <?php endif; ?>
                    </div>

                    <!-- Info -->
                    <div
                        style="flex: 1; display: grid; grid-template-columns: 2fr 1fr 1fr; gap: var(--spacing-md); align-items: center;">
                        <!-- Name -->
                        <div>
                            <h3
                                style="font-size: 1rem; font-weight: 700; color: var(--gray-900); margin-bottom: 0.25rem;">
                                <?php echo e($curso->nombre); ?>

                            </h3>
                            <p style="color: var(--gray-600); font-size: 0.8125rem; margin: 0;">
                                <i class="fas fa-layer-group" style="width: 14px;"></i> <?php echo e($curso->nivel); ?>

                            </p>
                        </div>

                        <!-- Estudiantes -->
                        <div>
                            <div
                                style="color: var(--gray-500); font-size: 0.6875rem; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.25rem;">
                                Estudiantes
                            </div>
                            <div style="font-weight: 600; color: var(--gray-900); font-size: 0.875rem;">
                                <?php echo e($curso->estudiantes_count); ?>

                            </div>
                        </div>

                        <!-- Profesor Jefe -->
                        <div>
                            <div
                                style="color: var(--gray-500); font-size: 0.6875rem; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.25rem;">
                                Profesor Jefe
                            </div>
                            <div style="font-weight: 600; font-size: 0.875rem;">
                                <?php echo e($curso->profesor ? $curso->profesor->nombre . ' ' . $curso->profesor->apellido : 'Sin profesor'); ?>

                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="card-actions" style="display: flex; gap: var(--spacing-xs); flex-shrink: 0;">
                        <a href="<?php echo e(route('courses.edit', $curso)); ?>" class="btn btn-primary btn-sm"
                            style="color: white;">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="<?php echo e(route('courses.destroy', $curso)); ?>" method="POST"
                            onsubmit="return confirm('¿Estás seguro de querer eliminar este curso?');">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-outline btn-sm"
                                style="color: #ef4444; border-color: #ef4444;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="card text-center" style="padding: var(--spacing-2xl);">
                <div style="margin-bottom: var(--spacing-md); font-size: 3rem; color: var(--gray-300);">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--gray-700);">No hay cursos registrados</h3>
                <p style="color: var(--gray-500);">Comienza agregando un nuevo curso al sistema.</p>
            </div>
        <?php endif; ?>
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

        // Make cards clickable
        document.addEventListener('DOMContentLoaded', function() {
            const clickableCards = document.querySelectorAll('.clickable-card');
            
            clickableCards.forEach(card => {
                card.addEventListener('click', function(e) {
                    // Don't navigate if clicking on buttons, links, or forms
                    if (e.target.closest('.card-actions')) {
                        return;
                    }
                    
                    const url = this.getAttribute('data-curso-url');
                    if (url) {
                        window.location.href = url;
                    }
                });
            });
        });
    </script>
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