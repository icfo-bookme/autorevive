<?php

namespace App\Http\Controllers\category;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\category\CategoryModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
     /**
     * @name allCategoryView
     * @role All category list view
     * @param
     * @return view with compact array
     *
     */
    public function allCategoryView(){
        $categories = CategoryModel::where('soft_delete', 0)->orderBy('priority', 'ASC')->orderBy('id', 'ASC')->get();

        $data = [
            'categories' => $categories
        ];

         return view('admin.category.allCategoryView',$data);

    }






    /**
     * @name categoryInsertAjax
     * @role insert category info into  database
     * @param Request from array
     * @return json response
     *
     */

    public function categoryInsertAjax(Request $request)
    {
        $userName = auth()->user()->first_name;
        $defaultStatus = 0;

        //gettings attributes
        $attributeNames = array(
            'name'              => $request->name,
            'created_by'        => $userName,
            'updated_by'        => $userName,
            'soft_delete'       => $defaultStatus
        );

        //validating the attributes
        $validator = Validator::make($attributeNames, [
            'name'                  => 'required|unique:category',
        ]);

        if ($validator->fails()) {

            return response()->json([
                'data' => $validator->getMessageBag()->toArray(),
                'status' => "validation-error",
                'message' => "Category creation failed"
            ]);
        }else {
            $response = CategoryModel::create($attributeNames);

            if($response){

                return response()->json([
                   'data' => null,
                   'status' => true,
                   'message' => "Category created successfully"
                ]);
            }

            return response()->json([
                'data' => null,
                'status' => false,
                'message' => "Category creation failed! Please try again"
            ]);
        }
    }






     /**
     * @name getCategoryDetails
     * @role get category details from  database
     * @param Request from array
     * @return json response
     *
     */


    public function getCategoryDetails(Request $request)
    {
        $id = $request->id;
        $category = CategoryModel::findOrFail($id);
        return response()->json($category);
    }






     /**
     * @name categoryUpdateAjax
     * @role update category details into  database
     * @param Request from array
     * @return json response
     *
     */
    public function categoryUpdateAjax(Request $request)
    {
        $id = $request->id;
        $category = CategoryModel::findOrFail($id);

        $attributeNames = array(
            'name'              => $request->name,

        );

        $validator = Validator::make($attributeNames, [
            'name'                  => 'required|unique:category,name,'.$id,
        ]);

        if ($validator->fails()) {

            return response()->json([
                'data' => $validator->getMessageBag()->toArray(),
                'status' => "validation-error",
                'message' => "Category creation failed"
            ]);
        } else {
            $response = $category->update($attributeNames);

            if($response){
                return response()->json([
                    'data' => null,
                    'status' => true,
                    'message' => "Category updated successfully"
                ]);
            }

            return response()->json([
                'data' => null,
                'status' => false,
                'message' => "Category updating failed! Please try again!"
            ]);
        }
    }


    public function priorityUpdateAjax(Request $request)
    {
        $id = $request->id;
        $category = CategoryModel::findOrFail($id);

        $attributeNames = array(
            'priority'          => $request->priority
        );

        $validator = Validator::make($attributeNames, [
            'priority'                  => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            $category->update($attributeNames);
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
    public function categoryDeleteAjax(Request $request)
    {
        $id = $request->id;
        $category = categoryModel::findOrFail($id);
        $deletedAttribute = 1;
        $attributeNames = array(
            'soft_delete' => $deletedAttribute
        );

        try {
            $category->update($attributeNames);
            return response()->json("Deleted!");
        } catch (\Exception $exception) {
            return response()->json(array('errors' => $exception->getMessage()));
        }
    }






}
