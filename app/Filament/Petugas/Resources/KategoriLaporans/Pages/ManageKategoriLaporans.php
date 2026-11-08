<?php

namespace App\Filament\Petugas\Resources\KategoriLaporans\Pages;

use App\Filament\Petugas\Resources\KategoriLaporans\KategoriLaporanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageKategoriLaporans extends ManageRecords
{
    protected static string $resource = KategoriLaporanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
