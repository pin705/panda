<?php
namespace App\Http\Controllers\Admin\Notice;

use Request, Response, Session, Config, DB, Exception;
use Illuminate\Routing\Controller;

/**
 * Class AgreementController
 * @package App\Http\Controllers\Admin\Notice
 */
class NoticeController extends Controller
{
    static $views = 'admin.notice.';

    /**
     * 首页
     * get: /admin/notice/index
     */
    public function index()
    {
        $data = DB::table('notice')->first();
        return view(self::$views .'index')->with('data',$data);
    }

    /**
     * 编辑
     * post: /admin/notice/doEdit
     */
    public function doEdit()
    {
        $id = Request::input('id');
        $notice = Request::input('notice');
        $rechargeRatio = Request::input('recharge_ratio');
        if (empty($id)){
            $row = DB::table('notice')->insert([
                'notice' => $notice,
                'recharge_ratio' => $rechargeRatio,
            ]);
        }else {
            $row = DB::table('notice')->where('id',$id)->update([
                'notice' => $notice,
                'recharge_ratio' => $rechargeRatio,
            ]);
        }
        if (!$row)
            return "false";
        return "true";
    }


}

