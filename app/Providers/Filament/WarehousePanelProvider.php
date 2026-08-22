<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class WarehousePanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('warehouse')
            ->path('warehouse')
            ->login()
            ->spa()
            ->databaseNotifications()
            ->brandName('Warehouse')
            ->globalSearch(false)
            ->viteTheme('resources/css/filament/admin/theme.css')
             ->maxContentWidth(Width::Full)
              ->sidebarCollapsibleOnDesktop()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Warehouse/Resources'), for: 'App\Filament\Warehouse\Resources')
            ->discoverPages(in: app_path('Filament/Warehouse/Pages'), for: 'App\Filament\Warehouse\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Warehouse/Widgets'), for: 'App\Filament\Warehouse\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
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
            ->navigationGroups([
                NavigationGroup::make()
                    ->label('Warehouse')
                    ->icon(Heroicon::BuildingStorefront),
                NavigationGroup::make()
                    ->label('Hub')
                    ->icon(Heroicon::BuildingOffice2),
                // NavigationGroup::make()
                //     ->label(fn (): string => __('navigation.settings'))
                //     ->icon('heroicon-o-cog-6-tooth')
                //     ->collapsed(),
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
