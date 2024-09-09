<?php
namespace App\Http\Controllers\Admin\Setting;

use Request, Response, Session, Config, DB, Exception;
use Illuminate\Routing\Controller;

/**
 * Class AgreementController
 * @package App\Http\Controllers\Admin\Setting
 */
class SettingController extends Controller
{
    static $views = 'admin.setting.';

    /**
     * 首页
     * get: /admin/setting/index
     */
    public function index()
    {
        $data = DB::table('p_setting')->first();
        return view(self::$views .'index')->with('data',$data);
    }

    /**
     * 编辑
     * post: /admin/setting/doEdit
     */
    public function doEdit()
    {
        $id = Request::input('id');
        $gold = Request::input('gold') * 100;
        if (empty($id)){
            $row = DB::table('p_setting')->insert([
                'gold' => $gold,
                'create_time' => time()
            ]);
        }else {
            $row = DB::table('p_setting')->where('id',$id)->update([
                'gold' => $gold,
                'update_time' => time()
            ]);
        }
        if (!$row)
            return "false";
        return "true";
    }


}

