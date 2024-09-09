<?php

namespace App\Repositories;

use App\Models\AuthRole;
use Session;
class RoleRepository extends AbstractRepository{
    /**
     * construct
     * @param \App\Models\AuthRole $role
     */
    public function __construct(AuthRole $role){
        $this->model = $role;
    }

    /**
     * 分页查询
     * @param $con 条件
     * @return mixed
     */
    public function searchPage($con){
        $page = intval($con['start']/$con['length']+1);;
        $model = $this->model;
        if(!empty($con['role_id'])){
          $model = $model->where('role_id', '=', $con['role_id']);
        }
        if(!empty($con['search'])){
            $model = $model->where('role_name', 'like', '%'.$con['search'].'%');
        }
        $model = $model->where('status','>',0);
        $list = $model->paginate($con['length'], ['id','role_name','identifier','remark','status'], 'page', $page);
        $data['data'] = array();
        for ($i = 0;$i<count($list);$i++){
            $data['data'][] = $list[$i];
        }
        $data['recordsTotal'] = $list->total();
        $data['recordsFiltered'] =  $list->total();
        return $data;
    }



}
