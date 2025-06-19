<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\TextInput::make('name')
                ->required(),


                TextInput::make('linke_tree_url')
    ->label('رابط Linktree')
    ->url()
    ->nullable(),

TextInput::make('social_media_url')
    ->label('رابط وسائل التواصل')
    ->url()
    ->nullable(),

            Forms\Components\DatePicker::make('start_date')
                ->label('تاريخ البدء'),

            Forms\Components\Toggle::make('enabled')
                ->label('مفعل؟')
                ->default(true),
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //


               Tables\Columns\TextColumn::make('name')->label('اسم المشروع'),
            Tables\Columns\TextColumn::make('start_date')->label('تاريخ البدء')->date(),
            Tables\Columns\IconColumn::make('enabled')->boolean()->label('مفعل؟'),
            Tables\Columns\TextColumn::make('created_at')->dateTime()->label('أنشئ في'),


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
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }


    public static function shouldRegisterNavigation(): bool
{
    return auth()->check() && auth()->user()->type === 'admin';
}


public static function getNavigationSort(): ?int
{
    return 1; // رقم أقل = يظهر أولاً
}



public static function getNavigationIcon(): string
{
    return 'heroicon-o-folder'; // مثال
}




}
