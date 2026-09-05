{{-- Admin click-to-edit preview mode (?admin_preview=1) --}}
<style>
    body.admin-preview-mode [data-admin-section] {
        position: relative;
        cursor: pointer !important;
        transition: outline-color 0.15s ease, background-color 0.15s ease;
        outline: 2px solid transparent;
        outline-offset: 2px;
        border-radius: 6px;
    }
    /* Site chrome: tight highlight on the exact component only */
    body.admin-preview-mode [data-admin-section][data-admin-compact] {
        display: inline-block;
        width: fit-content;
        max-width: 100%;
        vertical-align: middle;
    }
    body.admin-preview-mode [data-admin-section][data-admin-compact]::after {
        content: attr(data-admin-label);
        position: absolute;
        top: -26px;
        left: 0;
        z-index: 9999;
        background: rgba(15, 23, 42, 0.92);
        color: #fff;
        font-size: 9px;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        padding: 3px 7px;
        border-radius: 6px;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.12s ease;
        white-space: nowrap;
    }
    body.admin-preview-mode [data-admin-section][data-admin-compact]:hover,
    body.admin-preview-mode [data-admin-section][data-admin-compact].is-admin-focused {
        outline-color: #ea580c;
        background: rgba(234, 88, 12, 0.12);
        box-shadow: none;
    }
    body.admin-preview-mode [data-admin-section][data-admin-compact]:hover::after,
    body.admin-preview-mode [data-admin-section][data-admin-compact].is-admin-focused::after {
        opacity: 1;
    }
    body.admin-preview-mode [data-admin-section][data-admin-compact].is-admin-focused::after {
        background: #ea580c;
    }
    /* Home page sections: full-section overlay (no data-admin-compact) */
    body.admin-preview-mode [data-admin-section]:not([data-admin-compact])::after {
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
        white-space: nowrap;
    }
    body.admin-preview-mode [data-admin-section]:not([data-admin-compact]):hover {
        outline-color: rgba(234, 88, 12, 0.7);
        box-shadow: inset 0 0 0 9999px rgba(234, 88, 12, 0.07);
    }
    body.admin-preview-mode [data-admin-section]:not([data-admin-compact]):hover::after,
    body.admin-preview-mode [data-admin-section]:not([data-admin-compact]).is-admin-focused::after {
        opacity: 1;
    }
    body.admin-preview-mode [data-admin-section]:not([data-admin-compact]).is-admin-focused {
        outline-color: #ea580c;
        box-shadow: inset 0 0 0 9999px rgba(234, 88, 12, 0.1);
    }
    body.admin-preview-mode [data-admin-section]:not([data-admin-compact]).is-admin-focused::after {
        background: #ea580c;
    }
    body.admin-preview-mode a,
    body.admin-preview-mode button {
        pointer-events: none !important;
    }
</style>
<script>
(function () {
    document.body.classList.add('admin-preview-mode');

    function post(type, extra) {
        if (window.parent === window) return;
        window.parent.postMessage(Object.assign({
            source: 'admin-home-preview',
            type: type,
        }, extra || {}), '*');
    }

    function focusElement(el) {
        document.querySelectorAll('[data-admin-section]').forEach(function (node) {
            node.classList.remove('is-admin-focused');
        });
        if (!el) return;
        el.classList.add('is-admin-focused');
        el.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    function findTargetAt(x, y) {
        var candidates = Array.prototype.slice.call(
            document.querySelectorAll('[data-admin-section]')
        ).filter(function (el) {
            var rect = el.getBoundingClientRect();
            return x >= rect.left && x <= rect.right && y >= rect.top && y <= rect.bottom;
        });

        if (!candidates.length) return null;

        candidates.sort(function (a, b) {
            var ra = a.getBoundingClientRect();
            var rb = b.getBoundingClientRect();
            return (ra.width * ra.height) - (rb.width * rb.height);
        });

        return candidates[0];
    }

    function applyFieldUpdate(section, field, value) {
        var sectionRoot = document.getElementById(section) || document.querySelector('[data-admin-section="' + section + '"]');
        var scope = sectionRoot || document;

        if (field === 'image-focus') {
            scope.querySelectorAll('[data-preview-field="image"]').forEach(function (el) {
                el.style.objectPosition = value || '50% 50%';
            });
            return;
        }

        scope.querySelectorAll('[data-preview-field="' + field + '"]').forEach(function (el) {
            if (el.tagName === 'IMG') {
                if (value) {
                    el.setAttribute('src', value);
                    var mediaWrap = el.closest('[data-about-intro-media]');
                    if (mediaWrap) {
                        mediaWrap.classList.remove('d-none');
                    }
                    var placeholder = scope.querySelector('[data-about-intro-placeholder]');
                    if (placeholder) {
                        placeholder.classList.add('d-none');
                    }
                }
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

    document.addEventListener('click', function (event) {
        var el = findTargetAt(event.clientX, event.clientY);
        if (!el) return;
        event.preventDefault();
        event.stopPropagation();
        var section = el.getAttribute('data-admin-section');
        if (!section) return;
        var field = el.getAttribute('data-admin-field');
        var editUrl = el.getAttribute('data-admin-edit-url');
        focusElement(el);
        if (editUrl) {
            post('navigate-edit', { url: editUrl, section: section, field: field });
            return;
        }
        post('section-click', { section: section, field: field, editUrl: editUrl || null });
    }, true);

    window.addEventListener('message', function (event) {
        var data = event.data || {};
        if (data.source !== 'admin-home-preview-parent') return;
        if (data.type === 'focus-section' && data.section) {
            var sel = data.field
                ? '[data-admin-section="' + data.section + '"][data-admin-field="' + data.field + '"]'
                : '[data-admin-section="' + data.section + '"]';
            focusElement(document.querySelector(sel));
        }
        if (data.type === 'update-field' && data.section && data.field) {
            applyFieldUpdate(data.section, data.field, data.value);
        }
        if (data.type === 'ping') post('ready');
    });

    post('ready');
})();
</script>
