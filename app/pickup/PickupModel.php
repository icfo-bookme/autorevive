<?php

namespace App\pickup;

use Illuminate\Database\Eloquent\Model;
use App\OrderModel;
use App\User;

class PickupModel extends Model
{
    protected $table = 'pickup';
    protected $fillable = [
        'order_id',
        'pickup_date',
        'pickup_time',
        'completed_at',
        'completed_by',
        'created_by',
        'updated_by'
    ];


    public function orders(){
        return $this->hasOne(OrderModel::class,'id','order_id')->where('is_approve', 1)
                                                            ->where('is_rejected', 0)
                                                            ->where('shipment_assigned', 1)
                                                            ->where('is_shipment', 0)
                                                            ->where('soft_delete',0);

    }

}