@extends('admin.layouts.app')

@section('title', 'New Organization')
@section('page-title', 'Create Organization')
@section('page-subtitle', 'Add New Tenant')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <a href="{{ route('admin.organizations.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-slate-900 transition">
            <i class="bi bi-arrow-left"></i>
            <span>Back to Organizations Directory</span>
        </a>
    </div>

    <form action="{{ route('admin.organizations.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 lg:p-8 space-y-6">
        @csrf

        <div class="border-b border-slate-100 pb-4">
            <h2 class="text-base font-bold text-slate-900">Register New Tenant Organization</h2>
            <p class="text-xs text-slate-500 mt-0.5">Set up the organization name, unique URL slug, custom domain, and basic details.</p>
        </div>

        @if ($errors->any())
            <div class="p-4 bg-rose-50 border border-rose-200 rounded-xl text-xs text-rose-800 space-y-1">
                @foreach ($errors->all() as $error)
                    <div>&bull; {{ $error }}</div>
                @endforeach
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Company Name -->
            <div class="space-y-1.5">
                <label for="title" class="block text-xs font-bold text-slate-700">Company / Organization Name <span class="text-rose-500">*</span></label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required placeholder="e.g. Maji Works East Africa"
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition">
            </div>

            <!-- Slug -->
            <div class="space-y-1.5">
                <label for="slug" class="block text-xs font-bold text-slate-700">URL Slug / Identifier</label>
                <input type="text" name="slug" id="slug" value="{{ old('slug') }}" placeholder="e.g. maji-works (auto-generated if empty)"
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition">
            </div>

            <!-- Custom Domain -->
            <div class="space-y-1.5">
                <label for="domain" class="block text-xs font-bold text-slate-700">Custom Domain Name (Optional)</label>
                <input type="text" name="domain" id="domain" value="{{ old('domain') }}" placeholder="e.g. majiworks.org"
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition">
            </div>

            <!-- Status -->
            <div class="space-y-1.5">
                <label for="status" class="block text-xs font-bold text-slate-700">Status</label>
                <select name="status" id="status" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:border-brand-500 transition">
                    <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
        </div>

        <!-- Tagline -->
        <div class="space-y-1.5">
            <label for="tagline" class="block text-xs font-bold text-slate-700">Tagline / Mission Statement</label>
            <input type="text" name="tagline" id="tagline" value="{{ old('tagline') }}" placeholder="e.g. Infrastructure &middot; Engineering &middot; Impact"
                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition">
        </div>

        <!-- SEO Meta -->
        <div class="space-y-1.5">
            <label for="meta_description" class="block text-xs font-bold text-slate-700">SEO Meta Description</label>
            <textarea name="meta_description" id="meta_description" rows="2" placeholder="Short description for search engines and social shares"
                      class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition">{{ old('meta_description') }}</textarea>
        </div>

        <!-- Logos -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-slate-100">
            <div class="space-y-1.5">
                <label for="logo" class="block text-xs font-bold text-slate-700">Header Brand Logo</label>
                <input type="file" name="logo" id="logo" accept="image/*"
                       class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100">
            </div>

            <div class="space-y-1.5">
                <label for="favicon" class="block text-xs font-bold text-slate-700">Browser Favicon</label>
                <input type="file" name="favicon" id="favicon" accept="image/*"
                       class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100">
            </div>
        </div>

        <!-- Submit Button -->
        <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
            <a href="{{ route('admin.organizations.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition">
                Cancel
            </a>
            <button type="submit" class="px-6 py-2.5 bg-brand-600 hover:bg-brand-500 text-white text-xs font-bold rounded-xl shadow-lg shadow-brand-600/30 transition flex items-center gap-2">
                <i class="bi bi-check2-circle"></i>
                <span>Create & Configure Organization</span>
            </button>
        </div>
    </form>

</div>
@endsection
