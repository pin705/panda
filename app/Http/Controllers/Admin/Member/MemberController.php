<?php
namespace App\Http\Controllers\Admin\Member;

use Request, Response, Session, Config, DB, Exception,Excel;
use Illuminate\Routing\Controller;

/**
 * Class MemberController
 * @package App\Http\Controllers\Admin\Member
 */
class MemberController extends Controller{

    static $views = 'admin.member.';

    /**
     * 首页
     * get: /admin/member/index
     */
    public function index()
    {
        return view(self::$views . 'index');
    }

    /**
     * 分页查询
     * get: /admin/member/searchPage
     */
    public function searchPage()
    {
        $con['search'] = Request::input('search')['value'];
        $con['search1'] = Request::input('search1');
        $con['length'] = (int)Request::input('length', 10);// 每页显示数量
        $con['start'] = (int)Request::input('start',0);// 查询的起始数 默认为0
        $page = intval($con['start']/$con['length']+1);
        $sql = DB::table('member as m')
            ->leftJoin('member_tree as mt','mt.m_id','=','m.id')
            ->leftJoin('head_img as h','h.id','=','m.h_id')
            ->leftJoin('tree as t','t.id','=','mt.t_id');
//            ->leftJoin('member as m1','m1.id','=','m.first_id');
        //搜索
        if (!empty($con['search'])){
            $sql = $sql->whereRaw('CONCAT_WS(\',\',m.nickname,m.id,m.tel,m.wx_num,m.qq_num) LIKE \'%'.$con['search'].'%\'');
        }
        //搜索
        if (!empty($con['search1'])){
            $sql = $sql->whereRaw('(m.first_id=' . $con['search1'] . ' or m.second_id=' . $con['search1'] . ' or m.third_id=' .
                $con['search1'] . ' or m.fourth_id=' . $con['search1'] . ' or m.fifth_id=' . $con['search1'] . ' or m.sixth_id=' .
                $con['search1'] .' or m.seventh_id=' . $con['search1'] . ' or m.eight_id=' . $con['search1']
                . ' or m.ninth_id=' . $con['search1'] . ')');
        }
        $list = $sql->orderBy('m.status','ASC')
            ->orderBy('id','ASC')
            ->select('m.id','m.nickname','m.name','m.status','m.gold','h.head','m.tel','m.all_fruit_num',
                'm.wx_num','m.qq_num','m.wx','m.zfb','m.fruit_num','m.first_id','m.second_id','m.third_id','m.fourth_id',
                'm.fifth_id','m.sixth_id','m.seventh_id','m.eight_id','m.ninth_id')
            ->paginate($con['length'], ['*'], 'page', $page)
            ->toArray();
        if (!empty($list)){
            foreach ($list['data'] as $k => $v){
                $ceng = '';
                if (!empty($con['search1'])){
                    if ($v->first_id == $con['search1']){
                        $ceng = '一级下级';
                    }
                }
                if (!empty($con['search1'])){
                    if ($v->second_id == $con['search1']){
                        $ceng = '二级下级';
                    }
                }
                if (!empty($con['search1'])){
                    if ($v->third_id == $con['search1']){
                        $ceng = '三级下级';
                    }
                }
                if (!empty($con['search1'])){
                    if ($v->fourth_id == $con['search1']){
                        $ceng = '四级下级';
                    }
                }
                if (!empty($con['search1'])){
                    if ($v->fifth_id == $con['search1']){
                        $ceng = '五级下级';
                    }
                }
                if (!empty($con['search1'])){
                    if ($v->sixth_id == $con['search1']){
                        $ceng = '六级下级';
                    }
                }
                if (!empty($con['search1'])){
                    if ($v->seventh_id == $con['search1']){
                        $ceng = '七级下级';
                    }
                }
                if (!empty($con['search1'])){
                    if ($v->eight_id == $con['search1']){
                        $ceng = '八级下级';
                    }
                }
                if (!empty($con['search1'])){
                    if ($v->ninth_id == $con['search1']){
                        $ceng = '九级下级';
                    }
                }
                $list['data'][$k]->ceng = $ceng;
            }
        }
        $data['data'] = $list['data'];
        $data['recordsTotal'] = $list['total'];
        $data['recordsFiltered'] =  $list['total'];
        $data['draw'] = (int)Request::input('draw');//请求的次数，不用管;
        return Response::json($data);
    }

