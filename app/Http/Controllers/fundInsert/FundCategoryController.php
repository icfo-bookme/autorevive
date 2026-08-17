<?php

namespace App\Http\Controllers\fundInsert;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\FundInsert\FundCategory;
use App\FundInsert\FundInsert;
use App\FundInsert\FundSubCategory;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class FundCategoryController extends Controller
{
    /**
     * Returns blade for category view
     */
    public function fundCategoryView()
    {
        return view('admin.fundInsert.fundCategoryView');
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     * Returns all fund categories data for datatable display
     */
    public function listAllFundCategories(Request $request)
    {
        $fundCategoryData = FundCategory::where(['soft_delete' => SOFT_DELETE_NO])->orderBy('updated_at', 'desc');

        return Datatables::of($fundCategoryData)

            ->addColumn('data_created_by', function ($data) {
                return $data->createdBy->first_name;
            })
            ->addColumn('data_updated_by', function ($data) {
                return $data->updatedBy->first_name;
            })
            ->addColumn('action', function ($data) {
                return '<button class="btn btn-primary btn-xs" title="Edit" onclick="fundCategoryEdit('.$data->id.')">
                            <i class="fa fa-pencil"></i>
                        </button>
                        <button class="btn btn-danger btn-xs" title="Delete" onclick="fundCategoryDelete('.$data->id.')">
                            <i class="fa fa-trash"></i>
                        </button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * Fund category insert
     */
    public function fundCategoryInsert(Request $request)
    {
        try {
            //gettings attributes
            $attributeNames = array(
                'name' => $request->name
            );
            //validating the attributes
            $validator = Validator::make($attributeNames, [
                'name' => [
                    'required',
                    'name' => Rule::unique('fund_categories')->where(function ($query){
                        return $query->where('soft_delete', SOFT_DELETE_NO);
                    }),
                ]
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'data' => $validator->getMessageBag()->toArray(),
                    'status' => "validation-error",
                    'message' => "Category creation failed"
                ]);
            }

            //Inserting data
            $response = FundCategory::create([
                'name' => $request->name,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id
            ]);
            if ($response) {
                return response()->json([
                    'data' => $response,
                    'status' => true,
                    'message' => 'Catgeory created succesfully'
                ]);
            }

            return response()->json([
                'data' => $response,
                'status' => false,
                'message' => 'Catgeory creation failed! Please try again'
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
    public function getFundCategoryEditForm(Request $request)
    {
        try{
            $categoryData = FundCategory::where('id',$request->get('id'))->first();

            if($categoryData){
                return response()->json([
                    'data' => view('admin.fundInsert.fundCategoryEditForm')->with([
                        'categoryData' => $categoryData,
                    ])->render(),
                    'status' => true,
                    'message' => 'successfully'
                ]);
            }

            return response()->json([
                'data' => $categoryData,
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
     * Category is updated here
     */
    public function fundCategoryUpdate(Request $request)
    {
        try{
            //gettings attributes
            $categoryId = $request->category_id;

            $attributeNames = array(
                'category_id' => $categoryId,
                'name' => $request->name,
            );

            //validating the attributes
            $validator = Validator::make($attributeNames, [
                'name' => [
                    'required',
                    'name' => Rule::unique('fund_categories')->ignore($categoryId)->where(function ($query) {
                        return $query->where('soft_delete',SOFT_DELETE_NO);
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

            $response = FundCategory::where('id',$request->category_id)->update([
                'name' => $request->name,
                'updated_by' => auth()->user()->id
            ]);

            if($response){
                return response()->json([
                    'data' => $response,
                    'status' => true,
                    'message' => 'Category updated successfully'
                ]);
            }
            return response()->json([
                'data' => $response,
                'status' => false,
                'message' => 'Category update failed! Please try again'
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
    public function fundCategoryDelete(Request $request)
    {
        try{
            //Update fund subcategories
            FundSubCategory::where('category_id',$request->id)->update([
                'soft_delete' => SOFT_DELETE_YES
            ]);
            //Update funds
            FundInsert::where('category_id',$request->id)->update([
                'soft_delete' => SOFT_DELETE_YES
            ]);

            $response = FundCategory::where('id',$request->id)->update([
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
