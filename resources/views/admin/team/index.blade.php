@extends('admin.site-pages.layout')

@section('title', 'Leadership Team')
@section('page-title', 'Leadership Team')
@section('page-subtitle', $currentOrg->title)

@section('page-form')
<div class="space-y-6" x-data="{
    openMemberModal: false,
    editingId: null,
    firstName: '',
    lastName: '',
    title: '',
    bio: '',
    order: 1,
    status: 'active',
    founder: false,

    edit(m) {
        this.editingId = m.id;
        this.firstName = m.first_name || '';
        this.lastName = m.last_name || '';
        this.title = m.title || '';
        this.bio = m.description || '';
        this.order = m.order || 1;
        this.status = m.status?.value || m.status || 'active';
        this.founder = !!m.founder;
        this.openMemberModal = true;
    },

    create() {
        this.editingId = null;
        this.firstName = '';
        this.lastName = '';
        this.title = '';
        this.bio = '';
        this.order = {{ ($members->max('order') ?? 0) + 1 }};
        this.status = 'active';
        this.founder = false;
        this.openMemberModal = true;
    }
}">

    <!-- Header Actions Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
        <div>
            <h2 class="text-base font-bold text-slate-900">Leadership Team & Staff Profiles</h2>
            <p class="text-xs text-slate-500 mt-0.5">Manage team members, roles, founder badges, and headshot photos on {{ $currentOrg->title }}.</p>
        </div>
        <button type="button" @click="create()" class="inline-flex items-center gap-2 px-4 py-2 bg-brand-600 hover:bg-brand-500 text-white text-xs font-bold rounded-xl shadow-lg shadow-brand-600/30 transition shrink-0">
            <i class="bi bi-person-plus-fill"></i>
            <span>Add Team Member (Modal)</span>
        </button>
    </div>

    <!-- Team Members Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50/80 border-b border-slate-200 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                    <tr>
                        <th class="px-6 py-4">Photo</th>
                        <th class="px-6 py-4">Name & Role</th>
                        <th class="px-6 py-4">Founder</th>
                        <th class="px-6 py-4">Display Order</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($members as $m)
                        @php
                            $photo = $m->getFirstMediaUrl('team-images');
                        @endphp
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="px-6 py-4">
                                <div class="w-12 h-12 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center font-bold text-slate-400 overflow-hidden shrink-0">
                                    @if($photo)
                                        <img src="{{ $photo }}" alt="{{ $m->full_name }}" class="w-full h-full object-cover">
                                    @else
                                        {{ mb_substr($m->first_name, 0, 1) }}
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-bold text-slate-900 text-sm block">{{ $m->full_name }}</span>
                                <span class="text-brand-600 font-semibold text-xs block">{{ $m->title }}</span>
                                @if($m->description)
                                    <span class="text-slate-400 text-[11px] truncate block max-w-xs">{{ $m->description }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($m->founder)
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">FOUNDER</span>
                                @else
                                    <span class="text-slate-400">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-mono font-semibold text-slate-700">
                                {{ $m->order }}
                            </td>
                            <td class="px-6 py-4">
                                <form action="{{ route('admin.team.toggle-status', $m) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-2.5 py-1 rounded-full text-[10px] font-bold transition {{ $m->status === \App\Enums\StatusEnum::active ? 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200' : 'bg-slate-200 text-slate-600 hover:bg-slate-300' }}">
                                        {{ ucfirst($m->status->value ?? 'active') }}
                                    </button>
                                </form>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <button type="button" @click="edit({{ json_encode($m) }})" class="p-2 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-lg transition" title="Edit Profile">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <form action="{{ route('admin.team.destroy', $m) }}" method="POST" class="inline" onsubmit="return confirm('Delete this team member?')">
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
                                No team members found. Click "Add Team Member" above to create one.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($members->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $members->links() }}
            </div>
        @endif
    </div>

    <!-- MODAL: ADD / EDIT TEAM MEMBER -->
    <div x-show="openMemberModal" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
        <div class="min-h-full px-4 py-8 flex items-center justify-center">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" @click="openMemberModal = false"></div>

            <!-- Modal Panel -->
            <div class="relative bg-white rounded-2xl border border-slate-200 shadow-2xl max-w-2xl w-full p-6 lg:p-8 space-y-6 z-10">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <h3 class="text-base font-bold text-slate-900" x-text="editingId ? 'Edit Team Member Profile' : 'Add New Team Member'"></h3>
                    <button @click="openMemberModal = false" class="text-slate-400 hover:text-slate-700"><i class="bi bi-x-lg"></i></button>
                </div>

                <form :action="editingId ? ('/admin/team/quick-update/' + editingId) : '{{ route('admin.team.quick-store') }}'" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700">First Name <span class="text-rose-500">*</span></label>
                            <input type="text" name="first_name" x-model="firstName" required placeholder="e.g. Wanjiku" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700">Last Name</label>
                            <input type="text" name="last_name" x-model="lastName" placeholder="e.g. Mwangi" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Role / Title <span class="text-rose-500">*</span></label>
                        <input type="text" name="title" x-model="title" required placeholder="e.g. Managing Director &middot; Hydrogeologist" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Short Bio</label>
                        <textarea name="description" x-model="bio" rows="2" placeholder="Brief professional background" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition"></textarea>
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
                        <label class="block text-xs font-bold text-slate-700">Profile Headshot Photo</label>
                        <input type="file" name="photo" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100">
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <label class="flex items-center gap-2 text-xs font-semibold text-slate-700 cursor-pointer">
                            <input type="checkbox" name="founder" value="1" x-model="founder" class="w-4 h-4 rounded text-brand-600">
                            <span>Show "FOUNDER" Badge</span>
                        </label>

                        <div class="flex items-center gap-3">
                            <button type="button" @click="openMemberModal = false" class="px-4 py-2 bg-slate-100 text-slate-700 text-xs font-bold rounded-xl">Cancel</button>
                            <button type="submit" class="px-5 py-2 bg-brand-600 hover:bg-brand-500 text-white text-xs font-bold rounded-xl shadow-lg shadow-brand-600/30">Save Member</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
