<?php

namespace App\Filament\Masyarakat\Resources\Laporans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class LaporansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn($query) => $query->where('user_id', Auth::id()))
            ->columns([

                // Menampilkan Nama Kategori alih-alih kategori_laporan_id (angka)
                TextColumn::make('kategoriLaporan.nama_kategori')
                    ->label('Kategori')
                    ->badge()
                    ->color('info')
                    ->searchable()
                    ->sortable(),

                // Judul Laporan utama
                TextColumn::make('judul_laporan')
                    ->label('Judul Laporan')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->limit(35), // Membatasi panjang teks agar tidak terlalu memakan tempat

                // Status Laporan dengan Badge berwarna sesuai kondisi
                TextColumn::make('status_laporan')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn($state) => ucwords($state ?? '-'))
                    ->color(fn(string $state): string => match ($state) {
                        'menunggu' => 'gray',
                        'verifikasi' => 'info',
                        'proses' => 'warning',
                        'tolak' => 'danger',
                        'selesai' => 'success',
                        default => 'gray',
                    })
                    ->sortable(),

                // Tanggal dibuat dengan format yang lebih ramah dibaca
                TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->icon('heroicon-o-calendar'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
