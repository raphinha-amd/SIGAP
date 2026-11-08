<?php

namespace App\Filament\Masyarakat\Resources\Laporans;

use App\Filament\Masyarakat\Resources\Laporans\Pages\CreateLaporan;
use App\Filament\Masyarakat\Resources\Laporans\Pages\EditLaporan;
use App\Filament\Masyarakat\Resources\Laporans\Pages\ListLaporans;
use App\Filament\Masyarakat\Resources\Laporans\Pages\ViewLaporan;
use App\Filament\Masyarakat\Resources\Laporans\Schemas\LaporanForm;
use App\Filament\Masyarakat\Resources\Laporans\Schemas\LaporanInfolist;
use App\Filament\Masyarakat\Resources\Laporans\Tables\LaporansTable;
use App\Models\Laporan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LaporanResource extends Resource
{
    protected static ?string $model = Laporan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static ?string $recordTitleAttribute = 'Laporan';

    public static function form(Schema $schema): Schema
    {
        return LaporanForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return LaporanInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LaporansTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLaporans::route('/'),
            'create' => CreateLaporan::route('/create'),
            'view' => ViewLaporan::route('/{record}'),
            'edit' => EditLaporan::route('/{record}/edit'),
        ];
    }
}
