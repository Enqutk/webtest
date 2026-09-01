<div
    x-data="{
        viewMode: 'desktop',
        previewTheme: 'light',
        
        get title() { 
            return $wire.data?.title?.trim() || 'Company Name'; 
        },
        get showBrandText() { 
            return $wire.data?.theme?.show_brand_text !== false && $wire.data?.theme?.show_brand_text !== '0'; 
        },
        get brandFont() { 
            return $wire.data?.theme?.brand_font_family || $wire.data?.theme?.font_display || 'Fraunces'; 
        },
        get brandSize() { 
            let s = $wire.data?.theme?.brand_font_size;
            return s ? (s.match(/^[0-9]+$/) ? s + 'px' : s) : '1.45rem'; 
        },
        get brandWeight() { 
            return $wire.data?.theme?.brand_font_weight || '700'; 
        },
        get brandColor() { 
            return $wire.data?.theme?.brand_color || (this.previewTheme === 'dark' ? '#ffffff' : ($wire.data?.theme?.ink || '#10211f')); 
        },
        get brandSpacing() { 
            return $wire.data?.theme?.brand_letter_spacing || '-0.03em'; 
        },

        get tagline() { 
            return $wire.data?.tagline?.trim() || 'Engineering high-quality infrastructure for community impact.'; 
        },
        get showTagline() { 
            return $wire.data?.theme?.show_tagline !== false && $wire.data?.theme?.show_tagline !== '0'; 
        },
        get taglineFont() { 
            return $wire.data?.theme?.tagline_font_family || $wire.data?.theme?.font_body || 'Outfit'; 
        },
        get taglineSize() { 
            let s = $wire.data?.theme?.tagline_font_size;
            return s ? (s.match(/^[0-9]+$/) ? s + 'px' : s) : '0.95rem'; 
        },
        get taglineStyle() { 
            return $wire.data?.theme?.tagline_font_style || 'normal'; 
        },
        get taglineWeight() { 
            return $wire.data?.theme?.tagline_font_weight || '400'; 
        },
        get taglineColor() { 
            return $wire.data?.theme?.tagline_color || (this.previewTheme === 'dark' ? '#94a3b8' : ($wire.data?.theme?.muted || '#5a6b68')); 
        },

        get navFont() { 
            return $wire.data?.theme?.nav_font_family || $wire.data?.theme?.font_body || 'Outfit'; 
        },
        get navSize() { 
            let s = $wire.data?.theme?.nav_font_size;
            return s ? (s.match(/^[0-9]+$/) ? s + 'px' : s) : '0.95rem'; 
        },
        get navWeight() { 
            return $wire.data?.theme?.nav_font_weight || '500'; 
        },
        get navColor() { 
            return $wire.data?.theme?.nav_color || (this.previewTheme === 'dark' ? '#e2e8f0' : ($wire.data?.theme?.ink || '#10211f')); 
        },
        get navSpacing() { 
            return $wire.data?.theme?.nav_spacing || '0.55rem 0.9rem'; 
        },

        get showHeaderCta() { 
            return $wire.data?.theme?.show_header_cta !== false && $wire.data?.theme?.show_header_cta !== '0'; 
        },
        get ctaText() { 
            return $wire.data?.theme?.header_cta_text?.trim() || 'Get in touch'; 
        },
        get ctaSize() { 
            let s = $wire.data?.theme?.header_cta_font_size;
            return s ? (s.match(/^[0-9]+$/) ? s + 'px' : s) : '0.88rem'; 
        },
        get ctaBg() { 
            return $wire.data?.theme?.header_cta_bg || $wire.data?.theme?.accent || '#0f766e'; 
        },
        get ctaColor() { 
            return $wire.data?.theme?.header_cta_text_color || '#ffffff'; 
        },

        get poBox() { 
            return $wire.data?.po_box?.trim() || '12345 - 00100'; 
        },
        get showPoBox() { 
            return $wire.data?.theme?.show_po_box !== false && $wire.data?.theme?.show_po_box !== '0'; 
        },
        get poboxSize() { 
            let s = $wire.data?.theme?.pobox_font_size;
            return s ? (s.match(/^[0-9]+$/) ? s + 'px' : s) : '0.875rem'; 
        },
        get poboxColor() { 
            return $wire.data?.theme?.pobox_color || (this.previewTheme === 'dark' ? '#94a3b8' : ($wire.data?.theme?.muted || '#5a6b68')); 
        },

        get address() { 
            return $wire.data?.address?.trim() || 'Riverside Business Plaza, 4th Floor, Suite 402'; 
        },
        get showAddress() { 
            return $wire.data?.theme?.show_address !== false && $wire.data?.theme?.show_address !== '0'; 
        },
        get addressSize() { 
            let s = $wire.data?.theme?.address_font_size;
            return s ? (s.match(/^[0-9]+$/) ? s + 'px' : s) : '0.95rem'; 
        },
        get addressColor() { 
            return $wire.data?.theme?.address_color || (this.previewTheme === 'dark' ? '#e2e8f0' : ($wire.data?.theme?.ink || '#10211f')); 
        },

        get accentColor() { 
            return $wire.data?.theme?.accent || '#0f766e'; 
        },
        get containerBg() {
            if (this.previewTheme === 'dark') return '#0a1615';
            return $wire.data?.theme?.bg || '#f3f6f5';
        },
        get headerBg() {
            if (this.previewTheme === 'dark') return '#112220';
            return $wire.data?.theme?.surface || '#ffffff';
        },
        get borderColor() {
            if (this.previewTheme === 'dark') return 'rgba(255,255,255,0.1)';
            return $wire.data?.theme?.line || '#d7e0dd';
        },

        loadGoogleFont(font) {
            if (!font) return;
            const fontName = font.trim();
            const id = 'gf-' + fontName.replace(/\s+/g, '-').toLowerCase();
            if (!document.getElementById(id)) {
                const link = document.createElement('link');
                link.id = id;
                link.rel = 'stylesheet';
                link.href = 'https://fonts.googleapis.com/css2?family=' + fontName.replace(/\s+/g, '+') + ':ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap';
                document.head.appendChild(link);
            }
        },

        init() {
            this.$watch('$wire.data.theme.brand_font_family', f => this.loadGoogleFont(f));
            this.$watch('$wire.data.theme.tagline_font_family', f => this.loadGoogleFont(f));
            this.$watch('$wire.data.theme.nav_font_family', f => this.loadGoogleFont(f));
            this.$watch('$wire.data.theme.font_display', f => this.loadGoogleFont(f));
            this.$watch('$wire.data.theme.font_body', f => this.loadGoogleFont(f));

            this.loadGoogleFont(this.brandFont);
            this.loadGoogleFont(this.taglineFont);
            this.loadGoogleFont(this.navFont);
        }
    }"
    class="w-full select-none"
