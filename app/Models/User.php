<?php

namespace App\Models;

use App\Models\Traits\ActiveUserHelper;
use Auth;
use function config;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable{
        notify as laravelNotify;
    }
    use HasRoles;
    use ActiveUserHelper;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'last_login_at',
        'last_login_ip',
        'introduction',
        'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * 处理读取的avatar，存储为public文件夹相对路径
     * 没有再返回默认图片
     * @param $key
     * @return string
     */
    public function getAvatarAttribute($key)
    {
        if ($key) {
//            判断是本地还在网络image
            $url = filter_var($key, FILTER_VALIDATE_URL) ? $key : config('app.url') . $key;
        } else {
//            没有image,返回一个默认值
            $url = 'https://fsdhubcdn.phphub.org/uploads/images/201709/20/1/PtDKbASVcz.png?imageView2/1/w/60/h/60';
        }
        return $this->attributes['avatar'] = $url;
    }

    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    public function isAuthor($model)
    {
        return $this->id == $model->user_id;
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }
//    定制notify()
    public function notify($instance)
    {
        // 如果要通知的人是当前用户，就不必通知了！
        if ($this->id===Auth::id()){
            return;
        }

        $this->increment('notification_count');
        $this->laravelNotify($instance);

    }

    public function markAsRead()
    {
        $this->notification_count=0;
        $this->save();
        $this->unreadNotifications->markAsRead();
    }

}
