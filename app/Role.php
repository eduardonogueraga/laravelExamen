<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public static function getList()
    {
        return ['admin', 'user'];
    }
}
