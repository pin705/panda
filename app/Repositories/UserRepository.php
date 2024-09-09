<?php

namespace App\Repositories;

use App\Models\AuthUser;
use App\Models\AuthUserRole;
use App\Models\AuthRole;
use DB,Session;
class UserRepository extends AbstractRepository{

    static $USER_ROLE;
    static $ROLE;
    static $Table;

    /**
     * construct
     * @param \App\Models\AuthUser $user
     * @param \App\Models\AuthUserRole $userRole
     * @param \App\Models\AuthRole $role
     */
    public function __construct(
        AuthUser $user,
        AuthUserRole $userRole,
        AuthRole $role){
        $this->model = $user;
        self::$USER_ROLE = $userRole->getTable();
        self::$ROLE = $role->getTable();
        self::$Table = $this->model->getTable();
    }

    /**
     * 分页查询
     * @param $con 条件
     * @return mixed
     */
    public function searchPage($con){
        $page = intval($con['start']/$con['length']+1);
        $model = $this->model;
        $model = $model->where('id','>',1);
        if(!empty($con['search'])){
            $model = $model->whereRaw('CONCAT_WS(\',\','.self::$Table.'.account,'.self::$Table.'.phone) LIKE \'%'.$con['search'].'%\'');
        }
        if(!empty($con['role_id'])){
            $model = $model->whereHas('roles',function($query) use($con){
                $query->where('role_id', '=', $con['role_id']);
            });
         }
        $list = $model->with(['roles' => function($query) {
          $query->select('role_name');
        }])->paginate($con['length'], ['*'], 'page', $page);
        $data['data'] = array();
        for ($i = 0;$i<count($list);$i++){
            $data['data'][] = $list[$i];
        }
        $data['recordsTotal'] = $list->total();
        $data['recordsFiltered'] =  $list->total();
        return $data;
    }
}
