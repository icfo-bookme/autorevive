<?php

namespace App\welcomeCall;
use App\customer\CustomerModel;

use Illuminate\Database\Eloquent\Model;

class WelcomeCallModel extends Model
{

    protected $table = 'welcome_call';

    protected $fillable = [
        'customer_id',
        'status',
        'soft_delete',
        'created_by'
    ];  

    public function customer(){
        return $this->hasOne(CustomerModel::class,'id','customer_id');

    }
    
}
