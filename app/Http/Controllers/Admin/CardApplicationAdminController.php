<?php

namespace App\Http\Controllers\Admin;

use App\Enums\EntityTypeEnum;
use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Models\CardApplication;
use App\Models\Entity;
use App\Models\Hero;
use App\Models\Organization;
use App\Models\OrganizationContact;
use App\Models\SocialRef;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CardApplicationAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = CardApplication::query()->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('reference_code', 'like', "%{$search}%")
                  ->orWhere('company_name', 'like', "%{$search}%");
            });
        }

        $applications = $query->paginate(15)->withQueryString();
        $pendingCount = CardApplication::where('status', 'pending')->count();
        $approvedCount = CardApplication::where('status', 'approved')->count();
        $currentOrg = Organization::resolveCurrent();

        return view('admin.applications.index', compact('applications', 'pendingCount', 'approvedCount', 'currentOrg'));
    }

    public function show(CardApplication $application)
    {
        $currentOrg = Organization::resolveCurrent();
        return view('admin.applications.show', compact('application', 'currentOrg'));
    }

    public function approve($application, Request $request)
    {
        $application = ($application instanceof CardApplication) ? $application : CardApplication::findOrFail($application);

        if ($application->status === 'approved' && $application->organization_id) {
            return back()->with('info', 'This application has already been approved and provisioned.');
        }

        // 1. Ensure unique organization slug
        $baseSlug = Str::slug($application->slug ?: $application->name) ?: 'card-member';
        $slug = $baseSlug;
        $counter = 1;
        while (Organization::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        // 2. Build full multi-tenant theme
        $appTheme = is_array($application->theme) ? $application->theme : [];
        $fontDisplay = $appTheme['font_display'] ?? 'Outfit';
        $fontBody = $appTheme['font_body'] ?? 'Outfit';
        $accent = $appTheme['accent'] ?? '#eab308';
        $bg = $appTheme['bg'] ?? '#0b0f19';
        $imageShape = $appTheme['image_shape'] ?? 'squircle';

        $highlights = is_array($application->highlights) ? $application->highlights : [];
        $aboutPoints = collect($highlights)->map(function ($h, $index) {
            return [
                'title' => 'Key Highlight ' . ($index + 1),
                'description' => $h,
            ];
        })->all();

        $orgTheme = [
            'bg' => $bg,
            'surface' => '#111827',
            'ink' => '#f9fafb',
            'muted' => '#9ca3af',
            'line' => '#1f2937',
            'accent' => $accent,
            'accent_dark' => '#9e7d3b',
            'accent_soft' => 'rgba(234, 179, 8, 0.15)',
            'dark' => '#030712',
            'font_display' => $fontDisplay,
            'font_body' => $fontBody,
            'brand_font_family' => $fontDisplay,
            'brand_font_weight' => '700',
            'brand_letter_spacing' => '0.02em',
            'tagline_font_family' => $fontBody,
            'tagline_font_style' => 'normal',
            'tagline_font_weight' => '500',
            'nav_font_family' => $fontBody,
            'nav_font_weight' => '600',
            'nav_spacing' => '1.5rem',
            'image_shape' => $imageShape,
            'show_logo' => false,
            'show_brand_text' => true,
            'show_tagline' => true,
            'show_header_cta' => true,
            'header_cta_text' => 'Get in Touch',
            'show_address' => true,
            'show_po_box' => true,
            'show_opening_hours' => false,
            'show_email' => true,
            'show_phone' => true,
            'show_social_links' => true,
            'home_sections' => [
                'hero' => [
                    'is_visible' => true,
                    'badge' => $application->role_title . ($application->company_name ? " · {$application->company_name}" : ''),
                    'subtitle' => $application->role_title,
                    'title' => $application->tagline ?: "Professional Profile & Digital Smart Card",
                    'description' => $application->bio ?: "Welcome to the official verified digital presence of {$application->name}.",
                    'cta_text' => 'Direct Contact',
                    'cta_url' => '/contact',
                    'secondary_cta_text' => 'Explore Portfolio',
                    'secondary_cta_url' => '/portfolio',
                    'image_shape' => $imageShape,
                    'slides' => [
                        [
                            'eyebrow' => $application->role_title,
                            'title' => $application->tagline ?: "Professional Profile & Digital Smart Card",
                            'description' => $application->bio ?: "Connecting with leaders and clients across the region.",
                            'button_label' => 'Direct Contact',
                            'button_url' => '/contact',
                            'image_shape' => $imageShape,
                            'is_visible' => true,
                        ],
                    ],
                ],
                'about' => [
                    'is_visible' => true,
                    'eyebrow' => 'Background & Story',
                    'title' => $application->name,
                    'description' => $application->bio ?: "Dedicated {$application->role_title} delivering impactful and reliable solutions.",
                    'image_shape' => $imageShape,
                    'points' => $aboutPoints,
                ],
                'stats' => [
                    'is_visible' => true,
                    'eyebrow' => 'Milestones',
                    'title' => 'Key Performance & Track Record',
                    'items' => [
                        ['number' => '100%', 'label' => 'Verified Presence', 'description' => 'Official NFC smart profile and digital card.'],
                        ['number' => '24/7', 'label' => 'Direct Reach', 'description' => 'Fast messaging and mobile contact channels.'],
                    ],
                ],
                'services' => [
                    'is_visible' => ($application->type === 'business'),
                ],
                'portfolio' => [
                    'is_visible' => true,
                    'eyebrow' => 'Selected Showcase',
                    'title' => 'Featured Highlights & Projects',
                    'description' => 'Curated portfolio and accomplishments.',
                    'image_shape' => $imageShape,
                ],
                'team' => [
                    'is_visible' => true,
                    'eyebrow' => 'Principal',
                    'title' => $application->name,
                    'description' => $application->role_title,
                    'cta_text' => 'Contact Now',
                    'cta_url' => '/contact',
                    'image_shape' => $imageShape,
                ],
                'clients' => [
                    'is_visible' => false,
                ],
                'cta' => [
                    'is_visible' => true,
                    'eyebrow' => 'Direct Connect',
                    'title' => "Connect with {$application->name}",
                    'description' => "Tap NFC or reach out directly to initiate collaboration or discussions.",
                    'button_text' => 'Send Message',
                    'button_url' => '/contact',
                    'secondary_button_text' => 'Direct WhatsApp',
                    'secondary_button_url' => !empty($application->social_links['whatsapp']) ? "https://wa.me/" . preg_replace('/[^0-9]/', '', $application->social_links['whatsapp']) : null,
                ],
            ],
        ];

        // 3. Create the Organization
        $org = Organization::create([
            'title' => $application->name,
            'slug' => $slug,
            'tagline' => $application->tagline ?: $application->role_title,
            'meta_description' => "{$application->name} — {$application->role_title}.",
            'address' => $application->company_name ?: 'Verified Smart Card Member',
            'theme' => $orgTheme,
            'status' => 'active',
        ]);

        // 4. Create Organization Contacts
        if ($application->email) {
            OrganizationContact::create([
                'organization_id' => $org->id,
                'type' => 'email',
                'value' => $application->email,
                'status' => StatusEnum::active,
            ]);
        }
        if ($application->phone) {
            OrganizationContact::create([
                'organization_id' => $org->id,
                'type' => 'phone',
                'value' => $application->phone,
                'status' => StatusEnum::active,
            ]);
        }

        // 5. Create Social Media References
        $socials = is_array($application->social_links) ? $application->social_links : [];
        foreach ($socials as $network => $val) {
            if (empty($val)) continue;
            
            $icon = match ($network) {
                'telegram' => 'bi bi-telegram',
                'whatsapp' => 'bi bi-whatsapp',
                'linkedin' => 'bi bi-linkedin',
                'github' => 'bi bi-github',
                default => 'bi bi-globe',
            };
            $link = str_starts_with($val, 'http') || str_starts_with($val, 'mailto') ? $val : (
                $network === 'telegram' ? 'https://t.me/' . ltrim($val, '@') : (
                $network === 'whatsapp' ? 'https://wa.me/' . preg_replace('/[^0-9]/', '', $val) : $val
            ));

            SocialRef::create([
                'organization_id' => $org->id,
                'title' => ucfirst($network),
                'icon_class' => $icon,
                'link' => $link,
                'status' => StatusEnum::active,
            ]);
        }

        // 6. Create Team Member Profile
        $nameParts = explode(' ', $application->name, 2);
        Team::create([
            'organization_id' => $org->id,
            'first_name' => $nameParts[0],
            'last_name' => $nameParts[1] ?? '',
            'title' => $application->role_title,
            'description' => $application->bio ?: $application->tagline,
            'founder' => true,
            'order' => 1,
            'status' => StatusEnum::active,
        ]);

        // 7. Create Hero Slide
        $hero = Hero::create([
            'organization_id' => $org->id,
            'subtitle' => $application->role_title,
            'title' => $application->tagline ?: "Welcome to {$application->name}",
            'description' => $application->bio ?: "Verified Kimem NFC Smart Card & Digital Profile.",
            'text_link' => 'Direct Contact',
            'button_link' => '/contact',
            'order' => 1,
            'status' => StatusEnum::active,
        ]);

        $heroMedia = $application->getFirstMedia('hero_image');
        if ($heroMedia) {
            try {
                $hero->addMedia($heroMedia->getPath())->preservingOriginal()->toMediaCollection('images');
            } catch (\Throwable $e) {}
        }

        // 8. Create Portfolio Projects or Highlight Entities
        $portfolioItems = $application->portfolio ?: [];
        if (!empty($portfolioItems)) {
            foreach ($portfolioItems as $index => $item) {
                Entity::create([
                    'organization_id' => $org->id,
                    'name' => $item['title'] ?? ("Project " . ($index + 1)),
                    'type' => EntityTypeEnum::project,
                    'description' => $item['description'] ?? '',
                    'link' => !empty($item['url']) ? $item['url'] : null,
                    'order' => $index + 1,
                    'status' => StatusEnum::active,
                ]);
            }
        } else {
            foreach ($highlights as $index => $h) {
                Entity::create([
                    'organization_id' => $org->id,
                    'name' => "Highlight " . ($index + 1),
                    'type' => EntityTypeEnum::project,
                    'description' => $h,
                    'order' => $index + 1,
                    'status' => StatusEnum::active,
                ]);
            }
        }

        // 9. Transfer uploaded headshot to Organization & Team
        $media = $application->getFirstMedia('profile_photo');
        if ($media) {
            try {
                $org->addMedia($media->getPath())->preservingOriginal()->toMediaCollection('logo');
            } catch (\Throwable $e) {}
        }

        // 10. Update Application Status
        $application->update([
            'status' => 'approved',
            'organization_id' => $org->id,
        ]);

        return redirect()->route('admin.applications.show', $application)
            ->with('success', "🎉 Application approved! Organization '{$org->title}' and live site /card/{$org->slug} have been successfully provisioned!");
    }

    public function reject($application, Request $request)
    {
        $application = ($application instanceof CardApplication) ? $application : CardApplication::findOrFail($application);

        $application->update([
            'status' => 'rejected',
            'admin_notes' => $request->input('admin_notes'),
        ]);

        return back()->with('success', 'Application marked as rejected.');
    }
}
