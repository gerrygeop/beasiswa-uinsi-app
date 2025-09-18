<?php

namespace App\Filament\Resources\Beasiswas\RelationManagers;

use App\Models\Mahasiswa;
use Filament\Actions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MahasiswasRelationManager extends RelationManager
{
    protected static string $relationship = 'mahasiswas';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('nama')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('ttl')
                    ->required(),
                TextInput::make('no_hp')
                    ->required(),
                TextInput::make('prodi')
                    ->required(),
                TextInput::make('fakultas')
                    ->required(),
                TextInput::make('angkatan')
                    ->required(),
                TextInput::make('sks')
                    ->required()
                    ->numeric(),
                TextInput::make('semester')
                    ->required(),
                TextInput::make('ip')
                    ->required()
                    ->numeric(),
                TextInput::make('ipk')
                    ->required()
                    ->numeric(),

                Select::make('status')
                    ->options([
                        'menunggu_verifikasi' => 'menunggu_verifikasi',
                        'lolos_verifikasi' => 'lolos_verifikasi',
                        'ditolak' => 'ditolak',
                        'diterima' => 'diterima',
                    ])
                    ->visible(fn() => auth()->user()->hasAnyRole(['admin', 'staf'])),
            ]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        TextEntry::make('user.nim')
                            ->label('NIM'),

                        TextEntry::make('nama'),
                        TextEntry::make('email'),
                        TextEntry::make('ttl')
                            ->label('Tempat, Tanggal Lahir'),
                        TextEntry::make('no_hp'),
                        TextEntry::make('prodi'),
                        TextEntry::make('fakultas'),
                        TextEntry::make('angkatan'),
                        TextEntry::make('sks')
                            ->numeric(),
                        TextEntry::make('semester'),
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

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nama')
            ->columns([
                TextColumn::make('user.nim')
                    ->label('NIM')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('nama')
                    ->searchable(),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('ttl')
                    ->label('Tempat, Tanggal Lahir')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('no_hp')
                    ->searchable(),
                TextColumn::make('prodi')
                    ->searchable(),
                TextColumn::make('fakultas')
                    ->searchable(),
                TextColumn::make('angkatan')
                    ->searchable(),
                TextColumn::make('sks')
                    ->label('SKS')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('pivot.status')
                    ->badge()
                    ->label('Status'),

                TextColumn::make('semester')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('ip')
                    ->label('IP')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('ipk')
                    ->label('IPK')
                    ->numeric()
                    ->sortable()
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
            ->headerActions([
                Actions\CreateAction::make(),
                Actions\AttachAction::make()
                    ->preloadRecordSelect(),
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
