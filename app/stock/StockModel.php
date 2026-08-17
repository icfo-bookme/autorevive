<?php

namespace App\stock;

use App\purchase\PurchaseItemBarcode;
use Illuminate\Database\Eloquent\Model;
use App\item\ItemModel;
use App\purchase\PurchaseDetailsModel;

class StockModel extends Model
{
    protected $table = 'stocks';
    protected $fillable = [
        'item_id',
        'item_barcodes_id',
        'barcode',
        'quantity',
        'uom',
        'cost_price',
        'created_by',
        'updated_by',
        'soft_delete',
        'duplicate_flag',
        'isPublic',
        'stock_out_display'
    ];


    public function item(){
        return $this->belongsTo(ItemModel::class, 'item_id', 'id');
    }
    public function purchase_item_barcode(){
        return $this->belongsTo(PurchaseItemBarcode::class, 'item_barcodes_id', 'id');
    }

    // //inavalid relationship as there are same item id for multiple times
    // public function purchase_details(){
    //     return $this->belongsTo(PurchaseDetailsModel::class, 'item_id', 'item_id');
    // }


}
