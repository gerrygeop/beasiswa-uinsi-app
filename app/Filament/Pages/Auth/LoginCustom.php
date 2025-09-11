<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\Login;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Component;
use Filament\Forms\Components\TextInput;
use Illuminate\Validation\ValidationException;

class LoginCustom extends Login
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getNIMFormComponent(),
                $this->getPasswordFormComponent(),
            ]);
    }

    protected function getNIMFormComponent(): Component
    {
        return TextInput::make('nim')
            ->label('NIM')
            ->required()
            ->autocomplete()
            ->autofocus()
            ->extraInputAttributes(['tabindex' => 1]);
    }

    protected function getCredentialsFromFormData(#[SensitiveParameter] array $data): array
    {
        return [
            'nim' => $data['nim'],
            'password' => $data['password'],
        ];
    }

    protected function throwFailureValidationException(): never
    {
        throw ValidationException::withMessages([
            'data.nim' => __('filament-panels::auth/pages/login.messages.failed'),
        ]);
    }
}
