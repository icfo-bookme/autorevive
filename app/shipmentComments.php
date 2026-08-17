<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class shipmentComments extends Model
{
    protected $table = "shipment_comments";
    protected $fillable = [
        'order_id',
        'comment',
        'user_id',
        'created_by',
        'created_at',
        'updated_at',
        'soft_delete',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
