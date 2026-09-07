<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Kimem Cards platform SEO (kimemcards.com homepage)
    |--------------------------------------------------------------------------
    */
    'platform' => [
        'name' => 'Kimem Cards',
        'legal_name' => 'Kimem Cards',
        'title' => 'Kimem Cards | NFC Business Cards & Digital Profiles in Ethiopia',
        'description' => 'Premium NFC business cards and live digital profiles for professionals in Ethiopia. Tap once to share contact details, portfolio, and social links — no app required. Order smart business cards in Addis Ababa and nationwide.',
        'keywords' => [
            'NFC business card',
            'NFC card Ethiopia',
            'digital business card Ethiopia',
            'smart business card',
            'digital business card Addis Ababa',
            'NFC digital profile',
            'tap to share contact',
            'electronic business card',
            'Kimem Cards',
            'Ethiopia NFC card',
        ],
        'locale' => 'en_ET',
        'twitter' => null,
        'og_image' => 'images/image.webp',
        'area_served' => 'Ethiopia',
        'price_currency' => 'ETB',
    ],

    /*
    |--------------------------------------------------------------------------
    | Default tenant / card site SEO suffixes
    |--------------------------------------------------------------------------
    */
    'tenant' => [
        'title_suffix' => 'Digital Profile',
        'keywords' => [
            'digital business card',
            'NFC profile',
            'online portfolio',
            'professional profile Ethiopia',
        ],
    ],

    'sitemap' => [
        'cache_minutes' => 60,
    ],

    'noindex_routes' => [
        'card.apply.success',
        'card.apply.track',
        'card.invite.show',
    ],

    'noindex_query' => [
        'admin_preview',
    ],

];
