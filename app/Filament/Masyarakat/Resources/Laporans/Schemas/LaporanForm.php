<?php

namespace App\Filament\Masyarakat\Resources\Laporans\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class LaporanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                // 1. INFORMASI LAPORAN
                Section::make('Informasi Laporan')
                    ->description('Sampaikan informasi laporan atau aspirasi yang ingin Anda ajukan kepada pemerintah desa.')
                    ->icon('heroicon-o-clipboard-document-list')
                    ->iconColor('primary')
                    ->schema([

                        Hidden::make('user_id')
                            ->default(fn() => Auth::id())
                            ->required(),

                        Select::make('kategori_laporan_id')
                            ->label('Kategori Laporan')
                            ->relationship('kategoriLaporan', 'nama_kategori')
                            ->placeholder('Pilih kategori laporan')
                            ->helperText('Pilih kategori yang paling sesuai dengan permasalahan Anda.')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->prefixIcon('heroicon-o-tag')
                            ->columnSpanFull(),

                        TextInput::make('judul_laporan')
                            ->label('Judul Laporan')
                            ->placeholder('Contoh: Jalan Rusak di Dusun Sukamaju')
                            ->helperText('Buat judul singkat yang menggambarkan permasalahan.')
                            ->required()
                            ->maxLength(255)
                            ->prefixIcon('heroicon-o-pencil-square')
                            ->columnSpanFull(),

                        Textarea::make('deskripsi_laporan')
                            ->label('Deskripsi Permasalahan')
                            ->placeholder('Jelaskan permasalahan yang Anda alami atau temukan secara lengkap...')
                            ->helperText('Tuliskan kronologi, kondisi permasalahan, dan informasi pendukung lainnya.')
                            ->required()
                            ->rows(5)
                            ->autosize()
                            ->maxLength(3000)
                            ->columnSpanFull(),

                        Textarea::make('alamat')
                            ->label('Lokasi Kejadian')
                            ->placeholder('Contoh: Jalan Raya Sukamaju, RT 02/RW 01, Desa Sukamaju')
                            ->helperText('Cantumkan alamat atau lokasi kejadian secara jelas agar petugas mudah menemukan lokasi.')
                            ->required()
                            ->rows(3)
                            ->autosize()
                            ->maxLength(1000)
                            ->columnSpanFull(),

                    ])
                    ->columns(2)
                    ->collapsible(false)
                    ->columnSpanFull(),

                // 2. DOKUMENTASI LAPORAN
                Section::make('Dokumentasi Pendukung')
                    ->description('Tambahkan foto sebagai bukti atau dokumentasi kondisi permasalahan di lapangan.')
                    ->icon('heroicon-o-camera')
                    ->iconColor('success')
                    ->schema([

                        Repeater::make('fotoLaporan')
                            ->label('Foto Pendukung')
                            ->relationship('fotoLaporan')
                            ->schema([

                                FileUpload::make('foto_path')
                                    ->label('Unggah Foto')
                                    ->image()
                                    ->imageEditor()
                                    ->imagePreviewHeight('200')
                                    ->maxSize(5120)
                                    ->acceptedFileTypes([
                                        'image/jpeg',
                                        'image/png',
                                        'image/jpg',
                                        'image/webp',
                                    ])
                                    ->required()
                                    ->helperText('Format JPG, JPEG, PNG, atau WEBP. Maksimal ukuran 5 MB.'),

                            ])
                            ->columns(1)
                            ->grid(2)
                            ->addActionLabel('Tambah Foto')
                            // ->addActionIcon('heroicon-o-plus')
                            ->reorderable(false)
                            ->collapsible()
                            ->itemLabel(
                                fn(array $state): ?string =>
                                filled($state['foto_path'] ?? null)
                                    ? 'Foto Pendukung'
                                    : 'Foto Baru'
                            )
                            ->columnSpanFull()
                            ->maxItems(5)
                            ->defaultItems(0),

                    ])
                    ->collapsible(false)
                    ->columnSpanFull(),

            ])
            ->columns(1);
    }
}
