<?php

namespace App\Models;
use App\Models\Setting;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
protected $fillable = [
    'sender_id',
    'receiver_id',
    'project_id',
    'title',
    'description',
    'status',
    'task_url',
    'task_url_after',
    'task_time_after',
    'required_time',
    'done_info',
      'is_received',
];


    protected $casts = [
        'status' => 'boolean',
    ];



    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }



    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }








protected static function booted(): void
{
    static::updating(function (Task $task) {


        if ($task->isDirty('status')) {

            $newStatus = $task->status ? 'تمت' : 'لم تتم';
            $userName = auth()->user()?->name ?? 'مستخدم غير معروف';
            $message = "📌 تم تغيير حالة المهمة: '{$task->title}'\n"
                     . "من قبل: {$userName}\n"
                     . "الحالة الجديدة: {$newStatus}";

                      $message = str_replace("\n", "\\n",  $message);

$settings = Setting::first();

            // إرسال عبر واتساب
            send_with_wapi(
                auth: $settings->token,              // من جدول settings
                profileId: $settings->profile_id,    // من جدول settings
                phone: $settings->admin_group_id,                // الرقم الثابت
                message: $message
            );
        }











 if ($task->isDirty('is_received')) {

            $userName = $task->receiver?->name ?? 'موظف غير معروف';

            $newStatus = $task->is_received
                ? "📩 أكد الموظف {$userName} استلام المهمة: \"{$task->title}\""
                : "⚠️ ألغى الموظف {$userName} استلام المهمة: \"{$task->title}\"";

            // نظف السطر للنص
            $message = str_replace("\n", "\\n", $newStatus);

           // dd($message);
            // إعدادات WAPI
            $settings = Setting::first();
            if (!$settings) return;

            send_with_wapi(
                auth: $settings->token,
                profileId: $settings->profile_id,
                phone: $settings->admin_group_id, // رقم المسؤول/القروب
                message: $message
            );
        }
















    });
}







}
