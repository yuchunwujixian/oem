<?php
return [

	// 安全检验码，以数字和字母组成的32位字符。
    //囧米
    'key' => 'q8y75k43rn0o9fa8ryspj9gtbkot46zu',

	//签名方式
	'sign_type' => 'MD5',

	// 服务器异步通知页面路径。
	'notify_url' => env('APP_URL') . '/member/notify',

	// 页面跳转同步通知页面路径。
	'return_url' => env('APP_URL') . '/member/return'
];