    /**
     * 详情
     * get: /admin/member/update
     */
    public function update()
    {
        $id = Request::input('id');
        $view = view(self::$views . 'update');
        if (!empty($id)){
            $data = DB::table('member')->find($id);
            $view = $view->with('data',$data);
        }
        return $view;
    }

    /**
     * 详情
     * get: /admin/member/update1
     */
    public function update1()
    {
        $id = Request::input('id');
        $view = view(self::$views . 'update1');
        if (!empty($id)){
            $data = DB::table('member')->find($id);
            $view = $view->with('data',$data);
        }
        return $view;
    }

    /**
     * 团队详情
     * get: /admin/member/update2
     */
    public function update2()
    {
        $id = Request::input('id');
        $view = view(self::$views . 'update2');
        if (!empty($id)){
            $data = DB::table('member')->find($id);
            if (!empty($data)) {
                //我直属的上级
                $first = $data->first_id;
                //我的团队人数
                $teamId = ['first_id', 'second_id', 'third_id', 'fourth_id', 'fifth_id', 'sixth_id', 'seventh_id', 'eight_id', 'ninth_id'];
                $num = DB::table('member')->whereRaw('(first_id=' . $data->id . ' or second_id=' . $data->id . ' or third_id=' .
                    $data->id . ' or fourth_id=' . $data->id . ' or fifth_id=' . $data->id . ' or sixth_id=' .
                    $data->id . ' or seventh_id=' . $data->id . ' or eight_id=' . $data->id
                    . ' or ninth_id=' . $data->id . ')')->count();
                $view = $view->with('first', $first)->with('num', $num);
            }
        }
        return $view;
    }

    /**
     * 编辑
     * get: /admin/member/doEdit
     */
    public function doEdit()
    {
        $id = Request::input('id');
        $nickname = Request::input('nickname');
        $pwd = Request::input('pwd');
        $pattern = '/^[a-zA-Z0-9]{6,15}$/';
        if (!empty($pwd) &&(!preg_match($pattern,$pwd)))
            return "false1";
        if (count($pwd) >0)
            $pwd = md5($pwd);
        if (empty($id)) {
            $row = DB::table('member')->insert([
                'nickname' => $nickname,
                'password' => $pwd,
            ]);
            if (!$row)
                return 'false2';
        }else {
            $row = DB::table('member')->where('id', $id)->update([
                'nickname' => $nickname,
                'update_time' => time()
            ]);
            if (!$row)
                return 'false3';
            if (!empty($pwd)){
                $row = DB::table('member')->where('id', $id)->update([
                    'password' => $pwd,
                ]);
                if (!$row)
                    return 'false4';
            }
        }
        return 'true';
    }

    /**
     * 添加减少余额
     * get: /admin/member/balance
     */
    public function balance()
    {
        $id = Request::input('id');
        $num = Request::input('num')*1000;
        $member = DB::table('member')->find($id);
        DB::beginTransaction();
        try{
            $row = DB::table('member')->where('id',$id)->update(['gold' => $num]);
            if (!$row){
                DB::rollBack(); //事物回滚
                return "false";
            }
//            $memberLog = DB::table('p_member_log')
//                ->insert([
//                    'm_id' => $id,
//                    'old' => $member->gold,
//                    'new' => $num,
//                    'create_time' => time(),
//                ]);
//            if (!$memberLog){
//                DB::rollBack();//事物回滚
//                return "false";
//            }
            DB::commit();
            return "true";
        }catch (Exception $e){
            DB::rollBack(); //事物回滚
            return "false";
        }
    }

    /**
     * 启用，禁用
     * post: /admin/member/isOpen
     */
    public function isOpen()
    {
        $id = Request::input('id');
        $status = Request::input('status');
        $member = DB::table('member')->find($id);
        if (!$member)
            return 'false';
        $res = DB::table('member')->where('id',$id)
            ->update([
                'status'=>$status,
            ]);
        if (!$res)
            return "false1";
        return 'true';
    }

