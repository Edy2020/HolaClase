<x-app-layout>
    <x-slot name="header">
        Escala de Notas
    </x-slot>

    <div class="page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-lg);">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--gray-900); margin: 0;">
                Calculadora de Escala de Notas
            </h2>
            <p style="color: var(--gray-500); margin: var(--spacing-xs) 0 0 0; font-size: 0.9375rem;">
                Genera al instante la tabla de calificaciones según el puntaje máximo y exigencia.
            </p>
        </div>
        <div class="header-actions" style="display: flex; gap: var(--spacing-md);">
            <a href="{{ route('grades.index') }}" class="btn btn-outline"
                style="display: flex; align-items: center; gap: var(--spacing-sm); border: 1px solid var(--gray-300); color: var(--gray-700); padding: 0.625rem 1.25rem; border-radius: var(--radius-md); font-weight: 600; text-decoration: none; transition: all 0.2s;">
                <i class="fas fa-arrow-left"></i> Volver a Notas
            </a>
            <button onclick="window.print()" class="btn btn-primary"
                style="display: flex; align-items: center; gap: var(--spacing-sm); background: var(--primary); color: white; padding: 0.625rem 1.25rem; border: none; border-radius: var(--radius-md); font-weight: 600; cursor: pointer;">
                <i class="fas fa-print"></i> Imprimir Escala
            </button>
        </div>
    </div>

    <link rel="stylesheet" href="{{ asset('css/escala.css') }}?v={{ time() }}">

    <div class="escala-layout">
        
        <!-- Controls Panel -->
        <div class="card" style="align-self: start;">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-sliders-h"></i> Parámetros</h3>
            </div>
            <div class="card-body escala-controls">
                <form id="scaleForm" onsubmit="event.preventDefault(); triggerCalculation();">
                    <div class="form-group">
                        <label class="form-label" for="puntaje_maximo">Puntaje Máximo</label>
                        <input type="number" id="puntaje_maximo" class="form-control" value="100" min="1" step="1" required oninput="triggerCalculation()">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="exigencia">Exigencia (%)</label>
                        <select id="exigencia" class="form-select" onchange="triggerCalculation()">
                            <option value="50">50%</option>
                            <option value="60" selected>60%</option>
                            <option value="70">70%</option>
                        </select>
                    </div>

                    <hr style="margin: var(--spacing-lg) 0; border: none; border-top: 1px solid var(--gray-200);">
                    
                    <div class="form-group">
                        <label class="form-label" for="nota_aprobacion">Nota de Aprobación</label>
                        <input type="number" id="nota_aprobacion" class="form-control" value="4.0" step="0.1" oninput="triggerCalculation()">
                    </div>

                    <div class="inputs-row">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" for="nota_minima">Nota Mín.</label>
                            <input type="number" id="nota_minima" class="form-control" value="1.0" step="0.1" oninput="triggerCalculation()">
                        </div>
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" for="nota_maxima">Nota Máx.</label>
                            <input type="number" id="nota_maxima" class="form-control" value="7.0" step="0.1" oninput="triggerCalculation()">
                        </div>
                    </div>
                </form>

                <div style="margin-top: var(--spacing-xl); padding: var(--spacing-md); background: var(--gray-50); border-radius: var(--radius-md); border: 1px solid var(--gray-200); text-align: center;">
                    <div style="font-size: 0.85rem; text-transform: uppercase; font-weight: 700; color: var(--gray-500); margin-bottom: 8px;">Puntaje para Aprobar</div>
                    <div id="puntaje_corte" style="font-size: 2.5rem; font-weight: 800; color: var(--primary); line-height: 1;">60</div>
                </div>
            </div>
        </div>

        <!-- Scale Results Table -->
        <div class="card">
            <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                <h3 class="card-title"><i class="fas fa-table"></i> Resultados</h3>
            </div>
            <div class="card-body" style="padding: var(--spacing-md); background: var(--gray-50);">
                <div id="scale_tables_container" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: var(--spacing-md); align-items: start;">
                    <!-- Filled by JS -->
                </div>
            </div>
        </div>

    </div>

    <!-- Script that reacts and calculates -->
    <script>
        function calculateGrades() {
            const pMax = parseFloat(document.getElementById('puntaje_maximo').value) || 100;
            const exigencia = parseFloat(document.getElementById('exigencia').value) / 100 || 0.6;
            const nMin = parseFloat(document.getElementById('nota_minima').value) || 1.0;
            const nMax = parseFloat(document.getElementById('nota_maxima').value) || 7.0;
            const nAprob = parseFloat(document.getElementById('nota_aprobacion').value) || 4.0;

            const pAprob = pMax * exigencia;
            document.getElementById('puntaje_corte').innerText = Math.round(pAprob);

            const container = document.getElementById('scale_tables_container');
            container.innerHTML = '';

            let itemsTotal = pMax + 1;
            let columnsCount = 3;
            
            // Adjust grid layout dynamically for mobile via inline style adjustment
            if (window.innerWidth <= 768) {
                columnsCount = 2;
                container.style.gridTemplateColumns = 'repeat(2, 1fr)';
            }
            if (window.innerWidth <= 480) {
                columnsCount = 1;
                container.style.gridTemplateColumns = '1fr';
            } else if (window.innerWidth > 768) {
                container.style.gridTemplateColumns = 'repeat(3, 1fr)';
            }
            
            let rowsPerCol = Math.ceil(itemsTotal / columnsCount);

            let allRows = [];
            for (let p = 0; p <= pMax; p++) {
                let nota = 0;
                if (p < pAprob) nota = nMin + (nAprob - nMin) * (p / pAprob);
                else nota = nAprob + (nMax - nAprob) * ((p - pAprob) / (pMax - pAprob));

                let notaStr = (Math.round(nota * 10) / 10).toFixed(1);
                let isAprob = parseFloat(notaStr) >= nAprob;
                let colorBase = isAprob ? '#3b82f6' : '#ef4444'; 
                let bgRow = (p === Math.round(pAprob)) ? 'background: #eff6ff;' : (p % 2 === 0 ? 'background: white;' : 'background: #fdfdfd;');

                allRows.push(`
                    <tr style="${bgRow}">
                        <td style="text-align: center; font-size: 0.95rem; color: var(--gray-700); border-right: 1px solid var(--gray-200);">
                            ${p}
                        </td>
                        <td style="text-align: center; font-weight: 800; font-size: 1.05rem; color: ${colorBase};">
                            ${notaStr}
                        </td>
                    </tr>
                `);
            }

            for(let c = 0; c < columnsCount; c++) {
                let startPos = c * rowsPerCol;
                let endPos = startPos + rowsPerCol;
                let colRows = allRows.slice(startPos, endPos).join('');

                if(colRows.length > 0) {
                    container.innerHTML += `
                        <div class="scale-table-wrap">
                            <table>
                                <thead>
                                    <tr>
                                        <th style="width: 50%; border-right: 1px solid var(--gray-200); text-align: center;">Pts</th>
                                        <th style="width: 50%; text-align: center;">Nota</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${colRows}
                                </tbody>
                            </table>
                        </div>
                    `;
                }
            }
        }

        let timeout = null;
        function triggerCalculation() {
            if(timeout) clearTimeout(timeout);
            timeout = setTimeout(() => {
                calculateGrades();
            }, 50); // slight debounce for smooth dragging on inputs
        }

        // Init on page load
        document.addEventListener('DOMContentLoaded', calculateGrades);
    </script>
    


</x-app-layout>
