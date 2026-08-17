<?php

namespace App\Http\Controllers\costInsert;

use App\CostInsert\CostCategory;
use App\CostInsert\CostInsert;
use App\CostInsert\CostSubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class CostCategoryController extends Controller
{
    /**
     * Returns blade for category view
     */
    public function costCategoryView()
    {
        return view('admin.costinsert.costCategoryView');
    }

    public function costCategoryViewInactive()
    {
        return view('admin.costinsert.costCategoryViewInactive');
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     * Returns all cost categories data for datatable display
     */
    public function listAllCostCategories(Request $request)
    {
        $costCategoryData = CostCategory::where(['soft_delete' => SOFT_DELETE_NO])->orderBy('updated_at', 'desc');

        return Datatables::of($costCategoryData)
            ->addColumn('action', function ($data) {
                return '<button class="btn btn-primary btn-xs" title="Edit" onclick="costCategoryEdit(' . $data->id . ')">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                            <button class="btn btn-danger btn-xs" title="Inactive"
                                                onclick="costCategoryDelete(' . $data->id . ')">
                                               <i class="fa fa-lock"></i></button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function listAllCostCategoriesInactive(Request $request)
    {
        $costCategoryData = CostCategory::where(['soft_delete' => SOFT_DELETE_YES])->orderBy('updated_at', 'desc');

        return Datatables::of($costCategoryData)
            ->addColumn('action', function ($data) {
                return '
                                            <button class="btn btn-success btn-xs" title="Restore"
                                                onclick="costCategoryRestore(' . $data->id . ')">
                                               <i class="fa fa-undo"></i></button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * Cost category insert
     */
    public function costCategoryInsert(Request $request)
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
                    'name' => Rule::unique('cost_categories')->where(function ($query) {
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
            $response = CostCategory::create([
                'name' => $request->name,
                'created_by' => auth()->user()->first_name,
                'updated_by' => auth()->user()->first_name
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
    public function getCostCategoryEditForm(Request $request)
    {
        try {
            $categoryData = CostCategory::where('id', $request->get('id'))->first();

            if ($categoryData) {
                return response()->json([
                    'data' => view('admin.costinsert.costCategoryEditForm')->with([
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * Category is updated here
     */
    public function costCategoryUpdate(Request $request)
    {
        try {
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
                    'name' => Rule::unique('cost_categories')->ignore($categoryId)->where(function ($query) {
                        return $query->where('soft_delete', SOFT_DELETE_NO);
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

            $response = CostCategory::where('id', $request->category_id)->update([
                'name' => $request->name,
                'updated_by' => auth()->user()->first_name
            ]);

            if ($response) {
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * Deletes category (Soft delete)
     */
    public function costCategoryDelete(Request $request)
    {
        try {
            //Update cost subcategories
            CostSubCategory::where('category_id', $request->id)->update([
                'soft_delete' => SOFT_DELETE_YES
            ]);
            //Update costs
            CostInsert::where('category_id', $request->id)->update([
                'soft_delete' => SOFT_DELETE_YES
            ]);

            $response = CostCategory::where('id', $request->id)->update([
                'soft_delete' => SOFT_DELETE_YES
            ]);

            if ($response) {
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
        } catch (Exception $exception) {
            Log::error($exception->getMessage());

            return response()->json([
                'data' => $exception->getMessage(),
                'status' => false,
                'message' => 'Something went wrong! Please try again'
            ]);
        }
    }

    public function costCategoryRestore(Request $request)
    {
        try {
            //Update cost subcategories
            CostSubCategory::where('category_id', $request->id)->update([
                'soft_delete' => SOFT_DELETE_NO
            ]);
            //Update costs
            CostInsert::where('category_id', $request->id)->update([
                'soft_delete' => SOFT_DELETE_NO
            ]);

            $response = CostCategory::where('id', $request->id)->update([
                'soft_delete' => SOFT_DELETE_NO
            ]);

            if ($response) {
                return response()->json([
                    'status' => true,
                    'message' => 'Category successfully restored',
                    'data' => $response
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'Category restoration failed! Please try again',
                'data' => null
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
}
