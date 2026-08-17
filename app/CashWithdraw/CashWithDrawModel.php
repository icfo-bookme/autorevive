<?php

namespace App\CashWithdraw;

use Illuminate\Database\Eloquent\Model;
use App\User;
class CashWithDrawModel extends Model
{
    //
    protected $table = 'cash_withdraw';

    protected $fillable = [
        'date',
        'description',
        'amount',
        'withdraw_by',
        'inserted_by',
    ];


    public function user(){
        return $this->belongsTo(User::class,'withdraw_by','id');
    }
  
}
