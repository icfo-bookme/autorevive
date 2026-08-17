<?php

namespace App\delivery;

use Illuminate\Database\Eloquent\Model;

class deliveryTeamModel extends Model
{
    protected $table ="delivery_team";
    protected $fillable = [
        'name',
        'contact_number',
        'alt_contact_number',
        'address',
        'NID',
        'role_id',
        'created_by',
        'updated_by',
        'soft_delete'
    ];

}
