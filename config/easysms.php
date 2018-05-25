<?php
return [
    'timeout' => 5,
    'default' => [
        'strategy' => \Overtrue\EasySms\Strategies\OrderStrategy::class,
        'gateways' => [
            'yunpian',
        ],
    ],

    'gateways'=>[
        'errorlog'=>['file'=>storage_path().'/logs/easy-sms.log']
    ],
    'yunpian'=>['api_key'=>env('YUNPIAN_API_KEY')]
];