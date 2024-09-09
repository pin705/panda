<?php

namespace App\Http\Middleware;

use Closure,Session,Request,Config,DB;
use Illuminate\Foundation\Application;
use EasyWeChat\Factory;

class HomeMiddleware
{
    /**
     * @param $request
     * @param Closure $next
     * @param null $guard
     * @return mixed
     */
    public function handle($request, Closure $next){
        //获取token
        $token = $request->input('token');//参数：登录验证
        $data = [
            'errcode' => 10001,
            'errmsg' => '未登录或登录已失效，请重新登录。'
        ];
        if(empty($token)){
            return response()->json($data);
        }

//        $memberService = new MemberService();

        $member = DB::table('member')->where('token',$token)->first(['id','status']);
        if (empty($member)) {
            return response()->json($data);
        }
        $mid = $member->id;
        if ($mid <= 0) {
            return response()->json($data);
        }
        //根据mid获取用户信息
        $status = $member->status;
        if(!empty($status) && $status == 2){
            $data = [
                'errcode' => 10005,
                'errmsg' => '账号被封。'
            ];
            return response()->json($data);
        }
        $request->attributes->add(['mid' => $mid]);
        return $next($request);
    }



}