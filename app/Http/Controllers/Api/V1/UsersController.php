<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\UserRequest;
use App\Models\User;
use Cache;
use Hash;
use function hash_equals;
use App\Http\Controllers\Api\Controller;

class UsersController extends Controller
{
    public function store(UserRequest $request)
    {
        $verify_data = Cache::get($request->verification_key);

        if (!$verify_data) {
            return $this->response->error("验证码已失效", 422);
        }

        if (!hash_equals($verify_data['code'], $request->verification_code)) {
            return $this->response->errorUnauthorized('验证码错误');
        }

        User::create([
            'name'     => $request->name,
            'phone'    => $verify_data['phone'],
            'password' => Hash::make($request->password),
        ]);

        Cache::forget($request->verification_key);

        return $this->response->created();

    }
}
