<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaskResource\Pages;
use App\Filament\Resources\TaskResource\RelationManagers;
use App\Models\Task;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\ViewAction;
use Filament\Forms\Components\Textarea;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //




Forms\Components\Select::make('receiver_id')
                ->label('الموظف المستهدف')
                ->relationship('receiver', 'name')
                ->required(),

            Forms\Components\Select::make('project_id')
                ->label('المشروع')
                ->relationship('project', 'name')
                ->required(),

            Forms\Components\TextInput::make('title')->required(),


           // Forms\Components\Textarea::make('description'),

Textarea::make('description')
    ->label('الوصف')

    ->columnSpanFull()
    ->rows(fn ($state) => max(3, ceil(strlen($state ?? '') / 80))),









            Forms\Components\Toggle::make('status')->label('تمت؟'),
            Forms\Components\Hidden::make('sender_id')->default(fn () => auth()->id()),


Forms\Components\TextInput::make('task_url')
    ->label('رابط المهمة')

   ->required(),



Forms\Components\TextInput::make('required_time')
    ->label('الوقت المطلوب (بالدقائق)')
    ->numeric()
    ->required(),

Forms\Components\Textarea::make('done_info')
    ->label('ملاحظات الإنجاز')
    ->nullable(),





            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                //






Tables\Columns\TextColumn::make('receiver.name')->label('الموظف'),
            Tables\Columns\TextColumn::make('project.name')->label('المشروع'),
            Tables\Columns\TextColumn::make('title'),
            /*
            Tables\Columns\IconColumn::make('status')
                ->boolean()
                ->label('تمت؟'),
*/
/*

Tables\Columns\TextColumn::make('task_url')
    ->label('رابط المهمة')
    ->url(fn ($record) => $record->task_url)
    ->limit(30)
    ->openUrlInNewTab(),



       TextColumn::make('created_at')
    ->label('تاريخ الإنشاء')
    ->dateTime('d M Y - H:i')
    ->sortable(),


 ToggleColumn::make('status')
    ->label('تم الإنجاز؟')
    ->onColor('danger')
    ->offColor(color: 'success')
    ->sortable(),


/*
 ViewColumn::make('task_url')
    ->label('رابط المهمة')
    ->view('filament.components.task-url-button'),
*/

            ])
            ->filters([
                //



 SelectFilter::make('receiver_id')
        ->label('الموظف')
        ->relationship('receiver', 'name'),

    SelectFilter::make('project_id')
        ->label('المشروع')
        ->relationship('project', 'name'),

    SelectFilter::make('status')
        ->label('الحالة')
        ->options([
            '1' => 'تمت',
            '0' => 'لم تتم',
        ]),


  SelectFilter::make('created_at')
                ->form([
                    DatePicker::make('created_from')
                        ->label('من تاريخ'),
                    DatePicker::make('created_until')
                        ->label('إلى تاريخ'),
                ])
                ->query(function ($query, array $data) {
                    return $query
                        ->when($data['created_from'], fn ($q) =>
                            $q->whereDate('created_at', '>=', $data['created_from']))
                        ->when($data['created_until'], fn ($q) =>
                            $q->whereDate('created_at', '<=', $data['created_until']));
                }),


            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                    ViewAction::make(),
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
            'index' => Pages\ListTasks::route('/'),
            'create' => Pages\CreateTask::route('/create'),
            'edit' => Pages\EditTask::route('/{record}/edit'),
        ];
    }









public static function getEloquentQuery(): Builder
{


    $user = auth()->user();
    $query = parent::getEloquentQuery();
    /*

    if ($user->type === 'employee') {
        $query->where(function ($q) use ($user) {
            $q->where('sender_id', $user->id)
              ->orWhere('receiver_id', $user->id);
        });
    }

    */
    return  $query->latest();
}



public static function getNavigationSort(): ?int
{
    return 1; // رقم أقل = يظهر أولاً
}

public static function getNavigationIcon(): string
{
    return 'heroicon-o-check-circle'; // مثال
}




}
