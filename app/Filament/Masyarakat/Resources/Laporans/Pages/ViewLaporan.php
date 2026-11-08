<?php

namespace App\Filament\Masyarakat\Resources\Laporans\Pages;

use App\Filament\Masyarakat\Resources\Laporans\LaporanResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewLaporan extends ViewRecord
{
    protected static string $resource = LaporanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('kembali')
                ->label('Kembali')
                ->icon('heroicon-o-arrow-left')
                ->color('gray')
                ->url(LaporanResource::getUrl('index')),
        ];
    }
}
