<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\EditProfile as BaseEditProfile;
use Filament\Forms\Components;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EditProfile extends BaseEditProfile
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Pengguna')
                    ->description('Perbarui informasi profil dan kata sandi akun Anda di sini.')
                    ->columns(1)
                    ->components([
                        Components\TextInput::make('name')
                            ->label('Nama')
                            ->required()
                            ->maxLength(255),

                        Components\TextInput::make('nim')
                            ->label('NIM / Username')
                            ->required()
                            ->maxLength(255),

                        Components\TextInput::make('password')
                            ->password()
                            ->revealable()
                            ->dehydrateStateUsing(fn(string $state): string => Hash::make($state))
                            ->dehydrated(fn(?string $state): bool => filled($state))
                            ->required(fn(string $operation): bool => $operation === 'create')
                            ->minLength(8)
                            ->maxLength(255),

                        Components\FileUpload::make('foto')
                            ->image()
                            ->avatar()
                            ->imageEditor()
                            ->circleCropper()
                            ->directory('foto-pengguna')
                            ->maxSize(5024)
                    ]),
            ]);
    }
}
