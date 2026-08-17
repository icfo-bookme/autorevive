<?php

namespace App\admin\role;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\admin\UserRolesModel;


class RoleModel extends Model
{
    //

    protected $table = 'roles';
    protected $fillable = [
       'name',
       'created_by',
       'soft_delete'
    ];

    public function users(){
    return $this->belongsToMany(User::class);
    }

    public function rolesUser(){
        return $this->hasMany(UserRolesModel::class,'role_id','id');
    }

}
