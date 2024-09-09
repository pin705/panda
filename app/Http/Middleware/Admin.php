<?php

namespace App\Http\Middleware;

use Closure,Session,Request,Config;

class Admin
{
    /**
     * @param $request
     * @param Closure $next
     * @param null $guard
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        //判断当前用户是否登陆
        // 获取当前用户ID
        $user =Session::get(Config::get('custom.AdminUser'));
        $menu =	Session::get(Config::get('custom.AdminMenu'));
        if(!$user || !$menu){// 还没登录 跳转到登录页面
            //暂存请求的URL数据，并只在下次请求有效，登陆后使用
            Session::flash('request_url', Request::getRequestUri());
            return redirect('/admin/sign');
        }
        return $next($request);
    }
}
