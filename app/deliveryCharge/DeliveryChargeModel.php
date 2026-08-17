<?php

namespace App\deliveryCharge;
use Illuminate\Database\Eloquent\Model;
class DeliveryChargeModel extends Model
{

    protected $table = 'charges';

    protected $fillable = [
         'name',
         'amount',
         'created_by',
         'updated_by',
         'soft_delete'
    ];


}
