<?php

namespace App\Filament\Resources\Mahasiswas\Tables;

use App\Filament\Exports\MahasiswaExporter;
use App\Models\Mahasiswa;
use Filament\Actions;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class MahasiswasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.nim')
                    ->label('NIM')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('nama')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('email')
                    ->searchable(),

                TextColumn::make('no_hp')
                    ->searchable(),

                TextColumn::make('prodi')
                    ->searchable(),

                TextColumn::make('fakultas')
                    ->searchable(),

                TextColumn::make('angkatan')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('ip')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('ipk')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
                SelectFilter::make('angkatan')->options(
                    Mahasiswa::query()->distinct()->pluck('angkatan', 'angkatan')->toArray()
                )->label('Angkatan'),
                SelectFilter::make('fakultas')->options(
                    Mahasiswa::query()->distinct()->pluck('fakultas', 'fakultas')->toArray()
                )->label('Fakultas'),
                SelectFilter::make('prodi')->options(
                    Mahasiswa::query()->distinct()->pluck('prodi', 'prodi')->toArray()
                )->label('Prodi'),
            ])
            ->recordActions([
                Actions\ViewAction::make(),
                Actions\EditAction::make(),
            ])
            ->headerActions([
                Actions\ExportAction::make()
                    ->exporter(MahasiswaExporter::class),
            ])
            ->toolbarActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                    Actions\ForceDeleteBulkAction::make(),
                    Actions\RestoreBulkAction::make(),
                ]),
                Actions\ExportBulkAction::make()
                    ->exporter(MahasiswaExporter::class),
            ]);
    }
}
