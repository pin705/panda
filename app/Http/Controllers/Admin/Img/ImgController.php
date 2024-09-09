<?php
namespace App\Http\Controllers\Admin\Img;

use Request, Response, Session, Config, DB, Exception;
use Illuminate\Routing\Controller;

/**
 * Class VipcnController
 * @package App\Http\Controllers\Admin\Img
 */
class ImgController extends Controller
{
    static $views = 'admin.img.';

    /**
     * 首页
     * get: /admin/img/index
     */
    public function index()
    {
        $data = DB::table('p_img')->first();
        return view(self::$views . 'index')->with('data',$data);
    }

    /**
     * 编辑
     * post: /admin/img/doEdit
     */
    public function doEdit()
    {
        $id = Request::input('id');
        $wx = Request::input('wx');
        $zfb = Request::input('zfb');
        $customer = Request::input('customer');
        if (empty($id)){
            $row = DB::table('p_img')->insert([
                'wx' => $wx,
                'zfb' => $zfb,
                'customer' => $customer,
                'create_time' => time(),
            ]);
        } else {
            $row = DB::table('p_img')->where('id',$id)->update([
                'wx' => $wx,
                'zfb' => $zfb,
                'customer' => $customer,
                'update_time' => time(),
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