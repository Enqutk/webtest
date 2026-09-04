@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('homeSectionsBuilder', () => ({
        activeSection: 'hero',
        previewOpen: true,
        previewReady: false,
        sectionLabels: @json($sectionLabels),
        openSlideModal: false,
        editingSlideIndex: null,
        slideTitle: '',
        slideSubtitle: '',
        slideDesc: '',
        slideBtnText: 'Explore services',
        slideBtnLink: '/our-services',
        slideShape: 'inherit',
        slideVisible: true,

        openTeamModal: false,
        editingMemberId: null,
        memberFirst: '',
        memberLast: '',
        memberRole: '',
        memberBio: '',
        memberOrder: {{ ($teamMembers->max('order') ?? 0) + 1 }},
        memberStatus: 'active',
        memberFounder: false,

        heroBadge: @json($hero['badge'] ?? 'Infrastructure · Engineering · Impact'),
        heroSubtitle: @json($hero['subtitle'] ?? 'Engineering Excellence'),
        heroTitle: @json($hero['title'] ?? 'Building resilient infrastructure for lasting communities'),
        heroDescription: @json($hero['description'] ?? ''),
        heroCtaText: @json($hero['cta_text'] ?? 'Explore Our Work'),
        heroSecondaryCtaText: @json($hero['secondary_cta_text'] ?? 'Our Services'),

        aboutEyebrow: @json($about['eyebrow'] ?? 'About our firm'),
        aboutTitle: @json($about['title'] ?? 'Rooted in East Africa, built for scale'),
        aboutP1: @json($about['paragraph_1'] ?? ($about['description'] ?? '')),
        aboutP2: @json($about['paragraph_2'] ?? ''),

        servicesEyebrow: @json($servicesSec['eyebrow'] ?? 'Core Capabilities'),
        servicesTitle: @json($servicesSec['title'] ?? 'Integrated solutions for complex infrastructure'),
        servicesDescription: @json($servicesSec['description'] ?? ''),

        statsEyebrow: @json($statsSec['eyebrow'] ?? 'By the numbers'),
        statsTitle: @json($statsSec['title'] ?? ($statsSec['stat_1_label'] ? 'Impact & Statistics' : 'Impact that compounds across communities')),

        portfolioEyebrow: @json($portfolioSec['eyebrow'] ?? 'Featured Projects'),
        portfolioTitle: @json($portfolioSec['title'] ?? 'Delivering resilient infrastructure across East Africa'),

        teamEyebrow: @json($teamSec['eyebrow'] ?? 'Leadership & Team'),
        teamTitle: @json($teamSec['title'] ?? 'Experienced engineers & hydrologists'),
        teamDescription: @json($teamSec['description'] ?? ''),

        ctaTitle: @json($ctaSec['title'] ?? 'Ready to build water infrastructure that lasts?'),
        ctaButtonText: @json($ctaSec['button_text'] ?? 'Talk to an engineer'),

        editSlide(index, slide) {
            this.editingSlideIndex = index;
            this.slideTitle = slide.title || '';
            this.slideSubtitle = slide.subtitle || '';
            this.slideDesc = slide.description || '';
            this.slideBtnText = slide.text_link || 'Explore services';
            this.slideBtnLink = slide.button_link || '/our-services';
            this.slideShape = slide.image_shape || 'inherit';
            this.slideVisible = (slide.is_visible !== false);
            this.openSlideModal = true;
        },

        newSlide() {
            this.editingSlideIndex = null;
            this.slideTitle = '';
            this.slideSubtitle = '';
            this.slideDesc = '';
            this.slideBtnText = 'Explore services';
            this.slideBtnLink = '/our-services';
            this.slideShape = 'inherit';
            this.slideVisible = true;
            this.openSlideModal = true;
        },

        editMember(m) {
            this.editingMemberId = m.id;
            this.memberFirst = m.first_name || '';
            this.memberLast = m.last_name || '';
            this.memberRole = m.title || '';
            this.memberBio = m.description || '';
            this.memberOrder = m.order || 1;
            this.memberStatus = m.status?.value || m.status || 'active';
            this.memberFounder = !!m.founder;
            this.openTeamModal = true;
        },

        newMember() {
            this.editingMemberId = null;
            this.memberFirst = '';
            this.memberLast = '';
            this.memberRole = '';
            this.memberBio = '';
            this.memberOrder = {{ ($teamMembers->max('order') ?? 0) + 1 }};
            this.memberStatus = 'active';
            this.memberFounder = false;
            this.openTeamModal = true;
        },

        previewFrame() {
            return this.$refs.previewFrame || null;
        },

        previewDoc() {
            const frame = this.previewFrame();
            if (!frame) return null;
            try {
                return frame.contentDocument || frame.contentWindow.document;
            } catch (e) {
                return null;
            }
        },

        postToPreview(payload) {
            const frame = this.previewFrame();
            if (!frame || !frame.contentWindow) return;
            frame.contentWindow.postMessage(Object.assign({
                source: 'admin-home-preview-parent',
            }, payload), '*');
        },

        focusPreviewSection(section) {
            section = section || this.activeSection;
            this.postToPreview({ type: 'focus-section', section: section });
            const doc = this.previewDoc();
            if (!doc) return;
            doc.querySelectorAll('[data-admin-section]').forEach((el) => el.classList.remove('is-admin-focused'));
            const target = doc.querySelector('[data-admin-section="' + section + '"]');
            if (!target) return;
            target.classList.add('is-admin-focused');
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        },

        pushField(section, field, value) {
            this.postToPreview({ type: 'update-field', section: section, field: field, value: value });
            const doc = this.previewDoc();
            if (!doc) return;
            const root = doc.querySelector('[data-admin-section="' + section + '"]');
            if (!root) return;
            root.querySelectorAll('[data-preview-field="' + field + '"]').forEach((el) => {
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
        },

        selectSection(section, options) {
            options = options || {};
            if (!section) return;
            this.activeSection = section;
            this.$nextTick(() => {
                this.focusPreviewSection(section);
                const form = document.getElementById('admin-form-' + section);
                if (form) {
                    form.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                }
            });
        },

        aboutPreviewHtml() {
            const parts = [this.aboutP1, this.aboutP2].filter(Boolean);
            const lt = String.fromCharCode(60);
            const gt = String.fromCharCode(62);
            return parts.map((p) => {
                return p.split(lt).join('&lt;').split(gt).join('&gt;').split('\n').join('<br>');
            }).join('<br><br>');
        },

        syncActiveSectionToPreview() {
            if (!this.previewReady) return;
            this.focusPreviewSection(this.activeSection);

            if (this.activeSection === 'hero') {
                this.pushField('hero', 'badge', this.heroBadge);
                this.pushField('hero', 'title', this.heroTitle);
                this.pushField('hero', 'description', this.heroDescription);
                this.pushField('hero', 'cta_text', this.heroCtaText);
                this.pushField('hero', 'secondary_cta_text', this.heroSecondaryCtaText);
            }
            if (this.activeSection === 'about') {
                this.pushField('about', 'eyebrow', this.aboutEyebrow);
                this.pushField('about', 'title', this.aboutTitle);
                this.pushField('about', 'description', this.aboutPreviewHtml());
            }
            if (this.activeSection === 'services') {
                this.pushField('services', 'eyebrow', this.servicesEyebrow);
                this.pushField('services', 'title', this.servicesTitle);
                this.pushField('services', 'description', this.servicesDescription);
            }
            if (this.activeSection === 'stats') {
                this.pushField('stats', 'eyebrow', this.statsEyebrow);
                this.pushField('stats', 'title', this.statsTitle);
            }
            if (this.activeSection === 'portfolio') {
                this.pushField('portfolio', 'eyebrow', this.portfolioEyebrow);
                this.pushField('portfolio', 'title', this.portfolioTitle);
            }
            if (this.activeSection === 'team') {
                this.pushField('team', 'eyebrow', this.teamEyebrow);
                this.pushField('team', 'title', this.teamTitle);
                this.pushField('team', 'description', this.teamDescription);
            }
            if (this.activeSection === 'cta') {
                this.pushField('cta', 'title', this.ctaTitle);
                this.pushField('cta', 'button_text', this.ctaButtonText);
            }
        },

        wirePreviewInteractions() {
            const doc = this.previewDoc();
            if (!doc || !doc.body) return;

            doc.body.classList.add('admin-preview-mode');

            if (!doc.getElementById('admin-preview-parent-style')) {
                const style = doc.createElement('style');
                style.id = 'admin-preview-parent-style';
                style.textContent = [
                    'body.admin-preview-mode [data-admin-section]{position:relative;cursor:pointer!important;outline:2px solid transparent;outline-offset:-2px}',
                    'body.admin-preview-mode [data-admin-section]::after{content:attr(data-admin-label);position:absolute;top:10px;right:10px;z-index:9999;background:rgba(15,23,42,.9);color:#fff;font-size:11px;font-weight:700;text-transform:uppercase;padding:6px 10px;border-radius:8px;opacity:0;pointer-events:none}',
                    'body.admin-preview-mode [data-admin-section]:hover{outline-color:rgba(234,88,12,.7);box-shadow:inset 0 0 0 9999px rgba(234,88,12,.07)}',
                    'body.admin-preview-mode [data-admin-section]:hover::after,body.admin-preview-mode [data-admin-section].is-admin-focused::after{opacity:1}',
                    'body.admin-preview-mode [data-admin-section].is-admin-focused{outline-color:#ea580c;box-shadow:inset 0 0 0 9999px rgba(234,88,12,.1)}',
                    'body.admin-preview-mode [data-admin-section].is-admin-focused::after{background:#ea580c}',
                    'body.admin-preview-mode a,body.admin-preview-mode button{pointer-events:none!important}',
                ].join('');
                (doc.head || doc.body).appendChild(style);
            }

            const map = [
                { key: 'site-header', label: 'Edit Header', sel: 'header.hz-header, .hz-header', editUrl: @json(\App\Support\AdminEditUrls::siteSettings('header')) },
                { key: 'site-brand', label: 'Edit Header', sel: '.hz-brand', editUrl: @json(\App\Support\AdminEditUrls::siteSettings('header')) },
                { key: 'site-nav', label: 'Edit Navigation', sel: '.hz-nav-collapse, .hz-nav', editUrl: @json(\App\Support\AdminEditUrls::siteSettings('navigation')) },
                { key: 'site-header-cta', label: 'Edit Header Button', sel: '.hz-nav-cta', editUrl: @json(\App\Support\AdminEditUrls::siteSettings('header')) },
                { key: 'site-footer', label: 'Edit Footer', sel: 'footer.hz-footer, .hz-footer', editUrl: @json(\App\Support\AdminEditUrls::siteSettings('footer')) },
                { key: 'site-social', label: 'Edit Social Links', sel: '.hz-social', editUrl: @json(\App\Support\AdminEditUrls::siteSettings('footer')) },
                { key: 'site-contact', label: 'Edit Contact Info', sel: '.hz-footer .col-lg-3:last-child', editUrl: @json(\App\Support\AdminEditUrls::siteSettings('footer')) },
                { key: 'hero', label: 'Edit Hero', sel: '[data-admin-section="hero"], section.hz-hero, .hz-hero' },
                { key: 'about', label: 'Edit About', sel: '[data-admin-section="about"], #about, section.hz-about' },
                { key: 'services', label: 'Edit Services', sel: '[data-admin-section="services"], #services, section.hz-services' },
                { key: 'stats', label: 'Edit Stats', sel: '[data-admin-section="stats"], section.hz-stats' },
                { key: 'portfolio', label: 'Edit Portfolio', sel: '[data-admin-section="portfolio"], #portfolio, section.hz-portfolio' },
                { key: 'clients', label: 'Edit Clients', sel: '[data-admin-section="clients"], section.hz-clients' },
                { key: 'team', label: 'Edit Team', sel: '[data-admin-section="team"], #team, section.hz-team' },
                { key: 'cta', label: 'Edit CTA', sel: '[data-admin-section="cta"], section.hz-cta' },
            ];

            const self = this;
            map.forEach(({ key, label, sel, editUrl }) => {
                doc.querySelectorAll(sel).forEach((el) => {
                    if (!el.getAttribute('data-admin-section')) {
                        el.setAttribute('data-admin-section', key);
                    }
                    el.setAttribute('data-admin-label', label);
                    if (editUrl) {
                        el.setAttribute('data-admin-edit-url', editUrl);
                    }
                    if (el.dataset.adminWired === '1') return;
                    el.dataset.adminWired = '1';
                    el.addEventListener('click', (event) => {
                        event.preventDefault();
                        event.stopPropagation();
                        const url = el.getAttribute('data-admin-edit-url');
                        if (url) {
                            window.location.href = url;
                            return;
                        }
                        self.selectSection(key, { fromPreview: true });
                    }, true);
                });
            });

            this.previewReady = true;
            this.syncActiveSectionToPreview();
        },

        onPreviewLoad() {
            setTimeout(() => this.wirePreviewInteractions(), 50);
            setTimeout(() => this.wirePreviewInteractions(), 300);
        },

        init() {
            window.addEventListener('message', (event) => {
                const data = event.data || {};
                if (data.source !== 'admin-home-preview') return;

                if (data.type === 'ready') {
                    this.previewReady = true;
                    this.wirePreviewInteractions();
                }

                if (data.type === 'section-click' && data.section) {
                    if (data.editUrl) {
                        window.location.href = data.editUrl;
                        return;
                    }
                    const common = @json([
                        'site-header' => \App\Support\AdminEditUrls::siteSettings('header'),
                        'site-brand' => \App\Support\AdminEditUrls::siteSettings('header'),
                        'site-nav' => \App\Support\AdminEditUrls::siteSettings('navigation'),
                        'site-header-cta' => \App\Support\AdminEditUrls::siteSettings('header'),
                        'site-footer' => \App\Support\AdminEditUrls::siteSettings('footer'),
                        'site-social' => \App\Support\AdminEditUrls::siteSettings('footer'),
                        'site-contact' => \App\Support\AdminEditUrls::siteSettings('footer'),
                    ]);
                    if (common[data.section]) {
                        window.location.href = common[data.section];
                        return;
                    }
                    this.selectSection(data.section, { fromPreview: true });
                }

                if (data.type === 'navigate-edit' && data.url) {
                    window.location.href = data.url;
                }
            });

            this.$watch('activeSection', () => this.syncActiveSectionToPreview());
            this.$watch('heroBadge', (v) => this.pushField('hero', 'badge', v));
            this.$watch('heroTitle', (v) => this.pushField('hero', 'title', v));
            this.$watch('heroDescription', (v) => this.pushField('hero', 'description', v));
            this.$watch('heroCtaText', (v) => this.pushField('hero', 'cta_text', v));
            this.$watch('heroSecondaryCtaText', (v) => this.pushField('hero', 'secondary_cta_text', v));
            this.$watch('aboutEyebrow', (v) => this.pushField('about', 'eyebrow', v));
            this.$watch('aboutTitle', (v) => this.pushField('about', 'title', v));
            this.$watch('aboutP1', () => this.pushField('about', 'description', this.aboutPreviewHtml()));
            this.$watch('aboutP2', () => this.pushField('about', 'description', this.aboutPreviewHtml()));
            this.$watch('servicesEyebrow', (v) => this.pushField('services', 'eyebrow', v));
            this.$watch('servicesTitle', (v) => this.pushField('services', 'title', v));
            this.$watch('servicesDescription', (v) => this.pushField('services', 'description', v));
            this.$watch('statsEyebrow', (v) => this.pushField('stats', 'eyebrow', v));
            this.$watch('statsTitle', (v) => this.pushField('stats', 'title', v));
            this.$watch('portfolioEyebrow', (v) => this.pushField('portfolio', 'eyebrow', v));
            this.$watch('portfolioTitle', (v) => this.pushField('portfolio', 'title', v));
            this.$watch('teamEyebrow', (v) => this.pushField('team', 'eyebrow', v));
            this.$watch('teamTitle', (v) => this.pushField('team', 'title', v));
            this.$watch('teamDescription', (v) => this.pushField('team', 'description', v));
            this.$watch('ctaTitle', (v) => this.pushField('cta', 'title', v));
            this.$watch('ctaButtonText', (v) => this.pushField('cta', 'button_text', v));
        },
    }));
});
</script>
@endpush
