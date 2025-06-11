<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Actions\DeleteAction;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([



                //


  Forms\Components\TextInput::make('name')->required(),
            Forms\Components\TextInput::make('email')->email()->required(),
            Forms\Components\TextInput::make('password')
                ->password()
                ->dehydrateStateUsing(fn ($state) => filled($state) ? bcrypt($state) : null)
                ->dehydrated(fn ($state) => filled($state)),

            Forms\Components\TextInput::make('phone')->label('رقم الهاتف')->tel()->nullable(),
            Forms\Components\TextInput::make('group_id')->label('معرف المجموعة')->nullable(),

            Forms\Components\Toggle::make('send_noti_in_privete')->label('إرسال إشعار خاص'),
            Forms\Components\Toggle::make('send_noti_in_group')->label('إرسال إشعار جماعي'),

            Forms\Components\Toggle::make('enabled')->label('مفعل؟'),

            Forms\Components\Select::make('type')
                ->label('النوع')
                ->options([
                    'admin' => 'مدير',
                    'employee' => 'موظف',
                ])
                ->required()
                 ->visible(fn () => auth()->user()?->type === 'admin'), // ✅ هذا هو الشرط










            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //


                 Tables\Columns\TextColumn::make('name'),
            Tables\Columns\TextColumn::make('email'),
            Tables\Columns\TextColumn::make('phone')->label('الهاتف'),
            Tables\Columns\TextColumn::make('group_id')->label('المجموعة'),
            Tables\Columns\IconColumn::make('send_noti_in_privete')->boolean()->label('إشعار خاص'),
            Tables\Columns\IconColumn::make('send_noti_in_group')->boolean()->label('إشعار جماعي'),
            Tables\Columns\TextColumn::make('type')->label('الدور'),
            Tables\Columns\IconColumn::make('enabled')->boolean()->label('مفعل؟'),


            ])
            ->filters([
                //
            ])

            ->actions([
                Tables\Actions\EditAction::make(),



   DeleteAction::make()
                ->requiresConfirmation() // ✅ تفعيل نافذة التأكيد
                ->modalHeading('هل أنت متأكد من الحذف؟')
                 ->visible(fn () => auth()->user()?->type === 'admin')
                ->modalDescription('سيتم حذف هذا المستخدم وجميع المهام المرتبطة به نهائيًا ولا يمكن استرجاعها.')
                ->modalButton('نعم، احذف'),






/*
            Tables\Actions\DeleteAction::make()
                ->visible(fn () => auth()->user()?->type === 'admin'),

                */

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //Tables\Actions\DeleteBulkAction::make(),

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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

/*

    public static function canViewAny(): bool
{


   return auth()->user()?->type === 'admin';
}
*/



/*

public static function shouldRegisterNavigation(): bool
{
    return auth()->user()?->type === 'admin';
}
*/







/*
public static function shouldRegisterNavigation(): bool
{
    return auth()->check() && auth()->user()->type === 'admin';
}

*/



public static function getEloquentQuery(): Builder
{
    $user = auth()->user();
    $query = parent::getEloquentQuery();

    // إذا كان الموظف، يظهر فقط نفسه
    if ($user->type === 'employee') {
        return $query->where('id', $user->id);
    }

    // المدير يرى الجميع
    return $query;
}





public static function getNavigationSort(): ?int
{
    return 2; // رقم أقل = يظهر أولاً
}

public static function getNavigationIcon(): string
{
    return 'heroicon-o-users'; // مثال
}


public static function canCreate(): bool
{
    return auth()->user()?->type === 'admin';
}





public static function canDelete(Model $record): bool
{
    return auth()->user()?->type === 'admin';
}




























}
