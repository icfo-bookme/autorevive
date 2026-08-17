<?php

namespace App\CashStoragePlatform;

use App\User;
use Illuminate\Database\Eloquent\Model;

class CashStoragePlatform extends Model
{
    protected $table = 'cash_storage_platforms';

    protected $fillable =[
        'name',
        'amount',
        'created_by',
        'updated_by',
        'soft_delete'
    ];

    public function user_name(){
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

}
