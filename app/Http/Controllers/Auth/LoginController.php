<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Toastr;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/member/info/index';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function username()
    {
        return 'username';
    }

//    protected function sendLoginResponse(Request $request)
//    {
//        $request->session()->regenerate();
//
//        $this->clearLoginAttempts($request);
//
//        return redirect()->intended();
//    }
    public function showLoginForm()
    {
        $this->title = '登录';
        return $this->view('auth.login');
    }

    protected function credentials(Request $request)
    {
        $login = $request->input($this->username(), '');

        $input = array(
            'password' => $request->input('password')
        );

        if (preg_match(config('config_base.mobile_rule'), $login)) {
            $input['mobile'] = $login;
        } elseif (preg_match(config('config_base.email_rule'), $login)) {
            $input['email'] = $login;
        }

        return $input;
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $input = $this->credentials($request);
        if (empty($input['mobile']) && empty($input['email'])){
            return redirect()->back()
                ->withInput($request->only($this->username(), 'password', 'remember'))
                ->withErrors([
                    $this->username() => '账号不合法，请重试',
                ]);
        }
        $user = User::getUserInfo($input);

        if (!$user){
            return redirect()->back()
                ->withInput($request->only($this->username(), 'password', 'remember'))
                ->withErrors([
                    $this->username() => '账号不存在，请切换其他账号',
                ]);
        }

        if ($user->status != 1) {
            return redirect()->back()
                ->withInput($request->only($this->username(), 'password', 'remember'))
                ->withErrors([
                    $this->username() => '账号被禁用，请联系客服解禁',
                ]);
        }

        if ($this->attemptLogin($request)) {
            //赠送积分
            User::giveIntegral($user->id, 2, 10, '登录送');
            Toastr::success("登录成功");
            return $this->sendLoginResponse($request);
        }
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->flush();

        $request->session()->regenerate();
        Toastr::success("退出成功");
        return redirect(route('index.index'));
    }

}
