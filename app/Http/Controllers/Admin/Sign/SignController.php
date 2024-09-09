<?php
namespace App\Http\Controllers\Admin\Sign;

use Request, Validator, Session;
use Illuminate\Routing\Controller;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use App\Repositories\AuthMenuRepository;

/**
 * Class SignController
 * @package App\Http\Controllers\Admin\Seventeen\Sign
 */
class SignController extends Controller
{

    static $views = 'admin.sign.';
    //验证自定义消息
    private $messages = [
        'account.required' => '请输入账号！',
        'account.alpha_dash' => '账号允许字母、数字、-、_',
        'account.min' => '账号最少4位字符',
        'account.max' => '账号最多16字符',
        'password.required' => '请输入密码！',
        'password.alpha_dash' => '密码允许字母、数字、-、_',
        'password.min' => '密码最少6位字符',
        'password.max' => '密码最多10字符',
    ];
    /**
     * 验证规则
     */
    private $rules = [
        'account' => 'required|alpha_dash|min:4|max:16',
        'password' => 'required|alpha_dash|min:6|max:10'
    ];
    protected $user;
    protected $role;
    protected $menu;

    /**
     * constructor.
     */
    function __construct(UserRepository $user,
                         RoleRepository $role,
                         AuthMenuRepository $menu)
    {
        $this->user = $user;
        $this->role = $role;
        $this->menu = $menu;
    }

    /**
     * 登陆首页
     * get: /admin/sign
     */
    public function index()
    {
        //判断登录前的url地址
        if (Session::has('request_url'))
            Session::reflash();//刷新当前暂存数据，延长到下次请求
        return view(self::$views . 'index');
    }

    /**
     * 登录
     * post: /admin/signup
     */
    public function signup()
    {
        if (Request::method() == 'POST') {
            //获取所有的表单
            $data = Request::all();
            //验证
            $validator = Validator::make($data, $this->rules, $this->messages);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator->errors());
            }
            $account = $data['account'];
            $password = $data['password'];
            $uid = $this->login($account, $password);

            if ($uid > 0) { //登录成功
                $user = Session::get(config('custom.AdminUser'));
                if (!Session::has(config('custom.AdminMenu'))) {
                    //获取用户ID
//					$user = Session::get(config('custom.AdminUser'));
                    $uid = $user['id'];
                    //根据用户ID查询用户所拥有的权限
                    $data = $this->menu->getMenu($uid);
                    //设置过期时间

                    Session::put(config('custom.AdminMenu'), $data);
                }
                if (Session::has('request_url')) {
                    $url = Session::get('request_url');
                    return redirect($url);
                }
                return redirect('/admin/index/index');
            } else { //登录失败
                switch ($uid) {
                    case -1:
                        $error = '用户不存在或被禁用！';
                        break; //系统级别禁用
                    case -2:
                        $error = '密码错误！';
                        break;
                    default:
                        $error = '未知错误！';
                        break; // 0-接口参数错误（调试阶段使用）
                }
                return redirect()->back()->withInput()->withErrors($error);
            }
        }
    }

    /**
     * 用户登录认证
     * @param  string $username 用户名
     * @param  string $password 用户密码
     * @param  string $type 1:用户登录名   2：邮箱  3:手机号
     * @return integer  登录成功-用户ID，登录失败-错误编号
     */
    private function login($username, $password)
    {
        //获取用户数据
        $where = array(['account', '=', $username]);
        $user = $this->user->findFirst($where, ['id', 'account', 'password', 'user_name', 'phone', 'status']);
        if ((!empty($user) && md5($password) === $user['password'])) {
            if ($user['status'] == 1) {
                Session::put(config('custom.AdminUser'), $user);
                return $user['id']; //登录成功，返回用户ID
            } else {
                return -1; //用户不存在或被禁用
            }
        } else {
            return -2; //密码错误
        }
    }

    /**
     * 退出登录
     * get: /admin/sign/logout
     */
    public function logout()
    {
        //添加记录
        $user = Session::get(config('custom.AdminUser'));
        if (empty($user)) {
            return redirect('/admin/sign');
        }
        Session::forget(config('custom.AdminUser'));
        Session::forget(config('custom.AdminMenu'));
        return redirect('/admin/sign');
    }

}
