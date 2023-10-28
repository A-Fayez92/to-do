<?php

namespace App\Filament\Resources;

use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\MailProvider;
use Filament\Resources\Resource;
use Filament\Forms\Components\Checkbox;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use App\Filament\Resources\MailProviderResource\Pages;

class MailProviderResource extends Resource
{
    protected static ?string $model = MailProvider::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->translateLabel()->required(),
                TextInput::make('host')->translateLabel()->required(),
                TextInput::make('port')->translateLabel()->required(),
                TextInput::make('username')->translateLabel()->required(),
                TextInput::make('password')->translateLabel()->required(),
                TextInput::make('encryption')->translateLabel(),
                TextInput::make('timeout')->translateLabel(),
                TextInput::make('local_domain')->translateLabel()->required(),
                Checkbox::make('active')->translateLabel(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->translateLabel(),
                TextColumn::make('host')->translateLabel(),
                TextColumn::make('port')->translateLabel(),
                TextColumn::make('username')->translateLabel(),
                TextColumn::make('password')->translateLabel(),
                TextColumn::make('encryption')->translateLabel(),
                TextColumn::make('timeout')->translateLabel(),
                TextColumn::make('local_domain')->translateLabel(),
                IconColumn::make('active')->boolean()->translateLabel(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListMailProviders::route('/'),
            // 'create' => Pages\CreateMailProvider::route('/create'),
            // 'edit' => Pages\EditMailProvider::route('/{record}/edit'),
        ];
    }
    
    public static function getSingularLabel(): string
    {
        return __('Mail Provider');
    }

    public static function getPluralLabel(): string
    {
        return __('Mail Providers');
    }

    public static function getModelLabel(): string
    {
        return __('Mail Provider');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Mail Providers');
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
