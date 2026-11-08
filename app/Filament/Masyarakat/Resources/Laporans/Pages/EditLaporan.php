<?php

namespace App\Filament\Masyarakat\Resources\Laporans\Pages;

use App\Filament\Masyarakat\Resources\Laporans\LaporanResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditLaporan extends EditRecord
{
    protected static string $resource = LaporanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            Action::make('back')
                ->label('Kembali ke tabel')
                ->url(LaporanResource::getUrl('index')),

        ];
    }
}
