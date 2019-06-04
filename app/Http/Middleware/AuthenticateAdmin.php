<?php

namespace App\Http\Middleware;

use Closure;
use Route, URL, Auth;

class AuthenticateAdmin
{

    protected $except = [
        'admin/index',
        'admin.index.index',
    ];
    protected $allow = [
        'admin.index.index',
    ];

    /**
     * Handle an incoming request.
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $routeName = starts_with(Route::currentRouteName(), 'admin.') ? Route::currentRouteName() : 'admin.' . Route::currentRouteName();
        //超级管理员
        if (Auth::guard('admin')->user()->is_super_admin === 1 || in_array($routeName,$this->allow)) {
            return $next($request);
        }

        $previousUrl = URL::previous();
//        if (!\Gate::check($routeName)) {
        //权限判断
        if (!Auth::guard('admin')->user()->hasPermission($routeName)) {
            if ($request->ajax() && ($request->getMethod() != 'GET')) {
                return response()->json([
                    'status' => 0,
                    'message'    => '您没有权限执行此操作',
                ]);
            } else {
                return response()->view('admin.errors.403', compact('previousUrl'));
            }
        }

        return $next($request);
    }
}
