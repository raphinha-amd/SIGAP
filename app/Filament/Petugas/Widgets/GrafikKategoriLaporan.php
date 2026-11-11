<?php

namespace App\Filament\Petugas\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class GrafikKategoriLaporan extends ChartWidget
{
    protected ?string $heading = 'Laporan Berdasarkan Kategori';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $kategori = DB::table('kategori_laporans')
            ->leftJoin(
                'laporans',
                'kategori_laporans.id',
                '=',
                'laporans.kategori_laporan_id'
            )
            ->select(
                'kategori_laporans.nama_kategori',
                DB::raw('COUNT(laporans.id) as total')
            )
            ->groupBy(
                'kategori_laporans.id',
                'kategori_laporans.nama_kategori'
            )
            ->orderByDesc('total')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Laporan',
                    'data' => $kategori->pluck('total')->toArray(),
                    'backgroundColor' => '#3B82F6',
                ],
            ],
            'labels' => $kategori->pluck('nama_kategori')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
