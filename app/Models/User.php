<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */protected $fillable = [
    'name',
    'email',
    'password',
    'phone',
    'group_id',
    'send_noti_in_privete',
    'send_noti_in_group',
    'enabled',
    'type',
];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];




    public function sentTasks(): HasMany
{
    return $this->hasMany(Task::class, 'sender_id');
}

public function receivedTasks(): HasMany
{
    return $this->hasMany(Task::class, 'receiver_id');
}













protected static function booted(): void
{


     static::creating(function ($user) {
        if (User::count() === 0) {
            $user->type = 'admin';
            $user->enabled = true;
        } else {
            $user->type = 'employee';
            $user->enabled = false;
        }
    });


























}





}
