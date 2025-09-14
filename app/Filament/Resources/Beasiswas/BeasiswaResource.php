<?php

namespace App\Filament\Resources\Beasiswas;

use App\Filament\Resources\Beasiswas\Pages\CreateBeasiswa;
use App\Filament\Resources\Beasiswas\Pages\EditBeasiswa;
use App\Filament\Resources\Beasiswas\Pages\ListBeasiswas;
use App\Filament\Resources\Beasiswas\Pages\ViewBeasiswa;
use App\Filament\Resources\Beasiswas\Schemas\BeasiswaForm;
use App\Filament\Resources\Beasiswas\Schemas\BeasiswaInfolist;
use App\Filament\Resources\Beasiswas\Tables\BeasiswasTable;
use App\Models\Beasiswa;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BeasiswaResource extends Resource
{
    protected static ?string $model = Beasiswa::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'nama_beasiswa';

    public static function form(Schema $schema): Schema
    {
        return BeasiswaForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return BeasiswaInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BeasiswasTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBeasiswas::route('/'),
            'create' => CreateBeasiswa::route('/create'),
            'view' => ViewBeasiswa::route('/{record}'),
            'edit' => EditBeasiswa::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();

        // Jika user adalah admin atau staf, tampilkan semua beasiswa.
        if ($user->hasAnyRole(['admin', 'staf'])) {
            return parent::getEloquentQuery();
        }

        // Jika user adalah mahasiswa...
        if ($user->hasRole('mahasiswa')) {
            // ...hanya tampilkan beasiswa yang memiliki relasi dengan profil mahasiswanya.
            return parent::getEloquentQuery()->whereHas('mahasiswas', function (Builder $query) use ($user) {
                $query->where('user_id', $user->id);
            });
        }

        // Jika tidak memiliki role di atas, jangan tampilkan apa-apa.
        return parent::getEloquentQuery()->whereRaw('1 = 0');
    }
}
