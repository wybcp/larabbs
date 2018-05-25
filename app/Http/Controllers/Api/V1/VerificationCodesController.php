<?php

namespace App\Http\Controllers\Api\V1;

use function app;
use App\Http\Requests\Api\VerificationCodeRequest;
use App\Http\Controllers\Api\Controller;
use GuzzleHttp\Exception\ClientException;
use function json_decode;
use Overtrue\EasySms\EasySms;
use function random_int;
use function str_pad;
use const STR_PAD_LEFT;

class VerificationCodesController extends Controller
{
    public function store(VerificationCodeRequest $request, EasySms $easy_sms)
    {
        $phone = $request->phone;
        if (!app()->environment('production')) {
            $code = 1234;
        } else {
            $code = str_pad(random_int(1, 9999), 4, STR_PAD_LEFT);
            try {
                $result = $easy_sms->send($phone, [
                    'content' => "你的验证码{$code},有效时间5分钟。"
                ]);
            } catch (ClientException $exception) {
                $response = $exception->getResponse();
                $result = json_decode($response->getBody()->getContents(), true);
                return $this->response->errorInternal($result['msg'] ?? '短信异常');
            }
        }
        return $this->response->array([
            "test_message" => "store verification code!"
        ]);
    }
}