>
    <!-- Live Preview Card Container -->
    <div class="rounded-2xl border border-gray-200/80 dark:border-gray-800 bg-white dark:bg-gray-900 shadow-xl shadow-gray-200/50 dark:shadow-none overflow-hidden transition-all duration-300">
        
        <!-- Control Toolbar / Device Switcher -->
        <div class="px-4 py-3 bg-gradient-to-r from-gray-50 via-gray-100 to-gray-50 dark:from-gray-800 dark:via-gray-850 dark:to-gray-800 border-b border-gray-200 dark:border-gray-700/80 flex flex-wrap items-center justify-between gap-3">
            
            <!-- Window mock buttons & title -->
            <div class="flex items-center gap-3">
                <div class="flex items-center space-x-1.5">
                    <span class="w-3 h-3 rounded-full bg-red-400/90 shadow-sm inline-block"></span>
                    <span class="w-3 h-3 rounded-full bg-amber-400/90 shadow-sm inline-block"></span>
                    <span class="w-3 h-3 rounded-full bg-emerald-400/90 shadow-sm inline-block"></span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold text-gray-700 dark:text-gray-200 tracking-wide uppercase">Interactive Live Preview</span>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300 border border-emerald-300/40">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse mr-1"></span> Real-time
                    </span>
                </div>
            </div>

            <!-- Viewport & Theme Switchers -->
            <div class="flex items-center gap-2">
                <!-- Device buttons -->
                <div class="flex items-center bg-gray-200/80 dark:bg-gray-700/80 p-0.5 rounded-lg text-xs">
                    <button
                        type="button"
                        @click="viewMode = 'desktop'"
                        :class="viewMode === 'desktop' ? 'bg-white dark:bg-gray-900 text-teal-600 dark:text-teal-400 shadow-sm font-semibold' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900'"
                        class="px-2.5 py-1 rounded-md transition-all flex items-center gap-1.5"
                    >
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <span>Desktop</span>
                    </button>
                    <button
                        type="button"
                        @click="viewMode = 'tablet'"
                        :class="viewMode === 'tablet' ? 'bg-white dark:bg-gray-900 text-teal-600 dark:text-teal-400 shadow-sm font-semibold' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900'"
                        class="px-2.5 py-1 rounded-md transition-all flex items-center gap-1.5"
                    >
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        <span>Tablet</span>
                    </button>
                    <button
                        type="button"
                        @click="viewMode = 'mobile'"
                        :class="viewMode === 'mobile' ? 'bg-white dark:bg-gray-900 text-teal-600 dark:text-teal-400 shadow-sm font-semibold' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900'"
                        class="px-2.5 py-1 rounded-md transition-all flex items-center gap-1.5"
                    >
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        <span>Mobile</span>
                    </button>
                </div>

                <!-- Theme Toggle -->
                <div class="flex items-center bg-gray-200/80 dark:bg-gray-700/80 p-0.5 rounded-lg text-xs">
                    <button
                        type="button"
                        @click="previewTheme = 'light'"
                        :class="previewTheme === 'light' ? 'bg-white dark:bg-gray-900 text-amber-600 shadow-sm font-semibold' : 'text-gray-600 dark:text-gray-400'"
                        class="px-2 py-1 rounded-md transition-all flex items-center"
                        title="Light Theme"
                    >
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </button>
                    <button
                        type="button"
                        @click="previewTheme = 'dark'"
                        :class="previewTheme === 'dark' ? 'bg-white dark:bg-gray-900 text-indigo-400 shadow-sm font-semibold' : 'text-gray-600 dark:text-gray-400'"
                        class="px-2 py-1 rounded-md transition-all flex items-center"
                        title="Dark Theme"
                    >
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Preview Viewport Frame -->
        <div class="p-4 md:p-6 flex justify-center bg-gray-100/70 dark:bg-gray-950/80 transition-all duration-300 min-h-[220px]">
            <div
                :style="{
                    width: viewMode === 'desktop' ? '100%' : (viewMode === 'tablet' ? '768px' : '390px'),
                    background: containerBg,
                    borderColor: borderColor
                }"
                class="rounded-xl border shadow-md transition-all duration-300 overflow-hidden"
            >
                <!-- Simulated Website Navigation Header -->
                <div
                    :style="{
                        background: headerBg,
                        borderBottomColor: borderColor
                    }"
                    class="px-4 sm:px-6 py-3.5 border-b flex items-center justify-between gap-4 transition-all duration-200"
                >
                    <!-- Brand Section -->
                    <div class="flex items-center gap-2.5 shrink-0">
                        <template x-if="showBrandText">
                            <span
                                x-text="title"
                                :style="{
                                    fontFamily: `'${brandFont}', sans-serif`,
                                    fontSize: brandSize,
                                    fontWeight: brandWeight,
                                    color: brandColor,
                                    letterSpacing: brandSpacing,
                                    lineHeight: '1.2'
                                }"
                                class="transition-all duration-150 inline-block"
                            ></span>
                        </template>
                        <template x-if="!showBrandText">
                            <span class="text-xs italic text-gray-400 dark:text-gray-500 py-1 px-2 rounded bg-gray-100 dark:bg-gray-800 border border-dashed border-gray-300 dark:border-gray-700">
                                🚫 Brand Text Hidden
                            </span>
                        </template>
                    </div>

                    <!-- Navigation Menu (Desktop & Tablet) -->
                    <template x-if="viewMode !== 'mobile'">
                        <nav class="flex items-center gap-1">
                            <template x-for="(link, i) in ['Home', 'About Us', 'Services', 'Contact Us']" :key="link">
                                <span
                                    x-text="link"
                                    :style="{
                                        fontFamily: `'${navFont}', sans-serif`,
                                        fontSize: navSize,
                                        fontWeight: navWeight,
                                        color: i === 0 ? accentColor : navColor,
                                        padding: navSpacing,
                                        borderBottom: i === 0 ? `2px solid ${accentColor}` : '2px solid transparent'
                                    }"
                                    class="transition-all duration-150 cursor-pointer hover:opacity-80 inline-block font-medium"
                                ></span>
                            </template>
                        </nav>
                    </template>

                    <!-- Mobile Hamburger (Mobile View) -->
                    <template x-if="viewMode === 'mobile'">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded border border-gray-300 dark:border-gray-600 flex flex-col justify-center items-center gap-1 p-1.5 cursor-pointer">
                                <span class="w-full h-0.5 bg-gray-700 dark:bg-gray-300 rounded-full"></span>
                                <span class="w-full h-0.5 bg-gray-700 dark:bg-gray-300 rounded-full"></span>
                                <span class="w-full h-0.5 bg-gray-700 dark:bg-gray-300 rounded-full"></span>
                            </div>
                        </div>
                    </template>

                    <!-- CTA Button -->
                    <div class="shrink-0" :class="viewMode === 'mobile' ? 'hidden sm:block' : 'block'">
                        <template x-if="showHeaderCta">
                            <span
                                x-text="ctaText"
                                :style="{
                                    fontFamily: `'${navFont}', sans-serif`,
                                    fontSize: ctaSize,
                                    backgroundColor: ctaBg,
                                    color: ctaColor,
                                    boxShadow: `0 2px 8px ${ctaBg}33`
                                }"
                                class="inline-flex items-center gap-1.5 px-4 py-2 rounded-md font-semibold transition-all duration-150 transform hover:-translate-y-0.5 cursor-pointer"
                            ></span>
                        </template>
                        <template x-if="!showHeaderCta">
                            <span class="text-xs italic text-gray-400 dark:text-gray-500 py-1 px-2 rounded bg-gray-100 dark:bg-gray-800 border border-dashed border-gray-300 dark:border-gray-700">
                                🚫 CTA Hidden
                            </span>
                        </template>
                    </div>
                </div>

                <!-- Simulated Sub-Banner / Information Strip -->
                <div class="px-4 sm:px-6 py-5 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 transition-all duration-200">
                    <!-- Tagline -->
                    <div class="max-w-md">
                        <template x-if="showTagline">
                            <p
                                x-text="tagline"
                                :style="{
                                    fontFamily: `'${taglineFont}', sans-serif`,
                                    fontSize: taglineSize,
                                    fontStyle: taglineStyle,
                                    fontWeight: taglineWeight,
                                    color: taglineColor,
                                    lineHeight: '1.45'
                                }"
                                class="m-0 transition-all duration-150"
                            ></p>
                        </template>
                        <template x-if="!showTagline">
                            <span class="text-xs italic text-gray-400 dark:text-gray-500 py-1 px-2 rounded bg-gray-100 dark:bg-gray-800 border border-dashed border-gray-300 dark:border-gray-700">
                                🚫 Tagline Hidden
                            </span>
                        </template>
                    </div>

                    <!-- Contact & PO Box Pill Badges -->
                    <div class="flex flex-wrap items-center gap-3">
                        <template x-if="showAddress">
                            <div
                                :style="{
                                    fontSize: addressSize,
                                    color: addressColor
                                }"
                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-black/5 dark:bg-white/5 transition-all duration-150"
                            >
                                <svg class="w-3.5 h-3.5 opacity-70 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <span x-text="address" class="truncate max-w-[200px]"></span>
                            </div>
                        </template>

                        <template x-if="showPoBox">
                            <div
                                :style="{
                                    fontSize: poboxSize,
                                    color: poboxColor
                                }"
                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-black/5 dark:bg-white/5 transition-all duration-150"
                            >
                                <svg class="w-3.5 h-3.5 opacity-70 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                <span>P.O. Box: <strong x-text="poBox"></strong></span>
                            </div>
                        </template>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
