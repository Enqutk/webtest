@php
    $servicesListForJs = $services->map(fn ($s) => [
        'id' => $s->id,
        'title' => $s->title,
        'short_description' => $s->short_description,
        'quote' => $s->quote,
        'order' => $s->order,
        'status' => $s->status->value ?? $s->status,
        'image_focus_x' => $s->image_focus_x ?? 50,
        'image_focus_y' => $s->image_focus_y ?? 50,
        'image_url' => $s->main_image_url ?: null,
    ])->values();
    $projectsListForJs = $projects->map(fn ($p) => [
        'id' => $p->id,
        'name' => $p->name,
        'category' => $p->category,
        'link' => $p->link,
        'description' => $p->description,
        'order' => $p->order,
        'status' => $p->status->value ?? $p->status,
        'image_focus_x' => $p->image_focus_x ?? 50,
        'image_focus_y' => $p->image_focus_y ?? 50,
        'image_url' => $p->getFirstMediaUrl('image') ?: null,
    ])->values();
    $clientsListForJs = $clientPartners->map(fn ($c) => [
        'id' => $c->id,
        'name' => $c->name,
        'type' => $c->type->value ?? $c->type,
        'link' => $c->link,
        'order' => $c->order,
        'status' => $c->status->value ?? $c->status,
        'image_focus_x' => $c->image_focus_x ?? 50,
        'image_focus_y' => $c->image_focus_y ?? 50,
        'image_url' => $c->getFirstMediaUrl('image') ?: null,
    ])->values();
