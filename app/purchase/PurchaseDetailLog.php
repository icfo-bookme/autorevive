<?php

namespace App\purchase;

use Illuminate\Database\Eloquent\Model;
use App\item\ItemModel;

class PurchaseDetailLog extends Model
{
    protected $table = 'purchase_detail_logs';
    
    protected $fillable =[
        'purchase_log_id',
        'purchase_detail_id',
        'purchase_id',
        'item_id',
        'cost_price',
        'sales_price',
        'wholesale_price',
        'mrp',
        'quantity',
        'uom',
        'expired_date',
        'created_by',
        'updated_by',
        'soft_delete'
    ];

    public function item(){
        return $this->belongsTo(ItemModel::class, 'item_id', 'id');
    }
}
