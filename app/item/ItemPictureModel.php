<?php

namespace App\item;

use Illuminate\Database\Eloquent\Model;
use App\item\ItemModel;
class ItemPictureModel extends Model
{
    protected $table = 'item_picture';
    protected $fillable =[
        'item_id',
        'image_path',
        'created_by',
        'updated_by',
        'soft_delete'
    ];


     public function item(){
        return $this->belongsTo(ItemModel::class, 'item_id', 'id');
    }
    
  
    
}
