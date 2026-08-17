<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReferralModel extends Model
{
    protected $table = 'referrals';

    protected $fillable = [
        
        'referral_method'
    ];

}
