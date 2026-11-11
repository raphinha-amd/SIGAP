<?php

namespace App\Filament\Petugas\Pages;

use App\Models\Laporan;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class ManageLaporan extends Page implements HasTable
{
    use InteractsWithTable;

    protected string $view = 'filament.petugas.pages.manage-laporan';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationLabel = 'Kelola Laporan Masyarakat';

    protected static ?string $title = 'Kelola Laporan Masyarakat';

    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        $total = Laporan::where('status_laporan', 'menunggu')->count();

        return $total > 0 ? (string) $total : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'Jumlah laporan yang belum ditanggapi';
    }

    public static function canAccess(): bool
    {
        return Auth::check();
    }

    public static function getNavigationItemActiveRoutePattern(): string|array
    {
        return [
            static::getRouteName(),
            ManageLaporan::getRouteName() . '.*',
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Laporan::query()
                    ->with(['user', 'kategoriLaporan'])
            )

            ->columns([
                TextColumn::make('judul_laporan')
                    ->label('Judul Laporan')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(
                        fn(Laporan $record) => str($record->deskripsi_laporan)->limit(65)
                    ),

                TextColumn::make('user.name')
                    ->label('Pelapor')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('kategoriLaporan.nama_kategori')
                    ->label('Kategori')
                    ->sortable(),

                TextColumn::make('alamat')
                    ->label('Lokasi')
                    ->limit(35)
                    ->tooltip(fn(Laporan $record) => $record->alamat),

                TextColumn::make('status_laporan')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'menunggu' => 'Menunggu Verifikasi',
                        'verifikasi' => 'Terverifikasi',
                        'proses' => 'Sedang Diproses',
                        'tolak' => 'Ditolak',
                        'selesai' => 'Selesai',
                        default => $state,
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'menunggu' => 'warning',
                        'verifikasi' => 'info',
                        'proses' => 'primary',
                        'tolak' => 'danger',
                        'selesai' => 'success',
                        default => 'gray',
                    }),

                TextColumn::make('created_at')
                    ->label('Tanggal Laporan')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])

            ->filters([
                SelectFilter::make('status_laporan')
                    ->label('Filter Status')
                    ->options([
                        'menunggu' => 'Menunggu Verifikasi',
                        'verifikasi' => 'Terverifikasi',
                        'proses' => 'Sedang Diproses',
                        'tolak' => 'Ditolak',
                        'selesai' => 'Selesai',
                    ]),

                SelectFilter::make('kategori_laporan_id')
                    ->label('Filter Kategori')
                    ->relationship('kategoriLaporan', 'nama_kategori'),
            ])

            ->recordActions([
                Action::make('kelola')
                    ->label('Kelola Laporan')
                    ->icon('heroicon-o-arrow-right')
                    ->color('primary')
                    ->url(
                        fn(Laporan $record): string => KelolaLaporan::getUrl(
                            ['record' => $record->getKey()],
                            panel: 'petugas'
                        )
                    ),
            ])

            ->defaultSort('created_at', 'desc')

            ->emptyStateHeading('Belum Ada Laporan')
            ->emptyStateDescription('Belum terdapat laporan masyarakat yang masuk.')
            ->emptyStateIcon('heroicon-o-clipboard-document-list')

            ->striped()
            ->paginated([10, 25, 50]);
    }
}