@endphp
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
        slideFocusX: 50,
        slideFocusY: 50,
        slidePreviewUrl: '',

        openTeamModal: false,
        editingMemberId: null,
        memberFirst: '',
        memberLast: '',
        memberRole: '',
        memberBio: '',
        memberOrder: {{ ($teamMembers->max('order') ?? 0) + 1 }},
        memberStatus: 'active',
        memberFounder: false,
        memberFocusX: 50,
        memberFocusY: 50,
        memberPreviewUrl: '',

        openServiceModal: false,
        editingServiceId: null,
        serviceTitle: '',
        serviceShortDesc: '',
        serviceQuote: '',
        serviceOrder: {{ $nextServiceOrder }},
        serviceStatus: 'active',
        serviceFocusX: 50,
        serviceFocusY: 50,
        servicePreviewUrl: '',
        servicesList: @json($servicesListForJs),

        openProjectModal: false,
        editingProjectId: null,
        projectName: '',
        projectCategory: '',
        projectLink: '',
        projectDescription: '',
        projectOrder: {{ $nextProjectOrder }},
        projectStatus: 'active',
        projectFocusX: 50,
        projectFocusY: 50,
        projectPreviewUrl: '',
        projectsList: @json($projectsListForJs),

        openClientModal: false,
        editingClientId: null,
        clientName: '',
        clientType: 'client',
        clientLink: '',
        clientOrder: {{ $nextClientOrder }},
        clientStatus: 'active',
        clientFocusX: 50,
        clientFocusY: 50,
        clientPreviewUrl: '',
        clientsList: @json($clientsListForJs),

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
        aboutPoints: @json(collect($aboutPoints)->values()->all()),

        servicesEyebrow: @json($servicesSec['eyebrow'] ?? 'Core Capabilities'),
        servicesTitle: @json($servicesSec['title'] ?? 'Integrated solutions for complex infrastructure'),
        servicesDescription: @json($servicesSec['description'] ?? ''),

        statsEyebrow: @json($statsSec['eyebrow'] ?? 'By the numbers'),
        statsTitle: @json($statsSec['title'] ?? ($statsSec['stat_1_label'] ? 'Impact & Statistics' : 'Impact that compounds across communities')),
        statsItems: @json(collect($statsItems)->values()->all()),

        portfolioEyebrow: @json($portfolioSec['eyebrow'] ?? 'Featured Projects'),
        portfolioTitle: @json($portfolioSec['title'] ?? 'Delivering resilient infrastructure across East Africa'),

        clientsEyebrow: @json($clientsSec['eyebrow'] ?? 'Trusted partners'),
        clientsTitle: @json($clientsSec['title'] ?? 'Organizations we work alongside'),
        clientsDescription: @json($clientsSec['description'] ?? ''),

        teamEyebrow: @json($teamSec['eyebrow'] ?? 'Leadership & Team'),
        teamTitle: @json($teamSec['title'] ?? 'Experienced engineers & hydrologists'),
        teamDescription: @json($teamSec['description'] ?? ''),

        ctaTitle: @json($ctaSec['title'] ?? 'Ready to build water infrastructure that lasts?'),
        ctaButtonText: @json($ctaSec['button_text'] ?? 'Talk to an engineer'),

        creatorVisible: {{ !empty($creatorSec['is_visible']) ? 'true' : 'false' }},
        creatorLabel: @json($creatorSec['label'] ?? 'Creator of this platform'),
        creatorName: @json($creatorSec['name'] ?? ''),
        creatorLine: @json($creatorSec['line'] ?? ''),
        creatorCtaText: @json($creatorSec['cta_text'] ?? ''),

        editSlide(index, slide) {
            this.editingSlideIndex = index;
            this.slideTitle = slide.title || '';
            this.slideSubtitle = slide.subtitle || '';
            this.slideDesc = slide.description || '';
            this.slideBtnText = slide.text_link || 'Explore services';
            this.slideBtnLink = slide.button_link || '/our-services';
            this.slideShape = slide.image_shape || 'inherit';
            this.slideVisible = (slide.is_visible !== false);
            this.slideFocusX = Number(slide.image_focus_x ?? 50);
            this.slideFocusY = Number(slide.image_focus_y ?? 50);
            this.slidePreviewUrl = this.slideImageUrlFromData(slide);
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
            this.slideFocusX = 50;
            this.slideFocusY = 50;
            this.slidePreviewUrl = '';
            this.openSlideModal = true;
        },

        slideImageUrlFromData(slide) {
            if (!slide) return '';
            let img = slide.image_path || slide.image || '';
            if (Array.isArray(img)) {
                img = img[0] || Object.values(img)[0] || '';
            }
            if (!img) return '';
            if (String(img).startsWith('http')) return img;
            return '/storage/' + String(img).replace(/^\/+/, '').replace(/^storage\//, '');
        },

        setSlideFocusFromClick(event) {
            this.imageFocusFromClick(event, 'slideFocusX', 'slideFocusY');
        },

        setSlideFocusPreset(x, y) {
            this.setImageFocusPreset(x, y, 'slideFocusX', 'slideFocusY');
        },

        onSlideImagePick(event) {
            this.onImagePick(event, 'slidePreviewUrl');
        },

        imageFocusFromClick(event, xProp, yProp) {
            const rect = event.currentTarget.getBoundingClientRect();
            if (!rect.width || !rect.height) return;
            this[xProp] = Math.max(0, Math.min(100, Math.round(((event.clientX - rect.left) / rect.width) * 100)));
            this[yProp] = Math.max(0, Math.min(100, Math.round(((event.clientY - rect.top) / rect.height) * 100)));
        },

        setImageFocusPreset(x, y, xProp, yProp) {
            this[xProp] = x;
            this[yProp] = y;
        },

        onImagePick(event, previewProp) {
            const file = event.target.files && event.target.files[0];
            if (!file) return;
            this[previewProp] = URL.createObjectURL(file);
        },

        mediaPreviewUrl(item) {
            if (!item) return '';
            if (item.image_url) return item.image_url;
            return this.slideImageUrlFromData(item);
        },

        resetImageFocus(xProp, yProp, previewProp) {
            this[xProp] = 50;
            this[yProp] = 50;
            this[previewProp] = '';
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
            this.memberFocusX = Number(m.image_focus_x ?? 50);
            this.memberFocusY = Number(m.image_focus_y ?? 50);
            this.memberPreviewUrl = m.image_url || '';
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
            this.resetImageFocus('memberFocusX', 'memberFocusY', 'memberPreviewUrl');
            this.openTeamModal = true;
        },

        editService(s) {
            this.editingServiceId = s.id;
            this.serviceTitle = s.title || '';
            this.serviceShortDesc = s.short_description || '';
            this.serviceQuote = s.quote || '';
            this.serviceOrder = s.order || 1;
            this.serviceStatus = s.status?.value || s.status || 'active';
            this.serviceFocusX = Number(s.image_focus_x ?? 50);
            this.serviceFocusY = Number(s.image_focus_y ?? 50);
            this.servicePreviewUrl = s.image_url || '';
            this.openServiceModal = true;
        },

        newService() {
            this.editingServiceId = null;
            this.serviceTitle = '';
            this.serviceShortDesc = '';
            this.serviceQuote = '';
            this.serviceOrder = {{ $nextServiceOrder }};
            this.serviceStatus = 'active';
            this.resetImageFocus('serviceFocusX', 'serviceFocusY', 'servicePreviewUrl');
            this.openServiceModal = true;
        },

        findServiceById(id) {
            return this.servicesList.find((s) => String(s.id) === String(id)) || null;
        },

        editProject(p) {
            this.editingProjectId = p.id;
            this.projectName = p.name || '';
            this.projectCategory = p.category || '';
            this.projectLink = p.link || '';
            this.projectDescription = p.description || '';
            this.projectOrder = p.order || 1;
            this.projectStatus = p.status?.value || p.status || 'active';
            this.projectFocusX = Number(p.image_focus_x ?? 50);
            this.projectFocusY = Number(p.image_focus_y ?? 50);
            this.projectPreviewUrl = p.image_url || '';
            this.openProjectModal = true;
        },

        newProject() {
            this.editingProjectId = null;
            this.projectName = '';
            this.projectCategory = '';
            this.projectLink = '';
            this.projectDescription = '';
            this.projectOrder = {{ $nextProjectOrder }};
            this.projectStatus = 'active';
            this.resetImageFocus('projectFocusX', 'projectFocusY', 'projectPreviewUrl');
            this.openProjectModal = true;
        },

        findProjectById(id) {
            return this.projectsList.find((p) => String(p.id) === String(id)) || null;
        },

        editClient(c) {
            this.editingClientId = c.id;
            this.clientName = c.name || '';
            this.clientType = c.type?.value || c.type || 'client';
            this.clientLink = c.link || '';
            this.clientOrder = c.order || 1;
            this.clientStatus = c.status?.value || c.status || 'active';
            this.openClientModal = true;
        },

        newClient() {
            this.editingClientId = null;
            this.clientName = '';
            this.clientType = 'client';
            this.clientLink = '';
            this.clientOrder = {{ $nextClientOrder }};
            this.clientStatus = 'active';
            this.openClientModal = true;
        },

        findClientById(id) {
            return this.clientsList.find((c) => String(c.id) === String(id)) || null;
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
            if (window.AdminPreview) {
                window.AdminPreview.post(payload);
            }
        },

        focusPreviewSection(section, field) {
            if (window.AdminPreview) {
                window.AdminPreview.focusPreviewSection(section || this.activeSection, field || null);
            }
        },

        pushField(section, field, value) {
            if (window.AdminPreview) {
                window.AdminPreview.pushField(section, field, value);
            }
        },

        selectSection(section, options) {
            options = options || {};
            if (!section) return;
            this.activeSection = section;
            this.$nextTick(() => {
                this.focusPreviewSection(section, options.field || null);
                const form = document.getElementById('admin-form-' + section);
                if (form) {
                    form.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                    if (options.field) {
                        let input = form.querySelector('[name="' + options.field + '"]');
                        if (!input && /^point_\d+$/.test(options.field)) {
                            const idx = options.field.replace('point_', '');
                            input = form.querySelector('#about-point-' + idx + '-title')
                                || form.querySelector('[name="points[' + idx + '][title]"]');
                            const card = form.querySelector('#about-point-' + idx);
                            if (card) {
                                card.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            }
                        }
                        if (!input && /^service_\d+$/.test(options.field)) {
                            const id = options.field.replace('service_', '');
                            const card = form.querySelector('#service-' + id);
                            if (card) {
                                card.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            }
                            const svc = this.findServiceById(id);
                            if (svc) {
                                this.editService(svc);
                            }
                        }
                        if (!input && /^project_\d+$/.test(options.field)) {
                            const id = options.field.replace('project_', '');
                            const card = form.querySelector('#project-' + id);
                            if (card) {
                                card.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            }
                            const project = this.findProjectById(id);
                            if (project) {
                                this.editProject(project);
                            }
                        }
                        if (!input && /^client_\d+$/.test(options.field)) {
                            const id = options.field.replace('client_', '');
                            const card = form.querySelector('#client-' + id);
                            if (card) {
                                card.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            }
                            const client = this.findClientById(id);
                            if (client) {
                                this.editClient(client);
                            }
                        }
                        if (!input && /^stat_\d+$/.test(options.field)) {
                            const idx = options.field.replace('stat_', '');
                            input = form.querySelector('#stat-' + idx + '-value')
                                || form.querySelector('[name="items[' + idx + '][value]"]');
                            const card = form.querySelector('#stat-' + idx);
                            if (card) {
                                card.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            }
                        }
                        if (input) {
                            input.focus();
                            input.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                    }
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
                this.aboutPoints.forEach((point, index) => {
                    this.pushField('about', 'point-' + index + '-title', point.title || '');
                    this.pushField('about', 'point-' + index + '-description', point.description || '');
                });
            }
            if (this.activeSection === 'services') {
                this.pushField('services', 'eyebrow', this.servicesEyebrow);
                this.pushField('services', 'title', this.servicesTitle);
                this.pushField('services', 'description', this.servicesDescription);
            }
            if (this.activeSection === 'stats') {
                this.pushField('stats', 'eyebrow', this.statsEyebrow);
                this.pushField('stats', 'title', this.statsTitle);
                this.statsItems.forEach((stat, index) => {
                    this.pushField('stats', 'stat-' + index + '-value', stat.value || '');
                    this.pushField('stats', 'stat-' + index + '-label', stat.label || '');
                });
            }
            if (this.activeSection === 'portfolio') {
                this.pushField('portfolio', 'eyebrow', this.portfolioEyebrow);
                this.pushField('portfolio', 'title', this.portfolioTitle);
            }
            if (this.activeSection === 'clients') {
                this.pushField('clients', 'eyebrow', this.clientsEyebrow);
                this.pushField('clients', 'title', this.clientsTitle);
                this.pushField('clients', 'description', this.clientsDescription);
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
            if (this.activeSection === 'creator') {
                this.pushField('creator', 'label', this.creatorLabel);
                this.pushField('creator', 'name', this.creatorName);
                this.pushField('creator', 'line', this.creatorLine);
                this.pushField('creator', 'cta_text', this.creatorCtaText);
                this.syncCreatorVisibility();
            }
        },

        syncCreatorVisibility() {
            const doc = this.previewDoc();
            if (!doc) return;
            const bar = doc.querySelector('.hz-creator-bar');
            if (!bar) return;
            bar.classList.toggle('is-creator-off', !this.creatorVisible);
        },

        wirePreviewInteractions() {
            this.previewReady = true;
            this.syncCreatorVisibility();
            this.syncActiveSectionToPreview();
        },

        onPreviewLoad() {
            if (this.$refs.previewFrame && window.AdminPreview) {
                window.AdminPreview.registerFrame(this.$refs.previewFrame);
            }
            setTimeout(() => this.wirePreviewInteractions(), 50);
            setTimeout(() => this.wirePreviewInteractions(), 300);
            if (window.AdminPreview) {
                window.AdminPreview.onFrameLoad();
            }
        },

        init() {
            if (window.AdminPreview) {
                window.AdminPreview.handlers.onSectionClick = (section, field) => {
                    this.selectSection(section, { fromPreview: true, field: field || null });
                };
            }

            const rawHash = window.location.hash.replace('#', '');
            const hash = rawHash.split('?')[0];
            let field = new URLSearchParams(window.location.search).get('field');
            if (!field && rawHash.includes('?')) {
                field = new URLSearchParams(rawHash.split('?')[1] || '').get('field');
            }
            if (hash.startsWith('admin-form-')) {
                const section = hash.replace('admin-form-', '');
                this.$nextTick(() => this.selectSection(section, { field: field }));
            }

            window.addEventListener('message', (event) => {
                const data = event.data || {};
                if (data.source !== 'admin-home-preview') return;

                if (data.type === 'ready') {
                    this.previewReady = true;
                    this.wirePreviewInteractions();
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
            this.$watch('aboutPoints', () => {
                this.aboutPoints.forEach((point, index) => {
                    this.pushField('about', 'point-' + index + '-title', point.title || '');
                    this.pushField('about', 'point-' + index + '-description', point.description || '');
                });
            }, { deep: true });
            this.$watch('servicesEyebrow', (v) => this.pushField('services', 'eyebrow', v));
            this.$watch('servicesTitle', (v) => this.pushField('services', 'title', v));
            this.$watch('servicesDescription', (v) => this.pushField('services', 'description', v));
            this.$watch('statsEyebrow', (v) => this.pushField('stats', 'eyebrow', v));
            this.$watch('statsTitle', (v) => this.pushField('stats', 'title', v));
            this.$watch('statsItems', () => {
                this.statsItems.forEach((stat, index) => {
                    this.pushField('stats', 'stat-' + index + '-value', stat.value || '');
                    this.pushField('stats', 'stat-' + index + '-label', stat.label || '');
                });
            }, { deep: true });
            this.$watch('portfolioEyebrow', (v) => this.pushField('portfolio', 'eyebrow', v));
            this.$watch('portfolioTitle', (v) => this.pushField('portfolio', 'title', v));
            this.$watch('clientsEyebrow', (v) => this.pushField('clients', 'eyebrow', v));
            this.$watch('clientsTitle', (v) => this.pushField('clients', 'title', v));
            this.$watch('clientsDescription', (v) => this.pushField('clients', 'description', v));
            this.$watch('teamEyebrow', (v) => this.pushField('team', 'eyebrow', v));
            this.$watch('teamTitle', (v) => this.pushField('team', 'title', v));
            this.$watch('teamDescription', (v) => this.pushField('team', 'description', v));
            this.$watch('ctaTitle', (v) => this.pushField('cta', 'title', v));
            this.$watch('ctaButtonText', (v) => this.pushField('cta', 'button_text', v));
            this.$watch('creatorLabel', (v) => this.pushField('creator', 'label', v));
            this.$watch('creatorName', (v) => this.pushField('creator', 'name', v));
            this.$watch('creatorLine', (v) => this.pushField('creator', 'line', v));
            this.$watch('creatorCtaText', (v) => {
                this.pushField('creator', 'cta_text', v);
                const doc = this.previewDoc();
                if (!doc) return;
                const link = doc.querySelector('.hz-creator-bar-link');
                if (link) link.style.display = v ? '' : 'none';
            });
            this.$watch('creatorVisible', () => this.syncCreatorVisibility());
        },
    }));
});
</script>
@endpush
