<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Filament\Resources\TodoResource;
use App\Models\Todo;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\RelationManagers\Concerns\Translatable;
use Filament\Tables\Columns\IconColumn;

class TodosRelationManager extends RelationManager
{
    use Translatable;
    protected static string $relationship = 'todos';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')->translateLabel()
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('title')->translateLabel(),
                IconColumn::make('__')->boolean()->label(__('Completed'))->getStateUsing(fn ($record) => $record->completed_at ? true : false),
                TextColumn::make('completed_at')->date()->translateLabel(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\LocaleSwitcher::make(),
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make(__('Showing'))
                    ->color('gray')
                    ->icon('heroicon-o-eye')
                    ->url(fn (Todo $record): string => TodoResource::getUrl('view', ['record' => $record]))
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->recordUrl(
                fn (Todo $record): string => TodoResource::getUrl('view', ['record' => $record])
            );
            ;
    }


    protected function getTableHeading(): string
    {
        return __('Todo Lists');
    }
}
