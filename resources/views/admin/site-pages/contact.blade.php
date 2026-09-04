@extends('admin.site-pages.layout')

@section('title', 'Contact page')
@section('page-title', 'Contact page')
@section('page-subtitle', $currentOrg->title)

@section('page-form')
@php
    $contactEmails = ($contacts ?? collect())->get('email')?->pluck('value')->filter()->values() ?? collect();
    $contactPhones = ($contacts ?? collect())->get('phone')?->pluck('value')->filter()->values() ?? collect();
    if ($contactEmails->isEmpty()) { $contactEmails = collect(['']); }
    if ($contactPhones->isEmpty()) { $contactPhones = collect(['']); }
    $openingHours = collect($currentOrg->opening_hours ?? [])->map(function ($slot) {
        return [
            'days' => $slot['days'] ?? [],
            'from' => isset($slot['from']) ? substr((string) $slot['from'], 0, 5) : '',
            'to' => isset($slot['to']) ? substr((string) $slot['to'], 0, 5) : '',
        ];
    })->values()->all();
    if ($openingHours === []) {
        $openingHours = [['days' => ['mon', 'tue', 'wed', 'thu', 'fri'], 'from' => '08:00', 'to' => '17:00']];
    }
    $dayOptions = \App\Models\Organization::getDayOptions();
@endphp

