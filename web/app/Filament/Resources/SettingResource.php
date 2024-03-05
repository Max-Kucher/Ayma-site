<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Filament\Resources\SettingResource\RelationManagers;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('settings.general'))
                    ->schema([
                        Forms\Components\TextInput::make('key')
                            ->label(__('settings.setting.key'))
                            ->required()
                            ->maxLength(32),
                        Forms\Components\TextInput::make('value')
                            ->label(__('settings.setting.key'))
                            ->required()
                            ->maxLength(128),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->label(__('settings.setting.key')),
                Tables\Columns\TextColumn::make('value')
                    ->label(__('settings.setting.value')),
            ])
            ->filters([
                Tables\Filters\Filter::make('key')
                    ->form([
                        Forms\Components\TextInput::make('key')
                            ->label(__('settings.setting.key'))
                            ->placeholder(__('settings.setting.key.filter.placeholder')),
                    ])
                    ->query(function ($query, $data) {
                        if (!empty($data['key'])) {
                            return $query->where('key', 'like', '%' . $data['key'] . '%');
                        }

                        return null;
                    }),
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
            'index' => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSetting::route('/create'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}
