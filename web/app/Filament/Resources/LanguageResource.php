<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LanguageResource\Pages;
use App\Filament\Resources\LanguageResource\RelationManagers;
use App\Models\Language;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;

class LanguageResource extends Resource
{
    protected static ?string $model = Language::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('General')->schema([
                    Forms\Components\TextInput::make('lang_code')
                        ->required()
                        ->maxLength(2),
                    Forms\Components\TextInput::make('locale')
                        ->required()
                        ->maxLength(5),
                    Forms\Components\Checkbox::make('is_default'),
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(64),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('lang_code'),
                Tables\Columns\TextColumn::make('locale'),
                Tables\Columns\BooleanColumn::make('is_default'),
                Tables\Columns\TextColumn::make('name'),
            ])
            ->filters([
                //
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLanguages::route('/'),
            'create' => Pages\CreateLanguage::route('/create'),
            'edit' => Pages\EditLanguage::route('/{record}/edit'),
        ];
    }
}
