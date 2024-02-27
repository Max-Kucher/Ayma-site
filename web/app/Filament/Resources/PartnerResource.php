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
use OpenApi\Attributes\OpenApi as OA;

/**
 * @OA\Schema(
 *     schema="Partner",
 *     type="object",
 *     title="Partner",
 *     description="The partner model representation.",
 *     @OA\Property(
 *         property="file_url",
 *         type="string",
 *         format="uri",
 *         description="The URL to the partner's file."
 *     ),
 *     @OA\Property(
 *         property="link",
 *         type="string",
 *         format="uri",
 *         description="The URL to the partner's website."
 *     ),
 *     @OA\Property(
 *         property="location",
 *         type="string",
 *         enum={"top", "bottom"},
 *         description="The location where the partner's information is displayed, either 'top' or 'bottom'."
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="The name of the partner."
 *     )
 * )
 */
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
                            ->directory('public/partners/files')
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
