<?php

namespace App\Filament\Resources\ContentPageResource\RelationManagers;

use App\Models\Language;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ContentPageDescriptionsRelationManager extends RelationManager
{
    protected static string $relationship = 'descriptions';

    public function form(Form $form): Form
    {
        $languages = Language::select('id', 'name')->get();

        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label(__('settings.content_pages.title'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\RichEditor::make('content')
                    ->label(__('settings.content_pages.content'))
                    ->required(),
                Forms\Components\Select::make('language_id')
                    ->label(__('settings.languages.name'))
                    ->required()
                    ->options($languages->pluck('name', 'id')->all())
                    ->searchable(),
            ])->columns(1);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('question')
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label(__('settings.content_pages.title')),
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
