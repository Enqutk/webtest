@props([
    'title' => 'Navigation links',
    'description' => 'Every link appears in the header. Choose whether it also shows in the footer Explore column.',
])

<div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm space-y-4" x-data="sitePageNavLinks">
    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
        <div>
            <h3 class="text-sm font-bold text-slate-900">{{ $title }}</h3>
            <p class="text-xs text-slate-500 mt-0.5">{{ $description }}</p>
        </div>
        <button type="button" @click="openAdd()" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold rounded-lg transition">
            + Add link
        </button>
    </div>

    <div class="space-y-2">
        @forelse($navItems as $item)
            <div class="flex items-center justify-between gap-2 p-3 rounded-xl bg-slate-50 border border-slate-200/80">
                <div class="min-w-0 flex-1">
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="text-xs font-bold text-slate-900 truncate">{{ $item->title }}</span>
                        <span class="px-1.5 py-0.5 rounded text-[10px] font-bold {{ $item->show_in_footer ? 'bg-brand-50 text-brand-700' : 'bg-slate-200 text-slate-600' }}">
                            {{ $item->show_in_footer ? 'Header + footer' : 'Header only' }}
                        </span>
                    </div>
                    <div class="text-[11px] text-slate-500 font-mono truncate">{{ $item->url }}</div>
                </div>
                <div class="flex items-center gap-1 shrink-0">
                    <button type="button" @click="openEdit(@json($item))" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <form action="{{ route('admin.menus.items.destroy', $item) }}" method="POST" onsubmit="return confirm('Remove this link?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-1.5 text-rose-500 hover:bg-rose-50 rounded-lg" title="Delete">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-xs text-slate-500 p-3 rounded-xl bg-slate-50 border border-dashed border-slate-200">No links yet. Add Home, About, Services, Portfolio, Contact.</p>
        @endforelse
    </div>

    <div x-show="openModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
        <div class="min-h-full px-4 py-8 flex items-center justify-center">
            <div class="fixed inset-0 bg-slate-900/60" @click="openModal = false"></div>
            <div class="relative bg-white rounded-2xl border shadow-2xl max-w-md w-full p-6 space-y-4 z-10">
                <h4 class="text-sm font-bold text-slate-900" x-text="editingId ? 'Edit nav link' : 'Add nav link'"></h4>
                <form :action="editingId ? ('/admin/menus/items/' + editingId) : '{{ route('admin.menus.items.store') }}'" method="POST" class="space-y-3">
                    @csrf
                    <template x-if="editingId">
                        <input type="hidden" name="_method" value="PUT">
                    </template>
                    <input type="hidden" name="menu_id" value="{{ $headerMenu->id }}">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Label</label>
                        <input type="text" name="title" x-model="itemTitle" required placeholder="e.g. About" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">URL</label>
                        <input type="text" name="url" x-model="itemUrl" required placeholder="/about or /contact" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-mono">
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Show in</label>
                        <select name="show_in_footer" x-model="itemShowInFooter" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                            <option value="1">Header and footer</option>
                            <option value="0">Header only</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700">Order</label>
                            <input type="number" name="order_number" x-model="itemOrder" min="1" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700">Opens in</label>
                            <select name="target" x-model="itemTarget" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                                <option value="_self">Same tab</option>
                                <option value="_blank">New tab</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" @click="openModal = false" class="px-4 py-2 text-xs font-bold text-slate-600">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-brand-600 text-white text-xs font-bold rounded-xl">Save link</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@once
@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('sitePageNavLinks', () => ({
        openModal: false,
        editingId: null,
        itemTitle: '',
        itemUrl: '/',
        itemOrder: {{ ($navItems->max('order_number') ?? 0) + 1 }},
        itemTarget: '_self',
        itemShowInFooter: '1',
        openAdd() {
            this.editingId = null;
            this.itemTitle = '';
            this.itemUrl = '/';
            this.itemOrder = {{ ($navItems->max('order_number') ?? 0) + 1 }};
            this.itemTarget = '_self';
            this.itemShowInFooter = '1';
            this.openModal = true;
        },
        openEdit(item) {
            this.editingId = item.id;
            this.itemTitle = item.title || '';
            this.itemUrl = item.url || '/';
            this.itemOrder = item.order_number || 1;
            this.itemTarget = item.target || '_self';
            this.itemShowInFooter = item.show_in_footer === false || item.show_in_footer === 0 ? '0' : '1';
            this.openModal = true;
        },
    }));
});
</script>
@endpush
@endonce
