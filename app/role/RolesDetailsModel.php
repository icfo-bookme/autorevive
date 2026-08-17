<?php

namespace App\role;

use App\module\ModuleModel;
use Illuminate\Database\Eloquent\Model;

class RolesDetailsModel extends Model
{
    // 
    protected $table = "roles_details";
    protected $fillable = [
        "role_id",
        "module_id",
        "created_by",
        "status",
        "soft_delete"
    ];

    // public function module(){
    //     return $this->belongsTo(ModuleModel::class);
    // }
}
