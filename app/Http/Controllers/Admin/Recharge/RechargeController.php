<?php
namespace App\Http\Controllers\Admin\Recharge;

use Request, Response, Session, Config, DB, Exception;
use Illuminate\Routing\Controller;

/**
 * Class AgreementController
 * @package App\Http\Controllers\Admin\Recharge
 */
class RechargeController extends Controller
{
    static $views = 'admin.recharge.';

    /**
     * 首页
     * get: /admin/recharge/index
     */
    public function index()
    {
        return view(self::$views .'index');
    }

    /**
     * 分页查询
     * get: /admin/recharge/searchPage
     */
    public function searchPage()
    {
        $con['search'] = Request::input('search')['value'];
        $con['length'] = (int)Request::input('length', 10);// 每页显示数量
        $con['start'] = (int)Request::input('start',0);// 查询的起始数 默认为0
        $page = intval($con['start']/$con['length']+1);
        $sql = DB::table('recharge');
//        if (!empty($con['search'])){
//            $sql = $sql->where('title','LIKE','%'.$con['search'].'%');
//        }
        $list = $sql->paginate($con['length'], ['*'], 'page', $page)->toArray();
        $data['data'] = $list['data'];
        $data['recordsTotal'] = $list['total'];
        $data['recordsFiltered'] =  $list['total'];
        $data['draw'] = (int)Request::input('draw');//请求的次数，不用管;
        return Response::json($data);
    }

    /**
     * 详情
     * get: /admin/recharge/update
     */
    public function update()
    {
        $id = Request::input('id');
        $view = view(self::$views . 'update');
        if (!empty($id)){
            $data = DB::table('recharge')->find($id);
            $view = $view->with('data',$data);
        }
        return $view;
    }

    /**
     * 编辑
     * post: /admin/recharge/doEdit
     */
    public function doEdit()
    {
        $id = Request::input('id');
        $title = Request::input('title');
        $price = Request::input('price') *1000;
        $gold = Request::input('gold') * 1000;
        if (empty($id)){
            $row = DB::table('recharge')->insert([
                'title' => $title,
                'price' => $price,
                'gold' => $gold,
                'create_time' => time(),
            ]);
        }else {
            $row = DB::table('recharge')->where('id',$id)->update([
                'title' => $title,
                'price' => $price,
                'gold' => $gold,
                'update_time' => time(),
            ]);
        }
        if (!$row)
            return "false";
        return "true";
    }

    /**
     * 删除
     * get: /admin/recharge/delete
     */
    public function delete()
    {
        $id = Request::input('id');
        $row = DB::table('recharge')->where('id',$id)->delete();
        if (!$row)
            return 'false';
        return 'true';
    }

}

