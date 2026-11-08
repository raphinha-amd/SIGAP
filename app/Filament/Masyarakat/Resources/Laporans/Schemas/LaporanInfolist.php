<?php

namespace App\Filament\Masyarakat\Resources\Laporans\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class LaporanInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                // 1. Informasi Utama Laporan
                Section::make()
                    ->heading(fn($record) => $record->judul_laporan)
                    ->description('Informasi utama dan perkembangan laporan Anda.')
                    ->icon('heroicon-o-clipboard-document-check')
                    ->iconColor('primary')
                    ->schema([
                        Grid::make([
                            'default' => 1,
                            'md' => 2,
                        ])->schema([

                            TextEntry::make('status_laporan')
                                ->label('Status Laporan')
                                ->badge()
                                ->size('lg')
                                ->formatStateUsing(fn($state) => match ($state) {
                                    'menunggu' => 'Menunggu Verifikasi',
                                    'verifikasi' => 'Sedang Diverifikasi',
                                    'proses' => 'Sedang Diproses',
                                    'tolak' => 'Ditolak',
                                    'selesai' => 'Selesai',
                                    default => ucfirst($state ?? '-'),
                                })
                                ->color(fn($state) => match ($state) {
                                    'menunggu' => 'gray',
                                    'verifikasi' => 'info',
                                    'proses' => 'warning',
                                    'tolak' => 'danger',
                                    'selesai' => 'success',
                                    default => 'gray',
                                })
                                ->icon('heroicon-o-flag'),

                            TextEntry::make('kategoriLaporan.nama_kategori')
                                ->label('Kategori Laporan')
                                ->badge()
                                ->color('info')
                                ->icon('heroicon-o-tag')
                                ->placeholder('-'),

                            TextEntry::make('user.name')
                                ->label('Nama Pelapor')
                                ->icon('heroicon-o-user')
                                ->placeholder('-'),

                            TextEntry::make('created_at')
                                ->label('Tanggal Pengajuan')
                                ->dateTime('d F Y, H:i')
                                ->icon('heroicon-o-calendar')
                                ->placeholder('-'),
                        ]),
                    ])
                    ->columnSpanFull(),

                // 2. Detail Laporan
                Section::make('Detail Laporan')
                    ->description('Penjelasan mengenai permasalahan yang Anda sampaikan.')
                    ->icon('heroicon-o-document-text')
                    ->iconColor('primary')
                    ->schema([
                        TextEntry::make('deskripsi_laporan')
                            ->label('Deskripsi Permasalahan')
                            ->prose()
                            ->placeholder('Tidak ada deskripsi laporan.')
                            ->columnSpanFull(),

                        TextEntry::make('alamat')
                            ->label('Lokasi Kejadian')
                            ->icon('heroicon-o-map-pin')
                            ->iconColor('danger')
                            ->placeholder('Lokasi tidak dicantumkan.')
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),

                // 3. Dokumentasi Foto
                Section::make('Dokumentasi Foto')
                    ->description('Foto pendukung yang dilampirkan pada laporan.')
                    ->icon('heroicon-o-camera')
                    ->iconColor('primary')
                    ->schema([
                        RepeatableEntry::make('fotoLaporan')
                            ->label('Lampiran Foto')
                            ->schema([
                                ImageEntry::make('foto_path')
                                    ->label('')
                                    ->imageWidth('100%')
                                    ->imageHeight(220)
                                    ->extraImgAttributes([
                                        'class' => 'w-full rounded-xl object-cover border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition duration-300 cursor-zoom-in',
                                        'onclick' => "window.open(this.src, '_blank')",
                                    ]),
                            ])
                            ->grid([
                                'default' => 1,
                                'sm' => 2,
                                'lg' => 3,
                            ])
                            ->contained(false),
                    ])
                    ->collapsible()
                    ->columnSpanFull(),

                // 4. Catatan Petugas
                Section::make('Catatan Petugas')
                    ->description('Informasi atau tanggapan tambahan dari petugas desa.')
                    ->icon('heroicon-o-chat-bubble-left-ellipsis')
                    ->iconColor('success')
                    ->schema([
                        TextEntry::make('catatan_petugas')
                            ->label('Tanggapan Petugas')
                            ->prose()
                            ->placeholder('Belum ada catatan atau tanggapan dari petugas.')
                            ->color(fn($state) => filled($state) ? 'success' : 'gray')
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->columnSpanFull(),

                // 5. Riwayat Tindak Lanjut
                Section::make('Riwayat Tindak Lanjut')
                    ->description('Pantau setiap tahapan penanganan laporan oleh petugas desa.')
                    ->icon('heroicon-o-clock')
                    ->iconColor('warning')
                    ->schema([
                        RepeatableEntry::make('tindakLanjut')
                            ->label('Riwayat Progres')
                            ->schema([

                                Grid::make([
                                    'default' => 1,
                                    'sm' => 2,
                                ])->schema([

                                    TextEntry::make('status')
                                        ->label('Status Penanganan')
                                        ->badge()
                                        ->formatStateUsing(fn($state) => match ($state) {
                                            'proses' => 'Sedang Diproses',
                                            'selesai' => 'Selesai',
                                            'batal' => 'Dibatalkan',
                                            default => ucfirst($state ?? '-'),
                                        })
                                        ->color(fn($state) => match ($state) {
                                            'proses' => 'warning',
                                            'selesai' => 'success',
                                            'batal' => 'danger',
                                            default => 'gray',
                                        })
                                        ->icon('heroicon-o-check-circle'),

                                    TextEntry::make('created_at')
                                        ->label('Waktu Pembaruan')
                                        ->dateTime('d F Y, H:i')
                                        ->icon('heroicon-o-calendar-days')
                                        ->color('gray'),
                                ]),

                                TextEntry::make('keterangan')
                                    ->label('Keterangan Tindakan')
                                    ->prose()
                                    ->placeholder('Tidak ada keterangan.')
                                    ->columnSpanFull(),

                            ])
                            ->contained(true)
                            ->columns(1),
                    ])
                    ->collapsible()
                    ->columnSpanFull(),

            ])
            ->columns(1);
    }
}
