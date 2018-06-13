<?php

namespace Tests\Traits;

use App\Models\User;
use Auth;

trait ActingJWTUser
{
    public function JWTActingAs(User $user)
    {
        $token = Auth::guard('api')->fromUser($user);
        $this->withHeaders(['Authorization' => 'Bearer ' . $token,'Accept'=>'application/prs.larabbs.v1+json']);

        return $this;
    }
}