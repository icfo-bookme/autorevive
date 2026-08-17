<?php

namespace App\module;

use App\role\RolesDetailsModel;
use Illuminate\Database\Eloquent\Model;

class ModuleModel extends Model
{
    //
    protected $table = "modules";
    protected $fillable = [ 
        'name',
        'created_by',
        'status',
        'soft_delete'
    ];

    public function modules(){
        return $this->hasMany(ModuleDetailsModel::class,'module_id','id');
    }
}
