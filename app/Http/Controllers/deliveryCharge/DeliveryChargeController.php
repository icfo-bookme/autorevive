<?php

namespace App\Http\Controllers\deliveryCharge;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\deliveryCharge\DeliveryChargeModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class DeliveryChargeController extends Controller
{
     /**
     * @name deliveryChargeView
     * @role All category list view
     * @param 
     * @return view with compact array
     *
     */
    public function deliveryChargeView(){
        $charges = DeliveryChargeModel::where('soft_delete', 0)->get();

        $data = [
            'charges' => $charges
        ];

         return view('admin.deliveryCharge.deliveryChargeView',$data);

    }






    /**
     * @name categoryInsertAjax
     * @role insert category info into  database
     * @param Request from array
     * @return json response
     *
     */

    public function deliveryChargeInsertAjax(Request $request)
    {
        $userName = Auth::user()->first_name;
        $defaultStatus = 0;
        //gettings attributes
        $attributeNames = array(
            'name'                 => $request->name,
            'amount'               => $request->amount,
            'created_by'           => $userName,
            'updated_by'           => $userName,
            'soft_delete'          => $defaultStatus

        );



        //return dd($attributeNames);

        //validating the attributes
        $validator = Validator::make($attributeNames, [
            'name'                    => 'required',
            'amount'                  => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }else {
            DeliveryChargeModel::create($attributeNames);
            return response()->json("Success");
        }
    }





    
     /**
     * @name getCategoryDetails
     * @role get category details from  database
     * @param Request from array
     * @return json response
     *
     */


    public function getChargeDetails(Request $request)
    {
        $id = $request->id;
        $charge = DeliveryChargeModel::findOrFail($id);
        return response()->json($charge);
    }






     /**
     * @name chargeUpdateAjax
     * @role update category details into  database
     * @param Request from array
     * @return json response
     *
     */
    public function chargeUpdateAjax(Request $request)
    {
        $id = $request->id;
        $charge = DeliveryChargeModel::findOrFail($id);

        $attributeNames = array(
            'name'              => $request->name,
            'amount'            => $request->amount,
        );

        $validator = Validator::make($attributeNames, [
            'name'                  => 'required',
            'amount'                => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            $charge->update($attributeNames);
            return response()->json("Success");
        }
    }






     /**
     * @name categoryDeleteAjax
     * @role delete category  from  database
     * @param Request from array
     * @return json response
     *
     */
    public function chargeDeleteAjax(Request $request)
    {
        $id = $request->id;
        $charge = DeliveryChargeModel::findOrFail($id);
        $deletedAttribute = 1;
        $attributeNames = array(
            'soft_delete' => $deletedAttribute
        );

        try {
            $charge->update($attributeNames);
            return response()->json("Deleted!");
        } catch (\Exception $exception) {
            return response()->json(array('errors' => $exception->getMessage()));
        }
    }






}
