<?php

namespace App\Booking;

use Illuminate\Database\Eloquent\Model;
use App\AdvancePayment\AdvancePayment;

class Booking extends Model
{
    protected $table = 'bookings';

    protected $fillable = [
        'sale_id',
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
        'house_no',
        'flat_no',
        'car_no',
        'status',
        'created_by',
        'invoice_date',
        'advance_payment',
        'discount_amount',
        'shipping_amount',
        'booking_notes',
        'customer_notes',
        'remarks',
        'updated_by'
    ];

    public function payment_in_advance(){
        return $this->hasOne(AdvancePayment::class,'booking_id','id')->latest();
      }
}
