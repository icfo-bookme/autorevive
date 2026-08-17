<?php

namespace App\stock;

use Illuminate\Database\Eloquent\Model;
use App\item\ItemModel;


class StockCount extends Model
{
    protected $table = 'stock_counts';
    protected $fillable = [
        'item_id',
        'item_name',
        'barcode',
        'quantity',
        'created_by',
        'updated_by'
    ];


    public function system_stock() {
        return $this->hasOne(StockModel::class, 'barcode', 'barcode')->where('soft_delete', 0);
    }

    // added by monir: 02.05.2024
    public function item(){
        return $this->belongsTo(ItemModel::class, 'item_id', 'id');
    }

}
