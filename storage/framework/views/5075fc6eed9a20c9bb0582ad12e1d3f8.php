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

    <!-- Search and Filters -->
    <div class="card mb-xl" style="border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
        <div class="card-body" style="padding: var(--spacing-lg);">
            <div class="grid" style="grid-template-columns: 2fr 1fr 1fr; gap: var(--spacing-md); align-items: center;">
                <!-- Search Input -->
                <div class="form-group mb-0" style="position: relative;">
                    <div style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--gray-400); font-size: 1.125rem;">
                        <i class="fas fa-search"></i>
                    </div>
                    <input type="text" id="searchInput" class="form-input" 
                        placeholder="Buscar cursos..." 
                        style="padding-left: 40px; border: 2px solid var(--gray-200); border-radius: var(--radius-lg); transition: all 0.2s; font-size: 0.9375rem;"
                        onfocus="this.style.borderColor='var(--theme-color)'; this.style.boxShadow='0 0 0 3px rgba(139, 92, 246, 0.1)'"
                        onblur="this.style.borderColor='var(--gray-200)'; this.style.boxShadow='none'">
                </div>
                
                <!-- Nivel Filter -->
                <div class="form-group mb-0" style="position: relative;">
                    <div style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--gray-400); font-size: 1rem; pointer-events: none; z-index: 1;">
                        <i class="fas fa-layer-group"></i>
                    </div>
                    <select id="nivelFilter" class="form-select" 
                        style="padding-left: 40px; border: 2px solid var(--gray-200); border-radius: var(--radius-lg); transition: all 0.2s; font-size: 0.9375rem; cursor: pointer;"
                        onfocus="this.style.borderColor='var(--theme-color)'; this.style.boxShadow='0 0 0 3px rgba(139, 92, 246, 0.1)'"
                        onblur="this.style.borderColor='var(--gray-200)'; this.style.boxShadow='none'">
                        <option value="">Todos los niveles</option>
                        <option value="pre-kinder">Pre-Kinder</option>
                        <option value="kinder">Kinder</option>
                        <option value="basica">Básica</option>
                        <option value="media">Media</option>
                    </select>
                </div>
                
                <!-- Profesor Filter -->
                <div class="form-group mb-0" style="position: relative;">
                    <div style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--gray-400); font-size: 1rem; pointer-events: none; z-index: 1;">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <select id="profesorFilter" class="form-select" 
                        style="padding-left: 40px; border: 2px solid var(--gray-200); border-radius: var(--radius-lg); transition: all 0.2s; font-size: 0.9375rem; cursor: pointer;"
                        onfocus="this.style.borderColor='var(--theme-color)'; this.style.boxShadow='0 0 0 3px rgba(139, 92, 246, 0.1)'"
                        onblur="this.style.borderColor='var(--gray-200)'; this.style.boxShadow='none'">
                        <option value="">Todos los profesores</option>
                        <?php $__currentLoopData = $cursos->unique('profesor_id')->filter(fn($c) => $c->profesor); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $curso): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($curso->profesor->id); ?>"><?php echo e($curso->profesor->nombre); ?> <?php echo e($curso->profesor->apellido); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- No Results Message (hidden by default) -->
    <div id="noResults" class="card mb-xl" style="display: none;">
        <div class="card-body text-center" style="padding: var(--spacing-2xl);">
            <i class="fas fa-search" style="font-size: 3rem; color: var(--gray-300); margin-bottom: var(--spacing-md);"></i>
            <p style="color: var(--gray-600); margin: 0;">No se encontraron cursos que coincidan con tu búsqueda</p>
        </div>
    </div>

    <!-- Mobile Cards View (hidden on desktop) -->
    <div class="mobile-cards" style="display: none;">
        <?php $__empty_1 = true; $__currentLoopData = $cursos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $curso): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="card mb-md curso-item" style="cursor: pointer;" onclick="window.location='<?php echo e(route('courses.show', $curso->id)); ?>'" 
                data-search="<?php echo e(strtolower($curso->nombre . ' ' . $curso->nivel)); ?>"
                data-nivel="<?php echo e($curso->nivel); ?>"
                data-profesor="<?php echo e($curso->profesor_id ?? ''); ?>">
                <div style="display: flex; align-items: center; gap: var(--spacing-md); margin-bottom: var(--spacing-md);">
                    <div style="width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, var(--theme-color), var(--theme-dark)); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 1rem;">
                        <?php if($curso->nivel === 'pre-kinder' || $curso->nivel === 'kinder'): ?>
                            <?php echo e(strtoupper(substr($curso->nivel, 0, 2))); ?><?php echo e($curso->letra); ?>

                        <?php else: ?>
                            <?php echo e($curso->grado); ?><?php echo e($curso->letra); ?>

                        <?php endif; ?>
                    </div>
                    <div style="flex: 1;">
                        <div style="font-weight: 700; color: var(--gray-900); font-size: 1.125rem;"><?php echo e($curso->nombre); ?></div>
                        <span class="badge badge-primary" style="margin-top: var(--spacing-xs);"><?php echo e(ucfirst($curso->nivel)); ?></span>
                    </div>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--spacing-md); margin-bottom: var(--spacing-md); padding: var(--spacing-md); background: var(--gray-50); border-radius: var(--radius-md);">
                    <div>
                        <div style="font-size: 0.75rem; color: var(--gray-500); text-transform: uppercase; margin-bottom: var(--spacing-xs);">Profesor Jefe</div>
                        <div style="font-weight: 600; color: var(--gray-900); font-size: 0.875rem;">
                            <?php if($curso->profesor): ?>
                                <?php echo e($curso->profesor->nombre); ?> <?php echo e($curso->profesor->apellido); ?>

                            <?php else: ?>
                                Sin asignar
                            <?php endif; ?>
                        </div>
                    </div>
                    <div>
                        <div style="font-size: 0.75rem; color: var(--gray-500); text-transform: uppercase; margin-bottom: var(--spacing-xs);">Estudiantes</div>
                        <div style="font-weight: 600; color: var(--gray-900); font-size: 0.875rem;">
                            <i class="fas fa-users" style="color: var(--theme-color); margin-right: var(--spacing-xs);"></i>
                            <?php echo e($curso->estudiantes_count ?? 0); ?>

                        </div>
                    </div>
                </div>

                <div style="display: flex; gap: var(--spacing-sm);" onclick="event.stopPropagation();">
                    <a href="<?php echo e(route('courses.edit', $curso->id)); ?>" class="btn btn-primary btn-sm" style="flex: 1; color: white;">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <form action="<?php echo e(route('courses.destroy', $curso->id)); ?>" method="POST" style="flex: 1;" onsubmit="return confirm('¿Está seguro de eliminar este curso?');">
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
                <i class="fas fa-graduation-cap" style="font-size: 3rem; margin-bottom: var(--spacing-md); opacity: 0.3; color: var(--gray-300);"></i>
                <p style="margin: 0; font-size: 1.125rem; color: var(--gray-500);">No hay cursos registrados</p>
                <p style="margin: var(--spacing-sm) 0 0 0; font-size: 0.875rem; color: var(--gray-500);">Haz clic en "Nuevo Curso" para comenzar</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Desktop Table View (hidden on mobile) -->
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
                    <tr class="curso-item" style="cursor: pointer;" onclick="window.location='<?php echo e(route('courses.show', $curso->id)); ?>'" 
                        data-search="<?php echo e(strtolower($curso->nombre . ' ' . $curso->nivel)); ?>"
                        data-nivel="<?php echo e($curso->nivel); ?>"
                        data-profesor="<?php echo e($curso->profesor_id ?? ''); ?>">
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

    <script>
        // Real-time search and filter functionality
        const searchInput = document.getElementById('searchInput');
        const nivelFilter = document.getElementById('nivelFilter');
        const profesorFilter = document.getElementById('profesorFilter');
        const noResults = document.getElementById('noResults');
        
        function filterCursos() {
            const searchTerm = searchInput.value.toLowerCase();
            const selectedNivel = nivelFilter.value.toLowerCase();
            const selectedProfesor = profesorFilter.value;
            
            const items = document.querySelectorAll('.curso-item');
            let visibleCount = 0;
            
            items.forEach(item => {
                const searchText = item.dataset.search || '';
                const nivel = item.dataset.nivel || '';
                const profesor = item.dataset.profesor || '';
                
                const matchesSearch = searchText.includes(searchTerm);
                const matchesNivel = !selectedNivel || nivel === selectedNivel;
                const matchesProfesor = !selectedProfesor || profesor === selectedProfesor;
                
                if (matchesSearch && matchesNivel && matchesProfesor) {
                    item.style.display = '';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });
            
            // Show/hide no results message
            noResults.style.display = visibleCount === 0 ? 'block' : 'none';
        }
        
        // Add event listeners for real-time filtering
        searchInput.addEventListener('input', filterCursos);
        nivelFilter.addEventListener('change', filterCursos);
        profesorFilter.addEventListener('change', filterCursos);
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