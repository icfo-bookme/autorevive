<?php

namespace App\purchase;

use Illuminate\Database\Eloquent\Model;
use App\purchase\PurchaseModel;
use App\purchase\PurchaseItemBarcode;
use App\item\ItemModel;

class PurchaseDetailsModel extends Model
{
    protected $table = 'purchase_details';

    protected $fillable =[
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
        'soft_delete',
        'barcode',
        'is_barcode'
    ];

    public function item(){
        return $this->belongsTo(ItemModel::class, 'item_id', 'id');
    }
    public function purchase(){
        return $this->belongsTo(PurchaseModel::class, 'purchase_id', 'id');
    }
    public function purchase_item_barcode(){
        return $this->belongsTo(PurchaseItemBarcode::class, 'id', 'purchase_detail_id')->with('stock');
    }
}
