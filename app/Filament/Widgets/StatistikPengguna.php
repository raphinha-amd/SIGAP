<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatistikPengguna extends StatsOverviewWidget
{
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 1;
    protected function getStats(): array
    {
        return [
            Stat::make('Total Pengguna', User::count())
                ->description('Seluruh pengguna SIGAP')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),

            Stat::make('Masyarakat', User::where('role', 'masyarakat')->count())
                ->description('Pengguna masyarakat')
                ->descriptionIcon('heroicon-m-user')
                ->color('success'),

            Stat::make('Admin', User::where('role', 'admin')->count())
                ->description('Administrator sistem')
                ->descriptionIcon('heroicon-m-shield-check')
                ->color('warning'),

            Stat::make('Petugas', User::where('role', 'petugas')->count())
                ->description('Petugas desa')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info'),

            Stat::make('Pengguna Aktif', User::where('status_akun', true)->count())
                ->description('Akun yang dapat digunakan')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Pengguna Nonaktif', User::where('status_akun', false)->count())
                ->description('Akun yang dinonaktifkan')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),
        ];
    }
}
