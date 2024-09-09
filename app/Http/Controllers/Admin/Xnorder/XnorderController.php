<?php

namespace App\Http\Controllers\Admin\Xnorder;

use Request, Response, Session, Config, DB, Exception,Excel;
use Illuminate\Routing\Controller;

/**
 * Class RechargeController
 * @package App\Http\Controllers\Admin\Xnorder
 */
class XnorderController extends Controller
{

    static $views = 'admin.xnorder.';

    /**
     * 首页
     * get: /admin/xnorder/index
     */
    public function index()
    {
        return view(self::$views . 'index');
    }

    /**
     * 分页查询
     * get: /admin/xnorder/searchPage
     */
    public function searchPage()
    {
        $con['search'] = Request::input('search')['value'];
        $con['length'] = (int)Request::input('length', 10);// 每页显示数量
        $con['start'] = (int)Request::input('start',0);// 查询的起始数 默认为0
        $page = intval($con['start']/$con['length']+1);
        $sql = DB::table('exchange_order as o')
            ->leftJoin('member as m','m.id','=','o.m_id');
        if (!empty($con['search'])){
            $sql = $sql->whereRaw('CONCAT_WS(\',\',m.id,m.nickname,m.name) LIKE \'%'.$con['search'].'%\'');
        }
        $list = $sql->where('m.name','<>',null)
            ->where('o.type',2)
            ->orderBy('o.status','DESC')
            ->select('m.id as m_id','m.nickname','m.name','m.wx_num','m.qq_num','m.wx','m.zfb','o.price','o.num',
                'o.status','o.title','o.desc','o.id',
            DB::raw('FROM_UNIXTIME(o.create_time,\'%Y/%m/%d %H:%i:%s\') as create_date'),
            DB::raw('FROM_UNIXTIME(o.update_time,\'%Y/%m/%d %H:%i:%s\') as update_date'))
            ->paginate($con['length'], ['*'], 'page', $page)->toArray();
        $data['data'] = $list['data'];
        $data['recordsTotal'] = $list['total'];
        $data['recordsFiltered'] =  $list['total'];
        $data['draw'] = (int)Request::input('draw');//请求的次数，不用管;
        return Response::json($data);
    }

    /**
     * 详情
     * get: /admin/goods/update
     */
    public function update()
    {
        $id = Request::input('id');
        $view = view(self::$views . 'update');
        if (!empty($id)){
            $data = DB::table('exchange_order as o')
                ->leftJoin('member as m','m.id','=','o.m_id')
                ->where('o.id',$id)
                ->first(['m.wx','m.zfb']);
            $view = $view->with('data',$data);
        }
        return $view;
    }


    /**
     * 删除
     * get: /admin/sworder/delete
     */
    public function delete()
    {
        $id = Request::input('id');
        $row = DB::table('exchange_order')->where('id',$id)->delete();
        if (!$row)
            return 'false';
        return 'true';
    }

    /**
     * 立即打款
     */
    public function isOpen(){
        $id = Request::input('id');
        $status = Request::input('status');
        $row = DB::table('exchange_order')->find($id);
        if (!$row)
            return "false";
        $res = DB::table('exchange_order')->where('status',2)->where('id',$id)
            ->update([
                'status' => 1,
                'update_time' => time()
            ]);
        if (!$res)
            return "false";
        return "true";
    }

    /**
     * 立即打款
     */
    public function isRefuse(){
        $id = Request::input('id');
        $status = Request::input('status');
        $row = DB::table('exchange_order')->find($id);
        if (!$row)
            return "false";
        DB::beginTransaction();
        try{
            $res = DB::table('exchange_order')->where('status',2)
                ->where('id',$id)
                ->update([
                    'status' => 3,
                    'update_time' => time()
                ]);
            if (!$res){
                DB::rollBack();
                return "false";
            }
            //返还金币
            $member = DB::table('member')->where('id',$row->m_id)
                ->increment('gold',$row->price);
            if (!$member){
                DB::rollBack();
                return "false";
            }
            DB::commit();
            return "true";
        }catch (Exception $e){
            DB::rollBack();
            return 'false';
        }
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
