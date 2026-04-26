<div id="section-calendario" class="tab-section prof-section">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-lg); flex-wrap: wrap; gap: var(--spacing-md);">
        <h3 style="font-size: 1.125rem; font-weight: 700; color: var(--gray-900); margin: 0;">
            <i class="fas fa-calendar-alt" style="color: var(--gray-400); margin-right: 6px;"></i>Calendario de Recordatorios
        </h3>
        <div class="cal-view-toggle">
            <button type="button" id="btnViewMonth" class="cal-view-btn active" onclick="setCalView('month')">Mes</button>
            <button type="button" id="btnViewWeek" class="cal-view-btn" onclick="setCalView('week')">Semana</button>
        </div>
    </div>

    <div class="calendario-wrapper" style="background: var(--bg-card, white); border: 1px solid var(--border-color, var(--gray-200)); border-radius: var(--radius-lg); overflow: hidden;">
        <div class="calendario-header">
            <button type="button" onclick="calNav(-1)" class="cal-nav-btn">
                <i class="fas fa-chevron-left"></i>
            </button>
            <span id="calLabel" style="font-weight: 700; font-size: 1.0625rem; color: var(--gray-900); text-transform: capitalize;"></span>
            <button type="button" onclick="calNav(1)" class="cal-nav-btn">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>

        <div class="calendario-dias-header">
            <div>Lu</div><div>Ma</div><div>Mi</div><div>Ju</div><div>Vi</div><div>Sa</div><div>Do</div>
        </div>

        <div id="calGrid" class="calendario-grid"></div>
    </div>
</div>

<div id="calModalBackdrop" class="cal-modal-backdrop" onclick="closeCalModal()"></div>
<div id="calModal" class="cal-modal">
    <div class="cal-modal-header">
        <h4 id="calModalTitle" style="font-weight: 700; font-size: 1.0625rem; color: var(--gray-900); margin: 0;"></h4>
        <button type="button" onclick="closeCalModal()" style="background: none; border: none; cursor: pointer; color: var(--gray-400); font-size: 1.25rem; padding: 4px;">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <div id="calModalList" class="cal-modal-list"></div>

    <div id="calAddTriggerContainer" class="cal-trigger-container">
        <button type="button" onclick="toggleAddForm(true)" class="cal-trigger-btn">
            <i class="fas fa-plus"></i> Añadir recordatorio
        </button>
    </div>

    <div class="cal-modal-add" id="calAddFormContainer" style="display: none;">
        <form id="calAddForm" onsubmit="event.preventDefault(); addRecordatorio();">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
                <span style="font-weight: 600; font-size: 0.95rem; color: var(--gray-800);">Nuevo Recordatorio</span>
                <button type="button" onclick="toggleAddForm(false)" style="background: none; border: none; cursor: pointer; color: var(--gray-400); padding: 4px; transition: color 0.2s;" onmouseover="this.style.color='var(--gray-600)'" onmouseout="this.style.color='var(--gray-400)'">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="cal-input-row">
                <div class="cal-input-group flex-1">
                    <i class="fas fa-thumbtack"></i>
                    <input type="text" id="calNewTitle" placeholder="Nuevo recordatorio..." maxlength="255" required autocomplete="off">
                </div>
                <div class="cal-input-group w-auto no-icon">
                    <input type="time" id="calNewTime">
                </div>
            </div>
            <div class="cal-input-row">
                <div class="cal-input-group" style="width: 100%;">
                    <i class="fas fa-align-left" style="top: 14px;"></i>
                    <textarea id="calNewDesc" placeholder="Descripción (opcional)" maxlength="500" autocomplete="off" rows="2" style="width: 100%; resize: vertical; min-height: 42px; font-family: inherit;"></textarea>
                </div>
            </div>
            <div class="cal-input-row" style="justify-content: flex-end; align-items: center;">
                <div class="cal-input-group w-auto">
                    <select id="calNewImp" class="cal-select-imp">
                        <option value="normal">Normal</option>
                        <option value="importante">Importante</option>
                        <option value="urgente">Urgente</option>
                    </select>
                </div>
                <button type="submit" class="cal-add-btn" style="width: auto; padding: 0 20px; gap: 8px;">
                    <i class="fas fa-save"></i> Guardar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
