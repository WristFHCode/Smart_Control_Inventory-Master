<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->sidebarCollapsibleOnDesktop() // Makes the sidebar collapsible on desktop
            ->default() // Default settings for the panel
            ->id('admin') // Unique identifier for the panel
            ->path('admin') // Path for the admin dashboard
            ->login() // Enables login page
            ->colors([ 
                'primary' => Color::Blue, // Primary color for the panel
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources') // Automatically discover resources
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages') // Automatically discover pages
            ->pages([
                Pages\Dashboard::class, // Adds the dashboard page to the panel
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets') // Automatically discover widgets
            ->widgets([
                Widgets\AccountWidget::class, // Adds the account widget to the panel
                // Widgets\FilamentInfoWidget::class, // Optional, can add other widgets
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
            ->plugins([
                FilamentShieldPlugin::make(), // Adds FilamentShield plugin
            ])
            ->authMiddleware([
                Authenticate::class, // Middleware for authentication
            ]);
    }
}
