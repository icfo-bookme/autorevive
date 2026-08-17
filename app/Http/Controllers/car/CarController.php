<?php

namespace App\Http\Controllers\car;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\car\CarModel;
use DB;

class CarController extends Controller
{
    public function companySetupView()
    {
        return view('admin.car.companySetupView');
    }

    public function companyInsertAjax(Request $request)
    {
        // Auth::user()->name;
        $userName        = Auth::user()->first_name;
        // dd($userName);
        $defaultStatus   = 0;

        $attributeNames = array(
            'car_company'              => $request->car_company
        );

        $validator = Validator::make($attributeNames, [
            'car_company'                  => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            DB::beginTransaction();
            try {

                $item =  new CarModel;
                $item->car_company           = $request->car_company;
                $item->created_by            = $userName;
                $item->updated_by            = $userName;
                $item->soft_delete           = $defaultStatus;
                $item->save();

                DB::commit();
                return response()->json("Success");
            } catch (\Exception $exception) {
                DB::rollback();
                return response()->json(array('dbErrors' => $exception->getMessage()));
            }
        }
    }


    public function allCompaniesView()
    {
        $cars         = CarModel::where('soft_delete', 0)->get();

        $data = [
            'cars'    => $cars,
        ];
        return view('admin.car.allCompaniesView', $data);
    }

    public function getCompanies()
    {
        $cars = CarModel::where('soft_delete', 0)->get();
        return response()->json($cars, 200);
    }


    public function getCompanyInfoAjax(Request $request)
    {
        $companyInfo = CarModel::findOrFail($request->id);
        return response()->json($companyInfo);
    }


    public function companyUpdateAjax(Request $request)
    {

        $companyInfo        = CarModel::findOrFail($request->company_id);
        $userName           = Auth::user()->first_name;
        $defaultStatus      = 0;

        $attributeNames = array(
            'car_company'           => $request->car_company,
            'updated_by'            => $userName,
            'soft_delete'           => $defaultStatus
        );


        $validator = Validator::make($attributeNames, [
            'car_company'           => 'required',
            'updated_by'            => 'required',
            'soft_delete'           => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            $companyInfo->car_company           = $request->car_company;
            $companyInfo->updated_by            = $userName;
            $companyInfo->soft_delete           = $defaultStatus;
            $companyInfo->update();

            return response()->json("Success");
        }
    }


    public function companyDeleteAjax(Request $request)
    {
        $id = $request->id;
        $company = CarModel::findOrFail($id);
        $attributeNames = array(
            'soft_delete' => 1
        );

        try {
            $company->update($attributeNames);
            return response()->json("Deleted!");
        } catch (\Exception $exception) {
            return response()->json(array('errors' => $exception->getMessage()));
        }
    }
}
