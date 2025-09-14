<?php

namespace App\Filament\Resources\Mahasiswas\RelationManagers;

use App\Models\Beasiswa;
use Filament\Actions;
use Filament\Forms\Components;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BeasiswasRelationManager extends RelationManager
{
    protected static string $relationship = 'beasiswas';

    public function form(Schema $schema): Schema
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
            ]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        TextEntry::make('nama_beasiswa'),
                        TextEntry::make('jenis_beasiswa'),
                        TextEntry::make('lembaga_penyelenggara'),
                        TextEntry::make('besar_beasiswa')
                            ->numeric(),
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

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nama_beasiswa')
            ->columns([
                TextColumn::make('nama_beasiswa')
                    ->searchable(),

                TextColumn::make('jenis_beasiswa')
                    ->searchable(),

                TextColumn::make('lembaga_penyelenggara')
                    ->searchable(),

                TextColumn::make('besar_beasiswa')
                    ->numeric()
                    ->money('idr')
                    ->sortable(),

                TextColumn::make('periode')
                    ->searchable(),

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
                Actions\CreateAction::make(),
                Actions\AttachAction::make(),
            ])
            ->recordActions([
                Actions\ViewAction::make(),
                Actions\EditAction::make(),
                Actions\DetachAction::make(),
                Actions\DeleteAction::make(),
                Actions\ForceDeleteAction::make(),
                Actions\RestoreAction::make(),
            ])
            ->toolbarActions([
                Actions\BulkActionGroup::make([
                    Actions\DetachBulkAction::make(),
                    Actions\DeleteBulkAction::make(),
                    Actions\ForceDeleteBulkAction::make(),
                    Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(fn(Builder $query) => $query
                ->withoutGlobalScopes([
                    SoftDeletingScope::class,
                ]));
    }
}
