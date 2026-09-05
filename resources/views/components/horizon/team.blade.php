@props([
    'team' => collect(),
    'showBios' => false,
    'eyebrow' => 'Our people',
    'title' => 'The team behind the work',
    'description' => null,
    'ctaText' => null,
    'ctaUrl' => null,
])

@if($team->isNotEmpty())
<section class="hz-section hz-team" id="team">
    <div class="container">
        <div class="row justify-content-between align-items-end mb-4 g-3">
            <div class="col-lg-7">
                <p class="hz-eyebrow" data-preview-field="eyebrow" {!! \App\Support\AdminPreviewAttrs::html('team', 'eyebrow', 'Edit Eyebrow') !!}>{{ $eyebrow }}</p>
                <h2 class="hz-title mb-0" data-preview-field="title" {!! \App\Support\AdminPreviewAttrs::html('team', 'title', 'Edit Title') !!}>{{ $title }}</h2>
                @if($description)
                    <p class="hz-lead text-muted mt-2 mb-0" data-preview-field="description" {!! \App\Support\AdminPreviewAttrs::html('team', 'description', 'Edit Description') !!}>{{ $description }}</p>
                @else
                    <p class="hz-lead text-muted mt-2 mb-0" data-preview-field="description" style="display:none"></p>
                @endif
            </div>
            @if($ctaText)
                <div class="col-lg-auto">
                    <a href="{{ $ctaUrl ?: route('about') . '#team' }}" class="btn-hz-outline">{{ $ctaText }}</a>
                </div>
            @endif
        </div>

        <div class="row g-4">
            @foreach($team as $member)
                @php
                    $photo = $member->getFirstMediaUrl('team-images');
                    $initials = collect(explode(' ', $member->full_name))
                        ->filter()
                        ->map(fn ($part) => mb_strtoupper(mb_substr($part, 0, 1)))
                        ->take(2)
                        ->implode('');
                @endphp
                <div class="col-6 col-lg-3">
                    <article class="hz-team-card">
                        <div class="hz-team-photo">
                            @if($photo)
                                <x-horizon.focused-image
                                    :src="$photo"
                                    :alt="$member->full_name"
                                    :focus-x="$member->image_focus_x ?? 50"
                                    :focus-y="$member->image_focus_y ?? 50"
                                />
                            @else
                                <div class="hz-team-initials" aria-hidden="true">{{ $initials }}</div>
                            @endif
                            @if($member->founder)
                                <span class="hz-team-badge">Founder</span>
                            @endif
                        </div>
                        <h3 class="h5 mb-1">{{ $member->full_name }}</h3>
                        <div class="hz-team-role">{{ $member->title }}</div>
                        @if($showBios && $member->description)
                            <p class="hz-team-bio">{{ $member->description }}</p>
                        @endif
                    </article>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
