<?php

namespace App\order;
use App\User;
use App\shipment\ShipmentModel;


use Illuminate\Database\Eloquent\Model;

class OrderWarningMessage extends Model
{
    protected $table = 'order_warning_messege';
    protected $fillable =[
        'order_id',
        'delivery_man_id',
        'deadline',
        'team_lead',
     
        'created_by',
        'updated_by',
        'soft_delete'
    ];



    public function user(){
        return $this->belongsTo(User::class,'delivery_man_id','id');
    }



}
