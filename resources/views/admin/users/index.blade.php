@extends('admin.layouts.app')

@section('title', 'Users & Staff')
@section('page-title', 'Users & Staff Management')
@section('page-subtitle', 'Platform Administrators')

@section('content')
<div class="space-y-6" x-data="{
    openModal: false,
    editingId: null,
    name: '',
    email: '',
    role: 'editor',

    create() {
        this.editingId = null;
        this.name = '';
        this.email = '';
        this.role = 'editor';
        this.openModal = true;
    },

    edit(u) {
        this.editingId = u.id;
        this.name = u.name || '';
        this.email = u.email || '';
        this.role = u.organizations?.[0]?.pivot?.role || 'editor';
        this.openModal = true;
    }
}">

    <!-- Header Actions Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
        <div>
            <h2 class="text-base font-bold text-slate-900">Platform Users & Team Access</h2>
            <p class="text-xs text-slate-500 mt-0.5">Manage administrators, editors, and tenant assignment access roles.</p>
        </div>
        <button type="button" @click="create()" class="inline-flex items-center gap-2 px-4 py-2 bg-brand-600 hover:bg-brand-500 text-white text-xs font-bold rounded-xl shadow-lg shadow-brand-600/30 transition shrink-0">
            <i class="bi bi-person-plus"></i>
            <span>Create New User (Modal)</span>
        </button>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50/80 border-b border-slate-200 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                    <tr>
                        <th class="px-6 py-4">User</th>
                        <th class="px-6 py-4">Assigned Organizations</th>
                        <th class="px-6 py-4">Created Date</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($users as $u)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-slate-800 text-white flex items-center justify-center font-bold text-xs">
                                        {{ mb_substr($u->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <span class="font-bold text-slate-900 text-sm block">{{ $u->name }}</span>
                                        <span class="text-slate-500 text-xs">{{ $u->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-1.5 flex-wrap">
                                    @foreach($u->organizations as $o)
                                        <span class="px-2.5 py-1 rounded-lg bg-slate-100 font-semibold text-slate-700 text-[11px]">
                                            {{ $o->title }} ({{ $o->pivot->role ?? 'member' }})
                                        </span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-500 font-mono text-[11px]">
                                {{ $u->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <button type="button" @click="edit({{ json_encode($u) }})" class="p-2 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-lg transition" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                @if(auth()->id() !== $u->id)
                                    <form action="{{ route('admin.users.destroy', $u) }}" method="POST" class="inline" onsubmit="return confirm('Delete this user?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-lg transition" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $users->links() }}
            </div>
        @endif
    </div>

    <!-- MODAL: ADD / EDIT USER -->
    <div x-show="openModal" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
        <div class="min-h-full px-4 py-8 flex items-center justify-center">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" @click="openModal = false"></div>

            <div class="relative bg-white rounded-2xl border border-slate-200 shadow-2xl max-w-lg w-full p-6 lg:p-8 space-y-6 z-10">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <h3 class="text-base font-bold text-slate-900" x-text="editingId ? 'Edit User Account' : 'Create New User Account'"></h3>
                    <button @click="openModal = false" class="text-slate-400 hover:text-slate-700"><i class="bi bi-x-lg"></i></button>
                </div>

                <form :action="editingId ? ('/admin/users/' + editingId) : '{{ route('admin.users.store') }}'" method="POST" class="space-y-4">
                    @csrf
                    <template x-if="editingId">
                        <input type="hidden" name="_method" value="PUT">
                    </template>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Full Name <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" x-model="name" required placeholder="John Doe" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Email Address <span class="text-rose-500">*</span></label>
                        <input type="email" name="email" x-model="email" required placeholder="john@example.com" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Password <span x-show="!editingId" class="text-rose-500">*</span><span x-show="editingId" class="text-slate-400 font-normal">(Leave blank to keep current)</span></label>
                        <input type="password" name="password" :required="!editingId" placeholder="••••••••" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Access Role on Active Organization</label>
                        <select name="role" x-model="role" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                            <option value="owner">Owner (Full Permissions)</option>
                            <option value="admin">Admin (Manage Content & Members)</option>
                            <option value="editor">Editor (Manage Website Content)</option>
                            <option value="viewer">Viewer (Read Only)</option>
                        </select>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                        <button type="button" @click="openModal = false" class="px-4 py-2 bg-slate-100 text-slate-700 text-xs font-bold rounded-xl">Cancel</button>
                        <button type="submit" class="px-5 py-2 bg-brand-600 hover:bg-brand-500 text-white text-xs font-bold rounded-xl shadow-lg shadow-brand-600/30">Save User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
