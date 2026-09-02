@extends('admin.layouts.app')

@section('title', 'Social Media Links')
@section('page-title', 'Social Media & Links')
@section('page-subtitle', $currentOrg->title)

@section('content')
<div class="space-y-6" x-data="{
    openModal: false,
    editingId: null,
    title: '',
    link: '',
    iconClass: 'bi-linkedin',
    order: 1,
    status: 'active',

    create() {
        this.editingId = null;
        this.title = '';
        this.link = 'https://';
        this.iconClass = 'bi-linkedin';
        this.order = {{ ($socials->max('order') ?? 0) + 1 }};
        this.status = 'active';
        this.openModal = true;
    },

    edit(s) {
        this.editingId = s.id;
        this.title = s.title || '';
        this.link = s.link || '';
        this.iconClass = s.icon_class || 'bi-globe';
        this.order = s.order || 1;
        this.status = s.status?.value || s.status || 'active';
        this.openModal = true;
    }
}">

    <!-- Header Actions Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
        <div>
            <h2 class="text-base font-bold text-slate-900">Social Media & Online Profiles</h2>
            <p class="text-xs text-slate-500 mt-0.5">Manage social media links displayed in the header and footer of {{ $currentOrg->title }}.</p>
        </div>
        <button type="button" @click="create()" class="inline-flex items-center gap-2 px-4 py-2 bg-brand-600 hover:bg-brand-500 text-white text-xs font-bold rounded-xl shadow-lg shadow-brand-600/30 transition shrink-0">
            <i class="bi bi-plus-circle"></i>
            <span>Add Social Link (Modal)</span>
        </button>
    </div>

    <!-- Socials Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($socials as $soc)
            <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm hover:shadow-md transition flex items-center justify-between">
                <div class="flex items-center gap-3.5 min-w-0">
                    <div class="w-11 h-11 rounded-xl bg-slate-100 flex items-center justify-center text-slate-700 text-lg shrink-0">
                        <i class="bi {{ $soc->icon_class ?: 'bi-link-45deg' }}"></i>
                    </div>
                    <div class="min-w-0">
                        <span class="text-xs font-bold text-slate-900 block truncate">{{ $soc->title }}</span>
                        <a href="{{ $soc->link }}" target="_blank" class="text-[11px] font-mono text-brand-600 hover:underline truncate block max-w-xs">{{ $soc->link }}</a>
                    </div>
                </div>

                <div class="flex items-center gap-2 shrink-0">
                    <button type="button" @click="edit({{ json_encode($soc) }})" class="p-2 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-lg transition" title="Edit">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                    <form action="{{ route('admin.socials.destroy', $soc) }}" method="POST" onsubmit="return confirm('Delete this link?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-2 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-lg transition" title="Delete">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-2xl border border-slate-200 p-12 text-center text-slate-400 text-xs">
                No social links configured yet. Click "Add Social Link" above to create one.
            </div>
        @endforelse
    </div>

    <!-- MODAL: ADD / EDIT SOCIAL -->
    <div x-show="openModal" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
        <div class="min-h-full px-4 py-8 flex items-center justify-center">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" @click="openModal = false"></div>

            <div class="relative bg-white rounded-2xl border border-slate-200 shadow-2xl max-w-lg w-full p-6 lg:p-8 space-y-6 z-10">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <h3 class="text-base font-bold text-slate-900" x-text="editingId ? 'Edit Social Link' : 'Add New Social Link'"></h3>
                    <button @click="openModal = false" class="text-slate-400 hover:text-slate-700"><i class="bi bi-x-lg"></i></button>
                </div>

                <form :action="editingId ? ('/admin/socials/' + editingId) : '{{ route('admin.socials.store') }}'" method="POST" class="space-y-4">
                    @csrf
                    <template x-if="editingId">
                        <input type="hidden" name="_method" value="PUT">
                    </template>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Platform Title <span class="text-rose-500">*</span></label>
                        <input type="text" name="title" x-model="title" required placeholder="e.g. LinkedIn, Twitter, YouTube" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Profile URL <span class="text-rose-500">*</span></label>
                        <input type="url" name="link" x-model="link" required placeholder="https://linkedin.com/company/..." class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 font-mono focus:bg-white transition">
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Icon Class (Bootstrap Icons)</label>
                        <select name="icon_class" x-model="iconClass" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                            <option value="bi-linkedin">LinkedIn (bi-linkedin)</option>
                            <option value="bi-twitter-x">Twitter / X (bi-twitter-x)</option>
                            <option value="bi-facebook">Facebook (bi-facebook)</option>
                            <option value="bi-instagram">Instagram (bi-instagram)</option>
                            <option value="bi-youtube">YouTube (bi-youtube)</option>
                            <option value="bi-github">GitHub (bi-github)</option>
                            <option value="bi-globe">Website / Globe (bi-globe)</option>
                        </select>
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

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                        <button type="button" @click="openModal = false" class="px-4 py-2 bg-slate-100 text-slate-700 text-xs font-bold rounded-xl">Cancel</button>
                        <button type="submit" class="px-5 py-2 bg-brand-600 hover:bg-brand-500 text-white text-xs font-bold rounded-xl shadow-lg shadow-brand-600/30">Save Link</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
