<?php

namespace App\permissionModule;

use Illuminate\Database\Eloquent\Model;

class PermissionRoleModuleModel extends Model
{
    //
    protected $table = "roles_details";
    protected $fillable = [
        "role_id",
        "permission_module_id",
        "created_by",
        "status",
        "soft_delete"
    ];
    
}
