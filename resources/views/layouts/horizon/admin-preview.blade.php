{{-- Admin click-to-edit preview mode (?admin_preview=1) --}}
<style>
    body.admin-preview-mode [data-admin-section] {
        position: relative;
        cursor: pointer !important;
        transition: box-shadow 0.15s ease, outline-color 0.15s ease;
        outline: 2px solid transparent;
        outline-offset: -2px;
    }
    body.admin-preview-mode [data-admin-section]::after {
        content: attr(data-admin-label);
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 9999;
        background: rgba(15, 23, 42, 0.9);
        color: #fff;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        padding: 6px 10px;
        border-radius: 8px;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.15s ease;
    }
    body.admin-preview-mode [data-admin-section]:hover {
        outline-color: rgba(234, 88, 12, 0.7);
        box-shadow: inset 0 0 0 9999px rgba(234, 88, 12, 0.07);
    }
    body.admin-preview-mode [data-admin-section]:hover::after,
    body.admin-preview-mode [data-admin-section].is-admin-focused::after {
        opacity: 1;
    }
    body.admin-preview-mode [data-admin-section].is-admin-focused {
        outline-color: #ea580c;
        box-shadow: inset 0 0 0 9999px rgba(234, 88, 12, 0.1);
    }
    body.admin-preview-mode [data-admin-section].is-admin-focused::after {
        background: #ea580c;
    }
    body.admin-preview-mode a,
    body.admin-preview-mode button {
        pointer-events: none !important;
    }
</style>
<script>
(function () {
    // Always mark preview mode when this script loads
    document.body.classList.add('admin-preview-mode');

    function post(type, extra) {
        if (window.parent === window) return;
        window.parent.postMessage(Object.assign({
            source: 'admin-home-preview',
            type: type,
        }, extra || {}), '*');
    }

    function focusSection(key) {
        document.querySelectorAll('[data-admin-section]').forEach(function (el) {
            el.classList.remove('is-admin-focused');
        });
        var target = document.querySelector('[data-admin-section="' + key + '"]');
        if (!target) return;
        target.classList.add('is-admin-focused');
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    function applyFieldUpdate(section, field, value) {
        var root = document.querySelector('[data-admin-section="' + section + '"]');
        if (!root) return;
        root.querySelectorAll('[data-preview-field="' + field + '"]').forEach(function (el) {
            if (el.tagName === 'IMG') {
                if (value) el.setAttribute('src', value);
                return;
            }
            if (el.getAttribute('data-preview-html') === '1') {
                el.innerHTML = value || '';
            } else {
                el.textContent = value || '';
            }
            if (el.style && el.style.display === 'none') {
                el.style.display = value ? '' : 'none';
            }
        });
    }

    // Capture-phase clicks so nested links/buttons cannot swallow the event
    document.addEventListener('click', function (event) {
        var el = event.target && event.target.closest
            ? event.target.closest('[data-admin-section]')
            : null;
        if (!el) return;
        event.preventDefault();
        event.stopPropagation();
        var section = el.getAttribute('data-admin-section');
        if (!section) return;
        focusSection(section);
        post('section-click', { section: section });
    }, true);

    window.addEventListener('message', function (event) {
        var data = event.data || {};
        if (data.source !== 'admin-home-preview-parent') return;
        if (data.type === 'focus-section' && data.section) focusSection(data.section);
        if (data.type === 'update-field' && data.section && data.field) {
            applyFieldUpdate(data.section, data.field, data.value);
        }
        if (data.type === 'ping') post('ready');
    });

    post('ready');
})();
</script>
