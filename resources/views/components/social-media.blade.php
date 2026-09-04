@if(isset($socialRefs) && $socialRefs->isNotEmpty())
    @php $adminPreview = request()->boolean('admin_preview'); @endphp
    <div class="d-inline-flex flex-wrap align-items-center gap-2">
        @foreach ($socialRefs as $ref)
            @php
                $link = trim($ref->link ?? '');
                if (empty($link)) continue;

                $icon = trim($ref->icon_class ?? '');
                $title = $ref->title ?? 'Social Media';

                // Map legacy FontAwesome classes to Bootstrap Icons if needed
                if (str_contains($icon, 'fa-facebook') || str_contains($icon, 'facebook')) {
                    $icon = 'bi bi-facebook';
                } elseif (str_contains($icon, 'fa-linkedin') || str_contains($icon, 'linkedin')) {
                    $icon = 'bi bi-linkedin';
                } elseif (str_contains($icon, 'fa-x-twitter') || str_contains($icon, 'twitter') || str_contains($icon, 'fa-twitter')) {
                    $icon = 'bi bi-twitter-x';
                } elseif (str_contains($icon, 'fa-github') || str_contains($icon, 'github')) {
                    $icon = 'bi bi-github';
                } elseif (str_contains($icon, 'fa-telegram') || str_contains($icon, 'telegram')) {
                    $icon = 'bi bi-telegram';
                } elseif (str_contains($icon, 'fa-whatsapp') || str_contains($icon, 'whatsapp')) {
                    $icon = 'bi bi-whatsapp';
                } elseif (str_contains($icon, 'fa-envelope') || str_contains($icon, 'envelope') || str_starts_with($link, 'mailto:')) {
                    $icon = 'bi bi-envelope-fill';
                } elseif (str_contains($icon, 'fa-globe') || str_contains($icon, 'globe')) {
                    $icon = 'bi bi-globe';
                } elseif (str_contains($icon, 'fa-youtube') || str_contains($icon, 'youtube')) {
                    $icon = 'bi bi-youtube';
                } elseif (str_contains($icon, 'fa-instagram') || str_contains($icon, 'instagram')) {
                    $icon = 'bi bi-instagram';
                } elseif (!str_starts_with($icon, 'bi ') && !str_starts_with($icon, 'fa')) {
                    $icon = 'bi bi-link-45deg';
                }
            @endphp
            <a href="{{ $link }}" target="_blank" rel="noopener noreferrer" title="{{ $title }}" aria-label="{{ $title }}" class="hz-social-btn"
                @if($adminPreview)
                    data-admin-section="site-social"
                    data-admin-compact="1"
                    data-admin-label="Edit Social"
                    data-admin-edit-url="{{ \App\Support\AdminEditUrls::siteSettings('social') }}"
                @endif
            >
                <i class="{{ $icon }}"></i>
            </a>
        @endforeach
    </div>
@endif
