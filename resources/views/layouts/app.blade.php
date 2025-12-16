<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'HolaClase') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/themes.css') }}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="app-container">
        <!-- Desktop Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <a href="{{ route('dashboard') }}" class="sidebar-logo">
                    <div class="sidebar-logo-icon">HC</div>
                    <span class="sidebar-logo-text">HolaClase</span>
                </a>
                <button class="sidebar-toggle-btn" id="sidebar-toggle-btn" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
            </div>

            <nav>
                <ul class="sidebar-nav">
                    <li class="sidebar-nav-item">
                        <a href="{{ route('dashboard') }}" class="sidebar-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <span class="sidebar-nav-icon"><i class="fas fa-home"></i></span>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="{{ route('courses.index') }}" class="sidebar-nav-link {{ request()->routeIs('courses.*') ? 'active' : '' }}">
                            <span class="sidebar-nav-icon"><i class="fas fa-graduation-cap"></i></span>
                            <span>Cursos</span>
                        </a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="{{ route('subjects.index') }}" class="sidebar-nav-link {{ request()->routeIs('subjects.*') ? 'active' : '' }}">
                            <span class="sidebar-nav-icon"><i class="fas fa-book"></i></span>
                            <span>Asignaturas</span>
                        </a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="{{ route('teachers.index') }}" class="sidebar-nav-link {{ request()->routeIs('teachers.*') ? 'active' : '' }}">
                            <span class="sidebar-nav-icon"><i class="fas fa-chalkboard-teacher"></i></span>
                            <span>Profesores</span>
                        </a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="{{ route('attendance.index') }}" class="sidebar-nav-link {{ request()->routeIs('attendance.*') ? 'active' : '' }}">
                            <span class="sidebar-nav-icon"><i class="fas fa-calendar-check"></i></span>
                            <span>Asistencia</span>
                        </a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="{{ route('grades.index') }}" class="sidebar-nav-link {{ request()->routeIs('grades.*') ? 'active' : '' }}">
                            <span class="sidebar-nav-icon"><i class="fas fa-chart-line"></i></span>
                            <span>Calificaciones</span>
                        </a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="{{ route('settings.index') }}" class="sidebar-nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
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
                <a href="{{ route('dashboard') }}" class="sidebar-logo">
                    <div class="sidebar-logo-icon">HC</div>
                    <span class="sidebar-logo-text">HolaClase</span>
                </a>
                <button class="sidebar-toggle-btn" onclick="closeMobileSidebar()">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <nav>
                <ul class="sidebar-nav">
                    <li class="sidebar-nav-item">
                        <a href="{{ route('dashboard') }}" class="sidebar-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <span class="sidebar-nav-icon"><i class="fas fa-home"></i></span>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="{{ route('courses.index') }}" class="sidebar-nav-link {{ request()->routeIs('courses.*') ? 'active' : '' }}">
                            <span class="sidebar-nav-icon"><i class="fas fa-graduation-cap"></i></span>
                            <span>Cursos</span>
                        </a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="{{ route('subjects.index') }}" class="sidebar-nav-link {{ request()->routeIs('subjects.*') ? 'active' : '' }}">
                            <span class="sidebar-nav-icon"><i class="fas fa-book"></i></span>
                            <span>Asignaturas</span>
                        </a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="{{ route('teachers.index') }}" class="sidebar-nav-link {{ request()->routeIs('teachers.*') ? 'active' : '' }}">
                            <span class="sidebar-nav-icon"><i class="fas fa-chalkboard-teacher"></i></span>
                            <span>Profesores</span>
                        </a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="{{ route('attendance.index') }}" class="sidebar-nav-link {{ request()->routeIs('attendance.*') ? 'active' : '' }}">
                            <span class="sidebar-nav-icon"><i class="fas fa-calendar-check"></i></span>
                            <span>Asistencia</span>
                        </a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="{{ route('grades.index') }}" class="sidebar-nav-link {{ request()->routeIs('grades.*') ? 'active' : '' }}">
                            <span class="sidebar-nav-icon"><i class="fas fa-chart-line"></i></span>
                            <span>Calificaciones</span>
                        </a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="{{ route('settings.index') }}" class="sidebar-nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                            <span class="sidebar-nav-icon"><i class="fas fa-cog"></i></span>
                            <span>Configuración</span>
                        </a>
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
                <h1 class="navbar-title">{{ $header ?? 'Dashboard' }}</h1>
            </div>

            <div class="navbar-right">
                <!-- User Icon Button -->
                <button class="user-icon-btn" onclick="toggleUserMenu()">
                    <i class="fas fa-user"></i>
                </button>

                <!-- User Dropdown Menu -->
                <div id="user-menu" style="display: none; position: absolute; right: var(--spacing-md); top: 60px; background: white; border-radius: var(--radius-md); box-shadow: var(--shadow-lg); min-width: 200px; z-index: 50;">
                    <div style="padding: var(--spacing-md); border-bottom: 1px solid var(--gray-200);">
                        <div style="font-weight: 600; color: var(--gray-900);">{{ Auth::user()->name }}</div>
                        <div style="font-size: 0.875rem; color: var(--gray-600);">{{ Auth::user()->email }}</div>
                    </div>
                    <div style="padding: var(--spacing-sm);">
                        <a href="{{ route('profile.edit') }}" style="display: block; padding: var(--spacing-sm) var(--spacing-md); color: var(--gray-700); text-decoration: none; border-radius: var(--radius-sm); transition: background var(--transition-fast);" onmouseover="this.style.background='var(--gray-100)'" onmouseout="this.style.background='transparent'">
                            <i class="fas fa-cog"></i> Perfil
                        </a>
                        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                            @csrf
                            <button type="submit" style="width: 100%; text-align: left; padding: var(--spacing-sm) var(--spacing-md); color: var(--error); background: transparent; border: none; cursor: pointer; border-radius: var(--radius-sm); transition: background var(--transition-fast); font-family: inherit; font-size: inherit;" onmouseover="this.style.background='var(--gray-100)'" onmouseout="this.style.background='transparent'">
                                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="main-content with-sidebar" id="mainContent">
            <!-- Page Content -->
            <main class="content-wrapper fade-in">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="app-footer">
                <p>&copy; {{ date('Y') }} HolaClase. Sistema de Gestión Educativa. Todos los derechos reservados.</p>
            </footer>
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
            const menu = document.getElementById('user-menu');
            menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
        }

        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('user-menu');
            const button = event.target.closest('button');
            
            if (!button && menu && menu.style.display === 'block') {
                menu.style.display = 'none';
            }
        });

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
