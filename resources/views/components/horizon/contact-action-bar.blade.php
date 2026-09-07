@php
    $actions = $data['contactActions'] ?? null;
@endphp

@if(! empty($actions['show']))
    <div class="hz-contact-fab" data-hz-contact-fab role="group" aria-label="Contact {{ $data['siteName'] ?? 'profile' }}">
        <div class="hz-contact-fab__actions">
            @if(! empty($actions['tel']))
                <div class="hz-contact-fab__row">
                    <span class="hz-contact-fab__label">Call</span>
                    <a href="{{ $actions['tel'] }}"
                       class="hz-contact-fab__btn hz-contact-fab__btn--call"
                       aria-label="Call">
                        <i class="bi bi-telephone-fill" aria-hidden="true"></i>
                    </a>
                </div>
            @endif

            @if(! empty($actions['whatsapp']))
                <div class="hz-contact-fab__row">
                    <span class="hz-contact-fab__label">WhatsApp</span>
                    <a href="{{ $actions['whatsapp'] }}"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="hz-contact-fab__btn hz-contact-fab__btn--whatsapp"
                       aria-label="WhatsApp">
                        <i class="bi bi-whatsapp" aria-hidden="true"></i>
                    </a>
                </div>
            @endif

            @if(! empty($actions['canSave']))
                <div class="hz-contact-fab__row">
                    <span class="hz-contact-fab__label">Save contact</span>
                    <button type="button"
                            class="hz-contact-fab__btn hz-contact-fab__btn--save"
                            data-hz-open-contact-sheet='@json($actions['vcard'])'
                            aria-label="Save contact">
                        <i class="bi bi-person-plus-fill" aria-hidden="true"></i>
                    </button>
                </div>
            @endif
        </div>
    </div>

    <div class="hz-contact-sheet" data-hz-contact-sheet hidden aria-hidden="true">
        <button type="button" class="hz-contact-sheet__backdrop" data-hz-contact-sheet-close aria-label="Close"></button>

        <div class="hz-contact-sheet__panel" role="dialog" aria-modal="true" aria-labelledby="hz-contact-sheet-title">
            <div class="hz-contact-sheet__handle" aria-hidden="true"></div>

            <button type="button" class="hz-contact-sheet__close" data-hz-contact-sheet-close aria-label="Close">
                <i class="bi bi-x-lg" aria-hidden="true"></i>
            </button>

            <div class="hz-contact-sheet__card">
                <div class="hz-contact-sheet__avatar" data-hz-sheet-photo hidden>
                    <img src="" alt="" data-hz-sheet-photo-img>
                </div>
                <div class="hz-contact-sheet__avatar hz-contact-sheet__avatar--fallback" data-hz-sheet-initials hidden></div>

                <p class="hz-contact-sheet__eyebrow">New contact</p>
                <h2 class="hz-contact-sheet__name" id="hz-contact-sheet-title" data-hz-sheet-name></h2>
                <p class="hz-contact-sheet__role" data-hz-sheet-role hidden></p>

                <div class="hz-contact-sheet__fields">
                    <div class="hz-contact-sheet__field" data-hz-sheet-phone-row hidden>
                        <span class="hz-contact-sheet__field-label">Mobile</span>
                        <span class="hz-contact-sheet__field-value" data-hz-sheet-phone></span>
                    </div>
                    <div class="hz-contact-sheet__field" data-hz-sheet-email-row hidden>
                        <span class="hz-contact-sheet__field-label">Email</span>
                        <span class="hz-contact-sheet__field-value" data-hz-sheet-email></span>
                    </div>
                    <div class="hz-contact-sheet__field" data-hz-sheet-url-row hidden>
                        <span class="hz-contact-sheet__field-label">Website</span>
                        <span class="hz-contact-sheet__field-value" data-hz-sheet-url></span>
                    </div>
                </div>
            </div>

            <a href="{{ $actions['vcardUrl'] }}"
               class="hz-contact-sheet__primary"
               data-hz-contact-sheet-save>
                <i class="bi bi-person-plus-fill" aria-hidden="true"></i>
                Add to Contacts
            </a>
            <p class="hz-contact-sheet__hint">Opens your phone’s Add Contact screen. Tap Create to save.</p>
        </div>
    </div>

    @once
        @push('scripts')
            <script>
                (function () {
                    const sheet = document.querySelector('[data-hz-contact-sheet]');
                    if (!sheet) {
                        return;
                    }

                    const saveButton = sheet.querySelector('[data-hz-contact-sheet-save]');

                    const initialsFromName = (name) => {
                        const parts = String(name || '').trim().split(/\s+/).filter(Boolean);
                        if (!parts.length) {
                            return '?';
                        }
                        if (parts.length === 1) {
                            return parts[0].slice(0, 2).toUpperCase();
                        }
                        return (parts[0][0] + parts[parts.length - 1][0]).toUpperCase();
                    };

                    const setRow = (row, valueEl, value) => {
                        if (!row || !valueEl) {
                            return;
                        }
                        const hasValue = Boolean(value);
                        row.hidden = !hasValue;
                        valueEl.textContent = value || '';
                    };

                    const openSheet = (contact) => {
                        sheet.querySelector('[data-hz-sheet-name]').textContent = contact.name || 'Contact';

                        const roleEl = sheet.querySelector('[data-hz-sheet-role]');
                        if (contact.role) {
                            roleEl.textContent = contact.role;
                            roleEl.hidden = false;
                        } else {
                            roleEl.hidden = true;
                        }

                        setRow(
                            sheet.querySelector('[data-hz-sheet-phone-row]'),
                            sheet.querySelector('[data-hz-sheet-phone]'),
                            contact.phone
                        );
                        setRow(
                            sheet.querySelector('[data-hz-sheet-email-row]'),
                            sheet.querySelector('[data-hz-sheet-email]'),
                            contact.email
                        );
                        setRow(
                            sheet.querySelector('[data-hz-sheet-url-row]'),
                            sheet.querySelector('[data-hz-sheet-url]'),
                            contact.url
                        );

                        const photoWrap = sheet.querySelector('[data-hz-sheet-photo]');
                        const photoImg = sheet.querySelector('[data-hz-sheet-photo-img]');
                        const initialsEl = sheet.querySelector('[data-hz-sheet-initials]');

                        if (contact.photo) {
                            photoImg.src = contact.photo;
                            photoImg.alt = contact.name || 'Contact photo';
                            photoWrap.hidden = false;
                            initialsEl.hidden = true;
                        } else {
                            photoWrap.hidden = true;
                            initialsEl.textContent = initialsFromName(contact.name);
                            initialsEl.hidden = false;
                        }

                        sheet.hidden = false;
                        sheet.setAttribute('aria-hidden', 'false');
                        document.body.classList.add('hz-contact-sheet-open');
                        saveButton.focus();
                    };

                    const closeSheet = () => {
                        sheet.hidden = true;
                        sheet.setAttribute('aria-hidden', 'true');
                        document.body.classList.remove('hz-contact-sheet-open');
                    };

                    document.addEventListener('click', (event) => {
                        const openTrigger = event.target.closest('[data-hz-open-contact-sheet]');
                        if (openTrigger) {
                            try {
                                openSheet(JSON.parse(openTrigger.dataset.hzOpenContactSheet || '{}'));
                            } catch (error) {
                                return;
                            }
                            return;
                        }

                        if (event.target.closest('[data-hz-contact-sheet-close]')) {
                            closeSheet();
                        }
                    });

                    document.addEventListener('keydown', (event) => {
                        if (event.key === 'Escape' && !sheet.hidden) {
                            closeSheet();
                        }
                    });
                })();
            </script>
        @endpush
    @endonce
@endif