(function(){
    const MONTHS = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
    let currentView = 'month';
    let baseDate = new Date(); // Represents the month/week currently being viewed
    let calData = {};
    let selectedDateStr = null;

    const today = new Date();
    const todayStr = today.getFullYear() + '-' + String(today.getMonth()+1).padStart(2,'0') + '-' + String(today.getDate()).padStart(2,'0');
    const csrf = document.querySelector('meta[name="csrf-token"]').content;

    window.setCalView = function(view) {
        currentView = view;
        document.getElementById('btnViewMonth').classList.toggle('active', view === 'month');
        document.getElementById('btnViewWeek').classList.toggle('active', view === 'week');
        loadData();
    };

    window.calNav = function(dir) {
        if (currentView === 'month') {
            baseDate.setMonth(baseDate.getMonth() + dir);
        } else {
            baseDate.setDate(baseDate.getDate() + (dir * 7));
        }
        loadData();
    };

    function getStartOfWeek(date) {
        const d = new Date(date);
        const day = d.getDay();
        const diff = d.getDate() - day + (day === 0 ? -6 : 1); // adjust when day is sunday
        return new Date(d.setDate(diff));
    }

    function formatDate(d) {
        return d.getFullYear() + '-' + String(d.getMonth()+1).padStart(2,'0') + '-' + String(d.getDate()).padStart(2,'0');
    }

    function loadData() {
        let start, end, label;

        if (currentView === 'month') {
            const year = baseDate.getFullYear();
            const month = baseDate.getMonth();
            start = new Date(year, month, 1);
            end = new Date(year, month + 1, 0);
            label = MONTHS[month] + ' ' + year;
        } else {
            start = getStartOfWeek(baseDate);
            end = new Date(start);
            end.setDate(end.getDate() + 6);
            
            if (start.getMonth() === end.getMonth()) {
                label = start.getDate() + ' - ' + end.getDate() + ' ' + MONTHS[start.getMonth()] + ' ' + start.getFullYear();
            } else {
                label = start.getDate() + ' ' + MONTHS[start.getMonth()].substring(0,3) + ' - ' + 
                        end.getDate() + ' ' + MONTHS[end.getMonth()].substring(0,3) + ' ' + end.getFullYear();
            }
        }

        document.getElementById('calLabel').textContent = label;

        fetch('/recordatorios?start=' + formatDate(start) + '&end=' + formatDate(end), {
            headers: { 'Accept': 'application/json' }
        })
        .then(r => r.json())
        .then(data => {
            calData = data;
            renderGrid(start, end);
        });
    }

    function renderGrid(start, end) {
        const grid = document.getElementById('calGrid');
        grid.innerHTML = '';

        if (currentView === 'month') {
            const year = baseDate.getFullYear();
            const month = baseDate.getMonth();
            const firstDay = new Date(year, month, 1);
            let startDayOffset = firstDay.getDay() - 1;
            if (startDayOffset < 0) startDayOffset = 6;
            
            for (let i = 0; i < startDayOffset; i++) {
                const empty = document.createElement('div');
                empty.className = 'cal-cell cal-cell-empty';
                grid.appendChild(empty);
            }

            const daysInMonth = end.getDate();
            for (let d = 1; d <= daysInMonth; d++) {
                const dateStr = year + '-' + String(month+1).padStart(2,'0') + '-' + String(d).padStart(2,'0');
                renderCell(grid, dateStr, d);
            }
        } else {
            // Week view
            let curr = new Date(start);
            for (let i = 0; i < 7; i++) {
                const dateStr = formatDate(curr);
                renderCell(grid, dateStr, curr.getDate());
                curr.setDate(curr.getDate() + 1);
            }
        }
    }

    function renderCell(grid, dateStr, dayNum) {
        const cell = document.createElement('div');
        cell.className = 'cal-cell';
        if (dateStr === todayStr) cell.classList.add('cal-cell-today');

        const header = document.createElement('div');
        header.className = 'cal-cell-header';

        const num = document.createElement('span');
        num.className = 'cal-cell-num';
        num.textContent = dayNum;
        header.appendChild(num);
        cell.appendChild(header);

        const eventsContainer = document.createElement('div');
        eventsContainer.className = 'cal-cell-events';

        if (calData[dateStr] && calData[dateStr].length > 0) {
            const dayEvents = calData[dateStr];
            let maxEvents = currentView === 'week' ? 5 : 2;
            
            for(let i=0; i < Math.min(dayEvents.length, maxEvents); i++) {
                const r = dayEvents[i];
                let impClass = r.importancia ? ' imp-' + r.importancia : ' imp-normal';
                
                if (currentView === 'week') {
                    const evt = document.createElement('div');
                    evt.className = 'cal-event-card' + impClass + (r.completado ? ' done' : '');
                    
                    let timeHtml = r.hora ? `<div class="evt-time"><i class="far fa-clock"></i> ${r.hora.substring(0,5)}</div>` : '';
                    let titleHtml = `<div class="evt-title">${escapeHtml(r.titulo)}</div>`;
                    let descHtml = r.descripcion ? `<div class="evt-desc">${escapeHtml(r.descripcion)}</div>` : '';
                    
                    evt.innerHTML = timeHtml + titleHtml + descHtml;
                    eventsContainer.appendChild(evt);
                } else {
                    const evt = document.createElement('div');
                    evt.className = 'cal-event-pill' + impClass + (r.completado ? ' done' : '');
                    
                    let timeStr = r.hora ? r.hora.substring(0,5) + ' ' : '';
                    evt.textContent = timeStr + r.titulo;
                    eventsContainer.appendChild(evt);
                }
            }
            
            if(dayEvents.length > maxEvents) {
                const more = document.createElement('div');
                more.className = 'cal-event-more';
                more.textContent = '+' + (dayEvents.length - maxEvents) + ' más';
                eventsContainer.appendChild(more);
            }
        }

        cell.appendChild(eventsContainer);
        cell.addEventListener('click', () => openCalModal(dateStr));
        grid.appendChild(cell);
    }

    function openCalModal(dateStr) {
        selectedDateStr = dateStr;
        const parts = dateStr.split('-');
        document.getElementById('calModalTitle').textContent = parseInt(parts[2]) + ' de ' + MONTHS[parseInt(parts[1])-1] + ' ' + parts[0];
        renderModalList();
        
        toggleAddForm(false); // Reset to show list, hide form
        
        document.getElementById('calModalBackdrop').classList.add('active');
        document.getElementById('calModal').classList.add('active');
    }

    window.toggleAddForm = function(show) {
        document.getElementById('calAddTriggerContainer').style.display = show ? 'none' : 'block';
        document.getElementById('calAddFormContainer').style.display = show ? 'block' : 'none';
        
        if (show) {
            document.getElementById('calNewTitle').value = '';
            document.getElementById('calNewTime').value = '';
            document.getElementById('calNewDesc').value = '';
            document.getElementById('calNewImp').value = 'normal';
            setTimeout(() => document.getElementById('calNewTitle').focus(), 50);
        }
    };

    window.closeCalModal = function() {
        document.getElementById('calModalBackdrop').classList.remove('active');
        document.getElementById('calModal').classList.remove('active');
        selectedDateStr = null;
    }

    function renderModalList() {
        const list = document.getElementById('calModalList');
        const items = calData[selectedDateStr] || [];

        if (items.length === 0) {
            list.innerHTML = '<div style="text-align:center;padding:24px;color:var(--gray-400);font-size:0.9rem;"><i class="fas fa-clipboard-list" style="font-size:1.5rem;display:block;margin-bottom:8px;opacity:0.4;"></i>Sin recordatorios para este día</div>';
            return;
        }

        list.innerHTML = items.map(r => {
            const checked = r.completado ? 'checked' : '';
            const crossed = r.completado ? 'cal-item-done' : '';
            const timeStr = r.hora ? `<span class="cal-item-time"><i class="far fa-clock"></i> ${r.hora.substring(0,5)}</span>` : '';
            const descStr = r.descripcion ? `<div class="cal-item-desc">${escapeHtml(r.descripcion)}</div>` : '';
            
            let impIcon = '';
            let impColor = 'var(--gray-400)';
            if(r.importancia === 'importante') { impIcon = '<i class="fas fa-exclamation-circle"></i>'; impColor = '#f59e0b'; }
            if(r.importancia === 'urgente') { impIcon = '<i class="fas fa-exclamation-triangle"></i>'; impColor = '#ef4444'; }
            
            const impBadge = impIcon ? `<span style="color: ${impColor}; font-size: 0.8rem; margin-left: 6px;" title="${r.importancia}">${impIcon}</span>` : '';
            
            let itemImpClass = '';
            if(r.importancia === 'importante') itemImpClass = ' cal-item-imp';
            if(r.importancia === 'urgente') itemImpClass = ' cal-item-urg';
            
            return '<div class="cal-item ' + crossed + itemImpClass + '">' +
                '<label class="cal-check-label">' +
                    '<input type="checkbox" ' + checked + ' onchange="toggleRecordatorio(' + r.id + ', this)" class="cal-checkbox">' +
                    '<span class="cal-checkmark"></span>' +
                '</label>' +
                '<div style="flex:1; min-width:0; display:flex; flex-direction:column; gap: 4px; padding: 0 12px;">' +
                    '<div style="display:flex; align-items:center;">' +
                        '<span class="cal-item-text">' + escapeHtml(r.titulo) + '</span>' +
                        impBadge +
                    '</div>' +
                    descStr +
                    timeStr +
                '</div>' +
                '<button type="button" onclick="deleteRecordatorio(' + r.id + ')" class="cal-delete-btn" title="Eliminar">' +
                    '<i class="fas fa-trash-alt"></i>' +
                '</button>' +
            '</div>';
        }).join('');
    }

    window.addRecordatorio = function() {
        const inputTitle = document.getElementById('calNewTitle');
        const inputTime = document.getElementById('calNewTime');
        const inputDesc = document.getElementById('calNewDesc');
        const inputImp = document.getElementById('calNewImp');
        
        const titulo = inputTitle.value.trim();
        const hora = inputTime.value;
        const descripcion = inputDesc.value.trim();
        const importancia = inputImp.value;
        
        if (!titulo || !selectedDateStr) return;

        inputTitle.disabled = true;
        inputTime.disabled = true;
        inputDesc.disabled = true;
        inputImp.disabled = true;
        
        fetch('/recordatorios', {
            method: 'POST',
            headers: { 'Content-Type':'application/json', 'Accept':'application/json', 'X-CSRF-TOKEN': csrf },
            body: JSON.stringify({ 
                titulo: titulo, 
                fecha: selectedDateStr, 
                hora: hora || null,
                descripcion: descripcion || null,
                importancia: importancia
            })
        })
        .then(r => r.json())
        .then(rec => {
            if (!calData[selectedDateStr]) calData[selectedDateStr] = [];
            calData[selectedDateStr].push(rec);
            
            // Sort items by time (nulls last or first, let's say nulls first then by time)
            calData[selectedDateStr].sort((a,b) => {
                if(!a.hora && !b.hora) return 0;
                if(!a.hora) return -1;
                if(!b.hora) return 1;
                return a.hora.localeCompare(b.hora);
            });
            
            renderModalList();
            loadData(); // Reload to update dots
            
            toggleAddForm(false); // Hide form after adding
            
            inputTitle.disabled = false;
            inputTime.disabled = false;
            inputDesc.disabled = false;
            inputImp.disabled = false;
        })
        .catch(() => { 
            inputTitle.disabled = false; 
            inputTime.disabled = false; 
            inputDesc.disabled = false;
            inputImp.disabled = false;
        });
    };

    window.toggleRecordatorio = function(id, checkbox) {
        fetch('/recordatorios/' + id + '/toggle', {
            method: 'PATCH',
            headers: { 'Accept':'application/json', 'X-CSRF-TOKEN': csrf }
        })
        .then(r => r.json())
        .then(updated => {
            if (calData[selectedDateStr]) {
                const idx = calData[selectedDateStr].findIndex(r => r.id === id);
                if (idx !== -1) calData[selectedDateStr][idx].completado = updated.completado;
            }
            renderModalList();
            loadData(); // To update dots color if all completed
        });
    };

    window.deleteRecordatorio = function(id) {
        fetch('/recordatorios/' + id, {
            method: 'DELETE',
            headers: { 'Accept':'application/json', 'X-CSRF-TOKEN': csrf }
        })
        .then(() => {
            if (calData[selectedDateStr]) {
                calData[selectedDateStr] = calData[selectedDateStr].filter(r => r.id !== id);
            }
            renderModalList();
            loadData(); // To update dots
        });
    };

    function escapeHtml(str) {
        const div = document.createElement('div');
        div.textContent = str;
        return div.innerHTML;
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && selectedDateStr) closeCalModal();
    });

    document.addEventListener('DOMContentLoaded', function() {
        loadData();
    });

    if (document.readyState !== 'loading') {
        loadData();
    }
})();
</script>
