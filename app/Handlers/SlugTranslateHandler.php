<?php
/**
 * Created by PhpStorm.
 * User: riverside
 * Date: 2018/1/15
 * Time: 08:58
 */

namespace App\Handlers;


use function app;
use GuzzleHttp\Client;
use function http_build_query;
use function md5;
use function str_slug;
use Overtrue\Pinyin\Pinyin;

class SlugTranslateHandler
{
    public function translate($text)
    {
        $http=new Client();

//        初始化配置
        $api='https://fanyi-api.baidu.com/api/trans/vip/translate?';
        $appid = config('services.baidu_translate.appid');
        $key = config('services.baidu_translate.key');
        $salt = time();
//        如果没有配置百度翻译，自动转换为兼容的拼音方式
        if (empty($appid)||empty($key)){
            return $this->pinyin($text);
        }
//        http://api.fanyi.baidu.com/api/trans/product/apidoc
        $sign=md5($appid.$text.$salt.$key);

//        构建请求
        $query=http_build_query([
            "q"     =>  $text,
            "from"  => "zh",
            "to"    => "en",
            "appid" => $appid,
            "salt"  => $salt,
            "sign"  => $sign,
        ]);

//        发送HTTP Get请求
        $response=$http->get($api.$query);

        $result=\GuzzleHttp\json_decode($response->getBody(),true);

        /**
        获取结果，如果请求成功，dd($result) 结果如下：

        array:3 [▼
        "from" => "zh"
        "to" => "en"
        "trans_result" => array:1 [▼
        0 => array:2 [▼
        "src" => "XSS 安全漏洞"
        "dst" => "XSS security vulnerability"
        ]
        ]
        ]
        **/
        //        尝试获取翻译结果
        if(isset($result['trans_result'][0]['dst'])){
            return str_slug($result['trans_result'][0]['dst']);
        }else{
            return $this->pinyin($text);
        }
    }

    public function pinyin($text)
    {
        return str_slug(app(Pinyin::class)->permalink($text));

    }

}