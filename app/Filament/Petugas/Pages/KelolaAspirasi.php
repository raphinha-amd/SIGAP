<?php

namespace App\Filament\Petugas\Pages;

use App\Models\Aspirasi;
use App\Models\BalasanAspirasi;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class KelolaAspirasi extends Page implements HasTable
{
    use InteractsWithTable;

    protected string $view = 'filament.petugas.pages.kelola-aspirasi';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $slug = 'manage-aspirasi/{record}/kelola';

    protected static bool $shouldRegisterNavigation = false;

    public int|string $recordId;

    public function mount(int|string $record): void
    {
        $this->recordId = $record;

        $this->getRecord();
    }

    public function getRecord(): Aspirasi
    {
        return Aspirasi::query()
            ->with('user')
            ->findOrFail($this->recordId);
    }

    public static function canAccess(): bool
    {
        return Auth::check();
    }

    public function getTitle(): string
    {
        return 'Detail Aspirasi Masyarakat';
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->record($this->getRecord())
            ->components([
                Section::make('Informasi Aspirasi')
                    ->description('Informasi utama aspirasi masyarakat.')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('judul_aspirasi')
                                    ->label('Judul Aspirasi')
                                    ->weight('bold')
                                    ->columnSpanFull(),

                                TextEntry::make('user.name')
                                    ->label('Nama Pengirim')
                                    ->icon('heroicon-o-user'),

                                TextEntry::make('created_at')
                                    ->label('Tanggal Aspirasi')
                                    ->dateTime('d F Y, H:i'),
                            ]),
                    ]),

                Section::make('Isi Aspirasi')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->schema([
                        TextEntry::make('isi_aspirasi')
                            ->label('Isi Aspirasi')
                            ->columnSpanFull()
                            ->prose(),
                    ]),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('kembali')
                ->label('Kembali')
                ->icon('heroicon-o-arrow-left')
                ->color('gray')
                ->url(ManageAspirasi::getUrl(panel: 'petugas'))
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
                    ->balasanAspirasi()
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

                TextColumn::make('isi_balasan')
                    ->label('Balasan')
                    ->wrap()
                    ->searchable(),
            ])
            ->headerActions([
                Action::make('balasAspirasi')
                    ->label('Balas Aspirasi')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('primary')
                    ->schema([
                        Textarea::make('isi_balasan')
                            ->label('Isi Balasan')
                            ->placeholder('Tuliskan tanggapan untuk aspirasi masyarakat...')
                            ->rows(5)
                            ->required()
                            ->maxLength(65535),
                    ])
                    ->modalHeading('Balas Aspirasi Masyarakat')
                    ->modalDescription('Sampaikan tanggapan atau tindak lanjut kepada masyarakat.')
                    ->modalWidth('lg')
                    ->modalSubmitActionLabel('Kirim Balasan')
                    ->action(function (array $data): void {
                        $this->getRecord()->balasanAspirasi()->create([
                            'user_id' => Auth::id(),
                            'isi_balasan' => $data['isi_balasan'],
                        ]);

                        Notification::make()
                            ->title('Balasan aspirasi berhasil dikirim')
                            ->success()
                            ->send();

                        $this->resetTable();
                    }),
            ])
            ->recordActions([
                Action::make('editBalasan')
                    ->label('Edit')
                    ->icon('heroicon-o-pencil-square')
                    ->color('gray')
                    ->schema([
                        Textarea::make('isi_balasan')
                            ->label('Isi Balasan')
                            ->rows(5)
                            ->required()
                            ->maxLength(65535),
                    ])
                    ->fillForm(fn (BalasanAspirasi $record): array => [
                        'isi_balasan' => $record->isi_balasan,
                    ])
                    ->modalHeading('Edit Balasan Aspirasi')
                    ->modalDescription('Perbarui balasan yang telah dikirim kepada masyarakat.')
                    ->modalWidth('lg')
                    ->modalSubmitActionLabel('Simpan Perubahan')
                    ->action(function (BalasanAspirasi $record, array $data): void {
                        $record->update([
                            'isi_balasan' => $data['isi_balasan'],
                        ]);

                        Notification::make()
                            ->title('Balasan aspirasi berhasil diperbarui')
                            ->success()
                            ->send();

                        $this->resetTable();
                    }),

                Action::make('hapusBalasan')
                    ->label('Hapus')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Hapus Balasan Aspirasi')
                    ->modalDescription('Apakah Anda yakin ingin menghapus balasan ini?')
                    ->modalSubmitActionLabel('Hapus Balasan')
                    ->action(function (BalasanAspirasi $record): void {
                        $record->delete();

                        Notification::make()
                            ->title('Balasan aspirasi berhasil dihapus')
                            ->success()
                            ->send();

                        $this->resetTable();
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->emptyStateHeading('Belum Ada Balasan')
            ->emptyStateDescription('Belum ada tanggapan petugas untuk aspirasi ini.')
            ->emptyStateIcon('heroicon-o-chat-bubble-left-right')
            ->striped()
            ->paginated([10, 25, 50]);
    }
}
