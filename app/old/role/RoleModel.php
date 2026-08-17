<?php

namespace App\role;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\userDetailsModel;

class RoleModel extends Model
{
    //

    protected $table = 'roles';
    protected $fillable = [
       'name',
       'created_by'
    ];

    public function users()
    {
        return $this->hasMany(userDetailsModel::class,'role_id','id');
    }

}
