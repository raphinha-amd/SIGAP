<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;

class GrafikStatusPengguna extends ChartWidget
{
    protected ?string $heading = 'Grafik Status Pengguna';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Pengguna',
                    'data' => [
                        User::where('status_akun', true)->count(),
                        User::where('status_akun', false)->count(),
                    ],
                    'backgroundColor' => [
                        '#22C55E',
                        '#EF4444',
                    ],
                ],
            ],
            'labels' => [
                'Aktif',
                'Nonaktif',
            ],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
