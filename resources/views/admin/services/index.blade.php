@extends('admin.site-pages.layout')

@section('title', 'Services')
@section('page-title', 'Services')
@section('page-subtitle', $currentOrg->title)

@section('page-form')
    @include('admin.site-pages._page-header-form', ['pageKey' => 'services', 'data' => $data])

    <div class="space-y-4" x-data="{
        openModal: false,
        editingId: null,
        title: '',
        shortDesc: '',
        quote: '',
        order: 1,
        status: 'active',
        focusX: 50,
        focusY: 50,
        previewUrl: '',

        create() {
            this.editingId = null;
            this.title = '';
            this.shortDesc = '';
            this.quote = '';
            this.order = {{ $nextOrder }};
            this.status = 'active';
            this.resetImageFocus('focusX', 'focusY', 'previewUrl');
            this.openModal = true;
        },

        edit(s) {
            this.editingId = s.id;
            this.title = s.title || '';
            this.shortDesc = s.short_description || '';
            this.quote = s.quote || '';
            this.order = s.order || 1;
            this.status = s.status?.value || s.status || 'active';
            this.loadImageFocus(s, 'focusX', 'focusY', 'previewUrl', s.image_url || s.main_image_url || '');
            this.openModal = true;
        }
    }">
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm">
            <div class="flex items-center justify-between gap-3 border-b border-slate-100 pb-3 mb-4">
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Service cards</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Individual offerings shown on the services page.</p>
                </div>
                <button type="button" @click="create()" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-brand-600 hover:bg-brand-500 text-white text-xs font-bold rounded-lg transition shrink-0">
                    <i class="bi bi-plus-circle"></i> Add
                </button>
            </div>

            <div class="space-y-3">
                @forelse($services as $srv)
                    @php $img = $srv->main_image_url; @endphp
                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/80">
                        <div class="flex items-start gap-3">
                            @if($img)
                                <img src="{{ $img }}" alt="" class="w-14 h-14 rounded-lg object-cover shrink-0 border border-slate-200">
                            @else
                                <span class="w-14 h-14 rounded-lg bg-white border border-slate-200 flex items-center justify-center text-slate-400 shrink-0">
                                    <i class="bi bi-wrench"></i>
                                </span>
                            @endif
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="text-xs font-bold text-slate-900 truncate">{{ $srv->title }}</span>
                                    <span class="px-1.5 py-0.5 rounded text-[10px] font-bold {{ $srv->status === \App\Enums\StatusEnum::active ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-200 text-slate-600' }}">
                                        {{ ucfirst($srv->status->value ?? 'active') }}
                                    </span>
                                </div>
                                <p class="text-[11px] text-slate-500 line-clamp-2 mt-0.5">{{ $srv->short_description }}</p>
                            </div>
                            <div class="flex items-center gap-1 shrink-0">
                                <button type="button" @click="edit({{ json_encode(array_merge($srv->only(['id','title','short_description','quote','order','image_focus_x','image_focus_y']), ['status' => $srv->status->value ?? $srv->status, 'image_url' => $img ?: ''])) }})" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <form action="{{ route('admin.services.destroy', $srv) }}" method="POST" onsubmit="return confirm('Delete this service?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-rose-500 hover:bg-rose-50 rounded-lg" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-500 p-4 rounded-xl bg-slate-50 border border-dashed border-slate-200 text-center">No services yet. Click Add to create one.</p>
                @endforelse
            </div>
        </div>

        <div x-show="openModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
            <div class="min-h-full px-4 py-8 flex items-center justify-center">
                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="openModal = false"></div>
                <div class="relative bg-white rounded-2xl border shadow-2xl max-w-lg w-full p-6 space-y-4 z-10">
                    <h4 class="text-sm font-bold text-slate-900" x-text="editingId ? 'Edit service' : 'Add service'"></h4>
                    <form :action="editingId ? ('/admin/services/' + editingId) : '{{ route('admin.services.store') }}'" method="POST" enctype="multipart/form-data" class="space-y-3">
                        @csrf
                        <template x-if="editingId">
                            <input type="hidden" name="_method" value="PUT">
                        </template>
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700">Title</label>
                            <input type="text" name="title" x-model="title" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700">Short summary</label>
                            <textarea name="short_description" x-model="shortDesc" rows="2" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs"></textarea>
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700">Highlight quote</label>
                            <input type="text" name="quote" x-model="quote" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="space-y-1.5">
                                <label class="block text-xs font-bold text-slate-700">Order</label>
                                <input type="number" name="order" x-model="order" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                            </div>
                            <div class="space-y-1.5">
                                <label class="block text-xs font-bold text-slate-700">Status</label>
                                <select name="status" x-model="status" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700">Cover photo</label>
                            <input type="file" name="image" accept="image/*" @change="onImagePick($event, 'previewUrl')" class="w-full text-xs file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-brand-50 file:text-brand-700">
                        </div>

                        @include('admin.partials.image-focus-picker', [
                            'focusX' => 'focusX',
                            'focusY' => 'focusY',
                            'previewUrl' => 'previewUrl',
                        ])

                        <div class="flex justify-end gap-2 pt-2">
                            <button type="button" @click="openModal = false" class="px-4 py-2 text-xs font-bold text-slate-600">Cancel</button>
                            <button type="submit" class="px-4 py-2 bg-brand-600 text-white text-xs font-bold rounded-xl">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
