<?php
namespace App\Http\Controllers\Admin\Exchange;

use Request, Response, Session, Config, DB, Exception;
use Illuminate\Routing\Controller;

/**
 * Class VipcnController
 * @package App\Http\Controllers\Admin\Exchange
 */
class ExchangeController extends Controller
{
    static $views = 'admin.exchange.';

    /**
     * 首页
     * get: /admin/exchange/index
     */
    public function index()
    {
        return view(self::$views . 'index');
    }

    /**
     * 分页查询
     *get: /admin/exchange/searchPage
     */
    public function searchPage()
    {
        $con['search'] = Request::input('search')['value'];
        $con['length'] = (int)Request::input('length', 10);// 每页显示数量
        $con['start'] = (int)Request::input('start',0);// 查询的起始数 默认为0
        $page = intval($con['start']/$con['length']+1);
        $sql = DB::table('exchange');
        $list = $sql->paginate($con['length'], ['*'], 'page', $page)->toArray();
        $data['data'] = $list['data'];
        $data['recordsTotal'] = $list['total'];
        $data['recordsFiltered'] =  $list['total'];
        $data['draw'] = (int)Request::input('draw');//请求的次数，不用管;
        return Response::json($data);
    }

    /**
     * 详情
     * get: /admin/exchange/update
     */
    public function update()
    {
        $id = Request::input('id');
        $view = view(self::$views . 'update');
        if (!empty($id)){
            $data = DB::table('exchange')->find($id);
            $view = $view->with('data',$data);
        }
        return $view;
    }

    /**
     * 编辑
     * post: /admin/exchange/doEdit
     */
    public function doEdit()
    {
        $id = Request::input('id');
        $title = Request::input('title');
        $desc = Request::input('desc');
        $stock = Request::input('stock');
        $price = Request::input('price')*1000;
        $img = Request::input('photo');
        $status = Request::input('status');
        if (empty($id)){
            $row = DB::table('exchange')->insert([
                'title' => $title,
                'desc' => $desc,
                'stock' => $stock,
                'price' => $price,
                'img' => $img,
                'status' => $status,
                'create_time' => time(),
            ]);
        } else {
            $row = DB::table('exchange')->where('id',$id)->update([
                'title' => $title,
                'desc' => $desc,
                'stock' => $stock,
                'price' => $price,
                'img' => $img,
                'status' => $status,
                'update_time' => time(),
            ]);
        }
        if (!$row)
            return "false";
        return "true";
    }

    /**
     * 删除
     * post: /admin/exchange/delete
     */
    public function delete()
    {
        $id = Request::input('id');
        $row = DB::table('exchange')->where('id',$id)->delete();
        if (!$row)
            return "false";
        return "true";
    }

    /**
     * 上传图片
     * post: /admin/gift/upload
     */
    public function upload()
    {
        $file = Request::file('file'); // 后去上传文件
        $dir = 'uploads/';//上传到的目录
        $file_ext = $file->getClientOriginalExtension();//获取上传文件的后缀名
        $file_name = time().rand(1000,9999).'.'.$file_ext;
        $file->move($dir,$file_name);//移动文件到指定目录
        $url = '/'.$dir.$file_name;
        return Response::json(['url' => $url]);
    }




}