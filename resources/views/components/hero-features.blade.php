@props(['data'])

<section class="section-sm border-bottom ihbox-section-two">
    <div class="container">
        <div class="flex flex-wrap gap-12 justify-start items-stretch py-8">
            @foreach($data['heroFeatures']->items ?? [] as $feature)
                <div class="flex flex-col md:flex-row items-start gap-6 w-full md:w-1/3">
                    <div class="bg-gray-100 rounded-xl flex items-center justify-center w-24 h-24 mb-4 md:mb-0">
                        <i class="{{ $feature['icon'] }} text-4xl text-gray-800"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $feature['title'] }}</h3>
                        <p class="text-gray-700 text-base leading-relaxed">{{ $feature['description'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
