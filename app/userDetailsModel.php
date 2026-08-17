<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\role\RoleModel;
class userDetailsModel extends Model
{
    protected $table = "user_details";
    protected $fillable = [
        'user_id','role_id'
    ];

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function role()
    {
        return $this->belongsTo(RoleModel::class,'role_id','id');
    }
}
