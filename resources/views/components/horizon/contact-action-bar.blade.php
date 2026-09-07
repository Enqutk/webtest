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
                            data-hz-save-contact='@json($actions['vcard'])'
                            aria-label="Save contact">
                        <i class="bi bi-person-plus-fill" aria-hidden="true"></i>
                    </button>
                </div>
            @endif
        </div>
    </div>

    @once
        @push('scripts')
            <script>
                document.addEventListener('click', function (event) {
                    const button = event.target.closest('[data-hz-save-contact]');
                    if (!button) {
                        return;
                    }

                    let contact;
                    try {
                        contact = JSON.parse(button.dataset.hzSaveContact || '{}');
                    } catch (error) {
                        return;
                    }

                    const escapeVcard = (value) => String(value || '')
                        .replace(/\\/g, '\\\\')
                        .replace(/;/g, '\\;')
                        .replace(/,/g, '\\,')
                        .replace(/\n/g, '\\n');

                    const lines = [
                        'BEGIN:VCARD',
                        'VERSION:3.0',
                        'FN:' + escapeVcard(contact.name),
                        contact.org ? 'ORG:' + escapeVcard(contact.org) : null,
                        contact.role ? 'TITLE:' + escapeVcard(contact.role) : null,
                        contact.phone ? 'TEL;TYPE=CELL:' + escapeVcard(contact.phone) : null,
                        contact.email ? 'EMAIL;TYPE=INTERNET:' + escapeVcard(contact.email) : null,
                        contact.url ? 'URL:' + escapeVcard(contact.url) : null,
                        'END:VCARD',
                    ].filter(Boolean);

                    const blob = new Blob([lines.join('\r\n')], { type: 'text/vcard;charset=utf-8' });
                    const url = URL.createObjectURL(blob);
                    const link = document.createElement('a');
                    link.href = url;
                    link.download = (contact.filename || 'contact') + '.vcf';
                    document.body.appendChild(link);
                    link.click();
                    link.remove();
                    URL.revokeObjectURL(url);
                });
            </script>
        @endpush
    @endonce
@endif
