<?php

namespace App\Filament\Masyarakat\Resources\Aspirasis\Pages;

use App\Filament\Masyarakat\Resources\Aspirasis\AspirasiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageAspirasis extends ManageRecords
{
    protected static string $resource = AspirasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
