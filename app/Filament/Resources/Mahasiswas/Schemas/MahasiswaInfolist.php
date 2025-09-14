<?php

namespace App\Filament\Resources\Mahasiswas\Schemas;

use App\Models\Mahasiswa;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MahasiswaInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        TextEntry::make('user.nim')
                            ->label('NIM'),

                        TextEntry::make('nama'),
                        TextEntry::make('email'),
                        TextEntry::make('no_hp'),
                        TextEntry::make('prodi'),
                        TextEntry::make('fakultas'),
                        TextEntry::make('angkatan'),
                        TextEntry::make('ip')
                            ->label('IP')
                            ->badge()
                            ->color('info'),
                        TextEntry::make('ipk')
                            ->label('IPK')
                            ->badge(),
                    ])
                    ->columns(2)
                    ->columnSpan(2),

                Section::make()
                    ->schema([
                        TextEntry::make('created_at')
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('updated_at')
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('deleted_at')
                            ->dateTime()
                            ->visible(fn(Mahasiswa $record): bool => $record->trashed()),
                    ])
                    ->columnSpan(1),
            ])
            ->columns(3);
    }
}
