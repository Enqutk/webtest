@php
    $record = (isset($getRecord) && is_callable($getRecord))
        ? $getRecord()
        : ((isset($this) && method_exists($this, 'getRecord')) ? $this->getRecord() : \App\Models\Organization::first());
    $theme = (is_array($record?->theme)) ? $record->theme : \App\Models\Organization::defaultTheme();
    $teamSection = $theme['home_sections']['team'] ?? \App\Models\Organization::defaultHomeSections()['team'];

    $eyebrow = $teamSection['eyebrow'] ?? 'Leadership & Team';
    $title = $teamSection['title'] ?? 'Experienced engineers & hydrologists';
    $desc = $teamSection['description'] ?? 'Multidisciplinary experts dedicated to delivering technical precision and community impact.';
    $ctaText = $teamSection['cta_text'] ?? 'Meet the entire team';
    $ctaUrl = $teamSection['cta_url'] ?? '/about#team';
    $isVisible = $teamSection['is_visible'] ?? true;

    $globalShape = $theme['image_shape'] ?? 'rounded-xl';
    $teamShape = $teamSection['image_shape'] ?? 'inherit';
    $effectiveShape = ($teamShape === 'inherit' || empty($teamShape)) ? $globalShape : $teamShape;
    $teamRadiusCss = \App\Models\Organization::getImageRadiusCss($effectiveShape)['border-radius'];

    $teamMembers = \App\Models\Team::query()->with('media')->orderBy('order')->get();
@endphp

<style>
    .hz-team-manager-wrap {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
        width: 100%;
    }
    .hz-team-thumb-box {
        width: 64px;
        height: 64px;
        min-width: 64px;
        max-width: 64px;
        min-height: 64px;
        max-height: 64px;
        border-radius: {{ $teamRadiusCss }} !important;
        overflow: hidden;
        background: #e5e7eb;
        border: 1px solid #d1d5db;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .dark .hz-team-thumb-box {
        background: #374151;
        border-color: #4b5563;
    }
    .hz-team-thumb-img {
        width: 64px !important;
        height: 64px !important;
        max-width: 64px !important;
        max-height: 64px !important;
        border-radius: {{ $teamRadiusCss }} !important;
        object-fit: cover !important;
        display: block !important;
    }
</style>

