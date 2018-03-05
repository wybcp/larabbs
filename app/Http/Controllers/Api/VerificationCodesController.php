<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\VerificationCodeRequest;
use Cache;
use Overtrue\EasySms\EasySms;
use function random_int;
use function str_pad;
use const STR_PAD_LEFT;

class VerificationCodesController extends Controller
{
    private $expire_minutes = 10;

    public function store(VerificationCodeRequest $request, EasySms $easy_sms)
    {
        $phone = $request->phone;
        if (!app()->environment('production')) {
            $code = '1234';
        } else {
//        make 4 digit number ,
            $code = str_pad(random_int(1, 9999), 4, 0, STR_PAD_LEFT);
            try {
                $easy_sms->send($phone, [
                    'template' => 'SMS_126650362',
                    'data'     => [
                        'code' => $code
                    ],
                ]);
            } catch (\GuzzleHttp\Exception\ClientException $exception) {
                $response = $exception->getResponse();
                $result = json_decode($response->getBody()->getContents(), true);
                return $this->response->errorInternal($result['msg'] ?? '短信发送异常');
            }
        }

        $key = 'verificationCode_' . str_random(15);
        $expiredAt = now()->addMinutes($this->expire_minutes);
        // 缓存验证码 10分钟过期。

        Cache::put($key, ['phone' => $phone, 'code' => $code], $expiredAt);

        return $this->response->array([
            'key'        => $key,
            'expired_at' => $expiredAt->toDateTimeString(),
        ])->setStatusCode(201)
            ;
    }
}
