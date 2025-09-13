<?php

namespace App\Filament\Resources\Beasiswas\Schemas;

use Filament\Forms\Components;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

class BeasiswaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        Components\TextInput::make('nama_beasiswa')
                            ->required(),

                        Components\Select::make('jenis_beasiswa')
                            ->options([
                                'Prestasi' => 'Prestasi',
                                'Tidak mampu' => 'Tidak mampu',
                            ])
                            ->required(),

                        Components\TextInput::make('lembaga_penyelenggara')
                            ->required(),

                        Components\TextInput::make('besar_beasiswa')
                            ->required()
                            ->numeric(),

                        Components\TextInput::make('periode')
                            ->required(),

                        Components\Textarea::make('deskripsi')
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
