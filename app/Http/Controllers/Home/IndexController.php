<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Config, DB, Response, Exception, Request, Session, QrCode;
use function Couchbase\defaultDecoder;
use EasyWeChat\Factory;
use Illuminate\Auth\DatabaseUserProvider;
use Illuminate\Cache\RetrievesMultipleKeys;
use function PHPSTORM_META\elementType;

class IndexController extends Controller
{
    /**
     * 注册路由
     * get: /home/logonUrl
     */
    public function logonUrl()
    {
        return view('home1.index');
    }

    /**
     * 登录
     * post: /home/login
     * @param : tel(账号)
     * @param : pwd(密码)
     */
    public function login()
    {
        $tel = Request::input('tel');
        $pwd = Request::input('pwd');
        if (empty($tel) || empty($pwd))
            return Response::json([
                'status' => 3,
                'info' => '请输入账号密码'
            ]);
        $pwd = md5($pwd);//加密
        //查询用户信息
        $member = DB::table('member')->where('tel', $tel)->first(['id', 'password', 'status']);
        if (empty($member))
            return Response::json([
                'status' => 3,
                'info' => '用户不存在'
            ]);
        if ($member->status != 1)
            return Response::json([
                'status' => 3,
                'info' => '用户已被封禁，请联系客服'
            ]);
        if ($pwd != $member->password)
            return Response::json([
                'status' => 3,
                'info' => '密码不正确'
            ]);
        $token = $this->genToken();
        $memberToken = DB::table('member')->where('id', $member->id)->update(['token' => $token]);
        if (!$memberToken)
            return Response::json([
                'status' => 2,
                'info' => '登录失败'
            ]);
        return Response::json([
            'status' => 1,
            'info' => '登录成功',
            'token' => $token
        ]);
    }

    /**
     * token
     */
    function genToken($len = 32, $md5 = true)
    {
        # Seed random number generator
        # Only needed for PHP versions prior to 4.2
        mt_srand((double)microtime() * 1000000);
        # Array of characters, adjust as desired
        $chars = array(
            'Q', '@', '8', 'y', '%', '^', '5', 'Z', '(', 'G', '_', 'O', '`',
            'S', '-', 'N', '<', 'D', '{', '}', '[', ']', 'h', ';', 'W', '.',
            '/', '|', ':', '1', 'E', 'L', '4', '&', '6', '7', '#', '9', 'a',
            'A', 'b', 'B', '~', 'C', 'd', '>', 'e', '2', 'f', 'P', 'g', ')',
            '?', 'H', 'i', 'X', 'U', 'J', 'k', 'r', 'l', '3', 't', 'M', 'n',
            '=', 'o', '+', 'p', 'F', 'q', '!', 'K', 'R', 's', 'c', 'm', 'T',
            'v', 'j', 'u', 'V', 'w', ',', 'x', 'I', '$', 'Y', 'z', '*'
        );
        # Array indice friendly number of chars;
        $numChars = count($chars) - 1;
        $token = '';
        # Create random token at the specified length
        for ($i = 0; $i < $len; $i++)
            $token .= $chars[mt_rand(0, $numChars)];
        # Should token be run through md5?
        if ($md5) {
            # Number of 32 char chunks
            $chunks = ceil(strlen($token) / 32);
            $md5token = '';
            # Run each chunk through md5
            for ($i = 1; $i <= $chunks; $i++)
                $md5token .= md5(substr($token, $i * 32 - 32, 32));
            # Trim the token
            $token = substr($md5token, 0, $len);
        }
        return $token;
    }

    /**
     * 退出
     * post: /home/logout
     */
    public function logout()
    {
        $mid = Request::get('mid');
        $token = $this->genToken();
        $member = DB::table('member')->where('id', $mid)->update(['token' => $token]);
        if (!$member)
            return Response::json([
                'status' => 2,
                'info' => '退出失败'
            ]);
        return Response::json([
            'status' => 1,
            'info' => '退出成功'
        ]);
    }

