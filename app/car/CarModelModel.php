<?php

namespace App\car;

use Illuminate\Database\Eloquent\Model;
use App\car\CarBrandModel;

class CarModelModel extends Model
{
    protected $table = 'car_model';
    protected $fillable = [
        'car_model',
        'company_id',
        'brand_id',
        'created_by',
        'soft_delete'
    ];

    public function brandName(){
        return $this->belongsTo(CarBrandModel::class, 'brand_id', 'id');
    }

}
