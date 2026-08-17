<?php

namespace App\Http\Controllers\admin\role;

use Illuminate\Support\Facades\Validator;
use App\admin\module\ModuleDetailsModel;
use App\admin\role\RolesDetailsModel;
use App\welcomeCall\WelcomeCallModel;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\admin\module\ModuleModel;
use App\customer\CustomerModel;
use App\admin\role\RoleModel;
use App\admin\UserRolesModel;
use Illuminate\Http\Request;
use App\User;
//use DB;


class RoleController extends Controller
{
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.role.roleInsert');
    }

    public function roleInsertAjaxRequest(Request $request)
    {
        //getting the current user Name
        $userName      = Auth::user()->first_name;
        $defaultStatus = 0;
        //gettings attributes
        $attributeNames = array(
            'name'          => $request->roleName,
            'created_by'    => $userName,
            'soft_delete'   => $defaultStatus

        );

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

            //return response()->json("Success");
            return response()->json([
                'data'      => null,
                'status'    => true,
                'message'   => 'Role inserted successfully'
            ]);
        }
    }


    public function rolesDeleteAjax(Request $request)
    {
        $id = $request->role_id;
        $role = RoleModel::findOrFail($id);
        $deletedAttribute = 1;
        $attributeNames = array(
            'soft_delete'        => $deletedAttribute
        );
        DB::beginTransaction();
        try{
            $role->update($attributeNames);
            RolesDetailsModel::where('role_id',$id)->update($attributeNames);
            DB::commit();
            return response("Deleted!");

        }catch(\Exception $exception){

            DB::rollback();
            return response()->json(array(
                'dbErrors' => $exception->getMessage()
            ));
        }

    }


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
                return response()->json([
                    'data'      => null,
                    'status'    => true,
                    'message'   => 'Role assigned successfully'
                ]);
                // return response()->json("Success");
            }
        }
    }

    public function rolesView()
    {
        //gettings all the roles
        $roles = RoleModel::all('id', 'name', 'created_by', 'soft_delete')->where('soft_delete', 0);
        //dd($roles);
        return view('admin.role.rolesView', compact('roles'));
    }


    //role assign view
    public function rolesAssign()
    {
        //getting all the roles and module
        $roles = RoleModel::all('id', 'name', 'soft_delete')->where('soft_delete', 0)->where('id','!=', 1);
        $modules = ModuleModel::all('id', 'name', 'soft_delete')->where('soft_delete', 0);

        $data = [
            'roles'   => $roles,
            'modules' => $modules
        ];
        return view('admin.role.roleAssign', $data);
    }

    // getting all the roles
    public function getAllRoles()
    {
        $roles = RoleModel::all('id', 'name', 'created_by', 'status')->wherer('status', 0)->where('id','!=', 1);
        return response()->json($roles, 200);
    }
    //getting the role
    public function getRole(Request $request)
    {
        $role = RoleModel::findorFail($request->id);
        return response()->json($role, 200);
    }

    //get module by role
    public function getmodulebyrole(Request $request)
    {
        // dd($request);
        //getting the module_id associated with the role_id from roles_details table
        $filtered_module_ids = RolesDetailsModel::where('role_id', $request->id)->pluck('module_id')->toArray();

        //getting all the module associated wuth module_id array..thats why whereIn
        // $module_names = ModuleModel::whereIn('id', $filtered_module_ids)->pluck('name')->toArray();
        $module_names = ModuleModel::whereIn('id', $filtered_module_ids)->get()->toArray();

        return response()->json($module_names, 200);
    }

    public function updateRole(Request $request)
    {
        $role = RoleModel::findOrFail($request->id);

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

    public function roleAssignUser()
    {
        //getting all user and roles
        $users = User::all('id', 'first_name', 'last_name', 'email')->where('id','!=', 1);
        $roles = RoleModel::all('id', 'name', 'soft_delete')->where('soft_delete', 0)->where('id','!=', 1);

        $data = [
            'users'     => $users,
            'roles'     => $roles

        ];

        return view('admin.role.roleAssignUser', $data);
    }

    public function roleModuleAssignAjax(Request $request)
    {

        $userName = Auth::user()->first_name;
        $defaultStatus = 0;
        $attributeNames = array(
            'role_id'               => $request->role,
            'module_id'             => $request->module,
            'created_by'            => $userName,
            'soft_delete'           => 0
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
            ->exists()) {
                return response()->json(array('warning' => "Record Already Exists"));
            } else {
                //work goes here
                RolesDetailsModel::create($attributeNames);
                return response()->json("Success", 200);
            }
        }
    }

    public function getModuleByUser(Request $request)
    {
        $id = $request->user_id;

        $user_role_id = UserRolesModel::where('user_id', $id)->where('soft_delete', 0)->pluck('role_id')->toArray();

        $filtered_module_ids = RoleModel::whereIn('id', $user_role_id)->where('soft_delete', 0)->get()->toArray();
        return response()->json($filtered_module_ids, 200);
    }

    public function removeRoleModule(Request $request)
    {
        $role_id = $request->role_id;
        $module_id = $request->module_id;
        RolesDetailsModel::where('role_id', $role_id)->where('module_id', $module_id)->delete();

        return response()->json("Success");
    }

    public function removeUserRole(Request $request)
    {
        $user_id = $request->user_id;
        $role_id = $request->role_id;

        UserRolesModel::where('user_id', $user_id)->where('role_id', $role_id)->where('soft_delete', 0)->delete();

        return response()->json("Success");
    }


    /*
    USER REGISTRATION BY ADMIN
    */

    public function adminPanelRegister()
    {
        $roles = RoleModel::all('id', 'name', 'soft_delete')->where('soft_delete', 0)->where('id','!=', 1)->where('id','!=', 2);
        $data    = [
            'roles' => $roles
        ];
        return view('auth.adminPanelRegister', $data);
    }

    public function adminRegister(Request $request){

        $attributeNames = array(
            'first_name'    => $request->first_name,
            'last_name'     => $request->last_name,
            'email'         => $request->email,
            'phone'         => $request->phone,
            'address'       => $request->address,
            'password'      => Hash::make($request->password),
            'plain_password'      => $request->password,
            'country'       => $request->country,
            'district'      => $request->district,
            'city'          => $request->city,
            'thana'         => $request->thana,
            'area'          => $request->area,
            'road_no'       => $request->road_no,
            'house_no'      => $request->house_no,
            'flat_no'       => $request->flat_no
        );

        $validator = Validator::make($attributeNames, [
            'first_name'    => 'required',
            'last_name'     => 'required',
            'email'         => 'required',
            'password'      => 'required',
            'phone'         => 'required|regex:/(01)[0-9]{9}/',
            'address'       => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            $emailAndPhone = User::where('email', '=', $request->email)->orWhere('phone', '=', $request->phone)->first();
            if ($emailAndPhone === null) {
                DB::beginTransaction();
                try {
                    //$email = User::where('email', '=', $request->email)->first();
                    //if ($email === null) {
                        $user =  User::create($attributeNames);
                        UserRolesModel::create(
                            [
                                'user_id'       => $user->id,
                                'role_id'       => 2,
                                'created_by'    => Auth::user()->first_name,
                                'soft_delete'   => 0
                            ]
                        );

                        /* INSERT INTO customers TABLE AS NEW CUSTOMER */
                        // $customerMailPhoneExists = CustomerModel::where('phone', '=', $request->phone)->first();
                        // if ($customerMailPhoneExists === null) {
                        //     $newCustomer = new CustomerModel();
                        //     $newCustomer->first_name    = $request->first_name;
                        //     $newCustomer->last_name     = $request->last_name;
                        //     $newCustomer->email         = $request->email;
                        //     $newCustomer->phone         = $request->phone;
                        //     $newCustomer->country       = $request->country;
                        //     $newCustomer->district      = $request->district;
                        //     $newCustomer->city          = $request->city;
                        //     $newCustomer->thana         = $request->thana;
                        //     $newCustomer->area          = $request->area;
                        //     $newCustomer->road_no       = $request->road_no;
                        //     $newCustomer->house_no      = $request->house_no;
                        //     $newCustomer->flat_no       = $request->flat_no;
                        //     $newCustomer->address       = $request->address;
                        //     $newCustomer->created_by    = Auth::user()->first_name;
                        //     $newCustomer->updated_by    = Auth::user()->first_name;
                        //     $newCustomer->save();

                        //     WelcomeCallModel::create([
                        //         'customer_id'	=>	$newCustomer->id,
                        //         'created_by'	=>	Auth::user()->first_name
                        //     ]);
                        // }

                        if(isset($request->role)){
                            UserRolesModel::create(
                                [
                                    'user_id'       => $user->id,
                                    'role_id'       => $request->role,
                                    'created_by'    => Auth::user()->first_name,
                                    'soft_delete'   => 0
                                ]
                            );
                        }

                    // /* INSERT INTO customers TABLE AS NEW CUSTOMER WHEN ROLE IS USER */
                    // $userRole = $request->role;
                    // if ($userRole == 2 ) {
                    //     $mailID = CustomerModel::where('email', '=', $request->email)->first();
                    //     if ($mailID === null) {

                    //         $newCustomer = new CustomerModel();

                    //         $newCustomer->first_name      = $request->first_name;
                    //         $newCustomer->last_name       = $request->last_name;
                    //         $newCustomer->email           = $request->email;
                    //         $newCustomer->phone           = $request->phone;
                    //         $newCustomer->save();
                    //     }
                    // }

                    DB::commit();
                    return response()->json("Success");
                } catch (\Exception $exception) {
                    DB::rollback();
                    return response()->json(array('dbErrors' => $exception->getMessage()));
                }
            }else {
                return response()->json("mailOrPhoneExists");
            }
        }
    }
}
