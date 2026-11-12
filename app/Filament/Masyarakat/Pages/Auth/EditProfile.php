<?php

namespace App\Filament\Masyarakat\Pages\Auth;

use Filament\Auth\Pages\EditProfile as BaseEditProfile;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class EditProfile extends BaseEditProfile
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Lengkap')
                    ->required()
                    ->maxLength(255),

                TextInput::make('nik')
                    ->label('NIK')
                    ->disabled()
                    ->dehydrated(false),

                $this->getEmailFormComponent(),

                $this->getPasswordFormComponent(),

                $this->getPasswordConfirmationFormComponent(),
            ]);
    }
}
