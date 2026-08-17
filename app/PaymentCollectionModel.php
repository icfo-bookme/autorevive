<?php

namespace App;

use App\sales\SalesModel;
use Illuminate\Database\Eloquent\Model;

class PaymentCollectionModel extends Model
{
    protected $table = 'payment_collection';
    protected $fillable = [
        'order_id',
        'payment_method_id',
        'invoice_amount',
        'total_amount',
        'payment_collected_by'
    ];


    public function payment_method(){
        return $this->hasOne(PaymentMethodModel::class,'id','payment_method_id')->latest();

      }

      public function order()
      {
          return $this->belongsTo(OrderModel::class,'order_id','id');
      }

    public function sales()
    {
        return $this->belongsTo(SalesModel::class,'order_id','order_id');
    }
}
