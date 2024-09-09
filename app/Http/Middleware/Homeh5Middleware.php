<?php

namespace App\Http\Middleware;

use Closure,Session,Request,Config,DB;
use Illuminate\Foundation\Application;
use EasyWeChat\Factory;

class Homeh5Middleware
{
    /**
     * @param $request
     * @param Closure $next
     * @param null $guard
     * @return mixed
     */
//    public function handle($request, Closure $next, $guard = null)
//    {
////        Session::put('mid',21);
//        $url = Request::getRequestUri();
//        $basepath = Config::get('custom.BasePathH5');
//        $url = urlencode($url);
//        if(!Session::has('open_id')){
//            $url = $basepath.'/oAuth/indexh5?redirect_url='.$url;
//            return redirect($url);
//        }
//        return $next($request);
//    }http://fgh5.fggy.shop/home2/indexh5

    public function handle($request, Closure $next, $guard = null)
    {
        $json = Request::get('json');

        if (!empty($json)){
            $json = json_decode($json);
            Session::put('open_id', $json->open_id);
            return redirect("/home2/indexh5");
        }

        if(!Session::has('open_id')){
            $url = Request::getRequestUri();
            $basepath = Config::get('custom.BasePath');
            $url = urlencode($basepath.$url);
            $url = 'https://www.modn123.cn/oAuth/indexI?redirect_url='.$url;
            return redirect($url);
        }

        return $next($request);
    }







}