<?php

namespace App\Filament\Resources\IncomingLetterResource\Pages;

use App\Filament\Resources\IncomingLetterResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditIncomingLetter extends EditRecord
{
    protected static string $resource = IncomingLetterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function authorizeAccess(): void
    {
        if (!Auth::user()->isSekretariat()) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }
    }
}
