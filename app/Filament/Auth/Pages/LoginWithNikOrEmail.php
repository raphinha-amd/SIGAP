<?php

namespace App\Filament\Auth\Pages;

use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class LoginWithNikOrEmail extends BaseLogin
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('email')
                    ->label('NIK atau Email')
                    ->placeholder('Masukkan NIK atau email')
                    ->required()
                    ->autocomplete()
                    ->autofocus(),

                $this->getPasswordFormComponent(),

                $this->getRememberFormComponent(),
            ]);
    }

    protected function getCredentialsFromFormData(array $data): array
    {
        $identifier = trim($data['email']);

        $field = filter_var($identifier, FILTER_VALIDATE_EMAIL)
            ? 'email'
            : 'nik';

        return [
            $field => $identifier,
            'password' => $data['password'],
        ];
    }
}
