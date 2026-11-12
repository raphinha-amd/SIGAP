<?php

namespace App\Providers\Filament;

use App\Filament\Auth\Pages\LoginWithNikOrEmail;
use App\Filament\Petugas\Widgets\GrafikKategoriLaporan;
use App\Filament\Petugas\Widgets\StatistikLaporanPetugas;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class PetugasPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('petugas')
            ->path('petugas')
            ->login(LoginWithNikOrEmail::class)
            ->globalSearch(false)
            ->favicon(asset('asset/favicon.png'))
            ->colors([
                'primary' => Color::Blue,
            ])
            ->discoverResources(in: app_path('Filament/Petugas/Resources'), for: 'App\Filament\Petugas\Resources')
            ->discoverPages(in: app_path('Filament/Petugas/Pages'), for: 'App\Filament\Petugas\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Petugas/Widgets'), for: 'App\Filament\Petugas\Widgets')
            ->widgets([
                GrafikKategoriLaporan::class,
                StatistikLaporanPetugas::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
