<?php

namespace App\sales;

use App\item\ItemModel;
use App\purchase\PurchaseItemBarcode;
use Illuminate\Database\Eloquent\Model;

class SalesDetailNewLog extends Model
{
    protected $table = 'sales_detail_new_logs';
    protected $fillable = [
        'sales_log_id',
        'sale_detail_id',
        'product_id',
        'barcode_id',
        'product_name',
        'quantity',
        'unit_price',
        'price',
        'cost_price',
        'regular_price',
        'details_created_by',
        'details_updated_by',
        'soft_delete',
        'created_by'
    ];

    public function purchase_item_barcodes_log(){
        return $this->belongsTo(PurchaseItemBarcode::class, 'barcode_id', 'id');
    }

    public function item_log(){
        return $this->belongsTo(ItemModel::class, 'product_id', 'id');
    }

}
