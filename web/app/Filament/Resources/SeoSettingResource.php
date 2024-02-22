<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SeoSettingResource\Pages;
use App\Filament\Resources\SeoSettingResource\RelationManagers;
use App\Models\SeoSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Language;

class SeoSettingResource extends Resource
{
    protected static ?string $model = SeoSetting::class;

    public static function form(Form $form): Form
    {
        $tabs = [];

        foreach (Language::all() as $language) {
            $tabs[] = Forms\Components\Tabs\Tab::make($language->name)
                ->schema([
                    Forms\Components\TextInput::make('titles.' . $language->lang_code)
                        ->label("Title ($language->lang_code")
                        ->required(),
                    Forms\Components\Textarea::make('meta_descriptions.' . $language->lang_code)
                        ->label("Meta Description ($language->lang_code)")
                        ->nullable(),
                    Forms\Components\Textarea::make('meta_keywords.' . $language->lang_code)
                        ->label("Meta Keywords ($language->lang_code)")
                        ->nullable(),
                ]);
        }

        return $form
            ->schema([
                Forms\Components\Section::make('General')
                    ->schema([
                        Forms\Components\TextInput::make('route')
                            ->label('Route')
                            ->required(),
                    ]),
                Forms\Components\Section::make('Descriptions')
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
            'index' => Pages\ListSeoSettings::route('/'),
            'create' => Pages\CreateSeoSetting::route('/create'),
            'edit' => Pages\EditSeoSetting::route('/{record}/edit'),
        ];
    }
}
