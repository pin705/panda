<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AuthUserRole
 */
class AuthUserRole extends Model
{
    protected $table = 'auth_user_role';

    public $timestamps = true;

    protected $fillable = [
        'role_id',
        'user_id'
    ];

    protected $guarded = [];

        
}