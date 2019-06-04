<?php

namespace App\Http\Controllers;

use App\Models\Sms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class SmsController extends Controller
{

    public  function send(Request $request)
    {
        $output = ['status' => 0, 'message' => ''];
        $type = $request->input('type');//1注册 2找回密码 3绑定账号
        $username = $request->input('username');
        $code = rand(100000, 999999);
        //判断账号是否已注册
        $input = [];
        $sms_type = 1;
        if (preg_match(config('config_base.mobile_rule'), $username)) {
            $input['mobile'] = $username;
        } elseif (preg_match(config('config_base.email_rule'), $username)) {
            $input['email'] = $username;
            $sms_type = 2;
        }
        if (!$input){
            $output['message'] = "账号格式不正确，请重试";
            return $this->tojson($output);
        }
        $user = User::where($input)->first();
        if ($type == 1 && $user) {
            $output['message'] = "该账号已经注册，请切换其他账号";
            return $this->tojson($output);
        }elseif ($type == 2 && empty($user)){
            $output['message'] = "该账号未注册，请去注册账号";
            return $this->tojson($output);
        }elseif ($type == 3 && $user){
            $output['message'] = "该账号已经绑定，请切换其他账号";
            return $this->tojson($output);
        }

        //判断账号是否过期
        $res = Sms::where(['username' => $username, 'sms_type' => $sms_type, 'type' => $type])->orderBy('id', 'desc')->get();
        if (!env('APP_DEBUG') && $res->count() > 0){
            if (time() - strtotime($res[0]['created_at']) <= 300) {
                $output['message'] = "验证码已发送，且有效，无需重发";
                return $this->tojson($output);
            }
            if ($res->count() >= 3) {
                $output['message'] = "对不起，您的账号已操作三次，请联系官方解绑";
                return $this->tojson($output);
            }
        }
        $add = [
            'username' => $username,
            'sms_type' => $sms_type,
            'code' => $code,
            'type' => $type,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        if (auth()->user()){
            $add['user_id'] = auth()->user()->id;
        }
        $res = Sms::create($add);
        if ($res){
            $output['status'] = 1;
            $output['message'] = "验证码发送成功，请注意查收";
            if (env('APP_DEBUG')){
                $output['message'] = '验证码为：'.$code.'，请在有效时间内填写';
            }
        }
        return $this->tojson($output);
    }


    public  function forgot(Request $request)
    {
        $email = $request->input('email');
        $code = rand(100000, 999999);
        //判断账号是否已注册
        $user = User::where('email', $email)->get();
        if (empty($user->count())) {
            $date['code'] = 1;
            $date['message'] = "该账号未注册";
            return $date;
        }

        //判断账号是否过期
        $res = Email::where(['email' => $email, 'type' => 3])->orderBy('created_at', 'desc')->get();
        if ($res->count()) {
            if (time() - strtotime($res[0]['created_at']) <= 300) {
                $date['code'] = 1;
                $date['message'] = "验证码已发送，无需重发";
                return $date;
            }
        }

        Mail::send('email.forgot', ['code' => $code], function ($message) use ($email) {
            $message->to($email)->subject('找回密码');
        });
        Email::create([
            'email' => $email,
            'code' => $code,
            'type' => 3
        ]);
        $date['code'] = 0;
        $date['message'] = "验证码发送成功，请注意查收";
        return $date;
    }

}
