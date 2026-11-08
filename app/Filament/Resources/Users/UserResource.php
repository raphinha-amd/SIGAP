<?php

namespace App\Filament\Resources\Users;

use App\Filament\Resources\Users\Pages\ManageUsers;
use App\Models\User;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static ?string $recordTitleAttribute = 'User';

    protected static ?string $navigationLabel = 'Kelola Pengguna';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Pribadi')
                    ->description('Lengkapi data dasar pengguna.')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama lengkap')
                            ->placeholder('Masukkan nama lengkap')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('nik')
                            ->label('NIK')
                            ->placeholder('Masukkan NIK')
                            ->required()
                            ->numeric()
                            ->maxLength(16),
                        TextInput::make('no_telp')
                            ->label('Nomor telepon')
                            ->placeholder('Contoh: 081234567890')
                            ->tel()
                            ->required()
                            ->maxLength(20),
                    ]),
                Section::make('Akses Akun')
                    ->description('Atur kredensial, peran, dan status akun pengguna.')
                    ->schema([
                        TextInput::make('email')
                            ->label('Alamat email')
                            ->placeholder('nama@contoh.com')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        Select::make('role')
                            ->label('Peran')
                            ->options([
                                'admin' => 'Admin',
                                'petugas' => 'Petugas',
                                'masyarakat' => 'Masyarakat',
                            ])
                            ->default('masyarakat')
                            ->native(false)
                            ->required(),
                        TextInput::make('password')
                            ->label('Kata sandi')
                            ->password()
                            ->revealable()
                            ->required(fn(string $operation): bool => $operation === 'create')
                            ->dehydrated(fn(?string $state): bool => filled($state))
                            ->minLength(8)
                            ->maxLength(255)
                            ->helperText('Minimal 8 karakter. Kosongkan saat edit jika tidak ingin mengubahnya.'),
                        Toggle::make('status_akun')
                            ->label('Akun aktif')
                            ->default(true)
                            ->inline(false),
                        Hidden::make('email_verified_at')
                            ->default(fn(?User $record): ?string => filled($record) ? $record->email_verified_at : now()),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('User')
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->label('Nama'),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                TextColumn::make('nik')
                    ->searchable(),
                TextColumn::make('no_telp')
                    ->searchable(),
                TextColumn::make('role')
                    ->badge(),
                IconColumn::make('status_akun')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
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
            'index' => ManageUsers::route('/'),
        ];
    }
}
