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
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
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
                            ->readOnly()
                            ->default(fn() => str_pad(IncomingLetter::max('id') + 1, 5, '0', STR_PAD_LEFT))
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
                        Select::make('recipients')
                            ->multiple()
                            ->label('Ditujukan Kepada')
                            ->relationship('recipients', 'name')
                            ->searchable()
                            ->required()
                            ->preload(),
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
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'Menunggu Persetujuan' => 'Menunggu Persetujuan',
                                'Tidak Disetujui' => 'Tidak Disetujui',
                                'Selesai dan Terdistribusi' => 'Selesai dan Terdistribusi',
                            ])
                            ->default('Menunggu Persetujuan'),
                        Select::make('classification_letter')
                            ->label('Klasifikasi Surat')
                            ->options([
                                'Akademik' => 'Akademik',
                                'Keuangan' => 'Keuangan',
                                'Kemahasiswaan' => 'Kemahasiswaan',
                                'Umum' => 'Umum',
                            ])
                            ->required(),
                        Select::make('category_letter')
                            ->label('Sifat Surat')
                            ->options([
                                'Rahasia' => 'Rahasia',
                                'Segera' => 'Segera',
                                'Penting' => 'Penting',
                                'Biasa' => 'Biasa',
                            ])
                            ->required(),
                        FileUpload::make('attachment')
                            ->directory('surat_masuk')
                            ->getUploadedFileNameForStorageUsing(fn($file) => now()->timestamp . '-' . $file->getClientOriginalName())
                            ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                            ->maxSize(5120)
                            ->label('File Arsip')
                            ->helperText('Tipe file pdf dan docx dengan ukuran maksimal 5 MB.'),
                        Textarea::make('resume')
                            ->label('Resume Disposisi')
                            ->autosize()
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
                    : $query->whereHas('recipients', fn($q) => $q->where('users.id', auth()->id()))

            )
            ->columns([
                TextColumn::make('agenda_number')
                    ->label('No. Agenda')
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                TextColumn::make('letter_number')
                    ->label('No. Surat')
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
                    ->label('File Arsip Surat')
                    ->formatStateUsing(fn($state) => $state ? basename($state) : '-')
                    ->url(fn($record) => $record->attachment ? asset('storage/' . $record->attachment) : null, true)
                    ->openUrlInNewTab(fn($record) => (bool) $record->attachment)
                    ->placeholder('Belum Diupload')
                    ->wrap(),
                TextColumn::make('lembar_disposisi')
                    ->label('Lembar Disposisi')
                    ->getStateUsing(fn($record) => "Lembar Disposisi - {$record->agenda_number}")
                    ->url(fn($record) => asset("storage/lembar_disposisi_{$record->agenda_number}.xlsx"), true)
                    ->openUrlInNewTab(fn($record) => file_exists(storage_path("app/public/lembar_disposisi_{$record->agenda_number}.xlsx")))
                    ->placeholder('Belum Digenerate')
                    ->wrap(),
                TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'warning' => 'Menunggu Persetujuan',
                        'danger' => 'Tidak Disetujui',
                        'success' => 'Selesai dan Terdistribusi',
                    ])
            ])
            ->defaultSort('agenda_number', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'Menunggu Persetujuan' => 'Menunggu Persetujuan',
                        'Tidak Disetujui' => 'Tidak Disetujui',
                        'Selesai dan Terdistribusi' => 'Selesai dan Terdistribusi',
                    ]),
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
                ? route('filament.admin.resources.incoming-letters.edit', $record)
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
