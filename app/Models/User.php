<?php

namespace App\Models;

use function config;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

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
        return $this->attributes['avatar'] = $key?config('app.url') . $key:'https://fsdhubcdn.phphub.org/uploads/images/201709/20/1/PtDKbASVcz.png?imageView2/1/w/60/h/60';
    }
}
