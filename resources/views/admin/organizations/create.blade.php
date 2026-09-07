@extends('admin.layouts.app')

@section('title', 'Add Organization / Invite Client')
@section('header', 'Add Organization or Invite Client')
@section('subheader', 'Choose whether to send a mobile self-onboarding link to your client or configure the organization manually.')

@section('content')
<div class="max-w-4xl mx-auto space-y-6" x-data="{ mode: '{{ session('invitation_created') ? 'invite' : 'invite' }}' }">

    <!-- Top Action Bar -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.organizations.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-slate-900 transition">
            <i class="bi bi-arrow-left"></i>
            <span>Back to Organizations Directory</span>
        </a>
    </div>

    <!-- Success Modal/Banner if an invitation was just generated -->
    @if(session('invitation_created'))
        @php
            $invite = session('invitation_created');
            $inviteUrl = $invite->getInvitationUrl();
            $clientPhoneDigits = preg_replace('/[^0-9]/', '', $invite->client_phone ?? '');
            $shareMsg = "Hello {$invite->client_name}, here is your private link to design your Kimem NFC Smart Card & Digital Profile: {$inviteUrl}";
        @endphp
        <div class="p-6 rounded-2xl bg-gradient-to-br from-emerald-50 via-white to-amber-50 border border-emerald-200 text-slate-900 space-y-4 shadow-lg"
             x-data="{
                copied: false,
                saved: false,
                copyLink() {
                    navigator.clipboard.writeText(@js($inviteUrl));
                    this.copied = true;
                    setTimeout(() => this.copied = false, 2500);
                },
                saveLinkFile() {
                    const body = `Kimem Cards — Private Invitation\n\nClient: {{ $invite->client_name }}\nRole: {{ $invite->initial_role ?: '—' }}\nPhone: {{ $invite->client_phone ?: '—' }}\nEmail: {{ $invite->client_email ?: '—' }}\nCode: {{ $invite->token }}\nLink: {{ $inviteUrl }}\n\nOpen on mobile for the best experience.`;
                    const blob = new Blob([body], { type: 'text/plain' });
                    const a = document.createElement('a');
                    a.href = URL.createObjectURL(blob);
                    a.download = 'kimem-invite-{{ $invite->token }}.txt';
                    a.click();
                    URL.revokeObjectURL(a.href);
                    this.saved = true;
                    setTimeout(() => this.saved = false, 2500);
                }
             }">
            <div class="flex items-start justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-xl">
                        <i class="bi bi-send-check-fill"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900">Invitation created for {{ $invite->client_name }}</h3>
                        <p class="text-xs text-slate-600 mt-0.5">Send the link below — or call / WhatsApp them directly from here.</p>
                    </div>
                </div>
                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700 font-mono shrink-0">
                    {{ $invite->token }}
                </span>
            </div>

            <div class="p-3.5 rounded-xl bg-white border border-slate-200">
                <div class="font-mono text-xs text-amber-700 font-bold break-all select-all">{{ $inviteUrl }}</div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-2">
                <button type="button" @click="copyLink()"
                        class="col-span-1 px-3 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-xs font-bold text-white transition flex items-center justify-center gap-1.5 min-h-[44px]">
                    <i class="bi" :class="copied ? 'bi-check-lg text-emerald-400' : 'bi-clipboard'"></i>
                    <span x-text="copied ? 'Copied' : 'Copy'"></span>
                </button>

                <button type="button" @click="saveLinkFile()"
                        class="col-span-1 px-3 py-2.5 rounded-xl bg-white border border-slate-200 hover:border-amber-400 text-xs font-bold text-slate-800 transition flex items-center justify-center gap-1.5 min-h-[44px]">
                    <i class="bi" :class="saved ? 'bi-check-lg text-emerald-600' : 'bi-download'"></i>
                    <span x-text="saved ? 'Saved' : 'Save file'"></span>
                </button>

                @if($clientPhoneDigits)
                <a href="tel:{{ $invite->client_phone }}"
                   class="col-span-1 px-3 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-xs font-bold text-white transition flex items-center justify-center gap-1.5 min-h-[44px]">
                    <i class="bi bi-telephone-fill"></i> Call client
                </a>

                <a href="https://wa.me/{{ $clientPhoneDigits }}?text={{ urlencode($shareMsg) }}" target="_blank" rel="noopener"
                   class="col-span-1 px-3 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-xs font-bold text-white transition flex items-center justify-center gap-1.5 min-h-[44px]">
                    <i class="bi bi-whatsapp"></i> WhatsApp
                </a>

                <a href="sms:{{ $clientPhoneDigits }}?body={{ urlencode($shareMsg) }}"
                   class="col-span-1 px-3 py-2.5 rounded-xl bg-violet-600 hover:bg-violet-500 text-xs font-bold text-white transition flex items-center justify-center gap-1.5 min-h-[44px]">
                    <i class="bi bi-chat-dots"></i> SMS
                </a>
                @else
                <div class="col-span-2 sm:col-span-3 px-3 py-2.5 rounded-xl bg-amber-50 border border-amber-200 text-[10px] text-amber-800 flex items-center gap-2 min-h-[44px]">
                    <i class="bi bi-info-circle"></i> Add client phone next time to enable Call / SMS buttons.
                </div>
                @endif

                @if($invite->client_email)
                <a href="mailto:{{ $invite->client_email }}?subject={{ urlencode('Your Kimem NFC Card invitation') }}&body={{ urlencode($shareMsg) }}"
                   class="col-span-1 px-3 py-2.5 rounded-xl bg-sky-600 hover:bg-sky-500 text-xs font-bold text-white transition flex items-center justify-center gap-1.5 min-h-[44px]">
                    <i class="bi bi-envelope"></i> Email
                </a>
                @endif

                <a href="{{ $inviteUrl }}" target="_blank" rel="noopener"
                   class="col-span-1 px-3 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-xs font-bold text-slate-950 transition flex items-center justify-center gap-1.5 min-h-[44px]">
                    <i class="bi bi-box-arrow-up-right"></i> Open link
                </a>
            </div>
        </div>
    @endif

    <!-- Choice Tabs: Invite Client vs Manual Creation -->
    <div class="grid grid-cols-2 gap-3 bg-slate-200/70 p-1.5 rounded-2xl border border-slate-200">
        <button type="button" @click="mode = 'invite'"
                :class="mode === 'invite' ? 'bg-white text-slate-900 font-bold shadow-sm' : 'text-slate-600 hover:text-slate-900 font-medium'"
                class="py-3 px-4 rounded-xl text-xs flex items-center justify-center gap-2 transition">
            <i class="bi bi-send-fill text-amber-500"></i>
            <span>Option 1: Send Mobile Invitation Link (Google Meet Style)</span>
        </button>

        <button type="button" @click="mode = 'manual'"
                :class="mode === 'manual' ? 'bg-white text-slate-900 font-bold shadow-sm' : 'text-slate-600 hover:text-slate-900 font-medium'"
                class="py-3 px-4 rounded-xl text-xs flex items-center justify-center gap-2 transition">
            <i class="bi bi-gear-fill text-indigo-500"></i>
            <span>Option 2: Configure Manually as Admin</span>
        </button>
    </div>

    <!-- OPTION 1: Send Mobile Invitation Link -->
    <div x-show="mode === 'invite'" class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 lg:p-8 space-y-6">
        <div class="border-b border-slate-100 pb-4">
            <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-amber-50 text-amber-700 text-[11px] font-bold uppercase tracking-wider mb-2">
                <i class="bi bi-phone-fill"></i> Mobile-Optimized Self-Onboarding
            </div>
            <h2 class="text-base font-bold text-slate-900">Generate Client Invitation Link</h2>
            <p class="text-xs text-slate-500 mt-0.5">
                Create a private Google Meet-style link (e.g. <code class="text-indigo-600 font-mono">/invite/km-abc-xyz</code>). Your client can open it on their smartphone, pick their colors/fonts with live mobile preview, and submit their quote for your 1-click approval.
            </p>
        </div>

        <form action="{{ route('admin.organizations.invite') }}" method="POST" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Client / Executive Name <span class="text-rose-500">*</span></label>
                    <input type="text" name="client_name" required placeholder="e.g. Dr. Elias Vance"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:ring-1 focus:ring-amber-500 transition">
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Role / Title (Optional)</label>
                    <input type="text" name="initial_role" placeholder="e.g. Senior Partner & Strategic Advisor"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:ring-1 focus:ring-amber-500 transition">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Client Phone / WhatsApp <span class="text-amber-600 font-normal">(for Call & SMS buttons)</span></label>
                    <input type="text" name="client_phone" placeholder="+251 9... / +1 212..."
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:ring-1 focus:ring-amber-500 transition">
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Client Email (Optional)</label>
                    <input type="email" name="client_email" placeholder="client@example.com"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:ring-1 focus:ring-amber-500 transition">
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700">Pre-Selected Physical Card Edition</label>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <label class="cursor-pointer">
                        <input type="radio" name="card_edition" value="midnight_navy" checked class="sr-only peer">
                        <div class="p-3 rounded-xl border border-slate-200 bg-slate-50 peer-checked:border-amber-500 peer-checked:bg-amber-50/50 transition text-xs">
                            <div class="font-bold text-slate-900">Midnight Obsidian Navy</div>
                            <div class="text-[10px] text-slate-500">1,850 ETB</div>
                        </div>
                    </label>

                    <label class="cursor-pointer">
                        <input type="radio" name="card_edition" value="brushed_gold" class="sr-only peer">
                        <div class="p-3 rounded-xl border border-slate-200 bg-slate-50 peer-checked:border-amber-500 peer-checked:bg-amber-50/50 transition text-xs">
                            <div class="font-bold text-slate-900">Brushed Gold Luxe</div>
                            <div class="text-[10px] text-slate-500">2,450 ETB (VIP)</div>
                        </div>
                    </label>

                    <label class="cursor-pointer">
                        <input type="radio" name="card_edition" value="executive_black" class="sr-only peer">
                        <div class="p-3 rounded-xl border border-slate-200 bg-slate-50 peer-checked:border-amber-500 peer-checked:bg-amber-50/50 transition text-xs">
                            <div class="font-bold text-slate-900">Executive Stealth Black</div>
                            <div class="text-[10px] text-slate-500">2,150 ETB</div>
                        </div>
                    </label>
                </div>
            </div>

            <div class="pt-4 flex justify-end">
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 font-extrabold text-xs rounded-xl transition shadow-md shadow-amber-500/20 flex items-center gap-2">
                    <i class="bi bi-link-45deg text-base"></i> Generate Private Invitation Link
                </button>
            </div>
        </form>

        <!-- Recent Active Invitations Table -->
        @if(isset($recentInvitations) && $recentInvitations->isNotEmpty())
            <div class="border-t border-slate-100 pt-6 space-y-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">Recently Generated Invitations</h3>
                <div class="divide-y divide-slate-100 border border-slate-200 rounded-xl overflow-hidden text-xs">
                    @foreach($recentInvitations as $inv)
                        <div class="p-3 bg-slate-50/50 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 hover:bg-slate-100/60 transition">
                            <div>
                                <div class="font-bold text-slate-900">{{ $inv->client_name }} <span class="text-[10px] text-slate-400 font-normal">({{ $inv->initial_role ?: 'Client' }})</span></div>
                                <div class="font-mono text-[10px] text-indigo-600 font-bold mt-0.5">{{ $inv->getInvitationUrl() }}</div>
                            </div>
                            <div class="flex items-center gap-1.5 shrink-0 flex-wrap justify-end">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $inv->status === 'completed' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                    {{ ucfirst($inv->status) }}
                                </span>
                                @if($inv->client_phone)
                                <a href="tel:{{ $inv->client_phone }}" class="p-2 rounded-lg bg-blue-50 border border-blue-200 text-blue-700 hover:bg-blue-100 text-xs" title="Call {{ $inv->client_name }}">
                                    <i class="bi bi-telephone-fill"></i>
                                </a>
                                @endif
                                <a href="{{ $inv->getInvitationUrl() }}" target="_blank" rel="noopener" class="p-2 rounded-lg bg-white border border-slate-200 text-slate-600 hover:text-slate-900 text-xs" title="Open invite">
                                    <i class="bi bi-box-arrow-up-right"></i>
                                </a>
                                <button type="button" @click="navigator.clipboard.writeText('{{ $inv->getInvitationUrl() }}')" class="p-2 rounded-lg bg-white border border-slate-200 text-slate-600 hover:text-slate-900 text-xs" title="Copy URL">
                                    <i class="bi bi-clipboard"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <!-- OPTION 2: Manual Organization Configuration -->
    <div x-show="mode === 'manual'" class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 lg:p-8 space-y-6" x-cloak>
        <div class="border-b border-slate-100 pb-4">
            <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-indigo-50 text-indigo-700 text-[11px] font-bold uppercase tracking-wider mb-2">
                <i class="bi bi-shield-lock-fill"></i> Admin Direct Creation
            </div>
            <h2 class="text-base font-bold text-slate-900">Configure Organization Manually</h2>
            <p class="text-xs text-slate-500 mt-0.5">Directly input all company information, slug, custom domain, and theme settings.</p>
        </div>

        <form action="{{ route('admin.organizations.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label for="title" class="block text-xs font-bold text-slate-700">Company / Organization Name <span class="text-rose-500">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required placeholder="e.g. Maji Works East Africa"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:ring-1 focus:ring-indigo-500 transition">
                </div>

                <div class="space-y-1.5">
                    <label for="slug" class="block text-xs font-bold text-slate-700">URL Slug / Identifier</label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug') }}" placeholder="e.g. maji-works"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:ring-1 focus:ring-indigo-500 transition">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label for="domain" class="block text-xs font-bold text-slate-700">Custom Domain Name (Optional)</label>
                    <input type="text" name="domain" id="domain" value="{{ old('domain') }}" placeholder="e.g. majiworks.org"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:ring-1 focus:ring-indigo-500 transition">
                </div>

                <div class="space-y-1.5">
                    <label for="status" class="block text-xs font-bold text-slate-700">Status</label>
                    <select name="status" id="status" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                        <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>

            <div class="space-y-1.5">
                <label for="tagline" class="block text-xs font-bold text-slate-700">Tagline / Mission Statement</label>
                <input type="text" name="tagline" id="tagline" value="{{ old('tagline') }}" placeholder="e.g. Empowering East African Communities with Smart Water Infrastructure"
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:ring-1 focus:ring-indigo-500 transition">
            </div>

            <div class="pt-4 flex justify-end">
                <button type="submit" class="px-6 py-3 bg-brand-600 hover:bg-brand-500 text-white font-bold text-xs rounded-xl transition shadow-md shadow-brand-600/20 flex items-center gap-2">
                    <i class="bi bi-check2-circle text-base"></i> Save & Open Visual Studio
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
