<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AuthMenu
 */
class AuthMenu extends Model
{
    protected $table = 'auth_menu';

    public $timestamps = true;

    protected $fillable = [
        'menu_name',
        'parent_id',
        'url',
        'level',
        'sort',
        'status'
    ];

    protected $guarded = [];

        
}