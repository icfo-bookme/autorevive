<?php

namespace App\admin;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\admin\role\RoleModel;
use App\module\ModuleModel;
class UserRolesModel extends Model
{
    //
    protected $table = "users_roles";
    protected $fillable = [
        'user_id',
        'role_id',
        'created_by',
        'soft_delete'
    ];

    //Just a comment
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function role(){
        return $this->belongsTo(RoleModel::class,'role_id','id');
    }


    public function routes(){
        return $this->hasMany(ModuleModel::class, 'role_id', 'id');

    }
}
