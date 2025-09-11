<?php

namespace App\Filament\Resources\Mahasiswas\Schemas;

use App\Models\User;
use Filament\Forms\Components;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

class MahasiswaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        Components\Select::make('user_id')
                            ->options(User::query()->pluck('nim', 'id')->except(auth()->id()))
                            ->label('NIM')
                            ->searchable()
                            ->required(),

                        Components\TextInput::make('nama')
                            ->required(),

                        Components\TextInput::make('email')
                            ->label('Email address')
                            ->email()
                            ->required(),

                        Components\TextInput::make('no_hp')
                            ->required(),

                        Components\TextInput::make('prodi')
                            ->required(),

                        Components\TextInput::make('fakultas')
                            ->required(),

                        Components\TextInput::make('angkatan')
                            ->required(),

                        Components\TextInput::make('ip')
                            ->required(),

                        Components\TextInput::make('ipk')
                            ->required(),
                    ])
                    ->columns(2)
                    ->columnSpanFull()
            ]);
    }
}
