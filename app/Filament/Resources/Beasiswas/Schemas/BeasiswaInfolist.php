<?php

namespace App\Filament\Resources\Beasiswas\Schemas;

use App\Models\Beasiswa;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

class BeasiswaInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        TextEntry::make('nama_beasiswa'),
                        TextEntry::make('kategori.nama_kategori'),
                        TextEntry::make('lembaga_penyelenggara'),
                        TextEntry::make('besar_beasiswa')
                            ->numeric()
                            ->money('idr'),
                        TextEntry::make('periode'),
                        TextEntry::make('deskripsi')
                            ->placeholder('-')
                            ->columnSpanFull(),
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
                            ->visible(fn(Beasiswa $record): bool => $record->trashed()),
                    ])
                    ->columnSpan(1),
            ])
            ->columns(3);
    }
}
