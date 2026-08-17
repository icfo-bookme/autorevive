<?php

namespace App\shipment;

use Illuminate\Database\Eloquent\Model;
use App\OrderModel;
use App\User;

class ShipmentModel extends Model
{
    protected $table = 'shipment';
    protected $fillable = [
        'order_id',
        'delivery_team_id',
        'deadline_date',
        'deadline_time',
        'created_by',
        'priority',
        'completed_at',
        'updated_by',
        'soft_delete'
    ];

    public function orders(){
        return $this->hasOne(OrderModel::class,'id','order_id')->where('is_approve', 1)
                                                            ->where('is_rejected', 0)
                                                            ->where('shipment_assigned', 1)
                                                            ->where('is_shipment', 0)
                                                            ->where('soft_delete',0);

    }

    public function orderReport() {
        return $this->hasOne(OrderModel::class,'id','order_id')
                    ->where('is_approve', 1)
                    ->where('is_rejected', 0)
                    ->where('shipment_assigned', 1)
                    ->where('soft_delete', 0);
    }

    public function user(){
        return $this->belongsTo(User::class,'delivery_team_id','id');
    }
}
