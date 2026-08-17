<?php

namespace App\role;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $fillable = [
        'name',
        'created_by',
        'soft_delete'
    ];

    public function users()
    {
        return $this->hasMany(User::class,'role_id','id');
    }
}
