<?php

namespace App\tags;

use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    protected $table = 'tags';
    protected $fillable = [
        'item_id',
        'tag_text',
        'soft_delete'
    ];
 
    public function item()
    {
        return $this->belongsTo(ItemModel::class, 'item_id', 'id');
    }
}
