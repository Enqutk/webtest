@props([
    'clients' => collect(),
    'eyebrow' => 'Trusted by',
    'title' => 'Clients & partners',
    'description' => null,
])

@if($clients->isNotEmpty())
<section class="hz-section hz-clients bg-surface border-top border-bottom border-hz" id="clients">
    <div class="container">
        <div class="row justify-content-between align-items-end mb-4 g-3">
            <div class="col-lg-8">
                <p class="hz-eyebrow" data-preview-field="eyebrow" {!! \App\Support\AdminPreviewAttrs::html('clients', 'eyebrow', 'Edit Eyebrow') !!}>{{ $eyebrow }}</p>
                <h2 class="hz-title mb-0" data-preview-field="title" {!! \App\Support\AdminPreviewAttrs::html('clients', 'title', 'Edit Title') !!}>{{ $title }}</h2>
                @if($description)
                    <p class="hz-lead text-muted mt-2 mb-0" data-preview-field="description" {!! \App\Support\AdminPreviewAttrs::html('clients', 'description', 'Edit Description') !!}>{{ $description }}</p>
                @else
                    <p class="hz-lead text-muted mt-2 mb-0" data-preview-field="description" style="display:none"></p>
                @endif
            </div>
        </div>

        <div class="row g-3">
            @foreach($clients as $client)
                @php
                    $logo = $client->getFirstMediaUrl('image');
                    $tag = $client->type?->value === 'partner' ? 'Partner' : 'Client';
                @endphp
                <div class="col-6 col-md-4 col-lg-3">
                    <div
                        class="h-100"
                        {!! \App\Support\AdminPreviewAttrs::html('clients', 'client_'.$client->id, 'Edit ' . $tag, false) !!}
                    >
                        @if($client->link)
                            <a href="{{ $client->link }}" target="_blank" rel="noopener" class="hz-client">
                                @if($logo)
                                    <img src="{{ $logo }}" alt="{{ $client->name }}" data-preview-field="client-{{ $client->id }}-image">
                                @else
                                    <span class="hz-client-name" data-preview-field="client-{{ $client->id }}-name">{{ $client->name }}</span>
                                @endif
                                <span class="hz-client-tag" data-preview-field="client-{{ $client->id }}-tag">{{ $tag }}</span>
                            </a>
                        @else
                            <div class="hz-client">
                                @if($logo)
                                    <img src="{{ $logo }}" alt="{{ $client->name }}" data-preview-field="client-{{ $client->id }}-image">
                                @else
                                    <span class="hz-client-name" data-preview-field="client-{{ $client->id }}-name">{{ $client->name }}</span>
                                @endif
                                <span class="hz-client-tag" data-preview-field="client-{{ $client->id }}-tag">{{ $tag }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
