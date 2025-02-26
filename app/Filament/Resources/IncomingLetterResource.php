<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IncomingLetterResource\Pages;
use App\Filament\Resources\IncomingLetterResource\RelationManagers;
use App\Models\External;
use App\Models\IncomingLetter;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class IncomingLetterResource extends Resource
{
    protected static ?string $model = IncomingLetter::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-arrow-down';

    protected static ?string $navigationLabel = 'Surat Masuk';

    protected static ?string $label = 'Surat Masuk';
    protected static ?string $pluralLabel = 'Surat Masuk';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('agenda_number')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->label('Nomor Agenda'),
                        TextInput::make('letter_number')
                            ->required()
                            ->label('Nomor Surat'),
                        DatePicker::make('letter_date')
                            ->required()
                            ->label('Tanggal Surat'),
                        Select::make('sender_type')
                            ->label('Jenis Pengirim')
                            ->options([
                                'Internal' => 'Internal',
                                'External' => 'External',
                            ])
                            ->reactive(),
                        Select::make('internal_sender_id')
                            ->label('Asal Surat')
                            ->options(User::pluck('name', 'id'))
                            ->searchable()
                            ->hidden(fn($get) => $get('sender_type') !== 'Internal'),

                        Select::make('external_sender_id')
                            ->label('Asal Surat')
                            ->options(External::pluck('name', 'id'))
                            ->searchable()
                            ->hidden(fn($get) => $get('sender_type') !== 'External'),
                        Select::make('recipient_id')
                            ->label('Ditujukan Kepada')
                            ->options(User::pluck('name', 'id'))
                            ->searchable()
                            ->required(),
                        TextInput::make('subject')
                            ->required()
                            ->label('Perihal'),
                        Group::make([
                            DatePicker::make('received_date')
                                ->required()
                                ->label('Tanggal Terima'),
                            TimePicker::make('received_time')
                                ->required()
                                ->label('Jam Terima'),
                            TextInput::make('recipient')
                                ->required()
                                ->label('Penerima'),
                        ])->columns(3),
                        FileUpload::make('attachment')
                            ->directory('surat_masuk')
                            ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                            ->maxSize(5120)
                            ->label('File Arsip')
                            ->helperText('Tipe file pdf dan docx dengan ukuran maksimal 5 MB.'),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(
                fn($query) =>
                auth()->user()->isSekretariat()
                    ? $query
                    : $query->where('recipient_id', auth()->id())
            )
            ->columns([
                TextColumn::make('agenda_number')
                    ->label('Nomor Agenda')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('letter_number')
                    ->label('Nomor Surat')
                    ->searchable(),
                TextColumn::make('letter_date')
                    ->label('Tanggal Surat')
                    ->dateTime('d M Y')
                    ->sortable(),
                TextColumn::make('sender_name')
                    ->label('Asal Surat')
                    ->wrap(),
                TextColumn::make('subject')
                    ->label('Perihal')
                    ->searchable()
                    ->wrap(),
                TextColumn::make('attachment')
                    ->label('File Surat')
                    ->url(fn($record) => asset('storage/' . $record->attachment), true)
                    ->openUrlInNewTab()
            ])
            ->defaultSort('agenda_number', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->visible(fn() => auth()->user()->isSekretariat()),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->visible(fn() => auth()->user()->isSekretariat()),
                ]),
            ])
            ->recordUrl(fn($record) => auth()->user()->isSekretariat()
                ? route('filament.admin.resources.outgoing-letters.edit', $record)
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
            'index' => Pages\ListIncomingLetters::route('/'),
            'create' => Pages\CreateIncomingLetter::route('/create'),
            'edit' => Pages\EditIncomingLetter::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return auth()->user()->isSekretariat();
    }

    public static function getNavigationSort(): ?int
    {
        return 2; // Posisi kedua setelah Dashboard
    }
}
