@php
    $styleSections = [
        'hero' => 'Hero',
        'about' => 'About',
        'services' => 'Services',
        'spotlight' => 'Spotlight story',
        'stats' => 'Stats',
        'portfolio' => 'Portfolio',
        'gallery' => 'Picture grid',
        'clients' => 'Clients',
        'team' => 'Team',
        'cta' => 'Call to action',
        'inquiry' => 'Contact form',
    ];
    $savedOrder = is_array($theme['section_order'] ?? null) ? $theme['section_order'] : [];
    $orderedKeys = array_values(array_unique(array_merge(
        array_values(array_filter($savedOrder, fn ($key) => isset($styleSections[$key]))),
        array_keys($styleSections)
    )));
@endphp

<form action="{{ route('admin.home-sections.update') }}" method="POST"
    class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm space-y-5">
    @csrf
    <input type="hidden" name="section" value="layout">

    <div>
        <h3 class="text-sm font-bold text-slate-900">Page style</h3>
        <p class="text-xs text-slate-500 mt-1">Switch the look, reorder sections, and keep editing every headline, photo, and color. Nothing here is locked to one design.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <label class="space-y-1.5">
            <span class="block text-xs font-bold text-slate-700">Overall look</span>
            <select name="layout" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                <option value="horizon" {{ ($theme['layout'] ?? 'horizon') === 'horizon' ? 'selected' : '' }}>Horizon — split profile</option>
                <option value="ceremony" {{ ($theme['layout'] ?? '') === 'ceremony' ? 'selected' : '' }}>Ceremony — dark full-page event</option>
            </select>
        </label>
        <label class="space-y-1.5">
            <span class="block text-xs font-bold text-slate-700">Footer</span>
            <select name="footer_style" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                <option value="columns" {{ ($theme['footer_style'] ?? 'columns') === 'columns' ? 'selected' : '' }}>Columns</option>
                <option value="explore" {{ ($theme['footer_style'] ?? '') === 'explore' ? 'selected' : '' }}>Centered explore links</option>
            </select>
        </label>
        <label class="space-y-1.5">
            <span class="block text-xs font-bold text-slate-700">Footer label</span>
            <input type="text" name="footer_explore_label" value="{{ $theme['footer_explore_label'] ?? 'Explore' }}"
                class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">
        </label>
    </div>

    <div>
        <p class="text-xs font-bold text-slate-700 mb-2">Section order</p>
        <p class="text-[11px] text-slate-500 mb-3">Lower numbers appear first. Hide a section from its own tab. Colors and fonts stay in Site Settings.</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
            @foreach($orderedKeys as $index => $key)
                <label class="flex items-center gap-3 px-3 py-2 rounded-xl border border-slate-200 bg-slate-50">
                    <input type="number" name="order[{{ $key }}]" value="{{ $index + 1 }}" min="1" max="30"
                        class="w-14 px-2 py-1.5 bg-white border border-slate-200 rounded-lg text-xs font-bold">
                    <span class="text-xs font-semibold text-slate-800">{{ $styleSections[$key] }}</span>
                </label>
            @endforeach
        </div>
    </div>

    <div class="flex justify-end">
        <button type="submit" class="px-5 py-2.5 bg-brand-600 hover:bg-brand-500 text-white text-xs font-bold rounded-xl">
            Save page style
        </button>
    </div>
</form>
