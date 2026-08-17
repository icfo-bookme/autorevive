<?php

namespace App\sales;

use App\User;
use Illuminate\Database\Eloquent\Model;

class SalesNewLog extends Model
{
    protected $table = 'sales_new_logs';
    protected $fillable = [
        'sales_id',
        'order_id',
        'first_name',
        'last_name',
        'phone_number',
        'email',
        'company_name',
        'address_1',
        'remarks',
        'country',
        'district',
        'city',
        'thana',
        'area',
        'road_no',
        'house_no',
        'flat_no',
        'car_no',
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
        'total_price',
        'paid_amount',
        'payment_method',
        'is_cancelled',
        'cancelled_by',
        'cancelled_at',
        'invoice_date',
        'completed_at',
        'sales_by',
        'sales_updated_by',
        'created_by',
        'soft_delete'
    ];


    public function user(){
        return $this->belongsTo(User::class,'created_by','id');
    }

}
