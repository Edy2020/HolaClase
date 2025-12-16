<x-app-layout>
    <x-slot name="header">
        Configuración
    </x-slot>

    <div style="min-height: calc(100vh - 200px);">
        <!-- Hero Header -->
        <div style="background: var(--theme-dark); color: white; padding: var(--spacing-2xl); border-radius: var(--radius-xl); margin-bottom: var(--spacing-2xl); box-shadow: var(--shadow-lg);">
            <h2 style="color: white; font-size: 1.75rem; font-weight: 700; margin-bottom: var(--spacing-sm);">
                <i class="fas fa-cog"></i> Configuración
            </h2>
            <p style="font-size: 1rem; opacity: 0.95; margin: 0;">
                Personaliza la apariencia y comportamiento de HolaClase
            </p>
        </div>

        <!-- Theme Selection -->
    <div class="card mb-xl">
        <div class="card-body">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-md);">
                    <div>
                        <h3 style="font-size: 1.125rem; font-weight: 700; color: var(--gray-900); margin: 0; display: flex; align-items: center; gap: var(--spacing-sm);">
                            <i class="fas fa-palette"></i>
                            Tema
                        </h3>
                    </div>
                    
                    <!-- Dark Mode Toggle -->
                    <div style="display: flex; align-items: center; gap: var(--spacing-sm);">
                        <i class="fas fa-moon" style="color: var(--gray-600); font-size: 0.875rem;"></i>
                        <label class="dark-mode-switch">
                            <input type="checkbox" id="dark-mode-toggle">
                            <span class="slider"></span>
                        </label>
                    </div>
                </div>

                <p style="font-size: 0.9375rem; color: var(--gray-600); margin-bottom: var(--spacing-lg);">
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
                                <button type="button" onclick="openCustomColorPicker(event)" style="display: inline-block; padding: var(--spacing-xs) var(--spacing-md); background: var(--gray-100); border: 1px solid var(--gray-300); border-radius: var(--radius-md); color: var(--gray-700); font-size: 0.875rem; font-weight: 500; cursor: pointer; transition: all var(--transition-fast);" onmouseover="this.style.background='var(--gray-200)'" onmouseout="this.style.background='var(--gray-100)'">
                                    <i class="fas fa-palette"></i> Seleccionar Color
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Custom Color Picker Modal -->
                <div id="custom-color-picker-modal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: transparent; z-index: 1000; align-items: center; justify-content: center; pointer-events: none;">
                    <div onclick="event.stopPropagation()" style="background: white; border-radius: var(--radius-lg); padding: var(--spacing-lg); max-width: 380px; width: 90%; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04), 0 0 0 1px rgba(0, 0, 0, 0.05); pointer-events: auto; border: 1px solid var(--gray-200);">
                        <!-- Header -->
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-md);">
                            <h3 style="margin: 0; font-weight: 700; color: var(--gray-900); font-size: 1.125rem;">Elige tu Color</h3>
                            <button onclick="closeCustomColorPicker()" style="width: 28px; height: 28px; border-radius: 50%; background: transparent; border: none; color: var(--gray-600); cursor: pointer; display: flex; align-items: center; justify-content: center; transition: background var(--transition-fast);" onmouseover="this.style.background='var(--gray-100)'" onmouseout="this.style.background='transparent'">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>

                        <!-- Color Preview -->
                        <div style="margin-bottom: var(--spacing-md);">
                            <div id="color-preview-box" style="width: 100%; height: 50px; border-radius: var(--radius-md); background: #7e22ce; box-shadow: var(--shadow-sm); border: 1px solid var(--gray-200);"></div>
                        </div>

                        <!-- Saturation/Lightness Box -->
                        <div style="margin-bottom: var(--spacing-md);">
                            <div id="saturation-lightness-box" style="position: relative; width: 100%; height: 160px; border-radius: var(--radius-md); background: linear-gradient(to right, white, hsl(270, 100%, 50%)); cursor: crosshair; border: 1px solid var(--gray-200);">
                                <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(to bottom, transparent, black); border-radius: var(--radius-md);"></div>
                                <div id="sl-selector" style="position: absolute; width: 14px; height: 14px; border: 2px solid white; border-radius: 50%; box-shadow: 0 0 0 1px rgba(0,0,0,0.3), 0 2px 4px rgba(0,0,0,0.2); transform: translate(-50%, -50%); pointer-events: none; left: 50%; top: 50%;"></div>
                            </div>
                        </div>

                        <!-- Hue Slider -->
                        <div style="margin-bottom: var(--spacing-md);">
                            <input type="range" id="hue-slider" min="0" max="360" value="270" style="width: 100%; height: 16px; border-radius: var(--radius-md); background: linear-gradient(to right, #ff0000, #ffff00, #00ff00, #00ffff, #0000ff, #ff00ff, #ff0000); -webkit-appearance: none; appearance: none; cursor: pointer;">
                        </div>

                        <!-- Hex Input -->
                        <div style="margin-bottom: var(--spacing-md);">
                            <label style="display: block; font-size: 0.8125rem; font-weight: 500; color: var(--gray-700); margin-bottom: var(--spacing-xs);">Código Hexadecimal</label>
                            <input type="text" id="hex-input" value="#7e22ce" maxlength="7" style="width: 100%; padding: var(--spacing-xs) var(--spacing-sm); border: 1px solid var(--gray-300); border-radius: var(--radius-md); font-family: monospace; font-size: 0.875rem;">
                        </div>

                        <!-- Preset Colors -->
                        <div style="margin-bottom: var(--spacing-md);">
                            <label style="display: block; font-size: 0.8125rem; font-weight: 500; color: var(--gray-700); margin-bottom: var(--spacing-xs);">Colores Sugeridos</label>
                            <div id="preset-colors" style="display: grid; grid-template-columns: repeat(8, 1fr); gap: var(--spacing-xs);">
                                <!-- Preset colors will be added via JavaScript -->
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div style="display: flex; gap: var(--spacing-sm);">
                            <button onclick="closeCustomColorPicker()" class="btn btn-secondary" style="flex: 1; padding: var(--spacing-xs) var(--spacing-sm); font-size: 0.875rem;">
                                Cancelar
                            </button>
                            <button onclick="applyCustomColorFromPicker()" class="btn btn-primary" style="flex: 1; padding: var(--spacing-xs) var(--spacing-sm); font-size: 0.875rem;">
                                <i class="fas fa-check"></i> Aplicar
                            </button>
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
    </div>

    <link rel="stylesheet" href="{{ asset('css/configuracion.css') }}">

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

        // Custom Color Picker State
        let pickerState = {
            hue: 270,
            saturation: 100,
            lightness: 39,
            tempColor: '#7e22ce'
        };

        const presetColors = [
            '#7e22ce', '#52525b', '#0284c7', '#059669', '#dc2626', '#ea580c',
            '#ca8a04', '#65a30d', '#0891b2', '#7c3aed', '#db2777', '#e11d48',
            '#f97316', '#eab308', '#84cc16', '#10b981'
        ];

        function openCustomColorPicker(event) {
            event.stopPropagation();
            const modal = document.getElementById('custom-color-picker-modal');
            modal.style.display = 'flex';
            
            // Load current color
            const currentColor = localStorage.getItem('customColor') || '#7e22ce';
            pickerState.tempColor = currentColor;
            
            // Convert hex to HSL and update picker
            const hsl = hexToHSL(currentColor);
            pickerState.hue = hsl.h;
            pickerState.saturation = hsl.s;
            pickerState.lightness = hsl.l;
            
            updatePickerUI();
            initializePresetColors();
        }

        function closeCustomColorPicker() {
            const modal = document.getElementById('custom-color-picker-modal');
            modal.style.display = 'none';
        }

        function applyCustomColorFromPicker() {
            const color = pickerState.tempColor;
            localStorage.setItem('customColor', color);
            applyCustomColorToSystem(color);
            updateColorPreview(color);
            selectTheme('custom');
            closeCustomColorPicker();
        }

        function updatePickerUI() {
            const color = hslToHex(pickerState.hue, pickerState.saturation, pickerState.lightness);
            pickerState.tempColor = color;
            
            // Update preview
            document.getElementById('color-preview-box').style.background = color;
            
            // Update hex input
            document.getElementById('hex-input').value = color;
            
            // Update hue slider
            document.getElementById('hue-slider').value = pickerState.hue;
            
            // Update saturation/lightness box background
            const slBox = document.getElementById('saturation-lightness-box');
            slBox.style.background = `linear-gradient(to right, white, hsl(${pickerState.hue}, 100%, 50%))`;
            
            // Update selector position
            const selector = document.getElementById('sl-selector');
            selector.style.left = `${pickerState.saturation}%`;
            selector.style.top = `${100 - pickerState.lightness}%`;
        }

        function initializePresetColors() {
            const container = document.getElementById('preset-colors');
            container.innerHTML = '';
            
            presetColors.forEach(color => {
                const colorBox = document.createElement('div');
                colorBox.style.cssText = `
                    width: 100%;
                    padding-bottom: 100%;
                    background: ${color};
                    border-radius: var(--radius-md);
                    cursor: pointer;
                    border: 2px solid var(--gray-200);
                    transition: all var(--transition-fast);
                `;
                colorBox.onmouseover = () => colorBox.style.transform = 'scale(1.1)';
                colorBox.onmouseout = () => colorBox.style.transform = 'scale(1)';
                colorBox.onclick = () => selectPresetColor(color);
                container.appendChild(colorBox);
            });
        }

        function selectPresetColor(color) {
            const hsl = hexToHSL(color);
            pickerState.hue = hsl.h;
            pickerState.saturation = hsl.s;
            pickerState.lightness = hsl.l;
            updatePickerUI();
        }

        // Event Listeners
        document.addEventListener('DOMContentLoaded', function() {
            // Hue slider
            const hueSlider = document.getElementById('hue-slider');
            if (hueSlider) {
                hueSlider.addEventListener('input', function(e) {
                    pickerState.hue = parseInt(e.target.value);
                    updatePickerUI();
                });
            }
            
            // Saturation/Lightness box
            const slBox = document.getElementById('saturation-lightness-box');
            if (slBox) {
                slBox.addEventListener('click', function(e) {
                    const rect = this.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    
                    pickerState.saturation = Math.round((x / rect.width) * 100);
                    pickerState.lightness = Math.round(100 - (y / rect.height) * 100);
                    
                    updatePickerUI();
                });
            }
            
            // Hex input
            const hexInput = document.getElementById('hex-input');
            if (hexInput) {
                hexInput.addEventListener('input', function(e) {
                    let value = e.target.value;
                    if (!value.startsWith('#')) {
                        value = '#' + value;
                    }
                    
                    if (/^#[0-9A-Fa-f]{6}$/.test(value)) {
                        const hsl = hexToHSL(value);
                        pickerState.hue = hsl.h;
                        pickerState.saturation = hsl.s;
                        pickerState.lightness = hsl.l;
                        updatePickerUI();
                    }
                });
            }
            
            // Close modal on outside click
            const modal = document.getElementById('custom-color-picker-modal');
            if (modal) {
                modal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeCustomColorPicker();
                    }
                });
            }
        });

        // Color Conversion Functions
        function hslToHex(h, s, l) {
            s /= 100;
            l /= 100;
            
            const c = (1 - Math.abs(2 * l - 1)) * s;
            const x = c * (1 - Math.abs((h / 60) % 2 - 1));
            const m = l - c / 2;
            
            let r = 0, g = 0, b = 0;
            
            if (0 <= h && h < 60) {
                r = c; g = x; b = 0;
            } else if (60 <= h && h < 120) {
                r = x; g = c; b = 0;
            } else if (120 <= h && h < 180) {
                r = 0; g = c; b = x;
            } else if (180 <= h && h < 240) {
                r = 0; g = x; b = c;
            } else if (240 <= h && h < 300) {
                r = x; g = 0; b = c;
            } else if (300 <= h && h < 360) {
                r = c; g = 0; b = x;
            }
            
            r = Math.round((r + m) * 255);
            g = Math.round((g + m) * 255);
            b = Math.round((b + m) * 255);
            
            return '#' + [r, g, b].map(x => {
                const hex = x.toString(16);
                return hex.length === 1 ? '0' + hex : hex;
            }).join('');
        }

        function hexToHSL(hex) {
            const r = parseInt(hex.slice(1, 3), 16) / 255;
            const g = parseInt(hex.slice(3, 5), 16) / 255;
            const b = parseInt(hex.slice(5, 7), 16) / 255;
            
            const max = Math.max(r, g, b);
            const min = Math.min(r, g, b);
            let h, s, l = (max + min) / 2;
            
            if (max === min) {
                h = s = 0;
            } else {
                const d = max - min;
                s = l > 0.5 ? d / (2 - max - min) : d / (max + min);
                
                switch (max) {
                    case r: h = ((g - b) / d + (g < b ? 6 : 0)) / 6; break;
                    case g: h = ((b - r) / d + 2) / 6; break;
                    case b: h = ((r - g) / d + 4) / 6; break;
                }
            }
            
            return {
                h: Math.round(h * 360),
                s: Math.round(s * 100),
                l: Math.round(l * 100)
            };
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
            
            // Load saved custom color
            const savedCustomColor = localStorage.getItem('customColor');
            if (savedCustomColor) {
                updateColorPreview(savedCustomColor);
                const currentTheme = localStorage.getItem('theme');
                if (currentTheme === 'custom') {
                    applyCustomColorToSystem(savedCustomColor);
                }
            }

            // Load dark mode state
            const darkModeToggle = document.getElementById('dark-mode-toggle');
            const isDarkMode = localStorage.getItem('darkMode') === 'true';
            if (darkModeToggle) {
                darkModeToggle.checked = isDarkMode;
                if (isDarkMode) {
                    document.documentElement.classList.add('dark-mode');
                }
            }
        });

        // Dark mode toggle handler
        document.addEventListener('DOMContentLoaded', function() {
            const darkModeToggle = document.getElementById('dark-mode-toggle');
            if (darkModeToggle) {
                darkModeToggle.addEventListener('change', function() {
                    const isDarkMode = this.checked;
                    localStorage.setItem('darkMode', isDarkMode);
                    
                    if (isDarkMode) {
                        document.documentElement.classList.add('dark-mode');
                    } else {
                        document.documentElement.classList.remove('dark-mode');
                    }
                });
            }
        });
    </script>
</x-app-layout>
