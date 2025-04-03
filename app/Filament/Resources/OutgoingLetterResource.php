<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OutgoingLetterResource\Pages;
use App\Filament\Resources\OutgoingLetterResource\RelationManagers;
use App\Models\External;
use App\Models\OutgoingLetter;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OutgoingLetterResource extends Resource
{
    protected static ?string $model = OutgoingLetter::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-arrow-up';


    protected static ?string $navigationLabel = 'Surat Keluar';

    protected static ?string $label = 'Surat Keluar';
    protected static ?string $pluralLabel = 'Surat Keluar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('letter_number')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->label('Nomor Surat Keluar'),
                        DatePicker::make('letter_date')
                            ->required()
                            ->label('Tanggal Surat')
                            ->default(now()),
                        TextInput::make('subject')
                            ->required()
                            ->label('Perihal'),
                        Select::make('sender_type')
                            ->label('Jenis Pengirim')
                            ->options([
                                'Internal' => 'Internal',
                                'External' => 'External',
                            ])
                            ->required()
                            ->reactive(),

                        Select::make('internal_sender_id')
                            ->label('Pengirim Internal')
                            ->options(User::pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->hidden(fn($get) => $get('sender_type') !== 'Internal'),

                        Select::make('external_sender_id')
                            ->label('Pengirim Eksternal')
                            ->options(External::pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->hidden(fn($get) => $get('sender_type') !== 'External'),

                        Select::make('recipient_type')
                            ->label('Jenis Penerima')
                            ->options([
                                'Internal' => 'Internal',
                                'External' => 'External',
                            ])
                            ->required()
                            ->reactive(),

                        Select::make('internal_recipient_id')
                            ->label('Penerima Internal')
                            ->options(User::pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->hidden(fn($get) => $get('recipient_type') !== 'Internal'),

                        Select::make('external_recipient_id')
                            ->label('Penerima Eksternal')
                            ->required()
                            ->options(External::pluck('name', 'id'))
                            ->searchable()
                            ->hidden(fn($get) => $get('recipient_type') !== 'External'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(
                fn($query) =>
                auth()->user()->isSekretariat()
                    ? $query
                    : $query->where('internal_sender_id', auth()->id())
            )
            ->columns([
                TextColumn::make('letter_number')
                    ->label('Nomor Surat')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('letter_date')
                    ->label('Tanggal Surat')
                    ->dateTime('d M Y')
                    ->sortable(),

                TextColumn::make('sender_type')
                    ->label('Pengirim')
                    ->formatStateUsing(fn($record) => $record->sender_type === 'Internal'
                        ? $record->internalSender->name
                        : $record->externalSender->name),
                TextColumn::make('subject')
                    ->label('Perihal'),
            ])
            ->defaultSort('letter_date', 'desc')
            ->filters([])
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
            'index' => Pages\ListOutgoingLetters::route('/'),
            'create' => Pages\CreateOutgoingLetter::route('/create'),
            'edit' => Pages\EditOutgoingLetter::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return auth()->user()->isSekretariat();
    }

    public static function getNavigationSort(): ?int
    {
        return 3; // Posisi ketiga setelah Surat Masuk
    }
}
