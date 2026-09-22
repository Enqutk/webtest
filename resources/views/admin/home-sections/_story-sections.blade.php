@php
    $spotlight = $sections['spotlight'] ?? \App\Models\Organization::defaultHomeSections()['spotlight'];
    $gallery = $sections['gallery'] ?? \App\Models\Organization::defaultHomeSections()['gallery'];
    $inquiry = $sections['inquiry'] ?? \App\Models\Organization::defaultHomeSections()['inquiry'];
    $frames = array_values($spotlight['frames'] ?? []);
    while (count($frames) < 3) {
        $frames[] = ['image' => '', 'alt' => ''];
    }
    $frames[] = ['image' => '', 'alt' => ''];
    $tiles = array_values($gallery['tiles'] ?? []);
    while (count($tiles) < 5) {
        $tiles[] = ['image' => '', 'title' => '', 'subtitle' => '', 'span' => 'tile'];
    }
    $tiles[] = ['image' => '', 'title' => '', 'subtitle' => '', 'span' => 'tile'];
    $spotPoints = array_values($spotlight['points'] ?? []);
    while (count($spotPoints) < 3) {
        $spotPoints[] = ['title' => '', 'description' => ''];
    }
@endphp

<div id="admin-form-spotlight" x-show="activeSection === 'spotlight'" class="space-y-6" x-cloak>
    <form action="{{ route('admin.home-sections.update') }}" method="POST" enctype="multipart/form-data"
        class="bg-white rounded-2xl border border-slate-200/80 p-6 lg:p-8 shadow-sm space-y-6">
        @csrf
        <input type="hidden" name="section" value="spotlight">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <div>
                <h3 class="text-sm font-bold text-slate-900">Spotlight story</h3>
                <p class="text-xs text-slate-500">Photo collage on one side, story on the other. Add or remove frames any time.</p>
            </div>
            <label class="flex items-center gap-2 text-xs font-bold text-slate-700">
                <input type="checkbox" name="is_visible" value="1" {{ !empty($spotlight['is_visible']) ? 'checked' : '' }} class="w-4 h-4 rounded text-brand-600">
                Show
            </label>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <label class="space-y-1.5">
                <span class="block text-xs font-bold text-slate-700">Name on the photo</span>
                <input type="text" name="overlay" value="{{ $spotlight['overlay'] ?? '' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">
            </label>
            <label class="space-y-1.5">
                <span class="block text-xs font-bold text-slate-700">Small line under the name</span>
                <input type="text" name="overlay_sub" value="{{ $spotlight['overlay_sub'] ?? '' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">
            </label>
            <label class="space-y-1.5">
                <span class="block text-xs font-bold text-slate-700">Eyebrow</span>
                <input type="text" name="eyebrow" value="{{ $spotlight['eyebrow'] ?? '' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">
            </label>
            <label class="space-y-1.5">
                <span class="block text-xs font-bold text-slate-700">Heading</span>
                <input type="text" name="title" value="{{ $spotlight['title'] ?? '' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">
            </label>
        </div>
        <label class="space-y-1.5 block">
            <span class="block text-xs font-bold text-slate-700">Introduction</span>
            <textarea name="description" rows="3" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">{{ $spotlight['description'] ?? '' }}</textarea>
        </label>
        <div class="space-y-3">
            <h4 class="text-xs font-bold text-slate-800">Story points</h4>
            @foreach($spotPoints as $i => $point)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <input type="text" name="points[{{ $i }}][title]" value="{{ $point['title'] ?? '' }}" placeholder="Point"
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                    <input type="text" name="points[{{ $i }}][description]" value="{{ $point['description'] ?? '' }}" placeholder="Detail, optional"
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                </div>
            @endforeach
        </div>
        <div class="space-y-3">
            <h4 class="text-xs font-bold text-slate-800">Collage photos</h4>
            <p class="text-[11px] text-slate-500">The first photo is the large frame. Leave a row empty to skip it. Check remove to drop a photo you already saved.</p>
            @foreach($frames as $i => $frame)
                @php $frameUrl = \App\Models\Organization::themeFileUrl($frame['image'] ?? null); @endphp
                <div class="p-3 rounded-xl border border-slate-200 bg-slate-50 space-y-2" id="frame-{{ $i }}">
                    <div class="flex items-center justify-between gap-3">
                        <span class="text-[11px] font-bold text-slate-600">Frame {{ $i + 1 }}</span>
                        @if($frameUrl)
                            <label class="text-[11px] font-semibold text-rose-700 flex items-center gap-1">
                                <input type="checkbox" name="frames[{{ $i }}][remove]" value="1"> Remove
                            </label>
                        @endif
                    </div>
                    <img src="{{ $frameUrl }}" alt="" class="js-picture-thumb h-20 w-32 object-cover rounded-lg border border-slate-200" @unless($frameUrl) style="display:none" @endunless>
                    <input type="hidden" name="frames[{{ $i }}][image]" value="{{ $frame['image'] ?? '' }}">
                    <input type="file" name="frame_files[{{ $i }}]" accept="image/*" class="w-full text-xs"
                        onchange="if (this.files[0] && window.AdminPreview) { window.AdminPreview.pushField('spotlight', 'frame_{{ $i }}', URL.createObjectURL(this.files[0])); }">
                    <input type="text" name="frames[{{ $i }}][alt]" value="{{ $frame['alt'] ?? '' }}" placeholder="Short description of this photo"
                        class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs">
                </div>
            @endforeach
        </div>
        @include('admin.home-sections._fill-background', ['section' => $spotlight])
        <div class="flex justify-end">
            <button type="submit" class="px-5 py-2.5 bg-brand-600 text-white text-xs font-bold rounded-xl">Save spotlight</button>
        </div>
    </form>
