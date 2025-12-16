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
        Control de Asistencia
     <?php $__env->endSlot(); ?>

    <!-- Hero Header -->
    <div style="background: var(--theme-dark); color: white; padding: var(--spacing-2xl); border-radius: var(--radius-xl); margin-bottom: var(--spacing-2xl); box-shadow: var(--shadow-lg);">
        <h2 style="color: white; font-size: 1.75rem; font-weight: 700; margin-bottom: var(--spacing-sm);">
            <i class="fas fa-calendar-check"></i> Control de Asistencia
        </h2>
        <p style="font-size: 1rem; opacity: 0.95; margin: 0;">
            Registra la asistencia de tus estudiantes de forma rápida y eficiente
        </p>
    </div>

    <!-- Course and Date Selection -->
    <div class="card mb-xl">
        <div class="card-header">
            <h3 class="card-title">Seleccionar Curso y Fecha</h3>
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
                    <label class="form-label">Fecha</label>
                    <input 
                        type="date" 
                        class="form-input" 
                        value="<?php echo e(date('Y-m-d')); ?>"
                    >
                </div>
                <div class="form-group mb-0">
                    <label class="form-label">Hora</label>
                    <input 
                        type="time" 
                        class="form-input" 
                        value="<?php echo e(date('H:i')); ?>"
                    >
                </div>
            </div>
        </div>
    </div>

    <!-- Attendance Summary -->
    <div class="grid grid-cols-4 mb-xl">
        <div class="stat-card">
            <div class="stat-value" style="color: var(--theme-color);">32</div>
            <div class="stat-label">Total Estudiantes</div>
        </div>
        <div class="stat-card">
            <div class="stat-value" style="color: var(--success);">28</div>
            <div class="stat-label">Presentes</div>
        </div>
        <div class="stat-card">
            <div class="stat-value" style="color: var(--error);">3</div>
            <div class="stat-label">Ausentes</div>
        </div>
        <div class="stat-card">
            <div class="stat-value" style="color: var(--warning);">1</div>
            <div class="stat-label">Tardanzas</div>
        </div>
    </div>

    <!-- Attendance List -->
    <div class="card">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h3 class="card-title mb-0">Lista de Asistencia</h3>
            <div style="display: flex; gap: var(--spacing-md);">
                <button class="btn btn-ghost btn-sm"><i class="fas fa-check"></i> Marcar Todos Presentes</button>
                <button class="btn btn-ghost btn-sm">✗ Marcar Todos Ausentes</button>
            </div>
        </div>
        <div class="card-body">
            <div style="display: flex; flex-direction: column; gap: var(--spacing-md);">
                <!-- Student 1 -->
                <div style="display: flex; align-items: center; justify-content: space-between; padding: var(--spacing-md); background: var(--gray-50); border-radius: var(--radius-md); border-left: 4px solid var(--success);">
                    <div style="display: flex; align-items: center; gap: var(--spacing-md); flex: 1;">
                        <div style="width: 50px; height: 50px; border-radius: var(--radius-full); background: var(--theme-color), var(--theme-color)); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 1.125rem;">
                            JG
                        </div>
                        <div style="flex: 1;">
                            <div style="font-weight: 600; color: var(--gray-900); margin-bottom: var(--spacing-xs);">
                                Juan García
                            </div>
                            <div style="font-size: 0.875rem; color: var(--gray-600);">
                                ID: #001 • juan.garcia@email.com
                            </div>
                        </div>
                    </div>
                    <div style="display: flex; gap: var(--spacing-sm);">
                        <button class="btn btn-sm" style="background: var(--success); color: white;">
                            <i class="fas fa-check"></i> Presente
                        </button>
                        <button class="btn btn-ghost btn-sm">
                            ⏰ Tarde
                        </button>
                        <button class="btn btn-ghost btn-sm">
                            ✗ Ausente
                        </button>
                    </div>
                </div>

                <!-- Student 2 -->
                <div style="display: flex; align-items: center; justify-content: space-between; padding: var(--spacing-md); background: var(--gray-50); border-radius: var(--radius-md); border-left: 4px solid var(--success);">
                    <div style="display: flex; align-items: center; gap: var(--spacing-md); flex: 1;">
                        <div style="width: 50px; height: 50px; border-radius: var(--radius-full); background: var(--theme-color), var(--theme-color)); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 1.125rem;">
                            ML
                        </div>
                        <div style="flex: 1;">
                            <div style="font-weight: 600; color: var(--gray-900); margin-bottom: var(--spacing-xs);">
                                María López
                            </div>
                            <div style="font-size: 0.875rem; color: var(--gray-600);">
                                ID: #002 • maria.lopez@email.com
                            </div>
                        </div>
                    </div>
                    <div style="display: flex; gap: var(--spacing-sm);">
                        <button class="btn btn-sm" style="background: var(--success); color: white;">
                            <i class="fas fa-check"></i> Presente
                        </button>
                        <button class="btn btn-ghost btn-sm">
                            ⏰ Tarde
                        </button>
                        <button class="btn btn-ghost btn-sm">
                            ✗ Ausente
                        </button>
                    </div>
                </div>

                <!-- Student 3 -->
                <div style="display: flex; align-items: center; justify-content: space-between; padding: var(--spacing-md); background: var(--gray-50); border-radius: var(--radius-md); border-left: 4px solid var(--error);">
                    <div style="display: flex; align-items: center; gap: var(--spacing-md); flex: 1;">
                        <div style="width: 50px; height: 50px; border-radius: var(--radius-full); background: var(--theme-color), #059669); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 1.125rem;">
                            CR
                        </div>
                        <div style="flex: 1;">
                            <div style="font-weight: 600; color: var(--gray-900); margin-bottom: var(--spacing-xs);">
                                Carlos Rodríguez
                            </div>
                            <div style="font-size: 0.875rem; color: var(--gray-600);">
                                ID: #003 • carlos.rodriguez@email.com
                            </div>
                        </div>
                    </div>
                    <div style="display: flex; gap: var(--spacing-sm);">
                        <button class="btn btn-ghost btn-sm">
                            <i class="fas fa-check"></i> Presente
                        </button>
                        <button class="btn btn-ghost btn-sm">
                            ⏰ Tarde
                        </button>
                        <button class="btn btn-sm" style="background: var(--error); color: white;">
                            ✗ Ausente
                        </button>
                    </div>
                </div>

                <!-- Student 4 -->
                <div style="display: flex; align-items: center; justify-content: space-between; padding: var(--spacing-md); background: var(--gray-50); border-radius: var(--radius-md); border-left: 4px solid var(--warning);">
                    <div style="display: flex; align-items: center; gap: var(--spacing-md); flex: 1;">
                        <div style="width: 50px; height: 50px; border-radius: var(--radius-full); background: var(--theme-color), var(--theme-dark)); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 1.125rem;">
                            AM
                        </div>
                        <div style="flex: 1;">
                            <div style="font-weight: 600; color: var(--gray-900); margin-bottom: var(--spacing-xs);">
                                Ana Martínez
                            </div>
                            <div style="font-size: 0.875rem; color: var(--gray-600);">
                                ID: #004 • ana.martinez@email.com
                            </div>
                        </div>
                    </div>
                    <div style="display: flex; gap: var(--spacing-sm);">
                        <button class="btn btn-ghost btn-sm">
                            <i class="fas fa-check"></i> Presente
                        </button>
                        <button class="btn btn-sm" style="background: var(--warning); color: white;">
                            ⏰ Tarde
                        </button>
                        <button class="btn btn-ghost btn-sm">
                            ✗ Ausente
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div style="display: flex; justify-content: flex-end; gap: var(--spacing-md);">
                <button class="btn btn-ghost">Cancelar</button>
                <button class="btn btn-primary">
                    <i class="fas fa-save"></i> Guardar Asistencia
                </button>
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
<?php /**PATH C:\Users\Edy\Downloads\laragon-portable\www\HolaClase\resources\views/asistencia/index.blade.php ENDPATH**/ ?>