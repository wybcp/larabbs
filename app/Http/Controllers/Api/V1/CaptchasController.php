<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\CaptchaRequest;
use Cache;
use Gregwar\Captcha\CaptchaBuilder;
use App\Http\Controllers\Api\Controller;
use function now;
use function str_random;

class CaptchasController extends Controller
{
    public function store(CaptchaRequest $request, CaptchaBuilder $captcha_builder)
    {
        $key = 'captcha_' . str_random(15);
        $captcha = $captcha_builder->build();
        $expired_at = now()->addMinutes(10);
        Cache::put($key, ['phone' => $request->phone, 'code' => $captcha->getPhrase()], $expired_at);
//        inline 方法获取的 base64 图片验证码
//        考虑到图片验证码比较小，直接以 base64 格式返回图片，大家可以考虑在这里返回图片 url，例如 http://larabbs.test/captchas/{captcha_key}，然后访问该链接的时候生成并返回图片。
        $result = [
            'captcha_key'           => $key,
            'expired_at'            => $expired_at->toDateTimeString(),
            'captcha_image_content' => $captcha->inline(),
//            'captcha_image_content' => $captcha->getContents(),
        ];
        return $this->response->array($result)->setStatusCode(201);
    }
}
