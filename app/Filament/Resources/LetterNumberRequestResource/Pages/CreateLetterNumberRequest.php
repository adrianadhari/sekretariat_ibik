<?php

namespace App\Filament\Resources\LetterNumberRequestResource\Pages;

use App\Filament\Resources\LetterNumberRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLetterNumberRequest extends CreateRecord
{
    protected static string $resource = LetterNumberRequestResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        return $data;
    }
}
