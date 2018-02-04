<?php

namespace App\Models;

use App\Models\Traits\ActiveuserHelper;
use App\Models\Traits\LastActivedAtHelper;
use function bcrypt;
use Illuminate\Notifications\Notifiable;
use Auth;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
    use Notifiable{
        notify as protected laravelNotify;
    }
    use ActiveuserHelper;
    use LastActivedAtHelper;

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

    /**
     *  密码修改器
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        // 如果值的长度等于 60，即认为是已经做过加密的情况
        if (strlen($value) != 60) {

            // 不等于 60，做密码加密处理
            $value = bcrypt($value);
        }

        $this->attributes['password'] = $value;
    }

    /**
     *
     * 头像地址修改器
     * @param $path
     */
    public function setAvatarAttribute($path)
    {
        // 如果不是 `http` 子串开头，那就是从后台上传的，需要补全 URL
        if ( ! starts_with($path, 'http')) {

            // 拼接完整的 URL
            $path = config('app.url') . "/uploads/images/avatars/$path";
        }

        $this->attributes['avatar'] = $path;
    }
}
