<?php

namespace App\CostInsert;

use Illuminate\Database\Eloquent\Model;

class CostSubCategory extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'created_by',
        'updated_by',
        'soft_delete'
    ];

    public function category()
    {
        return $this->belongsTo(CostCategory::class,'category_id','id');
    }

    public function costEditReasons()
    {
        return $this->hasMany(CostEditReason::class, 'subcategory_id');
    }
}
