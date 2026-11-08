<?php

namespace App\Filament\Masyarakat\Resources\Laporans\Pages;

use App\Filament\Masyarakat\Resources\Laporans\LaporanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLaporans extends ListRecords
{
    protected static string $resource = LaporanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
