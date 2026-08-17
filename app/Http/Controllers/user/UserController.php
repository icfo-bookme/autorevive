<?php

namespace App\Http\Controllers\user;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\RoleModel;

class UserController extends Controller
{
    public function userRegister(Request $request){

        $attributeNames = array(
            'name'                => $request->name,
            'email'               => $request->email,
            'password'            => $request->password,
        );

        $validator = Validator::make($attributeNames, [
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'      => ['required', 'string', 'min:6'],
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {

            //work goes here for crate new user
            $user = User::create([
                    'name'                  => $attributeNames['name'],
                    'email'                 => $attributeNames['email'],
                    'password'              => Hash::make($attributeNames['password']),
                ]);

            $role = new RoleModel();
            $role->user_id = $user->id;
            $role->name    = $request->type;
            $role->save();    
             return redirect('/login');
        }
    }
}
