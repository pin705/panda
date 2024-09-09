<?php

namespace App\Http\Controllers\Admin\Order;

use Request, Response, Session, Config, DB, Exception,Excel;
use Illuminate\Routing\Controller;

/**
 * Class RechargeController
 * @package App\Http\Controllers\Admin\Order
 */
class OrderController extends Controller
{

    static $views = 'admin.order.';

    /**
     * 首页
     * get: /admin/order/index
     */
    public function index()
    {
        return view(self::$views . 'index');
    }

    /**
     * 分页查询
     * get: /admin/order/searchPage
     */
    public function searchPage()
    {
        $con['search'] = Request::input('search')['value'];
        $con['length'] = (int)Request::input('length', 10);// 每页显示数量
        $con['start'] = (int)Request::input('start',0);// 查询的起始数 默认为0
        $page = intval($con['start']/$con['length']+1);
        $sql = DB::table('recharge_order as o')
            ->leftJoin('member as m','m.id','=','o.m_id');
        if (!empty($con['search'])){
            $sql = $sql->whereRaw('CONCAT_WS(\',\',m.id,m.nickname,m.name,m.tel) LIKE \'%'.$con['search'].'%\'');
        }
        $list = $sql->where('m.name','<>',null)
            ->where('o.status',1)
            ->select('m.id','m.nickname','m.name','m.tel','o.price','o.status',
            DB::raw('FROM_UNIXTIME(m.update_time,\'%Y/%m/%d %H:%i:%s\') as update_date'))
            ->paginate($con['length'], ['*'], 'page', $page)->toArray();
        $data['data'] = $list['data'];
        $data['recordsTotal'] = $list['total'];
        $data['recordsFiltered'] =  $list['total'];
        $data['draw'] = (int)Request::input('draw');//请求的次数，不用管;
        return Response::json($data);
    }

    /**
     * 导出excel
     */
    public function getExcel(){
        $sql = DB::table('p_member as m');
        $datas = $sql->where('name','<>',null)
            ->select('m.id','m.nickname','m.name','m.tel','m.create_time','m.update_time')->get();
        $count = count($datas) + 2;
        foreach ($datas as $data => $value) {
            $cellData[] = array(
                '用户ID' => $value->id,
                '微信昵称' => $value->nickname,
                '姓名' => $value->name,
                '手机号码' => $value->tel,
                '填写领取时间' =>  date('Y-m-d H:i:s',$value->update_time),
            );
        }

        if (empty($cellData)){
            $cellData[] = array(
                '用户ID' => '',
                '微信昵称' => '',
                '姓名' => '',
                '手机号码' => '',
                '填写个人信息时间' => '',
            );
        }

        Excel::create('领取信息',function($excel) use ($cellData,$count){
            $excel->sheet('message', function($sheet) use ($cellData,$count){
                $sheet->fromArray($cellData)
                    -> prependRow(array(                      //在第一行之前加入一行
                        '领取信息'
                    ))
                    ->mergeCells('A1:E1')                      //合并A1到H1
                    ->setWidth(array(                         //A到H的列宽为15
                        'A'     => 20,
                        'B'     => 20,
                        'C'     => 20,
                        'D'     => 20,
                        'E'     => 20,
                    ))
                    ->setHeight(array(                        //第一行的行高为25
                        1     =>  25,
                    ))
                    ->cell('A1:E'.$count.'', function($cells) {        //A1到E6区域 水平垂直居中
                        $cells->setAlignment('center')->setValignment('center');
                    })
                    ->cell('A1:E1', function($cells) {
                        //设置第一行字体
                        $cells->setBackground('#000000')->setFontColor('#ffffff')->setFontFamily('Calibri')->setFontSize(16)->setFontWeight('bold',true);
                    });
            });
        })->export('xls');
    }






}
