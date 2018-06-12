<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\UserRequest;
use App\Models\Image;
use App\Models\User;
use App\Transformers\UserTransformer;
use Auth;
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

        $user = User::create([
            'name'     => $request->name,
            'phone'    => $verify_data['phone'],
            'password' => Hash::make($request->password),
        ]);

        Cache::forget($request->verification_key);

//        return $this->response->created();
        return $this->response->item($user, new UserTransformer())
            ->setMeta([
                'access_token' => Auth::guard('api')->fromUser($user),
                'token_type'   => 'Bearer',
                'expires_in'   => Auth::guard('api')->factory()->getTTL() * 60
            ])
            ->setStatusCode(201)
            ;
    }

    public function me()
    {
        return $this->response->item($this->user(), new UserTransformer());
    }

    public function update(UserRequest $request)
    {
        $user = $this->user();

        $attributes = $request->only(['name', 'email', 'introduction','registration_id']);
        if ($request->avatar_image_id) {
            $image = Image::findOrFail($request->avatar_image_id);
            $attributes['avatar'] = $image->path;
        }
        $user->update($attributes);
        return $this->response->item($user, new UserTransformer());

    }

    public function activedIndex(User $user)
    {
        return $this->response->collection($user->getActiveUsers(), new UserTransformer());
    }
}
