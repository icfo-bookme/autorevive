<?php

namespace App\Http\Controllers\vendor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\vendor\VendorModel;
use App\purchase\PurchaseModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Purchase;

class vendorController extends Controller
{

     /**
     * @name allVendorView
     * @role All vendor list view
     * @param
     * @return view with compact array
     *
     */
    public function allVendorView(){
        $vendors = VendorModel::where('soft_delete', 0)->get();

        $data = [
            'vendors' => $vendors
        ];

         return view('admin.vendor.allVendorView',$data);

    }




     /**
     * @name vendorInsertAjax
     * @role insert vendor info into  database
     * @param Request from array
     * @return json response
     *
     */

    public function vendorInsertAjax(Request $request)
    {
        $userName = Auth::user()->first_name;
        $defaultStatus = 0;
        //gettings attributes
        $attributeNames = array(
            'name'              => $request->name,
            'address'           => $request->address,
            'contact_person'    => $request->contact_person,
            'phone_number'      => $request->phone_number,
            'created_by'        => $userName,
            'updated_by'        => $userName,
            'status'            => $defaultStatus,
            'soft_delete'       => $defaultStatus

        );



        //return dd($attributeNames);

        //validating the attributes
        $validator = Validator::make($attributeNames, [
            'name'                  => 'required',
            'address'               => 'required',
            'contact_person'        => 'required',
            'phone_number'          => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }else {

            VendorModel::create($attributeNames);
            return response()->json("Success");
        }
    }





     /**
     * @name getVendorDetails
     * @role get vendor details from  database
     * @param Request from array
     * @return json response
     *
     */


    public function getVendorDetails(Request $request)
    {
        $id = $request->id;

        $vendor = vendorModel::findOrFail($id);

        return response()->json($vendor);
    }






    /**
     * @name vendorUpdateAjax
     * @role update vendor details into  database
     * @param Request from array
     * @return json response
     *
     */
    public function vendorUpdateAjax(Request $request)
    {
        $id = $request->id;
        $vendor = VendorModel::findOrFail($id);

        $attributeNames = array(
            'name'              => $request->name,
            'address'           => $request->address,
            'contact_person'    => $request->contact_person,
            'phone_number'      => $request->phone_number,
        );

        $validator = Validator::make($attributeNames, [
            'name'                  => 'required',
            'address'               => 'required',
            'contact_person'        => 'required',
            'phone_number'          => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {

            $vendor->update($attributeNames);

            return response()->json("Success");
        }
    }









    /**
     * @name vendorDeleteAjax
     * @role delete vendor  from  database
     * @param Request from array
     * @return json response
     *
     */
    public function vendorDeleteAjax(Request $request)
    {
        $id = $request->id;
        $vendor = VendorModel::findOrFail($id);

        $purchaseUnderVendor = PurchaseModel::where('vendor_id',$id)->get();
        $deletedAttribute = 1;
        $attributeNames = array(
            'soft_delete' => $deletedAttribute
        );

        try {
            //Note: Vendor name is default
            $defaultVendorDetails = VendorModel::where('name','default')->first();
            foreach ($purchaseUnderVendor as $purchase) {
                $purchase->update([
                    'vendor_id' => $defaultVendorDetails['id'],
                    'old_vendor_id' => $purchase->vendor_id
                ]);
            }

            $vendor->update($attributeNames);
            return response()->json("Deleted!");
        } catch (\Exception $exception) {
            return response()->json(array('errors' => $exception->getMessage()));
        }
    }






}



