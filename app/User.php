<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\admin\role\RoleModel;

use App\admin\UserRolesModel;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'plain_password',
        'phone',
        'address',
        'country',
        'district',
        'city',
        'thana',
        'area',
        'road_no',
        'house_no',
        'flat_no',
        'NID',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function role()
    {
        return $this->hasOne(RoleModel::class,'user_id','id');
    }

    public function roles()
    {
        return $this->hasMany(UserRolesModel::class, 'user_id', 'id');
    }


    // public function role()
    // {
    //     return $this->hasOne(RoleModel::class,'user_id','id');
    // }
}
