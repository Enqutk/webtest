@extends('admin.layouts.app')

@section('title', 'Portfolio Projects')
@section('page-title', 'Portfolio & Projects')
@section('page-subtitle', $currentOrg->title)

@section('content')
<div class="space-y-6" x-data="{
    openModal: false,
    editingId: null,
    name: '',
    category: '',
    link: '',
    description: '',
    order: 1,
    status: 'active',

    create() {
        this.editingId = null;
        this.name = '';
        this.category = '';
        this.link = '';
        this.description = '';
        this.order = {{ ($projects->max('order') ?? 0) + 1 }};
        this.status = 'active';
        this.openModal = true;
    },

    edit(p) {
        this.editingId = p.id;
        this.name = p.name || '';
        this.category = p.category || '';
        this.link = p.link || '';
        this.description = p.description || '';
        this.order = p.order || 1;
        this.status = p.status?.value || p.status || 'active';
        this.openModal = true;
    }
}">

    <!-- Header Actions Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
        <div>
            <h2 class="text-base font-bold text-slate-900">Project Portfolio Gallery</h2>
            <p class="text-xs text-slate-500 mt-0.5">Manage completed infrastructure projects, case studies, and engineering highlights for {{ $currentOrg->title }}.</p>
        </div>
        <button type="button" @click="create()" class="inline-flex items-center gap-2 px-4 py-2 bg-brand-600 hover:bg-brand-500 text-white text-xs font-bold rounded-xl shadow-lg shadow-brand-600/30 transition shrink-0">
            <i class="bi bi-plus-circle"></i>
            <span>Add New Project (Modal)</span>
        </button>
    </div>

    <!-- Projects Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($projects as $p)
            @php
                $img = $p->getFirstMediaUrl('image');
            @endphp
            <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm hover:shadow-md transition flex flex-col justify-between">
                <div>
                    <div class="flex items-start justify-between gap-3 mb-3">
                        @if($p->category)
                            <span class="px-2.5 py-0.5 rounded-lg text-[10px] font-bold bg-brand-50 text-brand-700 uppercase tracking-wider">
                                {{ $p->category }}
                            </span>
                        @else
                            <span></span>
                        @endif
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $p->status === \App\Enums\StatusEnum::active ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-200 text-slate-600' }}">
                            {{ ucfirst($p->status->value ?? 'active') }}
                        </span>
                    </div>

                    @if($img)
                        <div class="h-36 rounded-xl bg-slate-100 overflow-hidden mb-3">
                            <img src="{{ $img }}" alt="{{ $p->name }}" class="w-full h-full object-cover">
                        </div>
                    @endif

                    <h3 class="text-sm font-bold text-slate-900 mb-1">{{ $p->name }}</h3>
                    <p class="text-xs text-slate-500 line-clamp-2 mb-4">{{ $p->description }}</p>
                </div>

                <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                    <button type="button" @click="edit({{ json_encode($p) }})" class="px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs font-bold rounded-lg transition">
                        Edit
                    </button>
                    <form action="{{ route('admin.portfolio.destroy', $p) }}" method="POST" onsubmit="return confirm('Delete this project?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-1.5 text-rose-500 hover:bg-rose-50 rounded-lg transition">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-2xl border border-slate-200 p-12 text-center text-slate-400 text-xs">
                No projects found. Click "Add New Project" above to create one.
            </div>
        @endforelse
    </div>

    <!-- MODAL: ADD / EDIT PROJECT -->
    <div x-show="openModal" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
        <div class="min-h-full px-4 py-8 flex items-center justify-center">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" @click="openModal = false"></div>

            <div class="relative bg-white rounded-2xl border border-slate-200 shadow-2xl max-w-2xl w-full p-6 lg:p-8 space-y-6 z-10">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <h3 class="text-base font-bold text-slate-900" x-text="editingId ? 'Edit Project' : 'Add New Project'"></h3>
                    <button @click="openModal = false" class="text-slate-400 hover:text-slate-700"><i class="bi bi-x-lg"></i></button>
                </div>

                <form :action="editingId ? ('/admin/portfolio/' + editingId) : '{{ route('admin.portfolio.store') }}'" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <template x-if="editingId">
                        <input type="hidden" name="_method" value="PUT">
                    </template>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Project Name <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" x-model="name" required placeholder="e.g. Upper Tana Basin Irrigation & Drainage Scheme" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700">Category / Sector</label>
                            <input type="text" name="category" x-model="category" placeholder="e.g. Irrigation &middot; Drainage" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700">Project URL / Link</label>
                            <input type="text" name="link" x-model="link" placeholder="e.g. https://..." class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Description</label>
                        <textarea name="description" x-model="description" rows="3" placeholder="Overview of engineering design, scope, and community impact" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition"></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700">Display Order</label>
                            <input type="number" name="order" x-model="order" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700">Status</label>
                            <select name="status" x-model="status" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="space-y-1.5 pt-2">
                        <label class="block text-xs font-bold text-slate-700">Project Photo</label>
                        <input type="file" name="image" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100">
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                        <button type="button" @click="openModal = false" class="px-4 py-2 bg-slate-100 text-slate-700 text-xs font-bold rounded-xl">Cancel</button>
                        <button type="submit" class="px-5 py-2 bg-brand-600 hover:bg-brand-500 text-white text-xs font-bold rounded-xl shadow-lg shadow-brand-600/30">Save Project</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
