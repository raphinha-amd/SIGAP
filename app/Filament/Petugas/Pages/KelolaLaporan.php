<?php

namespace App\Filament\Petugas\Pages;

use App\Models\Laporan;
use App\Models\TindakLanjut;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Pages\Page;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Support\Facades\Auth;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class KelolaLaporan extends Page implements HasTable
{
    use InteractsWithTable;

    protected string $view = 'filament.petugas.pages.kelola-laporan';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static ?string $slug = 'manage-laporan/{record}/kelola';

    protected static bool $shouldRegisterNavigation = false;
  
    public int|string $recordId;

    public function mount(int|string $record): void
    {
        $this->recordId = $record;

        // Pastikan laporan tersedia.
        $this->getRecord();
    }

    public function getRecord(): Laporan
    {
        return Laporan::query()
            ->with([
                'user',
                'kategoriLaporan',
                'fotoLaporan',
            ])
            ->findOrFail($this->recordId);
    }

    public static function canAccess(): bool
    {
        return Auth::check();
    }

    public function getTitle(): string
    {
        return 'Detail Laporan Masyarakat';
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->record($this->getRecord())
            ->components([

                Section::make('Informasi Laporan')
                    ->description('Informasi utama laporan masyarakat.')
                    ->icon('heroicon-o-document-text')
                    ->schema([

                        Grid::make(2)
                            ->schema([

                                TextEntry::make('judul_laporan')
                                    ->label('Judul Laporan')
                                    ->weight('bold'),

                                TextEntry::make('status_laporan')
                                    ->label('Status Laporan')
                                    ->badge()
                                    ->formatStateUsing(fn($state) => match ($state) {
                                        'menunggu' => 'Menunggu Verifikasi',
                                        'verifikasi' => 'Terverifikasi',
                                        'proses' => 'Sedang Diproses',
                                        'tolak' => 'Ditolak',
                                        'selesai' => 'Selesai',
                                        default => $state,
                                    })
                                    ->color(fn($state) => match ($state) {
                                        'menunggu' => 'warning',
                                        'verifikasi' => 'info',
                                        'proses' => 'primary',
                                        'tolak' => 'danger',
                                        'selesai' => 'success',
                                        default => 'gray',
                                    }),

                                TextEntry::make('user.name')
                                    ->label('Nama Pelapor')
                                    ->icon('heroicon-o-user'),

                                TextEntry::make('kategoriLaporan.nama_kategori')
                                    ->label('Kategori Laporan')
                                    ->icon('heroicon-o-tag'),

                                TextEntry::make('alamat')
                                    ->label('Alamat / Lokasi')
                                    ->icon('heroicon-o-map-pin')
                                    ->columnSpanFull(),

                                TextEntry::make('created_at')
                                    ->label('Tanggal Laporan')
                                    ->dateTime('d F Y, H:i'),

                            ]),
                    ]),

                Section::make('Deskripsi Laporan')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->schema([
                        TextEntry::make('deskripsi_laporan')
                            ->label('Isi Laporan')
                            ->columnSpanFull(),
                    ]),

                Section::make('Foto Laporan')
                    ->description('Dokumentasi foto yang dikirim oleh masyarakat.')
                    ->icon('heroicon-o-photo')
                    ->schema([
                        RepeatableEntry::make('fotoLaporan')
                            ->label('')
                            ->schema([
                                ImageEntry::make('foto_path')
                                    ->label('Dokumentasi')
                                    ->height(220)
                                    ->width('100%')
                                    ->extraAttributes([
                                        'class' => 'rounded-xl',
                                    ]),
                            ])
                            ->columns(3),
                    ])
                    ->collapsible(),

                Section::make('Catatan Petugas Sebelumnya')
                    ->icon('heroicon-o-information-circle')
                    ->schema([
                        TextEntry::make('catatan_petugas')
                            ->label('Catatan')
                            ->placeholder('Belum ada catatan dari petugas.')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),

            ]);
    }

    protected function getHeaderActions(): array
    {
        return [

            Action::make('validasi')
                ->label('Validasi / Ubah Status')
                ->icon('heroicon-o-pencil-square')
                ->color('primary')
                ->schema([
                    Select::make('status_laporan')
                        ->label('Status Laporan')
                        ->options([
                            'menunggu' => 'Menunggu Verifikasi',
                            'verifikasi' => 'Terima / Verifikasi',
                            'proses' => 'Sedang Diproses',
                            'tolak' => 'Tolak Laporan',
                            'selesai' => 'Selesai',
                        ])
                        ->required()
                        ->native(false),

                    Textarea::make('catatan_petugas')
                        ->label('Catatan Petugas')
                        ->placeholder('Tuliskan alasan atau hasil pemeriksaan laporan...')
                        ->rows(4)
                        ->required(),
                ])
                ->fillForm(fn(): array => [
                    'status_laporan' => $this->getRecord()->status_laporan,
                    'catatan_petugas' => $this->getRecord()->catatan_petugas,
                ])
                ->modalHeading('Validasi / Ubah Status Laporan')
                ->modalDescription('Perbarui status jika terjadi kesalahan atau ada perubahan penanganan laporan.')
                ->modalWidth('lg')
                ->modalSubmitActionLabel('Simpan Perubahan')
                ->action(function (array $data) {

                    $record = Laporan::findOrFail($this->recordId);

                    $record->update([
                        'status_laporan' => $data['status_laporan'],
                        'catatan_petugas' => $data['catatan_petugas'],
                    ]);

                    Notification::make()
                        ->title('Status laporan berhasil diperbarui')
                        ->success()
                        ->send();

                    $this->dispatch('refresh-page');
                }),

            Action::make('kembali')
                ->label('Kembali')
                ->icon('heroicon-o-arrow-left')
                ->color('gray')
                ->url(ManageLaporan::getUrl(panel: 'petugas'))
                ->extraAttributes([
                    'class' => 'ml-auto',
                ]),

        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                $this->getRecord()
                    ->tindakLanjut()
                    ->getQuery()
                    ->with('user')
            )

            ->columns([

                TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),

                TextColumn::make('user.name')
                    ->label('Petugas')
                    ->placeholder('-'),

                TextColumn::make('keterangan')
                    ->label('Keterangan Tindak Lanjut')
                    ->wrap()
                    ->searchable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn($state) => match ($state) {
                        'batal' => 'Dibatalkan',
                        'proses' => 'Sedang Diproses',
                        'selesai' => 'Selesai',
                        default => $state,
                    })
                    ->color(fn($state) => match ($state) {
                        'batal' => 'danger',
                        'proses' => 'warning',
                        'selesai' => 'success',
                        default => 'gray',
                    }),

            ])

            ->headerActions([

                Action::make('tambahTindakLanjut')
                    ->label('Tambah Tindak Lanjut')
                    ->icon('heroicon-o-plus')
                    ->color('primary')

                    ->schema([

                        Textarea::make('keterangan')
                            ->label('Keterangan Tindak Lanjut')
                            ->placeholder('Jelaskan tindakan yang sudah atau akan dilakukan...')
                            ->rows(4)
                            ->required()
                            ->maxLength(65535),

                        Select::make('status')
                            ->label('Status Tindak Lanjut')
                            ->options([
                                'proses' => 'Sedang Diproses',
                                'selesai' => 'Selesai',
                                'batal' => 'Dibatalkan',
                            ])
                            ->default('proses')
                            ->required()
                            ->native(false),

                    ])

                    ->modalHeading('Tambah Tindak Lanjut')
                    ->modalDescription('Masukkan informasi perkembangan penanganan laporan.')
                    ->modalWidth('lg')
                    ->modalSubmitActionLabel('Simpan Tindak Lanjut')

                    ->action(function (array $data) {

                        $record = Laporan::findOrFail($this->recordId);

                        $record->tindakLanjut()->create([
                            'user_id' => Auth::id(),
                            'keterangan' => $data['keterangan'],
                            'status' => $data['status'],
                        ]);

                        // Jika tindak lanjut pertama dimulai,
                        // ubah status laporan menjadi proses.
                        if (
                            $record->status_laporan === 'verifikasi'
                            && $data['status'] === 'proses'
                        ) {
                            $record->update([
                                'status_laporan' => 'proses',
                            ]);
                        }

                        // Jika tindak lanjut selesai,
                        // laporan juga ditandai selesai.
                        if ($data['status'] === 'selesai') {
                            $record->update([
                                'status_laporan' => 'selesai',
                            ]);
                        }

                        Notification::make()
                            ->title('Tindak lanjut berhasil ditambahkan')
                            ->success()
                            ->send();

                        $this->dispatch('refresh-page');
                    }),

            ])

            ->recordActions([
                Action::make('editTindakLanjut')
                    ->label('Edit')
                    ->icon('heroicon-o-pencil-square')
                    ->color('gray')
                    ->schema([
                        Select::make('status')
                            ->label('Status Tindak Lanjut')
                            ->options([
                                'proses' => 'Sedang Diproses',
                                'selesai' => 'Selesai',
                                'batal' => 'Dibatalkan',
                            ])
                            ->required()
                            ->native(false),

                        Textarea::make('keterangan')
                            ->label('Keterangan Tindak Lanjut')
                            ->placeholder('Jelaskan tindakan yang sudah atau akan dilakukan...')
                            ->rows(4)
                            ->required()
                            ->maxLength(65535),
                    ])
                    ->fillForm(fn(TindakLanjut $record): array => [
                        'status' => $record->status,
                        'keterangan' => $record->keterangan,
                    ])
                    ->modalHeading('Edit Tindak Lanjut')
                    ->modalDescription('Perbaiki status atau keterangan tindak lanjut jika terjadi kesalahan.')
                    ->modalWidth('lg')
                    ->modalSubmitActionLabel('Simpan Perubahan')
                    ->action(function (TindakLanjut $record, array $data): void {
                        $record->update([
                            'status' => $data['status'],
                            'keterangan' => $data['keterangan'],
                        ]);

                        $this->resetTable();

                        Notification::make()
                            ->title('Tindak lanjut berhasil diperbarui')
                            ->success()
                            ->send();
                    }),
                Action::make('hapusTindakLanjut')
                    ->label('Hapus')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Hapus Tindak Lanjut')
                    ->modalDescription('Apakah Anda yakin ingin menghapus tindak lanjut ini? Tindak lanjut yang dihapus tidak dapat dikembalikan.')
                    ->modalSubmitActionLabel('Hapus Tindak Lanjut')
                    ->action(function (TindakLanjut $record): void {
                        $record->delete();

                        $this->resetTable();

                        Notification::make()
                            ->title('Tindak lanjut berhasil dihapus')
                            ->success()
                            ->send();
                    }),
            ])

            ->defaultSort('created_at', 'desc')
            ->striped()
            ->paginated([5, 10, 25])

            ->emptyStateHeading('Belum Ada Tindak Lanjut')
            ->emptyStateDescription(
                'Belum ada aktivitas penanganan untuk laporan ini.'
            )
            ->emptyStateIcon('heroicon-o-clipboard-document-list');
    }
}
