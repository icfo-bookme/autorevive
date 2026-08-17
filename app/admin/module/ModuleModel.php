<?php

namespace App\admin\module;

use App\role\RolesDetailsModel;
use Illuminate\Database\Eloquent\Model;
use App\admin\module\ModuleDetailsModel;

class ModuleModel extends Model
{
    //
    protected $table = "modules";
    protected $fillable = [
        'name',
        'created_by',
        'soft_delete',
        'status'
    ];

    // public function modules(){
    //     return $this->hasMany(RolesDetailsModel::class,'module_id','id');
    // }\

    public function module_details(){
        return $this->hasMany(ModuleDetailsModel::class,'module_id','id');
    }
}
