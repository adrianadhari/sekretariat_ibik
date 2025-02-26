<?php

namespace App\Filament\Resources\LetterNumberRequestResource\Pages;

use App\Filament\Resources\LetterNumberRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLetterNumberRequests extends ListRecords
{
    protected static string $resource = LetterNumberRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
