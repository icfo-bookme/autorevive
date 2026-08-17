<?php

namespace App\sales;

use Illuminate\Database\Eloquent\Model;
use App\OrderModel;
use App\SalesDuePayment\SalesDuePayment;
class SalesModel extends Model
{
    protected $table = 'sales';
    protected $fillable = [
        'order_id',
        'first_name',
        'last_name',
        'phone_number',
        'email',
        'city',
        'company_name',
        'order_notes',
        'status',
        'price',
        'cost_price',
        'is_shipment_charge_applied',
        'discount_amount',
        'advance_payment',
        'collected_payment',
        'is_due_paid',
        'payment_due',
        'is_cancelled',
        'cancelled_by',
        'cancelled_at',
        'sales_by',
        'invoice_date',
        'completed_at',
        'created_by',
        'updated_by',
        'soft_delete',
    ];

    //total sale price
    public function total_price(){
        return $this->hasMany(SalesDetailsModel::class,'sales_id','id')->where('soft_delete',0)->selectRaw('sales_details.sales_id,SUM(sales_details.price) as total')->groupBy('sales_details.sales_id');
    }

    //total cost price
    public function total_cost_price(){
        return $this->hasMany(SalesDetailsModel::class,'sales_id','id')->where('soft_delete',0)->selectRaw('sales_details.sales_id,SUM(sales_details.cost_price * quantity) as totalCost')->groupBy('sales_details.sales_id');
    }

    public function order(){
        return $this->belongsTo(OrderModel::class,'order_id','id');
    }


    public function sales_due_payment(){
        return $this->hasMany(SalesDuePayment::class,'sales_id','id');
    }


}
