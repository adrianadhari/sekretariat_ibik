<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExternalResource\Pages;
use App\Filament\Resources\ExternalResource\RelationManagers;
use App\Models\External;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ExternalResource extends Resource
{
    protected static ?string $model = External::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?string $navigationLabel = 'Kelola Pihak Eksternal';

    protected static ?string $label = 'Kelola Pihak Eksternal';
    protected static ?string $pluralLabel = 'Kelola Pihak Eksternal';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->label('Nama'),
                        TextInput::make('institution')
                            ->label('Institusi'),
                        TextInput::make('contact_info')
                            ->label('Kontak')
                            ->helperText('Bisa berupa nomor telepon atau email'),
                        Textarea::make('address')
                            ->autosize()
                            ->label('Alamat')
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable(),
                TextColumn::make('institution')
                    ->label('Institusi')
                    ->searchable(),
                TextColumn::make('contact_info')
                    ->label('Kontak')
                    ->searchable(),
                TextColumn::make('address')
                    ->label('Alamat')
                    ->wrap()
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageExternals::route('/'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()->isSekretariat();
    }

    public static function getNavigationSort(): ?int
    {
        return 5; // Posisi kelima setelah Pengajuan Nomor Surat
    }
}
