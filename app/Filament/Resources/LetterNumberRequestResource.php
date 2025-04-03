<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LetterNumberRequestResource\Pages;
use App\Filament\Resources\LetterNumberRequestResource\RelationManagers;
use App\Models\LetterNumberRequest;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class LetterNumberRequestResource extends Resource
{
    protected static ?string $model = LetterNumberRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-plus';

    protected static ?string $navigationLabel = 'Pengajuan Nomor Surat';

    protected static ?string $label = 'Pengajuan Nomor Surat';
    protected static ?string $pluralLabel = 'Pengajuan Nomor Surat';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'Pending')->count();
    }

    protected static ?string $navigationBadgeTooltip = 'Pengajuan Nomor Surat yang Pending';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Hidden::make('user_id')
                            ->default(Auth::id()),
                        FileUpload::make('attachment')
                            ->label('File Draft Surat')
                            ->directory('draft')
                            ->required()
                            ->getUploadedFileNameForStorageUsing(fn($file) => now()->timestamp . '-' . $file->getClientOriginalName())
                            ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                            ->maxSize(5120)
                            ->columnSpanFull()
                            ->helperText('Tipe file pdf dan docx dengan ukuran maksimal 5 MB.'),
                        Select::make('status')
                            ->options([
                                'Pending' => 'Pending',
                                'Disetujui' => 'Disetujui',
                                'Ditolak' => 'Ditolak',
                            ])
                            ->columnSpanFull()
                            ->default('Pending')
                            ->visible(fn() => auth()->user()->isSekretariat()),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(
                fn($query) =>
                auth()->user()->isSekretariat() ? $query : $query->where('user_id', auth()->id())
            )
            ->columns([
                TextColumn::make('user.name')
                    ->label('Pemohon'),
                TextColumn::make('created_at')
                    ->label('Tanggal Pengajuan')
                    ->dateTime('d M Y, H:i'),
                TextColumn::make('attachment')
                    ->label('File Draft Surat')
                    ->formatStateUsing(fn($state) => basename($state))
                    ->url(fn($record) => asset('storage/' . $record->attachment), true)
                    ->openUrlInNewTab(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Pending' => 'warning',
                        'Disetujui' => 'success',
                        'Ditolak' => 'danger'
                    })
                    ->label('Status Pengajuan'),
                TextColumn::make('remarks')
                    ->wrap()
                    ->label('No. Surat')
                    ->placeholder('Belum diberikan'),
            ])
            ->defaultSort('status', 'Pending')
            ->filters([
                //
            ])
            ->actions([
                Action::make('approve')
                    ->label('Setujui')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn(Model $record) => auth()->user()->isSekretariat() && $record->status === 'Pending')
                    ->requiresConfirmation()
                    ->form([
                        Textarea::make('remarks')
                            ->label('No. Surat')
                            ->required(),
                    ])
                    ->action(function (Model $record, array $data) {
                        $record->update([
                            'status' => 'Disetujui',
                            'remarks' => $data['remarks'],
                        ]);

                        Notification::make()
                            ->title('No. Surat Diberikan')
                            ->success()
                            ->body('Pengajuan nomor surat telah selesai.')
                            ->send();
                    }),

                Action::make('reject')
                    ->label('Tolak')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn(Model $record) => auth()->user()->isSekretariat() && $record->status === 'Pending')
                    ->requiresConfirmation()
                    ->form([
                        Textarea::make('remarks')
                            ->label('Alasan Penolakan')
                            ->required(),
                    ])
                    ->action(function (Model $record, array $data) {
                        $record->update([
                            'status' => 'Ditolak',
                            'remarks' => $data['remarks'],
                        ]);

                        Notification::make()
                            ->title('Pengajuan Ditolak')
                            ->danger()
                            ->body('Pengajuan nomor surat #' . $record->id . ' telah ditolak.')
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->visible(fn() => auth()->user()->isSekretariat()),
                ]),
            ])
            ->recordUrl(fn($record) => auth()->user()->isSekretariat()
                ? route('filament.admin.resources.letter-number-requests.edit', $record)
                : null);
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
            'index' => Pages\ListLetterNumberRequests::route('/'),
            'create' => Pages\CreateLetterNumberRequest::route('/create'),
            'edit' => Pages\EditLetterNumberRequest::route('/{record}/edit'),
        ];
    }

    public static function getNavigationSort(): ?int
    {
        return 4; // Posisi keempat setelah Surat Keluar
    }
}
