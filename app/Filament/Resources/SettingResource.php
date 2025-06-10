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
use Filament\Tables\Columns\TextColumn;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //

                 Forms\Components\TextInput::make('name')->required(),
            Forms\Components\TextInput::make('profile_id')->required(),
            Forms\Components\TextInput::make('token')->required(),
            Forms\Components\TextInput::make('admin_group_id')
    ->label('Admin Group ID')
    ->nullable(),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //

                  Tables\Columns\TextColumn::make('name'),
            Tables\Columns\TextColumn::make('profile_id'),
            Tables\Columns\TextColumn::make('token'),
              TextColumn::make('admin_group_id')->label('Admin Group ID'),

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
            'index' => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSetting::route('/create'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }


    public static function canCreate(): bool
{
    return \App\Models\Setting::count() === 0;
}

public static function canDelete($record): bool
{
    return false;
}



public static function shouldRegisterNavigation(): bool
{
    return auth()->check() && auth()->user()->type === 'admin';
}

public static function getNavigationSort(): ?int
{
    return 3; // رقم أقل = يظهر أولاً
}


public static function getNavigationIcon(): string
{
    return 'heroicon-o-cog-6-tooth'; // مثال
}

}
