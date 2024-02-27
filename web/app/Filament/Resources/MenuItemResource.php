<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MenuItemResource\Pages;
use App\Filament\Resources\MenuItemResource\RelationManagers\MenuItemsRelationManager;
use App\Models\Language;
use App\Models\MenuItem;
use App\Models\MenuItemDescription;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MenuItemResource extends Resource
{
    protected static ?string $model = MenuItem::class;

    public static function form(Form $form): Form
    {
        $menuItems = MenuItem::whereNull('parent_id')
            ->with(['description' => function ($query) {
                $query->select('menu_item_id', 'name');
            }])
            ->get()
            ->mapWithKeys(function ($item) {
                // Предполагая, что релейшен description может быть null или возвращать одну запись.
                $name = optional($item->description)->name ?? 'Undefined';
                return [$item->id => $name];
            });

        return $form
            ->schema([
                Forms\Components\Section::make(__('settings.general'))
                    ->schema([
                        Forms\Components\TextInput::make('link')
                            ->label(__('settings.menu.link'))
                            ->placeholder('/some-url#key')
                            ->required(),
                        Forms\Components\TextInput::make('priority')
                            ->label(__('settings.priority'))
                            ->numeric()
                            ->maxValue(100)
                            ->default(0),
                        Select::make('parent_id')
                            ->label(__('settings.menu.parent_id'))
                            ->options($menuItems->all())
                            ->searchable()
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('description.name')
                    ->label(__('settings.name')),
                Tables\Columns\TextColumn::make('link')
                    ->label(__('settings.menu.link')),
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
            MenuItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMenuItems::route('/'),
            'create' => Pages\CreateMenuItem::route('/create'),
            'edit' => Pages\EditMenuItem::route('/{record}/edit'),
        ];
    }
}
