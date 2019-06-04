<?php


return [
    1 => [
        'app_key'    => env('SMS_APP_KEY'),
        'app_secret' => env('SMS_APP_SECRET'),
        'sign_name' => env('SMS_SIGN_NAME', '赵本彩'),
        'template_code' => env('SMS_TEMPLATE_CODE_ONE'),
        'template_param' => true,
    ],
    2 => [
        'app_key'    => env('SMS_APP_KEY'),
        'app_secret' => env('SMS_APP_SECRET'),
        'sign_name' => env('SMS_SIGN_NAME', '赵本彩'),
        'template_code' => env('SMS_TEMPLATE_CODE_TWO'),
        'template_param' => true,
    ],
    3 => [
        'app_key'    => env('SMS_APP_KEY'),
        'app_secret' => env('SMS_APP_SECRET'),
        'sign_name' => env('SMS_SIGN_NAME', '赵本彩'),
        'template_code' => env('SMS_TEMPLATE_CODE_THREE'),
        'template_param' => true,
    ],
];
