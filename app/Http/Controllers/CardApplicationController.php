<?php

namespace App\Http\Controllers;

use App\Models\CardApplication;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CardApplicationController extends Controller
{
    public function create()
    {
        $fontOptions = Organization::getFontOptions();
        $shapeOptions = Organization::imageShapeOptions(false);
        
        $editions = [
            'midnight_navy' => [
                'name' => 'Midnight Obsidian Navy',
                'subtitle' => 'Deep Navy with Brushed Silver NFC Chip',
                'price' => '1,850 ETB',
                'bg_class' => 'from-slate-900 via-indigo-950 to-slate-900',
                'accent' => '#6366f1',
                'badge' => 'Most Popular',
            ],
            'brushed_gold' => [
                'name' => 'Brushed Gold Luxe Edition',
                'subtitle' => 'Premium Metallic Gold Foil & 24K Accent Foil',
                'price' => '2,450 ETB',
                'bg_class' => 'from-amber-950 via-yellow-900 to-stone-900',
                'accent' => '#c5a059',
                'badge' => 'VIP Executive',
            ],
            'executive_black' => [
                'name' => 'Executive Matte Stealth Black',
                'subtitle' => 'Matte Ceramic Finish with Stealth Dark Chip',
                'price' => '2,150 ETB',
                'bg_class' => 'from-zinc-950 via-neutral-900 to-black',
                'accent' => '#10b981',
                'badge' => 'High Tech',
            ],
        ];

        return view('card-applications.apply', compact('fontOptions', 'shapeOptions', 'editions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => ['required', 'in:individual,business'],
            'name' => ['required', 'string', 'max:255'],
            'role_title' => ['required', 'string', 'max:255'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'tagline' => ['nullable', 'string', 'max:500'],
            'bio' => ['nullable', 'string', 'max:2000'],
            'card_edition' => ['required', 'in:midnight_navy,brushed_gold,executive_black'],
            'bg_color' => ['nullable', 'string', 'max:20'],
            'accent_color' => ['nullable', 'string', 'max:20'],
            'font_display' => ['nullable', 'string', 'max:50'],
            'font_body' => ['nullable', 'string', 'max:50'],
            'image_shape' => ['nullable', 'string', 'max:30'],
            'highlights' => ['nullable', 'array'],
            'highlights.*' => ['nullable', 'string', 'max:255'],
            'telegram' => ['nullable', 'string', 'max:100'],
            'whatsapp' => ['nullable', 'string', 'max:100'],
            'linkedin' => ['nullable', 'string', 'max:255'],
            'github' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'string', 'max:255'],
            'photo' => ['nullable', 'image', 'max:5120'], // max 5MB
        ]);

        // Generate unique slug
        $baseSlug = Str::slug($validated['name']) ?: 'card-member';
        $slug = $baseSlug;
        $counter = 1;
        while (Organization::where('slug', $slug)->exists() || CardApplication::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        $prices = [
            'midnight_navy' => '1,850 ETB',
            'brushed_gold' => '2,450 ETB',
            'executive_black' => '2,150 ETB',
        ];

        $theme = [
            'bg' => $request->input('bg_color', '#090d16'),
            'surface' => '#111827',
            'ink' => '#f9fafb',
            'muted' => '#9ca3af',
            'line' => '#1f2937',
            'accent' => $request->input('accent_color', '#c5a059'),
            'accent_dark' => '#9e7d3b',
            'font_display' => $request->input('font_display', 'Outfit'),
            'font_body' => $request->input('font_body', 'Outfit'),
            'brand_font_family' => $request->input('font_display', 'Outfit'),
            'brand_font_weight' => '700',
            'image_shape' => $request->input('image_shape', 'squircle'),
        ];

        $socialLinks = array_filter([
            'telegram' => $request->input('telegram'),
            'whatsapp' => $request->input('whatsapp'),
            'linkedin' => $request->input('linkedin'),
            'github' => $request->input('github'),
            'website' => $request->input('website'),
        ]);

        $filteredHighlights = array_values(array_filter($request->input('highlights', [])));

        $application = CardApplication::create([
            'reference_code' => CardApplication::generateReferenceCode(),
            'type' => $validated['type'],
            'name' => $validated['name'],
            'slug' => $slug,
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'role_title' => $validated['role_title'],
            'company_name' => $validated['company_name'],
            'tagline' => $validated['tagline'] ?: "{$validated['role_title']} at " . ($validated['company_name'] ?: 'Independent'),
            'bio' => $validated['bio'],
            'card_edition' => $validated['card_edition'],
            'quote_amount' => $prices[$validated['card_edition']] ?? '1,850 ETB',
            'theme' => $theme,
            'highlights' => $filteredHighlights,
            'social_links' => $socialLinks,
            'status' => 'pending',
        ]);

        if ($request->hasFile('photo')) {
            $application->addMediaFromRequest('photo')->toMediaCollection('profile_photo');
        }

        return redirect()->route('card.apply.success', ['code' => $application->reference_code]);
    }

    public function success(string $code)
    {
        $application = CardApplication::where('reference_code', $code)->firstOrFail();
        return view('card-applications.success', compact('application'));
    }

    public function track(Request $request)
    {
        $code = $request->query('code');
        $application = $code ? CardApplication::where('reference_code', strtoupper(trim($code)))->first() : null;
        return view('card-applications.track', compact('application', 'code'));
    }
}
