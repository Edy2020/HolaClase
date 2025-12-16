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

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="guest-container">
        <div class="guest-card fade-in">
            <div class="guest-header">
                <div class="guest-logo">HC</div>
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
