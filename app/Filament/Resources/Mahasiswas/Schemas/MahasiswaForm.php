<?php

namespace App\Filament\Resources\Mahasiswas\Schemas;

use App\Models\Mahasiswa;
use App\Models\User;
use Filament\Forms\Components;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Illuminate\Support\Facades\Hash;

class MahasiswaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Akun Mahasiswa')
                    ->schema([
                        Components\TextInput::make('nim')
                            ->label('NIM')
                            ->numeric()
                            ->unique(
                                table: User::class,
                                column: 'nim',
                                ignorable: fn(?Mahasiswa $record): ?User => $record?->user,
                            )
                            ->required(),

                        Components\TextInput::make('password')
                            ->password()
                            ->revealable()
                            ->dehydrateStateUsing(fn(string $state): string => Hash::make($state))
                            ->dehydrated(fn(?string $state): bool => filled($state))
                            ->required(fn(string $operation): bool => $operation === 'create')
                            ->minLength(8)
                            ->maxLength(255)
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Section::make('Data Diri Mahasiswa')
                    ->schema([
                        Components\TextInput::make('nama')
                            ->required()
                            ->maxLength(255),

                        Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255),

                        Components\TextInput::make('no_hp')
                            ->tel()
                            ->required()
                            ->regex('/^(\+62|62|0)8[0-9]{8,12}$/')
                            ->validationMessages([
                                'regex' => 'Format nomor HP tidak valid. Contoh: 081234567890',
                            ]),

                        Components\TextInput::make('prodi')
                            ->required(),

                        Components\TextInput::make('fakultas')
                            ->required(),

                        Components\TextInput::make('angkatan')
                            ->numeric()
                            ->required(),

                        Components\TextInput::make('ip')
                            ->label('IP')
                            ->numeric()
                            ->required()
                            ->minValue(0)
                            ->maxValue(4),

                        Components\TextInput::make('ipk')
                            ->label('IPK')
                            ->numeric()
                            ->required()
                            ->minValue(0)
                            ->maxValue(4),
                    ])
                    ->columns(2)
                    ->columnSpanFull()
            ]);
    }
}
