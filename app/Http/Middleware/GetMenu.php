<?php

namespace App\Http\Middleware;

use Closure;
use Auth, Cache, Route;

class GetMenu
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //view()->share('comData',$this->getMenu());
        $request->attributes->set('comData_menu', $this->getMenu());
        return $next($request);
    }

    /**
     * 获取左边菜单栏
     * @return array
     */
    function getMenu()
    {
        $openArr = [];
        $data = [];
        $data['top'] = [];
        //查找并拼接出地址的别名值
        $urlPath = Route::currentRouteName();
        if (strpos($urlPath,'admin') === false){
            $urlPath = 'admin.'.$urlPath;
        }
        $urlPath = explode('.', $urlPath);
        //查找出所有的地址
        $table = Cache::store('file')->rememberForever('menus', function () {
            return \App\Models\Admin\Permission::where('is_menu', 1)
                ->get();
        });
        $user = Auth::guard('admin')->user();
        foreach ($table as $v) {
            if ($v->cid == 0 || ($user && $user->hasPermission($v))) {
                if (explode('.', $v->name)[1] == $urlPath[1]) {
                    $openArr[] = $v->id;
                    $openArr[] = $v->cid;
                }
                $data[$v->cid][] = $v->toarray();
            }

        }
        if (isset($data[0])){
            foreach ($data[0] as $v) {
                if (isset($data[$v['id']]) && is_array($data[$v['id']]) && count($data[$v['id']]) > 0) {
                    $data['top'][] = $v;
                }
            }
            unset($data[0]);
        }
        //ation open 可以在函数中计算给他
        $data['openarr'] = array_unique($openArr);
        return $data;

    }
}
