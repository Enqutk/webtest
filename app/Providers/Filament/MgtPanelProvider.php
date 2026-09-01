<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\HtmlString;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class MgtPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $accent = '#0f766e';

        try {
            $theme = \App\Models\Organization::query()->value('theme');
            if (is_string($theme)) {
                $theme = json_decode($theme, true);
            }
            if (is_array($theme) && ! empty($theme['accent'])) {
                $accent = $theme['accent'];
            }
        } catch (\Throwable) {
            // DB may not be ready during early boot / migrate.
        }

        return $panel
            ->default()
            ->id('mgt')
            ->path('mgt')
            ->login()
            ->colors([
                'primary' => Color::hex($accent),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->renderHook(
                PanelsRenderHook::HEAD_END,
                fn (): HtmlString => new HtmlString('
                    <link rel="preconnect" href="https://fonts.googleapis.com">
                    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                    <link href="' . \App\Models\Organization::getAllGoogleFontsUrl() . '" rel="stylesheet">
                    <style>
                        .fi-form-actions {
                            position: sticky !important;
                            bottom: 1.25rem !important;
                            z-index: 25 !important;
                            backdrop-filter: blur(12px) !important;
                            -webkit-backdrop-filter: blur(12px) !important;
                            background: rgba(255, 255, 255, 0.92) !important;
                            padding: 0.85rem 1.25rem !important;
                            border-radius: 0.75rem !important;
                            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.12), 0 8px 10px -6px rgba(0, 0, 0, 0.08) !important;
                            border: 1px solid rgba(0, 0, 0, 0.08) !important;
                            transition: all 0.2s ease-in-out !important;
                        }
                        .dark .fi-form-actions {
                            background: rgba(17, 24, 39, 0.92) !important;
                            border-color: rgba(255, 255, 255, 0.1) !important;
                            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5) !important;
                        }
                    </style>
                ')
            );
    }
}
