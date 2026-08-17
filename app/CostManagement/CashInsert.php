<?php

namespace App\CostManagement;

use Illuminate\Database\Eloquent\Model;
use App\User;

class CashInsert extends Model
{
    protected $table = 'cash_inserts';
    protected $fillable = [

        'cash_amount',
        'description',
        'date',
        'soft_delete',
        'created_by',
        'updated_by'
    ];

    public function createdBY(){
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    public function updatedBY(){
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

}
