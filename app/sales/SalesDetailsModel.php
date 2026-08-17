<?php

namespace App\sales;

use App\item\ItemModel;
use App\purchase\PurchaseItemBarcode;
use Illuminate\Database\Eloquent\Model;

class SalesDetailsModel extends Model
{
    protected $table = 'sales_details';
    protected $fillable =[
        'sales_id',
        'order_id',
        'product_id',
        'barcode_id',
        'product_name',
        'quantity',
        'unit_price',
        'price',
        'cost_price',
        'created_by',
        'updated_by',
        'soft_delete',
        'created_at',
        'updated_at'
    ];


    public function sales(){
        return $this->belongsTo(SalesModel::class,'sales_id','id');

    }

    public function product(){
        return $this->belongsTo(ItemModel::class,'product_id','id');
    }

    public function barcode(){
        return $this->belongsTo(PurchaseItemBarcode::class,'barcode_id','id');
    }
}
