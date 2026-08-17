<?php

namespace App\Http\Controllers\menu;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\admin\UserRolesModel;
use App\User;
use App\menu\MenuHead;

class MenuController extends Controller
{
   public function menuList(){
     
       $userRoles = UserRolesModel::where('user_id',Auth::user()->id)->get()->pluck('role_id');
       $menu      = MenuHead::whereHas('posts', function($q){
                                    $q->whereIn('route','2015-01-01 00:00:00');
                                });
       dd($userRoles);

   }

}
