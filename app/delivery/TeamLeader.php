<?php

namespace App\delivery;

use Illuminate\Database\Eloquent\Model;
use App\User;

class TeamLeader extends Model
{
    protected $table = "team_leaders";
    protected $fillable = [
        'name',
        'contact_number',
        'alt_contact_number',
        'address',
        'NID',
        'created_by',
        'updated_by',
        'soft_delete',
    ];
}
