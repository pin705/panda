<?php
namespace App\Http\Controllers\Admin\Deal;

use Request, Response, Session, Config, DB, Exception;
use Illuminate\Routing\Controller;

/**
 * Class CodeController
 * @package App\Http\Controllers\Admin\Deal
 */
class DealController extends Controller
{
    static $views = 'admin.deal.';

    /**
     * 首页
     * get: /admin/code/index
     */
    public function index()
    {
        $data = DB::table('fruit_price')->first();
        return view(self::$views . 'index')->with('data',$data);
    }

    /**
     * 编辑
     * post: /admin/code/doEdit
     */
    public function doEdit()
    {
        $id = Request::input('id');
        $buy = Request::input('buy')*1000;
        $sell = Request::input('sell')*1000;
        if (empty($id)){
            $row = DB::table('fruit_price')->insert([
                'buy' => $buy,
                'sell' => $sell,
                'create_time' => time(),
            ]);
        } else {
            $row = DB::table('fruit_price')->where('id',$id)->update([
                'buy' => $buy,
                'sell' => $sell,
                'update_time' => time(),
            ]);
        }
        if (!$row)
            return "false";
        return "true";
    }


}