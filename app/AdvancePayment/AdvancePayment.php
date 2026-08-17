<?php

namespace App\AdvancePayment;

use Illuminate\Database\Eloquent\Model;

class AdvancePayment extends Model
{
    protected $table = 'advance_payments';

    protected $fillable =[
        'booking_id',
        'payment_method_id',
        'paid_amount',
        'payable_amount',
        'payment_collected_by',
        'soft_delete'
    ];
    
    public function booking(){
        return $this->hasOne(Booking::class,'id','booking_id')->latest();
      }
}
