<?php

namespace App\Filament\Masyarakat\Resources\Aspirasis;

use App\Filament\Masyarakat\Resources\Aspirasis\Pages\ManageAspirasis;
use App\Models\Aspirasi;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Schemas\Components\Section;

class AspirasiResource extends Resource
{
    protected static ?string $model = Aspirasi::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleLeftRight;

    protected static ?string $recordTitleAttribute = 'Aspirasi';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('user_id')
                    ->default(Auth::id()),
                TextInput::make('judul_aspirasi')
                    ->required(),
                Textarea::make('isi_aspirasi')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Section Informasi Utama Aspirasi
                Section::make('Detail Aspirasi')
                    ->description('Informasi lengkap mengenai aspirasi yang dikirimkan.')
                    ->schema([
                        TextEntry::make('user.name')
                            ->label('Nama Pengguna')
                            ->badge()
                            ->color('gray'),

                        TextEntry::make('created_at')
                            ->label('Dibuat Pada')
                            ->dateTime('d M Y, H:i')
                            ->placeholder('-'),

                        TextEntry::make('judul_aspirasi')
                            ->label('Judul Aspirasi')
                            ->weight('bold')
                            ->columnSpanFull(),

                        TextEntry::make('isi_aspirasi')
                            ->label('Isi Aspirasi')
                            ->columnSpanFull()
                            ->prose(),
                    ])
                    ->columns(2),

                // Section Daftar Balasan dari Petugas
                Section::make('Tanggapan / Balasan Petugas')
                    ->description('Riwayat balasan atau tanggapan dari petugas terkait aspirasi ini.')
                    ->schema([
                        RepeatableEntry::make('balasanAspirasi') // Menggunakan nama relasi hasMany
                            ->label('')
                            ->schema([
                                TextEntry::make('created_at')
                                    ->label('Waktu Balas :')
                                    ->dateTime('d M Y, H:i')
                                    ->badge()
                                    ->color('success'),
                                TextEntry::make('user.name')
                                    ->label('Nama Petugas :')
                                    ->columnSpanFull()
                                    ->prose(),
                                TextEntry::make('isi_balasan')
                                    ->label('Pesan Balasan :')
                                    ->columnSpanFull()
                                    ->prose(),
                            ])
                            ->columns(1)
                            ->contained(true), // Membuat setiap balasan terbungkus kotak yang rapi
                    ])
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Aspirasi')
            ->modifyQueryUsing(fn($query) => $query->where('user_id', Auth::id()))
            ->columns([
                TextColumn::make('judul_aspirasi')
                    ->searchable(),
                TextColumn::make('isi_aspirasi')
                    ->limit(50)
                    ->searchable(),
                TextColumn::make('balasan_aspirasi_count')
                    ->label('Jumlah Balasan')
                    ->counts('balasanAspirasi')
                    ->suffix(' balasan')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageAspirasis::route('/'),
        ];
    }
}
