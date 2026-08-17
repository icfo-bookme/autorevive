<?php

namespace App\sales;

use Illuminate\Database\Eloquent\Model;
use App\purchase\PurchaseItemBarcode;
use App\stock\StockModel;
use App\item\ItemModel;

class SaleLogDetailModel extends Model
{
    protected $table = 'sale_detail_logs';
    
    protected $fillable =[
        'sale_detail_id',
        'sales_id',
        'order_id',      
        'product_id',
        'barcode_id',
        'stock',
        'product_name',
        'quantity',
        'price',
        'created_by',
        'updated_by',
        'soft_delete'
    ];

    public function item_log(){
        return $this->belongsTo(ItemModel::class, 'product_id', 'id');
    }
    public function purchase_item_barcodes_log(){
        return $this->belongsTo(PurchaseItemBarcode::class, 'barcode_id', 'id');
    }
    public function stocks_log()
    {
        return $this->belongsTo(StockModel::class,'barcode_id','item_barcodes_id');
    }

}