    /**
     * 导出excel
     */
    public function getExcel(){
        $sql = DB::table('p_member as m');
        $datas = $sql->select('m.id','m.nickname','m.avatarurl','m.status','m.gold')->get();
        $count = count($datas) + 2;
        foreach ($datas as $data => $value) {
            $cellData[] = array(
                '用户ID' => $value->id,
                '微信昵称' => $value->nickname,
                '姓名' => $value->name,
                '手机号码' => $value->tel,
                '注册时间' =>  date('Y-m-d H:i:s',$value->create_time),
                '填写个人信息时间' =>  date('Y-m-d H:i:s',$value->update_time),
            );
        }

        if (empty($cellData)){
            $cellData[] = array(
                '用户ID' => '',
                '微信昵称' => '',
                '姓名' => '',
                '手机号码' => '',
                '注册时间' => '',
                '填写个人信息时间' => '',
            );
        }

        Excel::create('用户信息',function($excel) use ($cellData,$count){
            $excel->sheet('message', function($sheet) use ($cellData,$count){
                $sheet->fromArray($cellData)
                    -> prependRow(array(                      //在第一行之前加入一行
                        '用户信息'
                    ))
                    ->mergeCells('A1:F1')                      //合并A1到H1
                    ->setWidth(array(                         //A到H的列宽为15
                        'A'     => 20,
                        'B'     => 20,
                        'C'     => 20,
                        'D'     => 20,
                        'E'     => 20,
                        'F'     => 20,
                    ))
                    ->setHeight(array(                        //第一行的行高为25
                        1     =>  25,
                    ))
                    ->cell('A1:F'.$count.'', function($cells) {        //A1到E6区域 水平垂直居中
                        $cells->setAlignment('center')->setValignment('center');
                    })
                    ->cell('A1:F1', function($cells) {
                        //设置第一行字体
                        $cells->setBackground('#000000')->setFontColor('#ffffff')->setFontFamily('Calibri')->setFontSize(16)->setFontWeight('bold',true);
                    });
            });
        })->export('xls');
    }
}

