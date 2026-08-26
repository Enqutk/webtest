@props([
    'title' => 'Have a project in mind?',
    'text' => 'Tell us about your irrigation, WASH, or resilience goals — we’ll help shape a clear path from concept to delivery.',
    'button' => 'Start a conversation',
    'href' => null,
])

<section class="hz-cta">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                <h2 class="hz-title mb-2">{{ $title }}</h2>
                <p class="mb-0">{{ $text }}</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="{{ $href ?? route('contact') }}" class="btn-hz">
                    {{ $button }} <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</section>
