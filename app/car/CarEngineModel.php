<?php

namespace App\car;

use Illuminate\Database\Eloquent\Model;

class CarEngineModel extends Model
{
    protected $table = 'car_engines';
    protected $fillable = [
        'car_engine',
        'company_id',
        'brand_id',
        'model_id',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'soft_delete'
    ];
}
