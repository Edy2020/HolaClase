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

            .btn-new-teacher {
                width: 100% !important;
                justify-content: center !important;
            }

            .btn-text {
                display: inline !important;
            }

            /* Hide filters card on mobile */
            .filters-card {
                display: none !important;
            }

            /* Show mobile filter button */
            .mobile-filter-button {
                display: block !important;
            }

            /* Hide table on mobile, show table */
            .table-container {
                display: none !important;
            }

            .mobile-table {
                display: block !important;
            }
        }

        /* Desktop: Show table, hide mobile elements */
        @media (min-width: 769px) {
            .mobile-table {
                display: none !important;
            }

            .table-container {
                display: block !important;
            }

            .mobile-filter-button,
            .filters-modal {
                display: none !important;
            }
        }

        /* Filter Badge */
        .filter-badge {
            position: absolute;
            top: -6px;
            right: -6px;
            background: var(--error);
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 0.6875rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Filters Modal */
        .filters-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            animation: fadeIn 0.2s ease-out;
        }

        .filters-modal.active {
            display: flex;
            align-items: flex-end;
            justify-content: center;
        }

        .filters-modal-content {
            background: white;
            border-radius: var(--radius-xl) var(--radius-xl) 0 0;
            width: 100%;
            max-height: 70vh;
            overflow-y: auto;
            animation: slideUp 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .filters-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: var(--spacing-lg);
            border-bottom: 1px solid var(--gray-200);
            position: sticky;
            top: 0;
            background: white;
            z-index: 1;
        }

        .filters-modal-close {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--gray-100);
            border: none;
            color: var(--gray-600);
            font-size: 1.125rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .filters-modal-close:hover {
            background: var(--gray-200);
            color: var(--gray-900);
        }

        .filters-modal-body {
            padding: var(--spacing-lg);
        }

        .filters-modal-footer {
            padding: var(--spacing-lg);
            border-top: 1px solid var(--gray-200);
            display: flex;
            gap: var(--spacing-sm);
            position: sticky;
            bottom: 0;
            background: white;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from { transform: translateY(100%); }
            to { transform: translateY(0); }
        }
    </style>

    <!-- Search and Filters -->
    <div class="card mb-xl filters-card" style="border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
        <div class="card-body" style="padding: var(--spacing-lg);">
            <div class="grid" style="grid-template-columns: 2fr 1fr; gap: var(--spacing-md); align-items: center;">
                <!-- Search Input -->
                <div class="form-group mb-0" style="position: relative;">
                    <div style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--gray-400); font-size: 1.125rem;">
                        <i class="fas fa-search"></i>
                    </div>
                    <input type="text" id="searchInput" class="form-input" 
                        placeholder="Buscar profesores..." 
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
                        <option value="Básica">Básica</option>
                        <option value="Media">Media</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile: Standalone Filter Button -->
    <div class="mobile-filter-button" style="display: none; margin-bottom: var(--spacing-lg);">
        <button class="btn btn-primary" onclick="openFiltersModal()" 
            style="width: 100%; height: 48px; border-radius: var(--radius-lg); position: relative; display: flex; align-items: center; justify-content: center; gap: var(--spacing-sm); color: white;">
            <i class="fas fa-search"></i>
            <span>Buscar y Filtrar</span>
            <span id="filterBadgeMobile" class="filter-badge" style="display: none;">0</span>
        </button>
    </div>

    <!-- Filters Modal (Mobile only) -->
    <div id="filtersModal" class="filters-modal" onclick="closeFiltersModal()">
        <div class="filters-modal-content" onclick="event.stopPropagation()">
            <div class="filters-modal-header">
                <h3 style="margin: 0; font-size: 1.25rem; font-weight: 700; color: var(--gray-900);">
                    <i class="fas fa-search" style="color: var(--theme-color); margin-right: var(--spacing-sm);"></i>
                    Buscar y Filtrar
                </h3>
                <button onclick="closeFiltersModal()" class="filters-modal-close" aria-label="Cerrar">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="filters-modal-body">
                <div class="form-group">
                    <label class="form-label" style="font-size: 0.875rem; font-weight: 600; color: var(--gray-700); margin-bottom: var(--spacing-xs);">
                        <i class="fas fa-search" style="color: var(--theme-color);"></i> Buscar
                    </label>
                    <input type="text" id="searchInputMobile" class="form-input" 
                        placeholder="Buscar profesores..." 
                        style="border: 2px solid var(--gray-200); border-radius: var(--radius-lg); font-size: 0.9375rem;">
                </div>
                <div class="form-group mb-0">
                    <label class="form-label" style="font-size: 0.875rem; font-weight: 600; color: var(--gray-700); margin-bottom: var(--spacing-xs);">
                        <i class="fas fa-layer-group" style="color: var(--theme-color);"></i> Nivel
                    </label>
                    <select id="nivelFilterMobile" class="form-select" 
                        style="border: 2px solid var(--gray-200); border-radius: var(--radius-lg); font-size: 0.9375rem;">
                        <option value="">Todos los niveles</option>
                        <option value="Básica">Básica</option>
                        <option value="Media">Media</option>
                    </select>
                </div>
            </div>
            <div class="filters-modal-footer">
                <button onclick="clearFilters()" class="btn btn-outline" style="flex: 1;">Limpiar</button>
                <button onclick="applyFilters()" class="btn btn-primary" style="flex: 1; color: white;">Aplicar</button>
            </div>
        </div>
    </div>

    <!-- Mobile Table View (hidden on desktop) -->
    <div class="mobile-table" style="display: none;">
        <div class="mobile-table-container" style="background: white; border-radius: var(--radius-lg); overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <?php $__empty_1 = true; $__currentLoopData = $profesores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $profesor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="profesor-item mobile-table-row" 
                    style="border-bottom: 1px solid var(--gray-200); padding: var(--spacing-sm) var(--spacing-md); cursor: pointer; transition: background 0.2s;"
                    onclick="window.location='<?php echo e(route('teachers.show', $profesor->id)); ?>'" 
                    data-search="<?php echo e(strtolower($profesor->nombre . ' ' . $profesor->apellido . ' ' . $profesor->rut)); ?>"
                    data-nivel="<?php echo e($profesor->nivel_ensenanza ?? ''); ?>"
                    onmouseover="this.style.background='var(--gray-50)'"
                    onmouseout="this.style.background='white'">
                    
                    <div style="display: flex; align-items: center; gap: var(--spacing-sm);">
                        <div style="width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, var(--theme-color), var(--theme-dark)); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 0.75rem; flex-shrink: 0;">
                            <?php echo e(strtoupper(substr($profesor->nombre, 0, 1) . substr($profesor->apellido, 0, 1))); ?>

                        </div>
                        
                        <div style="flex: 1; min-width: 0;">
                            <div style="font-weight: 700; color: var(--gray-900); font-size: 0.9375rem; line-height: 1.3;"><?php echo e($profesor->nombre); ?> <?php echo e($profesor->apellido); ?></div>
                            <div style="font-size: 0.75rem; color: var(--gray-600); margin-top: 2px;">
                                <i class="fas fa-envelope" style="font-size: 0.625rem;"></i> <?php echo e($profesor->email ?? 'Sin email'); ?>

                            </div>
                        </div>
                        
                        <div style="display: flex; gap: 4px; flex-shrink: 0;" onclick="event.stopPropagation();">
                            <a href="<?php echo e(route('teachers.edit', $profesor->id)); ?>" 
                                style="width: 32px; height: 32px; border-radius: var(--radius-md); background: var(--theme-color); color: white; display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: 0.75rem;"
                                title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="<?php echo e(route('teachers.destroy', $profesor->id)); ?>" method="POST" style="margin: 0;" onsubmit="return confirm('¿Está seguro de eliminar este profesor?');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" 
                                    style="width: 32px; height: 32px; border-radius: var(--radius-md); background: white; color: var(--error); border: 1px solid var(--error); display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 0.75rem;"
                                    title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div style="padding: var(--spacing-xl); text-align: center; color: var(--gray-500);">
                    <i class="fas fa-chalkboard-teacher" style="font-size: 2rem; margin-bottom: var(--spacing-sm); opacity: 0.3;"></i>
                    <p style="margin: 0; font-size: 0.9375rem;">No hay profesores registrados</p>
                </div>
            <?php endif; ?>
        </div>
    </div>


    <!-- Desktop Table View (hidden on mobile) -->
    <div class="table-container">
        <table class="table">
            <thead>
                <tr style="background: var(--theme-dark);">
                    <th style="color: white !important;">Profesor</th>
                    <th style="color: white !important;">Email</th>
                    <th style="color: white !important;">Teléfono</th>
                    <th style="color: white !important;">Nivel</th>
                    <th style="color: white !important;">Título</th>
                    <th style="color: white !important;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $profesores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $profesor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="profesor-item" style="cursor: pointer;" onclick="window.location='<?php echo e(route('teachers.show', $profesor->id)); ?>'" \n                        data-search="<?php echo e(strtolower($profesor->nombre . ' ' . $profesor->apellido . ' ' . $profesor->rut)); ?>"\n                        data-nivel="<?php echo e($profesor->nivel_ensenanza ?? ''); ?>">
                        <td>
                            <div style="display: flex; align-items: center; gap: var(--spacing-md);">
                                <div
                                    style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, var(--theme-color), var(--theme-dark)); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700;">
                                    <?php echo e(strtoupper(substr($profesor->nombre, 0, 1) . substr($profesor->apellido, 0, 1))); ?>

                                </div>
                                <div>
                                    <div style="font-weight: 600; color: var(--gray-900);">
                                        <?php echo e($profesor->nombre); ?> <?php echo e($profesor->apellido); ?></div>
                                    <div style="font-size: 0.875rem; color: var(--gray-500);"><?php echo e($profesor->rut); ?></div>
                                </div>
                            </div>
                        </td>
                        <td style="color: var(--gray-600);"><?php echo e($profesor->email ?? 'Sin email'); ?></td>
                        <td style="color: var(--gray-600);"><?php echo e($profesor->telefono ?? 'Sin teléfono'); ?></td>
                        <td>
                            <?php if($profesor->nivel_ensenanza): ?>
                                <span class="badge badge-primary"><?php echo e($profesor->nivel_ensenanza); ?></span>
                            <?php else: ?>
                                <span class="badge">Sin nivel</span>
                            <?php endif; ?>
                        </td>
                        <td style="color: var(--gray-600); font-size: 0.875rem;">
                            <?php echo e($profesor->titulo ?? 'Sin título'); ?>

                        </td>
                        <td>
                            <div style="display: flex; gap: var(--spacing-sm);" onclick="event.stopPropagation();">
                                <a href="<?php echo e(route('teachers.edit', $profesor->id)); ?>" class="btn btn-ghost btn-sm"
                                    title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="<?php echo e(route('teachers.destroy', $profesor->id)); ?>" method="POST"
                                    style="display: inline;"
                                    onsubmit="return confirm('¿Está seguro de eliminar este profesor?');">
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
                            <i class="fas fa-chalkboard-teacher"
                                style="font-size: 3rem; margin-bottom: var(--spacing-md); opacity: 0.3;"></i>
                            <p style="margin: 0; font-size: 1.125rem;">No hay profesores registrados</p>
                            <p style="margin: var(--spacing-sm) 0 0 0; font-size: 0.875rem;">Haz clic en "Nuevo Profesor"
                                para comenzar</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- No Results Message (hidden by default) -->
    <div id="noResults" class="card mb-xl" style="display: none;">
        <div class="card-body text-center" style="padding: var(--spacing-2xl);">
            <i class="fas fa-search" style="font-size: 3rem; color: var(--gray-300); margin-bottom: var(--spacing-md);"></i>
            <p style="color: var(--gray-600); margin: 0;">No se encontraron profesores que coincidan con tu búsqueda</p>
        </div>
    </div>

    <script>
        const searchInput = document.getElementById('searchInput');
        const searchInputMobile = document.getElementById('searchInputMobile');
        const nivelFilter = document.getElementById('nivelFilter');
        const nivelFilterMobile = document.getElementById('nivelFilterMobile');
        const noResults = document.getElementById('noResults');
        const filterBadge = document.getElementById('filterBadgeMobile');
        
        function filterProfesores() {
            const searchTerm = (searchInput?.value || searchInputMobile?.value || '').toLowerCase();
            const selectedNivel = nivelFilter?.value || nivelFilterMobile?.value || '';
            const items = document.querySelectorAll('.profesor-item');
            let visibleCount = 0;
            
            items.forEach(item => {
                const searchText = item.dataset.search || '';
                const nivel = item.dataset.nivel || '';
                const matchesSearch = searchText.includes(searchTerm);
                const matchesNivel = !selectedNivel || nivel === selectedNivel;
                
                if (matchesSearch && matchesNivel) {
                    item.style.display = '';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });
            
            if (noResults) {
                noResults.style.display = visibleCount === 0 ? 'block' : 'none';
            }
            updateFilterBadge();
        }
        
        function updateFilterBadge() {
            const nivelValue = nivelFilterMobile?.value || '';
            const activeFilters = nivelValue ? 1 : 0;
            if (filterBadge) {
                filterBadge.textContent = activeFilters;
                filterBadge.style.display = activeFilters > 0 ? 'flex' : 'none';
            }
        }
        
        // Sync search and filters
        if (searchInput && searchInputMobile) {
            searchInput.addEventListener('input', () => {
                searchInputMobile.value = searchInput.value;
                filterProfesores();
            });
            searchInputMobile.addEventListener('input', () => {
                searchInput.value = searchInputMobile.value;
                filterProfesores();
            });
        }
        if (nivelFilter) nivelFilter.addEventListener('change', filterProfesores);
        
        // Modal functions
        function openFiltersModal() {
            const modal = document.getElementById('filtersModal');
            if (modal) {
                modal.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
        }
        
        function closeFiltersModal() {
            const modal = document.getElementById('filtersModal');
            if (modal) {
                modal.classList.remove('active');
                document.body.style.overflow = '';
            }
        }
        
        function applyFilters() {
            if (nivelFilter && nivelFilterMobile) {
                nivelFilter.value = nivelFilterMobile.value;
            }
            filterProfesores();
            closeFiltersModal();
        }
        
        function clearFilters() {
            // Clear mobile filters
            const searchInputMobile = document.getElementById('searchInputMobile');
            const nivelFilterMobile = document.getElementById('nivelFilterMobile');
            
            if (searchInputMobile) searchInputMobile.value = '';
            if (nivelFilterMobile) nivelFilterMobile.value = '';
            
            // Clear desktop filters
            const searchInput = document.getElementById('searchInput');
            const nivelFilter = document.getElementById('nivelFilter');
            
            if (searchInput) searchInput.value = '';
            if (nivelFilter) nivelFilter.value = '';
            
            // Apply the cleared filters
            filterProfesores();
            closeFiltersModal();
        }
        
        // Close on escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeFiltersModal();
            }
        });
        
        updateFilterBadge();
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