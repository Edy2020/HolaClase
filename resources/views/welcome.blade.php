<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'HolaClase') }} - Sistema de Gestión Educativa</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800" rel="stylesheet" />
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    
    <style>
        .hero-section {
            min-height: 100vh;
            background: var(--theme-color) 0%, var(--secondary-700) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: var(--spacing-2xl);
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><circle cx="50" cy="50" r="2" fill="white" opacity="0.1"/></svg>');
            background-size: 50px 50px;
        }
        
        .hero-content {
            max-width: 1200px;
            text-align: center;
            position: relative;
            z-index: 1;
        }
        
        .hero-title {
            font-size: 4rem;
            font-weight: 800;
            color: white;
            margin-bottom: var(--spacing-lg);
            line-height: 1.1;
        }
        
        .hero-subtitle {
            font-size: 1.5rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: var(--spacing-2xl);
            font-weight: 400;
        }
        
        .hero-buttons {
            display: flex;
            gap: var(--spacing-lg);
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .hero-btn {
            padding: var(--spacing-lg) var(--spacing-2xl);
            font-size: 1.125rem;
            font-weight: 700;
            border-radius: var(--radius-lg);
            text-decoration: none;
            transition: all var(--transition-base);
            display: inline-flex;
            align-items: center;
            gap: var(--spacing-sm);
        }
        
        .hero-btn-primary {
            background: white;
            color: var(--theme-dark);
            box-shadow: var(--shadow-xl);
        }
        
        .hero-btn-primary:hover {
            transform: translateY(-4px);
            box-shadow: 0 30px 40px -10px rgba(0, 0, 0, 0.3);
        }
        
        .hero-btn-secondary {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid white;
            backdrop-filter: blur(10px);
        }
        
        .hero-btn-secondary:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-4px);
        }
        
        .features-section {
            padding: var(--spacing-3xl) var(--spacing-2xl);
            background: white;
        }
        
        .features-container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .section-title {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--gray-900);
            margin-bottom: var(--spacing-md);
        }
        
        .section-subtitle {
            text-align: center;
            font-size: 1.125rem;
            color: var(--gray-600);
            margin-bottom: var(--spacing-3xl);
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: var(--spacing-2xl);
        }
        
        .feature-card {
            background: white;
            border-radius: var(--radius-xl);
            padding: var(--spacing-2xl);
            box-shadow: var(--shadow-md);
            transition: all var(--transition-base);
            border: 2px solid var(--gray-100);
        }
        
        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-xl);
            border-color: var(--primary-200);
        }
        
        .feature-icon {
            width: 70px;
            height: 70px;
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin-bottom: var(--spacing-lg);
            background: var(--theme-color), var(--secondary-100));
        }
        
        .feature-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: var(--spacing-sm);
        }
        
        .feature-description {
            color: var(--gray-600);
            line-height: 1.6;
        }
        
        .cta-section {
            padding: var(--spacing-3xl) var(--spacing-2xl);
            background: var(--theme-color) 0%, var(--gray-800) 100%);
            text-align: center;
        }
        
        .cta-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: white;
            margin-bottom: var(--spacing-lg);
        }
        
        .cta-subtitle {
            font-size: 1.25rem;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: var(--spacing-2xl);
        }
        
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.125rem;
            }
            
            .hero-buttons {
                flex-direction: column;
            }
            
            .section-title {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-content fade-in">
            <h1 class="hero-title">Bienvenido a HolaClase</h1>
            <p class="hero-subtitle">
                El sistema de gestión educativa que simplifica la administración de cursos, estudiantes y calificaciones
            </p>
            <div class="hero-buttons">
                @auth
                    <a href="{{ route('dashboard') }}" class="hero-btn hero-btn-primary">
                        <span>Ir al Dashboard</span>
                        <span>→</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="hero-btn hero-btn-primary">
                        <span>Iniciar Sesión</span>
                        <span>→</span>
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="hero-btn hero-btn-secondary">
                            <span>Crear Cuenta</span>
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="features-container">
            <h2 class="section-title">Características Principales</h2>
            <p class="section-subtitle">
                Todo lo que necesitas para gestionar tu institución educativa en un solo lugar
            </p>
            
            <div class="features-grid">
                <div class="feature-card slide-in-right" style="animation-delay: 0.1s;">
                    <div class="feature-icon"><i class="fas fa-book"></i></div>
                    <h3 class="feature-title">Gestión de Cursos</h3>
                    <p class="feature-description">
                        Crea y administra cursos fácilmente. Organiza contenidos, asigna profesores y mantén todo bajo control.
                    </p>
                </div>
                
                <div class="feature-card slide-in-right" style="animation-delay: 0.2s;">
                    <div class="feature-icon"><i class="fas fa-users"></i></div>
                    <h3 class="feature-title">Control de Estudiantes</h3>
                    <p class="feature-description">
                        Registra estudiantes, gestiona sus datos y mantén un seguimiento completo de su progreso académico.
                    </p>
                </div>
                
                <div class="feature-card slide-in-right" style="animation-delay: 0.3s;">
                    <div class="feature-icon"><i class="fas fa-check"></i></div>
                    <h3 class="feature-title">Asistencia Digital</h3>
                    <p class="feature-description">
                        Pasa lista de forma rápida y eficiente. Genera reportes automáticos de asistencia por curso.
                    </p>
                </div>
                
                <div class="feature-card slide-in-right" style="animation-delay: 0.4s;">
                    <div class="feature-icon"><i class="fas fa-clipboard"></i></div>
                    <h3 class="feature-title">Calificaciones</h3>
                    <p class="feature-description">
                        Registra y calcula calificaciones automáticamente. Genera boletines y reportes académicos.
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
                    <div class="feature-icon">🔒</div>
                    <h3 class="feature-title">Seguro y Confiable</h3>
                    <p class="feature-description">
                        Tus datos están protegidos con las mejores prácticas de seguridad y encriptación.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
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

    <!-- Footer -->
    <footer style="background: var(--gray-900); color: white; padding: var(--spacing-2xl); text-align: center;">
        <p style="margin: 0;">&copy; {{ date('Y') }} HolaClase. Sistema de Gestión Educativa. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
