<?php

namespace App\SalesDuePayment;

use Illuminate\Database\Eloquent\Model;
use App\sales\SalesModel;

class SalesDuePayment extends Model
{
    protected $table = 'sales_due_payment';
    protected $fillable =[
        'sales_id',
        'paid_amount',      
        'collected_by'

    ];


    public function sales(){
        return $this->belongsTo(SalesModel::class,'sales_id','id');
        
    }


    
}
