<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentMethodModel extends Model
{
    protected $table = 'payment_method';
    protected $fillable = [

        'payment_method'
        
    ];
}
