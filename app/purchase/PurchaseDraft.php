<?php

namespace App\purchase;

use Illuminate\Database\Eloquent\Model;

class PurchaseDraft extends Model
{
    protected $table = 'purchase_drafts';

    protected $fillable = [
        'purchase_id',
        'amount',
        'note',
        'is_purchased',
        'created_by',
        'updated_by',
        'soft_delete'
    ];

    public function purchase(){
        return $this->belongsTo(PurchaseModel::class, 'purchase_id', 'id');
    }
}
