<?php

namespace App\Filament\Petugas\Pages;

use App\Models\Aspirasi;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class ManageAspirasi extends Page implements HasTable
{
    use InteractsWithTable;

    protected string $view = 'filament.petugas.pages.manage-aspirasi';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationLabel = 'Kelola Aspirasi Masyarakat';

    protected static ?string $title = 'Kelola Aspirasi Masyarakat';

    protected static ?int $navigationSort = 2;

    public static function getNavigationItemActiveRoutePattern(): string|array
    {
        return [
            static::getRouteName(),
            ManageAspirasi::getRouteName() . '.*',
        ];
    }

    public static function canAccess(): bool
    {
        return Auth::check();
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Aspirasi::query()
                    ->with('user')
            )
            ->columns([
                TextColumn::make('judul_aspirasi')
                    ->label('Judul Aspirasi')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('isi_aspirasi')
                    ->label('Isi Aspirasi')
                    ->searchable()
                    ->sortable()
                    ->limit(50),

                TextColumn::make('user.name')
                    ->label('Pengirim')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('balasan_aspirasi_count')
                    ->label('Jumlah Balasan')
                    ->counts('balasanAspirasi')
                    ->suffix(' balasan')
                    ->sortable(),

            ])
            ->recordActions([
                Action::make('kelola')
                    ->label('Kelola Aspirasi')
                    ->icon('heroicon-o-arrow-right')
                    ->color('primary')
                    ->url(
                        fn(Aspirasi $record): string => KelolaAspirasi::getUrl(
                            ['record' => $record->getKey()],
                            panel: 'petugas'
                        )
                    ),
            ])
            ->defaultSort('created_at', 'desc')
            ->emptyStateHeading('Belum Ada Aspirasi')
            ->emptyStateDescription('Belum terdapat aspirasi masyarakat yang masuk.')
            ->emptyStateIcon('heroicon-o-chat-bubble-left-right')
            ->striped()
            ->paginated([10, 25, 50]);
    }
}
