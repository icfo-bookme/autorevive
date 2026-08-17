<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\CostInsert\CostCategory; 
use App\CostInsert\CostSubCategory;

class CostEditReason extends Model
{
    protected $fillable = [
        'cost_insert_id',
        'category_id',
        'subcategory_id',
        'amount',
        'prev_amount',
        'date',
        'description',
        'reason',
        'created_by'
    ];

    public function costInsert()
    {
        return $this->belongsTo(CostInsert::class);
    }
    
    public function category()
    {
        return $this->belongsTo(CostCategory::class, 'category_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(CostSubCategory::class, 'subcategory_id');
    }
}
