<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\UserRequest;
use App\Models\Image;
use App\Models\User;
use App\Transformers\UserTransformer;
use Auth;
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

    public function show()
    {
        return $this->response
            ->item($this->user(),new UserTransformer())
            ->setMeta([
                'access_token'=>Auth::guard('api')->setTTl(60)->fromUser($this->user),
                'token_type' => 'Bearer',
                'expires_in' => Auth::guard('api')->factory()->getTTL() * 60

            ])
            ->setStatusCode(201);
    }

    public function update(UserRequest $request)
    {
        $user=$this->user();

        $attributes=$request->only(['name','email','introduction']);

        if ($request->avatar_image_id){
            $image=Image::find($request->avatar_image_id);
            $attributes['avatar']=$image->path;
        }
        $user->update($attributes);

        return $this->response->item($user,new UserTransformer());
    }
}