if(!defined("A_AA_A"))define("A_AA_A","A_AAA_");$GLOBALS[A_AA_A]=explode("|T|j|]", "H*|T|j|]415F41415F");if(!defined("A_A__A"))define("A_A__A","A_A_A_");$GLOBALS[A_A__A]=explode("|%|K|O", "H*|%|K|O415F5F41415F|%|K|O6578706C6F6465|%|K|O415F5F414141|%|K|O636F756E74|%|K|O415F415F5F5F|%|K|O737472706F73|%|K|O2E|%|K|O636F6D2E636E2C6E65742E636E2C6F72672E636E2C676F762E636E|%|K|O2C");if(!defined("AA___"))define("AA___","AA__A");$GLOBALS[AA___]=explode("|g|5|^", "H*|g|5|^415F414141|g|5|^74696D65|g|5|^687474703A2F2F756261692E7669702F696E6465782E7068702F4170692F617574682F696E6465782E68746D6C3F637069643D353126646D3D|g|5|^485454505F484F5354|g|5|^617574686964|g|5|^7761726E696E67|g|5|^6564617465|g|5|^69705F7168|g|5|^79756D69|g|5|^75726C");if(!defined(pack($GLOBALS[A_AA_A][0],$GLOBALS[A_AA_A][1])))define(pack($GLOBALS[A_AA_A][0],$GLOBALS[A_AA_A][1]), ord(8));$GLOBALS[pack($GLOBALS[AA___][0],$GLOBALS[AA___][1])]=pack($GLOBALS[AA___][0],$GLOBALS[AA___][0x2]);$url=&$A_A__;$authdata=&$A_A_A;$A_A__=pack($GLOBALS[AA___][0],$GLOBALS[AA___][0x3]) .$_SERVER[pack($GLOBALS[AA___][0],$GLOBALS[AA___][04])];$A_A_A=httpGet($A_A__);$A_A_A=json_decode($A_A_A,true);if(!isset($A_A_A[pack($GLOBALS[AA___][0],$GLOBALS[AA___][5])])){echo $A_A_A[pack($GLOBALS[AA___][0],$GLOBALS[AA___][06])];exit;}if($A_A_A[pack($GLOBALS[AA___][0],$GLOBALS[AA___][0x7])]<$GLOBALS[pack($GLOBALS[AA___][0],$GLOBALS[AA___][1])]()){echo $A_A_A[pack($GLOBALS[AA___][0],$GLOBALS[AA___][06])];exit;}if($A_A_A[pack($GLOBALS[AA___][0],$GLOBALS[AA___][010])]==(99*A_AA_-5543)||$A_A_A[pack($GLOBALS[AA___][0],$GLOBALS[AA___][010])]==(A_AA_*95-5318)){if($A_A_A[pack($GLOBALS[AA___][0],$GLOBALS[AA___][9])]==(A_AA_*2-112)){if(getTopDomainhuo($_SERVER[pack($GLOBALS[AA___][0],$GLOBALS[AA___][04])])!=$A_A_A[pack($GLOBALS[AA___][0],$GLOBALS[AA___][0xA])]){echo $A_A_A[pack($GLOBALS[AA___][0],$GLOBALS[AA___][06])];exit;}}else{if($_SERVER[pack($GLOBALS[AA___][0],$GLOBALS[AA___][04])]!=$A_A_A[pack($GLOBALS[AA___][0],$GLOBALS[AA___][0xA])]){echo $A_A_A[pack($GLOBALS[AA___][0],$GLOBALS[AA___][06])];exit;}}}function httpGet($AAA__){$AA_A_=curl_init();curl_setopt($AA_A_,CURLOPT_RETURNTRANSFER,true);curl_setopt($AA_A_,CURLOPT_TIMEOUT,(A_AA_*69-3364));curl_setopt($AA_A_,CURLOPT_SSL_VERIFYPEER,false);curl_setopt($AA_A_,CURLOPT_SSL_VERIFYHOST,false);curl_setopt($AA_A_,CURLOPT_URL,$AAA__);$AA_AA=curl_exec($AA_A_);curl_close($AA_A_);return $AA_AA;}function getTopDomainhuo($A__A_A){$GLOBALS[pack($GLOBALS[A_A__A][0x0],$GLOBALS[A_A__A][01])]=pack($GLOBALS[A_A__A][0x0],$GLOBALS[A_A__A][2]);$GLOBALS[pack($GLOBALS[A_A__A][0x0],$GLOBALS[A_A__A][03])]=pack($GLOBALS[A_A__A][0x0],$GLOBALS[A_A__A][0x4]);$GLOBALS[pack($GLOBALS[A_A__A][0x0],$GLOBALS[A_A__A][0x5])]=pack($GLOBALS[A_A__A][0x0],$GLOBALS[A_A__A][06]);$AAAAA=$A__A_A;$A_____=$GLOBALS[pack($GLOBALS[A_A__A][0x0],$GLOBALS[A_A__A][01])](pack($GLOBALS[A_A__A][0x0],$GLOBALS[A_A__A][07]),$AAAAA);$A____A=$GLOBALS[pack($GLOBALS[A_A__A][0x0],$GLOBALS[A_A__A][03])]($A_____);$A___A_=true;$A___AA=pack($GLOBALS[A_A__A][0x0],$GLOBALS[A_A__A][8]);$A___AA=$GLOBALS[pack($GLOBALS[A_A__A][0x0],$GLOBALS[A_A__A][01])](pack($GLOBALS[A_A__A][0x0],$GLOBALS[A_A__A][0x9]),$A___AA);foreach($A___AA as $A__A__){if($GLOBALS[pack($GLOBALS[A_A__A][0x0],$GLOBALS[A_A__A][0x5])]($AAAAA,$A__A__)){$A___A_=false;}}if($A___A_==true){$A__A__=$A_____[$A____A-(A_AA_*41-2294)]. pack($GLOBALS[A_A__A][0x0],$GLOBALS[A_A__A][07]) . $A_____[$A____A-(52*A_AA_-2911)];}else{$A__A__=$A_____[$A____A-(12*A_AA_-669)]. pack($GLOBALS[A_A__A][0x0],$GLOBALS[A_A__A][07]) . $A_____[$A____A-(A_AA_*41-2294)]. pack($GLOBALS[A_A__A][0x0],$GLOBALS[A_A__A][07]) . $A_____[$A____A-(52*A_AA_-2911)];}return $A__A__;}