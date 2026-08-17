<?php

namespace App\Http\Controllers\role;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\role\RoleModel;
use App\module\ModuleModel;
use App\module\ModuleDetailsModel;
use App\User;
use App\UserRolesModel;
use App\role\RolesDetailsModel;

class RoleController extends Controller
{
    //
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @name roleInsertView
     * @role insert a role record into the the database view
     * @param
     * @return view
     *
     */

public function roleInsertView()
    {
        return view('admin.role.roleInsert');
    }



    /**
     * @name rolesView
     * @role show all role record from the database
     * @param
     * @return view with compact array
     *
     */

    public function rolesView()
    {
        //gettings all the roles

        $roles = RoleModel::all('id', 'name', 'created_by', 'soft_delete')->where('soft_delete', 0);
        //dd($roles);
        return view('admin.role.rolesView', compact('roles'));
    }



     /**
     * @name rolesAssign
     * @role role module assign view
     * @param
     * @return view with compact array
     *
     */
    public function rolesAssignView()
    {
        //getting all the roles and module
        $roles = RoleModel::all('id', 'name', 'soft_delete')->where('soft_delete', 0)->where('id', '!=', 1);
        $modules = ModuleModel::all('id', 'name', 'soft_delete')->where('soft_delete', 0);

        $data = [
            'roles'   => $roles,
            'modules' => $modules
        ];
        return view('admin.role.roleAssign', $data);
    }




    /**
     * @name roleAssignUser
     * @role User role assign view
     * @param
     * @return view with compact array
     *
     */

    public function roleAssignUserView()
    {
        //getting all user and roles
        $users = User::all('id', 'first_name')->where('id', '!=', 1);
        $roles = RoleModel::all('id', 'name', 'soft_delete')->where('soft_delete', 0)->where('id', '!=', 1);

        $data = [
            'users'     => $users,
            'roles'     => $roles

        ];

        return view('admin.role.roleAssignUser', $data);
    }



    /**
     * @name roleInsertAjaxRequest
     * @role insert role record into the database
     * @param Request from array
     * @return json response
     *
     */

    public function roleInsertAjaxRequest(Request $request)
    {

        //getting the current user Name
        $userName = Auth::user()->first_name;
        $defaultStatus = 0;
        //gettings attributes
        $attributeNames = array(
            'name'        => $request->roleName,
            'created_by'  => $userName,
            'soft_delete' => $defaultStatus

        );



        //return dd($attributeNames);

        //validating the attributes
        $validator = Validator::make($attributeNames, [
            'name'                    => 'required',
            'created_by'              => 'required',
            'soft_delete'             => 'required'

        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            RoleModel::create($attributeNames);

            return response()->json("Success");
        }
    }


    /**
     * @name rolesDeleteAjax
     * @role soft delete role record into the database
     * @param Request from array
     * @return json response
     *
     */

    public function rolesDeleteAjax(Request $request)
    {
        $id = $request->role_id;
        // dd($id);
        $role = RoleModel::findOrFail($id);
        $deletedAttribute = 1;
        $attributeNames = array(
            'soft_delete' => $deletedAttribute
        );

        try {
            $role->update($attributeNames);
            return response()->json("Deleted!");
        } catch (\Exception $exception) {
            return response()->json(array('errors' => $exception->getMessage()));
        }
    }


    /**
     * @name roleAssignUserInsertAjax
     * @role Assign use and role record into the database
     * @param Request from array
     * @return json response
     *
     */


    public function roleAssignUserInsertAjax(Request $request)
    {

        $userName = Auth::user()->first_name;
        $defaultStatus = 0;

        $attributeNames = array(
            'role_id'               => $request->role,
            'user_id'               => $request->user,
            'created_by'            => $userName,
            'soft_delete'           => $defaultStatus
        );

        $validator = Validator::make($attributeNames, [
            'role_id'               => 'required',
            'user_id'               => 'required',
            'created_by'            => 'required',
            'soft_delete'           => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {

            //check if already exists
            if (UserRolesModel::where('role_id', $attributeNames['role_id'])
                ->where('user_id', $attributeNames['user_id'])
                ->exists()
            ) {
                return response()->json(array('warning' => "Record Already Exists"));
            } else {
                //work goes here
                UserRolesModel::create($attributeNames);
                return response()->json("Success");
            }
        }
    }







    // getting all the roles

    /**
     * @name getAllRoles
     * @role getting all the roles record from the database
     * @param
     * @return json response
     *
     */

    public function getAllRoles()
    {
        $roles = RoleModel::all('id', 'name', 'created_by', 'soft_delete')->wherer('soft_delete', 0)->where('id', '!=', 1);
        return response()->json($roles, 200);
    }


    /**
     * @name getRole
     * @role getting a specific role record from the database
     * @param Request from array
     * @return json response
     *
     */
    public function getRole(Request $request)
    {   $id = $request->id;
        $role = RoleModel::findorFail($id);
        return response()->json($role, 200);
    }



    /**
     * @name getmodulebyrole
     * @role getting modules by a specific role record from the database
     * @param Request from array
     * @return json response
     *
     */

    //get module by role
    public function getmodulebyrole(Request $request)
    {
        $id = $request->id;
        //getting the module_id associated with the role_id from roles_details table
        $filtered_module_ids = RolesDetailsModel::where('role_id', $id)->pluck('module_id')->toArray();

        //getting all the module associated wuth module_id array..thats why whereIn
        $module_names = ModuleModel::whereIn('id', $filtered_module_ids)->pluck('name')->toArray();
        // ->map(function ($item) {
        // return ['module_name' => $item['name']];
        // })

        return response()->json($module_names, 200);
    }


     /**
     * @name roleUpdatAjax
     * @role update informatinos of a specific role record from the database
     * @param Request from array
     * @return json response
     *
     */

    public function roleUpdatAjax(Request $request)
    {
        $id = $request->id;

        $role = RoleModel::findOrFail($id);

        $attributeNames = array(
            'name'        => request()->roleName
        );

        $validator = Validator::make($attributeNames, [
            'name'        => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {

            $role->update($attributeNames);

            return response()->json("Success");
        }
    }



    /**
     * @name roleModuleAssignAjax
     * @role record the role and module relationship into the database
     * @param Request from array
     * @return json response
     *
     */

    public function roleModuleAssignAjax(Request $request)
    {
      

        $userName = Auth::user()->first_name;
        $defaultStatus = 0;
        $attributeNames = array(
            'role_id'               => $request->role,
            'module_id'             => $request->module,
            'created_by'            => $userName,
            'soft_delete'           => $defaultStatus
        );

        $validator = Validator::make($attributeNames, [
            'role_id'                   => 'required',
            'module_id'                 => 'required',
            'created_by'                => 'required',
            'soft_delete'               => 'required'

        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            //checking existance
            if (RolesDetailsModel::where('role_id', $attributeNames['role_id'])
                ->where('module_id', $attributeNames['module_id'])
                ->exists()
            ) {
                return response()->json(array('warning' => "Record Already Exists"));
            } else {
                //work goes here
                RolesDetailsModel::create($attributeNames);
                return response()->json("Success", 200);
            }
        }
    }



    
}
