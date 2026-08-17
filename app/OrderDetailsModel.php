<?php

namespace App;

use App\item\ItemModel;
use App\stock\StockModel;
use App\purchase\PurchaseItemBarcode;
use Illuminate\Database\Eloquent\Model;


class OrderDetailsModel extends Model
{
    protected $table = 'order_details';
    protected $fillable = [
        'order_id',
        'product_id',
        'barcode_id',
        'product_name',
        'quantity',
        'unit_price',
        'price',
        'cost_price'
    ];


    public function item(){
        return $this->belongsTo(ItemModel::class, 'product_id', 'id');
    }
    public function purchase_item_barcodes(){
        return $this->belongsTo(PurchaseItemBarcode::class, 'barcode_id', 'id');
    }
    public function stocks()
    {
        return $this->belongsTo(StockModel::class,'barcode_id','item_barcodes_id');
    }

}
