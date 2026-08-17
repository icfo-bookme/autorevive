<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use App\admin\UserRolesModel;
use App\admin\role\RoleModel;
use App\admin\role\RolesDetailsModel;
use App\admin\module\ModuleModel;
use App\admin\module\ModuleDetailsModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class HasAccess
{
    /**
     * Handle an incoming request.
     * Just a comment
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {


        $requested_route = Route::getCurrentRoute()->uri();



        $user_id = Auth::user()->id;

        if ($user_id == 1) {
            # code...
            return $next($request);
        } else {

            $roles = UserRolesModel::where('soft_delete',0)->where('user_id', $user_id)->pluck('role_id')->toArray();

            $moduleIds = RolesDetailsModel::where('soft_delete',0)->whereIn('role_id', $roles)->pluck('module_id')->toArray();

            $module_count =  ModuleDetailsModel::select('id')->where('soft_delete',0)->where('route', $requested_route)->whereIn('module_id', $moduleIds)->count();

            if ($module_count > 0) {
                return $next($request);
            } else {
                return redirect('/accessnotallowed');
            }
        }
    }
}
