<?php

namespace App\Filament\Resources\Mahasiswas\Schemas;

use App\Models\Mahasiswa;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class MahasiswaInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user_id')
                    ->numeric(),
                TextEntry::make('nama'),
                TextEntry::make('email')
                    ->label('Email address'),
                TextEntry::make('no_hp'),
                TextEntry::make('prodi'),
                TextEntry::make('fakultas'),
                TextEntry::make('angkatan'),
                TextEntry::make('ip'),
                TextEntry::make('ipk'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (Mahasiswa $record): bool => $record->trashed()),
            ]);
    }
}
