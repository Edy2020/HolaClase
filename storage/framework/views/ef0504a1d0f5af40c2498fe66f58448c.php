<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'HolaClase')); ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('css/custom.css')); ?>">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body>
    <div class="guest-container">
        <div class="guest-card fade-in">
            <div class="guest-header">
                <a href="<?php echo e(url('/')); ?>" style="text-decoration: none;">
                    <div class="guest-logo">
                        <img src="<?php echo e(asset('hc_icon.png')); ?>" alt="HolaClase" style="width: 90%; height: 90%; object-fit: contain;">
                    </div>
                </a>
                <h1 class="guest-title">HolaClase</h1>
                <p class="guest-subtitle">Sistema de Gestión Educativa</p>
            </div>

            <?php echo e($slot); ?>


            <div class="guest-footer">
                <p>&copy; <?php echo e(date('Y')); ?> HolaClase. Todos los derechos reservados.</p>
            </div>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\laragon\www\HolaClase\resources\views/layouts/guest.blade.php ENDPATH**/ ?>