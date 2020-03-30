<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    //

    protected $fillable = [
        'id',
        'method',
        'description',
        'rule_set',
        'enabled',
        'consumer',
        'title',
    ];
}
