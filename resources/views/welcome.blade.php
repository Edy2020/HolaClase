<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'HolaClase') }} - Sistema de Gestión Educativa</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/themes.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
</head>

<body>
    <nav class="navbar">
        <div class="navbar-container">
            <a href="{{ url('/') }}" class="navbar-logo">
                <div class="navbar-logo-icon">
                    <img src="{{ asset('hc_icon.png') }}" alt="HolaClase"
                        style="width: 100%; height: 100%; object-fit: contain;">
                </div>
                <span class="navbar-logo-text">HolaClase</span>
            </a>
            <div class="navbar-links">
                <a href="#features" class="navbar-link">Características</a>
                <a href="#testimonials" class="navbar-link">Testimonios</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="navbar-btn">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="navbar-btn-outline">Iniciar Sesión</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="navbar-btn">Crear Cuenta</a>
                    @endif
                @endauth
            </div>
            <button class="mobile-menu-btn-welcome" onclick="openWelcomeSidebar()">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </nav>

    <div class="welcome-mobile-overlay" id="welcomeOverlay" onclick="closeWelcomeSidebar()"></div>

    <aside class="welcome-mobile-sidebar" id="welcomeSidebar">
        <div class="welcome-sidebar-header">
            <span class="welcome-sidebar-title">
                <i class="fas fa-bars"></i>
                Menú
            </span>
            <button class="welcome-sidebar-close" onclick="closeWelcomeSidebar()">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="welcome-sidebar-links">
            @auth
                <a href="{{ route('dashboard') }}" class="welcome-sidebar-link primary">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            @else
                <a href="{{ route('login') }}" class="welcome-sidebar-link">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Iniciar Sesión</span>
                </a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="welcome-sidebar-link primary">
                        <i class="fas fa-user-plus"></i>
                        <span>Crear Cuenta</span>
                    </a>
                @endif
            @endauth
        </div>
    </aside>

    <section class="hero-section">
        <div class="hero-content fade-in">
            <div class="hero-logo">
                <img src="{{ asset('hc_icon.png') }}" alt="HolaClase"
                    style="width: 100%; height: 100%; object-fit: contain;">
            </div>
            <h1 class="hero-title">Bienvenido a HolaClase</h1>
            <p class="hero-subtitle">
                El sistema de gestión educativa moderno que simplifica la administración de cursos, estudiantes,
                asistencia y notas
            </p>
            <div class="hero-buttons">
                @auth
                    <a href="{{ route('dashboard') }}" class="hero-btn hero-btn-primary">
                        <span>Ir al Dashboard</span>
                        <span>→</span>
                    </a>
                @endauth
            </div>

            <div class="scroll-indicator"
                onclick="document.querySelector('.stats-section').scrollIntoView({behavior: 'smooth'});">
                <span class="scroll-indicator-text">Descubre más</span>
                <i class="fas fa-chevron-down scroll-indicator-icon"></i>
            </div>
        </div>
    </section>

    <section class="stats-section">
        <div class="stats-container">
            <div class="stat-box fade-in" style="animation-delay: 0.1s;">
                <div class="stat-number">248+</div>
                <div class="stat-label">Estudiantes Activos</div>
            </div>
            <div class="stat-box fade-in" style="animation-delay: 0.2s;">
                <div class="stat-number">15+</div>
                <div class="stat-label">Profesores</div>
            </div>
            <div class="stat-box fade-in" style="animation-delay: 0.3s;">
                <div class="stat-number">24+</div>
                <div class="stat-label">Asignaturas</div>
            </div>
            <div class="stat-box fade-in" style="animation-delay: 0.4s;">
                <div class="stat-number">94%</div>
                <div class="stat-label">Asistencia Promedio</div>
            </div>
        </div>
    </section>

    <section class="features-section" id="features">
        <div class="features-container">
            <h2 class="section-title">Características Principales</h2>
            <p class="section-subtitle">
                Todo lo que necesitas para gestionar tu institución educativa en un solo lugar
            </p>

            <div class="features-grid">
                <div class="feature-card slide-in-right" style="animation-delay: 0.1s;">
                    <div class="feature-icon"><i class="fas fa-graduation-cap"></i></div>
                    <h3 class="feature-title">Gestión de Cursos</h3>
                    <p class="feature-description">
                        Crea y administra cursos fácilmente. Organiza contenidos, asigna profesores y mantén todo bajo
                        control.
                    </p>
                </div>

                <div class="feature-card slide-in-right" style="animation-delay: 0.2s;">
                    <div class="feature-icon"><i class="fas fa-users"></i></div>
                    <h3 class="feature-title">Control de Estudiantes</h3>
                    <p class="feature-description">
                        Registra estudiantes, gestiona sus datos y mantén un seguimiento completo de su progreso
                        académico.
                    </p>
                </div>

                <div class="feature-card slide-in-right" style="animation-delay: 0.3s;">
                    <div class="feature-icon"><i class="fas fa-calendar-check"></i></div>
                    <h3 class="feature-title">Asistencia Digital</h3>
                    <p class="feature-description">
                        Pasa lista de forma rápida y eficiente. Genera reportes automáticos de asistencia por curso.
                    </p>
                </div>

                <div class="feature-card slide-in-right" style="animation-delay: 0.4s;">
                    <div class="feature-icon"><i class="fas fa-chart-line"></i></div>
                    <h3 class="feature-title">Notas</h3>
                    <p class="feature-description">
                        Registra y calcula notas automáticamente. Genera boletines y reportes académicos.
                    </p>
                </div>

                <div class="feature-card slide-in-right" style="animation-delay: 0.5s;">
                    <div class="feature-icon"><i class="fas fa-chart-bar"></i></div>
                    <h3 class="feature-title">Reportes y Estadísticas</h3>
                    <p class="feature-description">
                        Visualiza el rendimiento con gráficos y estadísticas detalladas en tiempo real.
                    </p>
                </div>

                <div class="feature-card slide-in-right" style="animation-delay: 0.6s;">
                    <div class="feature-icon"><i class="fas fa-lock"></i></div>
                    <h3 class="feature-title">Seguro y Confiable</h3>
                    <p class="feature-description">
                        Tus datos están protegidos con las mejores prácticas de seguridad y encriptación.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="testimonials-section" id="testimonials">
        <div class="features-container">
            <h2 class="section-title">Lo que dicen nuestros usuarios</h2>
            <p class="section-subtitle">
                Instituciones educativas que confían en HolaClase
            </p>

            <div class="testimonials-grid">
                <div class="testimonial-card fade-in" style="animation-delay: 0.1s;">
                    <p class="testimonial-quote">
                        "HolaClase ha transformado completamente la forma en que gestionamos nuestra institución. La
                        interfaz es intuitiva y las funcionalidades son exactamente lo que necesitábamos."
                    </p>
                    <div class="testimonial-author">
                        <div class="testimonial-avatar">MG</div>
                        <div class="testimonial-info">
                            <div class="testimonial-name">María González</div>
                            <div class="testimonial-role">Directora, Colegio San José</div>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card fade-in" style="animation-delay: 0.2s;">
                    <p class="testimonial-quote">
                        "El sistema de asistencia y notas nos ha ahorrado horas de trabajo administrativo. Ahora podemos
                        enfocarnos más en la enseñanza."
                    </p>
                    <div class="testimonial-author">
                        <div class="testimonial-avatar">CR</div>
                        <div class="testimonial-info">
                            <div class="testimonial-name">Carlos Ruiz</div>
                            <div class="testimonial-role">Profesor de Matemáticas</div>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card fade-in" style="animation-delay: 0.3s;">
                    <p class="testimonial-quote">
                        "La facilidad para generar reportes y estadísticas nos permite tomar decisiones informadas sobre
                        el rendimiento académico de nuestros estudiantes."
                    </p>
                    <div class="testimonial-author">
                        <div class="testimonial-avatar">LP</div>
                        <div class="testimonial-info">
                            <div class="testimonial-name">Laura Pérez</div>
                            <div class="testimonial-role">Coordinadora Académica</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="cta-section">
        <h2 class="cta-title">¿Listo para comenzar?</h2>
        <p class="cta-subtitle">
            Únete a HolaClase y transforma la gestión de tu institución educativa
        </p>
        <div style="display: flex; gap: var(--spacing-lg); justify-content: center; flex-wrap: wrap;">
            @auth
                <a href="{{ route('dashboard') }}" class="hero-btn hero-btn-primary">
                    <span>Ir al Dashboard</span>
                    <span>→</span>
                </a>
            @else
                <a href="{{ route('register') }}" class="hero-btn hero-btn-primary">
                    <span>Crear Cuenta Gratis</span>
                    <span>→</span>
                </a>
                <a href="{{ route('login') }}" class="hero-btn hero-btn-secondary">
                    <span>Iniciar Sesión</span>
                </a>
            @endauth
        </div>
    </section>

    <footer class="footer">
        <div class="footer-content">
            <div class="footer-grid">
                <div>
                    <div class="navbar-logo" style="margin-bottom: var(--spacing-md);">
                        <div class="navbar-logo-icon">
                            <img src="{{ asset('hc_icon.png') }}" alt="HolaClase"
                                style="width: 100%; height: 100%; object-fit: contain;">
                        </div>
                        <span class="navbar-logo-text" style="color: white;">HolaClase</span>
                    </div>
                    <p class="footer-description">
                        El sistema de gestión educativa moderno que simplifica la administración de cursos, estudiantes
                        y notas.
                    </p>
                    <div class="footer-social">
                        <a href="#" class="footer-social-link" aria-label="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="footer-social-link" aria-label="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="footer-social-link" aria-label="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="footer-social-link" aria-label="LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>

                <div>
                    <h3 class="footer-section-title">Enlaces Rápidos</h3>
                    <ul class="footer-links">
                        <li class="footer-link"><a href="#features">Características</a></li>
                        <li class="footer-link"><a href="#testimonials">Testimonios</a></li>
                        <li class="footer-link"><a href="{{ route('login') }}">Iniciar Sesión</a></li>
                        @if (Route::has('register'))
                            <li class="footer-link"><a href="{{ route('register') }}">Crear Cuenta</a></li>
                        @endif
                    </ul>
                </div>

                <div>
                    <h3 class="footer-section-title">Recursos</h3>
                    <ul class="footer-links">
                        <li class="footer-link"><a href="#">Documentación</a></li>
                        <li class="footer-link"><a href="#">Guías de Usuario</a></li>
                        <li class="footer-link"><a href="#">Soporte Técnico</a></li>
                        <li class="footer-link"><a href="#">Preguntas Frecuentes</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="footer-section-title">Contacto</h3>
                    <ul class="footer-links">
                        <li class="footer-link">
                            <i class="fas fa-envelope" style="margin-right: var(--spacing-xs);"></i>
                            <a href="mailto:info@holaclase.edu">info@holaclase.edu</a>
                        </li>
                        <li class="footer-link">
                            <i class="fas fa-phone" style="margin-right: var(--spacing-xs);"></i>
                            <a href="tel:+56912345678">+56 9 1234 5678</a>
                        </li>
                        <li class="footer-link">
                            <i class="fas fa-map-marker-alt" style="margin-right: var(--spacing-xs);"></i>
                            <span style="color: rgba(255, 255, 255, 0.7);">Santiago, Chile</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <p class="footer-text">&copy; {{ date('Y') }} HolaClase. Sistema de Gestión Educativa. Todos los
                    derechos reservados.</p>
            </div>
        </div>
    </footer>

    <script>
        function openWelcomeSidebar() {
            document.getElementById('welcomeSidebar').classList.add('open');
            document.getElementById('welcomeOverlay').classList.add('show');
        }

        function closeWelcomeSidebar() {
            document.getElementById('welcomeSidebar').classList.remove('open');
            document.getElementById('welcomeOverlay').classList.remove('show');
        }

        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>

</html>