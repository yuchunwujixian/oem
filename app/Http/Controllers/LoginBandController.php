<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use App\Models\LoginBand;
use Auth;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use SocialiteProviders\Weixin\Provider;

class LoginBandController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/member/info/index';

    public function login(Request $request)
    {
        $this->validate($request, [
            'openId' => 'required',
            'type' => 'required',
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);
        $update_data = array(
            'open_id' => $request->input('openId'),
            'type' => $request->input('type'),
        );
        event(new Registered($user = User::create([
            'name' => $request->input('name'),
            'password' => bcrypt($request->input('password')),
            'email' => $request->input('email'),
        ])));
        $update_data['user_id'] = $user->id;
        LoginBand::create($update_data);
        $this->guard()->login($user);
        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

    protected function guard()
    {
        return Auth::guard();
    }

    //QQ登陆
    public function qq()
    {
        $clientId = "101406573";
        $clientSecret = "7edaf0bd99747ef019543ee9fdf7d3c6";
        $redirectUrl = "http://www.jiongmiyou.com/login/qqlogin";
        $additionalProviderConfig = ['site' => 'meta.stackoverflow.com'];
        $config = new \SocialiteProviders\Manager\Config($clientId, $clientSecret, $redirectUrl, $additionalProviderConfig);
        return Socialite::with('qq')->setConfig($config)->redirect();
    }

    //QQ回掉地址
    public function qqlogin()
    {
        $user = Socialite::driver('qq')->user();
        $openId = $user->getId();
        $res = LoginBand::where(['type' => 1, 'open_id' => $openId])->first();

        if ($res) {
            Auth::login($res->userInfo);
            return redirect()->route('member.info.index');
        } else {
            return view('auth.loginBand', [
                'openId' => $openId,
                'type' => 1,
                'message' => "QQ授权成功，请您填写基本信息，并绑定账号",
            ]);
        }
//        var_dump($user->getId());
//        var_dump($user->getNickname());
//        var_dump($user->getName());
//        var_dump($user->getEmail());
//        var_dump($user->getAvatar());
    }

    //微信
    public function weixin(Request $request)
    {
        return Socialite::with('weixin')->scopes(['snsapi_login'])->redirect();
    }

    //微信回掉地址
    public function weixinlogin(Request $request)
    {
        $user = Socialite::with('weixin')->user();
        $openId = $user->getId();
        $res = LoginBand::where(['type' => 2, 'open_id' => $openId])->first();

        if ($res) {
            Auth::login($res->userInfo);
            return redirect()->route('member.info.index');
        } else {
            return view('auth.loginBand', [
                'openId' => $openId,
                'type' => 2,
                'message' => "微信授权成功，请您填写基本信息，并绑定账号",
            ]);
        }
    }
    //微博
    public function weibo()
    {
        return Socialite::with('weibo')->redirect();
    }
    //微博回掉地址
    public function weibologin()
    {
        $user = Socialite::with('weibo')->user();
        $openId = $user->getId();
        $res = LoginBand::where(['type' => 3, 'open_id' => $openId])->first();

        if ($res) {
            Auth::login($res->userInfo);
            return redirect()->route('member.info.index');
        } else {
            return view('auth.loginBand', [
                'openId' => $openId,
                'type' => 3,
                'message' => "微博授权成功，请您填写基本信息，并绑定账号",
            ]);
        }
    }
}
