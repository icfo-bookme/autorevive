<?php

namespace App\module;

use Illuminate\Database\Eloquent\Model;
use App\module\ModuleModel;
class ModuleDetailsModel extends Model
{
    //
    protected $table = "modules_details";
    protected $fillable = [
        'route',
        'module_id',
        'created_by',
        'status',
        'soft_delete'
    ];

    public function module(){
         return $this->belongsTo(ModuleModel::class,'module_id','id');
    }
}
