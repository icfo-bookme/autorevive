<?php

namespace App\item;

use Illuminate\Database\Eloquent\Model;
use App\item\ItemModel;

class ItemSpecification extends Model
{
    protected $table = 'item_specification';
    protected $fillable = [
        'item_id',
        'name',
        'details',
        'created_by',
        'updated_by',
        'soft_delete',
    ];


    public function item(){
        return $this->belongsTo(ItemModel::class, 'item_id', 'id')->where('soft_delete',0);
    }

}
