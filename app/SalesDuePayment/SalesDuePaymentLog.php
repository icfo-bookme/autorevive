<?php

namespace App\SalesDuePayment;

use Illuminate\Database\Eloquent\Model;

class SalesDuePaymentLog extends Model
{
    protected $table = 'sales_due_payment_log';
    protected $fillable =[
        'sales_id',
        'paid_amount',      
        'collected_by',
        'due_collected_at'

    ];
}
