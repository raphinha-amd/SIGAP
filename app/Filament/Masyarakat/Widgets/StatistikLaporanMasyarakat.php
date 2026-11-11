<?php

namespace App\Filament\Masyarakat\Widgets;

use App\Models\Aspirasi;
use App\Models\Laporan;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class StatistikLaporanMasyarakat extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        $userId = Auth::id();

        // Query laporan milik pengguna yang sedang login
        $laporan = Laporan::where('user_id', $userId);

        return [
            Stat::make('Total Laporan', (clone $laporan)->count())
                ->description('Seluruh laporan yang Anda buat')
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->color('primary'),

            Stat::make('Menunggu', (clone $laporan)->where('status_laporan', 'menunggu')->count())
                ->description('Menunggu tanggapan petugas')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Verifikasi', (clone $laporan)->where('status_laporan', 'verifikasi')->count())
                ->description('Sedang diverifikasi petugas')
                ->descriptionIcon('heroicon-m-magnifying-glass')
                ->color('info'),

            Stat::make('Proses', (clone $laporan)->where('status_laporan', 'proses')->count())
                ->description('Sedang ditindaklanjuti')
                ->descriptionIcon('heroicon-m-arrow-path')
                ->color('info'),

            Stat::make('Ditolak', (clone $laporan)->where('status_laporan', 'tolak')->count())
                ->description('Laporan yang ditolak')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),

            Stat::make('Selesai', (clone $laporan)->where('status_laporan', 'selesai')->count())
                ->description('Laporan telah diselesaikan')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make(
                'Total Aspirasi',
                Aspirasi::where('user_id', $userId)->count()
            )
                ->description('Seluruh aspirasi yang Anda buat')
                ->descriptionIcon('heroicon-m-chat-bubble-left-right')
                ->color('success'),
        ];
    }
}
