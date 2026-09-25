(function () {
    'use strict';

    const STORAGE_PREFIX = 'oz_form_';
    const HISTORY_KEY = 'oz_navigation_history_v2';
    const ENTRY_KEY = 'ozEntryId';
    const IGNORE_TYPES = new Set(['password', 'file', 'submit', 'button', 'reset', 'image', 'hidden']);

    function getHistory() {
        try {
            return JSON.parse(sessionStorage.getItem(HISTORY_KEY)) || { entries: [], index: -1 };
        } catch (e) {
            return { entries: [], index: -1 };
        }
    }

    function saveHistory(data) {
        try {
            sessionStorage.setItem(HISTORY_KEY, JSON.stringify(data));
        } catch (e) {}
    }

    function newId() {
        return Date.now().toString(36) + Math.random().toString(36).slice(2, 9);
    }

    function currentEntryId() {
        return history.state && history.state[ENTRY_KEY];
    }

    function registerHistoryEntry() {
        const existingId = currentEntryId();
        let data = getHistory();

        if (existingId) {
            const existingIndex = data.entries.findIndex(entry => entry.id === existingId);
            if (existingIndex !== -1) {
                data.index = existingIndex;
                saveHistory(data);
                return;
            }
        }

        const id = newId();
        try {
            history.replaceState({ ...(history.state || {}), [ENTRY_KEY]: id }, '', location.href);
        } catch (e) {}

        const entry = {
            id,
            url: location.href,
            title: document.title || ''
        };

        if (data.index < data.entries.length - 1) {
            data.entries = data.entries.slice(0, data.index + 1);
        }

        data.entries.push(entry);
        data.index = data.entries.length - 1;
        saveHistory(data);
    }

    function updateHistoryPosition() {
        const id = currentEntryId();
        if (!id) {
            registerHistoryEntry();
            return;
        }

        const data = getHistory();
        const index = data.entries.findIndex(entry => entry.id === id);
        if (index !== -1) {
            data.index = index;
            saveHistory(data);
        } else {
            registerHistoryEntry();
        }
    }

    function keyFor(form, index) {
        const identity = [location.pathname, location.search, form.id || '', form.name || '', form.getAttribute('action') || '', index].join('|');
        return STORAGE_PREFIX + encodeURIComponent(identity).replace(/%/g, '_');
    }

    function fieldKey(field, index) {
        return field.name || field.id || field.getAttribute('data-oz-field') || ('field_' + index);
    }

    function saveForm(form, index) {
        const data = {};
        Array.from(form.elements).forEach((field, i) => {
            if (!field || field.disabled) return;
            const type = (field.type || '').toLowerCase();
            if (IGNORE_TYPES.has(type)) return;
            const key = fieldKey(field, i);

            if (type === 'radio') {
                if (field.checked) data[key] = { type: 'radio', value: field.value };
                return;
            }

            if (type === 'checkbox') {
                data[key] = { type: 'checkbox', checked: field.checked };
                return;
            }

            data[key] = { type: 'value', value: field.value };
        });

        try {
            sessionStorage.setItem(keyFor(form, index), JSON.stringify(data));
        } catch (e) {}
    }

    function restoreForm(form, index) {
        let raw;
        try {
            raw = sessionStorage.getItem(keyFor(form, index));
        } catch (e) {
            return;
        }

        if (!raw) return;

        let data;
        try {
            data = JSON.parse(raw);
        } catch (e) {
            return;
        }

        Array.from(form.elements).forEach((field, i) => {
            if (!field || field.disabled) return;
            const type = (field.type || '').toLowerCase();
            if (IGNORE_TYPES.has(type)) return;

            const saved = data[fieldKey(field, i)];
            if (!saved) return;

            if (type === 'radio') field.checked = saved.value === field.value;
            else if (type === 'checkbox') field.checked = !!saved.checked;
            else field.value = saved.value ?? '';
        });
    }

    function clearForm(form, index) {
        try {
            sessionStorage.removeItem(keyFor(form, index));
        } catch (e) {}
    }

    function protectForms() {
        Array.from(document.forms).forEach((form, index) => {
            restoreForm(form, index);

            const save = () => saveForm(form, index);
            form.addEventListener('input', save);
            form.addEventListener('change', save);
            form.addEventListener('submit', () => setTimeout(() => clearForm(form, index), 250));
        });
    }

    function positionPanel() {
        const panel = document.getElementById('oz-historial');
        if (!panel) return;

        const nav = document.getElementById('barra');
        if (nav) {
            const rect = nav.getBoundingClientRect();
            const gap = window.innerWidth <= 760 ? 8 : 10;
            const top = Math.max(92, Math.round(rect.bottom + gap));
            panel.style.top = top + 'px';
        } else {
            panel.style.top = window.innerWidth <= 760 ? '86px' : '96px';
        }
    }

    function createButtons() {
        let panel = document.getElementById('oz-historial');
        if (!panel) {
            panel = document.createElement('nav');
            panel.id = 'oz-historial';
            panel.setAttribute('aria-label', 'Navegación de Organic Zone');
            panel.innerHTML = `
                <button type="button" class="oz-historial-btn" id="oz-atras" aria-label="Ir atrás" title="Atrás">
                    <span class="oz-triangulo izquierda" aria-hidden="true"></span>
                </button>
                <button type="button" class="oz-historial-btn" id="oz-adelante" aria-label="Ir adelante" title="Adelante">
                    <span class="oz-triangulo derecha" aria-hidden="true"></span>
                </button>
            `;
            document.body.appendChild(panel);

            panel.querySelector('#oz-atras').addEventListener('click', () => history.back());
            panel.querySelector('#oz-adelante').addEventListener('click', () => history.forward());
        }

        const back = panel.querySelector('#oz-atras');
        const forward = panel.querySelector('#oz-adelante');
        const data = getHistory();

        const canBack = data.index > 0;
        const canForward = data.index >= 0 && data.index < data.entries.length - 1;

        back.hidden = !canBack;
        forward.hidden = !canForward;
        panel.hidden = !canBack && !canForward;
        positionPanel();
    }

    window.addEventListener('resize', positionPanel);

    function init() {
        registerHistoryEntry();
        createButtons();
        protectForms();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init, { once: true });
    } else {
        init();
    }

    window.addEventListener('pageshow', () => {
        updateHistoryPosition();
        createButtons();
        protectForms();
    });

    window.addEventListener('popstate', () => {
        updateHistoryPosition();
        createButtons();
    });
})();
