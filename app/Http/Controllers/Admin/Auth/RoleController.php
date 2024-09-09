<?php
namespace App\Http\Controllers\Admin\Auth;

use App\Repositories\AuthMenuRepository;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use App\Repositories\UserRoleRepository;
use App\Repositories\RoleMenuRepository;
use Request, Response, Session, Config;
use Illuminate\Routing\Controller;

/**
 * 后台权限——角色管理
 * Date: 2017-1-13
 * Class RoleController
 * @package App\Http\Controllers\Admin\Seventeen\Auth
 */
class RoleController extends Controller
{

    static $views = 'admin.auth.role.';


    protected $user;
    protected $role;
    protected $menu;
    protected $role_menu;
    protected $user_role;

    /**
     * constructor.
     */
    function __construct(UserRepository $user,
                         RoleRepository $role,
                         AuthMenuRepository $menu,
                         RoleMenuRepository $role_menu,
                         UserRoleRepository $user_role)
    {
        $this->user = $user;
        $this->role = $role;
        $this->menu = $menu;
        $this->role_menu = $role_menu;
        $this->user_role = $user_role;

    }

    /**
     * 首页
     * get: /admin/auth/role/index
     */
    public function index()
    {
        return view(self::$views . 'index');
    }

    /**
     * 分页查询
     * get: /admin/auth/role/searchPage
     */
    public function searchPage()
    {
        $con['search'] = Request::input('search')['value'];//表格自带搜索功能
        $draw = (int)Request::input('draw');//请求的次数，不用管
        $con['length'] = (int)Request::input('length', 10);// 每页显示数量
        $con['start'] = (int)Request::input('start');// 查询的起始数 默认为0
        $data = $this->role->searchPage($con);
        $data['draw'] = $draw;//表格参数不用管
        return Response::json($data);
    }

    /**
     * 启用/禁用
     * post: /admin/auth/role/isOpen
     */
    public function isOpen()
    {
        //获取数据
        $id = Request::input('id');
        $data['status'] = Request::input('status');
        if($data['status'] == 1){
            //判断是否由用户组
            $where = array(['role_id', '=', $id]);
            $roleMenuList = $this->role_menu->findWhere($where, ['role_id', 'menu_id']);
            if( count($roleMenuList) <= 0 ){
                return "notnone";
            }
        }
        $row = $this->role->update($id, $data);
        if ($row) {
            //添加日志
//            createLog('角色管理模块', '启用/禁用角色，id为' . $id);
            return "true";
        } else
            return "false";
    }

    /**
     * 删除角色
     * post: /admin/auth/role/delete
     */
    public function delete()
    {
        $id = Request::input('id');
        $row = $this->role->delete($id);
        if ($row) {
            $this->user_role->deleteWhere(array(['role_id', '=', $id]));
            //添加日志
//            createLog('角色管理模块', '删除角色，id为' . $id);
            return "true";
        }
        return "false";
    }

    /**
     * 更新页面
     * get: /admin/auth/role/update
     */
    public function update()
    {
        $id = Request::input('id');
        $view = view(self::$views . 'update');
        if (!empty($id)) {
            $role = $this->role->find($id);
            $view = $view->with('role', $role);
        }
        return $view;
    }

    /**
     * 进行修改操作
     * post: /admin/auth/role/doEdit
     */
    public function doEdit()
    {
        $id = Request::input('id');
        $role_name = Request::input('role_name');
        $remark = Request::input('remark');
        $data = [
            'role_name' => $role_name,
            'remark' => $remark
        ];
        $where = array();
        if (!empty($id)) {
            $where = array(['id', '=', $id]);
        }else{
            $data['status'] = 2;
        }
        $row = $this->role->updateOrCreate($data, $where);
        if ($row) {
            //添加日志
//            if (!empty($id)) {
//                createLog('角色管理模块', '修改角色，id为' . $id);
//            } else {
//                createLog('角色管理模块', '添加角色，id为' . $id);
//            }
            return "true";
        }
        return "false";
    }

    /**
     * 分配给角色分配权限的页面
     * get: /admin/auth/role/authorize
     */
    public function authorize()
    {
        $view = view(self::$views . 'authorize');
        $roleId = Request::input('id');
        $view->with('roleId', $roleId);
        //根据当前登录用户id查询
        $user = Session::get(config('custom.AdminUser'));
        $uid = $user->id;
        //根据用户id获取该用户拥有的权限
        $menuList = $this->menu->getAuth($uid);
        $view->with('menuList', $menuList);
        //根据角色查询该角色拥有的权限
        $menuRoleList = $this->role->find($roleId, ['*'], ['menus']);
        $menuRoleList = $menuRoleList->menus;
        $count = count($menuRoleList);
        $ids = '';
        for ($i = 0; $i < $count; $i++) {
            if ($i > 0) {
                $ids .= '-';
            }
            $query = $menuRoleList[$i];
            $ids .= $query->id;
        }
        $view->with('menuRoleList', $ids);
        return $view;
    }

    /**
     * 角色权限授权
     * post: /admin/auth/role/doAuthorize
     */
    public function doAuthorize()
    {
        $roleId = Request::input('roleId');
        $permissionIds = Request::input('permissionId');
        $row = $this->role_menu->addAuth($roleId, $permissionIds);
        if ($row) {
            //添加日志
//            createLog('角色管理模块', '分配角色权限');
            return "true";
        }
        return "false";
    }
}
