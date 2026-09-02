@extends('admin.layouts.app')

@section('title', 'Navigation Menus')
@section('page-title', 'Navigation Menus')
@section('page-subtitle', $currentOrg->title)

@section('content')
<div class="space-y-6" x-data="{
    openLocationModal: false,
    openItemModal: false,
    editingItemId: null,
    selectedMenuId: {{ $menus->first()?->id ?? 'null' }},
    itemTitle: '',
    itemUrl: '',
    itemOrder: 1,
    itemTarget: '_self',
    itemIcon: '',

    createItem(menuId) {
        this.editingItemId = null;
        this.selectedMenuId = menuId;
        this.itemTitle = '';
        this.itemUrl = '/';
        this.itemOrder = 1;
        this.itemTarget = '_self';
        this.itemIcon = '';
        this.openItemModal = true;
    },

    editItem(item) {
        this.editingItemId = item.id;
        this.selectedMenuId = item.menu_id;
        this.itemTitle = item.title || '';
        this.itemUrl = item.url || '';
        this.itemOrder = item.order_number || 1;
        this.itemTarget = item.target || '_self';
        this.itemIcon = item.icon || '';
        this.openItemModal = true;
    }
}">

    <!-- Header Actions Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
        <div>
            <h2 class="text-base font-bold text-slate-900">Website Navigation Menus</h2>
            <p class="text-xs text-slate-500 mt-0.5">Manage Header navbar links, footer menus, and dropdown destinations for {{ $currentOrg->title }}.</p>
        </div>
        <button type="button" @click="openLocationModal = true" class="inline-flex items-center gap-2 px-4 py-2 bg-brand-600 hover:bg-brand-500 text-white text-xs font-bold rounded-xl shadow-lg shadow-brand-600/30 transition shrink-0">
            <i class="bi bi-plus-circle"></i>
            <span>Create New Menu Location</span>
        </button>
    </div>

    <!-- Menus Container -->
    <div class="space-y-6">
        @forelse($menus as $menu)
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-slate-100 flex items-center justify-center text-slate-700 font-bold text-sm">
                            <i class="bi bi-list-nested"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-900">{{ $menu->name }}</h3>
                            <span class="text-[11px] font-mono text-slate-400">Location: {{ $menu->location->value ?? $menu->location ?? 'header' }}</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <button type="button" @click="createItem({{ $menu->id }})" class="px-3 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-xs font-bold rounded-lg transition flex items-center gap-1.5">
                            <i class="bi bi-plus"></i>
                            <span>Add Link</span>
                        </button>
                    </div>
                </div>

                <!-- Menu Items List -->
                <div class="space-y-2">
                    @forelse($menu->items as $item)
                        <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 hover:bg-slate-100/80 border border-slate-200/80 transition">
                            <div class="flex items-center gap-3">
                                <span class="w-6 h-6 rounded-md bg-white border border-slate-200 flex items-center justify-center font-bold text-slate-500 text-[11px]">
                                    {{ $item->order_number }}
                                </span>
                                <div>
                                    <span class="text-xs font-bold text-slate-900">{{ $item->title }}</span>
                                    <span class="text-[11px] font-mono text-brand-600 ml-2">{{ $item->url }}</span>
                                </div>
                            </div>

                            <div class="flex items-center gap-2">
                                <button type="button" @click="editItem({{ json_encode($item) }})" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg transition">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <form action="{{ route('admin.menus.items.destroy', $item) }}" method="POST" onsubmit="return confirm('Remove this link?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-rose-500 hover:bg-rose-50 rounded-lg transition">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-6 text-slate-400 text-xs">
                            No menu links added yet. Click "Add Link" to create one.
                        </div>
                    @endforelse
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center text-slate-400 text-xs">
                No menus created yet. Click "Create New Menu Location" above.
            </div>
        @endforelse
    </div>

    <!-- MODAL: ADD / EDIT MENU ITEM LINK -->
    <div x-show="openItemModal" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
        <div class="min-h-full px-4 py-8 flex items-center justify-center">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" @click="openItemModal = false"></div>

            <div class="relative bg-white rounded-2xl border border-slate-200 shadow-2xl max-w-lg w-full p-6 lg:p-8 space-y-6 z-10">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <h3 class="text-base font-bold text-slate-900" x-text="editingItemId ? 'Edit Menu Link' : 'Add New Menu Link'"></h3>
                    <button @click="openItemModal = false" class="text-slate-400 hover:text-slate-700"><i class="bi bi-x-lg"></i></button>
                </div>

                <form :action="editingItemId ? ('/admin/menus/items/' + editingItemId) : '{{ route('admin.menus.items.store') }}'" method="POST" class="space-y-4">
                    @csrf
                    <template x-if="editingItemId">
                        <input type="hidden" name="_method" value="PUT">
                    </template>
                    <input type="hidden" name="menu_id" :value="selectedMenuId">

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Link Label / Title <span class="text-rose-500">*</span></label>
                        <input type="text" name="title" x-model="itemTitle" required placeholder="e.g. Services, About Us, Case Studies" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">URL / Target Path <span class="text-rose-500">*</span></label>
                        <input type="text" name="url" x-model="itemUrl" required placeholder="e.g. /our-services, /about, https://..." class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 font-mono focus:bg-white transition">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700">Order Number</label>
                            <input type="number" name="order_number" x-model="itemOrder" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700">Target</label>
                            <select name="target" x-model="itemTarget" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                                <option value="_self">Same Tab (_self)</option>
                                <option value="_blank">New Tab (_blank)</option>
                            </select>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                        <button type="button" @click="openItemModal = false" class="px-4 py-2 bg-slate-100 text-slate-700 text-xs font-bold rounded-xl">Cancel</button>
                        <button type="submit" class="px-5 py-2 bg-brand-600 hover:bg-brand-500 text-white text-xs font-bold rounded-xl shadow-lg shadow-brand-600/30">Save Link</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL: ADD MENU LOCATION -->
    <div x-show="openLocationModal" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
        <div class="min-h-full px-4 py-8 flex items-center justify-center">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" @click="openLocationModal = false"></div>

            <div class="relative bg-white rounded-2xl border border-slate-200 shadow-2xl max-w-lg w-full p-6 lg:p-8 space-y-6 z-10">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <h3 class="text-base font-bold text-slate-900">Create Menu Location</h3>
                    <button @click="openLocationModal = false" class="text-slate-400 hover:text-slate-700"><i class="bi bi-x-lg"></i></button>
                </div>

                <form action="{{ route('admin.menus.locations.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Menu Name <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" required placeholder="e.g. Main Header Navigation" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Placement Location <span class="text-rose-500">*</span></label>
                        <select name="location" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                            <option value="header">Header Navigation</option>
                            <option value="footer">Footer Navigation</option>
                            <option value="sidebar">Sidebar Navigation</option>
                        </select>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                        <button type="button" @click="openLocationModal = false" class="px-4 py-2 bg-slate-100 text-slate-700 text-xs font-bold rounded-xl">Cancel</button>
                        <button type="submit" class="px-5 py-2 bg-brand-600 hover:bg-brand-500 text-white text-xs font-bold rounded-xl shadow-lg shadow-brand-600/30">Create Menu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
