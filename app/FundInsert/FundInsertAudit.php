<?php

namespace App\FundInsert;

use Illuminate\Database\Eloquent\Model;
use App\FundInsert\FundInsert;
use App\FundInsert\FundCategory;
use App\FundInsert\FundSubCategory;

class FundInsertAudit extends Model
{
    protected $table = 'fund_insert_audits';
    protected $fillable = [
        'trigger_type',
        'fund_id',
        'category_id',
        'subcategory_id',
        'amount',
        'date',
        'description',
        'created_by',
        'updated_by',
        'soft_delete',
    ];

    public function fund()
    {
        return $this->belongsTo(FundInsert::class,'fund_id','id');
    }

    public function category()
    {
        return $this->belongsTo(FundCategory::class,'category_id','id');
    }

    public function subcategory()
    {
        return $this->belongsTo(FundSubCategory::class,'subcategory_id','id');
    }

    public function createdBy(){
        return $this->belongsTo(User::class,'created_by','id');
    }
    public function updatedBy(){
        return $this->belongsTo(User::class,'updated_by','id');
    }
}
