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

                        Components\Select::make('kategori_id')
                            ->relationship('kategori', 'nama_kategori')
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->required(),

                        Components\TextInput::make('lembaga_penyelenggara')
                            ->required(),

                        Components\TextInput::make('besar_beasiswa')
                            ->required()
                            ->numeric(),

                        Components\TextInput::make('periode')
                            ->required(),

                        Components\Select::make('status')
                            ->options([
                                'menunggu_verifikasi' => 'menunggu_verifikasi',
                                'lolos_verifikasi' => 'lolos_verifikasi',
                                'ditolak' => 'ditolak',
                                'diterima' => 'diterima',
                            ])
                            ->visible(fn() => auth()->user()->hasAnyRole(['admin', 'staf'])),

                        Components\Textarea::make('deskripsi')
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        TextEntry::make('nama_beasiswa'),
                        TextEntry::make('kategori.nama_kategori'),
                        TextEntry::make('lembaga_penyelenggara'),
                        TextEntry::make('besar_beasiswa')
                            ->numeric(),
                        TextEntry::make('periode'),

                        TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->getStateUsing(function ($record) {
                                $userId = auth()->id();

                                return $record->mahasiswas
                                    ->where('id', $userId)
                                    ->first()?->pivot?->status ?? '-';
                            }),

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

                TextColumn::make('mahasiswas')
                    ->badge()
                    ->getStateUsing(function ($record) {
                        $userId = auth()->id();

                        // ambil status dari pivot untuk user login
                        return $record->mahasiswas
                            ->where('id', $userId)
                            ->first()?->pivot?->status ?? '-';
                    })
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
                SelectFilter::make('kategori_id')
                    ->label('Kategori Beasiswa')
                    ->relationship('kategori', 'nama_kategori'),
            ])
            ->headerActions([
                Actions\CreateAction::make(),
                Actions\AttachAction::make()
                    ->preloadRecordSelect()
                    ->action(function (array $data, Actions\AttachAction $action) {
                        // Ambil record mahasiswa saat ini (owner)
                        $mahasiswa = $this->getOwnerRecord();

                        // Lakukan attach dengan menyertakan data pivot
                        $mahasiswa->beasiswas()->attach($data['recordId'], [
                            'tanggal_penerimaan' => now(),
                        ]);
                    }),
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

    public function isReadOnly(): bool
    {
        return false;
    }
}
