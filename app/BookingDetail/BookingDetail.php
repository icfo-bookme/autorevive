<?php

namespace App\BookingDetail;

use App\purchase\PurchaseItemBarcode;
use App\stock\StockModel;
use Illuminate\Database\Eloquent\Model;
use App\item\ItemModel;

class BookingDetail extends Model
{
    protected $table = 'booking_details';

    protected $fillable =[
        'booking_id',
        'product_id',
        'barcode_id',
        'product_name',
        'quantity',
        'unit_price',
        'total_price',
        'cost_price',
        'soft_delete',
        'created_by'
    ];

    public function product_detail()
    {
        return $this->hasOne(ItemModel::class,'id','product_id')->latest();
    }

    public function purchase_item_barcodes()
    {
        return $this->belongsTo(PurchaseItemBarcode::class,'barcode_id','id');
    }

    public function stocks()
    {
        return $this->belongsTo(StockModel::class,'barcode_id','item_barcodes_id');
    }
}
