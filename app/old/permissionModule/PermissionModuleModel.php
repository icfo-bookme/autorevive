<?php

namespace App\permissionModule;

use Illuminate\Database\Eloquent\Model;
use App\permissionModule\PermissionModuleDetailsModel;

class PermissionModuleModel extends Model
{
    //
    protected $table = "permission_modules";
    protected $fillable = [
        'name',
        'created_by',
        'status',
        'soft_delete'
    ];

    public function permissions()
    {
        return $this->hasMany(PermissionModuleDetailsModel::class, 'permission_modules_id', 'id');
    }
}
