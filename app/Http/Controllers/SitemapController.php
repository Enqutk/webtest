<?php

namespace App\Http\Controllers;

use App\Enums\EntityTypeEnum;
use App\Enums\StatusEnum;
use App\Models\Entity;
use App\Models\Organization;
use App\Models\Page;
use App\Models\Service;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $xml = Cache::remember('sitemap.xml', now()->addMinutes(config('seo.sitemap.cache_minutes', 60)), function () {
            return $this->buildXml();
        });

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
        ]);
    }

    private function buildXml(): string
    {
        $urls = [];

        $urls[] = $this->entry(url('/'), now(), 'weekly', '1.0');
        $urls[] = $this->entry(url('/cards'), now(), 'monthly', '0.9');
        $urls[] = $this->entry(route('card.apply'), now(), 'monthly', '0.9');

        Organization::query()
            ->where('status', 'active')
            ->orderBy('id')
            ->each(function (Organization $org) use (&$urls) {
                $base = url('/card/' . $org->slug);
                $updated = $org->updated_at ?? now();

                $urls[] = $this->entry($base, $updated, 'weekly', '0.8');
                $urls[] = $this->entry($base . '/about', $updated, 'monthly', '0.7');
                $urls[] = $this->entry($base . '/our-services', $updated, 'monthly', '0.7');
                $urls[] = $this->entry($base . '/portfolio', $updated, 'monthly', '0.7');
                $urls[] = $this->entry($base . '/contact', $updated, 'monthly', '0.6');

                Service::query()
                    ->where('organization_id', $org->id)
                    ->where('status', StatusEnum::active)
                    ->each(function (Service $service) use (&$urls, $base) {
                        $urls[] = $this->entry(
                            $base . '/services/' . $service->slug,
                            $service->updated_at ?? now(),
                            'monthly',
                            '0.6'
                        );
                    });

                Entity::query()
                    ->where('organization_id', $org->id)
                    ->where('status', StatusEnum::active)
                    ->where('type', EntityTypeEnum::project)
                    ->each(function (Entity $entity) use (&$urls, $base) {
                        $urls[] = $this->entry(
                            $base . '/portfolio/' . $entity->id,
                            $entity->updated_at ?? now(),
                            'monthly',
                            '0.5'
                        );
                    });

                Page::query()
                    ->where('organization_id', $org->id)
                    ->where('is_active', true)
                    ->whereNotIn('slug', Page::RESERVED_SLUGS)
                    ->each(function (Page $page) use (&$urls, $base) {
                        $urls[] = $this->entry(
                            $base . '/pages/' . $page->slug,
                            $page->updated_at ?? now(),
                            'monthly',
                            '0.5'
                        );
                    });
            });

        $body = collect($urls)->implode('');

        return '<?xml version="1.0" encoding="UTF-8"?>'
            . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'
            . $body
            . '</urlset>';
    }

    private function entry(string $loc, $lastmod, string $changefreq, string $priority): string
    {
        $date = $lastmod instanceof \DateTimeInterface
            ? $lastmod->format('Y-m-d')
            : now()->format('Y-m-d');

        return '<url>'
            . '<loc>' . e($loc) . '</loc>'
            . '<lastmod>' . $date . '</lastmod>'
            . '<changefreq>' . $changefreq . '</changefreq>'
            . '<priority>' . $priority . '</priority>'
            . '</url>';
    }
}
