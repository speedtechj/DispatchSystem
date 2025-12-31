<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use Filament\Widgets\Widget;
use Filament\Pages\Dashboard;
use Filament\Support\Enums\Width;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use App\Filament\Resources\UserResource;
use Filament\Navigation\NavigationGroup;
use Filament\Widgets\FilamentInfoWidget;
use App\Filament\Widgets\ConsolidatorForm;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Session\Middleware\StartSession;
use App\Filament\Resources\ConsolidatorResource;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Filament\Http\Middleware\AuthenticateSession;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('/')
            // ->topbar(false)
            ->login()
             ->databaseNotifications()
             ->globalSearch(false)
            ->emailVerification()
            ->passwordReset()
             ->sidebarFullyCollapsibleOnDesktop()
            ->spa()
             ->maxContentWidth(Width::Full)
            ->brandName('Dispatch System')
            ->colors([
                'danger' => Color::Rose,
                'gray' => Color::Gray,
                'info' => Color::Blue,
                'primary' => 'rgb(246, 190, 0)',
                'success' => Color::Emerald,
                'warning' => Color::Orange,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Dashboard::class,
            ])
            // dont remove the comment if you want to enable auto-discovery of widgets
         //   ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
         //   ->widgets([
                // AccountWidget::class,
                // FilamentInfoWidget::class,
              
          //  ])
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
                 FilamentShieldPlugin::make(),
            ])
            ->navigationGroups([
            NavigationGroup::make()
                 ->label('Settings')
                 ->icon('heroicon-o-cog'),
            // NavigationGroup::make()
            //     ->label('Blog')
            //     ->icon('heroicon-o-pencil'),
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
