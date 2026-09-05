@extends('admin.layouts.app')

@section('title', 'Custom Pages')
@section('page-title', 'Custom Pages')
@section('page-subtitle', $currentOrg->title)

@section('content')
<div class="space-y-6" x-data="{
    openModal: false,
    editingSlug: null,
    title: '',
    slug: '',
    shortDesc: '',
    order: 1,
    isActive: true,
    focusX: 50,
    focusY: 50,
    previewUrl: '',

    create() {
        this.editingSlug = null;
        this.title = '';
        this.slug = '';
        this.shortDesc = '';
        this.order = {{ ($pages->max('display_order') ?? 0) + 1 }};
        this.isActive = true;
        this.resetImageFocus('focusX', 'focusY', 'previewUrl');
        this.openModal = true;
    },

    edit(p) {
        this.editingSlug = p.slug;
        this.title = p.title || '';
        this.slug = p.slug || '';
        this.shortDesc = p.short_description || '';
        this.order = p.display_order || 1;
        this.isActive = !!p.is_active;
        this.loadImageFocus(p, 'focusX', 'focusY', 'previewUrl', p.hero_image_url || '');
        this.openModal = true;
    }
}">

    <!-- Header Actions Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
        <div>
            <h2 class="text-base font-bold text-slate-900">Custom Website Pages</h2>
            <p class="text-xs text-slate-500 mt-0.5">Manage custom content pages, URL slugs, and hero banners on {{ $currentOrg->title }}.</p>
        </div>
        <button type="button" @click="create()" class="inline-flex items-center gap-2 px-4 py-2 bg-brand-600 hover:bg-brand-500 text-white text-xs font-bold rounded-xl shadow-lg shadow-brand-600/30 transition shrink-0">
            <i class="bi bi-file-earmark-plus"></i>
            <span>Add New Page (Modal)</span>
        </button>
    </div>

    <!-- Pages Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50/80 border-b border-slate-200 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                    <tr>
                        <th class="px-6 py-4">Hero Image</th>
                        <th class="px-6 py-4">Page Title & Slug</th>
                        <th class="px-6 py-4">Sections</th>
                        <th class="px-6 py-4">Display Order</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pages as $page)
                        @php
                            $heroImg = $page->getFirstMediaUrl('hero_image');
                        @endphp
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="px-6 py-4">
                                <div class="w-16 h-10 rounded-lg bg-slate-100 border border-slate-200 flex items-center justify-center overflow-hidden shrink-0">
                                    @if($heroImg)
                                        <img src="{{ $heroImg }}" alt="{{ $page->title }}" class="w-full h-full object-cover">
                                    @else
                                        <i class="bi bi-file-earmark-text text-slate-400"></i>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-bold text-slate-900 text-sm block">{{ $page->title }}</span>
                                <span class="text-brand-600 font-mono text-xs block">/{{ $page->slug }}</span>
                                @if($page->short_description)
                                    <span class="text-slate-400 text-[11px] truncate block max-w-xs">{{ $page->short_description }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-lg bg-slate-100 font-semibold text-slate-700 text-[11px]">
                                    {{ $page->sections->count() }} sections
                                </span>
                            </td>
                            <td class="px-6 py-4 font-mono font-semibold text-slate-700">
                                {{ $page->display_order }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $page->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-200 text-slate-600' }}">
                                    {{ $page->is_active ? 'Active' : 'Draft' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <button type="button" @click="edit({{ json_encode(array_merge($page->only(['slug','title','short_description','display_order','is_active','image_focus_x','image_focus_y']), ['hero_image_url' => $heroImg ?: ''])) }})" class="p-2 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-lg transition" title="Edit Page">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" class="inline" onsubmit="return confirm('Delete this page?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-lg transition" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400 text-xs">
                                No custom pages found. Click "Add New Page" above to create one.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pages->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $pages->links() }}
            </div>
        @endif
    </div>

    <!-- MODAL: ADD / EDIT PAGE -->
    <div x-show="openModal" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
        <div class="min-h-full px-4 py-8 flex items-center justify-center">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" @click="openModal = false"></div>

            <div class="relative bg-white rounded-2xl border border-slate-200 shadow-2xl max-w-2xl w-full p-6 lg:p-8 space-y-6 z-10">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <h3 class="text-base font-bold text-slate-900" x-text="editingSlug ? 'Edit Custom Page' : 'Add New Custom Page'"></h3>
                    <button @click="openModal = false" class="text-slate-400 hover:text-slate-700"><i class="bi bi-x-lg"></i></button>
                </div>

                <form :action="editingSlug ? ('/admin/pages/' + editingSlug) : '{{ route('admin.pages.store') }}'" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <template x-if="editingSlug">
                        <input type="hidden" name="_method" value="PUT">
                    </template>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Page Title <span class="text-rose-500">*</span></label>
                        <input type="text" name="title" x-model="title" required placeholder="e.g. Careers, Sustainability, FAQ" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">URL Slug</label>
                        <input type="text" name="slug" x-model="slug" placeholder="e.g. careers (auto-generated if empty)" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 font-mono focus:bg-white transition">
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Short Summary / Description</label>
                        <textarea name="short_description" x-model="shortDesc" rows="2" placeholder="Brief summary of the page" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition"></textarea>
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Display Order</label>
                        <input type="number" name="display_order" x-model="order" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Hero Header Image</label>
                        <input type="file" name="hero_image" accept="image/*" @change="onImagePick($event, 'previewUrl')" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100">
                    </div>

                    @include('admin.partials.image-focus-picker', [
                        'focusX' => 'focusX',
                        'focusY' => 'focusY',
                        'previewUrl' => 'previewUrl',
                    ])

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <label class="flex items-center gap-2 text-xs font-semibold text-slate-700 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" x-model="isActive" class="w-4 h-4 rounded text-brand-600">
                            <span>Page is Active & Published</span>
                        </label>

                        <div class="flex items-center gap-3">
                            <button type="button" @click="openModal = false" class="px-4 py-2 bg-slate-100 text-slate-700 text-xs font-bold rounded-xl">Cancel</button>
                            <button type="submit" class="px-5 py-2 bg-brand-600 hover:bg-brand-500 text-white text-xs font-bold rounded-xl shadow-lg shadow-brand-600/30">Save Page</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
