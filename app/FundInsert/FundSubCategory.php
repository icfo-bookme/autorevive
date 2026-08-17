<?php

namespace App\FundInsert;

use App\User;
use Illuminate\Database\Eloquent\Model;

class FundSubCategory extends Model
{
    protected $table = 'fund_sub_categories';
    protected $fillable = [
        'category_id',
        'name',
        'created_by',
        'updated_by',
        'soft_delete'
    ];

    public function category()
    {
        return $this->belongsTo(FundCategory::class,'category_id','id');
    }

    public function createdBy(){
        return $this->belongsTo(User::class,'created_by','id');
    }
    public function updatedBy(){
        return $this->belongsTo(User::class,'updated_by','id');
    }


}