    /**
     * 注册 下载更 多资源  ww w. zg ym w.com
     * post: /home/logon
     * @param : up_id(上级id)
     * @param : tel(手机账号)
     * @param : name(真实姓名)
     * @param : nickname(游戏昵称)
     * @param : pwd(密码)
     * @param : r_pwd(确认密码)
     * @param : code(确认密码)
     */
    public function logon()
    {
        $upId = Request::input('up_id');
        $tel = Request::input('tel');
        $name = Request::input('name');
        $nickname = Request::input('nickname');
        $pwd = Request::input('pwd');
        $rPwd = Request::input('r_pwd');
        $code = Request::input('code');
        if (empty($tel) || empty($name) || empty($nickname) || empty($pwd) || empty($rPwd))
            return Response::json([
                'status' => 3,
                'info' => '请输入注册信息'
            ]);
        if ($pwd != $rPwd)
            return Response::json([
                'status' => 3,
                'info' => '两次密码不一致'
            ]);
        unset($rPwd);//删除重复密码
        $pwd = md5($pwd); //密码加密
        $firstId = 0; //一级
        $secondId = 0; //二级
        $thirdId = 0; //三级
        $fourthId = 0; //四级
        $fifthId = 0; //五级
        $sixId = 0; //六级
        $sevenId = 0; //七级
        $eightId = 0; //八级
        $nineId = 0; //九级
        $time = time(); //服务器时间
        if (empty($upId))
            $upId = 10499;
        if (!empty($upId)) {
            $upMember = DB::table('member')->where('id', $upId)->where('status', 1)->first();
            if (empty($upMember))
                return Response::json([
                    'status' => 3,
                    'info' => '注册链接有误'
                ]);
            $firstId = $upMember->id; //一级
            $secondId = $upMember->first_id; //二级
            $thirdId = $upMember->second_id; //三级
            $fourthId = $upMember->third_id; //四级
            $fifthId = $upMember->fourth_id; //五级
            $sixId = $upMember->fifth_id; //六级
            $sevenId = $upMember->sixth_id; //七级
            $eightId = $upMember->seventh_id; //八级
            $nineId = $upMember->eight_id; //九级
        }
        //查询手机号是否重复
        $memberTel = DB::table('member')->where('tel', $tel)->first(['id']);
        if (!empty($memberTel))
            return Response::json([
                'status' => 3,
                'info' => '手机号已被注册'
            ]);
        //短息验证码有效期
        $telCode = DB::table('tel_code')->where('tel', $tel)->where('code', $code)->first(['id', 'deadline']);
        if (empty($telCode))
            return Response::json([
                'status' => 3,
                'info' => '短信验证码有误'
            ]);
        if ($telCode->deadline < $time)
            return Response::json([
                'status' => 3,
                'info' => '验证码过期,请重新发送'
            ]);
        DB::beginTransaction(); //开启事物
        try {
            if (!empty($upId)) {
                $upMember = DB::table('member')->where('id', $upId)->where('status', 1)->first();
                if (empty($upMember)) {
                    return Response::json([
                        'status' => 3,
                        'info' => '注册链接有误'
                    ]);
                }
            }
            //头像
            $headImg = DB::table('head_img')->first();
            //插入数据
            $memberInsertId = DB::table('member')
                ->insertGetId([
                    'tel' => $tel,
                    'password' => $pwd,
                    'nickname' => $nickname,
                    'name' => $name,
                    'h_id' => $headImg->id,
                    'create_time' => $time,
                    'first_id' => $firstId,
                    'second_id' => $secondId,
                    'third_id' => $thirdId,
                    'fourth_id' => $fourthId,
                    'fifth_id' => $fifthId,
                    'sixth_id' => $sixId,
                    'seventh_id' => $sevenId,
                    'eight_id' => $eightId,
                    'ninth_id' => $nineId,
                ]);
            if (!$memberInsertId) {
                DB::rollBack();
                return Response::json([
                    'status' => 2,
                    'info' => '添加失败'
                ]);
            }
            //member_tree
            $memberTree = DB::table('member_tree')
                ->insert([
                    'm_id' => $memberInsertId,
                    't_id' => 1,
                    'lv_land' => 1,
                    'create_time' => time()
                ]);
            if (!$memberTree) {
                DB::rollBack();
                return Response::json([
                    'status' => 2,
                    'info' => '添加失败'
                ]);
            }
            DB::commit();
            return Response::json([
                'status' => 1,
                'info' => '注册成功'
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json([
                'status' => 2,
                'info' => '注册失败'
            ]);
        }
    }

    /**
     * 获取验证码接口
     * post: /home/code
     * @param : tel(手机号)
     */
    public function code(Request $request)
    {
        $tel = Request::input('tel');
        if (!empty($account)) {
            //查询手机
            $memberTel = DB::table('member')->where('tel', $tel)->first();//
            if (!empty($memberTel)) {
                $tel = $memberTel->tel;
            }
        }
        if (isset($tel)) {
            $yzm = mt_rand(1000, 9999);
            $url = config('api.SMS_URL');
            $url .= '&mobile=' . $tel . '&xh=&content={"code":"' . $yzm . '"}';
            $data = [
                'tel' => $tel,
                'code' => $yzm,
                'deadline' => time() + 182,
            ];
            //添加记录
            $row = DB::table('tel_code')->insert($data);
            if ($row) {
                $repon = $this->_httpClient($url);
                $repon = json_decode($repon);
                if ($repon->stat === '100') {
                    $msg = ['msg' => '发送成功', 'code' => 1];
                } else {
                    $msg = ['msg' => '发送失败', 'code' => 2];
                }
            }
        } else {
            $msg = ['msg' => '手机号码为空', 'code' => 3];
        }
        return response()->json($msg);
    }

    // POST方式访问接口
    private function _httpClient($data)
    {
        if (function_exists('file_get_contents')) {
            $file_contents = file_get_contents($data);
        } else {
            $ch = curl_init();
            $timeout = 5;
            curl_setopt($ch, CURLOPT_URL, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            $file_contents = curl_exec($ch);
            curl_close($ch);
        }
        return $file_contents;
    }

    /**
     * 找回密码
     * post: /home/backPwd
     * @param : tel(手机号)
     * @param : code(短信验证码)
     * @param : pwd(密码)
     * @param : r_pwd(确认密码)
     */
    public function backPwd(Request $request)
    {
        $tel = Request::input('tel');//参数：手机号
        $code = Request::input('code');//参数：手机验证码
        $pwd = Request::input('pwd');//参数：密码
        $rPwd = Request::input('r_pwd');//参数：确认密码
        if (empty($tel) || empty($code) || empty($pwd) || empty($rPwd))
            return Response::json([
                'status' => 3,
                'info' => '请输入账号或密码'
            ]);
        if ($pwd != $rPwd)
            return Response::json([
                'status' => 3,
                'info' => '两次密码不一致'
            ]);
        unset($rPwd); //删除确认密码
        $pwd = md5($pwd);
        $member = DB::table('member')->where('tel', $tel)
            ->where('status', 1)->first(['id', 'password']);
        if (empty($member))
            return Response::json([
                'status' => 3,
                'info' => '用户不存在'
            ]);
        if ($pwd == $member->password)
            return Response::json([
                'status' => 3,
                'info' => '与原密码一致',
            ]);
        $telCode = DB::table('tel_code')->where('tel', $tel)->where('code', $code)->first(['id', 'deadline']);
        if (empty($telCode))
            return Response::json([
                'status' => 3,
                'info' => '验证码错误'
            ]);
        if ($telCode->deadline < time())
            return Response::json([
                'status' => 3,
                'info' => '证码已过期，请重新发送'
            ]);
        try {
            $row = DB::table('member')->where('id', $member->id)->update([
                'password' => $pwd
            ]);
            if (!$row) {
                DB::rollBack();
                return Response::json([
                    'status' => 2,
                    'info' => '修改失败'
                ]);
            }
            $row = DB::table('tel_code')->where('id', $telCode->id)->delete();
            if (!$row) {
                DB::rollBack();
                if (!$row) {
                    DB::rollBack();
                    return Response::json([
                        'status' => 2,
                        'info' => '修改失败'
                    ]);
                }
            }
            DB::commit();
            return Response::json([
                'status' => 1,
                'info' => '修改成功'
            ]);
        } catch (Exception $exception) {
            DB::rollBack();
            return Response::json([
                'status' => 2,
                'info' => '修改失败'
            ]);
        }
    }

    /**
     * 首页
     */
    public function index()
    {
        return view('home.index');
    }

    /**
     * 用户信息
     * post: /home/getMember
     */
    public function getMember()
    {
        $memberId = Request::get('mid');
        $member = DB::table('member as m')
            ->leftJoin('member_tree as mt', 'mt.m_id', '=', 'm.id')
            ->leftJoin('head_img as h', 'h.id', '=', 'm.h_id')
            ->leftJoin('tree as t', 't.id', '=', 'mt.t_id')
            ->where('m.id', $memberId)
            ->first(['m.id', 'm.nickname', 'm.fruit_num', 'm.gold', 't.lv', 't.id as t_id', 'mt.lv_land', 'h.head', 'm.wx_num',
                'm.qq_num', 'm.wx', 'm.zfb', 't.recycle']);
        if (!empty($member)) {
            $member->fruit_num = round($member->fruit_num / 1000, 3);
            $member->gold = round($member->gold / 1000, 3);
            //市场鲜果
            $platform = DB::table('platform')->first(['fruit_count']);
            if (!empty($platform))
                $member->fruit_count = $platform->fruit_count <= 0 ? 0 : round($platform->fruit_count / 1000, 3);
            //显示土地升级按钮
            $arrLand = ['50', '150', '300', '500', '750', '1000', '3000'];
            $lvLand = $member->lv_land; //当前土地等级
            if ($lvLand > 7) {
                $member->upgrade_land = 2;
            } else {
                if (($member->fruit_num * 1000 > ($arrLand[$lvLand - 1] * 1000))) {
                    $member->upgrade_land = 1;
                } else {
                    $member->upgrade_land = 2;
                }
            }
            //显示果树升级按钮
            $arrFruit = ['50', '150', '300', '500', '750', '1000', '3000'];
            $lvFruit = $member->lv; //当前果树等级
            if ($lvFruit > 7) {
                $member->upgrade_fruit_tree = 2;
            } else {
                if (($member->fruit_num * 1000 > ($arrFruit[$lvFruit - 1] * 1000)))
                    $member->upgrade_fruit_tree = 1;
                else
                    $member->upgrade_fruit_tree = 2;
            }
            //市场分红
            if ($member->t_id <= 7) {
                $member->market_per = '市场分红0%';
            } elseif (($member->t_id > 7) && ($member->t_id <= 13)) {
                $member->market_per = '市场分红0.1%';
            } elseif ($member->t_id == 14) {
                $member->market_per = '市场分红0.5%';
            } else {
                $member->market_per = '市场分红1%';
            }
            $arrFirst = ['1', '3', '5', '8', '12', '16', '21', '0', '25', '25', '25', '25', '25', '30', '30']; //直推贡献提成 百分比
            $member->deirect_per = '直推分红' . $arrFirst[$member->t_id - 1] . '%';
            $arrTeam = ['0.5', '1', '1.5', '2', '2.5', '3', '3.5', '0', '4', '4', '4', '4', '4', '4.5', '5']; //直推贡献提成 百分比
            $member->team_per = '团队分红' . $arrTeam[$member->t_id - 1] . '%';
        } //end if
        return Response::json($member);
    }

    /**
     * 公告
     * post: /home/notice
     */
    public function notice()
    {
        $notice = DB::table('notice')->first(['notice', 'recharge_ratio']);
        return Response::json($notice);
    }

    /**
     * 客服
     * post: /home/customer
     */
    public function customer()
    {
        $customer = DB::table('customer')->first(['img']);
        return Response::json($customer);
    }

    /**
     * 排行榜
     * post: /home/rank
     */
    public function rank()
    {
        $list = DB::table('member as m')
            ->leftJoin('member_tree as f', 'f.m_id', '=', 'm.id')
            ->leftJoin('tree as t', 't.id', '=', 'f.t_id')
            ->leftJoin('head_img as h', 'h.id', '=', 'm.h_id')
            ->orderBy('m.all_fruit_num', 'DESC')
            ->limit(20)
            ->get(['h.head', 'm.id', 'm.nickname', 't.name', 'm.all_fruit_num as num']);
        if (!empty($list)) {
            foreach ($list as $k => $v) {
                $list[$k]->num = round($v->num / 1000, 2);
            }
        }
        return Response::json($list);
    }

    /**
     * 收益说明
     * post: /home/explain
     */
    public function explain()
    {
        $row = DB::table('explain')->first(['person_img', 'direct_img', 'team_img', 'profit_img', 'other_img']);
        return Response::json($row);
    }

    /**
     * 充值类型
     * post: /home/rechargeList
     */
    public function rechargeList()
    {
        $list = DB::table('recharge')->get(['id', 'title', 'price', 'gold']);
        if (!empty($list)) {
            foreach ($list as $k => $v) {
                $list[$k]->price = round($v->price / 1000, 3);
                $list[$k]->gold = round($v->gold / 1000, 3);
            }
        }
        return Response::json($list);
    }

    /**
     * 充值记录
     * post: /home/rechargeLog
     */
    public function rechargeLog()
    {
        $memberId = Request::get('mid');
        $rechargeOrderLog = DB::table('recharge_order as o')
            ->leftJoin('member as m', 'm.id', '=', 'o.m_id')
            ->where('m.id', $memberId)
            ->where('o.status', 1)
            ->orderBy('o.create_time', 'DESC')
            ->get(['m.id', 'o.price', 'o.status',
                DB::raw('FROM_UNIXTIME(o.update_time,\'%Y/%m/%d %H:%i\') as update_date')]);
        if (!empty($rechargeOrderLog)) {
            foreach ($rechargeOrderLog as $k => $v) {
                $rechargeOrderLog[$k]->price = round($v->price / 1000, 3);
                $rechargeOrderLog[$k]->status = $v->status == 1 ? "已到账" : "未到账";
            }
        }
        return Response::json($rechargeOrderLog);
    }

    /**
     * 1.9 第三方支付
     * post: /pay
     */
    public function pay()
    {
        $memberId = Request::input('mid');
        $id = Request::input('id');
        if (empty($memberId) || empty($id)) {
            return "<span style='font-size: 100px'>参数不全</span>";
        }
        $recharge = DB::table('recharge')->find($id);
//        $WIDout_trade_no = time() . rand(1000, 9999);
//        $WIDtotal_fee = $recharge->price / 100;
//        $WIDsubject = $recharge->name;
        //生成订单
        $id = DB::table('recharge_order')
            ->insertGetId([
                'm_id' => $memberId,
                'r_id' => $recharge->id,
                'price' => $recharge->price,
                'gold' => $recharge->gold,
                'create_time' => time(),
            ]);
        if ($id <= 0) {
            return "<span style='font-size: 100px'>操作失败</span>";
        }

//        $notify_url = \Config::get('custom.BasePath') . "/notify";
//        $return_url = \Config::get('custom.BasePath') . "/game/seafood/index";
//        //需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/
//        //商户订单号
//        $out_trade_no = $WIDout_trade_no;
//        //商户网站订单系统中唯一订单号，必填
//        //支付方式
//        $type = 'wxpay';
//        //商品名称
//        $name = $WIDsubject;
//        //付款金额
//        $money = $WIDtotal_fee;
//        //站点名称
//        $sitename = '支付站点';
//        //必填
//
//        //订单描述
//
//
//        /************************************************************/
//        $alipay_config = $this->init();
////构造要请求的参数数组，无需改动
//        $parameter = array(
//            "pid" => trim($alipay_config['partner']),
//            "type" => $type,
//            "notify_url" => $notify_url,
//            "return_url" => $return_url,
//            "out_trade_no" => $out_trade_no,
//            "name" => $name,
//            "money" => $money,
//            "sitename" => $sitename
//        );
        $codepay_id = 410133;
        $codepay_key = 'fQtjZodzFkt4HATimNNFzU8HJx3VKvSz';
        $price = $recharge->price / 1000;
        $notify_url = \Config::get('custom.BasePath') . '/home/notify';
        $return_url = \Config::get('custom.BasePath') . '/home/index';

        $url = $this->createSign($codepay_id, $codepay_key, $id, $price, $notify_url, $return_url);
        return "<script>window.location.href='" . $url . "'</script>";
//        return view('game.seafood.form')->with('WIDsubject', $WIDsubject)
//            ->with('WIDout_trade_no', $WIDout_trade_no)->with('WIDtotal_fee', $WIDtotal_fee)->with('id', $id);
    }

    function createSign($codepay_id, $codepay_key, $id, $price, $notify_url, $return_url)
    {
        $data = array(
            "id" => $codepay_id,//你的码支付ID
            "pay_id" => $id, //唯一标识 可以是用户ID,用户名,session_id(),订单ID,ip 付款后返回
            "type" => 3,//1支付宝支付 3微信支付 2QQ钱包
            "price" => $price,//金额100元
            "param" => "",//自定义参数
            "notify_url" => $notify_url,//通知地址
            "return_url" => $return_url,//跳转地址
        ); //构造需要传递的参数

        ksort($data); //重新排序$data数组
        reset($data); //内部指针指向数组中的第一个元素

        $sign = ''; //初始化需要签名的字符为空
        $urls = ''; //初始化URL参数为空

        foreach ($data AS $key => $val) { //遍历需要传递的参数
            if ($val == '' || $key == 'sign') continue; //跳过这些不参数签名
            if ($sign != '') { //后面追加&拼接URL
                $sign .= "&";
                $urls .= "&";
            }
            $sign .= "$key=$val"; //拼接为url参数形式
            $urls .= "$key=" . urlencode($val); //拼接为url参数形式并URL编码参数值

        }
        $query = $urls . '&sign=' . md5($sign . $codepay_key); //创建订单所需的参数
        $url = "https://codepay.fateqq.com/creat_order/?{$query}"; //支付页面
        return $url;
//        header("Location:{$url}"); //跳转到支付页面
    }

    /**
     * post: /notify
     */
    public function notify()
    {
        $codepay_key = 'fQtjZodzFkt4HATimNNFzU8HJx3VKvSz';
        ksort($_POST); //排序post参数
        reset($_POST); //内部指针指向数组中的第一个元素
        $sign = '';
        foreach ($_POST AS $key => $val) {
            if ($val == '') continue; //跳过空值
            if ($key != 'sign') { //跳过sign
                $sign .= "$key=$val&"; //拼接为url参数形式
            }
        }
//        DB::table('recharge_order')->where('id',2)
//            ->update([
//                'wechat_no' => 11111,
//            ]);
        if (!$_POST['pay_no'] || md5(substr($sign, 0, -1) . $codepay_key) != $_POST['sign']) { //KEY密钥为你的密钥
            //不合法的数据 不做处理
//            DB::table('recharge_order')->where('id',3)
//                ->update([
//                    'wechat_no' => json_encode($_POST),
//                ]);
            exit('fail');
        } else { //合法的数据
            //业务处理
            // $_POST['pay_id'] 这是付款人的唯一身份标识或订单ID
            // $_POST['pay_no'] 这是流水号 没有则表示没有付款成功 流水号不同则为不同订单
            // $_POST['money'] 这是付款金额
            //  $_POST['param'] 这是自定义的参数
            $order = DB::table('recharge_order')->where('id', $_POST['pay_id'])->first();
            //改状态
            if ($order->status == 2) {
                DB::table('recharge_order')
                    ->where('id', $_POST['pay_id'])
                    ->update([
                        'wechat_no' => $_POST['pay_no'],
                        'status' => 1,
                        'update_time' => time()
                    ]);
                //加元宝
                DB::table('member')->where('id', $order->m_id)
                    ->increment('gold', $order->gold);
            }
            exit('success');
        }
    }

    /**
     * 编辑个人中心
     * post: /home/amendCenter
     * @param : wx_num(微信号)
     * @param : qq_num(qq号)
     * @param : wx(微信收款码)
     * @param : zfb(支付宝收款码)
     */
    public function amendCenter()
    {
        $memberId = Request::get('mid');
        $member = DB::table('member')->find($memberId);
        if (!$member)
            return Response::json([
                'status' => 2,
                'info' => '用户不存在'
            ]);
        $wxNum = Request::input('wx_num');
        $qqNum = Request::input('qq_num');
        $wx = Request::input('wx');
        $zfb = Request::input('zfb');
        DB::beginTransaction();
        try {
            //更新微信号
            if (!empty($wxNum)) {
                $updateWxNum = DB::table('member')->where('id', $memberId)->update(['wx_num' => $wxNum, 'update_time' => time()]);
                if (!$updateWxNum) {
                    DB::rollBack();
                    return Response::json([
                        'status' => 2,
                        'info' => '失败1'
                    ]);
                }
            }
            //更新QQ号
            if (!empty($qqNum)) {
                $updateQqNum = DB::table('member')->where('id', $memberId)->update(['qq_num' => $qqNum, 'update_time' => time()]);
                if (!$updateQqNum) {
                    DB::rollBack();
                    return Response::json([
                        'status' => 2,
                        'info' => '失败2'
                    ]);
                }
            }
            //更新微信收款码
            if (!empty($wx)) {
                $wx = $this->base64_image_content($wx, 'uploads');//图片转码
                $updateWx = DB::table('member')->where('id', $memberId)->update(['wx' => $wx, 'update_time' => time()]);
                if (!$updateWx) {
                    DB::rollBack();
                    return Response::json([
                        'status' => 2,
                        'info' => '失败3'
                    ]);
                }
            }
            //更新支付宝收款码
            if (!empty($zfb)) {
                $zfb = $this->base64_image_content($zfb, 'uploads');//图片转码
                $updateZfb = DB::table('member')->where('id', $memberId)->update(['zfb' => $zfb, 'update_time' => time()]);
                if (!$updateZfb) {
                    DB::rollBack();
                    return Response::json([
                        'status' => 2,
                        'info' => '失败4'
                    ]);
                }
            }
            DB::commit();
            return Response::json([
                'status' => 1,
                'info' => '成功'
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json([
                'status' => 2,
                'info' => '失败'
            ]);
        }
    }

    //base_64转码
    function base64_image_content($base64_image_content, $path)
    {
        //匹配出图片的格式
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)) {
            $type = $result[2];
            $new_file = $path . "/";

            $new_file = $new_file . time() . rand(1000, 9999) . ".{$type}";
            if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))) {
                return '/' . $new_file;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * 商城列表
     * post: /home/goods
     */
    public function goods()
    {
        $list = DB::table('goods')->get(['id', 'title', 'desc', 'stock', 'price', 'img']);
        if (!empty($list)) {
            foreach ($list as $k => $v) {
                $list[$k]->price = round($v->price / 1000, 3);
            }
        }
        return Response::json($list);
    }

    /**
     * 商城购买果树
     * post: /home/buyGoods
     * @param : id(果树id)
     */
    public function buyGoods()
    {
        $memberId = Request::get('mid');
        $member = DB::table('member')->where('status', 1)->find($memberId);
        if (empty($member))
            return Response::json([
                'status' => 2,
                'info' => '用户不存在'
            ]);
        $id = Request::input('id');
        if (empty($id))
            return Response::json([
                'status' => 3,
                'info' => '请选择购买的果树'
            ]);
        $goodsInfo = DB::table('goods')->where('stock', '>=', 1)->find($id);
        if (empty($goodsInfo))
            return Response::json([
                'status' => 2,
                'info' => '参数有误或库存不足',
            ]);
        //金币是否充足
        if ($member->gold < $goodsInfo->price)
            return Response::json([
                'status' => 3,
                'info' => '金币不足'
            ]);
        DB::beginTransaction(); //开启事物
        try {
            //添加购买记录
            $goodsOrder = DB::table('goods_order')
                ->insert([
                    'm_id' => $memberId,
                    'g_id' => $goodsInfo->id,
                    'g_title' => $goodsInfo->title,
                    'g_desc' => $goodsInfo->desc,
                    'g_price' => $goodsInfo->price,
                    'g_img' => $goodsInfo->img,
                    't_id' => $goodsInfo->t_id,
                    'create_time' => time()
                ]);
            if (!$goodsOrder) {
                DB::rollBack();
                return Response::json([
                    'status' => 2,
                    'info' => '添加失败'
                ]);
            }
            //购买果树扣除金币
            $memberDecrementGold = DB::table('member')->where('id', $memberId)
                ->where('gold', '>=', $goodsInfo->price)
                ->decrement('gold', $goodsInfo->price);
            if (!$memberDecrementGold) {
                DB::rollBack();
                return Response::json([
                    'status' => 2,
                    'info' => '扣除失败'
                ]);
            }
            //扣除goods表库存
            $goodsDecrementStock = DB::table('goods')->where('id', $id)
                ->where('stock', '>=', 1)
                ->decrement('stock', 1);
            if (!$goodsDecrementStock) {
                DB::rollBack();
                return Response::json([
                    'status' => 2,
                    'info' => '扣除失败goods_stock'
                ]);
            }
            //扣除tree表库存
            $treeDecrementTree = DB::table('tree')->where('id', $goodsInfo->t_id)
                ->where('stock', '>=', 1)
                ->decrement('stock', 1);
            if (!$treeDecrementTree) {
                DB::rollBack();
                return Response::json([
                    'status' => 2,
                    'info' => '扣除失败tree_stock'
                ]);
            }
            DB::commit();
            return Response::json([
                'status' => 1,
                'info' => '购买果树成功'
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json([
                'status' => 2,
                'info' => '购买果树失败'
            ]);
        }
    }

    /**
     * 兑换列表
     * post: /home/exchangeList
     */
    public function exchangeList()
    {
        $list = DB::table('exchange')
            ->get(['id', 'title', 'desc', 'price', 'stock', 'img', 'status']);
        if (!empty($list)) {
            foreach ($list as $k => $v)
                $list[$k]->price = round($v->price / 1000, 3);
        }
        return Response::json($list);
    }

    /**
     * 兑换
     * post: /home/exchangeOrder
     * @param : id(兑换类型id)
     * @param : num(兑换数量)
     * @param : name(姓名)
     * @param : tel(电话)
     * @param : address(地址)
     */
    public function exchangeOrder()
    {
        $memberId = Request::get('mid');
        $member = DB::table('member')->find($memberId);
        if (empty($member))
            return Response::json([
                'status' => 2,
                'info' => '用户不存在'
            ]);
        $id = Request::input('id'); //兑换id
        if (empty($id))
            return Response::json([
                'status' => 3,
                'info' => '请选择一种兑换物'
            ]);
        $exchangeInfo = DB::table('exchange')->find($id);
        if (!$exchangeInfo)
            return Response::json([
                'status' => 2,
                'info' => '参数有误'
            ]);
        // id 1,2 个人中心不能为空
        if ($exchangeInfo->status == 2) {
            if (empty($member->wx_num) || empty($member->qq_num) || empty($member->wx) || empty($member->zfb))
                return Response::json([
                    'status' => 3,
                    'info' => '请先完善个人中心'
                ]);
        }
        $num = Request::input('num'); //兑换数量
        if ($num > $exchangeInfo->stock)
            return Response::json([
                'status' => 3,
                'info' => '超出库存'
            ]);
        //金币是否充足
        if ($member->gold < $exchangeInfo->price * $num)
            return Response::json([
                'status' => 3,
                'info' => '金币不足'
            ]);
        $name = Request::input('name');
        $tel = Request::input('tel');
        $address = Request::input('address');
        if ($exchangeInfo->status == 1) {
            if (empty($name) || empty($tel) || empty($address))
                return Response::json([
                    'status' => 3,
                    'info' => '请填写收货信息'
                ]);
        } else {
            $name = '';
            $tel = '';
            $address = '';
        }
        DB::beginTransaction();
        try {
            //添加兑换记录
            $exchangeOrder = DB::table('exchange_order')
                ->insertGetId([
                    'm_id' => $memberId,
                    'e_id' => $exchangeInfo->id,
                    'title' => $exchangeInfo->title,
                    'desc' => $exchangeInfo->desc,
                    'price' => $exchangeInfo->price,
                    'num' => $num,
                    'name' => $name,
                    'tel' => $tel,
                    'type' => $exchangeInfo->status,
                    'address' => $address,
                    'create_time' => time()
                ]);
            if (!$exchangeOrder) {
                DB::rollBack();
                return Response::json([
                    'status' => 2,
                    'info' => '添加失败'
                ]);
            }
            //扣除库存
            $exchangeStock = DB::table('exchange')->where('id', $exchangeInfo->id)
                ->where('stock', '>=', $num)->decrement('stock', $num);
            if (!$exchangeStock) {
                DB::rollBack();
                return Response::json([
                    'status' => 2,
                    'info' => '扣除失败stock'
                ]);
            }
            //扣除金币
            $memberGold = DB::table('member')->where('id', $memberId)
                ->where('gold', '>=', $exchangeInfo->price * $num)
                ->decrement('gold', $exchangeInfo->price * $num);
            if (!$memberGold) {
                DB::rollBack();
                return Response::json([
                    'status' => 2,
                    'info' => '扣除失败gold'
                ]);
            }
            DB::commit(); //提交
            return Response::json([
                'status' => 1,
                'info' => '兑换成功'
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json([
                'status' => 2,
                'info' => '兑换失败'
            ]);
        }
    }

    /**
     * 买鲜果
     * post: /home/buyFruit
     * @param : num(买入的数量)
     */
    public function buyFruit()
    {
        $memberId = Request::get('mid');
        $member = DB::table('member')->find($memberId);
        if (!$member)
            return Response::json([
                'status' => 2,
                'info' => '用户不存在'
            ]);
        $num = Request::input('num'); //购买鲜果数量
        if ($num <= 0)
            return Response::json([
                'status' => 3,
                'info' => '请输入购买鲜果数量'
            ]);
        //单个鲜果价格
        $fruitPrice = DB::table('fruit_price')->first(['buy']);
        $fPrice = $fruitPrice->buy; //购买单价 精确到分
        $price = round($fPrice * $num, 2); //购买需花费金额
        if ($price > $member->gold)
            return Response::json([
                'status' => 3,
                'info' => '金币不足'
            ]);
        DB::beginTransaction();
        try {
            //购买记录
            $buyLog = DB::table('buy_log')->insert([
                'm_id' => $memberId,
                'num' => $num * 1000, //数量
                'buy' => $fPrice, //单价
                'price' => $price, //总金额
                'create_time' => time()
            ]);
            if (!$buyLog) {
                DB::rollBack();
                return Response::json([
                    'status' => 2,
                    'info' => '添加失败'
                ]);
            }
            //添加个人鲜果数量
            $addFruitNum = DB::table('member')->where('id', $memberId)
                ->increment('fruit_num', $num * 1000);
            if (!$addFruitNum) {
                DB::rollBack();
                return Response::json([
                    'status' => 2,
                    'info' => '添加失败'
                ]);
            }
            //添加累计鲜果数量
            $addAllFruitNum = DB::table('member')->where('id', $memberId)
                ->increment('all_fruit_num', $num * 1000);
            if (!$addAllFruitNum) {
                DB::rollBack();
                return Response::json([
                    'status' => 2,
                    'info' => '添加失败all'
                ]);
            }
            //扣除金币
            $memberGold = DB::table('member')->where('id', $memberId)
                ->where('gold', '>=', $price)->decrement('gold', $price);
            if (!$memberGold) {
                DB::rollBack();
                return Response::json([
                    'status' => 2,
                    'info' => '减额失败'
                ]);
            }
            DB::commit();
            return Response::json([
                'status' => 1,
                'info' => '购买成功'
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json([
                'status' => 2,
                'info' => '购买失败'
            ]);
        }
    }

    /**
     * 出售鲜果
     * post: /home/sellFruit
     * @param : num(出售数量)
     */
    public function sellFruit()
    {
        $memberId = Request::get('mid');
        $member = DB::table('member')->find($memberId);
        if (!$member)
            return Response::json([
                'status' => 2,
                'info' => '用户不存在'
            ]);
        $num = Request::input('num'); //出售鲜果数量
        if ($num <= 0)
            return Response::json([
                'status' => 3,
                'info' => '请输入出售鲜果数量'
            ]);
        //单个鲜果价格
        $fruitPrice = DB::table('fruit_price')->first(['sell']);
        $fPrice = $fruitPrice->sell; //出售单价 精确到分
        if ($num * 1000 > $member->fruit_num)
            return Response::json([
                'status' => 3,
                'info' => '请确认拥有鲜果数'
            ]);
        $price = $num * $fPrice; //出售鲜果获得的总金额
        DB::beginTransaction();
        try {
            //添加出售记录
            $sellLog = DB::table('sell_log')
                ->insertGetId([
                    'm_id' => $memberId,
                    'num' => $num, //数量
                    'sell' => $fPrice, //单价
                    'price' => $price, //总金额
                    'create_time' => time()
                ]);
            if (!$sellLog) {
                DB::rollBack();
                return Response::json([
                    'status' => 2,
                    'info' => '添加失败'
                ]);
            }
            //扣除拥有的果实
            $memberDecrementFruitNum = DB::table('member')->where('id', $memberId)
                ->where('fruit_num', '>=', $num * 1000)
                ->decrement('fruit_num', $num * 1000);
            if (!$memberDecrementFruitNum) {
                DB::rollBack();
                return Response::json([
                    'status' => 2,
                    'info' => '扣除失败'
                ]);
            }
            //添加金币
            $memberAddGold = DB::table('member')->where('id', $memberId)
                ->increment('gold', $price);
            if (!$memberAddGold) {
                DB::rollBack();
                return Response::json([
                    'status' => 2,
                    'info' => '添加失败gold'
                ]);
            }
            DB::commit(); //提交
            return Response::json([
                'status' => 1,
                'info' => '出售成功'
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json([
                'status' => 2,
                'info' => '出售失败'
            ]);
        }
    }

    /**
     * 赠送 确认
     * post: /home/giveFruit
     * @param : id(对方id)
     * @param : num(赠送鲜果数量)
     */
    public function giveFruit()
    {
        $memberId = Request::get('mid');
        $member = DB::table('member')->find($memberId);
        if (!$member)
            return Response::json([
                'status' => 2,
                'info' => '用户不存在'
            ]);
        $id = Request::input('id'); //赠送人的id
        if (empty($id))
            return Response::json([
                'status' => 2,
                'info' => '参数错误'
            ]);
        $giveMember = DB::table('member')->find($id);
        if (empty($giveMember))
            return Response::json([
                'status' => 3,
                'info' => 'ID不存在'
            ]);
        $num = Request::input('num'); //赠送鲜果
        if ($num <= 0)
            return Response::json([
                'status' => 3,
                'info' => '请输入鲜果数量'
            ]);
        if ($num * 1000 > $member->fruit_num)
            return Response::json([
                'status' => 3,
                'info' => '超出拥有数量'
            ]);
        return Response::json([
            'status' => 1,
            'info' => '成功',
            'id' => $id,
            'nickname' => $giveMember->nickname,
        ]);
    }

    /**
     * 确认赠送
     * post: /home/affirmGive
     * @param : id(对方id)
     * @param : num(赠送鲜果数量)
     */
    public function affirmGive()
    {
        $memberId = Request::get('mid');
        $member = DB::table('member')->find($memberId);
        if (!$member)
            return Response::json([
                'status' => 2,
                'info' => '用户不存在'
            ]);
        $id = Request::input('id'); //赠送人的id
        if (empty($id))
            return Response::json([
                'status' => 2,
                'info' => '参数错误'
            ]);
        $giveMember = DB::table('member')->find($id);
        if (empty($giveMember))
            return Response::json([
                'status' => 3,
                'info' => 'ID不存在'
            ]);
        $num = Request::input('num'); //赠送鲜果
        if ($num <= 0)
            return Response::json([
                'status' => 3,
                'info' => '请输入鲜果数量'
            ]);
        if ($num * 1000 > $member->fruit_num)
            return Response::json([
                'status' => 3,
                'info' => '超出拥有数量'
            ]);
        DB::beginTransaction();
        try {
            //添加赠送记录
            $giveLog = DB::table('give_log')
                ->insertGetId([
                    'm_id' => $memberId,
                    'give_id' => $id,
                    'num' => $num * 1000,
                    'create_time' => time()
                ]);
            if (!$giveLog) {
                DB::rollBack();
                return Response::json([
                    'status' => 2,
                    'info' => '添加失败'
                ]);
            }
            //扣除自己鲜果
            $memberFruitNum = DB::table('member')->where('id', $memberId)
                ->where('fruit_num', '>=', $num * 1000)
                ->decrement('fruit_num', $num * 1000);
            if (!$memberFruitNum) {
                DB::rollBack();
                return Response::json([
                    'status' => 2,
                    'info' => '扣除失败'
                ]);
            }
            //增加转赠鲜果
            $memberGiveFruitNum = DB::table('member')->where('id', $id)
                ->increment('fruit_num', $num * 1000);
            if (!$memberGiveFruitNum) {
                DB::rollBack();
                return Response::json([
                    'status' => 2,
                    'info' => '增加失败'
                ]);
            }
            //增加转赠累计鲜果
            $memberGiveAllFruitNum = DB::table('member')->where('id', $id)
                ->increment('all_fruit_num', $num * 1000);
            if (!$memberGiveAllFruitNum) {
                DB::rollBack();
                return Response::json([
                    'status' => 2,
                    'info' => '增加失败all'
                ]);
            }
            DB::commit();
            return Response::json([
                'status' => 1,
                'info' => '赠送成功'
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json([
                'status' => 2,
                'info' => '赠送失败'
            ]);
        }
    }

    /**
     * 市场
     * post: /home/market
     */
    public function market()
    {
        $endTime = strtotime(date('Y-m-d'), time());
        $startTime = $endTime - 24 * 60 * 60;
        $row = DB::table('platform')->first(['all', 'fruit_count', 'issue', 'all_issue']);
        if (!empty($row)) {
            //市场鲜果数量
            $shiChangFruitNum = DB::table('commission')->sum('lr_market');
            $row->shichang_all_num = round($shiChangFruitNum / 1000, 3);
            //今日鲜果数目 今日所产生的的鲜果（果树的）
            $todayFruitNum = DB::table('commission')
//                ->where('t_id','<',8)
                ->where('create_time', '>', $startTime)
                ->where('create_time', '<', $endTime)
                ->sum('lr_market');
            if (empty($todayFruitNum))
                $todayFruitNum = 0;
            $row->today_num = round($todayFruitNum / 1000, 3);
            //已分红鲜果数
            $row->profit_num = round($row->issue / 1000, 3);
            //剩余果实数目 当前鲜果数目
            $row->surplus = round($row->fruit_count / 1000, 3);
            //累计鲜果总数
            $memberAllFruitNum = DB::table('member')->where('status', 1)
                ->sum('all_fruit_num');
            if (empty($memberAllFruitNum))
                $memberAllFruitNum = 0;
            $platformAndAllFruitNum = $memberAllFruitNum + $row->all;
            $row->all_num = round($platformAndAllFruitNum / 1000, 3);
            //发放鲜果总数
            $row->issue = round($row->all_issue / 1000, 3);
        }
        return Response::json($row);
    }

    /**
     * 团队
     * post: /home/myTeam
     */
    public function myTeam()
    {
        $memberId = Request::get('mid');
        $member = DB::table('member')->where('status', 1)->find($memberId);
        if (empty($member))
            return Response::json([
                'status' => 2,
                'info' => '用户不存在'
            ]);
        //查询果树等级
        $lvFruit = DB::table('member_tree as mt')
            ->leftJoin('member as m', 'm.id', '=', 'mt.m_id')
            ->leftJoin('tree as t', 't.id', '=', 'mt.t_id')
            ->where('m.id', $memberId)
            ->where('m.status', 1)
            ->first(['t.lv', 'mt.t_id']);
        if (empty($lvFruit))
            return Response::json([
                'status' => 2,
                'info' => '查询失败'
            ]);
        $lvTid = $lvFruit->t_id;
        $lvFruitLv = $member->yesterday_tree_lv == "" ? $lvFruit->lv:$member->yesterday_tree_lv ; //昨日果树等级
        /******直推******/
        //人数
        $memberDirectCount = DB::table('member')->where('first_id', $memberId)->count();
        if (($memberDirectCount % 8) > 0) {
            $pageAllNum = floor($memberDirectCount / 8) + 1;
        } else {
            $pageAllNum = floor($memberDirectCount / 8);
        }
        $endTime = strtotime(date("Y-m-d", time()));
        $startTime = $endTime - 24 * 60 * 60;
        //收益

        //奖励等级
        $arrFirst = ['1', '3', '5', '8', '12', '16', '21', '0', '25', '25', '25', '25', '25', '30', '30']; //直推贡献提成 百分比
        if ($lvFruitLv <= 7) {
            $lvRewards = $arrFirst[$lvFruitLv - 1];
        } else {
            $lvRewards = $arrFirst[$lvTid - 1];
        }
        //收获
        $getNum = DB::table('commission')->where('first_id', $memberId)
            ->where('create_time', '>', $startTime)
            ->where('create_time', '<', $endTime)
            ->sum('first_num');
        if (empty($getNum))
            $getNum = 0;
        $getNum = round($getNum / 1000, 3);
        $direct = [];
        $direct['person_num'] = $memberDirectCount;
        $direct['commission_num'] = round($getNum / ($lvRewards / 100), 3);
        $direct['lv_rewards'] = $lvRewards . '%';
        $direct['get_num'] = $getNum;
        $direct['page_num'] = $pageAllNum;

        /******团队********************************************************************************************/
        $arrId = ['second_id', 'third_id', 'fourth_id', 'fifth_id', 'sixth_id', 'seventh_id', 'eight_id', 'ninth_id'];
        //人数
        $secondNum = DB::table('member')->where('second_id', $memberId)->count();
        $thirdNum = DB::table('member')->where('third_id', $memberId)->count();
        $fourthNum = DB::table('member')->where('fourth_id', $memberId)->count();
        $fifthNum = DB::table('member')->where('fifth_id', $memberId)->count();
        $sixNum = DB::table('member')->where('sixth_id', $memberId)->count();
        $seventhNum = DB::table('member')->where('seventh_id', $memberId)->count();
        $eightNum = DB::table('member')->where('eight_id', $memberId)->count();
        $ninthNum = DB::table('member')->where('ninth_id', $memberId)->count();
        $allPersonNum = $secondNum + $thirdNum + $fourthNum + $fifthNum + $sixNum + $seventhNum + $eightNum + $ninthNum;
        //收益

        //奖励等级
        $arrTeam = ['0.5', '1', '1.5', '2', '2.5', '3', '3.5', '0', '4', '4', '4', '4', '4', '4.5', '5']; //直推贡献提成 百分比
        if ($lvFruitLv <= 7) {
            $lvTeamRewards = $arrTeam[$lvFruitLv - 1];
        } else {
            $lvTeamRewards = $arrTeam[$lvTid - 1];
        }
        //收获
        $secondNumCommissionNum = DB::table('commission')->where('second_id', $memberId)
            ->where('create_time', '>', $startTime)
            ->where('create_time', '<', $endTime)
            ->sum('second_num');
        if (empty($secondNumCommissionNum))
            $secondNumCommissionNum = 0;
        $thirdNumCommissionNum = DB::table('commission')->where('third_id', $memberId)
            ->where('create_time', '>', $startTime)
            ->where('create_time', '<', $endTime)
            ->sum('third_num');
        if (empty($thirdNumCommissionNum))
            $thirdNumCommissionNum = 0;
        $fourthNumCommissionNum = DB::table('commission')->where('fourth_id', $memberId)
            ->where('create_time', '>', $startTime)
            ->where('create_time', '<', $endTime)
            ->sum('fourth_num');
        if (empty($fourthNumCommissionNum))
            $fourthNumCommissionNum = 0;
        $fifthNumCommissionNum = DB::table('commission')->where('fifth_id', $memberId)
            ->where('create_time', '>', $startTime)
            ->where('create_time', '<', $endTime)
            ->sum('fifth_num');
        if (empty($fifthNumCommissionNum))
            $fifthNumCommissionNum = 0;
        $sixNumCommissionNum = DB::table('commission')->where('sixth_id', $memberId)
            ->where('create_time', '>', $startTime)
            ->where('create_time', '<', $endTime)
            ->sum('sixth_num');
        if (empty($sixNumCommissionNum))
            $sixNumCommissionNum = 0;
        $seventhNumCommissionNum = DB::table('commission')->where('seventh_id', $memberId)
            ->where('create_time', '>', $startTime)
            ->where('create_time', '<', $endTime)
            ->sum('seventh_num');
        if (empty($seventhNumCommissionNum))
            $seventhNumCommissionNum = 0;
        $eightNumCommissionNum = DB::table('commission')->where('eight_id', $memberId)
            ->where('create_time', '>', $startTime)
            ->where('create_time', '<', $endTime)
            ->sum('eight_num');
        if (empty($eightNumCommissionNum))
            $eightNumCommissionNum = 0;
        $ninthNumCommissionNum = DB::table('commission')->where('ninth_id', $memberId)
            ->where('create_time', '>', $startTime)
            ->where('create_time', '<', $endTime)
            ->sum('ninth_num');
        if (empty($ninthNumCommissionNum))
            $ninthNumCommissionNum = 0;
        $getTeamNum = $secondNumCommissionNum + $thirdNumCommissionNum + $fourthNumCommissionNum +
            $fifthNumCommissionNum + $sixNumCommissionNum + $seventhNumCommissionNum + $eightNumCommissionNum +
            $ninthNumCommissionNum;
        $getTeamNum = round($getTeamNum / 1000, 3);
        $team = [];
        $team['person_num'] = $allPersonNum;
        $team['commission_num'] = round($getTeamNum / ($lvTeamRewards / 100), 3);
        $team['lv_rewards'] = $lvTeamRewards . '%';
        $team['get_num'] = $getTeamNum;
        return Response::json([
            'direct' => $direct,
            'team' => $team
        ]);
    }

    /**
     * 团队 直推 详情
     * post: /home/myDirectDetail
     */
    public function myDirectDetail()
    {
        $memberId = Request::get('mid');
        $member = DB::table('member')->where('status', 1)->find($memberId);
        if (empty($member))
            return Response::json([
                'status' => 2,
                'info' => '用户不存在'
            ]);
        $memberDirectCount = DB::table('member')->where('first_id', $memberId)->count();
        if (($memberDirectCount % 8) > 0) {
            $pageAllNum = floor($memberDirectCount / 8) + 1;
        } else {
            $pageAllNum = floor($memberDirectCount / 8);
        }
        $page = Request::input('page');
        if (empty($page))
            $page = 1;
        if ($page > $pageAllNum)
            return Response::json([
                'status' => 2,
                'info' => '参数有误'
            ]);
        $num = ($page - 1) * 8;
        //查询 头像 ID 农场等级 果树等级
        $firstMemberInfo = DB::table('member_tree as mt')
            ->leftJoin('member as m', 'm.id', '=', 'mt.m_id')
            ->leftJoin('tree as t', 't.id', '=', 'mt.t_id')
            ->leftJoin('head_img as h', 'h.id', '=', 'm.h_id')
            ->where('m.first_id', $memberId)
            ->where('m.status', 1)
            ->offset($num)
            ->limit(8)
            ->get(['h.head', 'm.id', 'mt.lv_land', 't.lv']);
        //直推 团队人数
        $arrId = ['first_id', 'second_id', 'third_id', 'fourth_id', 'fifth_id', 'sixth_id', 'seventh_id', 'eight_id', 'ninth_id'];
        $arrNum = ['first_num', 'second_num', 'third_num', 'fourth_num', 'fifth_num', 'sixth_num', 'seventh_num', 'eight_num', 'ninth_num'];
//        if (!empty($firstMemberInfo)){
//            foreach ($firstMemberInfo as $k => $v) {
//                $firstMemberInfo[$k]->person_num = DB::table('member')
//                    ->whereRaw('(first_id=' . $v->id . ' or second_id=' . $v->id .' or third_id=' .
//                        $v->id .' or fourth_id=' . $v->id .' or fifth_id=' . $v->id
//                    .' or sixth_id=' . $v->id.' or seventh_id=' . $v->id.' or eight_id=' . $v->id
//                    .' or ninth_id=' . $v->id.')')->count();
//                //收益
//                $commissionNum = 0;
//                for ($i = 0; $i< 9; $i++){
//                    $commissionNum = DB::table('commission')->where($arrId[$i],$v->id)->sum($arrNum[$i]);
//                    if (empty($commissionNum))
//                        $commissionNum =0;
//                    $commissionNum += $commissionNum;
//                }
//                $firstMemberInfo[$k]->commission_num = round($commissionNum /1000,3);
//            }
//        }
        return Response::json($firstMemberInfo);
    }

    /**
     * 团队 直推 个人详情
     * post: /home/personalDirectDetail
     * @param : id(用户id)
     */
    public function personalDirectDetail()
    {
        $memberId = Request::get('mid');
        $id = Request::input('id');
        $member = DB::table('member')->where('status', 1)->find($memberId);
        if (empty($member))
            return Response::json([
                'status' => 2,
                'info' => '用户不存在'
            ]);
        if (empty($id))
            return Respons::json([
                'status' => 2,
                'info' => '参数为空'
            ]);
        $firstMemberInfo = DB::table('member')->where('first_id', $memberId)->where('id', $id)->first(['id']);
        if (empty($firstMemberInfo))
            return Respons::json([
                'status' => 2,
                'info' => '参数有误'
            ]);
        $arrId = ['first_id', 'second_id', 'third_id', 'fourth_id', 'fifth_id', 'sixth_id', 'seventh_id', 'eight_id', 'ninth_id'];
        $arrNum = ['first_num', 'second_num', 'third_num', 'fourth_num', 'fifth_num', 'sixth_num', 'seventh_num', 'eight_num', 'ninth_num'];

        $firstMemberInfo->person_num = DB::table('member')
            ->whereRaw('(first_id=' . $id . ' or second_id=' . $id . ' or third_id=' .
                $id . ' or fourth_id=' . $id . ' or fifth_id=' . $id
                . ' or sixth_id=' . $id . ' or seventh_id=' . $id . ' or eight_id=' . $id
                . ' or ninth_id=' . $id . ')')->count();
        //收益
//        $commissionNum = 0;
//        for ($i = 0; $i< 9; $i++){
//            $commissionNum = DB::table('commission')->where($arrId[$i],$id)->sum($arrNum[$i]);
//            if (empty($commissionNum))
//                $commissionNum =0;
//            $commissionNum += $commissionNum;
//        }
        $commissionNum = DB::table('commission')->where('m_id', $id)->sum($arrNum[0]);
        if (empty($commissionNum))
            $commissionNum = 0;
        $commissionNum += $commissionNum;
        $firstMemberInfo->commission_num = round($commissionNum / 1000, 3);

        return Response::json($firstMemberInfo);
    }

    /**
     * 团队 团队 详情
     * post: /home/myTeamDetail
     */
    public function myTeamDetail()
    {
        $memberId = Request::get('mid');
        $member = DB::table('member')->where('status', 1)->find($memberId);
        if (empty($member))
            return Response::json([
                'status' => 2,
                'info' => '用户不存在'
            ]);
        //查询 头像 ID 农场等级 果树等级
        $arrId = ['second_id', 'third_id', 'fourth_id', 'fifth_id', 'sixth_id', 'seventh_id', 'eight_id', 'ninth_id'];
        $arrNum = ['second_num', 'third_num', 'fourth_num', 'fifth_num', 'sixth_num', 'seventh_num', 'eight_num', 'ninth_num'];
        $list = [];
        for ($i = 0; $i < 8; $i++) {
            //人数
            $personNum = DB::table('member')->where($arrId[$i], $memberId)->count();
            //收益
            $commissionNum = DB::table('commission')->where($arrId[$i], $memberId)->sum($arrNum[$i]);
            if (empty($commissionNum))
                $commissionNum = 0;
            else
                $commissionNum = round($commissionNum / 1000, 3);
            $list[] = [
                'lv_num' => $i + 2,
                'person_num' => $personNum,
                'commission_num' => $commissionNum,
            ];
        }
        return Response::json($list);
    }

    /**
     * 升级土地
     * post: /home/upgradeLand
     */
    public function upgradeLand()
    {
        $memberId = Request::get('mid');
        $member = DB::table('member as m')
            ->leftJoin('member_tree as mt', 'mt.m_id', '=', 'm.id')
            ->where('m.status', 1)->where('m.id', $memberId)
            ->first(['mt.lv_land']);
        if (empty($member))
            return Response::json([
                'status' => 2,
                'info' => '用户不存在'
            ]);
        $lvLand = $member->lv_land; //我的土地等级
        if ($lvLand >= 8)
            return Response::json([
                'status' => 2,
                'info' => '等级已满'
            ]);
        /**
         * 土地升级需要果实
         * 1=>2,50;2=>3,150;3=>4,300;4=>5,500;5=>6,750;6=>7,1000;7=>8,3000
         */
        $landFruitNum = ['50', '150', '300', '500', '750', '1000', '3000'];
        DB::beginTransaction(); //开启事物
        try {
            //添加土地升级记录
            $upgradeLandLog = DB::table('upgrade_log')
                ->insert([
                    'm_id' => $memberId,
                    'type' => 1, //1土地升级，2果树升级,
                    'old_lv' => $lvLand, //原来等级
                    'new_lv' => $lvLand + 1, //升级后等级
                    'num' => $landFruitNum[$lvLand - 1] * 1000, //升级需要鲜果
                    'create_time' => time()
                ]);
            if (!$upgradeLandLog) {
                DB::rollBack();
                return Response::json([
                    'status' => 2,
                    'info' => '添加失败'
                ]);
            }
            //升级土地等级
            $upgradeLvLand = DB::table('member_tree')->where('m_id', $memberId)
                ->increment('lv_land', 1);
            if (!$upgradeLvLand) {
                DB::rollBack();
                return Response::json([
                    'status' => 2,
                    'info' => '土地升级失败'
                ]);
            }
            //扣除鲜果
            $decrementFruitNum = DB::table('member')->where('id', $memberId)
                ->where('fruit_num', '>=', $landFruitNum[$lvLand - 1] * 1000)
                ->decrement('fruit_num', $landFruitNum[$lvLand - 1] * 1000);
            if (!$decrementFruitNum) {
                DB::rollBack();
                return Response::json([
                    'status' => 2,
                    'info' => '扣除失败'
                ]);
            }
            // 添加奖励任务
            // 查询升级之后的等级
            $newLv = DB::table('member as m')
                ->leftJoin('member_tree as mt','mt.m_id','=','m.id')
                ->leftJoin('tree as t','t.id','=','mt.t_id')
                ->where('m.status',1)->where('m.id',$memberId)
                ->first(['mt.lv_land','t.lv','m.is_jiangli_renwu','m.first_id']);
            // 查询直推人数
            //查询上级团队
            $upId = $newLv -> first_id;
            $upMemberPersonNum = DB::table('member')
                ->where('first_id',$upId)->where('is_jiangli_renwu',1)->count();
            $upMemberPersonNum = $upMemberPersonNum+1;
//            $taskNum = ['40', '40', '45', '50', '55', '60', '65']; //*1000
            $taskNum = ['65', '70', '75', '75', '75', '70', '65']; //*1000
            //查询上级用户信息
            $upMember = DB::table('member')->find($upId,['all_fruit_num','fruit_num']);
            if ($newLv->lv_land == 2 && $newLv->is_jiangli_renwu == 2 && $upMemberPersonNum <= 200){
                //1-5
                if ($upMemberPersonNum <= 5) {
                    $row = DB::table('member')->where('id', $upId)
                        ->where('status', 1)->update([
                            'all_fruit_num' => $upMember->all_fruit_num + $taskNum[0] * 1000,
                            'fruit_num' => $upMember->fruit_num + $taskNum[0] * 1000,
                        ]);
                    if (!$row) {
                        return 'false';
                    }
                    //添加记录
                    $row = DB::table('up_member_log')->where('id', $upId)
                        ->where('status', 1)
                        ->insert([
                            'm_id' => $upId,
                            'fruit_num' => $taskNum[0] * 1000,
                            'create_time' => time()
                        ]);
                    if (!$row) {
                        return 'false';
                    }
                }
                //6-15
                if (($upMemberPersonNum > 5) && ($upMemberPersonNum <= 15)) {
                    $row = DB::table('member')->where('id', $upId)
                        ->where('status', 1)->update([
                            'all_fruit_num' => $upMember->all_fruit_num + $taskNum[1] * 1000,
                            'fruit_num' => $upMember->fruit_num + $taskNum[1] * 1000,
                        ]);
                    if (!$row) {
                        return 'false';
                    }
                    //添加记录
                    $row = DB::table('up_member_log')->where('id', $upId)
                        ->where('status', 1)
                        ->insert([
                            'm_id' => $upId,
                            'fruit_num' => $taskNum[1] * 1000,
                            'create_time' => time()
                        ]);
                    if (!$row) {
                        return 'false';
                    }
                }
                //16-30
                if (($upMemberPersonNum > 15) && ($upMemberPersonNum <= 30)) {
                    $row = DB::table('member')->where('id', $upId)
                        ->where('status', 1)->update([
                            'all_fruit_num' => $upMember->all_fruit_num + $taskNum[2] * 1000,
                            'fruit_num' => $upMember->fruit_num + $taskNum[2] * 1000,
                        ]);
                    if (!$row) {
                        return 'false';
                    }
                    //添加记录
                    $row = DB::table('up_member_log')->where('id', $upId)
                        ->where('status', 1)
                        ->insert([
                            'm_id' => $upId,
                            'fruit_num' => $taskNum[2] * 1000,
                            'create_time' => time()
                        ]);
                    if (!$row) {
                        return 'false';
                    }
                }
                //31-50
                if (($upMemberPersonNum > 30) && ($upMemberPersonNum <= 50)) {
                    $row = DB::table('member')->where('id', $upId)
                        ->where('status', 1)->update([
                            'all_fruit_num' => $upMember->all_fruit_num + $taskNum[3] * 1000,
                            'fruit_num' => $upMember->fruit_num + $taskNum[3] * 1000,
                        ]);
                    if (!$row) {
                        return 'false';
                    }
                    //添加记录
                    $row = DB::table('up_member_log')->where('id', $upId)
                        ->where('status', 1)
                        ->insert([
                            'm_id' => $upId,
                            'fruit_num' => $taskNum[3] * 1000,
                            'create_time' => time()
                        ]);
                    if (!$row) {
                        return 'false';
                    }
                }
                //51-80
                if (($upMemberPersonNum > 50) && ($upMemberPersonNum <= 80)) {
                    $row = DB::table('member')->where('id', $upId)
                        ->where('status', 1)->update([
                            'all_fruit_num' => $upMember->all_fruit_num + $taskNum[4] * 1000,
                            'fruit_num' => $upMember->fruit_num + $taskNum[4] * 1000,
                        ]);
                    if (!$row) {
                        return 'false';
                    }
                    //添加记录
                    $row = DB::table('up_member_log')->where('id', $upId)
                        ->where('status', 1)
                        ->insert([
                            'm_id' => $upId,
                            'fruit_num' => $taskNum[4] * 1000,
                            'create_time' => time()
                        ]);
                    if (!$row) {
                        return 'false';
                    }
                }// end if 51-80
                //81-125
                if (($upMemberPersonNum > 80) && ($upMemberPersonNum <= 125)) {
                    $row = DB::table('member')->where('id', $upId)
                        ->where('status', 1)->update([
                            'all_fruit_num' => $upMember->all_fruit_num + $taskNum[5] * 1000,
                            'fruit_num' => $upMember->fruit_num + $taskNum[5] * 1000,
                        ]);
                    if (!$row) {
                        return 'false';
                    }
                    //添加记录
                    $row = DB::table('up_member_log')->where('id', $upId)
                        ->where('status', 1)
                        ->insert([
                            'm_id' => $upId,
                            'fruit_num' => $taskNum[5] * 1000,
                            'create_time' => time()
                        ]);
                    if (!$row) {
                        return 'false';
                    }
                } //end if 81-125
                //126-220
                if (($upMemberPersonNum > 125) && ($upMemberPersonNum <= 200)) {
                    $row = DB::table('member')->where('id', $upId)
                        ->where('status', 1)->update([
                            'all_fruit_num' => $upMember->all_fruit_num + $taskNum[6] * 1000,
                            'fruit_num' => $upMember->fruit_num + $taskNum[6] * 1000,
                        ]);
                    if (!$row) {
                        return 'false';
                    }
                    //添加记录
                    $row = DB::table('up_member_log')->where('id', $upId)
                        ->where('status', 1)
                        ->insert([
                            'm_id' => $upId,
                            'fruit_num' => $taskNum[6] * 1000,
                            'create_time' => time()
                        ]);
                    if (!$row) {
                        return 'false';
                    }
                } //end if 126-220
            }
            // 更改 状态 is_jiangli_renwu
            if ($newLv->is_jiangli_renwu != 1){
                $row = DB::table('member')->where('status',1)->where('id',$memberId)
                    ->update([
                        'is_jiangli_renwu'=>1,
                        'jiangli_renwu_time'=>time()
                    ]);
                if (!$row){
                    DB::rollBack();
                    return Response::json([
                        'status' =>2,
                        'info' => 'update is_jiangli_renwu false'
                    ]);
                }
            }

            DB::commit();
            return Response::json([
                'status' => 1,
                'info' => '土地升级成功'
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json([
                'status' => 2,
                'info' => '土地升级失败'
            ]);
        }
    }

    /**
     * 升级果树
     * post: /home/upgradeFruitTree
     */
    public function upgradeFruitTree(){
        $memberId = Request::get('mid');
        $member = DB::table('member as m')
            ->leftJoin('member_tree as mt','mt.m_id','=','m.id')
            ->leftJoin('tree as t','t.id','=','mt.t_id')
            ->where('m.status',1)->where('m.id',$memberId)
            ->first(['mt.lv_land','t.lv']);
        if (empty($member))
            return Response::json([
                'status' => 2,
                'info' => '用户不存在'
            ]);
        $lvLand = $member->lv_land; //我的土地等级
        $lvFruit = $member->lv; //我的果树等级
        //土地等级 >= 果树等级
        if (($lvFruit+1) > $lvLand)
            return Response::json([
                'status' => 3,
                'info' => '请先升级土地'
            ]);
        if ($lvFruit >= 8)
            return Response::json([
                'status' => 2,
                'info' => '等级已满'
            ]);
        /**
         * 果树升级需要果实
         * 1=>2,50;2=>3,150;3=>4,300;4=>5,500;5=>6,750;6=>7,1000;7=>8,3000
         */
        $landFruitNum = ['50','150','300','500','750','1000','3000'];
        DB::beginTransaction(); //开启事物
        try{
            //添加土地升级记录
            $upgradeLandLog = DB::table('upgrade_log')
                ->insert([
                    'm_id' => $memberId,
                    'type' => 2, //1土地升级，2果树升级,
                    'old_lv' => $lvFruit, //原来等级
                    'new_lv' => $lvFruit +1, //升级后等级
                    'num' => $landFruitNum[$lvFruit-1] *1000, //升级需要鲜果
                    'create_time' => time()
                ]);
            if (!$upgradeLandLog){
                DB::rollBack();
                return Response::json([
                    'status' => 2,
                    'info' => '添加失败'
                ]);
            }
            //升级果树等级
            //7级之前的
            if ($lvFruit < 7) {
                $upgradeLvLand = DB::table('member_tree')->where('m_id', $memberId)
                    ->increment('t_id', 1);
                if (!$upgradeLvLand) {
                    DB::rollBack();
                    return Response::json([
                        'status' => 2,
                        'info' => '果树升级失败1'
                    ]);
                }
            }elseif($lvFruit == 7){
                //八级果树
                $tree = DB::table('tree')->where('id','>',7)
                    ->where('stock','>=',1)->get(['id','per','stock']);
                $arr = [];
                foreach ($tree as $k => $v){
                    for ($i= 0;$i < $v->per; $i++){
                        $arr[] = $v->id;
                    }
                }
                $index = rand(0,count($arr)-1);
                $treeId = $arr[$index];
                $treeInfo = DB::table('tree')->find($treeId);
                $upgradeLvLand = DB::table('member_tree')->where('m_id',$memberId)
                    ->update(['t_id'=>$treeInfo->id]);
                if (!$upgradeLvLand){
                    DB::rollBack();
                    return Response::json([
                        'status' => 2,
                        'info' => '升级失败'
                    ]);
                }
                //扣除果树
                $fruitTreeReduce = DB::table('tree')->where('id',$treeInfo->id)
                    ->decrement('stock',1);
                if (!$fruitTreeReduce){
                    DB::rollBack();
                    return Response::json([
                        'status' => 2,
                        'info' => '扣除果树失败'
                    ]);
                }
            }else{
                return Response::json([
                    'status' => 2,
                    'info' => '已满级'
                ]);
            }
            //扣除鲜果
            $decrementFruitNum = DB::table('member')->where('id',$memberId)
                ->where('fruit_num','>=',$landFruitNum[$lvFruit-1]*1000)
                ->decrement('fruit_num',$landFruitNum[$lvFruit-1]*1000);
            if (!$decrementFruitNum){
                DB::rollBack();
                return Response::json([
                    'status' => 2,
                    'info' => '扣除失败'
                ]);
            }
            DB::commit();
            return Response::json([
                'status' => 1,
                'info' => '果树升级成功'
            ]);
        }catch (Exception $e){
            DB::rollBack();
            return Response::json([
                'status' => 2,
                'info' => '果树升级失败'
            ]);
        }
    }


    /**
     * 奖励任务
     * post: /home/myTask
     */
    public function myTask()
    {
        $memberId = Request::get('mid');
        $member = DB::table('member')->where('status', 1)->find($memberId);
        if (empty($member))
            return Response::json([
                'status' => 2,
                'info' => '用户不存在'
            ]);
        $arrId = ['first_id', 'second_id', 'third_id', 'fourth_id', 'fifth_id', 'sixth_id', 'seventh_id', 'eight_id', 'ninth_id'];
        $arrPerson = ['1-5', '6-15', '16-30', '31-50', '51-80', '81-125', '126-200']; //阶段人数
        $arrComPerson = ['5', '10', '15', '20', '30', '45', '75']; //完成人数
//        $arrRewards = ['40', '40', '45', '50', '55', '60', '65']; //奖励 要*100
        $arrRewards = ['65', '70', '75', '75', '75', '70', '65']; //*1000

        $list = [];

        $firstNum = DB::table('member')->where('first_id', $memberId)
            ->where('is_jiangli_renwu',1)->count();
//        $secondNum = DB::table('member')->where('second_id', $memberId)->count();
//        $thirdNum = DB::table('member')->where('third_id', $memberId)->count();
//        $fourthNum = DB::table('member')->where('fourth_id', $memberId)->count();
//        $fifthNum = DB::table('member')->where('fifth_id', $memberId)->count();
//        $sixthNum = DB::table('member')->where('sixth_id', $memberId)->count();
//        $seventhNum = DB::table('member')->where('seventh_id', $memberId)->count();
//        $eightNum = DB::table('member')->where('eight_id', $memberId)->count();
//        $ninthNum = DB::table('member')->where('ninth_id', $memberId)->count();
        //总下级人数
//        $allNum = $firstNum + $secondNum + $thirdNum + $fourthNum + $fifthNum + $sixthNum + $seventhNum + $eightNum + $ninthNum;
        $allNum = $firstNum;
        $flag = 2;
        for ($i = 0; $i < 7; $i++) {
            if ($allNum > 0) {
                if ($allNum >= $arrComPerson[$i]) {
                    if ($allNum == $arrComPerson[$i]) {
                        $flag = 1;
                    }
                    $getNum = $arrComPerson[$i];
                    $allNum = $allNum - $arrComPerson[$i];
                    $status = '已完成';
                } else {
                    $getNum = $allNum;
                    $allNum = 0;
                    $status = '进行中';
                }
            } else {
                if ($flag == 1) {
                    $getNum = 0;
                    $status = '进行中';
                } else {
                    $flag = 2;
                    $getNum = 0;
                    $status = '未进行';
                }
            }
            $list[] = [
                'lv' => $i + 1,
                'lv_person' => $arrPerson[$i],
                'com_person' => $arrComPerson[$i],
                'rewards' => $arrRewards[$i],
                'get_num' => $getNum,
                'status' => $status,
            ];
        }
        return Response::json($list);
    }

    /**
     * 鲜果数量
     * post: /home/fruitNum
     */
    public function fruitNum()
    {
        $memberId = Request::get('mid');
        $member = DB::table('member')->where('status', 1)->find($memberId);
        if (empty($member))
            return Response::json([
                'status' => 2,
                'info' => '用户不存在'
            ]);
        $endTime = strtotime(date("Y-m-d", time()));
        $startTime = $endTime - 24 * 60 * 60;
        $startTime1 = $endTime + 24 * 60 * 60;
        $list = [];
        //总鲜果数量
        $allNum = round($member->all_fruit_num / 1000, 3);
        //现有鲜果数量
        $nowNum = round($member->fruit_num / 1000, 3);
        //团队收益
        $secondNumCommissionNum = DB::table('commission')->where('second_id', $memberId)
            ->where('create_time', '>', $startTime)
            ->where('create_time', '<', $endTime)
            ->sum('second_num');
        if (empty($secondNumCommissionNum))
            $secondNumCommissionNum = 0;
        $thirdNumCommissionNum = DB::table('commission')->where('third_id', $memberId)
            ->where('create_time', '>', $startTime)
            ->where('create_time', '<', $endTime)
            ->sum('third_num');
        if (empty($thirdNumCommissionNum))
            $thirdNumCommissionNum = 0;
        $fourthNumCommissionNum = DB::table('commission')->where('fourth_id', $memberId)
            ->where('create_time', '>', $startTime)
            ->where('create_time', '<', $endTime)
            ->sum('fourth_num');
        if (empty($fourthNumCommissionNum))
            $fourthNumCommissionNum = 0;
        $fifthNumCommissionNum = DB::table('commission')->where('fifth_id', $memberId)
            ->where('create_time', '>', $startTime)
            ->where('create_time', '<', $endTime)
            ->sum('fifth_num');
        if (empty($fifthNumCommissionNum))
            $fifthNumCommissionNum = 0;
        $sixNumCommissionNum = DB::table('commission')->where('sixth_id', $memberId)
            ->where('create_time', '>', $startTime)
            ->where('create_time', '<', $endTime)
            ->sum('sixth_num');
        if (empty($sixNumCommissionNum))
            $sixNumCommissionNum = 0;
        $seventhNumCommissionNum = DB::table('commission')->where('seventh_id', $memberId)
            ->where('create_time', '>', $startTime)
            ->where('create_time', '<', $endTime)
            ->sum('seventh_num');
        if (empty($seventhNumCommissionNum))
            $seventhNumCommissionNum = 0;
        $eightNumCommissionNum = DB::table('commission')->where('eight_id', $memberId)
            ->where('create_time', '>', $startTime)
            ->where('create_time', '<', $endTime)
            ->sum('eight_num');
        if (empty($eightNumCommissionNum))
            $eightNumCommissionNum = 0;
        $ninthNumCommissionNum = DB::table('commission')->where('ninth_id', $memberId)
            ->where('create_time', '>', $startTime)
            ->where('create_time', '<', $endTime)
            ->sum('ninth_num');
        if (empty($ninthNumCommissionNum))
            $ninthNumCommissionNum = 0;
        $todayTeamCommission = $secondNumCommissionNum + $thirdNumCommissionNum +
            $fourthNumCommissionNum + $fifthNumCommissionNum + $sixNumCommissionNum + $seventhNumCommissionNum +
            $eightNumCommissionNum + $ninthNumCommissionNum;
        $teamNum = round($todayTeamCommission / 1000, 3);
        //会员收益
        $firstNumCommissionNum = DB::table('commission')->where('first_id', $memberId)
            ->where('create_time', '>', $startTime)
            ->where('create_time', '<', $endTime)
            ->sum('first_num');
        if (empty($firstNumCommissionNum))
            $firstNumCommissionNum = 0;
        $membersNum = round($firstNumCommissionNum / 1000, 3);
        //分红收益
        $myProfitNum = DB::table('commission')->where('t_id', '>', 7)
            ->where('m_id', $memberId)
            ->where('create_time', '>', $startTime)
            ->where('create_time', '<', $endTime)
            ->sum('num');
        if (empty($myProfitNum))
            $myProfitNum = 0;
        $profitNum = round($myProfitNum / 1000, 3);
        //个人收益
        $myFruitNum = DB::table('commission')->where('m_id', $memberId)
            ->where('t_id', '<', 8)
            ->where('create_time', '>', $startTime)
            ->where('create_time', '<', $endTime)
            ->sum('num');
        if (empty($myFruitNum))
            $myFruitNum = 0;
        $myNum = round($myFruitNum / 1000, 3);
        /*其他收益 购买的鲜果和转赠给我的鲜果 回收的鲜果*/
        $buyFruitNum = DB::table('buy_log')->where('m_id', $memberId)
            ->where('create_time', '>', $startTime)
            ->where('create_time', '<', $endTime)
            ->sum('num'); //今日购买的鲜果
        if (empty($buyFruitNum))
            $buyFruitNum = 0;
        $giveMeFruitNum = DB::table('give_log')->where('give_id', $memberId)
            ->where('create_time', '>', $startTime)
            ->where('create_time', '<', $endTime)
            ->sum('num');
        if (empty($giveMeFruitNum))
            $giveMeFruitNum = 0;
        $recycleFruitNum = DB::table('recycle_log')->where('m_id', $memberId)
            ->where('create_time', '>', $endTime)
            ->where('create_time', '<', $startTime1)
            ->sum('price');
        if (empty($recycleFruitNum))
            $recycleFruitNum = 0;
        $upMemberLogFruitNum = DB::table('up_member_log')->where('m_id', $memberId)
            ->where('create_time', '>', $startTime)
            ->where('create_time', '<', $endTime)
            ->sum('fruit_num');
        if (empty($upMemberLogFruitNum))
            $upMemberLogFruitNum = 0;
        $allOtherNum = $recycleFruitNum + $buyFruitNum + $giveMeFruitNum + $upMemberLogFruitNum;
        $otherNum = round(($allOtherNum) / 1000, 3);
        //今日总收益
        $nowAllNum = round($teamNum + $membersNum + $profitNum + $myNum + $otherNum, 3);
        $list[] = [
            'all_num' => $allNum,
            'now_num' => $nowNum,
            'now_all_num' => $nowAllNum,
            'team_num' => $teamNum,
            'members_num' => $membersNum,
            'profit_num' => $profitNum,
            'my_num' => $myNum,
            'other_num' => $otherNum,
        ];
        return Response::json($list);
    }

    /**
     * 仓库
     * post: /home/warehouse
     */
    public function warehouse()
    {
        $memberId = Request::get('mid');
        $member = DB::table('member')->where('status', 1)->find($memberId);
        if (empty($member))
            return Response::json([
                'status' => 2,
                'info' => '用户不存在'
            ]);
        $list = DB::table('goods_order as o')
            ->leftJoin('member as m', 'm.id', '=', 'o.m_id')
            ->where('m.id', $memberId)
            ->where('o.status', 2)
            ->get(['o.id', 'o.g_title', 'o.g_img', 'o.status']);
        if (!empty($list)) {
            foreach ($list as $k => $v) {
                $list[$k]->status = $v->status == 1 ? "已种植" : "种植";
            }
        }
        return Response::json($list);
    }

    /**
     * 仓库 种植
     * post: /home/plantingFruitTree
     * @param : id(记录id)
     */
    public function plantingFruitTree()
    {
        $memberId = Request::get('mid');
        $member = DB::table('member')->where('status', 1)->find($memberId);
        if (empty($member))
            return Response::json([
                'status' => 2,
                'info' => '用户不存在'
            ]);
        $id = Request::input('id');
        if (empty($id))
            return Response::json([
                'status' => 3,
                'info' => '请选择要种植的果树'
            ]);
        //要种植的果树
        $fruitTree = DB::table('goods_order')->where('status', 2)->find($id);
        if (empty($fruitTree))
            return Response::json([
                'status' => 3,
                'info' => '果树不存在或已种植'
            ]);
        //查询土地等级
        $lvLand = DB::table('member_tree as mt')
            ->leftJoin('member as m', 'm.id', '=', 'mt.m_id')
            ->where('m.id', $memberId)
            ->first(['mt.lv_land', 'mt.t_id']);
        if ($lvLand->t_id > 7)
            return Response::json([
                'status' => 3,
                'info' => '请先回收您的特殊果树'
            ]);
        $lvLand = $lvLand->lv_land; //土地等级
        if ($lvLand < 8)
            return Response::json([
                'status' => 3,
                'info' => '请先升级土地'
            ]);
        DB::beginTransaction(); //开启事物
        try {
            //种植记录
            $plantingLog = DB::table('planting_log')
                ->insert([
                    'm_id' => $memberId,
                    'g_o_id' => $id, //对应goods_order表id
                    't_id' => $fruitTree->g_title,
                    'title' => $fruitTree->t_id,
                    'create_time' => time()
                ]);
            if (!$plantingLog) {
                DB::rollBack();
                return Response::json([
                    'status' => 2,
                    'info' => '添加失败'
                ]);
            }
            //种植 更改对应goods_order表id状态
            $goodsOrderStatus = DB::table('goods_order')->where('status', 2)
                ->where('id', $id)->update(['status' => 1, 'update_time' => time()]);
            if (!$goodsOrderStatus) {
                DB::rollBack();
                return Response::json([
                    'status' => 2,
                    'info' => '更新失败'
                ]);
            }
            //种植 更改果树等级
            $lvFruitTree = DB::table('member_tree')->where('m_id', $memberId)
                ->where('lv_land', 8)->update(['t_id' => $fruitTree->t_id]);
            if (!$lvFruitTree) {
                DB::rollBack();
                return Response::json([
                    'status' => 2,
                    'info' => '果树等级更新失败'
                ]);
            }
            DB::commit();
            return Response::json([
                'status' => 1,
                'info' => '种植成功'
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json([
                'status' => 2,
                'info' => '种植失败'
            ]);
        }
    }

    /**
     * 买卖鲜果价格
     * post: /home/fruitPrice
     */
    public function fruitPrice()
    {
        $row = DB::table('fruit_price')->first(['buy', 'sell']);
        if (!empty($row)) {
            $row->buy = round($row->buy / 1000, 3);
            $row->sell = round($row->sell / 1000, 3);
        }
        return Response::json($row);
    }

    /**
     * 分享
     * post: /home/qrCode
     */
    public function qrCode()
    {
        $memberId = Request::get('mid');
//        if (file_exists('uploads/qrcodeRes' . $memberId . '.png')) {
//            return Response::json('/uploads/qrcodeRes' . $memberId . '.png');
//        }
        $qrCode = DB::table('qrcode')->first();
        $size = $qrCode->size;
        $offset_x = $qrCode->offset_x;
        $offset_y = $qrCode->offset_y;
        $path = 'uploads/qrcode' . $memberId . '.png'; //存二维码
        QrCode::format('png')->margin(0)->size($size)->generate(Config::get('custom.BasePath') . '/home1/logonUrl?id=' . $memberId, public_path('/' . $path)); // 生成二维码

        $dituPath = substr($qrCode->img, 1); // 底图路径
        $img = imagecreatefromstring(file_get_contents($path));//合成
        $dituImg = imagecreatefromstring(file_get_contents($dituPath));

        list($width, $hight, $type) = getimagesize($path);
        list($dituWidth, $dituHight, $dituType) = getimagesize($dituPath);
//        $withe = imagecolorallocate($img, 255, 255, 255);
        header("Content-type:image/png");
        imagepng($dituImg, 'uploads/qrcodeRes' . $memberId . '.png');

        $mid = 'uploads/qrcodeRes' . $memberId . '.png';
        $imgMid = imagecreatefromstring(file_get_contents($mid));
        list($midWidth, $midHight, $midType) = getimagesize($mid);
//        $gary = imagecolorallocate($imgMid, 105, 105, 105);
        imagecopymerge($imgMid, $dituImg, 0, 0, 0, 0, $dituWidth, $dituHight, 100);
        imagecopymerge($imgMid, $img, $offset_x, $offset_y, 0, 0, $width, $hight, 100);
        imagepng($imgMid, 'uploads/qrcodeRes' . $memberId . '.png');

        imagedestroy($img);
        imagedestroy($dituImg);
        imagedestroy($imgMid);
        $url = Config::get('custom.BasePath') . '/home1/logonUrl?id=' . $memberId;
        return Response::json([
            'img' => '/' . $mid,
            'url' => $url,
            'qr_code' => '/uploads/' . 'qrcode' . $memberId . '.png',
        ]);
    }

    /**
     * 观光团
     * post: /home/tour
     */
    public function tour()
    {
        $fruitUpgradePer = DB::table('fruit_upgrade_per')->first(['zs', 'bj', 'wx']);
        //钻石果树
        $zsTreeInfo = DB::table('tree')->where('id', 15)->first(['id', 'all_stock', 'stock']);
        $zs = [];
        $zs['z_shi'] = $zsTreeInfo->all_stock - $zsTreeInfo->stock;
        $zs['z_fou'] = $zsTreeInfo->stock;
        $zs['z_per'] = $fruitUpgradePer->zs . '%';
        //白金果树
        $bjTreeInfo = DB::table('tree')->where('id', 14)->first(['id', 'all_stock', 'stock']);
        $bj = [];
        $bj['b_shi'] = $bjTreeInfo->all_stock - $bjTreeInfo->stock;
        $bj['b_fou'] = $bjTreeInfo->stock;
        $bj['b_per'] = $fruitUpgradePer->bj . '%';
        //五行果树
        $jTreeInfo = DB::table('tree')->where('id', 9)->first(['id', 'all_stock', 'stock']);
        $mTreeInfo = DB::table('tree')->where('id', 10)->first(['id', 'all_stock', 'stock']);
        $sTreeInfo = DB::table('tree')->where('id', 11)->first(['id', 'all_stock', 'stock']);
        $hTreeInfo = DB::table('tree')->where('id', 12)->first(['id', 'all_stock', 'stock']);
        $tTreeInfo = DB::table('tree')->where('id', 13)->first(['id', 'all_stock', 'stock']);
        //五行果树总数量
        $wxAllTreeNum = $jTreeInfo->all_stock + $mTreeInfo->all_stock + $sTreeInfo->all_stock +
            $hTreeInfo->all_stock + $tTreeInfo->all_stock;
        //五行果树未种植数量
        $wxTreeNum = $jTreeInfo->stock + $mTreeInfo->stock + $sTreeInfo->stock + $hTreeInfo->stock + $tTreeInfo->stock;
        $wx = [];
        $wx['w_shi'] = $wxAllTreeNum - $wxTreeNum;
        $wx['w_fou'] = $wxTreeNum;
        $wx['w_per'] = $fruitUpgradePer->wx . '%';
        return Response::json([
            'zs' => $zs,
            'bj' => $bj,
            'wx' => $wx
        ]);
    }

    /**
     * 回收
     * post: /home/recycle
     * @param : t_id(树的id)
     */
    public function recycle()
    {
        $memberId = Request::get('mid');
        $member = DB::table('member')->where('status', 1)->find($memberId);
        if (empty($member))
            return Response::json([
                'status' => 2,
                'info' => '用户不存在'
            ]);
        $tId = Request::input('t_id'); //树的id
        if (empty($tId))
            return Response::json([
                'status' => 2,
                'info' => '请选择回收果树'
            ]);
        //查询t_id对应的果树
        $tIdInfo = DB::table('member_tree as mt')
            ->leftJoin('member as m', 'm.id', '=', 'mt.m_id')
            ->leftJoin('tree as t', 't.id', '=', 'mt.t_id')
            ->where('m.id', $memberId)
            ->first(['t.id']);
        if (empty($tIdInfo))
            return Response::json([
                'status' => 2,
                'info' => '参数有误'
            ]);
        //回收价格 财神树8,金9,木10,水11,火12,土13(tree表id)
        $recyclePrice = ['5000', '4000', '4000', '4000', '4000', '4000']; // *100计算
        if ($tId == 8)
            $tIdPrice = $recyclePrice[0] * 1000;
        if ($tId == 9)
            $tIdPrice = $recyclePrice[1] * 1000;
        if ($tId == 10)
            $tIdPrice = $recyclePrice[2] * 1000;
        if ($tId == 11)
            $tIdPrice = $recyclePrice[3] * 1000;
        if ($tId == 12)
            $tIdPrice = $recyclePrice[4] * 1000;
        if ($tId == 13)
            $tIdPrice = $recyclePrice[5] * 1000;
        //白金树 钻石树 回收
        $endTime = strtotime(date('Y-m-d'), time());
        $startTime = $endTime - 24 * 60 * 60;
        $startTime1 = $endTime + 24 * 60 * 60;
        $commissionFruitNum = DB::table('commission')
            ->where('create_time', '>=', $startTime)
            ->where('create_time', '<', $endTime)
            ->sum('lr_market');
        if (empty($commissionFruitNum))
            $commissionFruitNum = 0;
        $recycleFruitNum = DB::table('recycle_log')
            ->where('create_time', '>=', $endTime)
            ->where('create_time', '<', $startTime1)
            ->where('t_id', '>=', 14)
            ->sum('price');
        if (empty($recycleFruitNum))
            $recycleFruitNum = 0;
        //总市场收益
        $commissionFruitNum = $commissionFruitNum - $recycleFruitNum;
        if ($tId == 14)
            $tIdPrice = floor($commissionFruitNum * (7.5 / 100)); //白金树
        if ($tId == 15)
            $tIdPrice = floor($commissionFruitNum * (15 / 100)); //钻石树
        DB::beginTransaction();
        try {
            //添加回收记录
            $recycleLog = DB::table('recycle_log')
                ->insert([
                    'm_id' => $memberId,
                    't_id' => $tId, //回收树t_id
                    'price' => $tIdPrice, //回收价格
                    'create_time' => time()
                ]);
            if (!$recycleLog) {
                DB::rollBack();
                return Response::json([
                    'status' => 2,
                    'info' => '添加失败'
                ]);
            }
            //添加鲜果
            if ($tIdPrice > 0) {
                $IncrementFruitNum = DB::table('member')->where('id', $memberId)
                    ->where('status', 1)->increment('fruit_num', $tIdPrice);
                if (!$IncrementFruitNum) {
                    DB::rollBack();
                    return Response::json([
                        'status' => 2,
                        'info' => '添加失败1'
                    ]);
                }
                //添加累计鲜果数量
                $IncrementAllFruitNum = DB::table('member')->where('id', $memberId)
                    ->where('status', 1)->increment('all_fruit_num', $tIdPrice);
                if (!$IncrementAllFruitNum) {
                    DB::rollBack();
                    return Response::json([
                        'status' => 2,
                        'info' => '添加失败2'
                    ]);
                }
            }
            //初始化土地等级和果树等级
            $initLandTree = DB::table('member_tree')->where('m_id', $memberId)
                ->update(['t_id' => 1]);
            if (!$initLandTree) {
                DB::rollBack();
                return Response::json([
                    'status' => 2,
                    'info' => '初始化失败'
                ]);
            }
            //果树数量计算 tree表 stock+1
            $addTreeStock = DB::table('tree')->where('id', $tId)
                ->increment('stock', 1);
            if (!$addTreeStock) {
                DB::rollBack();
                return Response::json([
                    'status' => 2,
                    'info' => '回收失败'
                ]);
            }
            //钻石树 和 白金树， 扣除市场鲜果
            if (($tId == 14) || ($tId == 15)) {
                $platformFruitNum = DB::table('platform')->where('id', 1)
                    ->where('fruit_count', '>=', $tIdPrice)
                    ->decrement('fruit_count', $tIdPrice);
                if (!$platformFruitNum) {
                    DB::rollBack();
                    return Response::json([
                        'status' => 2,
                        'info' => '扣除市场鲜果失败'
                    ]);
                }
                $platformAllIssue = DB::table('platform')->where('id', 1)
                    ->increment('all_issue', $tIdPrice);
                if (!$platformAllIssue) {
                    DB::rollBack();
                    return Response::json([
                        'status' => 2,
                        'info' => '添加累计发放失败'
                    ]);
                }
            }
            DB::commit();
            return Response::json([
                'status' => 1,
                'info' => '回收成功',
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json([
                'status' => 2,
                'info' => '回收失败'
            ]);
        }
    }

    /**
     * 成长 定时任务
     * get: /home/growUp
     */
    public function growUp()
    {
        $time = time(); //server time
//        $time = 1572714610;
        $end = strtotime(date('Y-m-d', $time));//0点
        $begin = $end - 24 * 60 * 60;
        $market = DB::table('commission')->where('create_time', '>', $begin)
            ->where('create_time', '<', $end)->sum('lr_market');//昨日流入市场总值
        if (empty($market))
            $market = 0;
        $members = DB::table('member as m')
            ->leftJoin('member_tree as mt', 'mt.m_id', '=', 'm.id')
            ->where('m.status', 1)
            ->where('m.is_carry',2)
            ->where('mt.t_id', '<>', 8)
            ->limit(2000)
            ->get(['m.id', 'mt.t_id', 'm.first_id', 'm.second_id', 'm.third_id', 'm.fourth_id',
                'm.fifth_id', 'm.sixth_id', 'm.seventh_id', 'm.eight_id', 'm.ninth_id']);
        if (count($members) <=0)
            return "no data";
        DB::beginTransaction(); //开启事物
        try {
//            $arrProfit = ['0','0','1000','2000','3000','5000','6000','0','1','1','1','1','1','5','10']; //实际获得
            $arrProfit = ['0', '0', '2000', '4000', '6000', '10000', '12000', '0', '1', '1', '1', '1', '1', '5', '10']; //实际获得
//            $arrMarket = ['1000','1000','2000','3000','4000','5000','6000','0','8000','8000','8000','8000','8000'
//            $arrMarket = ['2000', '2000', '4000', '6000', '8000', '10000', '12000', '0', '8000', '8000', '8000', '8000', '8000'
//                , '10000', '15000']; //正常流入市场
            $arrMarket = ['2000', '2000', '4000', '6000', '8000', '10000', '12000', '0', '16000', '16000', '16000', '16000', '16000'
                , '20000', '30000']; //正常流入市场
            $arrStrId = ['first_id', 'second_id', 'third_id', 'fourth_id', 'fifth_id',
                'sixth_id', 'seventh_id', 'eight_id', 'ninth_id'];
            $arrStrNum = ['first_num', 'second_num', 'third_num', 'fourth_num', 'fifth_num',
                'sixth_num', 'seventh_num', 'eight_num', 'ninth_num'];
            $arrPerFirst = ['1', '3', '5', '8', '12', '16', '21', '0', '25', '25', '25', '25', '25', '30', '30'];//百分比
            $arrPerTeam = ['5', '10', '15', '20', '25', '30', '35', '0', '40', '40', '40', '40', '40', '45', '50'];//千分比
            $allMarket = 0;
            $issue = 0;
            foreach ($members as $m) {
                $data = [
                    'm_id' => $m->id,
                    't_id' => $m->t_id,
                    'create_time' => $time
                ];
                //记录昨天的果树等级
                $row = DB::table('member')->where('id', $m->id)
                    ->update(['yesterday_tree_lv' => $m->t_id, 'update_time' => $time+1]);
                if (!$row)
                    return "yesterday false";
                $row = DB::table('member')->where('id', $m->id)
                    ->update(['is_carry' => 1, 'carry_time' => $time+1]);
                if (!$row)
                    return "yesterday false";
                //自己获得收益
                if ($m->t_id < 8) {
                    $data['num'] = $arrProfit[($m->t_id - 1)];
                } else {
                    $data['num'] = floor(($market * $arrProfit[($m->t_id - 1)] / 1000) - $arrMarket[($m->t_id - 1)]);
                    $issue += $data['num'];
                    if ($m->t_id > 7) {
                        $row = DB::table('platform')->where('id', 1)
                            ->where('fruit_count', '>=', $data['num'])
                            ->decrement('fruit_count', $data['num']);
                        if (!$row) {
                            DB::rollBack();
                            return " decrement platform fruit count false";
                        }
                    }
                } //end if
                //判断num大于0 添加当前用户果实
                if ($data['num'] > 0) {
                    $row = DB::table('member')->where('id', $m->id)
                        ->increment('all_fruit_num', $data['num']);
                    if (!$row) {
                        DB::rollBack();
                        return 'insert row1 false';
                    }
                    $row = DB::table('member')->where('id', $m->id)
                        ->increment('fruit_num', $data['num']);
                    if (!$row) {
                        DB::rollBack();
                        return 'insert row2 false';
                    }
                }//end if添加当前用户果实
                $getMarket = $arrMarket[($m->t_id - 1)];
                $relMarket = $getMarket;
                for ($i = 0; $i < 9; $i++) {
                    $strId = $arrStrId[$i];//第几层
                    $strNum = $arrStrNum[$i];//第几层收益字段名
                    $id = $m->$strId;
                    $num = 0;
                    if ($id > 0) {
                        $up = DB::table('member as m')
                            ->leftJoin('member_tree as mt', 'mt.m_id', '=', 'm.id')
                            ->where('m.id', $id)
                            ->first(['m.id', 'mt.t_id']);
                        if (!empty($up)) {
                            if ($i == 0) {
                                $num = $getMarket * $arrPerFirst[($up->t_id - 1)] / 100;
                            } else {
                                $num = $getMarket * $arrPerTeam[($up->t_id - 1)] / 1000;
                            }
                        }
                    }
                    $data[$strId] = $id;
                    $data[$strNum] = $num;
                    $relMarket = $relMarket - $num;
                    //判断num大于0 添加id为$id用户果实
                    if ($num > 0) {
                        $row = DB::table('member')->where('id', $id)
                            ->increment('all_fruit_num', $num);
                        if (!$row) {
                            DB::rollBack();
                            return 'insert row3 false1';
                        }
                        $row = DB::table('member')->where('id', $id)
                            ->increment('fruit_num', $num);
                        if (!$row) {
                            DB::rollBack();
                            return 'insert row4 false';
                        }
                    }
                }//endfor
                $data['lr_market'] = $relMarket;
                //加记录
                $row = DB::table('commission')->insert($data);
                if (!$row) {
                    DB::rollBack();
                    return 'insert row5 false';
                }
                $allMarket += $relMarket;
            }//endforeach
            if ($allMarket > 0) {
                $row = DB::table('platform')->where('id', 1)
                    ->increment('all', $allMarket);
                if (!$row) {
                    DB::rollBack();
                    return 'insert row6 false';
                }
                $row = DB::table('platform')->where('id', 1)
                    ->increment('fruit_count', $allMarket);
                if (!$row) {
                    DB::rollBack();
                    return 'insert row7 false';
                }
            }//endif
            if ($issue > 0) {
                $row = DB::table('platform')->where('id', 1)
                    ->increment('issue', $issue);
//                    ->update(['issue'=>$issue,'update_time'=>time()]);
                if (!$row) {
                    DB::rollBack();
                    return 'insert row8 false';
                }
                $row = DB::table('platform')->where('id', 1)
                    ->increment('all_issue', $issue);
                if (!$row) {
                    DB::rollBack();
                    return 'insert row9 false';
                }
            }//endif
            DB::commit();
            return "ok";
        } catch (Exception $e) {
            DB::rollBack();
            return 'false';
        }
    }

    /**
     * 定时任务更改状态
     * get: /home/memberIsCarry
     */
    public function memberIsCarry(){
        $time = time(); // server time
        $row = DB::table('member')->update(['is_carry'=>2,'carry_time' => $time]);
        if (!$row)
            return "false";
        return "ok";
    }

    /**
     * 定时任务更改状态
     * get: /home/memberIsCarry
     */
    public function telStatus(){
        $time = time(); // server time
        $row = DB::table('test_tel')->insert(['time'=>$time]);
        if (!$row)
            return "false";
        return "ok";
    }

    /**
     * 头像列表
     * post: /home/headImgList
     */
    public function headImgList()
    {
        $list = DB::table('head_img')->get(['id', 'head']);
        return Response::json($list);
    }

    /**
     * 选择头像
     * post: /home/chooseHeadImg
     * @param : id(头像id)
     */
    public function chooseHeadImg()
    {
        $memberId = Request::get('mid');
        $member = DB::table('member')->where('status', 1)->find($memberId);
        if (empty($member))
            return Response::json([
                'status' => 2,
                'info' => '用户不存在'
            ]);
        $id = Request::input('id');
        if (empty($id))
            return Response::json([
                'status' => 3,
                'info' => '请选择喜欢的头像'
            ]);
        //查询id对应头像
        $headImgId = DB::table('head_img')->find($id);
        if (empty($headImgId))
            return Response::json([
                'status' => 2,
                'info' => '参数有误'
            ]);
        //更换头像
        $updateMemberHeadImg = DB::table('member')->where('id', $memberId)
            ->update(['h_id' => $id, 'update_time' => time()]);
        if (!$updateMemberHeadImg)
            return Response::json([
                'status' => 2,
                'info' => '更换失败'
            ]);
        return Response::json([
            'status' => 1,
            'info' => '更换成功'
        ]);
    }

    /**
     * 兑换记录
     * post: /home/exchangeListLog
     * @param : type (1实物，2虚拟物)
     */
    public function exchangeListLog()
    {
        $memberId = Request::get('mid');
        $member = DB::table('member')->where('status', 1)->find($memberId);
        if (empty($member))
            return Response::json([
                'status' => 2,
                'info' => '用户不存在'
            ]);
//        $type = Request::input('type');
//        if (empty($type))
//            $type = 1;
        $list = DB::table('exchange_order')->where('m_id', $memberId)
            ->orderBy('create_time', 'DESC')
            ->orderBy('status', 1)
            ->get(['title', 'status', 'num',
                DB::raw('FROM_UNIXTIME(create_time,\'%Y/%m/%d %H:%i:%s\') as create_date')]);
        if (!empty($list)) {
            foreach ($list as $k => $v) {
                if ($v->status == 1)
                    $list[$k]->status = "已发货";
                if ($v->status == 2)
                    $list[$k]->status = "已兑换";
                if ($v->status == 3)
                    $list[$k]->status = "已拒绝";
            }
        }
        return Response::json($list);
    }

    //添加 6000个账号
    public function addMemberTel(){
//        $num = DB::table('member')->count();
//        return $num;
//         $tel = DB::table('tel')->where('id','>',268)->where('id','<=',471)->get(['tel','nickname']);
         $tel = DB::table('tel')->where('id','>',268)->where('id','<=',471)->count();
//         return $tel;
//        return Response::json($tel);
        //10583	10582	10581	10499
        //20665	14599   10499
         if (!empty($tel)){
             foreach ($tel as $k => $v){
                 $memberTelExists = DB::table('member')->where('tel',$v->tel)->first();
                 if (!$memberTelExists){
                     $addTel = DB::table('member')
                         ->insert([
                             'tel' => $v->tel,
                             'password' => "dcc62e31c8030d9488969c5da73d2f16",
                             'h_id' => 24,
                             'nickname' => $v->nickname,
                             'name' => $v->tel,
                             'create_time' => time()+1,
                             'first_id' => 20665,
                             'second_id' => 14599,
                             'third_id' => 10499,
                         ]);
                     if (!$addTel)
                         return "false";
                 }// end if
             }// end foreach
             return "ok";
         }//end if
         return "true";
    }

    public function addMemberTreeInfo(){
        $member = DB::table('member')
            ->where('id','>',20671)
            ->get(['id']);
        $memberNum = DB::table('member')->count();
        $memberTreeNum = DB::table('member')->count();
        return Response::json([
            'm'=>$memberNum,
            't' => $memberTreeNum
        ]);

        if (!empty($member)){
            foreach ($member as $k => $v){
                $memberTreeInfo = DB::table('member_tree')->where('m_id',$v->id)->first();
                if (!$memberTreeInfo){
                    $row = DB::table('member_tree')
                        ->insert([
                            'm_id' => $v->id,
                            't_id' => 5,
                            'lv_land' => 7,
                            'create_time' => time()+1
                        ]);
                    if (!$row)
                        return "false";
                }// end if
            }// end foreach 13498   16498
            return "ok";
        }// end if
        return "true";
    }
}