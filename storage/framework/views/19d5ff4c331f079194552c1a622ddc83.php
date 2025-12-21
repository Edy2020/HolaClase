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
    <div class="hero-header"
        style="background: var(--theme-dark); color: white; padding: var(--spacing-2xl); border-radius: var(--radius-xl); margin-bottom: var(--spacing-2xl); box-shadow: var(--shadow-lg); display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2 style="color: white; font-size: 1.75rem; font-weight: 700; margin-bottom: var(--spacing-sm);">
                <i class="fas fa-chalkboard-teacher"></i> Profesores
            </h2>
            <p class="hero-description" style="font-size: 1rem; opacity: 0.95; margin: 0;">
                Administra el personal docente de la institución
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
            <a href="<?php echo e(route('teachers.create')); ?>" class="btn btn-primary btn-new-teacher"
                style="background: white; color: var(--theme-dark); flex-shrink: 0;">
                <span><i class="fas fa-plus"></i></span>
                <span class="btn-text">Nuevo Profesor</span>
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

            .view-toggle {
                width: 100% !important;
                justify-content: center !important;
            }

            .btn-new-teacher {
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

            #gridView .card > div:first-child {
                margin-bottom: var(--spacing-sm) !important;
            }

            #gridView .card > div:first-child > div:first-child {
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

            #listView .card > div:first-child {
                gap: var(--spacing-md) !important;
            }

            /* Avatar in list view */
            #listView .card > div:first-child > div:first-child {
                width: 50px !important;
                height: 50px !important;
                font-size: 1.25rem !important;
            }

            /* Info grid in list view - stack vertically */
            #listView .card > div:first-child > div:nth-child(2) {
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

            #listView .card > div:last-child {
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
            .table th:nth-child(3),
            .table td:nth-child(3),
            .table th:nth-child(4),
            .table td:nth-child(4) {
                display: none !important;
            }
        }
    </style>


    <!-- Teachers Grid View -->
    <div id="gridView" class="grid grid-cols-3">
        <?php $__empty_1 = true; $__currentLoopData = $profesores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $profesor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <!-- Teacher Card -->
            <div class="card">
                <div style="text-align: center; margin-bottom: var(--spacing-lg);">
                    <div
                        style="width: 100px; height: 100px; margin: 0 auto var(--spacing-md); border-radius: var(--radius-lg); background: var(--theme-color); display: flex; align-items: center; justify-content: center; color: white; font-size: 2.5rem; font-weight: 700; box-shadow: var(--shadow-lg);">
                        <?php echo e(substr($profesor->nombre, 0, 1) . substr($profesor->apellido, 0, 1)); ?>

                    </div>
                    <h3
                        style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900); margin-bottom: var(--spacing-xs);">
                        <?php echo e($profesor->nombre); ?> <?php echo e($profesor->apellido); ?>

                    </h3>
                    <p style="color: var(--gray-600); font-size: 0.875rem; margin-bottom: var(--spacing-xs);">
                        <?php echo e($profesor->rut); ?>

                    </p>
                    <p style="color: var(--gray-600); font-size: 0.875rem; margin: 0;">
                        <?php echo e($profesor->email); ?>

                    </p>
                </div>

                <div
                    style="padding: var(--spacing-md); background: var(--gray-50); border-radius: var(--radius-md); margin-bottom: var(--spacing-lg);">
                    <div style="display: flex; justify-content: space-between; margin-bottom: var(--spacing-sm);">
                        <span style="color: var(--gray-600); font-size: 0.875rem;">Teléfono:</span>
                        <span style="font-weight: 600;"><?php echo e($profesor->telefono ?? 'N/A'); ?></span>
                    </div>
                </div>

                <div style="display: flex; gap: var(--spacing-sm);">
                    <a href="<?php echo e(route('teachers.edit', $profesor)); ?>" class="btn btn-primary btn-sm"
                        style="color: white; flex: 1;">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <form action="<?php echo e(route('teachers.destroy', $profesor)); ?>" method="POST"
                        onsubmit="return confirm('¿Estás seguro de querer eliminar este profesor?');" style="flex: 1;">
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
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--gray-700);">No hay profesores registrados</h3>
                    <p style="color: var(--gray-500);">Comienza agregando un nuevo profesor al sistema.</p>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Teachers List View -->
    <div id="listView" style="display: none;">
        <?php $__empty_1 = true; $__currentLoopData = $profesores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $profesor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <!-- Teacher List Item -->
            <div class="card mb-md" style="padding: var(--spacing-lg);">
                <div style="display: flex; align-items: center; gap: var(--spacing-xl);">
                    <!-- Avatar -->
                    <div
                        style="width: 80px; height: 80px; flex-shrink: 0; border-radius: var(--radius-lg); background: var(--theme-color); display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem; font-weight: 700; box-shadow: var(--shadow-md);">
                        <?php echo e(substr($profesor->nombre, 0, 1) . substr($profesor->apellido, 0, 1)); ?>

                    </div>

                    <!-- Info -->
                    <div
                        style="flex: 1; display: grid; grid-template-columns: 2fr 1fr 1fr; gap: var(--spacing-lg); align-items: center;">
                        <!-- Name & Email -->
                        <div>
                            <h3
                                style="font-size: 1.125rem; font-weight: 700; color: var(--gray-900); margin-bottom: var(--spacing-xs);">
                                <?php echo e($profesor->nombre); ?> <?php echo e($profesor->apellido); ?>

                            </h3>
                            <p style="color: var(--gray-600); font-size: 0.875rem; margin-bottom: var(--spacing-xs);">
                                <i class="fas fa-envelope" style="width: 16px;"></i> <?php echo e($profesor->email); ?>

                            </p>
                            <p style="color: var(--gray-600); font-size: 0.875rem; margin: 0;">
                                <i class="fas fa-id-card" style="width: 16px;"></i> <?php echo e($profesor->rut); ?>

                            </p>
                        </div>

                        <!-- Especialidad -->
                        <div>
                            <div
                                style="color: var(--gray-500); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: var(--spacing-xs);">
                                Especialidad
                            </div>
                            <div style="font-weight: 600; color: var(--gray-900);">
                                <?php echo e($profesor->especialidad ?? 'N/A'); ?>

                            </div>
                        </div>

                        <!-- Teléfono -->
                        <div>
                            <div
                                style="color: var(--gray-500); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: var(--spacing-xs);">
                                Teléfono
                            </div>
                            <div style="font-weight: 600;">
                                <?php echo e($profesor->telefono ?? 'N/A'); ?>

                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div style="display: flex; gap: var(--spacing-sm); flex-shrink: 0;">
                        <a href="<?php echo e(route('teachers.edit', $profesor)); ?>" class="btn btn-primary btn-sm"
                            style="color: white;">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="<?php echo e(route('teachers.destroy', $profesor)); ?>" method="POST"
                            onsubmit="return confirm('¿Estás seguro de querer eliminar este profesor?');">
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
                    <i class="fas fa-user-graduate"></i>
                </div>
                <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--gray-700);">No hay profesores registrados</h3>
                <p style="color: var(--gray-500);">Comienza agregando un nuevo profesor al sistema.</p>
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
        const savedView = localStorage.getItem('teachersView') || 'grid';
        if (savedView === 'list') {
            showListView();
        }

        gridViewBtn.addEventListener('click', () => {
            showGridView();
            localStorage.setItem('teachersView', 'grid');
        });

        listViewBtn.addEventListener('click', () => {
            showListView();
            localStorage.setItem('teachersView', 'list');
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
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\Users\Edy\Downloads\laragon-portable\www\HolaClase\resources\views/profesores/index.blade.php ENDPATH**/ ?>