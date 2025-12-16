<x-app-layout>
    <x-slot name="header">
        Configuración del Sistema
    </x-slot>

    <div style="max-width: 1200px;">
        <!-- Header -->
        <div style="margin-bottom: var(--spacing-2xl);">
            <h2 style="font-size: 1.75rem; font-weight: 700; color: var(--gray-900); margin-bottom: var(--spacing-xs);">
                <i class="fas fa-cog"></i> Configuración del Sistema
            </h2>
            <p style="color: var(--gray-600); margin: 0;">
                Personaliza la apariencia y comportamiento de HolaClase
            </p>
        </div>

        <!-- Theme Selection -->
        <div class="card mb-xl">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-palette"></i> Tema del Sistema</h3>
            </div>
            <div class="card-body">
                <p style="color: var(--gray-600); margin-bottom: var(--spacing-xl);">
                    Selecciona el tema de colores que prefieras para personalizar la interfaz del sistema
                </p>

                <div class="grid grid-cols-3">
                    <!-- Tema Morado Oscuro (Default) -->
                    <div class="theme-card active" data-theme="purple" onclick="selectTheme('purple')">
                        <div style="display: flex; align-items: center; gap: var(--spacing-md); margin-bottom: var(--spacing-lg);">
                            <div style="width: 50px; height: 50px; border-radius: var(--radius-lg); background: #7e22ce; box-shadow: var(--shadow-md);"></div>
                            <div>
                                <h4 style="font-weight: 700; color: var(--gray-900); margin: 0 0 var(--spacing-xs) 0;">Morado Oscuro</h4>
                                <p style="font-size: 0.875rem; color: var(--gray-600); margin: 0;">Creativo y moderno</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tema Gris Oscuro -->
                    <div class="theme-card" data-theme="gray" onclick="selectTheme('gray')">
                        <div style="display: flex; align-items: center; gap: var(--spacing-md); margin-bottom: var(--spacing-lg);">
                            <div style="width: 50px; height: 50px; border-radius: var(--radius-lg); background: #52525b; box-shadow: var(--shadow-md);"></div>
                            <div>
                                <h4 style="font-weight: 700; color: var(--gray-900); margin: 0 0 var(--spacing-xs) 0;">Gris Oscuro</h4>
                                <p style="font-size: 0.875rem; color: var(--gray-600); margin: 0;">Elegante y profesional</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tema Azul Oscuro -->
                    <div class="theme-card" data-theme="blue" onclick="selectTheme('blue')">
                        <div style="display: flex; align-items: center; gap: var(--spacing-md); margin-bottom: var(--spacing-lg);">
                            <div style="width: 50px; height: 50px; border-radius: var(--radius-lg); background: #0284c7; box-shadow: var(--shadow-md);"></div>
                            <div>
                                <h4 style="font-weight: 700; color: var(--gray-900); margin: 0 0 var(--spacing-xs) 0;">Azul Oscuro</h4>
                                <p style="font-size: 0.875rem; color: var(--gray-600); margin: 0;">Confiable y corporativo</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tema Verde Esmeralda -->
                    <div class="theme-card" data-theme="green" onclick="selectTheme('green')">
                        <div style="display: flex; align-items: center; gap: var(--spacing-md); margin-bottom: var(--spacing-lg);">
                            <div style="width: 50px; height: 50px; border-radius: var(--radius-lg); background: #059669; box-shadow: var(--shadow-md);"></div>
                            <div>
                                <h4 style="font-weight: 700; color: var(--gray-900); margin: 0 0 var(--spacing-xs) 0;">Verde Esmeralda</h4>
                                <p style="font-size: 0.875rem; color: var(--gray-600); margin: 0;">Natural y equilibrado</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tema Carmesí -->
                    <div class="theme-card" data-theme="crimson" onclick="selectTheme('crimson')">
                        <div style="display: flex; align-items: center; gap: var(--spacing-md); margin-bottom: var(--spacing-lg);">
                            <div style="width: 50px; height: 50px; border-radius: var(--radius-lg); background: #dc2626; box-shadow: var(--shadow-md);"></div>
                            <div>
                                <h4 style="font-weight: 700; color: var(--gray-900); margin: 0 0 var(--spacing-xs) 0;">Carmesí</h4>
                                <p style="font-size: 0.875rem; color: var(--gray-600); margin: 0;">Potente y audaz</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tema Ámbar -->
                    <div class="theme-card" data-theme="amber" onclick="selectTheme('amber')">
                        <div style="display: flex; align-items: center; gap: var(--spacing-md); margin-bottom: var(--spacing-lg);">
                            <div style="width: 50px; height: 50px; border-radius: var(--radius-lg); background: #d97706; box-shadow: var(--shadow-md);"></div>
                            <div>
                                <h4 style="font-weight: 700; color: var(--gray-900); margin: 0 0 var(--spacing-xs) 0;">Ámbar</h4>
                                <p style="font-size: 0.875rem; color: var(--gray-600); margin: 0;">Energético y cálido</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div style="display: flex; justify-content: flex-end; gap: var(--spacing-md);">
                    <button class="btn btn-ghost" onclick="resetTheme()">Restablecer</button>
                </div>
            </div>
        </div>

        <!-- Other Settings -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-wrench"></i> Otras Configuraciones</h3>
            </div>
            <div class="card-body">
                <div style="display: flex; flex-direction: column; gap: var(--spacing-xl);">
                    <!-- Notifications -->
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: var(--spacing-md); background: var(--gray-50); border-radius: var(--radius-md);">
                        <div>
                            <h4 style="font-weight: 600; color: var(--gray-900); margin: 0 0 var(--spacing-xs) 0;">Notificaciones</h4>
                            <p style="font-size: 0.875rem; color: var(--gray-600); margin: 0;">Recibir notificaciones del sistema</p>
                        </div>
                        <label style="position: relative; display: inline-block; width: 60px; height: 34px;">
                            <input type="checkbox" checked style="opacity: 0; width: 0; height: 0;">
                            <span style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: var(--theme-color); transition: .4s; border-radius: 34px;"></span>
                        </label>
                    </div>

                    <!-- Language -->
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: var(--spacing-md); background: var(--gray-50); border-radius: var(--radius-md);">
                        <div>
                            <h4 style="font-weight: 600; color: var(--gray-900); margin: 0 0 var(--spacing-xs) 0;">Idioma</h4>
                            <p style="font-size: 0.875rem; color: var(--gray-600); margin: 0;">Idioma de la interfaz</p>
                        </div>
                        <select class="form-select" style="width: 200px;">
                            <option selected>Español</option>
                            <option>English</option>
                            <option>Português</option>
                        </select>
                    </div>

                    <!-- Timezone -->
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: var(--spacing-md); background: var(--gray-50); border-radius: var(--radius-md);">
                        <div>
                            <h4 style="font-weight: 600; color: var(--gray-900); margin: 0 0 var(--spacing-xs) 0;">Zona Horaria</h4>
                            <p style="font-size: 0.875rem; color: var(--gray-600); margin: 0;">Configuración de hora local</p>
                        </div>
                        <select class="form-select" style="width: 200px;">
                            <option selected>Santiago (GMT-3)</option>
                            <option>Buenos Aires (GMT-3)</option>
                            <option>Lima (GMT-5)</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .grid {
            display: grid;
            gap: var(--spacing-lg);
        }

        .grid-cols-3 {
            grid-template-columns: repeat(3, 1fr);
        }

        .theme-card {
            background: white;
            border-radius: var(--radius-lg);
            padding: var(--spacing-lg);
            cursor: pointer;
            border: 2px solid var(--gray-200);
        }

        .theme-card.active {
            border-width: 3px;
            border-color: var(--theme-color);
        }

        @media (max-width: 768px) {
            .grid-cols-3 {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <script>
        let selectedTheme = 'purple';

        function selectTheme(theme) {
            selectedTheme = theme;
            
            // Remove active class from all cards
            document.querySelectorAll('.theme-card').forEach(card => {
                card.classList.remove('active');
            });
            
            // Add active class to selected card
            document.querySelector(`[data-theme="${theme}"]`).classList.add('active');
            
            // Apply theme immediately
            applyTheme(theme);
        }

        function resetTheme() {
            selectTheme('purple');
        }

        function applyTheme(theme) {
            // Apply theme to HTML element
            document.documentElement.setAttribute('data-theme', theme);
            
            // Store in localStorage
            localStorage.setItem('holaclase_theme', theme);
        }

        // Load saved theme on page load
        window.addEventListener('DOMContentLoaded', function() {
            const savedTheme = localStorage.getItem('holaclase_theme') || 'gray';
            selectTheme(savedTheme);
        });
    </script>
</x-app-layout>
