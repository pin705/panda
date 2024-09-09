<?php

namespace App\Http\Controllers\Admin\Auth;

use Request, Response, Session, Config;
use Illuminate\Routing\Controller;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use App\Repositories\UserRoleRepository;

/**
 * 后台权限——用户管理
 * Date: 2017-1-13
 * Class UserController
 * @package App\Http\Controllers\Admin\Seventeen\Auth
 */
class UserController extends Controller
{

    static $views = 'admin.auth.user.';

    protected $user;
    protected $role;
    protected $user_role;

    /**
     * constructor.
     */
    function __construct(UserRepository $user,
                         RoleRepository $role,
                         UserRoleRepository $user_role)
    {
        $this->user = $user;
        $this->role = $role;
        $this->user_role = $user_role;
    }

    /**
     * 首页
     * get: /admin/auth/user/index
     */
    public function index()
    {
        $user = Session::get(config('custom.AdminUser'));
        //查询角色全部
        $where = array(['status', '=', 1]);
        $roleList = $this->role->findWhere($where, ['id', 'role_name']);
        return view(self::$views . 'index', ['roleList' => $roleList]);
    }

    /**
     * 获取用户组
     * get: /admin/auth/user/getInfo
     */
    public function getInfo()
    {
        //查询角色全部
        $where = array(['status', '=', 1]);
        $data = $this->role->findWhere($where, ['id', 'role_name']);
        return Response::json($data);
    }

    /**
     * 分页查询
     * get: /admin/auth/user/searchPage
     */
    public function searchPage()
    {
        $con['search'] = Request::input('search')['value'];
        $con['role_id'] = Request::input('role_id');
        $draw = (int)Request::input('draw');//请求的次数，不用管
        $con['length'] = (int)Request::input('length', 10);// 每页显示数量
        $con['start'] = (int)Request::input('start');// 查询的起始数 默认为0
        $data = $this->user->searchPage($con);
        ///表格参数不用管
        $data['draw'] = $draw;
        return Response::json($data);
    }

    /**
     * 启用/禁用
     * post: /admin/auth/user/isOpen
     */
    public function isOpen()
    {
        $id = Request::input('id');
        $data['status'] = Request::input('status');
        if($data['status'] == 1){
            //判断是否由用户组
            $where = array(['user_id', '=', $id]);
            $userRoleList = $this->user_role->findWhere($where, ['user_id', 'role_id']);
            if( count($userRoleList) <= 0 ){
                return "notnone";
            }
        }
        $row = $this->user->update($id, $data);
        if ($row) {
//			createLog('用户管理模块', '启用/禁用用户，id为'.$id);
            return "true";
        }
        return "false";
    }

    /**
     * 修改密码页面 password.blade
     * get: /admin/auth/user/password
     */
    public function password()
    {
        return view(self::$views . 'password');
    }


    /**
     * 修改密码
     * post: /admin/auth/user/editPassword
     */
    public function editPassword()
    {
        //密码
        $data['password'] = md5(Request::input('password'));
        //添加日志
        $user = Session::get(config('custom.AdminUser'));
        if (empty($user)) {
            return "false";
        }
        $uid = $user->id;
        $row = $this->user->update($uid, $data);
        if ($row) {
//			createLog('用户管理模块', '用户修改密码');
            Session::forget(config('custom.AdminUser'));
            Session::forget(config('custom.AdminMenu'));
            return "true";
        }
        return "false";
    }

    /**
     * 更新页面
     * get: /admin/auth/user/update
     */
    public function update()
    {
        $id = Request::input('id');
        $view = view(self::$views . 'update');
        if (!empty($id)) {
            $user = $this->user->find($id, ['id', 'account', 'phone', 'user_name']);
            $view->with('user', $user);
            //根据角色Id获取已被授权的用户
            $where = array(['user_id', '=', $id]);
            $userRoleList = $this->user_role->findWhere($where, ['user_id', 'role_id']);
            $count = count($userRoleList);
            $ids = '';
            for ($i = 0; $i < $count; $i++) {
                if ($i > 0) {
                    $ids .= '-';
                }
                $query = $userRoleList[$i];
                $ids .= $query['role_id'];
            }
            $view->with('roleIds', $ids);
        }
        $where = array(['status', '=', 1]);
        $roleList = $this->role->findWhere($where);
        $view->with('roleList', $roleList);
        return $view;
    }

