<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MenuItemResource\RelationManagers\PartnersRelationManager;
use App\Filament\Resources\PartnerResource\Pages;
use App\Models\Partner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PartnerResource extends Resource
{
    protected static ?string $model = Partner::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('settings.general'))
                    ->schema([
                        Forms\Components\FileUpload::make('file_path')
                            ->disk('local')
                            ->directory('partners/files')
                            ->required()
                            ->label(__('file')),
                        Forms\Components\Select::make('location')
                            ->label('Location')
                            ->options([
                                'top' => 'Top',
                                'bottom' => 'Bottom',
                            ])
                            ->required()
                            ->default('top'),
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
            PartnersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPartners::route('/'),
            'create' => Pages\CreatePartner::route('/create'),
            'edit' => Pages\EditPartner::route('/{record}/edit'),
        ];
    }
}
