<?php

namespace App\Filament\Resources\IncomingLetterResource\Pages;

use App\Exports\IncomingLetterDispositionExport;
use App\Filament\Resources\IncomingLetterResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Maatwebsite\Excel\Facades\Excel;

class CreateIncomingLetter extends CreateRecord
{
    protected static string $resource = IncomingLetterResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterCreate(): void
    {
        $letter = $this->record; // Ambil surat yang baru dibuat

        // Generate file Excel
        $filePath = storage_path("app/public/lembar_disposisi_{$letter->agenda_number}.xlsx");
        Excel::store(new IncomingLetterDispositionExport($letter), "lembar_disposisi_{$letter->agenda_number}.xlsx", 'public');


        // Notifikasi Download
        Notification::make()
            ->title('Lembar Disposisi Telah Dibuat')
            ->body('Klik untuk mengunduh.')
            ->actions([
                \Filament\Notifications\Actions\Action::make('Download')
                    ->url(asset("storage/lembar_disposisi_{$letter->agenda_number}.xlsx"), true)
            ])
            ->send();
    }
}
