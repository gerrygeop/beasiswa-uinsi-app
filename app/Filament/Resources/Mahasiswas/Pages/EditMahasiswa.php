<?php

namespace App\Filament\Resources\Mahasiswas\Pages;

use App\Filament\Resources\Mahasiswas\MahasiswaResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EditMahasiswa extends EditRecord
{
    protected static string $resource = MahasiswaResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['nim'] = $this->record->user->nim;

        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        try {
            return DB::transaction(function () use ($record, $data) {
                $userData = [
                    'name' => $data['nama'],
                    'nim' => $data['nim'],
                ];

                if (!empty($data['password'])) {
                    $userData['password'] = $data['password'];
                }

                $record->user->update($userData);

                unset($data['nim'], $data['password']);

                $record->update($data);

                return $record;
            });
        } catch (\Exception $e) {
            throw $e;
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
