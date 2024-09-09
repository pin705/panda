<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Log\AdminLog;
use App\Repositories\MenuRepository;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use App\Repositories\UserRoleRepository;
use Request, Response, Session;
use Illuminate\Routing\Controller;
use DB;

/**
 * 后台权限——菜单管理
 * Date: 2017-1-13
 * Class MenuController
 * @package App\Http\Controllers\Admin\Seventeen\Auth
 */
class MenuController extends Controller
{

    static $views = 'admin.auth.menu.';


    protected $user;
    protected $role;
    protected $menu;
    protected $user_role;

    /**
     * constructor.
     */
    function __construct(UserRepository $user,
                         RoleRepository $role,
                         MenuRepository $menu,
                         UserRoleRepository $user_role)
    {
        $this->user = $user;
        $this->role = $role;
        $this->menu = $menu;
        $this->user_role = $user_role;
    }

    /**
     * 菜单首页
     * get: /admin/auth/menu/index
     */
    public function index()
    {
        return view(self::$views . 'index');
    }

    /**
     * 分页查询
     * get: /admin/auth/menu/searchPage
     */
    public function searchPage()
    {
        $con['search'] = Request::input('search')['value'];//表格自带搜索功能
        $con['parent_id'] = (int)Request::input('parent_id');
        $draw = (int)Request::input('draw');//请求的次数，不用管
        $con['length'] = (int)Request::input('length', 10);// 每页显示数量
        $con['start'] = (int)Request::input('start',0);// 查询的起始数 默认为0
        $data = $this->menu->searchPage($con);
        $data['draw'] = $draw;//表格参数不用管
        return Response::json($data);
    }

    /**
     * 更新页面
     * get: /admin/auth/menu/update
     */
    public function update()
    {
        $view = view(self::$views . 'update');
        $id = Request::input('id');
        //查询一级菜单
        $where = array(['level', '=', 1]);
        $menuList = $this->menu->findWhere($where, ['id', 'parent_id', 'menu_name', 'url', 'level']);
        //根据ID查询这条纪录
        if (!empty($id)) {
            $menu = $this->menu->find($id);
            $view->with('menu', $menu);
        }
        return $view->with('menuList', $menuList);
    }

    /**
     * 排序修改
     * post: /admin/auth/menu/sortUpdate
     */
    public function sortUpdate()
    {
        $where = array(['id', '=', Request::input('id')]);
        $data = ['sort' => (int)Request::input('sort')];
        $row = $this->menu->updateWhere($where, $data);
        if ($row)
            return "true";
        return "false";
    }

    /**
     * 启用，禁用
     * post: /admin/auth/menu/isOpen
     */
    public function isOpen()
    {
        $id = Request::input('id');
        $data['status'] = Request::input('status');
        $row = $this->menu->update($id, $data);
        if ($row)
            return "true";
        return "false";
    }

    /**
     * 进行修改操作
     * post: /admin/auth/menu/doEdit
     */
    public function doEdit()
    {
        $input = Request::all();
        $level = 0;
        if (!empty($input['parent_id'])) {
            $menu = $this->menu->find($input['parent_id']);
            $level = $menu['level'];
        }
        $data = [
            'menu_name' => $input['menu_name'],
            'sort' => $input['sort'],
            'url' => $input['url'],
            'parent_id' => $input['parent_id'],
            'level' => $level + 1
        ];
        $where = array();
        if (!empty($input['id'])) {
            $where = array(['id', '=', $input['id']]);
        }
        $row = $this->menu->updateOrCreate($data, $where);
        if ($row) {
            return "true";
        }
        return "false";
    }


    /**
     * 删除菜单
     * post: /admin/auth/menu/del
     */
    public function del()
    {
        //获取模型
        $id = Request::input('id');
        if (!empty($id)) {
            $where = array(['id', '=', $id]);
            $row = $this->menu->deleteWhere($where);
            if ($row) {
                return "true";
            }
        }
        return "false";
    }


}
