<?php

namespace App\Filament\Petugas\Widgets;

use App\Models\Aspirasi;
use App\Models\Laporan;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatistikLaporanPetugas extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected int | string | array $columnSpan = 'full';
    protected function getStats(): array
    {
        return [
            Stat::make('Total Laporan Masuk', Laporan::count())
                ->description('Seluruh laporan masyarakat')
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->color('primary'),

            Stat::make('Menunggu', Laporan::where('status_laporan', 'menunggu')->count())
                ->description('Belum ditanggapi')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Verifikasi', Laporan::where('status_laporan', 'verifikasi')->count())
                ->description('Sedang diverifikasi')
                ->descriptionIcon('heroicon-m-magnifying-glass')
                ->color('info'),

            Stat::make('Proses', Laporan::where('status_laporan', 'proses')->count())
                ->description('Sedang ditangani')
                ->descriptionIcon('heroicon-m-arrow-path')
                ->color('info'),

            Stat::make('Ditolak', Laporan::where('status_laporan', 'tolak')->count())
                ->description('Laporan ditolak')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),

            Stat::make('Selesai', Laporan::where('status_laporan', 'selesai')->count())
                ->description('Laporan telah diselesaikan')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Aspirasi Masuk', Aspirasi::count())
                ->description('Seluruh aspirasi masyarakat')
                ->descriptionIcon('heroicon-m-chat-bubble-left-right')
                ->color('success'),
        ];
    }
}
