<?php


use Filament\Forms;
use Filament\Pages\Page;
use Filament\Forms\Concerns\InteractsWithForms;

class EditProfile_custom extends Page implements Forms\Contracts\HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(auth()->user()->toArray());
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('name')->required(),
            Forms\Components\TextInput::make('email')->email()->required(),
            Forms\Components\TextInput::make('phone'),
            Forms\Components\TextInput::make('group_id'),
            Forms\Components\Toggle::make('send_noti_in_group'),
            Forms\Components\Toggle::make('send_noti_in_privete'),
        ];
    }

    public function submit()
    {
        auth()->user()->update($this->form->getState());

        session()->flash('success', 'تم تحديث البيانات بنجاح.');
    }

    protected static string $view = 'filament.pages.edit-profile';



    public static function shouldRegisterNavigation(): bool
{
    return true; // أو تحقق من نوع المستخدم إذا أردت
}






public static function getNavigationLabel(): string
{
    return 'تعديل بياناتي';
}









}
