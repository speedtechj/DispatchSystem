<?php

namespace App\Providers\Filament;

use App\Filament\Resources\ConsolidatorResource;
use App\Filament\Resources\UserResource;
use App\Filament\Widgets\ConsolidatorForm;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Actions\Action;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Pages;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Filament\Widgets\Widget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

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
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                AccountWidget::class,
                //  FilamentInfoWidget::class,

            ])
            ->userMenuItems([
                Action::make('Forex Calgary')
                    ->url('https://cmsv4calgary.forexcargodeals.com/1224/login', shouldOpenInNewTab: true)
                    ->color('Info')
                    ->icon(Heroicon::Truck),
                Action::make('Forex Edmonton')
                    ->url('https://cmsv4edmonton.forexcargo.ca/1224/login', shouldOpenInNewTab: true)
                    ->color('Info')
                     ->icon(Heroicon::Truck),
                Action::make('Star Express Calgary')
                    ->url('https://cmscalgaryv4.starexpresskargo.com/1224/login', shouldOpenInNewTab: true)
                    ->color('Info')
                    ->icon(Heroicon::Star),
                Action::make('Star Express Edmonton')
                    ->url('https://cmsedmontonv4.starexpresskargo.com/1224/login', shouldOpenInNewTab: true)
                    ->color('Info')
                    ->icon(Heroicon::Star),
                Action::make('Icargo Xpress')
                    ->url('https://cmsv4.icargoxpress.com/1224', shouldOpenInNewTab: true)
                    ->color('Info')
                    ->icon(Heroicon::Bolt),
                Action::make('Rc Padala Express')
                    ->url('https://cms.rcpadalaexpress.com/1224/login', shouldOpenInNewTab: true)
                    ->color('Info')
                    ->icon(Heroicon::CheckBadge),
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
