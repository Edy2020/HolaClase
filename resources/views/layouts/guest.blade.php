<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'HolaClase') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background: #0f172a; /* Dark navy */
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .guest-container {
            width: 100%;
            display: flex;
            justify-content: center;
            padding: var(--spacing-md);
            box-sizing: border-box;
        }
        .guest-card {
            background: #1e293b; /* Lighter dark */
            border: 1px solid #334155;
            border-radius: var(--radius-xl);
            padding: var(--spacing-xl);
            width: 100%;
            max-width: 25rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            color: #f1f5f9;
        }
        .guest-title {
            color: #ffffff;
            font-size: 1.75rem;
            text-align: center;
            margin-bottom: var(--spacing-xs);
        }
        .guest-subtitle {
            text-align: center;
            color: #cbd5e1;
            margin-bottom: var(--spacing-xl);
            font-size: 0.875rem;
        }
        .guest-logo {
            width: 80px;
            height: 80px;
            margin: 0 auto var(--spacing-md);
            background: #84cc16; /* Accent Green */
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 15px;
        }
        .form-label {
            color: #e2e8f0 !important;
            font-weight: 500;
        }
        .form-input {
            background: #0f172a !important;
            border: 1px solid #334155 !important;
            color: white !important;
            width: 100%;
        }
        .form-input:focus {
            border-color: #84cc16 !important;
            outline: none !important;
            box-shadow: 0 0 0 3px rgba(132, 204, 22, 0.2) !important;
        }
        .guest-footer {
            text-align: center;
            margin-top: var(--spacing-xl);
            font-size: 0.75rem;
            color: #94a3b8;
        }
        .btn-primary {
            background: #84cc16 !important;
            border: none !important;
            color: white !important;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.2s;
        }
        .btn-primary:hover {
            opacity: 0.9;
        }
        /* Override check colors */
        #remember_me {
            appearance: auto !important;
            -webkit-appearance: auto !important;
            width: 1.125rem !important;
            height: 1.125rem !important;
            accent-color: #84cc16;
            cursor: pointer;
        }
        /* Mobile adjustment */
        @media (max-width: 480px) {
            .guest-card {
                padding: var(--spacing-lg) var(--spacing-md);
                border-radius: var(--radius-lg);
                border: none;
                box-shadow: none;
            }
            body {
                background: #1e293b; /* match mobile card to blend */
            }
        }
    </style>
</head>
<body>
    <div class="guest-container">
        <div class="guest-card fade-in">
            <div class="guest-header">
                <a href="{{ url('/') }}" style="text-decoration: none;">
                    <div class="guest-logo">
                        <img src="{{ asset('hc_icon.png') }}" alt="HolaClase" style="width: 90%; height: 90%; object-fit: contain;">
                    </div>
                </a>
                <h1 class="guest-title">HolaClase</h1>
                <p class="guest-subtitle">Sistema de Gestión Educativa</p>
            </div>

            {{ $slot }}

            <div class="guest-footer">
                <p>&copy; {{ date('Y') }} HolaClase. Todos los derechos reservados.</p>
            </div>
        </div>
    </div>
</body>
</html>
