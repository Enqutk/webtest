{{-- Admin click-to-edit preview mode (loaded only when ?admin_preview=1 and user is authenticated) --}}
<style>
    body.admin-preview-mode {
        cursor: default;
    }
    body.admin-preview-mode [data-admin-section] {
        position: relative;
        cursor: pointer;
        transition: box-shadow 0.2s ease, outline-color 0.2s ease;
        outline: 2px solid transparent;
        outline-offset: -2px;
    }
    body.admin-preview-mode [data-admin-section]::after {
        content: attr(data-admin-label);
        position: absolute;
        top: 12px;
        right: 12px;
        z-index: 50;
        background: rgba(15, 23, 42, 0.88);
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
        outline-color: rgba(234, 88, 12, 0.55);
        box-shadow: inset 0 0 0 9999px rgba(234, 88, 12, 0.06);
    }
    body.admin-preview-mode [data-admin-section]:hover::after {
        opacity: 1;
    }
    body.admin-preview-mode [data-admin-section].is-admin-focused {
        outline-color: #ea580c;
        box-shadow: inset 0 0 0 9999px rgba(234, 88, 12, 0.08);
    }
    body.admin-preview-mode [data-admin-section].is-admin-focused::after {
        opacity: 1;
        background: #ea580c;
    }
    body.admin-preview-mode a,
    body.admin-preview-mode button {
        pointer-events: none;
    }
</style>
<script>
(function () {
    if (window.parent === window) return;

    document.body.classList.add('admin-preview-mode');

    const sections = () => Array.from(document.querySelectorAll('[data-admin-section]'));

    function focusSection(key) {
        sections().forEach((el) => el.classList.remove('is-admin-focused'));
        const target = document.querySelector('[data-admin-section="' + key + '"]');
        if (!target) return;
        target.classList.add('is-admin-focused');
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    function applyFieldUpdate(section, field, value) {
        const root = document.querySelector('[data-admin-section="' + section + '"]');
        if (!root) return;
        root.querySelectorAll('[data-preview-field="' + field + '"]').forEach((el) => {
            if (el.tagName === 'IMG') {
                if (value) el.setAttribute('src', value);
                return;
            }
            if (el.dataset.previewHtml === '1') {
                el.innerHTML = value || '';
            } else {
                el.textContent = value || '';
            }
            if (el.hasAttribute('style') && el.style.display === 'none') {
                el.style.display = value ? '' : 'none';
            }
        });
    }

    sections().forEach((el) => {
        el.addEventListener('click', (event) => {
            event.preventDefault();
            event.stopPropagation();
            const section = el.getAttribute('data-admin-section');
            if (!section) return;
            focusSection(section);
            window.parent.postMessage({
                source: 'admin-home-preview',
                type: 'section-click',
                section: section,
            }, '*');
        });
    });

    window.addEventListener('message', (event) => {
        const data = event.data || {};
        if (data.source !== 'admin-home-preview-parent') return;

        if (data.type === 'focus-section' && data.section) {
            focusSection(data.section);
        }

        if (data.type === 'update-field' && data.section && data.field) {
            applyFieldUpdate(data.section, data.field, data.value);
        }

        if (data.type === 'ping') {
            window.parent.postMessage({
                source: 'admin-home-preview',
                type: 'ready',
            }, '*');
        }
    });

    window.parent.postMessage({
        source: 'admin-home-preview',
        type: 'ready',
    }, '*');
})();
</script>
