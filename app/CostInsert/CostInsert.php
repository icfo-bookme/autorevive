<?php

namespace App\CostInsert;

use Illuminate\Database\Eloquent\Model;
use App\CostInsert\CostCategory;
use App\CostInsert\CostSubCategory;

class CostInsert extends Model
{
    protected $fillable = [
        'category_id',
        'subcategory_id',
        'amount',
        'date',
        'description',
        'is_approved_by_superadmin',
        'is_approved_by_hop',
        'is_approved_by_manager',
        'is_approved_by_accounts',
        'is_approved_by_opManager',
        'is_approved_by_all',
        'created_by',
        'updated_by',
        'soft_delete',
    ];

    public function category()
    {
        return $this->belongsTo(CostCategory::class,'category_id','id');
    }

    public function subcategory()
    {
        return $this->belongsTo(CostSubCategory::class,'subcategory_id','id');
    }
    
    public function editReasons()
    {
        return $this->hasMany(CostEditReason::class, 'subcategory_id');
    }
}
