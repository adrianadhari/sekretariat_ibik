<?php

namespace App\Filament\Resources\ExternalResource\Pages;

use App\Filament\Resources\ExternalResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageExternals extends ManageRecords
{
    protected static string $resource = ExternalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
