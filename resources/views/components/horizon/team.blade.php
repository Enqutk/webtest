@props(['team' => collect()])

@if($team->isNotEmpty())
<section class="hz-section" id="team">
    <div class="container">
        <div class="row justify-content-between align-items-end mb-4 g-3">
            <div class="col-lg-7">
                <div class="hz-eyebrow">Our people</div>
                <h2 class="hz-title mb-0">The team behind the work</h2>
            </div>
        </div>
        <div class="row g-4">
            @foreach($team as $member)
                <div class="col-6 col-lg-3">
                    <div class="hz-team-photo">
                        <img src="{{ $member->image_url }}" alt="{{ $member->full_name }}">
                    </div>
                    <h3 class="h5 mb-1">{{ $member->full_name }}</h3>
                    <div class="hz-team-role">{{ $member->title }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
