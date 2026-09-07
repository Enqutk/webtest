<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentBlock;
use App\Models\Entity;
use App\Enums\EntityTypeEnum;
use App\Models\Hero;
use App\Models\Organization;
use App\Models\Service;
use App\Models\Team;
use App\Support\ImageFocus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomePageController extends Controller
{
    public function index()
    {
        $currentOrg = Organization::resolveCurrent();
        $theme = is_array($currentOrg->theme) ? $currentOrg->theme : Organization::defaultTheme();
        $sections = $theme['home_sections'] ?? Organization::defaultHomeSections();
        if (! isset($sections['creator'])) {
            $sections['creator'] = Organization::defaultHomeSections()['creator'];
            if (! empty($theme['creator']) && is_array($theme['creator'])) {
                $sections['creator'] = array_replace_recursive($sections['creator'], $theme['creator']);
            }
        }

        $shapeOptions = Organization::imageShapeOptions(true);
        $fontOptions = Organization::getFontOptions();
        $teamMembers = Team::query()->where('organization_id', $currentOrg->id)->orderBy('order')->get();
        $services = Service::query()
            ->where('organization_id', $currentOrg->id)
            ->with('media')
            ->orderBy('order')
            ->get();
        $nextServiceOrder = (Service::where('organization_id', $currentOrg->id)->max('order') ?? 0) + 1;
        $projects = Entity::query()
            ->where('organization_id', $currentOrg->id)
            ->where('type', EntityTypeEnum::project)
            ->with('media')
            ->orderBy('order')
            ->get();
        $nextProjectOrder = (Entity::where('organization_id', $currentOrg->id)->where('type', EntityTypeEnum::project)->max('order') ?? 0) + 1;
        $clientPartners = Entity::query()
            ->where('organization_id', $currentOrg->id)
            ->whereIn('type', [EntityTypeEnum::client, EntityTypeEnum::partner])
            ->with('media')
            ->orderBy('order')
            ->get();
        $nextClientOrder = (Entity::where('organization_id', $currentOrg->id)
            ->whereIn('type', [EntityTypeEnum::client, EntityTypeEnum::partner])
            ->max('order') ?? 0) + 1;

        $aboutPoints = $sections['about']['points'] ?? [];
        if ($aboutPoints === []) {
            $aboutPoints = ContentBlock::query()
                ->where('organization_id', $currentOrg->id)
                ->where('slug', 'key-features')
                ->value('list_items') ?? Organization::defaultSitePages()['about']['intro']['points'];
        }

        $statsItems = $sections['stats']['items'] ?? [];
        if ($statsItems === []) {
            for ($i = 1; $i <= 3; $i++) {
                $label = $sections['stats']["stat_{$i}_label"] ?? null;
                $value = $sections['stats']["stat_{$i}_value"] ?? null;
                if (filled($label) || filled($value)) {
                    $statsItems[] = ['value' => $value ?? '', 'label' => $label ?? ''];
                }
            }
        }
        if ($statsItems === []) {
            $blockItems = ContentBlock::query()
                ->where('organization_id', $currentOrg->id)
                ->where('slug', 'stats')
                ->value('list_items') ?? [];
            if ($blockItems !== []) {
                $statsItems = collect($blockItems)->map(function ($item) {
                    $value = $item['value'] ?? $item['number'] ?? '';
                    if (isset($item['suffix']) && $item['suffix'] !== '') {
                        $value = $value . $item['suffix'];
                    }

                    return [
                        'value' => (string) $value,
                        'label' => $item['label'] ?? '',
                    ];
                })->values()->all();
            }
        }
        if ($statsItems === []) {
            $statsItems = Organization::defaultHomeSections()['stats']['items'] ?? [];
        }
        $statsItems = collect($statsItems)->map(fn($item) => [
            'value' => (string) ($item['value'] ?? $item['number'] ?? ''),
            'label' => $item['label'] ?? '',
        ])->values()->all();

        return view('admin.home-sections.index', compact(
            'currentOrg',
            'sections',
            'theme',
            'shapeOptions',
            'fontOptions',
            'teamMembers',
            'services',
            'nextServiceOrder',
            'projects',
            'nextProjectOrder',
            'clientPartners',
            'nextClientOrder',
            'aboutPoints',
            'statsItems',
        ));
    }

    public function updateSection(Request $request)
    {
        $currentOrg = Organization::resolveCurrent();
        $theme = is_array($currentOrg->theme) ? $currentOrg->theme : Organization::defaultTheme();

        $sectionKey = $request->input('section'); // e.g. 'hero', 'about', 'services', 'portfolio', 'team', 'cta'
        $data = $request->except([
            '_token',
            'section',
            'hero_image',
            'hero_brand_logo',
            'about_image',
            'remove_hero_image',
            'remove_hero_brand_logo',
        ]);

        if ($request->hasFile('about_image')) {
            $path = $request->file('about_image')->store('about', 'public');
            $data['image_path'] = $path;
        }

        if ($sectionKey === 'hero') {
            $this->syncHeroPhoto(
                $currentOrg,
                $theme,
                $request->file('hero_image'),
                $request->boolean('remove_hero_image')
            );

            if ($request->hasFile('hero_brand_logo')) {
                $data['brand_logo_path'] = $request->file('hero_brand_logo')->store('hero-brand', 'public');
            } elseif ($request->boolean('remove_hero_brand_logo')) {
                $data['brand_logo_path'] = null;
            } elseif (isset($theme['home_sections']['hero']['brand_logo_path'])) {
                $data['brand_logo_path'] = $theme['home_sections']['hero']['brand_logo_path'];
            }

            $data['show_brand_text'] = $request->boolean('show_brand_text');
            $data['show_brand_logo'] = $request->boolean('show_brand_logo');
        }

        if (isset($data['points']) && is_array($data['points'])) {
            $data['points'] = array_values(array_filter(
                $data['points'],
                fn($point) => filled($point['title'] ?? null) || filled($point['description'] ?? null)
            ));
        }

        if (isset($data['items']) && is_array($data['items'])) {
            $data['items'] = array_values(array_filter(
                $data['items'],
                fn($item) => filled($item['label'] ?? null) || filled($item['value'] ?? null)
            ));
        }

        if (!isset($theme['home_sections'])) {
            $theme['home_sections'] = Organization::defaultHomeSections();
        }

        if (!isset($theme['home_sections'][$sectionKey])) {
            $theme['home_sections'][$sectionKey] = [];
        }

        $theme['home_sections'][$sectionKey]['is_visible'] = $request->boolean('is_visible');

        foreach ($data as $k => $v) {
            if ($k === 'is_visible') {
                continue;
            }
            $theme['home_sections'][$sectionKey][$k] = $v;
        }

        if ($sectionKey === 'creator') {
            $theme['creator'] = $theme['home_sections']['creator'];
        }

        $currentOrg->theme = $theme;
        $currentOrg->save();

        return back()->with('success', ucfirst($sectionKey) . ' section settings saved successfully!');
    }

    public function saveSlide(Request $request)
    {
        $currentOrg = Organization::resolveCurrent();
        $theme = is_array($currentOrg->theme) ? $currentOrg->theme : Organization::defaultTheme();

        $index = $request->input('slide_index'); // null for new slide, integer for existing
        $slides = $theme['home_sections']['hero']['slides'] ?? Organization::defaultHeroSlides();

        $slideData = [
            'title' => $request->input('title', ''),
            'subtitle' => $request->input('subtitle', ''),
            'description' => $request->input('description', ''),
            'text_link' => $request->input('text_link', 'Explore services'),
            'button_link' => $request->input('button_link', '/our-services'),
            'image_shape' => $request->input('image_shape', 'inherit'),
            'image_focus_x' => ImageFocus::clamp($request->input('image_focus_x', 50), $request->input('image_focus_y', 50))['x'],
            'image_focus_y' => ImageFocus::clamp($request->input('image_focus_x', 50), $request->input('image_focus_y', 50))['y'],
            'is_visible' => (bool) $request->input('is_visible', true),
        ];

        if ($request->hasFile('slide_image')) {
            $path = $request->file('slide_image')->store('hero-slides', 'public');
            $slideData['image'] = [$path => $path];
            $slideData['image_path'] = $path;
        } elseif ($request->boolean('remove_slide_image')) {
            $slideData['image'] = null;
            $slideData['image_path'] = null;
            $this->clearHeroMediaAtIndex($currentOrg, is_numeric($index) ? (int) $index : null);
        } elseif (is_numeric($index) && isset($slides[$index])) {
            $slideData['image'] = $slides[$index]['image'] ?? null;
            $slideData['image_path'] = $slides[$index]['image_path'] ?? null;
        }

        if (is_numeric($index) && isset($slides[$index])) {
            $slides[$index] = array_merge($slides[$index], $slideData);
            $savedIndex = (int) $index;
        } else {
            $slides[] = $slideData;
            $savedIndex = array_key_last($slides);
        }

        if ($request->hasFile('slide_image') && is_int($savedIndex)) {
            $this->replaceHeroMediaAtIndex($currentOrg, $savedIndex, $request->file('slide_image'));
        }

        $theme['home_sections']['hero']['slides'] = array_values($slides);
        $currentOrg->theme = $theme;
        $currentOrg->save();

        return back()->with('success', 'Hero slide saved successfully!');
    }

    public function deleteSlide($index)
    {
        $currentOrg = Organization::resolveCurrent();
        $theme = is_array($currentOrg->theme) ? $currentOrg->theme : Organization::defaultTheme();

        $slides = $theme['home_sections']['hero']['slides'] ?? Organization::defaultHeroSlides();

        if (isset($slides[$index])) {
            unset($slides[$index]);
            $theme['home_sections']['hero']['slides'] = array_values($slides);
            $currentOrg->theme = $theme;
            $currentOrg->save();
        }

        return back()->with('success', 'Hero slide removed.');
    }

    private function syncHeroPhoto(Organization $org, array &$theme, $file, bool $remove): void
    {
        if (! $file && ! $remove) {
            return;
        }

        if (! isset($theme['home_sections']['hero']['slides']) || ! is_array($theme['home_sections']['hero']['slides'])) {
            $theme['home_sections']['hero']['slides'] = Organization::defaultHeroSlides();
        }

        $slides = $theme['home_sections']['hero']['slides'];
        if ($slides === []) {
            $slides[] = [
                'title' => $theme['home_sections']['hero']['title'] ?? '',
                'subtitle' => $theme['home_sections']['hero']['badge'] ?? '',
                'description' => $theme['home_sections']['hero']['description'] ?? '',
                'text_link' => $theme['home_sections']['hero']['cta_text'] ?? 'About me',
                'button_link' => $theme['home_sections']['hero']['cta_url'] ?? '/about',
                'is_visible' => true,
            ];
        }

        if ($file) {
            $path = $file->store('hero-slides', 'public');
            $slides[0]['image'] = [$path => $path];
            $slides[0]['image_path'] = $path;
            $this->replaceHeroMediaAtIndex($org, 0, $file);
        } elseif ($remove) {
            $slides[0]['image'] = null;
            $slides[0]['image_path'] = null;
            $this->clearHeroMediaAtIndex($org, 0);
        }

        $theme['home_sections']['hero']['slides'] = array_values($slides);
    }

    private function replaceHeroMediaAtIndex(Organization $org, int $index, $file): void
    {
        $hero = Hero::query()
            ->where('organization_id', $org->id)
            ->orderBy('order')
            ->skip($index)
            ->first();

        if (! $hero) {
            $hero = Hero::create([
                'organization_id' => $org->id,
                'title' => $org->title,
                'order' => $index + 1,
                'status' => 'active',
            ]);
        }

        $hero->clearMediaCollection('image');
        $hero->addMedia($file)->preservingOriginal()->toMediaCollection('image');
    }

    private function clearHeroMediaAtIndex(Organization $org, ?int $index): void
    {
        if ($index === null) {
            return;
        }

        $hero = Hero::query()
            ->where('organization_id', $org->id)
            ->orderBy('order')
            ->skip($index)
            ->first();

        if ($hero) {
            $hero->clearMediaCollection('image');
        }
    }
}
