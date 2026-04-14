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
    <style>
        .sidebar-logo-text {
            font-family: 'Pacifico', cursive;
            font-size: 1.7rem;
            font-weight: 400;
            margin-top: 5px; /* Adjust slight vertical offset for cursive fonts */
        }
    </style>
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
                        <a href="{{ route('attendance.dashboard') }}"
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

                    <li class="sidebar-nav-item" style="margin-top: auto; border-top: 1px solid var(--gray-200); padding: 1rem;">
                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <a href="{{ route('profile.edit') }}" style="display: flex; align-items: center; text-decoration: none; color: inherit; flex: 1; overflow: hidden; gap: 0.75rem;">
                                <div style="width: 36px; height: 36px; border-radius: 50%; background: var(--primary-color, #4338ca); color: white; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div style="overflow: hidden;">
                                    <div style="font-weight: 600; font-size: 0.875rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; color: var(--text-primary, inherit);">{{ Auth::user()->name }}</div>
                                    <div style="font-size: 0.75rem; color: var(--text-secondary, #6b7280); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ Auth::user()->email }}</div>
                                </div>
                            </a>
                            <div style="display: flex; align-items: center; gap: 0.25rem; flex-shrink: 0; margin-left: 0.5rem;">
                                <button onclick="toggleDarkMode(); return false;" style="background: none; border: none; cursor: pointer; color: var(--text-secondary, #6b7280); padding: 0.4rem; border-radius: 0.375rem;" title="Alternar tema">
                                    <span class="theme-toggle-icon"><i class="fas fa-moon"></i></span>
                                </button>
                                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                                    @csrf
                                    <button type="submit" style="background: none; border: none; cursor: pointer; color: #ef4444; padding: 0.4rem; border-radius: 0.375rem;" title="Cerrar Sesión">
                                        <i class="fas fa-sign-out-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
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
                        <a href="{{ route('attendance.dashboard') }}"
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

                    <li class="sidebar-nav-item" style="margin-top: auto; border-top: 1px solid var(--gray-200); padding: 1rem;">
                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <a href="{{ route('profile.edit') }}" style="display: flex; align-items: center; text-decoration: none; color: inherit; flex: 1; overflow: hidden; gap: 0.75rem;">
                                <div style="width: 36px; height: 36px; border-radius: 50%; background: var(--primary-color, #4338ca); color: white; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div style="overflow: hidden;">
                                    <div style="font-weight: 600; font-size: 0.875rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; color: var(--text-primary, inherit);">{{ Auth::user()->name }}</div>
                                    <div style="font-size: 0.75rem; color: var(--text-secondary, #6b7280); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ Auth::user()->email }}</div>
                                </div>
                            </a>
                            <div style="display: flex; align-items: center; gap: 0.25rem; flex-shrink: 0; margin-left: 0.5rem;">
                                <button onclick="toggleDarkMode(); return false;" style="background: none; border: none; cursor: pointer; color: var(--text-secondary, #6b7280); padding: 0.4rem; border-radius: 0.375rem;" title="Alternar tema">
                                    <span class="theme-toggle-icon"><i class="fas fa-moon"></i></span>
                                </button>
                                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                                    @csrf
                                    <button type="submit" style="background: none; border: none; cursor: pointer; color: #ef4444; padding: 0.4rem; border-radius: 0.375rem;" title="Cerrar Sesión">
                                        <i class="fas fa-sign-out-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
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
