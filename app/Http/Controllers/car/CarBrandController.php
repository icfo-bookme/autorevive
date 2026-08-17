<?php

namespace App\Http\Controllers\car;

use DB;
use App\car\CarModel;
use App\car\CarBrandModel;
use App\car\CarModelModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CarBrandController extends Controller
{
    public function carBrandSetupView(){

        $carData = CarModel::where('soft_delete',0)->get();

        $data    = [
            'companyData' => $carData
        ];

        return view('admin.car.carBrandSetupView', $data);
    }

    public function carBrandInsertAjax(Request $request)
    {

        $userName        = Auth::user()->first_name;
        $defaultStatus   = 0;

        $attributeNames = array(
            'car_brand'              => $request->car_brand,
            'company_id'             => $request->company,
            'created_by'             => $userName,
        );
        // dd($attributeNames);

        $validator = Validator::make($attributeNames,[
            'car_brand'                  => 'required',
            'company_id'                 => 'required',


        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }else {
            DB::beginTransaction();
            try {

                $item =  new CarBrandModel;
                $item->car_brand             = $request->car_brand;
                $item->company_id            = $request->company;
                $item->created_by            = $userName;
                $item->updated_by            = $userName;
                $item->soft_delete           = $defaultStatus;
                $item->save();

                DB::commit();
                return response()->json("Success");

                }catch (\Exception $exception) {
                DB::rollback();
                return response()->json(array('dbErrors' => $exception->getMessage()));
            }
        }
    }

    public function getBrandByCompanyIdAjax(Request $request)
    {
        $brands = CarBrandModel::where('soft_delete', 0)
                                ->where('company_id', $request->id)
                                ->get();
        return response()->json($brands, 200);
    }


    public function getModelByBrandIdAjax(Request $request)
    {
        $models = CarModelModel::where('soft_delete', 0);
        if($request->id != null){
            $models =  $models->where('brand_id', $request->id);


        }
        if($request->company_id != null){
            $models =  $models->where('company_id', $request->company_id);


        }
        $models = $models->get();


        // $models = CarModelModel::where('soft_delete', 0)
        //                             ->where('company_id', $request->company_id)
        //                             ->where('brand_id', $request->id)
        //                             ->get();


        return response()->json($models, 200);
    }


    public function allCarBrandsView(){
        $brands         = CarBrandModel::where('soft_delete', 0)->get();
        $companies      = CarModel::where('soft_delete', 0)->get();
        $data = [
            'brands'         => $brands,
            'companies'      => $companies,
        ];

         return view('admin.car.allCarBrandsView',$data);

    }


    public function getCarBrandInfoAjax(Request $request){
        $brandInfo          = CarBrandModel::findOrFail($request->id);
        return response()->json($brandInfo);
    }


    public function carBrandUpdateAjax(Request $request)
    {


        $brandInfo          = CarBrandModel::findOrFail($request->brand_id);
        $userName           = Auth::user()->first_name;
        $defaultStatus      = 0;

        $attributeNames = array(
            'car_brand'             => $request->car_brand,
            'company_id'            => $request->company_id,
            'updated_by'            => $userName,
            'soft_delete'           => $defaultStatus
        );


        //validating the attributes
        $validator = Validator::make($attributeNames, [
            'car_brand'             => 'required',
            'company_id'            => 'required',
            'updated_by'            => 'required',
            'soft_delete'           => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }else {
                $brandInfo->car_brand             = $request->car_brand;
                $brandInfo->company_id            = $request->company_id;
                $brandInfo->updated_by            = $userName;
                $brandInfo->soft_delete           = $defaultStatus;
                $brandInfo->update();

            return response()->json("Success");
        }
    }

    public function carBrandDeleteAjax(Request $request)
    {
        $id = $request->id;
        $brand = CarBrandModel::findOrFail($id);
        $attributeNames = array(
            'soft_delete' => 1
        );

        try {
            $brand->update($attributeNames);
            return response()->json("Deleted!");
        } catch (\Exception $exception) {
            return response()->json(array('errors' => $exception->getMessage()));
        }
    }

    public function getAllBrandsAjax()
    {
        $brands = CarBrandModel::all();
        return response()->json($brands, 200);
    }

    public function getAllModelsAjax()
    {
        $models = CarModelModel::all();
        return response()->json($models, 200);
    }


}

