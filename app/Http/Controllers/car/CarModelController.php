<?php

namespace App\Http\Controllers\car;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\car\CarBrandModel;
use App\car\CarModel;
use App\car\CarModelModel;
use App\car\CarEngineModel;
use DB;

class CarModelController extends Controller
{
    public function carModelSetupView(){

        $carData = CarModel::where('soft_delete',0)->get();

        $brandData = CarBrandModel::where('soft_delete',0)->get();

        $data    = [
                'companyData' => $carData,
                'brandData' => $brandData
        ];

        return view('admin.car.carModelSetupView',$data);

    }

    public function carModelInsertAjax(Request $request)
    {

        $userName        = Auth::user()->first_name;
        $defaultStatus   = 0;

        $attributeNames = array(
            'car_model'              => $request->car_model,
            'company_id'             => $request->company,
            'brand_id'               => $request->car_brand,
            'created_by'             => $userName,
            'soft_del'               => $defaultStatus

        );

        $validator = Validator::make($attributeNames,[
            'car_model'                  => 'required',
            'company_id'                 => 'required',
            'brand_id'                   => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }else {
            DB::beginTransaction();
            try {

                // CarModelModel::create($attributeNames);
                $item =  new CarModelModel;
                $item->car_model                = $request->car_model;
                $item->company_id               = $request->company;
                $item->brand_id                 = $request->car_brand;
                $item->created_by               = $userName;
                $item->updated_by               = $userName;
                $item->soft_delete              = $defaultStatus;
                $item->save();

                DB::commit();
                return response()->json("Success");

                }catch (\Exception $exception) {
                DB::rollback();
                return response()->json(array('dbErrors' => $exception->getMessage()));
            }
        }
    }


    public function allCarModelsView(){
        $models         = CarModelModel::where('soft_delete', 0)->with('brandName')->get();
        $companies      = CarModel::where('soft_delete', 0)->get();
        $brands         = CarBrandModel::where('soft_delete', 0)->get();

        $data = [
            'models'        => $models,
            'companies'     =>$companies,
            'brands'        =>$brands
        ];

         return view('admin.car.allCarModelsView',$data);

    }


    public function getCarModelInfoAjax(Request $request){
        $modelInfo = CarModelModel::findOrFail($request->id);
        return response()->json($modelInfo);
    }


    public function CarModelUpdateAjax(Request $request)
    {

        $modelInfo          = CarModelModel::findOrFail($request->model_id);
        $userName           = Auth::user()->first_name;
        $defaultStatus      = 0;

        $attributeNames = array(
            'car_model'             => $request->car_model,
            'company_id'            => $request->company_id,
            'brand_id'              => $request->brand_id,
            'updated_by'            => $userName,
            'soft_delete'           => $defaultStatus
        );

        $validator = Validator::make($attributeNames, [
            'car_model'             => 'required',
            'company_id'            => 'required',
            'brand_id'              => 'required',
            'updated_by'            => 'required',
            'soft_delete'           => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }else {
                $modelInfo->car_model             = $request->car_model;
                $modelInfo->company_id            = $request->company_id;
                $modelInfo->brand_id              = $request->brand_id;
                $modelInfo->updated_by            = $userName;
                $modelInfo->soft_delete           = $defaultStatus;
                $modelInfo->update();

            return response()->json("Success");
        }
    }


    public function carModelDeleteAjax(Request $request)
    {
        $id = $request->id;
        $model = CarModelModel::findOrFail($id);
        $attributeNames = array(
            'soft_delete' => 1
        );

        try {
            $model->update($attributeNames);
            return response()->json("Deleted!");
        } catch (\Exception $exception) {
            return response()->json(array('errors' => $exception->getMessage()));
        }
    }

    //ENGINE SECTION
    public function carEngineSetupView(){

        $carData = CarModel::where('soft_delete',0)->get();

        $brandData = CarBrandModel::where('soft_delete',0)->get();

        $modelData = CarModelModel::where('soft_delete',0)->get();

        $data = [
            'companyData' 	=> $carData,
            'brandData' 	=> $brandData,
            'modelData' 	=> $modelData
        ];

        return view('admin.car.carEngineSetupView',$data);
    }

    public function carEngineInsertAjax(Request $request)
    {
        $userName        = Auth::user()->first_name;
        $defaultStatus   = 0;

        $attributeNames = array(
            'car_engine'             => $request->car_engine,
            'company_id'             => $request->company,
            'brand_id'               => $request->car_brand,
	        'model_id'               => $request->car_model,
            'created_by'             => $userName,
            'soft_delete'            => $defaultStatus
        );

        $validator = Validator::make($attributeNames,[
            'car_engine'                 => 'required',
            'company_id'                 => 'required',
            'brand_id'                   => 'required',
	        'model_id'                   => 'required',


        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }else {
            DB::beginTransaction();
            try {

                $item =  new CarEngineModel;
                $item->car_engine               = $request->car_engine;
                $item->company_id               = $request->company;
                $item->brand_id                 = $request->car_brand;
		        $item->model_id                 = $request->car_model;
                $item->created_by               = $userName;
                $item->updated_by               = $userName;
                $item->soft_delete              = $defaultStatus;
                $item->save();

                DB::commit();
                return response()->json("Success");

                }catch (\Exception $exception) {
                DB::rollback();
                return response()->json(array('dbErrors' => $exception->getMessage()));
            }
        }
    }

    public function allCarEnginesView(){
        $models         = CarModelModel::where('soft_delete', 0)->get();
        $companies      = CarModel::where('soft_delete', 0)->get();
        $brands         = CarBrandModel::where('soft_delete', 0)->get();
        $engines        = CarEngineModel::where('soft_delete', 0)->get();

        $data = [
            'models'        => $models,
            'companies'     => $companies,
            'brands'        => $brands,
            'engines'       => $engines
        ];

         return view('admin.car.allCarEnginesView',$data);
    }

    public function getCarEngineInfoAjax(Request $request){
        $engineInfo = CarEngineModel::findOrFail($request->id);
        return response()->json($engineInfo);
    }


    public function carEngineUpdateAjax(Request $request)
    {
        $engineInfo         = CarEngineModel::findOrFail($request->engine_id);
        $userName           = Auth::user()->first_name;
        $defaultStatus      = 0;

        $attributeNames = array(
            'car_engine'            => $request->car_engine,
            'company_id'            => $request->company_id,
            'brand_id'              => $request->brand_id,
            'model_id'              => $request->model_id,
            'updated_by'            => $userName,
            'soft_delete'           => $defaultStatus
        );

        $validator = Validator::make($attributeNames, [
            'car_engine'            => 'required',
            'company_id'            => 'required',
            'brand_id'              => 'required',
            'model_id'              => 'required',
            'updated_by'            => 'required',
            'soft_delete'           => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }else {
                $engineInfo->car_engine            = $request->car_engine;
                $engineInfo->company_id            = $request->company_id;
                $engineInfo->brand_id              = $request->brand_id;
                $engineInfo->model_id              = $request->model_id;
                $engineInfo->updated_by            = $userName;
                $engineInfo->soft_delete           = $defaultStatus;
                $engineInfo->update();

            return response()->json("Success");
        }
    }

    public function carEngineDeleteAjax(Request $request)
    {
        $id     = $request->id;
        $engine = CarEngineModel::findOrFail($id);
        $attributeNames = array(
            'soft_delete' => 1
        );

        try {
            $engine->update($attributeNames);
            return response()->json("Deleted!");
        } catch (\Exception $exception) {
            return response()->json(array('errors' => $exception->getMessage()));
        }
    }

}
