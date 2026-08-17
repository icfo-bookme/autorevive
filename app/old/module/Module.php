<?php

namespace App\module;

use App\moduleDetails;
use Illuminate\Database\Eloquent\Model;
use App\ModuleTask;
use App\Project\Project;




class Module extends Model
{

    protected $guarded = [];
    
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    public function Module_details()
    {
        return $this->hasMany(moduleDetails::class,'module_id','id');
    }

    public function task()
    {
        return $this->hasMany(ModuleTask::class);
    }

    
}
