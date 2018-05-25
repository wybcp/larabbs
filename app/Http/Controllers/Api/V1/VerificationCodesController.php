<?php

namespace App\Http\Controllers\Api\V1;

use function app;
use App\Http\Requests\Api\VerificationCodeRequest;
use App\Http\Controllers\Api\Controller;
use Cache;
use GuzzleHttp\Exception\ClientException;
use function json_decode;
use function now;
use Overtrue\EasySms\EasySms;
use function random_int;
use function str_pad;
use const STR_PAD_LEFT;
use function str_random;

class VerificationCodesController extends Controller
{
    public function store(VerificationCodeRequest $request, EasySms $easy_sms)
    {
        $captcha_data = Cache::get($request->captcha_key);

        if (!$captcha_data) {
            return $this->response->error('图片验证码已失效', 422);
        }
        if (!hash_equals($captcha_data['code'], $request->captcha_code)) {
            // 验证错误就清除缓存
            Cache::forget($request->captcha_key);
            return $this->response->errorUnauthorized('验证码错误');
        }
        $phone = $captcha_data['phone'];
        if (!app()->environment('production')) {
            $code = '1234';
        } else {
            $code = str_pad(random_int(1, 9999), 4, STR_PAD_LEFT);
            try {
                $easy_sms->send($phone, [
                    'content' => "你的验证码{$code},有效时间5分钟。"
                ]);
            } catch (ClientException $exception) {
                $response = $exception->getResponse();
                $result = json_decode($response->getBody()->getContents(), true);
                return $this->response->errorInternal($result['msg'] ?? '短信异常');
            }
        }

        $key = 'verification_code_' . str_random(15);
        $expired_at = now()->addMinutes(10);
        Cache::put($key, ['phone' => $phone, 'code' => $code], $expired_at);

        return $this->response->array([
            'key'        => $key,
            'expired_at' => $expired_at->toDateTimeString(),
        ])->setStatusCode(201)
            ;
    }
}
