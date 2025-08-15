@props(['features' => []])

<section class="section-sm border-bottom ihbox-section-two">
    <div class="container">
        <div class="row">
            @php
                $items = [];
                if (!empty($features) && isset($features[0])) {
                    $items = $features[0]->list_items ?? [];
                }
            @endphp
            @foreach($items as $feature)
            <div class="col-md-4 pbmit-column">
                <div class="pbmit-ihbox-style-4">
                    <div class="pbmit-ihbox-box">
                        <div class="pbmit-ihbox-icon">
                            <div class="pbmit-ihbox-icon-wrapper pbmit-icon-type-icon">
                                {!! $feature['icon'] ?? '' !!}
                            </div>
                        </div>
                        <div class="pbmit-ihbox-contents">
                            <h2 class="pbmit-element-title">{{ $feature['title'] ?? '' }}</h2>
                            <div class="pbmit-heading-desc">{{ $feature['description'] ?? '' }}</div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
