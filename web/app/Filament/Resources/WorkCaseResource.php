<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WorkCaseResource\RelationManagers\WorkCaseRelationManager;
use App\Filament\Resources\WorkCaseResource\Pages;
use App\Models\Partner;
use App\Models\WorkCase;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use OpenApi\Attributes\OpenApi as OA;

class WorkCaseResource extends Resource
{
    protected static ?string $model = WorkCase::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('settings.general'))
                    ->schema([
                        Forms\Components\FileUpload::make('file_path')
                            ->disk('local')
                            ->directory('public/work-cases/files')
                            ->required()
                            ->label(__('file')),
                        Forms\Components\TextInput::make('link')
                            ->label(__('settings.menu.link'))
                            ->placeholder('/some-url#key'),
                    ])
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
            WorkCaseRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWorkCase::route('/'),
            'create' => Pages\CreateWorkCase::route('/create'),
            'edit' => Pages\EditWorkCase::route('/{record}/edit'),
        ];
    }
}
