<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use function md5;
use function strtolower;
use function trim;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function gravatar($size=100)
    {
        $hash=md5(strtolower(trim($this->attributes['email'])));
        return "https://www.gravatar.com/avatar/$hash?s=$size";
    }
}
