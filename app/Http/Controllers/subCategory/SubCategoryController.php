<?php

namespace App\Http\Controllers\subCategory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\category\CategoryModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\subCategory\SubCategoryModel;

class SubCategoryController extends Controller
{
       /**
     * @name allCategoryView
     * @role All category list view
     * @param 
     * @return view with compact array
     *
     */
    public function allSubCategoryView(){
        $categories = CategoryModel::where('soft_delete', 0)->get();
        $subCategories = SubCategoryModel::where('soft_delete', 0)->get();

        $data = [
            'subCategories' => $subCategories,
            'categories'    => $categories
        ];

         return view('admin.subCategory.allSubCategoryView',$data);

    }




    /**
     * @name subCategoryInsertAjax
     * @role insert subcategory info into  database
     * @param Request from array
     * @return json response
     *
     */

    public function subCategoryInsertAjax(Request $request)
    {
        $userName = Auth::user()->first_name;
        $defaultStatus = 0;
        //gettings attributes
        $attributeNames = array(
            'category_id'       => $request->category_id,  
            'name'              => $request->name,
            'created_by'        => $userName,
            'updated_by'        => $userName,
            'soft_delete'       => $defaultStatus

        );



        //return dd($attributeNames);

        //validating the attributes
        $validator = Validator::make($attributeNames, [
            'category_id'           => 'required',
            'name'                  => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }else {
            SubCategoryModel::create($attributeNames);
            return response()->json("Success");
        }
    }







    
     /**
     * @name getSubCategoryDetails
     * @role get sub-category details from  database
     * @param Request from array
     * @return json response
     *
     */


    public function getSubCategoryDetails(Request $request)
    {
        $id = $request->id;
        $subCategory = SubCategoryModel::findOrFail($id);
        return response()->json($subCategory);
    }







     /**
     * @name subCategoryUpdateAjax
     * @role update subcategory details into  database
     * @param Request from array
     * @return json response
     *
     */
    public function subCategoryUpdateAjax(Request $request)
    {
        $id = $request->id;
        $subCategory = SubCategoryModel::findOrFail($id);

        $attributeNames = array(
            'category_id'       => $request->category_id,  
            'name'              => $request->name
        );

        $validator = Validator::make($attributeNames, [
            'category_id'           => 'required',
            'name'                  => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            $subCategory->update($attributeNames);
            return response()->json("Success");
        }
    }


    


    /**
     * @name subCategoryDeleteAjax
     * @role delete sub-category  from  database
     * @param Request from array
     * @return json response
     *
     */
    public function subCategoryDeleteAjax(Request $request)
    {
        $id = $request->id;
        $subCategory = SubCategoryModel::findOrFail($id);
        $deletedAttribute = 1;
        $attributeNames = array(
            'soft_delete' => $deletedAttribute
        );

        try {
            $subCategory->update($attributeNames);
            return response()->json("Deleted!");
        } catch (\Exception $exception) {
            return response()->json(array('errors' => $exception->getMessage()));
        }
    }
}