    /**
     * 验证登录名是否重复
     * post: /admin/auth/user/validataName
     */
    public function validataName()
    {
        $id = Request::input('id');
        $account = Request::input('account');
        $where = array(
            ['account', '=', $account],
        );
        if (!empty($id)) {
            array_push($where, ['id', '!=', $id]);
        }
        $first = $this->user->findFirst($where);
        if (empty($first)) {
            return response()->json(['valid' => 'true']);
        }
        return response()->json(['valid' => 'false']);
    }

    /**
     * 验证手机是否重复
     * post: /admin/auth/user/validataPhone
     */
    public function validataPhone()
    {
        $id = Request::input('id');
        $phone = Request::input('phone');
        $where = array(
            ['phone', '=', $phone],
        );
        if (!empty($id)) {
            array_push($where, ['id', '!=', $id]);
        }
        $first = $this->user->findFirst($where);
        if (empty($first)) {
            return response()->json(['valid' => 'true']);
        }
        return response()->json(['valid' => 'false']);
    }

    /**
     * 进行修改操作
     * post: /admin/auth/user/doEdit
     */
    public function doEdit()
    {
        $data['account'] = Request::input('account');
        $data['phone'] = Request::input('phone');
        $data['user_name'] = Request::input('user_name');
        $id = Request::input('id');
        $user = Session::get(config('custom.AdminUser'));
        $uid = $user->id;
        $where = array();
        if (!empty($id)) {
            $searchUser = $this->user->find($id);
            if (empty($searchUser)) {
                return "false";
            }
            $where = array(['id', '=', Request::input('id')]);
//			createLog('用户管理模块', '修改用户，id为'.$id);
        } else {
            $data['password'] = md5(Request::input('password'));
            $data['status'] = 2;
//			createLog('用户管理模块', '添加用户');
        }
        $row = $this->user->updateOrCreate($data, $where);
        if ($row) {
            return "true";
        }
        return "false";
    }

    /**
     * 分配用户组的页面 choose.blade
     * get: /admin/auth/user/choose
     */
    public function choose()
    {
        $user = Session::get(config('custom.AdminUser'));
        $userId = Request::input('id');
        //查询所有的用户
        $condition = array(['status', '=', 1]);
        $roleList = $this->role->findWhere($condition);
        //根据角色Id获取已被授权的用户
        $where = array(['user_id', '=', $userId]);
        $userRoleList = $this->user_role->findWhere($where, ['user_id', 'role_id']);
        $count = count($userRoleList);
        $ids = '';
        for ($i = 0; $i < $count; $i++) {
            if ($i > 0) {
                $ids .= '-';
            }
            $query = $userRoleList[$i];
            $ids .= $query['role_id'];
        }
        return view(self::$views . 'choose')->with('roleIds', $ids)->with('roleList', $roleList)->with('userId', $userId);
    }

    /**
     * 分配角色
     * post: /admin/auth/user/doChooseRole
     */
    public function doChooseRole()
    {
        $roleIds = Request::input('roleId');
        $userId = Request::input('userId');
        $condition = array(
            ['user_id', '=', $userId]
        );
        $this->user_role->deleteWhere($condition);
        $flag = true;
        for ($i = 0; $i < count($roleIds); $i++) {
            $dataChildren = ['role_id' => $roleIds[$i], 'user_id' => $userId];
            // array_push($data,$dataChildren);
            $row = $this->user_role->create($dataChildren);
            if (!$row) {
                $flag = false;
            }
        }
        if ($flag) {
            //添加日志
//			createLog('用户管理模块', '分配权限');
            return "true";
        }
        return "false";
    }

    /**
     * 删除
     * post: /admin/auth/user/delete
     */
    public function delete()
    {
        $id = Request::input('id');
        $row = $this->user->delete($id);
        if ($row) {
            //添加日志
//			createLog('用户管理模块', '删除用户'.$id);
            return "true";
        }
        return "false";
    }
}
