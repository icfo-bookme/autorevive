<?php

namespace App\sales;

use Illuminate\Database\Eloquent\Model;

class SaleLogModel extends Model
{
    protected $table = 'sale_logs';
    
    protected $fillable = [
        'sales_id',
        'order_id',
        'first_name',
        'last_name',
        'phone_number',
        'email',
        'city',
        'order_notes',
        'status',
        'price',
        'cost_price',
        'is_shipment_charge_applied',
        'discount_amount',
        'advance_payment',
        'collected_payment',
        'payment_due',
        'sales_by',
        'sales_created_at',
        'created_by',
        'updated_by',
        'soft_delete'
    ]; 
}
