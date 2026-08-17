<?php

namespace App\customer;

use Illuminate\Database\Eloquent\Model;

use App\OrderModel;

class CustomerModel extends Model
{
    protected $table = 'customers';

    protected $fillable = [
        // 'name',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'country',
        'district',
        'city',
        'thana',
        'area',
        'road_no',
        'house_no',
        'flat_no',
        'car_no',
        'created_by',
        'updated_by',
        'soft_delete'
        // 'about_us',
    ];



    public function car_numbers($email){
        return OrderModel::where('soft_delete', 0)->where('email', $email)->whereNotNull('car_no')->select('car_no')->get();
      
    }


    // public function orders(){
    //     return $this->hasMany(OrderModel::class,'order_id','id');
    // }



    
}
