<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\AuthorizationRequest;
use App\Http\Requests\Api\SocialAuthorizationRequest;
use App\Http\Controllers\Api\Controller;
use Auth;
use const FILTER_VALIDATE_EMAIL;
use function filter_var;
use function in_array;
use Socialite;
use App\Models\User;

class AuthorizationsController extends Controller
{
    protected $social_types = ['weixin'];

    public function socialStore(string $type, SocialAuthorizationRequest $request)
    {
        if (!in_array($type, $this->social_types)) {
            return $this->response->errorBadRequest();
        }

        $driver = Socialite::driver($type);

        try {
            if ($code = $request->code) {
                $response = $driver->getAccessTokenResponse($code);
                $token = array_get($response, 'access_token');
            } else {
                $token = $request->access_token;

                if ($type === 'weixin') {
                    $driver->setOpenId($request->openid);
                }
            }

            $oauth_user = $driver->userFromToken($token);
        } catch (\Exception $e) {
            return $this->response->errorUnauthorized('参数错误，未获取用户信息');
        }

        switch ($type) {
            case 'weixin':
                $unionid = $oauth_user->offsetExists('unionid') ? $oauth_user->offsetGet('unionid') : null;

                if ($unionid) {
                    $user = User::where('weixin_unionid', $unionid)->first();
                } else {
                    $user = User::where('weixin_openid', $oauth_user->getId())->first();
                }

                // 没有用户，默认创建一个用户
                if (!$user) {
                    $user = User::create([
                        'name'           => $oauth_user->getNickname(),
                        'avatar'         => $oauth_user->getAvatar(),
                        'weixin_openid'  => $oauth_user->getId(),
                        'weixin_unionid' => $unionid,
                    ]);
                }

                break;
        }
        $token = Auth::guard('api')->fromUser($user);
        return $this->respondWithToken($token)->setStatusCode(201);

    }

    public function store(AuthorizationRequest $request)
    {
        $user_name = $request->username;
        filter_var($user_name, FILTER_VALIDATE_EMAIL) ? $credentials['email'] = $user_name : $credentials['phone'] = $user_name;
        $credentials['password'] = $request->password;

        if (!$token = Auth::guard('api')->attempt($credentials)) {
            return $this->response->errorUnauthorized('用户名或者密码错误');
        }

        return $this->respondWithToken($token)->setStatusCode(201);
    }

    protected function respondWithToken($token)
    {
        return $this->response->array([
            'access_token' => $token,
            'token_type'   => 'Bearer',
            'expires_in'   => Auth::guard('api')->factory()->getTTL() * 60
        ]);
    }

    public function update()
    {
        $token = Auth::guard('api')->refresh();
        return $this->respondWithToken($token);
    }

    public function destroy()
    {
        Auth::guard('api')->logout();
        return $this->response->noContent();
    }
}
