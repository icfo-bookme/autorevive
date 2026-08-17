<?php

namespace App\CostInsert;

use Illuminate\Database\Eloquent\Model;
use App\CostInsert\CostInsert;
use App\CostInsert\CostCategory;
use App\CostInsert\CostSubCategory;

class CostInsertAudit extends Model
{
    protected $fillable = [
        'trigger_type',
        'cost_id',
        'category_id',
        'subcategory_id',
        'amount',
        'date',
        'description',
        'is_approved_by_superadmin',
        'is_approved_by_hop',
        'is_approved_by_manager',
        'is_approved_by_accounts',
        'is_approved_by_all',
        'created_by',
        'updated_by',
        'soft_delete',
        'created_at',
        'updated_at'

    ];

    public function cost()
    {
        return $this->belongsTo(CostInsert::class,'cost_id','id');
    }

    public function category()
    {
        return $this->belongsTo(CostCategory::class,'category_id','id');
    }

    public function subcategory()
    {
        return $this->belongsTo(CostSubCategory::class,'subcategory_id','id');
    }

    
}