<div class="hz-team-manager-wrap">
    {{-- Card 1: Section Header Settings --}}
    <div class="hz-admin-card">
        <div class="hz-card-header">
            <div>
                <h3 style="font-size: 0.95rem; font-weight: 600; margin: 0; color: inherit; display: flex; align-items: center; gap: 0.5rem;">
                    <span>👥</span> Leadership Team Section Settings
                </h3>
                <p style="font-size: 0.75rem; color: #6b7280; margin: 0.2rem 0 0 0;">Configure headline, eyebrow, copy, CTA button, and photo shape style for the team showcase.</p>
            </div>
            <button
                type="button"
                wire:click="mountAction('configureTeamSection')"
                style="display: inline-flex; align-items: center; gap: 0.35rem; padding: 0.45rem 0.9rem; font-size: 0.75rem; font-weight: 600; color: #ffffff; background: #ea580c; border: none; border-radius: 0.5rem; cursor: pointer; transition: background 0.15s;"
                onmouseover="this.style.background='#c2410c'"
                onmouseout="this.style.background='#ea580c'"
            >
                <x-heroicon-m-pencil-square style="width: 1rem; height: 1rem;" />
                Configure Section (Modal)
            </button>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 0.85rem; font-size: 0.8125rem;">
            <div style="padding: 0.75rem; background: rgba(0,0,0,0.02); border: 1px solid rgba(0,0,0,0.06); border-radius: 0.5rem;">
                <div style="font-size: 0.65rem; text-transform: uppercase; font-weight: 600; color: #9ca3af; letter-spacing: 0.05em; margin-bottom: 0.3rem;">Eyebrow & Heading</div>
                <div style="font-weight: 700; font-size: 0.9rem; margin-bottom: 0.3rem;">{{ $title }}</div>
                <div style="color: #6b7280; display: flex; align-items: center; gap: 0.4rem; font-size: 0.75rem; flex-wrap: wrap;">
                    <span class="hz-pill" style="background: rgba(234, 88, 12, 0.12); color: #c2410c;">{{ $eyebrow }}</span>
                    <span>&bull;</span>
                    <span class="hz-pill" style="background: rgba(59, 130, 246, 0.12); color: #2563eb;">🖼️ Photo Shape: {{ ucfirst($effectiveShape) }}</span>
                    <span>&bull;</span>
                    @if($isVisible)
                        <span class="hz-pill" style="background: rgba(16, 185, 129, 0.15); color: #059669;">Section Visible ON</span>
                    @else
                        <span class="hz-pill" style="background: rgba(156, 163, 175, 0.2); color: #6b7280;">Section Hidden OFF</span>
                    @endif
                </div>
            </div>

            <div style="padding: 0.75rem; background: rgba(0,0,0,0.02); border: 1px solid rgba(0,0,0,0.06); border-radius: 0.5rem;">
                <div style="font-size: 0.65rem; text-transform: uppercase; font-weight: 600; color: #9ca3af; letter-spacing: 0.05em; margin-bottom: 0.3rem;">Description & CTA</div>
                <div style="color: #4b5563; font-size: 0.8rem; margin-bottom: 0.4rem; line-height: 1.4;">{{ \Illuminate\Support\Str::limit($desc, 110) }}</div>
                <div>
                    <span style="display: inline-flex; align-items: center; gap: 0.25rem; padding: 0.25rem 0.5rem; background: rgba(0,0,0,0.05); border-radius: 0.375rem; font-size: 0.75rem; font-weight: 500;">
                        🔹 {{ $ctaText }} <span style="opacity: 0.6; font-family: monospace; font-size: 0.7rem;">({{ $ctaUrl }})</span>
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Card 2: Team Members Listed Here --}}
    <div class="hz-admin-card">
        <div class="hz-card-header">
            <div>
                <h3 style="font-size: 0.95rem; font-weight: 600; margin: 0; color: inherit; display: flex; align-items: center; gap: 0.5rem;">
                    <span>👔</span> Team Members (Displayed on Home Page)
                </h3>
                <p style="font-size: 0.75rem; color: #6b7280; margin: 0.2rem 0 0 0;">Manage leadership and staff members shown on the homepage grid with photos and roles.</p>
            </div>
            <button
                type="button"
                wire:click="mountAction('addTeamMember')"
                style="display: inline-flex; align-items: center; gap: 0.35rem; padding: 0.45rem 0.9rem; font-size: 0.75rem; font-weight: 600; color: #ffffff; background: #059669; border: none; border-radius: 0.5rem; cursor: pointer; transition: background 0.15s;"
                onmouseover="this.style.background='#047857'"
                onmouseout="this.style.background='#059669'"
            >
                <x-heroicon-m-plus-circle style="width: 1rem; height: 1rem;" />
                Add Team Member (Modal)
            </button>
        </div>

        @if($teamMembers->isEmpty())
            <div style="text-align: center; padding: 2rem; border: 1px dashed #d1d5db; border-radius: 0.75rem; color: #9ca3af; font-size: 0.875rem;">
                No team members found. Click "Add Team Member (Modal)" to create your first team profile.
            </div>
        @else
            <div>
                @foreach($teamMembers as $member)
                    @php
                        $photoUrl = $member->getFirstMediaUrl('team-images') ?: null;
                        $isActive = ($member->status === \App\Enums\StatusEnum::active);
                    @endphp

                    <div class="hz-slide-row">
                        <div style="display: flex; align-items: center; gap: 0.85rem; min-width: 0;">
                            {{-- Member Photo Thumb --}}
                            <div class="hz-team-thumb-box">
                                @if($photoUrl)
                                    <img src="{{ $photoUrl }}" alt="{{ $member->full_name }}" class="hz-team-thumb-img">
                                @else
                                    <span style="font-size: 0.9rem; font-weight: 700; color: #9ca3af;">
                                        {{ mb_substr($member->first_name, 0, 1) }}{{ mb_substr($member->last_name ?? '', 0, 1) }}
                                    </span>
                                @endif
                            </div>

                            <div style="min-width: 0; display: flex; flex-direction: column; gap: 0.2rem;">
                                <div style="display: flex; align-items: center; gap: 0.45rem; flex-wrap: wrap;">
                                    <span style="font-weight: 700; font-size: 0.875rem; color: inherit;">{{ $member->full_name }}</span>
                                    @if($member->founder)
                                        <span class="hz-pill" style="background: rgba(234, 88, 12, 0.15); color: #c2410c;">FOUNDER</span>
                                    @endif
                                    @if($isActive)
                                        <span class="hz-pill" style="background: rgba(16, 185, 129, 0.15); color: #059669;">Active (Order: {{ $member->order }})</span>
                                    @else
                                        <span class="hz-pill" style="background: rgba(156, 163, 175, 0.2); color: #6b7280;">Inactive</span>
                                    @endif
                                </div>

                                <div style="font-size: 0.75rem; color: #6b7280; display: flex; align-items: center; gap: 0.5rem; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                    <span style="font-weight: 500; color: #c2410c;">{{ $member->title }}</span>
                                    @if($member->description)
                                        <span>&bull;</span>
                                        <span style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 280px;">{{ $member->description }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div style="display: flex; align-items: center; gap: 0.4rem; flex-shrink: 0;">
                            {{-- Toggle Status --}}
                            <button
                                type="button"
                                wire:click="toggleTeamMemberStatus({{ $member->id }})"
                                title="{{ $isActive ? 'Deactivate member' : 'Activate member' }}"
                                style="padding: 0.4rem; border: 1px solid #d1d5db; background: transparent; border-radius: 0.375rem; cursor: pointer;"
                            >
                                @if($isActive)
                                    <x-heroicon-m-eye style="width: 1rem; height: 1rem; color: #059669;" />
                                @else
                                    <x-heroicon-m-eye-slash style="width: 1rem; height: 1rem; color: #9ca3af;" />
                                @endif
                            </button>

                            {{-- Edit Modal Button --}}
                            <button
                                type="button"
                                wire:click="mountAction('editTeamMember', { id: {{ $member->id }} })"
                                style="display: inline-flex; align-items: center; gap: 0.25rem; padding: 0.35rem 0.7rem; font-size: 0.75rem; font-weight: 600; color: #2563eb; background: rgba(37, 99, 235, 0.08); border: 1px solid rgba(37, 99, 235, 0.2); border-radius: 0.375rem; cursor: pointer;"
                            >
                                <x-heroicon-m-pencil-square style="width: 0.875rem; height: 0.875rem;" />
                                Edit (Modal)
                            </button>

                            {{-- Delete Button --}}
                            <button
                                type="button"
                                wire:click="mountAction('deleteTeamMember', { id: {{ $member->id }} })"
                                title="Delete member"
                                style="padding: 0.4rem; border: 1px solid rgba(220, 38, 38, 0.2); background: rgba(220, 38, 38, 0.06); border-radius: 0.375rem; cursor: pointer;"
                            >
                                <x-heroicon-m-trash style="width: 1rem; height: 1rem; color: #dc2626;" />
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
