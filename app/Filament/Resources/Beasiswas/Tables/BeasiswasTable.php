<?php

namespace App\Filament\Resources\Beasiswas\Tables;

use App\Filament\Exports\BeasiswaExporter;
use Filament\Actions;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class BeasiswasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_beasiswa')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('kategori.nama_kategori')
                    ->searchable(),

                TextColumn::make('lembaga_penyelenggara')
                    ->searchable(),

                TextColumn::make('besar_beasiswa')
                    ->numeric()
                    ->money('idr')
                    ->sortable(),

                TextColumn::make('periode')
                    ->searchable(),

                TextColumn::make('mahasiswas.0.pivot.status')
                    ->label('Status')
                    ->badge()
                    ->searchable()
                    ->visible(fn() => auth()->user()->hasRole('mahasiswa')),

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
                SelectFilter::make('jenis_beasiswa')
                    ->options([
                        'prestasi' => 'Prestasi',
                        'tidak mampu' => 'Tidak mampu',
                    ]),
            ])
            ->headerActions([
                Actions\ExportAction::make()
                    ->exporter(BeasiswaExporter::class),
            ])
            ->recordActions([
                Actions\ViewAction::make(),
                Actions\EditAction::make(),
            ])
            ->toolbarActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                    Actions\ForceDeleteBulkAction::make(),
                    Actions\RestoreBulkAction::make(),
                ]),
                Actions\ExportBulkAction::make()
                    ->exporter(BeasiswaExporter::class),
            ]);
    }
}
