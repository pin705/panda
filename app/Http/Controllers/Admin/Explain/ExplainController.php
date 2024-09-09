<?php
namespace App\Http\Controllers\Admin\Explain;

use Request, Response, Session, Config, DB, Exception;
use Illuminate\Routing\Controller;

/**
 * Class AgreementController
 * @package App\Http\Controllers\Admin\Explain
 */
class ExplainController extends Controller
{
    static $views = 'admin.explain.';

    /**
     * 首页
     * get: /admin/explain/index
     */
    public function index()
    {
        $data = DB::table('explain')->first();
        return view(self::$views .'index')->with('data',$data);
    }

    /**
     * 编辑
     * post: /admin/explain/doEdit
     */
    public function doEdit()
    {
        $id = Request::input('id');
//        $person = Request::input('person');
//        $direct = Request::input('direct');
//        $team = Request::input('team');
//        $profit = Request::input('profit');
        $person = Request::input('person_img');
        $direct = Request::input('direct_img');
        $team = Request::input('team_img');
        $profit = Request::input('profit_img');
        $other = Request::input('other_img');
        if (empty($id)){
            $row = DB::table('explain')->insert([
//                'person' => $person,
//                'direct' => $direct,
//                'team' => $team,
//                'profit' => $profit,
                'person_img' => $person,
                'direct_img' => $direct,
                'team_img' => $team,
                'profit_img' => $profit,
                'other_img' => $other,
                'create_time' => time()
            ]);
        }else {
            $row = DB::table('explain')->where('id',$id)->update([
                'person_img' => $person,
                'direct_img' => $direct,
                'team_img' => $team,
                'profit_img' => $profit,
                'other_img' => $other,
                'update_time' => time()
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

