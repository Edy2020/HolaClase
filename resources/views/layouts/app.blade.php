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
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <a href="{{ route('dashboard') }}" class="sidebar-logo">
                    <div class="sidebar-logo-icon">HC</div>
                    <span>HolaClase</span>
                </a>
            </div>

            <nav>
                <ul class="sidebar-nav">
                    <li class="sidebar-nav-item">
                        <a href="{{ route('dashboard') }}" class="sidebar-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <span class="sidebar-nav-icon"><i class="fas fa-chart-bar"></i></span>
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
                            <span class="sidebar-nav-icon"><i class="fas fa-school"></i></span>
                            <span>Profesores</span>
                        </a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="{{ route('attendance.index') }}" class="sidebar-nav-link {{ request()->routeIs('attendance.*') ? 'active' : '' }}">
                            <span class="sidebar-nav-icon"><i class="fas fa-check"></i></span>
                            <span>Asistencia</span>
                        </a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="{{ route('grades.index') }}" class="sidebar-nav-link {{ request()->routeIs('grades.*') ? 'active' : '' }}">
                            <span class="sidebar-nav-icon"><i class="fas fa-clipboard"></i></span>
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
                <button class="btn btn-ghost-light btn-sm" id="sidebar-toggle">
                    ☰
                </button>
                <h1 class="navbar-title">{{ $header ?? 'Dashboard' }}</h1>
            </div>

            <div class="navbar-right">
                <!-- User Dropdown -->
                <div style="position: relative;">
                    <button class="btn btn-ghost-light btn-sm" onclick="toggleUserMenu()">
                        <span>{{ Auth::user()->name }}</span>
                        <span>▼</span>
                    </button>

                    <div id="user-menu" style="display: none; position: absolute; right: 0; top: 100%; margin-top: 0.5rem; background: white; border-radius: var(--radius-md); box-shadow: var(--shadow-lg); min-width: 200px; z-index: 50;">
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
                                    🚪 Cerrar Sesión
                                </button>
                            </form>
                        </div>
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
        // Toggle user menu
        function toggleUserMenu() {
            const menu = document.getElementById('user-menu');
            menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
        }

        // Close user menu when clicking outside
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('user-menu');
            const button = event.target.closest('button');
            
            if (!button || button.getAttribute('onclick') !== 'toggleUserMenu()') {
                menu.style.display = 'none';
            }
        });

        // Sidebar toggle functionality
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        let sidebarOpen = true;
        
        sidebarToggle.addEventListener('click', function() {
            sidebarOpen = !sidebarOpen;
            
            if (sidebarOpen) {
                sidebar.style.transform = 'translateX(0)';
                sidebar.classList.remove('collapsed');
                mainContent.classList.add('with-sidebar');
            } else {
                sidebar.style.transform = 'translateX(-100%)';
                sidebar.classList.add('collapsed');
                mainContent.classList.remove('with-sidebar');
            }
        });
        
        // Responsive behavior
        function checkMobile() {
            if (window.innerWidth <= 1024) {
                sidebar.style.transform = 'translateX(-100%)';
                sidebar.classList.add('collapsed');
                mainContent.classList.remove('with-sidebar');
                sidebarOpen = false;
            } else {
                sidebar.style.transform = 'translateX(0)';
                sidebar.classList.remove('collapsed');
                mainContent.classList.add('with-sidebar');
                sidebarOpen = true;
            }
        }
        
        window.addEventListener('resize', checkMobile);
        checkMobile();
        
        // Load saved theme
        const savedTheme = localStorage.getItem('holaclase_theme');
        if (savedTheme) {
            document.documentElement.setAttribute('data-theme', savedTheme);
        }
    </script>
</body>
</html>
