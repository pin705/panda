<?php

namespace App\Http\Controllers\Admin\Log;

use Request, Response, Session, Config, DB, Exception;
use Illuminate\Routing\Controller;

/**
 * Class RechargeController
 * @package App\Http\Controllers\Admin\Log
 */
class LogController extends Controller
{

    static $views = 'admin.log.';

    /**
     * 首页
     * get: /admin/log/index
     */
    public function index()
    {
        return view(self::$views . 'index');
    }

    /**
     * 分页查询
     * get: /admin/log/searchPage
     */
    public function searchPage()
    {
        $con['search'] = Request::input('search')['value'];
        $con['length'] = (int)Request::input('length', 10);// 每页显示数量
        $con['start'] = (int)Request::input('start',0);// 查询的起始数 默认为0
        $con['create_begin'] = Request::input('create_begin');
        $con['create_end'] = Request::input('create_end');
        $page = intval($con['start']/$con['length']+1);
        $sql = DB::table('h_member_log as l')
            ->leftJoin('h_member as m','m.id','=','l.m_id');
        if (!empty($con['search'])){
            $sql = $sql->whereRaw('CONCAT_WS(\',\',l.m_id,m.nickname,m.id) LIKE \'%'.$con['search'].'%\'');
        }
        //按时间搜索
        if ((!empty($con['create_begin'])) && (!empty($con['create_end'])) ){
            $sql = $sql->where('l.create_time','>',strtotime($con['create_begin']))
                ->where('l.create_time','<',strtotime($con['create_end']));
        }

        $list = $sql->select('l.id','m.id as m_id','m.nickname','l.score',
            DB::raw('FROM_UNIXTIME(l.create_time,\'%Y/%m/%d %H:%i:%s\') as create_date'))
            ->paginate($con['length'], ['*'], 'page', $page)->toArray();
        $data['data'] = $list['data'];
        $data['recordsTotal'] = $list['total'];
        $data['recordsFiltered'] =  $list['total'];
        $data['draw'] = (int)Request::input('draw');//请求的次数，不用管;
        return Response::json($data);
    }

    /**
     * 删除
     * get: /admin/log/delete
     */
    public function delete()
    {
        $id = Request::input('id');
        $row = DB::table('h_member_log')->where('id',$id)->delete();
        if (!$row)
            return 'false';
        return 'true';
    }
}
