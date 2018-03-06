<?php

namespace App\Http\Controllers\Api;


use App\Http\Requests\Api\UserRequest;
use App\Models\User;
use Cache;
use function hash_equals;

class UsersController extends Controller
{
    public function store(UserRequest $request)
    {
        $verify_data=Cache::get($request->verification_key);

        if(!$verify_data){
            return $this->response->error('验证码已失效',422);
        }

        if (!hash_equals($verify_data['code'],$request->verification_code)){
            return $this->response->errorUnauthorized('验证码错误');
        }

        $user=User::create([
            'name'=>$request->name,
            'phone'=>$verify_data['phone'],
            'password'=>$request->password,
        ]);

        Cache::forget($request->verification_code);

        return $this->response->created();
    }
}
