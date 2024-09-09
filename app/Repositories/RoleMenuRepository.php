<?php

namespace App\Repositories;

use App\Models\AuthRoleMenu;
use DB,Exception;

class RoleMenuRepository extends AbstractRepository{

    /**
     * construct
     * @param \App\Models\AuthRoleMenu $roleMenu
     */
    public function __construct(AuthRoleMenu $roleMenu){
        $this->model = $roleMenu;
    }

    /**
     * 添加权限
     * @param number $roleId array $permissionIds
     * @return bool
     */
    public function addAuth($roleId,$permissionIds){
        $model = $this->model;
        DB::beginTransaction();
        try{
            $role = $model->where('role_id','=',$roleId)->get(['id']);
            if(!empty($role)){
                $row = $model->where('role_id','=',$roleId)->delete();
                if($row <= 0){
                    DB::rollBack();
                }
            }
            for ($i = 0; $i < count($permissionIds); $i++) {
                $row1 = $model->create([
                    'menu_id'=>$permissionIds[$i],
                    'role_id'=>$roleId
                ]);
                if(!$row1){
                    DB::rollBack();
                }
            }
            DB::commit();
            return true;
        }catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }

}
