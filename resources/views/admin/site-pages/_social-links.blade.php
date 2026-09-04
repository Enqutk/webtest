<div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm space-y-4" x-data="{
    openModal: false,
    editingId: null,
    title: '',
    link: 'https://',
    iconClass: 'bi-linkedin',
    order: {{ ($socials->max('order') ?? 0) + 1 }},
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
    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
        <div>
            <h3 class="text-sm font-bold text-slate-900">Social icons</h3>
            <p class="text-xs text-slate-500 mt-0.5">Facebook, LinkedIn, X, YouTube, etc. shown under the footer logo.</p>
        </div>
        <button type="button" @click="create()" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold rounded-lg transition">+ Add</button>
    </div>

    <div class="space-y-2">
        @forelse($socials as $soc)
            <div class="flex items-center justify-between gap-2 p-3 rounded-xl bg-slate-50 border border-slate-200/80">
                <div class="flex items-center gap-2 min-w-0 flex-1">
                    <span class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center text-slate-600 shrink-0">
                        <i class="bi {{ $soc->icon_class ?: 'bi-link-45deg' }}"></i>
                    </span>
                    <div class="min-w-0">
                        <div class="text-xs font-bold text-slate-900 truncate">{{ $soc->title }}</div>
                        <div class="text-[11px] text-slate-500 font-mono truncate">{{ $soc->link }}</div>
                    </div>
                </div>
                <div class="flex items-center gap-1 shrink-0">
                    <button type="button" @click="edit({{ json_encode($soc) }})" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg"><i class="bi bi-pencil"></i></button>
                    <form action="{{ route('admin.socials.destroy', $soc) }}" method="POST" onsubmit="return confirm('Remove this social link?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-1.5 text-rose-500 hover:bg-rose-50 rounded-lg"><i class="bi bi-trash"></i></button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-xs text-slate-500 p-3 rounded-xl bg-slate-50 border border-dashed border-slate-200">No social links yet.</p>
        @endforelse
    </div>

    <div x-show="openModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
        <div class="min-h-full px-4 py-8 flex items-center justify-center">
            <div class="fixed inset-0 bg-slate-900/60" @click="openModal = false"></div>
            <div class="relative bg-white rounded-2xl border shadow-2xl max-w-md w-full p-6 space-y-4 z-10">
                <h4 class="text-sm font-bold text-slate-900" x-text="editingId ? 'Edit social link' : 'Add social link'"></h4>
                <form :action="editingId ? ('/admin/socials/' + editingId) : '{{ route('admin.socials.store') }}'" method="POST" class="space-y-3">
                    @csrf
                    <template x-if="editingId"><input type="hidden" name="_method" value="PUT"></template>
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Platform</label>
                        <input type="text" name="title" x-model="title" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">URL</label>
                        <input type="url" name="link" x-model="link" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-mono">
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Icon</label>
                        <select name="icon_class" x-model="iconClass" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                            <option value="bi-linkedin">LinkedIn</option>
                            <option value="bi-twitter-x">X / Twitter</option>
                            <option value="bi-facebook">Facebook</option>
                            <option value="bi-instagram">Instagram</option>
                            <option value="bi-youtube">YouTube</option>
                            <option value="bi-github">GitHub</option>
                            <option value="bi-globe">Website</option>
                        </select>
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
                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" @click="openModal = false" class="px-4 py-2 text-xs font-bold text-slate-600">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-brand-600 text-white text-xs font-bold rounded-xl">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
