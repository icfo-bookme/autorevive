<?php

namespace App\Http\Controllers\brand;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Brand\BrandModel;

class BrandController extends Controller
{
    //git
     /**
     * @name allBrandView
     * @role All brand list view
     * @param 
     * @return view with compact array
     *
     */
    public function allBrandView(){
        $brands = BrandModel::where('soft_delete', 0)->get();

        $data = [
            'brands' => $brands
        ];

         return view('admin.brand.allBrandView',$data);

    }








    /**
     * @name brandInsertAjax
     * @role insert brand info into  database
     * @param Request from array
     * @return json response
     *
     */

    public function brandInsertAjax(Request $request)
    {
        $userName = Auth::user()->first_name;
        $defaultStatus = 0;
        //gettings attributes
        $attributeNames = array(
            'name'              => $request->name,
            'created_by'        => $userName,
            'updated_by'        => $userName,
            'soft_delete'       => $defaultStatus

        );



        //return dd($attributeNames);

        //validating the attributes
        $validator = Validator::make($attributeNames, [
            'name'                  => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }else {
            BrandModel::create($attributeNames);
            return response()->json("Success");
        }
    }






    
     /**
     * @name getBrandDetails
     * @role get brand details from  database
     * @param Request from array
     * @return json response
     *
     */


    public function getBrandDetails(Request $request)
    {
        $id = $request->id;
        $category = BrandModel::findOrFail($id);
        return response()->json($category);
    }












    /**
     * @name brandUpdateAjax
     * @role update brand details into  database
     * @param Request from array
     * @return json response
     *
     */
    public function brandUpdateAjax(Request $request)
    {
        $id = $request->id;
        $brand = BrandModel::findOrFail($id);

        $attributeNames = array(
            'name'              => $request->name,
        );

        $validator = Validator::make($attributeNames, [
            'name'                  => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            $brand->update($attributeNames);
            return response()->json("Success");
        }
    }





    
    /**
     * @name brandDeleteAjax
     * @role delete brand  from  database
     * @param Request from array
     * @return json response
     *
     */
    public function brandDeleteAjax(Request $request)
    {
        $id = $request->id;
        $brand = BrandModel::findOrFail($id);
        $deletedAttribute = 1;
        $attributeNames = array(
            'soft_delete' => $deletedAttribute
        );

        try {
            $brand->update($attributeNames);
            return response()->json("Deleted!");
        } catch (\Exception $exception) {
            return response()->json(array('errors' => $exception->getMessage()));
        }


    }







}
