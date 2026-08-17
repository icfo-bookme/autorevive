<?php

namespace App\purchase;

use App\item\ItemModel;
use App\stock\StockModel;
use Illuminate\Database\Eloquent\Model;

class PurchaseItemBarcode extends Model
{
    protected $fillable = [
      'purchase_id',
      'purchase_detail_id',
      'item_id',
      'barcode',
      'soft_delete',
      'regular_price',
      'sales_price',
      'barcode_image'
    ];


    public function item(){
        return $this->belongsTo(ItemModel::class, 'item_id', 'id');
    }

    public function purchase_details(){
        return $this->belongsTo(PurchaseDetailsModel::class,'purchase_detail_id','id')->with('purchase');
    }

    public function stock(){
        return $this->hasOne(StockModel::class,'item_barcodes_id','id')->where('soft_delete',0);
    }

}
