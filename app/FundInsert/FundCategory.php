<?php

namespace App\FundInsert;

use App\User;
use Illuminate\Database\Eloquent\Model;

class FundCategory extends Model
{
    protected $table = 'fund_categories';
    protected $fillable = [
        'name',
        'created_by',
        'updated_by',
        'soft_delete'
    ];

    public function createdBy(){
        return $this->belongsTo(User::class,'created_by','id');
    }
    public function updatedBy(){
        return $this->belongsTo(User::class,'updated_by','id');
    }

}
