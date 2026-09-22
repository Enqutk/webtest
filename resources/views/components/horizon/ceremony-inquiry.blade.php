@props([
    'config' => [],
])

@php
    $cfg = is_array($config) ? $config : [];
    $background = \App\Models\Organization::themeFileUrl($cfg['background_image'] ?? null);
    $recipient = $data['email'][0] ?? config('mail.from.address');
    $routeSlug = request()->route('slug') ?? ($data['routeSlug'] ?? ($data['organization']->slug ?? null));
    $formAction = $routeSlug
        ? route('card.contact.send', ['slug' => $routeSlug, 'recipient' => $recipient])
        : route('contact.send', ['recipient' => $recipient]);
    $button = $cfg['button_text'] ?? 'Send message';
@endphp

<section class="cm-block cm-inquiry" id="inquiry">
    <x-horizon.fill-background
        :image="$background"
        :opacity="$cfg['background_opacity'] ?? 80"
        :shade="$cfg['background_shade'] ?? 40"
        :focus-x="$cfg['background_focus_x'] ?? 50"
        :focus-y="$cfg['background_focus_y'] ?? 50"
    />
    <div class="container cm-inner">
        <div class="cm-inquiry-grid">
            <div>
                @if(filled($cfg['eyebrow'] ?? null))
                    <p class="cm-kicker">{{ $cfg['eyebrow'] }}</p>
                @endif
                @if(filled($cfg['title'] ?? null))
                    <h2>{{ $cfg['title'] }}</h2>
                @endif
                @if(filled($cfg['description'] ?? null))
                    <p class="cm-copy">{{ $cfg['description'] }}</p>
                @endif
                <div class="cm-inquiry-social">
                    <x-social-media />
                </div>
            </div>
            <form class="cm-form" method="POST" action="{{ $formAction }}">
                @csrf
                @if(session('success'))
                    <p class="cm-form-note is-ok">{{ session('success') }}</p>
                @endif
                @if(session('error'))
                    <p class="cm-form-note is-bad">{{ session('error') }}</p>
                @endif
                @if($errors->any())
                    <p class="cm-form-note is-bad">{{ $errors->first() }}</p>
                @endif
                <div class="cm-form-row">
                    <label>
                        <span>Name</span>
                        <input class="cm-field" type="text" name="name" value="{{ old('name') }}" required autocomplete="name">
                    </label>
                    <label>
                        <span>Email</span>
                        <input class="cm-field" type="email" name="email" value="{{ old('email') }}" required autocomplete="email">
                    </label>
                </div>
                <label>
                    <span>Subject</span>
                    <input class="cm-field" type="text" name="subject" value="{{ old('subject') }}" required>
                </label>
                <label>
                    <span>Message</span>
                    <textarea class="cm-field" name="message" rows="5" required>{{ old('message') }}</textarea>
                </label>
                <button class="cm-btn" type="submit">{{ $button }}</button>
            </form>
        </div>
    </div>
</section>
