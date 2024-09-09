<?php
namespace App\Http\Controllers\Admin\Customer;

use Request, Response, Session, Config, DB, Exception;
use Illuminate\Routing\Controller;

/**
 * Class AgreementController
 * @package App\Http\Controllers\Admin\Customer
 */
class CustomerController extends Controller
{
    static $views = 'admin.customer.';

    /**
     * 首页
     * get: /admin/customer/index
     */
    public function index()
    {
        $data = DB::table('customer')->first();
        return view(self::$views .'index')->with('data',$data);
    }

    /**
     * 编辑
     * post: /admin/customer/doEdit
     */
    public function doEdit()
    {
        $id = Request::input('id');
        $img = Request::input('img');
        if (empty($id)){
            $row = DB::table('customer')->insert([
                'img' => $img,
            ]);
        }else {
            $row = DB::table('customer')->where('id',$id)->update([
                'img' => $img,
            ]);
        }
        if (!$row)
            return "false";
        return "true";
    }

    /**
     * 上传图片
     * post: /admin/img/upload
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

