<?php

namespace App\Filament\Resources\Users;

use App\Exports\UsersExport;
use App\Exports\UserTemplateExport;
use App\Filament\Resources\Users\Pages\ManageUsers;
use App\Models\User;
use App\Services\UserImportService;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
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
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Excel as ExcelType;
use Maatwebsite\Excel\Facades\Excel;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static ?string $recordTitleAttribute = 'User';

    protected static ?string $navigationLabel = 'Kelola Pengguna';

    public static function canViewAny(): bool
    {
        return auth()->user()?->role === 'admin';
    }

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
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->dehydrated(fn (?string $state): bool => filled($state))
                            ->minLength(8)
                            ->maxLength(255)
                            ->helperText('Minimal 8 karakter. Kosongkan saat edit jika tidak ingin mengubahnya.'),
                        Toggle::make('status_akun')
                            ->label('Akun aktif')
                            ->default(true)
                            ->inline(false),
                        Hidden::make('email_verified_at')
                            ->default(fn (?User $record): ?string => filled($record) ? $record->email_verified_at : now()),
                    ]),
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
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'admin' => 'Admin',
                        'petugas' => 'Petugas',
                        'masyarakat' => 'Masyarakat',
                        default => $state,
                    })
                    ->badge(),
                IconColumn::make('status_akun')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                static::exportAction(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    static::exportSelectedAction(),
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

    private static function exportAction(): Action
    {
        return Action::make('exportUsers')
            ->label('Export User')
            ->icon(Heroicon::OutlinedArrowDownTray)
            ->schema([static::exportFormatField()])
            ->action(function (array $data) {
                $format = $data['format'];

                return Excel::download(
                    new UsersExport(User::query()->orderBy('id')->get()),
                    "users.{$format}",
                    $format === 'csv' ? ExcelType::CSV : ExcelType::XLSX,
                );
            });
    }

    private static function exportSelectedAction(): BulkAction
    {
        return BulkAction::make('exportSelectedUsers')
            ->label('Export User Terpilih')
            ->icon(Heroicon::OutlinedArrowDownTray)
            ->schema([static::exportFormatField()])
            ->action(function (Collection $records, array $data) {
                $format = $data['format'];

                return Excel::download(
                    new UsersExport($records),
                    "users-terpilih.{$format}",
                    $format === 'csv' ? ExcelType::CSV : ExcelType::XLSX,
                );
            })
            ->deselectRecordsAfterCompletion();
    }

    private static function exportFormatField(): Select
    {
        return Select::make('format')
            ->label('Format file')
            ->options([
                'xlsx' => 'Excel (.xlsx)',
                'csv' => 'CSV (.csv)',
            ])
            ->default('xlsx')
            ->required();
    }

    public static function importAction(): Action
    {
        return Action::make('importUsers')
            ->label('Import User')
            ->icon(Heroicon::OutlinedArrowUpTray)
            ->schema([
                FileUpload::make('file')
                    ->label('File user')
                    ->disk('local')
                    ->directory('user-imports')
                    ->acceptedFileTypes([
                        'text/csv',
                        'text/plain',
                        'application/vnd.ms-excel',
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    ])
                    ->rules(['required', 'file', 'mimes:csv,txt,xlsx', 'max:10240'])
                    ->maxSize(10240)
                    ->required()
                    ->helperText('Gunakan CSV atau XLSX dengan header: nama, email, password, role, nik, no_telp.'),
            ])
            ->action(function (array $data, UserImportService $service): void {
                $path = $data['file'];

                try {
                    $result = $service->import(Storage::disk('local')->path($path));
                } finally {
                    Storage::disk('local')->delete($path);
                }

                $body = "Berhasil: {$result->imported}. Gagal: {$result->failed()}.";

                if ($result->failed() > 0) {
                    $details = collect($result->errors)
                        ->map(fn (string $message, int $line): string => "Baris {$line}: {$message}")
                        ->implode("\n");
                    $body .= "\n\n{$details}";
                }

                $notification = Notification::make()
                    ->title($result->failed() === 0 ? 'Import berhasil' : 'Import selesai dengan kesalahan')
                    ->body($body);

                if ($result->failed() === 0) {
                    $notification->success();
                } elseif ($result->imported > 0) {
                    $notification->warning();
                } else {
                    $notification->danger();
                }

                $notification->send();
            });
    }

    public static function templateAction(): Action
    {
        return Action::make('downloadUserTemplate')
            ->label('Download Template')
            ->icon(Heroicon::OutlinedDocumentArrowDown)
            ->action(fn () => Excel::download(
                new UserTemplateExport,
                'template_user_sigap.xlsx',
                ExcelType::XLSX,
            ));
    }
}
