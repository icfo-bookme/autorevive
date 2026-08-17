<?php

namespace App\Reinvestment;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Reinvestment extends Model
{
    protected $table = 'reinvestments';
    protected $fillable = [
        'amount',
        'date',
        'description',
        'created_by',
        'updated_by',
        'soft_delete',
    ];

    public function createdBy(){
        return $this->belongsTo(User::class,'created_by','id');
    }
    public function updatedBy(){
        return $this->belongsTo(User::class,'updated_by','id');
    }
}
