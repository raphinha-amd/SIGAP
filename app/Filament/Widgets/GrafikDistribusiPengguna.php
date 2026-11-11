<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;

class GrafikDistribusiPengguna extends ChartWidget
{
    protected ?string $heading = 'Grafik Distribusi Pengguna';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Pengguna',
                    'data' => [
                        User::where('role', 'masyarakat')->count(),
                        User::where('role', 'admin')->count(),
                        User::where('role', 'petugas')->count(),
                    ],
                    'backgroundColor' => [
                        '#22C55E',
                        '#F59E0B',
                        '#3B82F6',
                    ],
                ],
            ],
            'labels' => [
                'Masyarakat',
                'Admin',
                'Petugas',
            ],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
