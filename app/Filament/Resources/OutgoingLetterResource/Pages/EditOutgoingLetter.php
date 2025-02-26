<?php

namespace App\Filament\Resources\OutgoingLetterResource\Pages;

use App\Filament\Resources\OutgoingLetterResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditOutgoingLetter extends EditRecord
{
    protected static string $resource = OutgoingLetterResource::class;

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