<div x-data="contactPageForm">
    <form action="{{ route('admin.site-pages.update', 'contact') }}" method="POST" class="space-y-6">
        @csrf

        <div id="page-header" class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm space-y-4">
            <div>
                <h3 class="text-sm font-bold text-slate-900">Page header banner</h3>
                <p class="text-[11px] text-slate-500 mt-0.5">Title bar at the top of the Contact page.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border-t border-slate-100 pt-4">
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Eyebrow</label>
                    <input type="text" name="eyebrow" value="{{ $data['eyebrow'] ?? '' }}" data-preview-bind="page-hero:eyebrow" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Title</label>
                    <input type="text" name="title" value="{{ $data['title'] ?? '' }}" required data-preview-bind="page-hero:title" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                </div>
            </div>
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700">Hero description</label>
                <textarea name="description" rows="2" data-preview-bind="page-hero:description" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">{{ $data['description'] ?? '' }}</textarea>
            </div>
        </div>

        <div id="contact-intro" class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm space-y-4">
            <div>
                <h3 class="text-sm font-bold text-slate-900">Form introduction</h3>
                <p class="text-[11px] text-slate-500 mt-0.5">Short paragraph above the contact form on the left.</p>
            </div>
            <div class="space-y-1.5 border-t border-slate-100 pt-4">
                <textarea name="intro" rows="3" data-preview-bind="contact-page-intro:intro" @input="pushIntro($event.target.value)" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">{{ $data['intro'] ?? '' }}</textarea>
            </div>
        </div>

        <div id="contact-details" class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm space-y-5">
            <div>
                <h3 class="text-sm font-bold text-slate-900">Contact details sidebar</h3>
                <p class="text-[11px] text-slate-500 mt-0.5">Phone, email, address, and working hours shown in the dark panel on the right.</p>
            </div>

            <div id="contact-emails" class="space-y-2 border-t border-slate-100 pt-4">
                <label class="block text-xs font-bold text-slate-700">Email addresses</label>
                <template x-for="(email, i) in emails" :key="'email-'+i">
                    <div class="flex gap-2">
                        <input type="email" :name="'contact_emails['+i+']'" x-model="emails[i]" @input="pushEmails()" placeholder="hello@example.com" class="flex-1 px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                        <button type="button" @click="emails.splice(i, 1); pushEmails()" x-show="emails.length > 1" class="px-2 text-rose-500"><i class="bi bi-x-lg"></i></button>
                    </div>
                </template>
                <button type="button" @click="emails.push(''); pushEmails()" class="text-[11px] font-bold text-brand-700">+ Add email</button>
            </div>

            <div id="contact-phones" class="space-y-2">
                <label class="block text-xs font-bold text-slate-700">Phone numbers</label>
                <template x-for="(phone, i) in phones" :key="'phone-'+i">
                    <div class="flex gap-2">
                        <input type="text" :name="'contact_phones['+i+']'" x-model="phones[i]" @input="pushPhones()" placeholder="+254 700 000 000" class="flex-1 px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                        <button type="button" @click="phones.splice(i, 1); pushPhones()" x-show="phones.length > 1" class="px-2 text-rose-500"><i class="bi bi-x-lg"></i></button>
                    </div>
                </template>
                <button type="button" @click="phones.push(''); pushPhones()" class="text-[11px] font-bold text-brand-700">+ Add phone</button>
            </div>

            <div id="contact-address" class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700">Address</label>
                <textarea name="address" rows="2" x-model="address" @input="pushField('address', address)" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">{{ $currentOrg->address }}</textarea>
            </div>

            <div id="contact-hours" class="space-y-3">
                <div class="flex items-center justify-between">
                    <label class="block text-xs font-bold text-slate-700">Working hours</label>
                    <button type="button" @click="addHoursSlot()" class="text-[11px] font-bold text-brand-700">+ Add slot</button>
                </div>
                <template x-for="(slot, index) in hoursSlots" :key="'hours-'+index">
                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 space-y-3">
                        <div class="flex flex-wrap gap-2">
                            @foreach($dayOptions as $key => $label)
                                <label class="inline-flex items-center gap-1 text-[11px] font-semibold text-slate-600">
                                    <input type="checkbox" :name="'opening_hours['+index+'][days][]'" value="{{ $key }}" x-model="hoursSlots[index].days" @change="pushHours()" class="rounded text-brand-600">
                                    {{ $label }}
                                </label>
                            @endforeach
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <input type="time" :name="'opening_hours['+index+'][from]'" x-model="hoursSlots[index].from" @input="pushHours()" class="px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs">
                            <input type="time" :name="'opening_hours['+index+'][to]'" x-model="hoursSlots[index].to" @input="pushHours()" class="px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs">
                        </div>
                        <button type="button" @click="hoursSlots.splice(index, 1); pushHours()" x-show="hoursSlots.length > 1" class="text-[11px] font-bold text-rose-600">Remove slot</button>
                    </div>
                </template>
            </div>
        </div>

        <div id="contact-social" class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm">
            <div class="mb-4">
                <h3 class="text-sm font-bold text-slate-900">Social links</h3>
                <p class="text-[11px] text-slate-500 mt-0.5">Icons shown at the bottom of the contact details panel.</p>
            </div>
            @include('admin.site-pages._social-links', ['bare' => true])
        </div>

        <button type="submit" class="px-6 py-3 bg-brand-600 hover:bg-brand-500 text-white text-sm font-bold rounded-xl shadow-lg shadow-brand-600/30">Save Contact page</button>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('contactPageForm', () => ({
        emails: @json($contactEmails->values()->all()),
        phones: @json($contactPhones->values()->all()),
        address: @json($currentOrg->address ?? ''),
        hoursSlots: @json($openingHours),
        dayLabels: @json($dayOptions),

        pushField(field, value) {
            window.AdminPreview?.pushField('contact-page-details', field, value);
        },
        pushIntro(value) {
            window.AdminPreview?.pushField('contact-page-intro', 'intro', value);
        },
        pushEmails() {
            const first = (this.emails.find((e) => e && e.trim()) || '').trim();
            this.pushField('email', first || 'Not configured');
        },
        pushPhones() {
            const first = (this.phones.find((p) => p && p.trim()) || '').trim();
            this.pushField('phone', first || 'Not configured');
        },
        addHoursSlot() {
            this.hoursSlots.push({ days: ['mon'], from: '09:00', to: '17:00' });
            this.pushHours();
        },
        formatHoursLine(slot) {
            if (!slot.days?.length || !slot.from || !slot.to) return '';
            const labels = slot.days.map((d) => this.dayLabels[d] || d);
            const from = (slot.from || '').substring(0, 5);
            const to = (slot.to || '').substring(0, 5);
            return labels.join('–') + ': ' + from + ' – ' + to;
        },
        pushHours() {
            const lines = this.hoursSlots.map((slot) => this.formatHoursLine(slot)).filter(Boolean);
            this.pushField('hours', lines.join('\n') || 'Not configured');
        },
    }));
});
</script>
@endpush
