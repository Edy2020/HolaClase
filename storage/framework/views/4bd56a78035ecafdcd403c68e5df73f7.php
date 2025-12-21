<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'HolaClase')); ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <!-- Styles -->
    <link rel="stylesheet" href="<?php echo e(asset('css/custom.css')); ?>?v=<?php echo e(time()); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/themes.css')); ?>?v=<?php echo e(time()); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">

    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body>
    <div class="app-container">
        <!-- Desktop Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <a href="<?php echo e(route('dashboard')); ?>" class="sidebar-logo">
                    <div class="sidebar-logo-icon">
                        <img src="<?php echo e(asset('hc_icon.png')); ?>" alt="HolaClase" style="width: 100%; height: 100%; object-fit: contain;">
                    </div>
                    <span class="sidebar-logo-text">HolaClase!</span>
                </a>
                <button class="sidebar-toggle-btn" id="sidebar-toggle-btn" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
            </div>

            <nav>
                <ul class="sidebar-nav">
                    <li class="sidebar-nav-item">
                        <a href="<?php echo e(route('dashboard')); ?>" class="sidebar-nav-link <?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>">
                            <span class="sidebar-nav-icon"><i class="fas fa-home"></i></span>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="<?php echo e(route('courses.index')); ?>" class="sidebar-nav-link <?php echo e(request()->routeIs('courses.*') ? 'active' : ''); ?>">
                            <span class="sidebar-nav-icon"><i class="fas fa-graduation-cap"></i></span>
                            <span>Cursos</span>
                        </a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="<?php echo e(route('subjects.index')); ?>" class="sidebar-nav-link <?php echo e(request()->routeIs('subjects.*') ? 'active' : ''); ?>">
                            <span class="sidebar-nav-icon"><i class="fas fa-book"></i></span>
                            <span>Asignaturas</span>
                        </a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="<?php echo e(route('teachers.index')); ?>" class="sidebar-nav-link <?php echo e(request()->routeIs('teachers.*') ? 'active' : ''); ?>">
                            <span class="sidebar-nav-icon"><i class="fas fa-chalkboard-teacher"></i></span>
                            <span>Profesores</span>
                        </a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="<?php echo e(route('attendance.index')); ?>" class="sidebar-nav-link <?php echo e(request()->routeIs('attendance.*') ? 'active' : ''); ?>">
                            <span class="sidebar-nav-icon"><i class="fas fa-calendar-check"></i></span>
                            <span>Asistencia</span>
                        </a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="<?php echo e(route('grades.index')); ?>" class="sidebar-nav-link <?php echo e(request()->routeIs('grades.*') ? 'active' : ''); ?>">
                            <span class="sidebar-nav-icon"><i class="fas fa-chart-line"></i></span>
                            <span>Notas</span>
                        </a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="<?php echo e(route('settings.index')); ?>" class="sidebar-nav-link <?php echo e(request()->routeIs('settings.*') ? 'active' : ''); ?>">
                            <span class="sidebar-nav-icon"><i class="fas fa-cog"></i></span>
                            <span>Configuración</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Mobile Sidebar Overlay -->
        <div class="mobile-sidebar-overlay" id="mobile-overlay" onclick="closeMobileSidebar()"></div>

        <!-- Mobile Sidebar -->
        <aside class="mobile-sidebar" id="mobile-sidebar">
            <div class="sidebar-header">
                <a href="<?php echo e(route('dashboard')); ?>" class="sidebar-logo">
                    <div class="sidebar-logo-icon">
                        <img src="<?php echo e(asset('hc_icon.png')); ?>" alt="HolaClase" style="width: 100%; height: 100%; object-fit: contain;">
                    </div>
                    <span class="sidebar-logo-text">HolaClase</span>
                </a>
                <button class="sidebar-toggle-btn" onclick="closeMobileSidebar()">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <nav>
                <ul class="sidebar-nav">
                    <li class="sidebar-nav-item">
                        <a href="<?php echo e(route('dashboard')); ?>" class="sidebar-nav-link <?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>">
                            <span class="sidebar-nav-icon"><i class="fas fa-home"></i></span>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="<?php echo e(route('courses.index')); ?>" class="sidebar-nav-link <?php echo e(request()->routeIs('courses.*') ? 'active' : ''); ?>">
                            <span class="sidebar-nav-icon"><i class="fas fa-graduation-cap"></i></span>
                            <span>Cursos</span>
                        </a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="<?php echo e(route('subjects.index')); ?>" class="sidebar-nav-link <?php echo e(request()->routeIs('subjects.*') ? 'active' : ''); ?>">
                            <span class="sidebar-nav-icon"><i class="fas fa-book"></i></span>
                            <span>Asignaturas</span>
                        </a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="<?php echo e(route('teachers.index')); ?>" class="sidebar-nav-link <?php echo e(request()->routeIs('teachers.*') ? 'active' : ''); ?>">
                            <span class="sidebar-nav-icon"><i class="fas fa-chalkboard-teacher"></i></span>
                            <span>Profesores</span>
                        </a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="<?php echo e(route('attendance.index')); ?>" class="sidebar-nav-link <?php echo e(request()->routeIs('attendance.*') ? 'active' : ''); ?>">
                            <span class="sidebar-nav-icon"><i class="fas fa-calendar-check"></i></span>
                            <span>Asistencia</span>
                        </a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="<?php echo e(route('grades.index')); ?>" class="sidebar-nav-link <?php echo e(request()->routeIs('grades.*') ? 'active' : ''); ?>">
                            <span class="sidebar-nav-icon"><i class="fas fa-chart-line"></i></span>
                            <span>Notas</span>
                        </a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="<?php echo e(route('settings.index')); ?>" class="sidebar-nav-link <?php echo e(request()->routeIs('settings.*') ? 'active' : ''); ?>">
                            <span class="sidebar-nav-icon"><i class="fas fa-cog"></i></span>
                            <span>Configuración</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Mobile User Sidebar Overlay -->
        <div class="mobile-user-sidebar-overlay" id="mobile-user-overlay" onclick="closeMobileUserSidebar()"></div>

        <!-- Mobile User Sidebar -->
        <aside class="mobile-user-sidebar" id="mobile-user-sidebar">
            <div class="mobile-user-sidebar-header">
                <div class="mobile-user-sidebar-info">
                    <div class="mobile-user-sidebar-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="mobile-user-sidebar-details">
                        <div class="mobile-user-sidebar-name"><?php echo e(Auth::user()->name); ?></div>
                        <div class="mobile-user-sidebar-email"><?php echo e(Auth::user()->email); ?></div>
                    </div>
                </div>
                <button class="sidebar-toggle-btn" onclick="closeMobileUserSidebar()">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <nav class="mobile-user-nav">
                <ul>
                    <li>
                        <a href="<?php echo e(route('profile.edit')); ?>" class="mobile-user-nav-link">
                            <span class="mobile-user-nav-icon"><i class="fas fa-user-cog"></i></span>
                            <span>Editar Perfil</span>
                        </a>
                    </li>
                    <li>
                        <form method="POST" action="<?php echo e(route('logout')); ?>" style="margin: 0;">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="mobile-user-nav-link logout-btn">
                                <span class="mobile-user-nav-icon"><i class="fas fa-sign-out-alt"></i></span>
                                <span>Cerrar Sesión</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Fixed Navbar -->
        <nav class="app-navbar">
            <div class="navbar-left">
                <button class="mobile-menu-btn" onclick="openMobileSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="navbar-title"><?php echo e($header ?? 'Dashboard'); ?></h1>
            </div>

            <div class="navbar-right">
                <!-- User Icon Button -->
                <button class="user-icon-btn" onclick="toggleUserMenu()" id="user-icon-btn">
                    <i class="fas fa-user"></i>
                </button>

                <!-- User Dropdown Menu (Desktop) -->
                <div id="user-menu" class="user-dropdown-menu">
                    <div class="user-dropdown-header">
                        <div class="user-dropdown-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="user-dropdown-info">
                            <div class="user-dropdown-name"><?php echo e(Auth::user()->name); ?></div>
                            <div class="user-dropdown-email"><?php echo e(Auth::user()->email); ?></div>
                        </div>
                    </div>
                    <div class="user-dropdown-divider"></div>
                    <nav class="user-dropdown-nav">
                        <a href="<?php echo e(route('profile.edit')); ?>" class="user-dropdown-link">
                            <span class="user-dropdown-link-icon">
                                <i class="fas fa-user-cog"></i>
                            </span>
                            <span class="user-dropdown-link-text">Perfil</span>
                        </a>
                        <form method="POST" action="<?php echo e(route('logout')); ?>" class="user-dropdown-form">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="user-dropdown-link user-dropdown-logout">
                                <span class="user-dropdown-link-icon">
                                    <i class="fas fa-sign-out-alt"></i>
                                </span>
                                <span class="user-dropdown-link-text">Cerrar Sesión</span>
                            </button>
                        </form>
                    </nav>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="main-content with-sidebar" id="mainContent">
            <!-- Page Content -->
            <main class="content-wrapper fade-in">
                <?php echo e($slot); ?>

            </main>

            <!-- Footer -->
            <!-- <footer class="app-footer">
                <p>&copy; <?php echo e(date('Y')); ?> HolaClase. Sistema de Gestión Educativa. Todos los derechos reservados.</p>
            </footer> -->
        </div>
    </div>

    <script>
        // Desktop Sidebar toggle functionality
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        
        // Load saved sidebar state
        let sidebarOpen = localStorage.getItem('sidebarOpen') !== 'false';

        function toggleSidebar() {
            sidebarOpen = !sidebarOpen;
            sidebar.classList.toggle('collapsed');
            // Save state to localStorage
            localStorage.setItem('sidebarOpen', sidebarOpen);
        }

        // Apply saved state on load
        if (!sidebarOpen) {
            sidebar.classList.add('collapsed');
        }

        // Mobile Sidebar functionality
        const mobileSidebar = document.getElementById('mobile-sidebar');
        const mobileOverlay = document.getElementById('mobile-overlay');

        function openMobileSidebar() {
            mobileSidebar.classList.add('open');
            mobileOverlay.classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeMobileSidebar() {
            mobileSidebar.classList.remove('open');
            mobileOverlay.classList.remove('show');
            document.body.style.overflow = '';
        }

        // Responsive behavior
        function checkMobile() {
            if (window.innerWidth <= 1024) {
                sidebar.classList.add('collapsed');
                sidebarOpen = false;
                localStorage.setItem('sidebarOpen', false);
            } else if (localStorage.getItem('sidebarOpen') !== 'false') {
                sidebar.classList.remove('collapsed');
                sidebarOpen = true;
                // Close mobile sidebar if open
                closeMobileSidebar();
            }
        }

        window.addEventListener('resize', checkMobile);
        checkMobile();

        // User menu toggle
        function toggleUserMenu() {
            // Check if mobile
            if (window.innerWidth <= 768) {
                openMobileUserSidebar();
            } else {
                const menu = document.getElementById('user-menu');
                menu.classList.toggle('show');
            }
        }

        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('user-menu');
            const button = document.getElementById('user-icon-btn');
            
            // Check if click is outside both menu and button
            if (!menu.contains(event.target) && !button.contains(event.target)) {
                menu.classList.remove('show');
            }
        });

        // Mobile User Sidebar functionality
        const mobileUserSidebar = document.getElementById('mobile-user-sidebar');
        const mobileUserOverlay = document.getElementById('mobile-user-overlay');

        function openMobileUserSidebar() {
            mobileUserSidebar.classList.add('open');
            mobileUserOverlay.classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeMobileUserSidebar() {
            mobileUserSidebar.classList.remove('open');
            mobileUserOverlay.classList.remove('show');
            document.body.style.overflow = '';
        }

        // Initialize theme on page load
        const savedTheme = localStorage.getItem('theme') || 'purple';
        if (savedTheme) {
            document.documentElement.setAttribute('data-theme', savedTheme);
            
            // Apply custom color if custom theme is selected
            if (savedTheme === 'custom') {
                const customColor = localStorage.getItem('customColor');
                if (customColor) {
                    applyCustomColor(customColor);
                }
            }
        }

        // Initialize dark mode on page load
        const isDarkMode = localStorage.getItem('darkMode') === 'true';
        if (isDarkMode) {
            document.documentElement.classList.add('dark-mode');
        }

        function applyCustomColor(baseColor) {
            // Generate color variations
            const variations = generateColorVariations(baseColor);
            
            // Apply custom colors
            document.documentElement.style.setProperty('--custom-color', baseColor);
            document.documentElement.style.setProperty('--custom-light', variations.light);
            document.documentElement.style.setProperty('--custom-dark', variations.dark);
            document.documentElement.style.setProperty('--custom-darker', variations.darker);
        }

        function generateColorVariations(hexColor) {
            // Convert hex to RGB
            const r = parseInt(hexColor.substr(1, 2), 16);
            const g = parseInt(hexColor.substr(3, 2), 16);
            const b = parseInt(hexColor.substr(5, 2), 16);
            
            // Generate lighter version (increase brightness by 15%)
            const light = `#${Math.min(255, Math.round(r * 1.15)).toString(16).padStart(2, '0')}${Math.min(255, Math.round(g * 1.15)).toString(16).padStart(2, '0')}${Math.min(255, Math.round(b * 1.15)).toString(16).padStart(2, '0')}`;
            
            // Generate darker version (decrease brightness by 15%)
            const dark = `#${Math.round(r * 0.85).toString(16).padStart(2, '0')}${Math.round(g * 0.85).toString(16).padStart(2, '0')}${Math.round(b * 0.85).toString(16).padStart(2, '0')}`;
            
            // Generate even darker version (decrease brightness by 30%)
            const darker = `#${Math.round(r * 0.7).toString(16).padStart(2, '0')}${Math.round(g * 0.7).toString(16).padStart(2, '0')}${Math.round(b * 0.7).toString(16).padStart(2, '0')}`;
            
            return { light, dark, darker };
        }
    </script>
</body>
</html>
<?php /**PATH C:\Users\Edy\Downloads\laragon-portable\www\HolaClase\resources\views/layouts/app.blade.php ENDPATH**/ ?>