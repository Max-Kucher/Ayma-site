<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MenuItemResource\Pages;
use App\Models\Language;
use App\Models\MenuItem;
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
        $tabs = [];
        foreach (Language::all() as $language) {
            $tabs[] = Forms\Components\Tabs\Tab::make($language->name)
                ->schema([
                    Forms\Components\TextInput::make('names.' . $language->lang_code)
                        ->label(__('settings.name'))
                        ->required(),
                ]);
        }

        $menuItems = MenuItem::whereNull('parent_id')
            ->with(['description' => function ($query) {
                $query->select('menu_item_id', 'name');
            }])
            ->get(['id'])
            ->map(function ($menuItem) {
                return [
                    'id' => $menuItem->id,
                    'name' => $menuItem->description->name ?? 'Undefined',
                ];
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
                            ->default(0),
                        Select::make('parent_id')
                            ->label(__('settings.menu.parent_id'))
                            ->options($menuItems)
                            ->searchable()
                    ]),
                Forms\Components\Section::make(__('settings.sections.description'))
                    ->schema([
                        Forms\Components\Tabs::make('DescriptionsTabs')
                            ->tabs($tabs),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListMenuItems::route('/'),
            'create' => Pages\CreateMenuItem::route('/create'),
            'edit' => Pages\EditMenuItem::route('/{record}/edit'),
        ];
    }
}
