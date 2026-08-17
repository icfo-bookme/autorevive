<?php

namespace App\CostInsert;

use Illuminate\Database\Eloquent\Model;

class CostCategory extends Model
{
    protected $fillable = [
        'name',
        'created_by',
        'updated_by',
        'soft_delete'
    ];

    public function costEditReasons()
    {
        return $this->hasMany(CostEditReason::class, 'category_id');
    }
}
