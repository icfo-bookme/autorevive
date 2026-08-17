<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CashFlowModel extends Model
{
    protected $table = 'cash_flow';
    protected $fillable = [
        'user_id',
        'date',
        'description',
        'type',
        'payable_amount',
        'is_approved_by_inventory',
        'is_approved_by_supplychain',
        'is_approved_by_hop',
        'is_approved_by_ceo'
    ];


    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


}
