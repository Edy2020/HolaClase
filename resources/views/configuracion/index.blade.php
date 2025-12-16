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

                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: var(--spacing-lg); margin-bottom: var(--spacing-2xl);" class="grid-cols-3">
                    <!-- Tema Morado -->
                    <div class="theme-card" data-theme="purple" onclick="selectTheme('purple')">
                        <div style="display: flex; align-items: center; gap: var(--spacing-md); margin-bottom: var(--spacing-lg);">
                            <div style="width: 50px; height: 50px; border-radius: var(--radius-lg); background: #7e22ce; box-shadow: var(--shadow-md);"></div>
                            <div>
                                <h4 style="font-weight: 700; color: var(--gray-900); margin: 0 0 var(--spacing-xs) 0;">Morado Oscuro</h4>
                                <p style="font-size: 0.875rem; color: var(--gray-600); margin: 0;">Creativo y moderno</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tema Gris -->
                    <div class="theme-card" data-theme="gray" onclick="selectTheme('gray')">
                        <div style="display: flex; align-items: center; gap: var(--spacing-md); margin-bottom: var(--spacing-lg);">
                            <div style="width: 50px; height: 50px; border-radius: var(--radius-lg); background: #52525b; box-shadow: var(--shadow-md);"></div>
                            <div>
                                <h4 style="font-weight: 700; color: var(--gray-900); margin: 0 0 var(--spacing-xs) 0;">Gris Oscuro</h4>
                                <p style="font-size: 0.875rem; color: var(--gray-600); margin: 0;">Elegante y profesional</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tema Azul -->
                    <div class="theme-card" data-theme="blue" onclick="selectTheme('blue')">
                        <div style="display: flex; align-items: center; gap: var(--spacing-md); margin-bottom: var(--spacing-lg);">
                            <div style="width: 50px; height: 50px; border-radius: var(--radius-lg); background: #0284c7; box-shadow: var(--shadow-md);"></div>
                            <div>
                                <h4 style="font-weight: 700; color: var(--gray-900); margin: 0 0 var(--spacing-xs) 0;">Azul Oscuro</h4>
                                <p style="font-size: 0.875rem; color: var(--gray-600); margin: 0;">Confiable y corporativo</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tema Verde -->
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

                    <!-- Tema Personalizado -->
                    <div class="theme-card" data-theme="custom" onclick="selectTheme('custom')">
                        <div style="display: flex; align-items: center; gap: var(--spacing-md); margin-bottom: var(--spacing-md);">
                            <div id="custom-color-preview" style="width: 50px; height: 50px; border-radius: var(--radius-lg); background: #7e22ce; box-shadow: var(--shadow-md);"></div>
                            <div style="flex: 1;">
                                <h4 style="font-weight: 700; color: var(--gray-900); margin: 0 0 var(--spacing-xs) 0;">Personalizado</h4>
                                <p style="font-size: 0.875rem; color: var(--gray-600); margin: 0 0 var(--spacing-sm) 0;">Elige tu propio color</p>
                                <label for="custom-color-picker" style="display: inline-block; padding: var(--spacing-xs) var(--spacing-md); background: var(--gray-100); border: 1px solid var(--gray-300); border-radius: var(--radius-md); color: var(--gray-700); font-size: 0.875rem; font-weight: 500; cursor: pointer; transition: all var(--transition-fast);" onmouseover="this.style.background='var(--gray-200)'" onmouseout="this.style.background='var(--gray-100)'">
                                    <i class="fas fa-palette"></i> Seleccionar Color
                                </label>
                                <input type="color" id="custom-color-picker" value="#7e22ce" 
                                       style="position: absolute; opacity: 0; width: 0; height: 0;"
                                       onchange="updateCustomColor(this.value)"
                                       onclick="event.stopPropagation()">
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
            border: 2px solid var(--gray-200);
            border-radius: var(--radius-lg);
            padding: var(--spacing-lg);
            cursor: pointer;
            transition: all var(--transition-base);
        }

        .theme-card:hover {
            border-color: var(--gray-300);
            box-shadow: var(--shadow-md);
        }

        .theme-card.selected {
            border-width: 3px;
            border-color: var(--theme-color);
            box-shadow: var(--shadow-lg);
        }

        @media (max-width: 768px) {
            .grid-cols-3 {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <script>
        // Theme selection
        let selectedTheme = 'purple';

        function selectTheme(theme) {
            selectedTheme = theme;
            
            // Remove selected class from all cards
            document.querySelectorAll('.theme-card').forEach(card => {
                card.classList.remove('selected');
            });
            
            // Add selected class to clicked card
            const selectedCard = document.querySelector(`.theme-card[data-theme="${theme}"]`);
            if (selectedCard) {
                selectedCard.classList.add('selected');
            }
            
            // Apply theme
            applyTheme(theme);
        }

        function resetTheme() {
            selectTheme('purple');
        }

        function applyTheme(theme) {
            document.documentElement.setAttribute('data-theme', theme);
            localStorage.setItem('theme', theme);
            
            // If custom theme, apply saved custom colors
            if (theme === 'custom') {
                const customColor = localStorage.getItem('customColor') || '#7e22ce';
                applyCustomColorToSystem(customColor);
            }
        }

        function updateCustomColor(color) {
            localStorage.setItem('customColor', color);
            applyCustomColorToSystem(color);
            updateColorPreview(color);
            selectTheme('custom');
        }

        function updateColorPreview(color) {
            const preview = document.getElementById('custom-color-preview');
            if (preview) {
                preview.style.background = color;
            }
        }

        function applyCustomColorToSystem(baseColor) {
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

        // Load saved theme on page load
        document.addEventListener('DOMContentLoaded', function() {
            const savedTheme = localStorage.getItem('theme') || 'purple';
            selectTheme(savedTheme);
        });

        // Load saved custom color on page load
        const savedCustomColor = localStorage.getItem('customColor');
        if (savedCustomColor) {
            document.getElementById('custom-color-picker').value = savedCustomColor;
            updateColorPreview(savedCustomColor);
            const currentTheme = localStorage.getItem('theme');
            if (currentTheme === 'custom') {
                applyCustomColorToSystem(savedCustomColor);
            }
        }
    </script>
</x-app-layout>
