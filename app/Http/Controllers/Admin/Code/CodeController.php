<?php
namespace App\Http\Controllers\Admin\Code;

use Request, Response, Session, Config, DB, Exception;
use Illuminate\Routing\Controller;

/**
 * Class CodeController
 * @package App\Http\Controllers\Admin\Code
 */
class CodeController extends Controller
{
    static $views = 'admin.code.';

    /**
     * 首页
     * get: /admin/code/index
     */
    public function index()
    {
        $data = DB::table('qrcode')->first();
        return view(self::$views . 'index')->with('data',$data);
    }

    /**
     * 编辑
     * post: /admin/code/doEdit
     */
    public function doEdit()
    {
        $id = Request::input('id');
        $size = Request::input('size');
        $offsetX = Request::input('offset_x');
        $offsetY = Request::input('offset_y');
        $image = Request::input('photo');
        if (empty($id)){
            $row = DB::table('qrcode')->insert([
                'size' => $size,
                'offset_x' => $offsetX,
                'offset_y' => $offsetY,
                'img' => $image,
                'create_time' => time(),
            ]);
        } else {
            $row = DB::table('qrcode')->where('id',$id)->update([
                'size' => $size,
                'offset_x' => $offsetX,
                'offset_y' => $offsetY,
                'img' => $image,
                'update_time' => time(),
            ]);
        }
        if (!$row)
            return "false";
        return "true";
    }

    /**
     * 上传图片
     * post: /admin/code/upload
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