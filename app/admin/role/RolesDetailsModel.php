<?php

namespace App\admin\role;

use App\admin\module\ModuleModel;
use Illuminate\Database\Eloquent\Model;

class RolesDetailsModel extends Model
{
    // 
    protected $table = "roles_details";
    protected $fillable = [
        "role_id",
        "module_id",
        "created_by",
        "soft_delete"
    ];

    // public function module(){
    //     return $this->belongsTo(ModuleModel::class);
    // }
}
