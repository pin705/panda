<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AuthRoleMenu
 */
class AuthRoleMenu extends Model
{
    protected $table = 'auth_role_menu';

    public $timestamps = true;

    protected $fillable = [
        'role_id',
        'menu_id'
    ];

    protected $guarded = [];

        
}