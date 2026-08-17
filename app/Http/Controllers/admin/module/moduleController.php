<?php

namespace App\Http\Controllers\admin\module;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\admin\module\ModuleModel;
use App\admin\role\RolesDetailsModel;
use App\admin\module\ModuleDetailsModel;
use Illuminate\Support\Facades\DB;

class moduleController extends Controller
{
    //module insert view
    public function moduleInsert()
    {
        return view('admin.module.moduleInsert');
    }

    //inserting module
    public function moduleInsertAjax(Request $request)
    {
        $userName = Auth::user()->first_name;
        $defaultValue = 0;

        $attributeNames = array(
            'name'              => $request->moduleName,
            'created_by'        => $userName,
            'status'            => $defaultValue,
            'soft_delete'       => '0'
        );

        $validator = Validator::make($attributeNames, [
            'name'              => 'required',
            'created_by'        => 'required',
            'status'            => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            //work goes here
            ModuleModel::create($attributeNames);
            return response()->json([
                'data'      => null,
                'status'    => true,
                'message'   => 'Module inserted successfully'
            ]);
        }
    }

    //module view
    public function modulesView()
    {
        $modules = ModuleModel::all('id', 'name', 'created_by', 'soft_delete')->where('soft_delete', 0);

        $data = [
            'modules' => $modules
        ];
        return view('admin.module.index', $data);
    }


    // update module
    public function updateModule($id)
    {
        $module = ModuleModel::findOrFail($id);
        $attributeNames = array(
            'name'          => request()->moduleName,
        );

        $validator = Validator::make($attributeNames, [
            'name'          => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            $module->update($attributeNames);
            return response()->json("Updated!");
        }
    }

    //delete module
    public function modulesDeleteAjax(Request $request)
    {
        // $id = $request->module_id;
        // $module = ModuleModel::findOrFail($id);
        // $deletedAttribute = 1;
        // $attributeNames = array(
        //     'status' => $deletedAttribute
        // );
        // $module->update($attributeNames);
        // //deleting the related routes
        // $ids = ModuleDetailsModel::where('module_id',$id)->pluck('id')->toarray();
        // ModuleDetailsModel::whereIn('id',$ids)->update($attributeNames);
        // return response("Deleted!");


        /*After delete soft_delete will be 1 rather than status & also added DB transaction */
        $id = $request->module_id;
        $module = ModuleModel::findOrFail($id);
        $deletedAttribute = 1;
        $attributeNames = array(
            'soft_delete' => $deletedAttribute
        );
        DB::beginTransaction();
        try {

            $module->update($attributeNames);
            //deleting the related routes
            // $ids = ModuleDetailsModel::where('module_id', $id)->pluck('id')->toarray();
            // dd($ids);
            ModuleDetailsModel::where('module_id', $id)->update($attributeNames);
            RolesDetailsModel::where('module_id', $id)->update($attributeNames);
            DB::commit();
            return response()->json("Deleted!");
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(array('dbErrors' => $exception->getMessage()));
        }

    }



    /**
     * @name moduleRouteView
     * @role module route assign view
     * @param
     * @return view with compact array
     *
     */

    public function moduleRouteView()
    {
        $modules = ModuleModel::all('id', 'name', 'soft_delete')->where('soft_delete', 0);
        $modulesRoutes = ModuleDetailsModel::where('soft_delete', 0)
                                            ->with('module')
                                            ->get();
        $data = [
            'modulesRoutes'      => $modulesRoutes,
            'modules'           => $modules
        ];
        return view('admin.module.moduleRouteView', $data);
    }



    // //module setup view
    // public function moduleSetup()
    // {
    //     $modules = ModuleModel::all('id', 'name', 'status')->where('status', 0);

    //     $data = [
    //         'modules' => $modules
    //     ];

    //     return view('admin.module.moduleSetup', $data);
    // }

    /**
     * @name moduleSetup
     * @role module Setup view
     * @param
     * @return view with compact array
     *
     */
    public function moduleSetupView()
    {
        $modules = ModuleModel::all('id', 'name', 'soft_delete')->where('soft_delete', 0);

        $data = [
            'modules' => $modules
        ];

        return view('admin.module.moduleSetup', $data);
    }


    //get single module
    public function getModule($id)
    {
        $module = ModuleModel::findOrFail($id);
        return response()->json($module);
    }


    //module Insert
    public function moduleDetailsInsertAjax(Request $request)
    {
        // $userName = Auth::user()->first_name;
        // $defaultValue = 0;

        // $attributeNames = array(
        //     'module_id'         => $request->module,
        //     'route'             => $request->route,
        //     'created_by'        => $userName,
        //     'status'            => $defaultValue,
        //     'soft_delete'       => $defaultValue
        // );

        // $validator = Validator::make($attributeNames, [
        //     'module_id'         => 'required',
        //     'route'             => 'required',
        //     'created_by'        => 'required',
        //     'status'            => 'required'
        // ]);

        // if ($validator->fails()) {
        //     return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        // } else {
        //     //work goes here
        //     ModuleDetailsModel::create($attributeNames);
        //     return response()->json([
        //         'data'      => null,
        //         'status'    => true,
        //         'message'   => 'Module route setup successfully'
        //     ]);
        //     // return response()->json("Success");
        // }
        
        $userName = Auth::user()->first_name;
        $defaultValue = 0;

        $attributeNames = array(
            'module_id'         => $request->module,
            'route'             => $request->route,
            'created_by'        => $userName,
            'soft_delete'       => $defaultValue
        );

        $validator = Validator::make($attributeNames, [
            'module_id'         => 'required',
            'route'             => 'required',
            'created_by'        => 'required',
            'soft_delete'       => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            //work goes here

            if (!ModuleDetailsModel::where('module_id', $request->module)
                ->where('route', $request->route)
                ->where('soft_delete', 0)
                ->exists()) {
                ModuleDetailsModel::create($attributeNames);
                return response()->json([
                    'data'      => null,
                    'status'    => true,
                    'message'   => 'Successfully Added Route to the Module'
                ]);
            } else {
                return response()->json(array('warning' => 'Record Already Exists!'));
            }
        }
        
    }


    public function getRouteByModule(Request $request)
    {
        $id = $request->id;
         //$modulesRoutes = ModuleDetailsModel::all('id','module_id','route','status')->where('status',0)->where('module_id',$id);
        $modulesRoutes = ModuleDetailsModel::select('id', 'module_id', 'route','soft_delete')
                                            ->where('module_id',$id)
                                            ->where('soft_delete',0)
                                            ->get();
        return response()->json($modulesRoutes, 200);
    }

    public function removeModuleRoute(Request $request)
    {
        // ModuleDetailsModel::where('id', $request->id)
        // ->where('status', 0)
        // ->delete();

        // return response()->json("Success", 200);

        $id = $request->id;
        $module_route = ModuleDetailsModel::findOrFail($id);
        $deletedAttribute = 1;
        $attributeNames = array(
            'soft_delete' => $deletedAttribute
        );

        try {
            $module_route->update($attributeNames);
            return response()->json("Success", 200);
        } catch (\Exception $exception) {
            return response()->json(array('errors' => $exception->getMessage()));
        }

    }

    // get details information of modules
    public function getModuleDetailsByidAjax(Request $request)
    {
        $id = $request->id;
        $module = ModuleDetailsModel::findOrFail($id);
        return response()->json($module);
    }

    // update module details record into the database
    public function moduleDetailsUpdateAjax(Request $request)
    {
        $id = $request->id;
        $module = ModuleDetailsModel::findOrFail($id);
        $userName = Auth::user()->first_name;
        $defaultValue = 0;

        $attributeNames = array(
            'module_id'                     => $request->module,
            'route'                         => $request->route,
            'created_by'                    => $userName,
            'soft_delete'                   => $defaultValue
        );

        $validator = Validator::make($attributeNames, [
            'module_id'                 => 'required',
            'route'                     => 'required',
            'created_by'                => 'required',
            'soft_delete'               => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            //work goes here
            $module->update($attributeNames);
            return response()->json("Success");
        }
    }

    /**
     * @name moduleDetailsDeleteAjax
     * @role soft delete individual module details record into the database
     * @param Request from array
     * @return view with compact array
     *
     */


    public function moduleDetailsDeleteAjax(Request $request)
    {
        $module = ModuleDetailsModel::findOrFail($request->id);

        try {
            $module->update([
                'soft_delete' => 1
            ]);
            return response()->json("Success");
        } catch (\Exception $exception) {
            return response()->json(array('dbErrors' => $exception->getMessage()));
        }
    }
}
