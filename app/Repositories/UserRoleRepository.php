<?php

namespace App\Repositories;

use App\Models\AuthUserRole;
use DB,Session;
class UserRoleRepository extends AbstractRepository{



    /**
     * construct
     * @param \App\Models\AuthUserRole $userRole
     */
    public function __construct(
        AuthUserRole $userRole){
        $this->model = $userRole;
    }


  

}
