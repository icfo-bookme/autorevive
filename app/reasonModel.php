<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\OrderModel;

class reasonModel extends Model
{
    //

    //
    protected $table ="reschedule_reason";
    protected $fillable =[
        'order_id',
        'reason',
        'created_by',
        'updated_by'
      ];

    public function orders()
    {
        return $this->belongsTo(OrderModel::class, 'order_id', 'id');
    }
}
