<?php

namespace App\Brand;

use Illuminate\Database\Eloquent\Model;

class BrandModel extends Model
{
    protected $table = 'brand';
    protected $fillable = [

        'name',
        'created_by',
        'updated_by',
        'soft_delete'

    ];

}
