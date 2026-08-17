<?php

namespace App;

use App\OrderDetailsModel;
use Illuminate\Database\Eloquent\Model;
use App\shipment\ShipmentModel;
use App\sales\SalesModel;
use App\pickup\PickupModel;
use App\PaymentCollectionModel;
class OrderModel extends Model
{
    protected $table = 'orders';
    protected $fillable = [
        'first_name',
        'last_name',
        'phone_number',
        'email',
        'country',
        'district',
        'city',
        'thana',
        'area',
        'road_no',
        'flat_no',
        'car_no',
        'order_code',
        'order_notes',
        'customer_notes',
        'delivery_type',
        'is_approve',
        'is_rejected',
        'rejected_by',
        'is_shipment',
        'is_payment',
        'status',
        'is_shipment_charge_applied',
        'discount_amount',
        'advance_payment',
        'collected_payment',
        'payment_due',
        'sales_by',
        'created_by',
        'updated_by',
        'soft_delete',
        'remarks'
    ];


    public function order_details(){
        return $this->hasMany(OrderDetailsModel::class,'order_id','id');
    }

    public function rescheduleReason(){
        return $this->hasMany(reasonModel::class,'order_id','id');
    }

    public function order_sum(){
        return $this->hasMany(OrderDetailsModel::class,'order_id','id')->where('soft_delete',0);
    }

    public function total_price(){
        return $this->hasMany(OrderDetailsModel::class,'order_id','id')->where('soft_delete',0)->selectRaw('order_details.order_id,SUM(order_details.price) as total') ->groupBy('order_details.order_id');
    }

    public function total_cost_price(){
        return $this->hasMany(OrderDetailsModel::class,'order_id','id')->where('soft_delete',0)->selectRaw('order_details.order_id,SUM(order_details.cost_price) as total') ->groupBy('order_details.order_id');
    }


    public function shipment(){
      return $this->hasOne(ShipmentModel::class,'order_id','id')->where('soft_delete',0)->latest();

    }

    public function pickup(){
      return $this->hasOne(PickupModel::class,'order_id','id')->latest();

    }

    public function payment(){
        return $this->hasOne(PaymentCollectionModel::class,'order_id','id')->where('soft_delete',0)->latest();

      }

    public function sales(){
      return $this->hasOne(SalesModel::class,'order_id','id')->select('created_at','id')->where('soft_delete',0);


    }




}
