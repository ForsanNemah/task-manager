<?php

namespace App\Filament\Resources\TaskResource\Pages;

use App\Filament\Resources\TaskResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;


class CreateTask extends CreateRecord
{
    protected static string $resource = TaskResource::class;






    protected function afterCreate(): void
{
    $task = $this->record;

    $settings = Setting::first();
    $receiver = $task->receiver;
    $sender = $task->sender;

    if (! $settings || ! $receiver || ! $receiver->phone) {
        return;
    }

    $message = "📌 مهمة جديدة لك\n"
        . "العنوان: {$task->title}\n"
        . "الوصف: {$task->description}\n"
        . "من: {$sender->name}\n"
        . "إلى: {$receiver->name}\n"
        . "📅 التاريخ: " . Carbon::now()->format('Y-m-d H:i');

        require_once base_path('helpers/wapi.php');

         //dd($settings->token);
        //dd($receiver->phone);

        $message = str_replace("\n", "\\n",  $message);


        if($receiver->send_noti_in_privete	){


             send_with_wapi(
        auth: $settings->token,
        profileId: $settings->profile_id,
        phone: $receiver->phone.'@c.us',
        message: $message
    );


        }



  if($receiver->send_noti_in_group	){


             send_with_wapi(
        auth: $settings->token,
        profileId: $settings->profile_id,
        phone: $receiver->group_id,
        message: $message
    );


        }










}











protected function getRedirectUrl(): string
{
return $this->getResource()::getUrl('index');
}






}




