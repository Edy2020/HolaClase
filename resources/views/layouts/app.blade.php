<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'HolaClase') }}</title>

    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800" rel="stylesheet" />

    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/themes.css') }}?v={{ time() }}">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">

    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="app-container">
        
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <a href="{{ route('dashboard') }}" class="sidebar-logo">
                    <div class="sidebar-logo-icon">
                        <img src="{{ asset('hc_icon_4.png') }}" class="brand-logo-light" alt="HolaClase" style="width: 100%; height: 100%; object-fit: contain;">
                        <img src="{{ asset('hc_icon.png') }}" class="brand-logo-dark" alt="HolaClase" style="width: 100%; height: 100%; object-fit: contain; display: none;">
                    </div>
                    <span class="sidebar-logo-text">HolaClase!</span>
                </a>
            </div>

            <nav style="display: flex; flex-direction: column; flex: 1; overflow-y: auto;">
                <ul class="sidebar-nav" style="display: flex; flex-direction: column; flex: 1;">
                    <li class="sidebar-nav-item">
                        <a href="{{ route('dashboard') }}"
                            class="sidebar-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <span class="sidebar-nav-icon"><i class="fas fa-home"></i></span>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="{{ route('courses.index') }}"
                            class="sidebar-nav-link {{ request()->routeIs('courses.*') ? 'active' : '' }}">
                            <span class="sidebar-nav-icon"><i class="fas fa-graduation-cap"></i></span>
                            <span>Cursos</span>
                        </a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="{{ route('subjects.index') }}"
                            class="sidebar-nav-link {{ request()->routeIs('subjects.*') ? 'active' : '' }}">
                            <span class="sidebar-nav-icon"><i class="fas fa-book"></i></span>
                            <span>Asignaturas</span>
                        </a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="{{ route('teachers.index') }}"
                            class="sidebar-nav-link {{ request()->routeIs('teachers.*') ? 'active' : '' }}">
                            <span class="sidebar-nav-icon"><i class="fas fa-chalkboard-teacher"></i></span>
                            <span>Profesores</span>
                        </a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="{{ route('students.index') }}"
                            class="sidebar-nav-link {{ request()->routeIs('students.*') ? 'active' : '' }}">
                            <span class="sidebar-nav-icon"><i class="fas fa-user-graduate"></i></span>
                            <span>Estudiantes</span>
                        </a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="{{ route('attendance.index') }}"
                            class="sidebar-nav-link {{ request()->routeIs('attendance.*') ? 'active' : '' }}">
                            <span class="sidebar-nav-icon"><i class="fas fa-calendar-check"></i></span>
                            <span>Asistencia</span>
                        </a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="{{ route('grades.index') }}"
                            class="sidebar-nav-link {{ request()->routeIs('grades.*') ? 'active' : '' }}">
                            <span class="sidebar-nav-icon"><i class="fas fa-chart-line"></i></span>
                            <span>Notas</span>
                        </a>
                    </li>

                    <li class="sidebar-nav-item" style="margin-top: auto; border-top: 1px solid var(--gray-200); padding-top: 1rem;">
                        <a href="#" onclick="toggleDarkMode(); return false;" class="sidebar-nav-link">
                            <span class="sidebar-nav-icon theme-toggle-icon"><i class="fas fa-moon"></i></span>
                            <span class="theme-toggle-text">Modo Oscuro</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        
        <div class="mobile-sidebar-overlay" id="mobile-overlay" onclick="closeMobileSidebar()"></div>

        
        <aside class="mobile-sidebar" id="mobile-sidebar">
            <div class="sidebar-header">
                <a href="{{ route('dashboard') }}" class="sidebar-logo">
                    <div class="sidebar-logo-icon">
                        <img src="{{ asset('hc_icon_4.png') }}" class="brand-logo-light" alt="HolaClase" style="width: 100%; height: 100%; object-fit: contain;">
                        <img src="{{ asset('hc_icon.png') }}" class="brand-logo-dark" alt="HolaClase" style="width: 100%; height: 100%; object-fit: contain; display: none;">
                    </div>
                    <span class="sidebar-logo-text">HolaClase</span>
                </a>
                <button class="sidebar-toggle-btn" onclick="closeMobileSidebar()">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <nav style="display: flex; flex-direction: column; flex: 1; overflow-y: auto;">
                <ul class="sidebar-nav" style="display: flex; flex-direction: column; flex: 1;">
                    <li class="sidebar-nav-item">
                        <a href="{{ route('dashboard') }}"
                            class="sidebar-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <span class="sidebar-nav-icon"><i class="fas fa-home"></i></span>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="{{ route('courses.index') }}"
                            class="sidebar-nav-link {{ request()->routeIs('courses.*') ? 'active' : '' }}">
                            <span class="sidebar-nav-icon"><i class="fas fa-graduation-cap"></i></span>
                            <span>Cursos</span>
                        </a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="{{ route('subjects.index') }}"
                            class="sidebar-nav-link {{ request()->routeIs('subjects.*') ? 'active' : '' }}">
                            <span class="sidebar-nav-icon"><i class="fas fa-book"></i></span>
                            <span>Asignaturas</span>
                        </a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="{{ route('teachers.index') }}"
                            class="sidebar-nav-link {{ request()->routeIs('teachers.*') ? 'active' : '' }}">
                            <span class="sidebar-nav-icon"><i class="fas fa-chalkboard-teacher"></i></span>
                            <span>Profesores</span>
                        </a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="{{ route('students.index') }}"
                            class="sidebar-nav-link {{ request()->routeIs('students.*') ? 'active' : '' }}">
                            <span class="sidebar-nav-icon"><i class="fas fa-user-graduate"></i></span>
                            <span>Estudiantes</span>
                        </a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="{{ route('attendance.index') }}"
                            class="sidebar-nav-link {{ request()->routeIs('attendance.*') ? 'active' : '' }}">
                            <span class="sidebar-nav-icon"><i class="fas fa-calendar-check"></i></span>
                            <span>Asistencia</span>
                        </a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="{{ route('grades.dashboard') }}"
                            class="sidebar-nav-link {{ request()->routeIs('grades.*') ? 'active' : '' }}">
                            <span class="sidebar-nav-icon"><i class="fas fa-chart-line"></i></span>
                            <span>Notas</span>
                        </a>
                    </li>

                    <li class="sidebar-nav-item" style="margin-top: auto; border-top: 1px solid var(--gray-200); padding-top: 1rem;">
                        <a href="#" onclick="toggleDarkMode(); return false;" class="sidebar-nav-link">
                            <span class="sidebar-nav-icon theme-toggle-icon"><i class="fas fa-moon"></i></span>
                            <span class="theme-toggle-text">Modo Oscuro</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        
        <div class="mobile-user-sidebar-overlay" id="mobile-user-overlay" onclick="closeMobileUserSidebar()"></div>

        
        <aside class="mobile-user-sidebar" id="mobile-user-sidebar">
            <div class="mobile-user-sidebar-header">
                <div class="mobile-user-sidebar-info">
                    <div class="mobile-user-sidebar-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="mobile-user-sidebar-details">
                        <div class="mobile-user-sidebar-name">{{ Auth::user()->name }}</div>
                        <div class="mobile-user-sidebar-email">{{ Auth::user()->email }}</div>
                    </div>
                </div>
                <button class="sidebar-toggle-btn" onclick="closeMobileUserSidebar()">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <nav class="mobile-user-nav">
                <ul>
                    <li>
                        <a href="{{ route('profile.edit') }}" class="mobile-user-nav-link">
                            <span class="mobile-user-nav-icon"><i class="fas fa-user-cog"></i></span>
                            <span>Editar Perfil</span>
                        </a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                            @csrf
                            <button type="submit" class="mobile-user-nav-link logout-btn">
                                <span class="mobile-user-nav-icon"><i class="fas fa-sign-out-alt"></i></span>
                                <span>Cerrar Sesión</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>
        </aside>

        
        <nav class="app-navbar">
            <div class="navbar-left">
                <button class="mobile-menu-btn" onclick="openMobileSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="navbar-title">{{ $header ?? 'Dashboard' }}</h1>
            </div>

            <div class="navbar-right">
                
                <button class="user-icon-btn" onclick="toggleUserMenu()" id="user-icon-btn">
                    <i class="fas fa-user"></i>
                </button>

                
                <div id="user-menu" class="user-dropdown-menu">
                    <div class="user-dropdown-header">
                        <div class="user-dropdown-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="user-dropdown-info">
                            <div class="user-dropdown-name">{{ Auth::user()->name }}</div>
                            <div class="user-dropdown-email">{{ Auth::user()->email }}</div>
                        </div>
                    </div>
                    <div class="user-dropdown-divider"></div>
                    <nav class="user-dropdown-nav">
                        <a href="{{ route('profile.edit') }}" class="user-dropdown-link">
                            <span class="user-dropdown-link-icon">
                                <i class="fas fa-user-cog"></i>
                            </span>
                            <span class="user-dropdown-link-text">Perfil</span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="user-dropdown-form">
                            @csrf
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

        
        <div class="main-content with-sidebar" id="mainContent">
            
            <main class="content-wrapper fade-in">
                {{ $slot }}
            </main>

            
            
        </div>
    </div>

    <script>
        // Desktop Sidebar toggle functionality
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');

        // Desktop sidebar functionality explicitly locked OPEN on desktop mode.
        // Mobile mode collapses it dynamically.
        let sidebarOpen = true;

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
            } else {
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
        document.addEventListener('click', function (event) {
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

        // --- Dark Mode Logic ---
        function applyDarkModeUI(isDark) {
            document.querySelectorAll('.theme-toggle-icon i').forEach(icon => {
                icon.className = isDark ? 'fas fa-sun' : 'fas fa-moon';
            });
            document.querySelectorAll('.theme-toggle-text').forEach(text => {
                text.textContent = isDark ? 'Modo Claro' : 'Modo Oscuro';
            });
        }

        function toggleDarkMode() {
            document.documentElement.classList.toggle('dark-mode');
            const isDark = document.documentElement.classList.contains('dark-mode');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            applyDarkModeUI(isDark);
        }

        // Initialize dark mode on load
        document.addEventListener('DOMContentLoaded', () => {
            const hasDarkPreference = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const savedTheme = localStorage.getItem('theme');
            const isDark = savedTheme === 'dark' || (!savedTheme && hasDarkPreference);
            
            if (isDark) {
                document.documentElement.classList.add('dark-mode');
            }
            applyDarkModeUI(isDark);
        });

    </script>
</body>
</html>
