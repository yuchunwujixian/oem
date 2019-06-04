<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Middleware\Authenticate as old_authe;
use Toastr;

class Authenticate extends old_authe
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null|array  $guards
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards)
    {
        //$guards是数组 取第一个
        if (!$guards){
            $guard = $guards;
        }else{
            $guard = $guards[0];
        }
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
				if($guard == 'admin'){
					return redirect()->guest('admin/login');
				}else{
					return redirect()->guest('/login');
				}
            }
        }
        if ($guard != 'admin' && Auth::guard($guard)->user()->status != 1){
            Toastr::error('账号被禁用，请联系客服解禁');
            Auth::guard($guard)->logout();
            return redirect()->guest('/login');
        }
        $this->authenticate($guards);
        return $next($request);
    }
}
