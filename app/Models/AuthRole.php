<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AuthRole
 */
class AuthRole extends Model
{
    protected $table = 'auth_role';

    public $timestamps = true;

    protected $fillable = [
        'role_name',
        'identifier',
        'remark',
        'status'
    ];

    protected $guarded = [];

    //用户对应菜单
    public function menus() {
        return $this->belongsToMany('App\Models\AuthMenu', 'auth_role_menu', 'role_id', 'menu_id');
    }
        
}