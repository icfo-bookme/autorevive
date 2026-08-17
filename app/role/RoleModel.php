<?php

namespace App\role;

use Illuminate\Database\Eloquent\Model;
use App\User;

class RoleModel extends Model
{
    //

    protected $table = 'roles';
    protected $fillable = [
       'name',
       'created_by',
       'status',
       'soft_delete'
    ];

    public function users(){
       return $this->belongsToMany(User::class);
    }


   

}
