@php
    $previewEditTargets = \App\Support\AdminEditUrls::editTargetsForJs();
    $previewLocalAnchors = \App\Support\AdminEditUrls::siteSettingsLocalAnchors();
@endphp
<script>
(function () {
    var editTargets = @json($previewEditTargets);
    var siteSettingsAnchors = @json($previewLocalAnchors);
    var homeSections = @json(\App\Support\AdminEditUrls::HOME_SECTIONS);

    function isHomeBuilderPage() {
        return window.location.pathname.endsWith('/admin/home-sections');
    }

    function isAboutPageEditor() {
        return window.location.pathname.endsWith('/admin/site-pages/about');
    }

    function isContactPageEditor() {
        return window.location.pathname.endsWith('/admin/site-pages/contact');
    }

    function isSameAdminPath(url) {
        if (!url) return false;
        try {
            return new URL(url, window.location.origin).pathname === window.location.pathname;
        } catch (e) {
            return false;
        }
    }

    function appendFieldParam(url, field) {
        if (!field || url.indexOf('field=') !== -1) return url;
        var hashIdx = url.indexOf('#');
        var base = hashIdx === -1 ? url : url.slice(0, hashIdx);
        var hash = hashIdx === -1 ? '' : url.slice(hashIdx);
        var sep = base.indexOf('?') === -1 ? '?' : '&';
        return base + sep + 'field=' + encodeURIComponent(field) + hash;
    }

    function shouldNavigateForSection(section) {
        if (!editTargets[section]) return false;
        if (isHomeBuilderPage() && homeSections.indexOf(section) !== -1) return false;
        if (isAboutPageEditor() && (section === 'about-page-intro' || section === 'about-page-story' || section === 'page-hero' || section === 'about')) return false;
        if (isContactPageEditor() && (section === 'contact-page-intro' || section === 'contact-page-details' || section === 'contact-page-social' || section === 'page-hero' || section === 'site-social')) return false;
        return true;
    }

    function previewDocument(frame) {
        if (!frame) return null;
        try {
            return frame.contentDocument || frame.contentWindow.document;
        } catch (e) {
            return null;
        }
    }

    function applyFieldUpdate(doc, section, field, value) {
        if (!doc) return;
        var sectionRoot = doc.getElementById(section) || doc.querySelector('[data-admin-section="' + section + '"]');
        var scope = sectionRoot || doc;
        scope.querySelectorAll('[data-preview-field="' + field + '"]').forEach(function (el) {
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

    function focusLocalSiteSettings(section) {
        if (!window.location.pathname.endsWith('/admin/site-settings')) return false;
        var anchor = siteSettingsAnchors[section];
        if (!anchor) return false;

        var panel = document.querySelector('.site-settings-panel');
        if (!panel || !panel.__x) return false;

        var data = panel.__x.$data;
        if (typeof data.setTab === 'function') {
            data.setTab(anchor.tab || 'header', anchor.hash);
            return true;
        }

        if (anchor.hash) {
            window.location.hash = anchor.hash;
        }

        return true;
    }

    function focusLocalPageEditor(section, field) {
        if (section === 'about') {
            section = 'about-page-intro';
        }

        if (section === 'page-hero') {
            var header = document.getElementById('page-header');
            if (!header) return false;
            header.scrollIntoView({ behavior: 'smooth', block: 'start' });
            var focusInput = header.querySelector('input[name="title"], textarea, input');
            if (focusInput) focusInput.focus();
            return true;
        }

        if (section === 'about-page-intro') {
            var intro = document.getElementById('about-page-intro');
            if (!intro) return false;
            intro.scrollIntoView({ behavior: 'smooth', block: 'start' });
            if (field && /^point_\d+$/.test(field)) {
                var idx = field.replace('point_', '');
                var card = document.getElementById('about-point-' + idx);
                if (card) {
                    card.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    var titleInput = card.querySelector('input[name="points[' + idx + '][title]"]');
                    if (titleInput) titleInput.focus();
                    return true;
                }
            }
            var fieldMap = { eyebrow: 'intro_eyebrow', title: 'intro_title', description: 'intro_description', paragraph_1: 'intro_description' };
            var inputName = fieldMap[field] || null;
            var input = inputName ? intro.querySelector('[name="' + inputName + '"]') : intro.querySelector('input, textarea');
            if (input) input.focus();
            return true;
        }

        if (section === 'about-page-story') {
            var story = document.getElementById('about-page-story');
            if (!story) return false;
            story.scrollIntoView({ behavior: 'smooth', block: 'start' });
            var storyFieldMap = { eyebrow: 'story_eyebrow', title: 'story_title' };
            var storyInputName = field ? (storyFieldMap[field] || null) : null;
            var storyInput = storyInputName ? story.querySelector('[name="' + storyInputName + '"]') : story.querySelector('input, textarea');
            if (storyInput) storyInput.focus();
            return true;
        }

        if (section === 'contact-page-intro') {
            var intro = document.getElementById('contact-intro');
            if (!intro) return false;
            intro.scrollIntoView({ behavior: 'smooth', block: 'start' });
            var introInput = intro.querySelector('[name="intro"]');
            if (introInput) introInput.focus();
            return true;
        }

        if (section === 'contact-page-details') {
            var details = document.getElementById('contact-details');
            if (!details) return false;
            details.scrollIntoView({ behavior: 'smooth', block: 'start' });
            var contactFieldMap = {
                email: '#contact-emails',
                phone: '#contact-phones',
                address: '#contact-address',
                hours: '#contact-hours',
            };
            var anchor = field ? contactFieldMap[field] : null;
            if (anchor) {
                var block = details.querySelector(anchor);
                if (block) {
                    block.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    var input = block.querySelector('input, textarea');
                    if (input) input.focus();
                }
            }
            return true;
        }

        if (section === 'contact-page-social' || section === 'site-social') {
            if (!isContactPageEditor()) return false;
            var social = document.getElementById('contact-social');
            if (!social) return false;
            social.scrollIntoView({ behavior: 'smooth', block: 'start' });
            return true;
        }

        return false;
    }

    window.AdminPreview = {
        frame: null,
        previewReady: false,
        editTargets: editTargets,
        handlers: {
            onSectionClick: null,
        },

        registerFrame(frame) {
            this.frame = frame;
            this.previewReady = false;
        },

        post(payload) {
            if (!this.frame || !this.frame.contentWindow) return;
            this.frame.contentWindow.postMessage(Object.assign({
                source: 'admin-home-preview-parent',
            }, payload), '*');
        },

        pushField(section, field, value) {
            this.post({ type: 'update-field', section: section, field: field, value: value });
            applyFieldUpdate(previewDocument(this.frame), section, field, value);
        },

        focusPreviewSection(section, field) {
            this.post({ type: 'focus-section', section: section, field: field || null });
            var doc = previewDocument(this.frame);
            if (!doc) return;
            doc.querySelectorAll('[data-admin-section]').forEach(function (el) {
                el.classList.remove('is-admin-focused');
            });
            var sel = field
                ? '[data-admin-section="' + section + '"][data-admin-field="' + field + '"]'
                : '[data-admin-section="' + section + '"]';
            var target = doc.querySelector(sel);
            if (!target) return;
            target.classList.add('is-admin-focused');
            target.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        },

        handlePreviewMessage(event) {
            var data = event.data || {};
            if (data.source !== 'admin-home-preview') return false;

            if (data.type === 'ready') {
                this.previewReady = true;
                return true;
            }

            if (data.type === 'navigate-edit' && data.url) {
                if (isSameAdminPath(data.url) && focusLocalPageEditor(data.section, data.field || null)) {
                    if (data.url.indexOf('#') !== -1) {
                        window.location.hash = data.url.split('#')[1].split('?')[0];
                    }
                    return true;
                }
                window.location.href = data.url;
                return true;
            }

            if (data.type === 'section-click' && data.section) {
                if (data.editUrl) {
                    if (isSameAdminPath(data.editUrl) && focusLocalPageEditor(data.section, data.field || null)) {
                        if (data.editUrl.indexOf('#') !== -1) {
                            window.location.hash = data.editUrl.split('#')[1].split('?')[0];
                        }
                        return true;
                    }
                    window.location.href = data.editUrl;
                    return true;
                }

                if (focusLocalSiteSettings(data.section)) {
                    return true;
                }

                if (focusLocalPageEditor(data.section, data.field || null)) {
                    return true;
                }

                if (shouldNavigateForSection(data.section)) {
                    var url = editTargets[data.section];
                    if (data.field) {
                        url = appendFieldParam(url, data.field);
                    }
                    window.location.href = url;
                    return true;
                }

                if (typeof this.handlers.onSectionClick === 'function') {
                    this.handlers.onSectionClick(data.section, data.field || null, data);
                    return true;
                }
            }

            return false;
        },

        bindInput(input, section, field) {
            if (!input || input.dataset.previewBound === '1') return;
            input.dataset.previewBound = '1';
            var push = function () {
                window.AdminPreview.pushField(section, field, input.value);
            };
            input.addEventListener('input', push);
            input.addEventListener('change', push);
        },

        bindFields(root) {
            (root || document).querySelectorAll('[data-preview-bind]').forEach(function (el) {
                var parts = (el.getAttribute('data-preview-bind') || '').split(':');
                if (parts.length !== 2) return;
                window.AdminPreview.bindInput(el, parts[0], parts[1]);
            });
        },

        onFrameLoad() {
            var self = this;
            setTimeout(function () {
                self.previewReady = true;
                self.bindFields(document);
            }, 50);
        },
    };

    window.addEventListener('message', function (event) {
        window.AdminPreview.handlePreviewMessage(event);
    });

    document.addEventListener('alpine:init', function () {
        Alpine.data('adminPreviewPanel', function () {
            return {
                previewReady: false,

                onPreviewLoad() {
                    if (this.$refs.previewFrame) {
                        window.AdminPreview.registerFrame(this.$refs.previewFrame);
                    }
                    window.AdminPreview.onFrameLoad();
                    this.previewReady = true;
                },

                pushField(section, field, value) {
                    window.AdminPreview.pushField(section, field, value);
                },

                init() {
                    this.$nextTick(function () {
                        window.AdminPreview.bindFields(this.$el);
                    }.bind(this));
                },
            };
        });
    });
})();
</script>
