<?php

namespace App\Filament\Resources;

use App\Models\Todo;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Concerns\Translatable;
use App\Filament\Resources\TodoResource\Pages;
use App\Filament\Resources\TodoResource\RelationManagers;
use Filament\Tables\Columns\IconColumn;

class TodoResource extends Resource
{
    use Translatable;
    protected static ?string $model = Todo::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')->translateLabel()->required(),
                Select::make('user_id')
                ->relationship('user', 'name')
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->translateLabel(),
                IconColumn::make('__')->boolean()->label(__('Completed'))->getStateUsing(fn ($record) => $record->completed_at ? true : false ),
                TextColumn::make('completed_at')->date()->translateLabel(),
                TextColumn::make('user.name')->translateLabel()
                ->url(fn (Todo $record): string => UserResource::getUrl('view', ['record' => $record->user]))
                
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
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
            RelationManagers\TasksRelationManager::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTodos::route('/'),
            'create' => Pages\CreateTodo::route('/create'),
            'edit' => Pages\EditTodo::route('/{record}/edit'),
            'view' => Pages\ViewUser::route('/{record}'),
        ];
    }
    
    public static function getSingularLabel(): string
    {
        return __('Todo');
    }

    public static function getPluralLabel(): string
    {
        return __('Todo Lists');
    }

    public static function getModelLabel(): string
    {
        return __('Todo List');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Todo Lists');
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    
}
