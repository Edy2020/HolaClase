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

    <?php if(session('success')): ?>
        <div id="successMessage" class="alert alert-success"
            style="background: #10b981; color: white; padding: var(--spacing-md); border-radius: var(--radius-md); margin-bottom: var(--spacing-lg);">
            <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

        </div>
        <script>
            setTimeout(() => {
                const msg = document.getElementById('successMessage');
                if (msg) {
                    msg.style.opacity = '0';
                    setTimeout(() => msg.style.display = 'none', 500);
                }
            }, 3000);
        </script>
    <?php endif; ?>

    <!-- Hero Header -->
    <div
        style="background: var(--theme-dark); color: white; padding: var(--spacing-2xl); border-radius: var(--radius-xl); margin-bottom: var(--spacing-2xl); box-shadow: var(--shadow-lg);">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h2 style="color: white; font-size: 1.75rem; font-weight: 700; margin-bottom: var(--spacing-sm);">
                    <i class="fas fa-calendar-check"></i> Control de Asistencia
                </h2>
                <p style="font-size: 1rem; opacity: 0.95; margin: 0;">
                    Gestiona y monitorea la asistencia de los estudiantes
                </p>
            </div>
            <a href="<?php echo e(route('attendance.create')); ?>" class="btn btn-accent" style="color: white;">
                <i class="fas fa-plus"></i> Tomar Asistencia
            </a>
        </div>
    </div>

    <!-- Statistics -->
    <div class="grid grid-cols-5 mb-xl">
        <div class="stat-card">
            <div class="stat-value" style="color: var(--theme-color);"><?php echo e($stats['total']); ?></div>
            <div class="stat-label">Total Registros</div>
        </div>
        <div class="stat-card">
            <div class="stat-value" style="color: var(--success);"><?php echo e($stats['presente']); ?></div>
            <div class="stat-label">Presentes</div>
        </div>
        <div class="stat-card">
            <div class="stat-value" style="color: var(--error);"><?php echo e($stats['ausente']); ?></div>
            <div class="stat-label">Ausentes</div>
        </div>
        <div class="stat-card">
            <div class="stat-value" style="color: var(--warning);"><?php echo e($stats['tarde']); ?></div>
            <div class="stat-label">Tardanzas</div>
        </div>
        <div class="stat-card">
            <div class="stat-value" style="color: var(--info);"><?php echo e($stats['porcentaje_asistencia']); ?>%</div>
            <div class="stat-label">% Asistencia</div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-xl">
        <div class="card-header">
            <h3 class="card-title">Filtros</h3>
        </div>
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('attendance.index')); ?>">
                <div class="grid grid-cols-5">
                    <div class="form-group mb-0">
                        <label class="form-label">Curso</label>
                        <select name="curso_id" class="form-select">
                            <option value="">Todos los cursos</option>
                            <?php $__currentLoopData = $cursos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $curso): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($curso->id); ?>" <?php echo e(request('curso_id') == $curso->id ? 'selected' : ''); ?>>
                                    <?php echo e($curso->nombre); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label">Asignatura</label>
                        <select name="asignatura_id" class="form-select">
                            <option value="">Todas las asignaturas</option>
                            <?php $__currentLoopData = $asignaturas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asignatura): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($asignatura->id); ?>" <?php echo e(request('asignatura_id') == $asignatura->id ? 'selected' : ''); ?>>
                                    <?php echo e($asignatura->nombre); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label">Fecha</label>
                        <input type="date" name="fecha" class="form-input" value="<?php echo e(request('fecha')); ?>">
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label">Estado</label>
                        <select name="estado" class="form-select">
                            <option value="">Todos</option>
                            <option value="presente" <?php echo e(request('estado') == 'presente' ? 'selected' : ''); ?>>Presente
                            </option>
                            <option value="ausente" <?php echo e(request('estado') == 'ausente' ? 'selected' : ''); ?>>Ausente
                            </option>
                            <option value="tarde" <?php echo e(request('estado') == 'tarde' ? 'selected' : ''); ?>>Tarde</option>
                            <option value="justificado" <?php echo e(request('estado') == 'justificado' ? 'selected' : ''); ?>>
                                Justificado</option>
                        </select>
                    </div>
                    <div class="form-group mb-0" style="display: flex; align-items: flex-end;">
                        <button type="submit" class="btn btn-primary" style="width: 100%; color: white;">
                            <i class="fas fa-search"></i> Filtrar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Attendance Records -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Registros de Asistencia</h3>
        </div>
        <div class="card-body">
            <?php if($asistencias->count() > 0): ?>
                <div style="overflow-x: auto;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Curso</th>
                                <th>Asignatura</th>
                                <th>Estudiante</th>
                                <th>Estado</th>
                                <th>Notas</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $asistencias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asistencia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($asistencia->fecha->format('d/m/Y')); ?></td>
                                    <td><?php echo e($asistencia->curso->nombre); ?></td>
                                    <td><?php echo e($asistencia->asignatura->nombre); ?></td>
                                    <td><?php echo e($asistencia->estudiante->nombre); ?> <?php echo e($asistencia->estudiante->apellido); ?></td>
                                    <td>
                                        <span class="badge badge-<?php echo e($asistencia->estado_color); ?>">
                                            <?php echo e($asistencia->estado_label); ?>

                                        </span>
                                    </td>
                                    <td><?php echo e($asistencia->notas ? Str::limit($asistencia->notas, 30) : '-'); ?></td>
                                    <td>
                                        <form action="<?php echo e(route('attendance.destroy', $asistencia)); ?>" method="POST"
                                            style="display: inline;" onsubmit="return confirm('¿Eliminar este registro?');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-outline"
                                                style="color: #ef4444; border-color: #ef4444;">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div style="margin-top: var(--spacing-lg);">
                    <?php echo e($asistencias->links()); ?>

                </div>
            <?php else: ?>
                <div
                    style="text-align: center; padding: var(--spacing-2xl); background: var(--gray-50); border-radius: var(--radius-md);">
                    <i class="fas fa-calendar-times"
                        style="font-size: 3rem; color: var(--gray-300); margin-bottom: var(--spacing-md);"></i>
                    <p style="color: var(--gray-600);">No hay registros de asistencia</p>
                    <a href="<?php echo e(route('attendance.create')); ?>" class="btn btn-primary"
                        style="margin-top: var(--spacing-md); color: white;">
                        <i class="fas fa-plus"></i> Tomar Asistencia
                    </a>
                </div>
            <?php endif; ?>
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
<?php endif; ?><?php /**PATH C:\Users\Edy\Downloads\laragon-portable\www\HolaClase\resources\views/asistencia/index.blade.php ENDPATH**/ ?>