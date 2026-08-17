<?php

namespace App\vendor;

use Illuminate\Database\Eloquent\Model;

class VendorModel extends Model
{

    //Hello World Hhnkhn
    protected $table = 'vendor';
    protected $fillable = [
        'name',
        'address',
        'contact_person',
        'phone_number',
        'created_by',
        'updated_by',
        'status',
        'soft_delete'
    ];

}
