<?php

namespace App\complain;

use Illuminate\Database\Eloquent\Model;
use App\delivery\deliveryTeamModel;

class Complain extends Model
{
    protected $table = 'complains';
    protected $fillable = [
        'delivery_man_id', 
        'complain',
        'complain_detail',
        'soft_delete',
        'created_by' ,
        'updated_by',
        'created_at', 
        'updated_at'
    ];

    public function deliveryTeam()
    {
        return $this->belongsTo(deliveryTeamModel::class, 'delivery_man_id', 'id');
    }
}
