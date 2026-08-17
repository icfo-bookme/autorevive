<?php

namespace App\car;

use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    protected $table = 'car';
    protected $fillable = [
        'car_company',
        'created_by',
        'updated_by',
        'soft_delete'
    ];
}
