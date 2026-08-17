<?php

namespace App\car;

use Illuminate\Database\Eloquent\Model;

class CarBrandModel extends Model
{
    protected $table = 'car_brands';
    protected $fillable = [
        'car_brand',
        'company_id',
        'created_by',
        'soft_delete'
    ];

}
