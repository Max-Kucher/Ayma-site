<?php

namespace App\Filament\Resources\ServiceResource\RelationManagers;

use App\Models\Language;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ServicesRelationManager extends RelationManager
{
    protected static string $relationship = 'descriptions';

    public function form(Form $form): Form
    {
        $languages = Language::select('id', 'name')->get();

        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('settings.name'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('language_id')
                    ->label(__('settings.languages.name'))
                    ->required()
                    ->options($languages->pluck('name', 'id')->all())
                    ->searchable(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('settings.name')),
                Tables\Columns\TextColumn::make('language.name')
                    ->label(__('settings.languages.name'))
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
}
