<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MAC extends Model
{
    //
    protected $table = 'users_mac_address';

    protected $fillable = [
        'user_id',
        'mac'

    ];
}
