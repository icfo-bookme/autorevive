<?php

namespace App\Http\Controllers\costInsert;
use App\CostInsert\CostInsert;
use App\CostInsert\CostSubCategory;
use App\CostInsert\CostCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class CostSubCategoryController extends Controller
{
    /**
     * Returns blade for category view
     */
    public function costSubCategoryView()
    {
        $categories = CostCategory::where('soft_delete', SOFT_DELETE_NO)->get();

        $data = [
            'categories' => $categories
        ];
        return view('admin.costinsert.costSubCategoryView', $data);
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     * Returns all cost categories data for datatable display
     */
    public function listAllCostSubCategories(Request $request)
    {
        $costSubCategoryData = CostSubCategory::with(['category'])->where(['soft_delete' => SOFT_DELETE_NO])->orderBy('updated_at', 'desc');

        return Datatables::of($costSubCategoryData)
            ->addColumn('action', function ($data) {
                return '<button class="btn btn-primary btn-xs" title="Edit" onclick="costSubCategoryEdit('.$data->id.')">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                            <button class="btn btn-danger btn-xs" title="Delete"
                                                onclick="costSubCategoryDelete('.$data->id.')">
                                               <i class="fa fa-trash"></i></button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * Cost Sub-category insert
     */
    public function costSubCategoryInsert(Request $request)
    {
        try {
            $categoryId = $request->category_id;
            $attributeNames = array(
                'name' => $request->name,
                'category_id' => $categoryId
            );

            //validating the attributes
            $validator = Validator::make($attributeNames, [
                'category_id' => 'required',
                'name' => [
                    'required',
                    'name' => Rule::unique('cost_sub_categories')->where(function ($query) use ($categoryId) {
                        return $query->where('category_id', $categoryId)->where('soft_delete',SOFT_DELETE_NO);
                    }),
                ]
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'data' => $validator->getMessageBag()->toArray(),
                    'status' => "validation-error",
                    'message' => "Sub Category creation failed!"
                ]);
            }

            //Inserting data
            $response = CostSubCategory::create([
                'category_id' => $request->category_id,
                'name'       => $request->name,
                'created_by' => auth()->user()->first_name,
                'updated_by' => auth()->user()->first_name,
                'soft_delete'=> SOFT_DELETE_NO

            ]);

            if ($response) {
                return response()->json([
                    'data' => $response,
                    'status' => true,
                    'message' => 'Sub Catgeory created succesfully'
                ]);
            }

            return response()->json([
                'data' => $response,
                'status' => false,
                'message' => 'SubCatgeory creation failed! Please try again'
            ]);

        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json([
                'data' => $exception->getMessage(),
                'status' => false,
                'message' => 'Something went wrong! Please try again'
            ]);
        }
    }

    /**
     *Display edit form
     */
    public function getCostSubCategoryEditForm(Request $request)
    {
        try{
            $categories = CostCategory::where('soft_delete',SOFT_DELETE_NO)->get();
            $subCategoryData = CostSubCategory::where('id',$request->get('id'))->first();

            if($subCategoryData){
                return response()->json([
                    'data' => view('admin.costinsert.costSubCategoryEditForm')->with([
                        'subCategoryData' => $subCategoryData,
                        'categories' => $categories,
                    ])->render(),
                    'status' => true,
                    'message' => 'successful'
                ]);
            }

            return response()->json([
                'data' => $subCategoryData,
                'status' => false,
                'message' => 'Form fetch failed! Please try again'
            ]);
        } catch(Exception $exception){
            Log::error($exception->getMessage());

            return response()->json([
                'data' => $exception->getMessage(),
                'status' => false,
                'message' => 'Something went wrong! Please try again'
            ]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * Sub Category is updated here
     */
    public function costSubCategoryUpdate(Request $request)
    {
        try{
            $subcategoryId = $request->subcategory_id;
            $categoryId = $request->category_id;
            //gettings attributes
            $attributeNames = array(
                'subcategory_id' => $subcategoryId,
                'category_id' => $categoryId,
                'name' => $request->name,
            );

            //validating the attributes
            $validator = Validator::make($attributeNames, [
                'name' => [
                    'required',
                    'name' => Rule::unique('cost_sub_categories')->ignore($subcategoryId)->where(function ($query) use ($categoryId) {
                        return $query->where('category_id', $categoryId)->where('soft_delete',SOFT_DELETE_NO);
                    }),
                ]
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'data' => $validator->getMessageBag()->toArray(),
                    'status' => "validation-error",
                    'message' => "Category update failed"
                ]);
            }

            $response = CostSubCategory::where('id',$request->subcategory_id)->update([
                'name' => $request->name,
                'category_id' => $request->category_id,
                'updated_by' => auth()->user()->first_name
            ]);

            if($response){
                return response()->json([
                    'data' => $response,
                    'status' => true,
                    'message' => 'Sub Category updated successfully'
                ]);
            }
            return response()->json([
                'data' => $response,
                'status' => false,
                'message' => 'Sub Category update failed! Please try again'
            ]);
        }catch (Exception $exception){
            Log::error($exception->getMessage());

            return response()->json([
                'data' => $exception->getMessage(),
                'status' => false,
                'message' => 'Something went wrong! Please try again'
            ]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * Deletes category (Soft delete)
     */
    public function costSubCategoryDelete(Request $request)
    {
        try{
            //Update costs
            CostInsert::where('subcategory_id',$request->id)->update([
                'soft_delete' => SOFT_DELETE_YES
            ]);

            //Update cost sub categories
            $response = CostSubCategory::where('id',$request->id)->update([
            'soft_delete' => SOFT_DELETE_YES
            ]);

            if($response){
                return response()->json([
                    'status' => true,
                    'message' => 'Category successfully removed',
                    'data' => $response
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'Category removing failed! Please try again',
                'data' => null
            ]);
        }catch (Exception $exception){
            Log::error($exception->getMessage());

            return response()->json([
                'data' => $exception->getMessage(),
                'status' => false,
                'message' => 'Something went wrong! Please try again'
            ]);
        }
    }
}
