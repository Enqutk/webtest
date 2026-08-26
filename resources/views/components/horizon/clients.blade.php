@props(['clients' => collect()])

@if($clients->isNotEmpty())
<section class="hz-section bg-surface border-top border-bottom border-hz">
    <div class="container">
        <div class="text-center mb-4">
            <div class="hz-eyebrow">Trusted by</div>
            <h2 class="hz-title">Clients & partners</h2>
        </div>
        <div class="row g-3">
            @foreach($clients as $client)
                <div class="col-6 col-md-4 col-lg-2">
                    @if($client->link)
                        <a href="{{ $client->link }}" target="_blank" rel="noopener" class="hz-client">
                            @if($client->getFirstMediaUrl('image'))
                                <img src="{{ $client->image_url }}" alt="{{ $client->name }}">
                            @else
                                <span class="fw-semibold">{{ $client->name }}</span>
                            @endif
                        </a>
                    @else
                        <div class="hz-client">
                            @if($client->getFirstMediaUrl('image'))
                                <img src="{{ $client->image_url }}" alt="{{ $client->name }}">
                            @else
                                <span class="fw-semibold">{{ $client->name }}</span>
                            @endif
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
