<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'host', 'api_key', 'number', 'uuid', 'max_token_count', 'enable'
    ];
}
