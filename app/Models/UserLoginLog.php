<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLoginLog extends Model
{
    public    $timestamps = false;
    protected $fillable   = [
        'user_id',
        'ip',
        'login_at',
    ];
}
