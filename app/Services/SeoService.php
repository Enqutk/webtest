<?php

namespace App\Services;

use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class SeoService
{
    /** @return array<string, mixed> */
    public function forPlatform(array $overrides = []): array
    {
        $config = config('seo.platform', []);
        $title = $overrides['title'] ?? $config['title'] ?? 'Kimem Cards';
        $description = $overrides['description'] ?? $config['description'] ?? '';
        $image = $this->absoluteUrl($overrides['image'] ?? $config['og_image'] ?? 'images/fevicon.png');
        $canonical = $overrides['canonical'] ?? url('/');

        return $this->pack([
            'title' => $title,
            'description' => $description,
            'keywords' => $this->keywordsString($overrides['keywords'] ?? $config['keywords'] ?? []),
            'canonical' => $canonical,
            'image' => $image,
            'type' => $overrides['type'] ?? 'website',
            'site_name' => $config['name'] ?? 'Kimem Cards',
            'locale' => $config['locale'] ?? 'en_ET',
            'robots' => $this->robotsDirective($overrides),
            'twitter_site' => $config['twitter'] ?? null,
        ]);
    }

    /**
     * @param  array<string, mixed>  $data  HomeContentService payload
     * @param  array<string, mixed>  $page
     * @return array<string, mixed>
     */
    public function forTenant(array $data, array $page = [], ?Request $request = null): array
    {
        $request ??= request();
        $siteName = $data['siteName'] ?? config('app.name');
        $suffix = config('seo.tenant.title_suffix', 'Digital Profile');

        $pageTitle = trim(strip_tags((string) ($page['title'] ?? 'Home')));

        if (str_contains($pageTitle, '|')) {
            $fullTitle = $pageTitle;
        } elseif ($pageTitle === 'Home' || $pageTitle === '') {
            $fullTitle = "{$siteName} | {$suffix}";
        } else {
            $fullTitle = "{$pageTitle} | {$siteName}";
        }

        $description = trim(strip_tags((string) (
            $page['description']
            ?? $data['metaDescription']
            ?? $data['tagline']
            ?? $siteName
        )));

        $description = Str::limit($description, 160, '…');

        $image = $page['image']
            ?? $data['logoUrl']
            ?? asset('images/fevicon.png');

        $keywords = array_merge(
            config('seo.tenant.keywords', []),
            array_filter([
                $siteName,
                $data['tagline'] ?? null,
                'NFC business card Ethiopia',
                'digital business card',
            ])
        );

        $organization = $data['organization'] ?? null;

        return $this->pack([
            'title' => $fullTitle,
            'description' => $description,
            'keywords' => $this->keywordsString($keywords),
            'canonical' => $this->canonicalUrl($request),
            'image' => $this->absoluteUrl($image),
            'type' => $page['type'] ?? 'website',
            'site_name' => $siteName,
            'locale' => 'en_ET',
            'robots' => $this->robotsDirective([], $request),
            'organization' => $organization,
            'person_name' => $siteName,
            'person_role' => $data['tagline'] ?? null,
            'person_url' => $this->canonicalUrl($request),
        ]);
    }

    /** @param  array<string, mixed>  $payload */
    private function pack(array $payload): array
    {
        $payload['description'] = Str::limit(trim(strip_tags((string) ($payload['description'] ?? ''))), 160, '…');

        return $payload;
    }

    /** @param  array<int, string>  $keywords */
    private function keywordsString(array $keywords): string
    {
        return collect($keywords)
            ->filter()
            ->map(fn ($k) => trim(strip_tags((string) $k)))
            ->unique()
            ->implode(', ');
    }

    private function absoluteUrl(?string $url): string
    {
        if (blank($url)) {
            return asset('images/fevicon.png');
        }

        if (str_starts_with($url, 'http://') || str_starts_with($url, 'https://')) {
            return $url;
        }

        return asset(ltrim($url, '/'));
    }

    private function canonicalUrl(?Request $request = null): string
    {
        $request ??= request();
        $url = URL::current();

        foreach (config('seo.noindex_query', []) as $param) {
            if ($request->has($param)) {
                $url = strtok($url, '?') ?: $url;
                break;
            }
        }

        return $url;
    }

    /** @param  array<string, mixed>  $overrides */
    private function robotsDirective(array $overrides = [], ?Request $request = null): string
    {
        if (isset($overrides['robots'])) {
            return (string) $overrides['robots'];
        }

        if (config('app.env') !== 'production') {
            return 'noindex, nofollow';
        }

        $request ??= request();

        foreach (config('seo.noindex_query', []) as $param) {
            if ($request->boolean($param)) {
                return 'noindex, nofollow';
            }
        }

        $routeName = Route::currentRouteName();
        if ($routeName && in_array($routeName, config('seo.noindex_routes', []), true)) {
            return 'noindex, nofollow';
        }

        return 'index, follow';
    }

    /** @return array<string, mixed> */
    public function organizationJsonLd(array $seo): array
    {
        return array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'Person',
            'name' => $seo['person_name'] ?? $seo['site_name'] ?? null,
            'jobTitle' => $seo['person_role'] ?? null,
            'url' => $seo['canonical'] ?? null,
            'image' => $seo['image'] ?? null,
            'description' => $seo['description'] ?? null,
        ]);
    }

    /** @return array<int, array<string, mixed>> */
    public function platformJsonLd(): array
    {
        $config = config('seo.platform', []);
        $url = url('/');

        return [
            array_filter([
                '@context' => 'https://schema.org',
                '@type' => 'WebSite',
                'name' => $config['name'] ?? 'Kimem Cards',
                'url' => $url,
                'description' => $config['description'] ?? null,
                'inLanguage' => 'en-ET',
            ]),
            array_filter([
                '@context' => 'https://schema.org',
                '@type' => 'Organization',
                'name' => $config['legal_name'] ?? 'Kimem Cards',
                'url' => $url,
                'logo' => asset('images/fevicon.png'),
                'description' => $config['description'] ?? null,
                'areaServed' => [
                    '@type' => 'Country',
                    'name' => $config['area_served'] ?? 'Ethiopia',
                ],
            ]),
            array_filter([
                '@context' => 'https://schema.org',
                '@type' => 'Product',
                'name' => 'Kimem NFC Business Card',
                'description' => 'Premium NFC-enabled business card with a live digital profile. Tap to share contact details, portfolio, and social links.',
                'brand' => [
                    '@type' => 'Brand',
                    'name' => 'Kimem Cards',
                ],
                'category' => 'NFC Business Card',
                'offers' => [
                    '@type' => 'AggregateOffer',
                    'priceCurrency' => $config['price_currency'] ?? 'ETB',
                    'lowPrice' => '1850',
                    'highPrice' => '2450',
                    'offerCount' => '2',
                    'availability' => 'https://schema.org/InStock',
                    'url' => url('/apply'),
                ],
            ]),
        ];
    }

    /** @return array<string, mixed> */
    public function platformFaqJsonLd(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => [
                [
                    '@type' => 'Question',
                    'name' => 'What is an NFC business card?',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => 'An NFC business card is a physical card with a built-in NFC chip. When someone taps it with a smartphone, your digital profile opens instantly — contact details, links, portfolio, and more — without typing or scanning a QR code.',
                    ],
                ],
                [
                    '@type' => 'Question',
                    'name' => 'Do Kimem Cards work in Ethiopia?',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => 'Yes. Kimem Cards are designed for professionals in Ethiopia and work with modern iOS and Android phones. We ship nationwide and configure your live digital profile before delivery.',
                    ],
                ],
                [
                    '@type' => 'Question',
                    'name' => 'What is a digital business card?',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => 'A digital business card is an online profile that represents you or your brand. With Kimem Cards, your NFC card links to a always-updated digital profile so you never reprint cards when your details change.',
                    ],
                ],
                [
                    '@type' => 'Question',
                    'name' => 'How much does an NFC card cost in Ethiopia?',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => 'Kimem Cards start from ETB 1,850 for the Midnight Navy edition and ETB 2,450 for the Brushed Gold edition, including profile setup and NFC encoding.',
                    ],
                ],
            ],
        ];
    }
}