</div>

<div id="admin-form-gallery" x-show="activeSection === 'gallery'" class="space-y-6" x-cloak>
    <form action="{{ route('admin.home-sections.update') }}" method="POST" enctype="multipart/form-data"
        class="bg-white rounded-2xl border border-slate-200/80 p-6 lg:p-8 shadow-sm space-y-6">
        @csrf
        <input type="hidden" name="section" value="gallery">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <div>
                <h3 class="text-sm font-bold text-slate-900">Picture grid</h3>
                <p class="text-xs text-slate-500">Each picture can be a normal tile, a wide tile, or the large feature. Add as many as you want.</p>
            </div>
            <label class="flex items-center gap-2 text-xs font-bold text-slate-700">
                <input type="checkbox" name="is_visible" value="1" {{ !empty($gallery['is_visible']) ? 'checked' : '' }} class="w-4 h-4 rounded text-brand-600">
                Show
            </label>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <label class="space-y-1.5">
                <span class="block text-xs font-bold text-slate-700">Eyebrow</span>
                <input type="text" name="eyebrow" value="{{ $gallery['eyebrow'] ?? '' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">
            </label>
            <label class="space-y-1.5">
                <span class="block text-xs font-bold text-slate-700">Heading, optional</span>
                <input type="text" name="title" value="{{ $gallery['title'] ?? '' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">
            </label>
        </div>
        <label class="space-y-1.5 block">
            <span class="block text-xs font-bold text-slate-700">Introduction, optional</span>
            <textarea name="description" rows="2" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">{{ $gallery['description'] ?? '' }}</textarea>
        </label>
        <div class="space-y-3">
            @foreach($tiles as $i => $tile)
                @php $tileUrl = \App\Models\Organization::themeFileUrl($tile['image'] ?? null); @endphp
                <div class="p-3 rounded-xl border border-slate-200 bg-slate-50 space-y-2" id="tile-{{ $i }}">
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-bold text-slate-600">Picture {{ $i + 1 }}</span>
                        @if($tileUrl)
                            <label class="text-[11px] font-semibold text-rose-700 flex items-center gap-1">
                                <input type="checkbox" name="tiles[{{ $i }}][remove]" value="1"> Remove
                            </label>
                        @endif
                    </div>
                    <img src="{{ $tileUrl }}" alt="" class="js-picture-thumb h-20 w-32 object-cover rounded-lg border border-slate-200" @unless($tileUrl) style="display:none" @endunless>
                    <input type="hidden" name="tiles[{{ $i }}][image]" value="{{ $tile['image'] ?? '' }}">
                    <input type="file" name="gallery_files[{{ $i }}]" accept="image/*" class="w-full text-xs"
                        onchange="if (this.files[0] && window.AdminPreview) { window.AdminPreview.pushField('gallery', 'tile_{{ $i }}', URL.createObjectURL(this.files[0])); }">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                        <input type="text" name="tiles[{{ $i }}][title]" value="{{ $tile['title'] ?? '' }}" placeholder="Caption"
                            class="px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs">
                        <input type="text" name="tiles[{{ $i }}][subtitle]" value="{{ $tile['subtitle'] ?? '' }}" placeholder="Small line"
                            class="px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs">
                        <select name="tiles[{{ $i }}][span]" class="px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs">
                            @foreach(['tile' => 'Normal', 'wide' => 'Wide', 'feature' => 'Large feature'] as $value => $label)
                                <option value="{{ $value }}" {{ ($tile['span'] ?? 'tile') === $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endforeach
        </div>
        @include('admin.home-sections._fill-background', ['section' => $gallery])
        <div class="flex justify-end">
            <button type="submit" class="px-5 py-2.5 bg-brand-600 text-white text-xs font-bold rounded-xl">Save picture grid</button>
        </div>
    </form>
</div>

<div id="admin-form-inquiry" x-show="activeSection === 'inquiry'" class="space-y-6" x-cloak>
    <form action="{{ route('admin.home-sections.update') }}" method="POST" enctype="multipart/form-data"
        class="bg-white rounded-2xl border border-slate-200/80 p-6 lg:p-8 shadow-sm space-y-6">
        @csrf
        <input type="hidden" name="section" value="inquiry">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <div>
                <h3 class="text-sm font-bold text-slate-900">Homepage contact form</h3>
                <p class="text-xs text-slate-500">Shown on the home page. Messages still go to the organization email.</p>
            </div>
            <label class="flex items-center gap-2 text-xs font-bold text-slate-700">
                <input type="checkbox" name="is_visible" value="1" {{ !empty($inquiry['is_visible']) ? 'checked' : '' }} class="w-4 h-4 rounded text-brand-600">
                Show
            </label>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <label class="space-y-1.5">
                <span class="block text-xs font-bold text-slate-700">Eyebrow</span>
                <input type="text" name="eyebrow" value="{{ $inquiry['eyebrow'] ?? '' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">
            </label>
            <label class="space-y-1.5">
                <span class="block text-xs font-bold text-slate-700">Button text</span>
                <input type="text" name="button_text" value="{{ $inquiry['button_text'] ?? 'Send message' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">
            </label>
        </div>
        <label class="space-y-1.5 block">
            <span class="block text-xs font-bold text-slate-700">Heading</span>
            <input type="text" name="title" value="{{ $inquiry['title'] ?? '' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">
        </label>
        <label class="space-y-1.5 block">
            <span class="block text-xs font-bold text-slate-700">Introduction</span>
            <textarea name="description" rows="3" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">{{ $inquiry['description'] ?? '' }}</textarea>
        </label>
        @include('admin.home-sections._fill-background', ['section' => $inquiry])
        <div class="flex justify-end">
            <button type="submit" class="px-5 py-2.5 bg-brand-600 text-white text-xs font-bold rounded-xl">Save contact form</button>
        </div>
    </form>
</div>
