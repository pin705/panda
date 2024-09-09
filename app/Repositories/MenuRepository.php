<?php

namespace App\Repositories;

use App\Models\AuthMenu;
use App\Models\AuthUserRole;
use App\Models\AuthUser;
use App\Models\AuthRoleMenu;
use Session;
class MenuRepository extends AbstractRepository{

    static $USER_ROLE;
    static $USER;
    static $ROLE_MENU;
    static $Table;

    /**
     * construct
     * @param \App\Models\AuthMenu $menu
     * @param \App\Models\AuthRoleMenu $roleMenu
     * @param \App\Models\AuthUser $user
     * @param \App\Models\AuthUserRole $userRole
     */
    public function __construct(
        AuthMenu $menu,
        AuthRoleMenu $roleMenu,
        AuthUser $user,
        AuthUserRole $userRole){
        $this->model = $menu;
        self::$USER_ROLE = $userRole->getTable();
        self::$USER = $user->getTable();
        self::$ROLE_MENU = $roleMenu->getTable();
        self::$Table = $this->model->getTable();
    }

    public function getMenu($uid){
        if($uid == 1){
            //超级管理员(总后台)
            $data = $this->model->where('status','=',1)->where('store_id','=',0)->where('is_top','=',1)
                ->orderBy('sort','asc')
                ->get(['id','parent_id','menu_name','lever','url','status']);
        }else{
            //普通用户（总后台）
            $data = $this->model->where(self::$Table.'.status','=',1)->orderBy(self::$Table.'.sort','asc')
                ->leftJoin(self::$ROLE_MENU.' as rm','rm.menu_id','=',self::$Table.'.id')
                ->leftJoin(self::$USER_ROLE.' as ur','ur.role_id','=','rm.role_id')
                ->leftJoin(self::$USER.' as u','u.id','=','ur.user_id')->where('u.id','=',$uid)
                ->get([
                    self::$Table.'.id',
                    self::$Table.'.parent_id',
                    self::$Table.'.menu_name',
                    self::$Table.'.lever',
                    self::$Table.'.url',
                    self::$Table.'.status'
                ]);
        }
        return $data;
    }

    /**
     * 分页查询
     * @param array $where
     * @return list
     */
    public function searchPage($con){
        $model = $this->model;
        //分页查询
        $model = $model->leftJoin(self::$Table.' as m2','m2.id','=',self::$Table.'.parent_id');
        if(!empty($con['parent_id'])){
            $model = $model->where(self::$Table.'.parent_id','=',$con['parent_id']);
        }else{
            $model = $model->where(self::$Table.'.parent_id','=',0);
        }
        if(!empty($con['search'])){
            $model = $model->where(self::$Table.'.menu_name', 'like', '%'.$con['search'].'%');
        }
        $model = $model->orderBy(self::$Table.'.sort','asc');
        $query = [
            self::$Table.'.id',
            'm2.menu_name as parent_name',
            self::$Table.'.menu_name',
            self::$Table.'.sort',
            self::$Table.'.level',
            self::$Table.'.url',
            self::$Table.'.status',
        ];
        $curPage = intval($con['start']/$con['length']+1);
//        dd($query);
        $menu = $model->paginate($con['length'], $query, 'page', $curPage);//分页方法查询

        $data['recordsTotal'] = $menu->total();//总条数
        $data['recordsFiltered'] = $menu->total();//总条数
        $data['data'] = array();
        for ($i = 0;$i<count($menu);$i++){
            $data['data'][] = $menu[$i];
        }
        return $data;
    }

    /**
     * 根据id获取所有权限
     * @param number $uid
     * @return array
     */
    public function getAuth($uid){
        $model = $this->model;
        $user = Session::get(config('custom.AdminUser'));
        if($user['store_id'] == 0){
            $is_top = 1;
        }else{
            $is_top = 2;
        }
        $model = $model->leftJoin(self::$ROLE_MENU.' as rm','rm.menu_id','=',self::$Table.'.id')
            ->leftJoin(self::$USER_ROLE.' as ur','ur.role_id','=','rm.role_id')
            ->leftJoin(self::$USER.' as u','u.id','=','ur.user_id')
            ->where(self::$Table.'.status','=',1)->where(self::$Table.'.is_top','=',$is_top);
        if($uid != 1){
            $model = $model->where('u.id','=',$uid);
        }
        return $model->orderBy(self::$Table.'.id','asc')
            ->get([
                self::$Table.'.id',
                self::$Table.'.parent_id',
                self::$Table.'.menu_name',
                self::$Table.'.lever',
                self::$Table.'.url']);
    }

    /**
     * 根据权限获取菜单id
     * @param number $roleId
     * @return array
     */
    public function getRoleAuth($roleId){
        return $this->model->leftJoin(self::$ROLE_MENU.' as rm','rm.menu_id','=',self::$Table.'.id')
            ->where('rm.role_id','=',$roleId)->get([self::$Table.'.id']);
    }

}