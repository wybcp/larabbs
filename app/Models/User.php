<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Auth;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable{
        notify as protected laravelNotify;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','introduction','avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function topics()
    {
        return $this->hasMany(Topic::class);
    }


    /**判断是否为作者本人
     * @param $model
     * @return mixed
     */
    public function isAuthor($model)
    {
        return $this->id==$model->user_id;
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }


    /**
     * 订制用户通知时更新未读通知数据
     * @param $instance
     */
    public function notify($instance)
    {
        // 如果要通知的人是当前用户，就不必通知了！
        if ($this->id == Auth::id()) {
            return;
        }
        $this->increment('notification_count');
        $this->laravelNotify($instance);
    }

    public function makeNotificationsAsRead()
    {
        $this->notification_count=0;
        $this->save();
//        dd($this->makeAsRead);
        $this->unreadNotifications->markAsRead();
    }
}
