<?php

namespace App\Filament\Resources\LetterNumberRequestResource\Pages;

use App\Filament\Resources\LetterNumberRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditLetterNumberRequest extends EditRecord
{
    protected static string $resource = LetterNumberRequestResource::class;

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

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (!auth()->user()->isSekretariat()) {
            unset($data['status']); // User biasa tidak bisa ubah status
        }
        return $data;
    }
}
