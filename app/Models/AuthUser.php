<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AuthUser
 */
class AuthUser extends Model
{
    protected $table = 'auth_user';

    public $timestamps = true;

    protected $fillable = [
        'account',
        'password',
        'phone',
        'status',
        'user_name'
    ];

    protected $guarded = [];

    //用户对应角色
    public function roles() {
        return $this->belongsToMany('App\Models\AuthRole', 'auth_user_role', 'user_id', 'role_id');
    }
        
}