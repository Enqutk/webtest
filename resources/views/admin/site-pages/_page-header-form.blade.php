<form id="page-header" action="{{ route('admin.site-pages.update', $pageKey) }}" method="POST" class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm space-y-4">
    @csrf
    <h3 class="text-sm font-bold text-slate-900 border-b border-slate-100 pb-3">Page header</h3>
    <div class="grid grid-cols-1 gap-4">
        <div class="space-y-1.5">
            <label class="block text-xs font-bold text-slate-700">Eyebrow</label>
            <input type="text" name="eyebrow" value="{{ $data['eyebrow'] ?? '' }}" data-preview-bind="page-hero:eyebrow" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">
        </div>
        <div class="space-y-1.5">
            <label class="block text-xs font-bold text-slate-700">Title</label>
            <input type="text" name="title" value="{{ $data['title'] ?? '' }}" required data-preview-bind="page-hero:title" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">
        </div>
    </div>
    <div class="space-y-1.5">
        <label class="block text-xs font-bold text-slate-700">Description</label>
        <textarea name="description" rows="3" data-preview-bind="page-hero:description" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">{{ $data['description'] ?? '' }}</textarea>
    </div>
    <button type="submit" class="w-full px-4 py-2.5 bg-brand-600 hover:bg-brand-500 text-white text-xs font-bold rounded-xl shadow-lg shadow-brand-600/30">Save page header</button>
</form>
