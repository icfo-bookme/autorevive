<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\customer\CustomerModel;
use App\ReferralModel;

class CustomersReferralsDetailsModel extends Model
{
    protected $table = 'customers_referrals_details';

    protected $fillable = [
        'customer_id',
        'referral_id',
        
    ];

    public function customer()
    {
        return $this->belongsTo(CustomerModel::class, 'customer_id', 'id');
    }

    public function referral()
    {
        return $this->belongsTo(ReferralModel::class, 'referral_id', 'id');
    }


}
