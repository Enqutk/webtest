@extends('layouts.inner')

@php
    $contactPage = $data['sitePages']['contact'] ?? [];
@endphp

@section('title', $contactPage['title'] ?? 'Contact Us')
@section('eyebrow', $contactPage['eyebrow'] ?? 'Get in touch')
@section('page_title', $contactPage['title'] ?? 'Contact Us')
@section('description', $contactPage['description'] ?? ('Reach ' . ($data['siteName'] ?? config('app.name')) . ($data['tagline'] ? ' - ' . $data['tagline'] : '')))

@php
    $dayLabels = [
        'mon' => 'Mon', 'tue' => 'Tue', 'wed' => 'Wed', 'thu' => 'Thu',
        'fri' => 'Fri', 'sat' => 'Sat', 'sun' => 'Sun',
    ];
    $recipient = $data['email'][0] ?? config('mail.from.address');
    $routeSlug = request()->route('slug') ?? ($data['routeSlug'] ?? ($data['organization']->slug ?? null));
    $formAction = $routeSlug ? route('card.contact.send', ['slug' => $routeSlug, 'recipient' => $recipient]) : route('contact.send', ['recipient' => $recipient]);
@endphp

@section('page')
@php
    $adminPreview = request()->boolean('admin_preview');
    $contactEditBase = $adminPreview ? route('admin.site-pages.edit', 'contact') : null;
    $hoursPreview = collect($data['working_days'] ?? [])->map(function ($slot) use ($dayLabels) {
        if (!isset($slot['days'], $slot['from'], $slot['to'])) {
            return null;
        }
        $days = collect($slot['days'])->map(fn ($d) => $dayLabels[$d] ?? $d)->implode('–');

        return $days . ': ' . substr($slot['from'], 0, 5) . ' – ' . substr($slot['to'], 0, 5);
    })->filter()->implode("\n");
@endphp
<section class="hz-section hz-contact" id="contact-page">
    <div class="container">
        <div class="row g-4 g-xl-5">
            <div class="col-lg-7">
                <p class="hz-lead mb-4" id="contact-page-intro" data-preview-field="intro" @if($adminPreview) {!! \App\Support\AdminPreviewAttrs::html('contact-page-intro', 'intro', 'Edit Intro', true, $contactEditBase ? $contactEditBase . '#contact-intro' : null) !!} @endif>
                    {{ $contactPage['intro'] ?? $data['tagline'] ?? 'Share a brief about your project. We will respond with next steps.' }}
                </p>

                @if(session('success'))
                    <div class="hz-alert hz-alert-success mb-4" role="status">
                        <i class="bi bi-check-circle"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="hz-alert hz-alert-error mb-4" role="alert">
                        <i class="bi bi-exclamation-circle"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @if($errors->any())
                    <div class="hz-alert hz-alert-error mb-4" role="alert">
                        <i class="bi bi-exclamation-circle"></i>
                        <div>
                            <strong>Please fix the following:</strong>
                            <ul class="mb-0 mt-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <form class="hz-form" method="POST" action="{{ $formAction }}" novalidate>
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="hz-label" for="contact-name">Full name</label>
                            <input id="contact-name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name">
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="hz-label" for="contact-email">Email</label>
                            <input id="contact-email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="hz-label" for="contact-phone">Phone</label>
                            <input id="contact-phone" type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="tel">
                            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="hz-label" for="contact-subject">Subject</label>
                            <input id="contact-subject" type="text" class="form-control @error('subject') is-invalid @enderror" name="subject" value="{{ old('subject') }}" required>
                            @error('subject')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="hz-label" for="contact-message">Message</label>
                            <textarea id="contact-message" class="form-control @error('message') is-invalid @enderror" name="message" rows="7" required>{{ old('message') }}</textarea>
                            @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <button class="btn-hz" type="submit">
                                Send message <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-lg-5">
                <aside class="hz-contact-panel" id="contact-page-details"
                    @if($adminPreview)
                        data-admin-section="contact-page-details"
                        data-admin-label="Edit Contact Details"
                        data-admin-edit-url="{{ $contactEditBase }}#contact-details"
                    @endif
                >
                    <h3>Contact details</h3>

                    <div class="hz-contact-item" id="contact-preview-email"
                        {!! $adminPreview ? \App\Support\AdminPreviewAttrs::html('contact-page-details', 'email', 'Edit Email', true, $contactEditBase ? $contactEditBase . '#contact-emails' : null) : '' !!}
                    >
                        <div class="label"><i class="bi bi-envelope"></i> Email</div>
                        @forelse(($data['email'] ?? []) as $email)
                            <div data-preview-field="email"><a href="mailto:{{ $email }}">{{ $email }}</a></div>
                        @empty
                            <div class="opacity-75" data-preview-field="email">Not configured</div>
                        @endforelse
                    </div>

                    <div class="hz-contact-item" id="contact-preview-phone"
                        {!! $adminPreview ? \App\Support\AdminPreviewAttrs::html('contact-page-details', 'phone', 'Edit Phone', true, $contactEditBase ? $contactEditBase . '#contact-phones' : null) : '' !!}
                    >
                        <div class="label"><i class="bi bi-telephone"></i> Phone</div>
                        @forelse(($data['phone'] ?? []) as $phone)
                            <div data-preview-field="phone"><a href="tel:{{ preg_replace('/\s+/', '', $phone) }}">{{ $phone }}</a></div>
                        @empty
                            <div class="opacity-75" data-preview-field="phone">Not configured</div>
                        @endforelse
                    </div>

                    <div class="hz-contact-item" id="contact-preview-address"
                        {!! $adminPreview ? \App\Support\AdminPreviewAttrs::html('contact-page-details', 'address', 'Edit Address', true, $contactEditBase ? $contactEditBase . '#contact-address' : null) : '' !!}
                    >
                        <div class="label"><i class="bi bi-geo-alt"></i> Address</div>
                        <div data-preview-field="address">{{ $data['address'] ?? 'Not configured' }}</div>
                    </div>

                    <div class="hz-contact-item" id="contact-preview-hours"
                        {!! $adminPreview ? \App\Support\AdminPreviewAttrs::html('contact-page-details', 'hours', 'Edit Hours', true, $contactEditBase ? $contactEditBase . '#contact-hours' : null) : '' !!}
                    >
                        <div class="label"><i class="bi bi-clock"></i> Working hours</div>
                        <div data-preview-field="hours" style="white-space: pre-line;">{{ $hoursPreview !== '' ? $hoursPreview : 'Not configured' }}</div>
                    </div>

                    <div class="hz-contact-item mb-0" id="contact-preview-social">
                        <div class="label">Social</div>
                        <div class="hz-social hz-social-on-dark">
                            <x-social-media :contact-page-edit="true" />
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</section>

@if(!empty($data['map']))
<section class="hz-section pt-0">
    <div class="container">
        <p class="hz-eyebrow">Find us</p>
        <h2 class="h4 mb-3">Location</h2>
        <div class="hz-map">
            {!! $data['map'] !!}
        </div>
    </div>
</section>
@endif
@endsection
