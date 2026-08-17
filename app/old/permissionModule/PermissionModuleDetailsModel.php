<?php

namespace App\permissionModule;

use Illuminate\Database\Eloquent\Model;
use App\permissionModule\PermissionModuleModel;

class PermissionModuleDetailsModel extends Model
{
    //
    protected $table = "permission_modules_details";
    protected $fillable = [
        'route',
        'permission_modules_id',
        'created_by',
        'soft_delete'
    ];

    public function permission()
    {
        return $this->belongsTo(PermissionModuleModel::class, 'permission_modules_id', 'id');
    }
}
